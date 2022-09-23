<?php

/**
 * Mega Filter
 * 
 * @author info@ocdemo.eu <info@ocdemo.eu> 
 */
class ModelModuleMegaFilter extends Model {
	
	private $_hasFilters = NULL;
	
	public function hasFilters() {
		if( $this->_hasFilters === NULL ) {
			$this->_hasFilters = version_compare( VERSION, '1.5.5', '>=' );
		}
		
		return $this->_hasFilters;
	}
	
	public function uninstall() {
		$this->db->query("
			DELETE FROM
				`" . DB_PREFIX . "setting`
			WHERE
				`key` IN('mega_filter_module','mega_filter_status','mfilter_version','mfilter_latest_ver','mfilter_license','mega_filter_attribs','mega_filter_settings', 'mega_filter_seo','mega_filter_filters','mega_filter_options','mfilter_plus_version','mfilter_mijoshop') OR
				`key` REGEXP '^mega_filter_at_img_[0-9]+_[0-9]+$' OR 
				`key` REGEXP '^mega_filter_fi_img_[0-9]+_[0-9]+$' OR 
				`key` REGEXP '^mega_filter_at_sort_[0-9]+_[0-9]+$'
		");
			
		$this->removeColumn( 'attribute_description', 'mf_tooltip' );
		$this->removeColumn( 'option_description', 'mf_tooltip' );
		$this->removeColumn( 'filter_group_description', 'mf_tooltip' );
			
		// @since 2.0.3.2
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "mfilter_url_alias`");
		
		// @since 2.0.4.5.2
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "mfilter_settings`");
	}
	
	/**
	 * Add column to table
	 * 
	 * @param string $table
	 * @param string $column
	 * @param string $type
	 * @return boolean 
	 */
	public function addColumn( $table, $column, $type ) {		
		$query = $this->db->query('SHOW COLUMNS FROM `' . DB_PREFIX . $table . '` LIKE "' . $column . '"');
		
		if( ! $query->num_rows ) {
			$this->db->query( 'ALTER TABLE `' . DB_PREFIX . $table . '` ADD `' . $column . '` ' . $type );
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * Remove column from table
	 * 
	 * @param string $table
	 * @param string $column
	 * @return bool 
	 */
	public function removeColumn( $table, $column ) {		
		$query = $this->db->query('SHOW COLUMNS FROM `' . DB_PREFIX . $table . '` LIKE "' . $column . '"');
		
		if( $query->num_rows ) {
			$this->db->query('ALTER TABLE `' . DB_PREFIX . $table . '` DROP `' . $column . '`');
			
			return true;
		}
		
		return false;
	}
	
	public function updateDB( $install = false ) {
		if( $install || version_compare( $this->config->get( 'mfilter_version' ), '2.0.4.4.5.2', '<' ) ) {
			$this->addColumn( 'attribute_description', 'mf_tooltip', 'TEXT NULL' );
			$this->addColumn( 'option_description', 'mf_tooltip', 'TEXT NULL' );
			$this->addColumn( 'filter_group_description', 'mf_tooltip', 'TEXT NULL' );
		}
		
		if( $install || version_compare( $this->config->get( 'mfilter_version' ), '2.0.4.5.2', '<' ) ) {
			$this->createSettingsTable();
		}
		
		if( $install || version_compare( $this->config->get( 'mfilter_version' ), '2.0.3.2', '<' ) ) {
			$this->model_module_mega_filter->createUrlAliasTable();
		}
		
		if( version_compare( $this->config->get( 'mfilter_version' ), '2.0.4.6', '<' ) ) {
			$this->addColumn( 'mfilter_url_alias', 'meta_title', 'VARCHAR(255) NULL' );
			$this->addColumn( 'mfilter_url_alias', 'meta_description', 'VARCHAR(255) NULL' );
			$this->addColumn( 'mfilter_url_alias', 'meta_keyword', 'VARCHAR(255) NULL' );
		}
		
		if( version_compare( $this->config->get( 'mfilter_version' ), '2.0.4.7', '<' ) ) {
			$this->addColumn( 'mfilter_url_alias', 'description', 'TEXT NULL' );
			$this->addColumn( 'mfilter_url_alias', 'h1', 'VARCHAR(255) NULL' );
		}
	}
	
	protected function optionsConditions( $data, $prefix = ' AND ' ) {
		/* @var $conditions array */
		$conditions = array();
		
		if (!empty($data['filter_name'])) {
			$conditions[] = "`od`.`name` LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if( ! empty( $data['except_ids'] ) ) {
			$conditions[] = "`o`.`option_id` NOT IN(" . implode( ',', $data['except_ids'] ) . ")";
		}
		
		if( ! empty( $data['only_ids'] ) ) {
			$conditions[] = "`o`.`option_id` IN(" . implode( ',', $data['only_ids'] ) . ")";
		}
		
		return $conditions ? $prefix . implode( ' AND ', $conditions ) : '';
	}
	
	protected function sqlOptions( $data, $select = '*' ) {
		$sql = "
			SELECT 
				" . $select . "
			FROM 
				`" . DB_PREFIX . "option` AS `o` 
			LEFT JOIN 
				`" . DB_PREFIX . "option_description` AS `od` 
			ON 
				`o`.`option_id` = `od`.`option_id` 
			WHERE 
				`od`.`language_id` = '" . (int)$this->config->get('config_language_id') . "' AND
				`o`.`type` IN( 'select', 'radio', 'checkbox', 'image' )
		";
		
		$sql .= $this->optionsConditions( $data );
		
		return $sql;
	}
	
	protected function sqlLimit( $data ) {
		$sql = '';
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
		return $sql;
	}

	public function getTotalOptions( $data = array() ) {		
		$query = $this->db->query( $this->sqlOptions( $data, 'COUNT(*) AS `total`' ) );

		return $query->row['total'];
	}
	
	public function getOptions( $data = array() ) {
		$sql = $this->sqlOptions( $data );

		$sql .= " ORDER BY `od`.`name` ASC";
		$sql .= $this->sqlLimit( $data );

		$query = $this->db->query($sql);
		
		/* @var $options array */
		$options = array();
		
		foreach( $query->rows as $row ) {
			$options[$row['option_id']] = $row;
		}
		
		return $options;
	}
	
	public function getFiltersValues( $filter_id, $lang_id ) {
		$sql = "
			SELECT
				`fd`.`name`,
				`f`.`filter_id`
			FROM
				`" . DB_PREFIX . "filter_description` AS `fd`
			INNER JOIN
				`" . DB_PREFIX . "filter` AS `f`
			ON
				`fd`.`filter_id` = `f`.`filter_id`
			WHERE
				`f`.`filter_group_id` = " . (int) $filter_id . " AND
				`fd`.`language_id` = '" . (int)$lang_id . "'
			ORDER BY
				`fd`.`name`
		";
			
		return $this->db->query( $sql )->rows;
	}
	
	public function getAttribsValues( $attribute_id, $lang_id ) {
		$sql = "
			SELECT
				REPLACE(REPLACE(TRIM(`pa`.`text`), '\r', ''), '\n', '') AS `text`,
				`pa`.`attribute_id`
			FROM
				`" . DB_PREFIX . "product_attribute` AS `pa`
			INNER JOIN
				`" . DB_PREFIX . "product` AS `p`
			ON
				`pa`.`product_id` = `p`.`product_id` AND `p`.`status` = '1'
			WHERE
				`pa`.`attribute_id` = " . (int) $attribute_id . " AND
				`pa`.`language_id` = '" . (int)$lang_id . "'
			GROUP BY
				`text`, `pa`.`attribute_id`
		";
		
		return $this->db->query( $sql )->rows;
	}
	
	protected function filtersConditions( $data, $prefix = ' AND ' ) {
		/* @var $conditions array */
		$conditions = array();
		
		if (!empty($data['filter_name'])) {
			$conditions[] = "`fgd`.`name` LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if( ! empty( $data['except_ids'] ) ) {
			$conditions[] = "`fg`.`filter_group_id` NOT IN(" . implode( ',', $data['except_ids'] ) . ")";
		}
		
		if( ! empty( $data['only_ids'] ) ) {
			$conditions[] = "`fg`.`filter_group_id` IN(" . implode( ',', $data['only_ids'] ) . ")";
		}
		
		return $conditions ? $prefix . implode( ' AND ', $conditions ) : '';
	}
	
	protected function sqlFilters( $data, $select = '*' ) {
		$sql = "
			SELECT 
				" . $select . "
			FROM 
				`" . DB_PREFIX . "filter_group` AS `fg` 
			INNER JOIN 
				`" . DB_PREFIX . "filter_group_description` AS `fgd` 
			ON 
				`fg`.`filter_group_id` = `fgd`.`filter_group_id` AND `fgd`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'
		";
		
		$sql .= $this->filtersConditions( $data );
		
		return $sql;
	}
	
	public function getFilters( $data = array() ) {
		$items = array();
		$sql = $this->sqlFilters( $data ) . $this->sqlLimit( $data );
		
		foreach( $this->db->query( $sql )->rows as $filter ) {
			$items[$filter['filter_group_id']] = $filter;
		}
		
		return $items;
	}
	
	public function getTotalFilters( $data = array() ) {
		$sql = $this->sqlFilters( $data, 'COUNT(*) AS `c`' );
		
		return $this->db->query( $sql )->row['c'];
	}
	
	public function getAttributesIds() {
		$ids = array();
		
		foreach( $this->getAttributes(array()) as $attribute ) {
			$ids[$attribute['attribute_id']] = $attribute['attribute_id'];
		}
		
		return $ids;
	}
	
	protected function attributesConditions( $data, $prefix = ' AND ' ) {
		/* @var $conditions array */
		$conditions = array();
		
		if (!empty($data['filter_name'])) {
			$conditions[] = "ad.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_attribute_group_id'])) {
			$conditions[] = "a.attribute_group_id = '" . $this->db->escape($data['filter_attribute_group_id']) . "'";
		}
		
		if( ! empty( $data['except_ids'] ) ) {
			$conditions[] = "a.attribute_id NOT IN(" . implode( ',', $data['except_ids'] ) . ")";
		}
		
		if( ! empty( $data['only_ids'] ) ) {
			$conditions[] = "a.attribute_id IN(" . implode( ',', $data['only_ids'] ) . ")";
		}
		
		return $conditions ? $prefix . implode( ' AND ', $conditions ) : '';
	}
	
	protected function attributesGroupConditions( $data, $prefix = ' AND ' ) {
		/* @var $conditions array */
		$conditions = array();
		
		if (!empty($data['filter_name'])) {
			$conditions[] = "agd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_attribute_group_id'])) {
			$conditions[] = "ag.attribute_group_id = '" . $this->db->escape($data['filter_attribute_group_id']) . "'";
		}
		
		if( ! empty( $data['except_ids'] ) ) {
			$conditions[] = "ag.attribute_group_id NOT IN(" . implode( ',', $data['except_ids'] ) . ")";
		}
		
		if( ! empty( $data['only_ids'] ) ) {
			$conditions[] = "ag.attribute_group_id IN(" . implode( ',', $data['only_ids'] ) . ")";
		}
		
		return $conditions ? $prefix . implode( ' AND ', $conditions ) : '';
	}

	public function getTotalAttributes( $data = array() ) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attribute AS a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		$sql .= $this->attributesConditions( $data );
		
		$query = $this->db->query( $sql );

		return $query->row['total'];
	}
	
	public function getAttributes( $data = array() ) {
		$sql = "SELECT *, (SELECT agd.name FROM " . DB_PREFIX . "attribute_group_description agd WHERE agd.attribute_group_id = a.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS attribute_group FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$sql .= $this->attributesConditions( $data );

		$sql .= " ORDER BY attribute_group, ad.name ASC";
		$sql .= $this->sqlLimit( $data );

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalAttributesGroup( $data = array() ) {
		$sql = "
			SELECT
				COUNT(*) AS total
			FROM
				" . DB_PREFIX . "attribute_group AS ag
			INNER JOIN
				" . DB_PREFIX . "attribute_group_description AS agd
			ON
				agd.attribute_group_id = ag.attribute_group_id
			WHERE
				agd.language_id = '" . (int)$this->config->get('config_language_id') . "'
		";
		
		$sql .= $this->attributesGroupConditions( $data );
		
		$query = $this->db->query( $sql );

		return $query->row['total'];
	}
	
	public function getAttributesGroup( $data = array() ) {
		$sql = "
			SELECT
				*
			FROM
				" . DB_PREFIX . "attribute_group AS ag
			INNER JOIN
				" . DB_PREFIX . "attribute_group_description AS agd
			ON
				agd.attribute_group_id = ag.attribute_group_id
			WHERE
				agd.language_id = '" . (int)$this->config->get('config_language_id') . "'
		";
		
		$sql .= $this->attributesGroupConditions( $data );

		$sql .= " ORDER BY agd.name ASC";
		$sql .= $this->sqlLimit( $data );

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getCategoriesByIds( $categories_ids ) {
		return $this->db->query( "
			SELECT 
				`c`.`category_id`, `cd`.`name`,
				" . ( $this->hasFilters() ? "
				(
					SELECT 
						GROUP_CONCAT(`cd1`.`name` ORDER BY `level` SEPARATOR ' &gt; ') 
					FROM 
						`" . DB_PREFIX . "category_path` AS `cp` 
					LEFT JOIN 
						`" . DB_PREFIX . "category_description` AS `cd1` 
					ON 
						`cp`.`path_id` = `cd1`.`category_id` AND `cp`.`category_id` != `cp`.`path_id` 
					WHERE 
						`cp`.`category_id` = `c`.`category_id` AND `cd1`.`language_id` = '" . (int)$this->config->get('config_language_id') . "' 
					GROUP BY 
						`cp`.`category_id`
				) AS `path`" : "CONCAT( '', '' ) AS `path`" ) . "
			FROM 
				`" . DB_PREFIX . "category` AS `c`
			LEFT JOIN
				`" . DB_PREFIX . "category_description` AS `cd`
			ON
				`c`.`category_id` = `cd`.`category_id` AND `cd`.`language_id` = " . $this->config->get( 'config_language_id' ) . "
			WHERE
				`c`.`category_id` IN(" . implode( ',', array_unique( $categories_ids ) ) . ")
		" )->rows;
	}
	
	public function getAllSettings() {
		$settings = array();
		
		foreach( $this->db->query( "SELECT * FROM `" . DB_PREFIX . "mfilter_settings` ORDER BY `idx` ASC" )->rows as $row ) {
			$settings[$row['idx']] = json_decode( $row['settings'], true );
		}
		
		return $settings;
	}
	
	public function getSettings( $idx ) {
		$query = $this->db->query( "SELECT * FROM `" . DB_PREFIX . "mfilter_settings` WHERE `idx` = " . (int) $idx );
		
		if( $query->num_rows ) {
			return json_decode( $query->row['settings'], true );
		}
		
		return array();
	}
	
	public function removeSettings( $idx ) {
		$this->db->query( "DELETE FROM `" . DB_PREFIX . "mfilter_settings` WHERE `idx` = " . (int) $idx );
	}
	
	public function saveSettings( $idx, $settings ) {
		$idx = (int) $idx;
		$settings = $this->db->escape( json_encode( $settings ) );
		
		if( $this->getSettings( $idx ) ) {
			$sql = "
				UPDATE
					`" . DB_PREFIX . "mfilter_settings`
				SET
					`settings` = '" . $settings . "'
				WHERE
					`idx` = " . $idx . "
			";
		} else {
			$sql = "
				INSERT INTO
					`" . DB_PREFIX . "mfilter_settings`
				SET
					`idx` = " . $idx . ",
					`settings` = '" . $settings . "'
			";
		}
		
		return $this->db->query( $sql );
	}
	
	public function createUrlAliasTable() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mfilter_url_alias` (
				`mfilter_url_alias_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`path` TEXT NOT NULL,
				`mfp` TEXT NOT NULL,
				`alias` TEXT NOT NULL,
				`language_id` INT(11) NOT NULL,
				`store_id` INT(11) NOT NULL DEFAULT '0',
				`meta_title` VARCHAR(255) NULL,
				`meta_description` VARCHAR(255) NULL,
				`meta_keyword` VARCHAR(255) NULL,
				`description` TEXT NULL,
				`h1` VARCHAR(255) NULL,
				PRIMARY KEY(`mfilter_url_alias_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1
		");
	}
	
	public function createSettingsTable() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mfilter_settings` (
				`idx` INT(11) UNSIGNED NOT NULL,
				`settings` LONGTEXT NOT NULL,
				UNIQUE KEY(`idx`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
		");
		
		if( $this->config->get('mega_filter_module') ) {
			foreach( $this->config->get('mega_filter_module') as $idx => $settings ) {
				$this->saveSettings( $idx, $settings );
			}
			
			/* @var $value string */
			$value = version_compare( VERSION, '2.1.0.0', '>=' ) ? json_encode( array(), true ) : serialize( array() );
			
			$this->db->query( "UPDATE `" . DB_PREFIX . "setting` SET `value` = '" . $this->db->escape( $value ) . "' WHERE `key` = 'mega_filter_module'" );
		}
	}

	public function changeTypeOfValueFieldInSettingTable() {			
		// Change column 'value' in table 'setting' from 'text' to 'longtext'
		$query = $this->db->query( "
			SELECT 
				* 
			FROM 
				INFORMATION_SCHEMA.COLUMNS 
			WHERE 
				TABLE_SCHEMA LIKE '" . $this->db->escape( DB_DATABASE ) . "' AND
				TABLE_NAME LIKE '" . $this->db->escape( DB_PREFIX . 'setting' ) . "' AND 
				COLUMN_NAME LIKE 'value'
		");
			
		if( $query->num_rows && isset( $query->row['COLUMN_TYPE'] ) && strtolower( $query->row['COLUMN_TYPE'] ) != 'longtext' ) {
			$sql = array();
			$sql[] = 'ALTER TABLE `' . DB_PREFIX . 'setting` CHANGE `value` `value` LONGTEXT';
				
			if( ! empty( $query->row['CHARACTER_SET_NAME'] ) ) {
				$sql[] = 'CHARACTER SET ' . $query->row['CHARACTER_SET_NAME'];
			}
				
			if( ! empty( $query->row['COLLATION_NAME'] ) ) {
				$sql[] = 'COLLATE ' . $query->row['COLLATION_NAME'];
			}
				
			if( ! empty( $query->row['IS_NULLABLE'] ) && strtolower( $query->row['IS_NULLABLE'] ) == 'no' ) {
				$sql[] = 'NOT';
			}
				
			$sql[] = 'NULL';
			
			$this->db->query( implode( ' ', $sql ) );
		}
	}
	
	public function getCategories($data) {
		if( version_compare( VERSION, '1.5.5', '>=' ) ) {
			$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' &gt; ') AS name, c.parent_id, c.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c ON (cp.path_id = c.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (c.category_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			if( ! empty( $data['filter_name'] ) ) {
				$sql .= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
			} 
				
			$sql .= " GROUP BY cp.category_id ORDER BY name";
		} else {
			$sql = "SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
				
			if( ! empty( $data['filter_name'] ) ) {
				$sql .= " AND LOWER(cd.name) LIKE '" . $this->db->escape( function_exists( 'mb_strtolower' ) ? mb_strtolower( $data['filter_name'], 'utf-8' ) : $data['filter_name'] ) . "%'";
			}
				
			$sql .= " GROUP BY c.category_id ORDER BY name";
		}

		$sql .= $this->sqlLimit( $data );
				
		$query = $this->db->query($sql);

		return $query->rows;
	}
}