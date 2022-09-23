<?php

/**
 * Mega Filter
 * 
 * @license Commercial
 * @author info@ocdemo.eu
 */
		
if( class_exists( 'VQMod' ) ) {
	require_once VQMod::modCheck( modification( DIR_SYSTEM . 'library/mfilter_core.php' ) );
	require_once VQMod::modCheck( modification( DIR_SYSTEM . 'library/mfilter_module.php' ) );
} else {
	require_once modification( DIR_SYSTEM . 'library/mfilter_core.php' );
	require_once modification( DIR_SYSTEM . 'library/mfilter_module.php' );
}

class ModelModuleMegaFilter extends Model {	
	
	private static $_tmp_sort_parameters = NULL;
	
	private $_settings = array();
	
	private static $_meta = false;
	
	private static $_cache = array();
	
	////////////////////////////////////////////////////////////////////////////
	
	/**
	 * {__mfp_select__}
	 * {__mfp_join__}
	 * {__mfp_conditions__}
	 * {__mfp_having_conditions__}
	 * {__mfp_group_by__}
	 * {__mfp_order_by__}
	 * {__mfp_limit__}
	 * 
	 * @param string $sql
	 * @param array $data
	 * @param string $type
	 * @return string
	 */	
	public function createQuery( $sql, $data, $type = '' ) {
		foreach( $data as $k => $v ) {
			if( is_array( $v ) ) {
				switch( $k ) {
					case '{__mfp_having_conditions__}' :
					case '{__mfp_conditions__}' : $v = implode( ' AND ', $v ); break;
					case '{__mfp_join__}' : $v = implode( ' ', $v ); break;
					default : $v = implode( ', ', $v );
				}
			}
			
			$sql = str_replace( $k, $v, $sql );
		}
		
		return $sql;
	}
	
	////////////////////////////////////////////////////////////////////////////
	
	public function setSettings( $settings ) {
		$this->_settings = $settings;
	}
	
	public function rewrite( $url = null, $url_data = null ) {
		if( isset( $url_data['mfp'] ) ) {
			if( isset( $url_data['route'] ) && in_array( $url_data['route'], array( 'product/product' ) ) ) {
				return array( $url, $url_data );
			}
			
			$mfilterConfig = $this->config->get( 'mega_filter_seo' );
			
			if( ! empty( $mfilterConfig['enabled'] ) ) {
				preg_match_all( '/([a-z0-9\-_]+)\[([^\]]*)\]/', $url_data['mfp'], $matches );
				
				if( isset( $matches[0] ) && isset( $matches[1] ) && isset( $matches[2] ) ) {
					$mfp = array();
					
					foreach( $matches[0] as $k => $match ) {
						if( ! isset( $matches[1][$k] ) || ! isset( $matches[2][$k] ) || $matches[1][$k] === '' ) {
							continue;
						}

						$key = $matches[1][$k];
						$val = $matches[2][$k];
						
						$mfp[] = $key . ',' . $val;
					}
					
					if( $mfp ) {
						$url .= '/mfp/' . implode( '/', $mfp );
					} else {
						$url .= '/mfp/' . $url_data['mfp'];
					}
					
					unset( $url_data['mfp'] );
				}
			}
		}
		
		return array( $url, $url_data );
	}
	
	public function removeMfpFromUrl( $url ) {
		if( false !== ( $mfpPos = mb_strpos( $url, '?mfp=', 0, 'utf8' ) ) ) {
			$before = $mfpPos ? mb_substr( $url, 0, $mfpPos, 'utf8' ) : '';
			$after	= '';
				
			if( false !== ( $pos = mb_strpos( $url, '&', $mfpPos+1, 'utf8' ) ) ) {
				$after = '?' . mb_substr( $url, $pos+1, NULL, 'utf8' );
			}
				
			$url = $before . $after;
		} else if( false !== ( $mfpPos = mb_strpos( $url, '&mfp=', 0, 'utf8' ) ) ) {
			$before = $mfpPos ? mb_substr( $url, 0, $mfpPos, 'utf8' ) : '';
			$after	= '';
				
			if( false !== ( $pos = mb_strpos( $url, '&', $mfpPos+1, 'utf8' ) ) ) {
				$after = '?' . mb_substr( $url, $pos+1, NULL, 'utf8' );
			}
				
			$url = $before . $after;
		} else if( false !== ( $mfpPos = mb_strpos( $url, 'mfp,', 0, 'utf8' ) ) ) {
			$before = $mfpPos ? mb_substr( $url, 0, $mfpPos, 'utf8' ) : '';
			$after	= '';
				
			if( false !== ( $pos = mb_strpos( $url, '?', $mfpPos+1, 'utf8' ) ) ) {
				$after = mb_substr( $url, $pos, NULL, 'utf8' );
			} else if( false !== ( $pos = mb_strpos( $url, '&', $mfpPos+1, 'utf8' ) ) ) {
				$after = '?' . mb_substr( $url, $pos+1, NULL, 'utf8' );
			} else if( false !== ( $pos = mb_strpos( $url, '/', $mfpPos+1, 'utf8' ) ) ) {
				$after = mb_substr( $url, $mfpPos, $pos, 'utf8' );
			}
				
			$url = $before . $after;
		}
	
		return $url;
	}
	
	public function prepareData( $data ) {
		if( ! empty( $data['breadcrumbs'] ) && ! empty( $this->request->get['mfp'] ) ) {
			foreach( $data['breadcrumbs'] as $mfK => $mfBreadcrumb ) {
				$data['breadcrumbs'][$mfK]['href'] = $this->removeMfpFromUrl( $data['breadcrumbs'][$mfK]['href'] );
			}
		}
		
		if( class_exists( 'ControllerModuleMegaFilter' ) ) {
			if( ControllerModuleMegaFilter::$_meta ) {
				if( ControllerModuleMegaFilter::$_meta['h1'] ) {
					$data['heading_title'] = ControllerModuleMegaFilter::$_meta['h1'];
				}
				if( ControllerModuleMegaFilter::$_meta['description'] ) {
					$data['description'] = html_entity_decode(ControllerModuleMegaFilter::$_meta['description'], ENT_QUOTES, 'UTF-8');
				}
			}
			
			self::$_meta = true;
		}
				
		if( isset( $this->request->get['mfilterAjax'] ) && class_exists( 'MegaFilterCore' ) ) {
			$calculate_number_of_products = false;
			$settings = isset( $this->request->get['mfilterIdx'] ) ? $this->getModuleSettings( $this->request->get['mfilterIdx'] ) : array();

			if( ! empty( $settings['configuration'] ) ) {
				$calculate_number_of_products = ! empty( $settings['configuration']['calculate_number_of_products'] );
			} else {
				$settings = $this->config->get('mega_filter_settings');
				$calculate_number_of_products = ! empty( $settings['calculate_number_of_products'] );
			}

			$seo_settings = $this->config->get('mega_filter_seo');
			$baseTypes	= array( 'stock_status', 'manufacturers', 'rating', 'attributes', 'price', 'options', 'filters' );

			if( isset( $this->request->get['mfilterBTypes'] ) ) {
				$baseTypes = explode( ',', $this->request->get['mfilterBTypes'] );
			}

			if( 
				! empty( $seo_settings['enabled'] ) || 
				$calculate_number_of_products || 
				in_array( 'categories:tree', $baseTypes ) || 
				in_array( 'vehicles', $baseTypes ) ||
				in_array( 'levels', $baseTypes )
			) {
				if( ! $calculate_number_of_products ) {
					$baseTypesCopy = $baseTypes;
					$baseTypes = array();

					if( in_array( 'categories:tree', $baseTypesCopy ) ) {
						$baseTypes[] = 'categories:tree';
					}

					if( in_array( 'vehicles', $baseTypesCopy ) ) {
						$baseTypes[] = 'vehicles';
					}

					if( in_array( 'levels', $baseTypesCopy ) ) {
						$baseTypes[] = 'levels';
					}
				}

				$idx = 0;

				if( isset( $this->request->get['mfilterIdx'] ) ) {
					$idx = (int) $this->request->get['mfilterIdx'];
				}

				$data['mfilter_json'] = json_encode( MegaFilterCore::newInstance( $this, NULL, array( 'mfp_overwrite_path' => true ) )->getJsonData($baseTypes, $idx) );
			}

			$data['header'] = $data['column_left'] = $data['column_right'] = $data['content_top'] = $data['content_bottom'] = $data['footer'] = '';
		}
		
		if( isset( $data['mfilter_json'] ) ) {
			$data['header'] .= '<div id="mfilter-json" style="display:none">' . base64_encode( $data['mfilter_json'] ) . '</div>';
		}
		
		$data['content_top'] .= '<div id="mfilter-content-container">';
		$data['content_bottom'] = '</div>' . $data['content_bottom'];
					
		return $data;
	}
	
	public function getModuleSettings( $idx ) {
		if( isset( self::$_cache[__FUNCTION__][$idx] ) ) {
			return self::$_cache[__FUNCTION__][$idx];
		}
		
		self::$_cache[__FUNCTION__][$idx] = array();
		
		$query = $this->db->query( "SELECT * FROM `" . DB_PREFIX . "mfilter_settings` WHERE `idx` = " . (int) $idx );
		
		if( $query->num_rows ) {
			self::$_cache[__FUNCTION__][$idx] = json_decode( $query->row['settings'], true );
		}
		
		return self::$_cache[__FUNCTION__][$idx];
	}
	
	protected function settings() {
		if( ! $this->_settings ) {
			$this->_settings = $this->config->get('mega_filter_settings');
		}
		
		return $this->_settings;
	}
	
	protected function seoSettings() {
		return (array) $this->config->get( 'mega_filter_seo' );
	}
	
	protected function isSeoEnabled() {
		$settings = $this->seoSettings();
		
		return ! empty( $settings['enabled'] );
	}
	
	/**
	 * Pobierz listę statusów
	 * 
	 * @return array 
	 */
	public function getStockStatuses() {
		$list = array();
		
		foreach( $this->db->query("
			SELECT
				*
			FROM
				`" . DB_PREFIX . "stock_status`
			WHERE
				`language_id` = " . (int) $this->config->get('config_language_id') . "
		")->rows as $row ) {
			$list[] = array(
				'key' => $row['stock_status_id'],
				'value' => $row['stock_status_id'],
				'name' => $row['name']
			);
		}
		
		return $list;
	}
	
	public function createBaseQuery( array $parameters, $core = null ) {
		$sql	= "
			SELECT
				{__mfp_select__}
			FROM
				`" . DB_PREFIX . "product` AS `p`
			{__mfp_join__}
			{__mfp_conditions__}
			{__mfp_group_by__}
			{__mfp_order_by__}
			{__mfp_limit__}
		";
		
		if( $core === null ) {
			$core = MegaFilterCore::newInstance( $this, NULL, array(), $this->settings() );
		}
		
		$data			= MegaFilterCore::_getData( $this );
		$join			= '';
		$conditions		= $core->_baseConditions( array(), true );
		$skipBaseJoin	= array();
		
		if( isset( $parameters['skipBaseJoin'] ) ) {
			$skipBaseJoin = $parameters['skipBaseJoin'];
			
			unset( $parameters['skipBaseJoin'] );
		}
		
		if( in_array( $core->route(), MegaFilterCore::$_specialRoute ) ) {
			$conditions[] = '(' . $core->_specialCol( '' ) . ') IS NOT NULL';
		}
		
		if( ! empty( $this->request->get['mfp_path'] ) || ! empty( $data['filter_name'] ) || ! empty( $data['filter_category_id'] ) || ! empty( $data['filter_manufacturer_id'] ) || ! empty( $conditions['search'] ) ) {
			$join .= ' ' . $core->_baseJoin( $skipBaseJoin );
		}
		
		if( isset( $parameters['conditions'] ) ) {
			foreach( $parameters['conditions'] as $k => $v ) {
				if( is_string( $k ) ) {
					$conditions[$k] = $v;
				} else {
					$conditions[] = $v;
				}
			}
			
			unset( $parameters['conditions'] );
		}
		
		$conditions	= $conditions ? 'WHERE ' . implode( ' AND ', $conditions ) : '';
		
		$search = array(
			'{__mfp_join__}' => $join, 
			'{__mfp_select__}' => '', 
			'{__mfp_group_by__}' => '', 
			'{__mfp_order_by__}' => '', 
			'{__mfp_conditions__}' => $conditions,
			'{__mfp_limit__}' => ''
		);
		
		foreach( $parameters as $k => $v ) {
			$search[$k] .= $v;
		}
		
		return $this->createQuery( $sql, $search );
	}
	
	public function getTags( $core = null ) {
		$list = array();
		$sql = $this->createBaseQuery(array(
			'{__mfp_select__}' => 'DISTINCT `t`.`tag`, `mfilter_tag_id`',
			'{__mfp_join__}' => "INNER JOIN `" . DB_PREFIX . "mfilter_tags` AS `t` ON FIND_IN_SET( `t`.`mfilter_tag_id`, `p`.`mfilter_tags` )",
			'{__mfp_order_by__}' => 'ORDER BY `t`.`tag` ASC'
		), $core);
		
		foreach( $this->db->query( $sql )->rows as $row ) {
			$list[$row['mfilter_tag_id']] = array(
				'name' => $row['tag'],
				'value' => $row['tag'],
				'key' => $row['mfilter_tag_id']
			);
		}
		
		return $list;
	}
	
	public function getOptionsByType( $type, $core = null ) {
		$list	= array();
		$unit	= '';
		$ftmp	= in_array( $type, array( 'weight', 'length', 'width', 'height' ) ) ?
			"ROUND( `p`.`" . $type . "` / ( SELECT `value` FROM `" . DB_PREFIX . ( $type == 'weight' ? 'weight' : 'length' ) . "_class` WHERE `" . ( $type == 'weight' ? 'weight' : 'length' ) . "_class_id` = `p`.`" . ( $type == 'weight' ? 'weight' : 'length' ) . "_class_id` LIMIT 1 ), 10 ) AS `field`" :
			"`" . $type . "` AS `field`";		
		
		if( in_array( $type, array( 'weight', 'length', 'width', 'height' ) ) ) {
			$ftmp .= ", ROUND( `p`.`" . $type . "` / ( SELECT `value` FROM `" . DB_PREFIX . ( $type == 'weight' ? 'weight' : 'length' ) . "_class` WHERE `" . ( $type == 'weight' ? 'weight' : 'length' ) . "_class_id` = `p`.`" . ( $type == 'weight' ? 'weight' : 'length' ) . "_class_id` LIMIT 1 ), 2 ) AS `field_name`";
			
			$unit = $this->db->query( "
				SELECT 
					`unit` 
				FROM 
					`" . DB_PREFIX . ( $type == 'weight' ? 'weight' : 'length' ) . "_class` AS `c` 
				INNER JOIN 
					`" . DB_PREFIX . ( $type == 'weight' ? 'weight' : 'length' ) . "_class_description` AS `cd` ON `c`.`" . ( $type == 'weight' ? 'weight' : 'length' ) . "_class_id` = `cd`.`" . ( $type == 'weight' ? 'weight' : 'length' ) . "_class_id` AND `cd`.`language_id` = " . (int) $this->config->get( 'config_language_id' ) . "
				WHERE
					`c`.`value` = 1
				LIMIT
					1
			");
			
			$unit = $unit->num_rows ? ' ' . $unit->row['unit'] : '';
		}
		
		$sql	= $this->createBaseQuery(array(
			'{__mfp_select__}' => $ftmp,
			'{__mfp_group_by__}' => 'GROUP BY `field`',
			'{__mfp_order_by__}' => in_array( $type, array( 'width', 'height', 'length', 'weight' ) ) ? 'ORDER BY `field_name` ASC' : 'ORDER BY `field` ASC',
			'conditions' => in_array( $type, array( 'width', 'height', 'length', 'weight' ) ) ? array(
				"`p`.`" . $type . "` > 0"
			) : array()
		), $core);
		
		foreach( $this->db->query( $sql )->rows as $row ) {			
			switch( $type ) {
				case 'length' :
				case 'width' :
				case 'height' : 
				case 'weight' : {
					$row['field'] = round( $row['field'], 10 );
					
					break;
				}
			}
			
			$k = md5( $row['field'] );
			
			$list[$k] = array(
				'name' => ( isset( $row['field_name'] ) ? $row['field_name'] : $row['field'] ) . $unit,
				'value' => $row['field'],
				'key' => $k
			);
		}
		
		return $list;
	}
	
	public function getManufacturers( $core = null ) {
		$sql = "
			SELECT 
				`m`.*" . (
					! $this->isSeoEnabled() ? '' :
					", (
						SELECT `keyword` FROM `" . DB_PREFIX . "url_alias` AS `ua` WHERE `query` = CONCAT( 'manufacturer_id=', `m`.`manufacturer_id` ) " . (
							$this->config->get( 'smp_is_install' ) ? "
								AND `ua`.`smp_language_id` = '" . (int) $this->config->get('config_language_id') . "'
							" : ''
					) . " LIMIT 1) AS `keyword`" ) . "
			FROM 
				`" . DB_PREFIX . "manufacturer` AS `m` 
			INNER JOIN 
				`" . DB_PREFIX . "manufacturer_to_store` AS `m2s` 
			ON 
				`m`.`manufacturer_id` = `m2s`.`manufacturer_id` AND `m2s`.`store_id` = '" . (int)$this->config->get('config_store_id') . "'
			{join}
			{conditions}
			{group}
			ORDER BY 
				`m`.`name` ASC
		";
		
		if( $core === null ) {
			$core = MegaFilterCore::newInstance( $this, NULL, array(), $this->settings() );
		}
		
		$data		= MegaFilterCore::_getData( $this );
		$join		= '';
		$group		= array();
		$conditions	= $core->_baseConditions( array(), true );
		$join		= 'INNER JOIN `' . DB_PREFIX . 'product` AS `p` ON `p`.`manufacturer_id` = `m`.`manufacturer_id`';
		
		if( in_array( $core->route(), MegaFilterCore::$_specialRoute ) ) {
			$conditions[] = '(' . $core->_specialCol( '' ) . ') IS NOT NULL';
		}
		
		if( ! empty( $this->request->get['mfp_path'] ) || ! empty( $data['filter_name'] ) || ! empty( $data['filter_category_id'] ) || ! empty( $data['filter_manufacturer_id'] ) || ! empty( $conditions['search'] ) ) {
			$join .= ' ' . $core->_baseJoin();
		}
		
		if( $join ) {
			$group[] = '`m`.`manufacturer_id`';
		}
		
		$group		= $group ? 'GROUP BY ' . implode( ',', $group ) : '';
		$conditions	= $conditions ? 'WHERE ' . implode( ' AND ', $conditions ) : '';
		
		$sql			= str_replace( array( '{join}', '{conditions}', '{group}' ), array( $join, $conditions, $group ), $sql );
		$manufacturers	= array();
		
		foreach( $this->db->query( $sql )->rows as $row ) {
			$manufacturers[] = array(
				'key'	=> $row['manufacturer_id'],
				'value'	=> $this->isSeoEnabled() && $row['keyword'] ? $row['keyword'] : $row['manufacturer_id'],
				'name'	=> $row['name'],
				'image'	=> empty( $row['image'] ) ? '' : $row['image']
			);
		}
		
		return $manufacturers;
	}
	
	public function getDiscountsSql( $core = null ) {		
		if( $core === null ) {
			$core = MegaFilterCore::newInstance( $this, NULL, array(), $this->settings() );
		}
		
		$sql = "
			SELECT 
				ROUND( 100 - ( ( ( " . $core->priceCol('') . " ) / `p`.`price` ) * 100 ) ) AS `discount`
			FROM 
				`" . DB_PREFIX . "product` AS `p` 
			{join}
			{conditions}
			{group}
			HAVING
				`discount` > 0
			ORDER BY 
				`discount` ASC
		";
		
		$data		= MegaFilterCore::_getData( $this );
		$join		= '';
		$group		= array();
		$conditions	= $core->_baseConditions( array(
			'`p`.`price` > 0',
		), true );
		$join		= '';
		
		if( in_array( $core->route(), MegaFilterCore::$_specialRoute ) ) {
			$conditions[] = '(' . $core->_specialCol( '' ) . ') IS NOT NULL';
		}
		
		if( ! empty( $this->request->get['mfp_path'] ) || ! empty( $data['filter_name'] ) || ! empty( $data['filter_category_id'] ) || ! empty( $data['filter_manufacturer_id'] ) || ! empty( $conditions['search'] ) ) {
			$join .= ' ' . $core->_baseJoin();
		}
		
		if( $join ) {
			$group[] = '`p`.`product_id`';
		}
		
		$group		= $group ? 'GROUP BY ' . implode( ',', $group ) : '';
		$conditions	= $conditions ? 'WHERE ' . implode( ' AND ', $conditions ) : '';
		
		return str_replace( array( '{join}', '{conditions}', '{group}' ), array( $join, $conditions, $group ), $sql );
	}
	
	public function getDiscounts( $core = null ) {
		$sql = $this->getDiscountsSql( $core );		
		$discounts	= array();
		
		foreach( $this->db->query( $sql )->rows as $row ) {
			$discounts[] = array(
				'key'	=> $row['discount'],
				'value'	=> $row['discount'],
				'name'	=> $row['discount'] . '%',
				'image'	=> ''
			);
		}
		
		return $discounts;
	}
	
	private function stockStatusIsEnabled( $idx ) {		
		$module		= $this->getModuleSettings( $idx );
		$attribs	= $idx !== NULL && isset( $module['base_attribs'] ) ? $module['base_attribs'] : $this->_settings['attribs'];
		
		return empty( $attribs['stock_status']['enabled'] ) ? false : true;
	}
	
	private function calculateNumberOfProducts( $idx ) {
		$module	= $this->getModuleSettings( $idx );
		$config	= $idx !== NULL && isset( $module['configuration'] ) ? $module['configuration'] : $this->_settings;
		
		return ! empty( $config['calculate_number_of_products'] );
	}
	
	private function showNumberOfProducts( $idx ) {
		$module	= $this->getModuleSettings( $idx );
		$config	= $idx !== NULL && isset( $module['configuration'] ) ? $module['configuration'] : $this->_settings;
		
		return ! empty( $config['show_number_of_products'] );
	}
	
	/**
	 * Utwórz listę filtrów 
	 */
	public function createFilters( $core, $idx, array $config ) {
		$sql = "
			SELECT
				`fgd`.`name` AS `gname`,
				`fgd`.`mf_tooltip` AS `tooltip`,
				`f`.`filter_group_id`,
				`f`.`filter_id`,
				`fd`.`name`" . (  $this->isSeoEnabled() ? ",
				LOWER(REPLACE(REPLACE(REPLACE(TRIM(`fd`.`name`), '\r', ''), '\n', ''), ' ', '-')) AS `keyword`" : '' ) . "
			FROM
				`" . DB_PREFIX . "product` AS `p`
			INNER JOIN
				`" . DB_PREFIX . "product_to_store` AS `p2s`
			ON
				`p`.`product_id` = `p2s`.`product_id` AND `p2s`.`store_id` = " . (int) $this->config->get( 'config_store_id' ) . "
			INNER JOIN
				`" . DB_PREFIX . "product_filter` AS `pf`
			ON
				`p`.`product_id` = `pf`.`product_id`
			INNER JOIN
				`" . DB_PREFIX . "filter` AS `f`
			ON
				`pf`.`filter_id` = `f`.`filter_id`
			INNER JOIN
				`" . DB_PREFIX . "filter_description` AS `fd`
			ON
				`pf`.`filter_id` = `fd`.`filter_id` AND `fd`.`language_id` = " . (int) $this->config->get('config_language_id') . "
			INNER JOIN
				`" . DB_PREFIX . "filter_group_description` AS `fgd`
			ON
				`f`.`filter_group_id` = `fgd`.`filter_group_id` AND `fgd`.`language_id` = " . (int) $this->config->get('config_language_id') . "
			{join}
			WHERE
				{conditions}
			GROUP BY
				`f`.`filter_group_id`, `f`.`filter_id`
			ORDER BY
				`f`.`sort_order`, `fd`.`name`
		";
		
		$filter_ids		= array();
		
		if( ! empty( $config['based_on_category'] ) ) {
			$category_id	= isset( $this->request->get['path'] ) ? explode( '_', (string) $this->request->get['path'] ) : array();
			$category_id	= end( $category_id );

			if( ! $category_id )
				return array();

			foreach( $this->db->query( 'SELECT `filter_id` FROM `' . DB_PREFIX . 'category_filter` WHERE `category_id` = ' . (int) $category_id )->rows as $row ) {
				$filter_ids[] = (int) $row['filter_id'];
			}

			if( ! $filter_ids )
				return array();
		}
		
		$conditions		= $core->_baseConditions( array(), true );
		$filters		= array();
		$join			= $core->_baseJoin(array('p2s','pf'));
		
		if( $filter_ids ) {
			$conditions[]	= sprintf( '`f`.`filter_id` IN(%s)', implode( ',', $filter_ids ) );
		}
		
		if( in_array( $core->route(), MegaFilterCore::$_specialRoute ) ) {
			$conditions[] = '(' . $core->_specialCol( '' ) . ') IS NOT NULL';
		}
		
		if( ! $this->stockStatusIsEnabled( $idx ) && ! empty( $core->_settings['in_stock_default_selected'] ) ) {
			$conditions[] = sprintf( '( `p`.`quantity` > 0 OR `p`.`stock_status_id` = %s )', $core->inStockStatus() );
		}
		
		$sql	= str_replace( array( '{conditions}', '{join}' ), array( implode( ' AND ', $conditions ), $join ), $sql );
		$sort	= array();
		
		foreach( $this->db->query( $sql )->rows as $filter ) {
			/* @var $item array */
			$item = isset( $config['default'] ) ? $config['default'] : array();
			
			if( isset( $config[$filter['filter_group_id']] ) ) {
				$item = $config[$filter['filter_group_id']];
			}
			
			if( empty( $item['enabled'] ) ) continue;
			
			if( ! isset( $item['sort_order'] ) ) {
				$item['sort_order'] = 0;
			}
			
			$images = (array) $this->config->get('mega_filter_fi_img_' . $filter['filter_group_id'] . '_' . $this->config->get('config_language_id'));
			
			if( ! isset( $filters['f_'.$filter['filter_group_id']] ) ) {
				$filters['f_'.$filter['filter_group_id']] = array(
					'id'					=> $filter['filter_group_id'],
					'type'					=> $item['type'],
					'base_type'				=> 'filter',
					'sort_order'			=> $item['sort_order'],
					'name'					=> $filter['gname'],
					'tooltip'				=> $filter['tooltip'],
					'seo_name'				=> $filter['filter_group_id'] . 'f-' . $this->clear( $filter['gname'] ),
					'options'				=> array(),
					'collapsed'				=> empty( $item['collapsed'] ) ? false : $item['collapsed'],
					'display_list_of_items'	=> empty( $item['display_list_of_items'] ) ? '' : $item['display_list_of_items'],
					'display_live_filter'	=> empty( $item['display_live_filter'] ) ? '' : $item['display_live_filter']
				);
			}
			
			if( ! empty( $item['sort_order_values'] ) )
				$sort['f_'.$filter['filter_group_id']] = $item['sort_order_values'];
			
			$filters['f_'.$filter['filter_group_id']]['options'][$filter['filter_id']] = array(
				'name' => $filter['name'],
				'value' => $this->isSeoEnabled() ? $filter['keyword'] : $filter['filter_id'],
				'key' => $filter['filter_id']
			);
				
			if( in_array( $filters['f_'.$filter['filter_group_id']]['type'], array( 'image', 'image_radio', 'image_list_radio', 'image_list_checkbox' ) ) ) {
				list( $w, $h ) = $this->_imageSize();
				
				$filters['f_'.$filter['filter_group_id']]['options'][$filter['filter_id']]['image'] = self::parseUrl( isset( $images[$filter['filter_id']] ) ? $this->model_tool_image->resize($images[$filter['filter_id']], $w, $h) : $this->model_tool_image->resize('no_image.jpg', $w, $h) );
			}
		}
		
		foreach( $sort as $filter_group_id => $type ) {
			$this->_sortOptions( $filters[$filter_group_id]['options'], $type, true );
		}
		
		return $filters;
	}
	
	private static function parseUrl( $url ) {
		$scheme		= isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
		$host		= isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
		$parse		= parse_url( $url );
		
		return $scheme . '://' . $host . '/' . trim( $parse['path'], '/' ) . ( empty( $parse['query'] ) ? '' : '?' . str_replace( '&amp;', '&', $parse['query'] ) );
	}
	
	/**
	 * Create a list of options
	 */
	public function createOptions( $core, $idx, array $opts ) {
		$sql = "
			SELECT
				`o`.`option_id`,
				`ov`.`option_value_id`,
				`od`.`name` AS `gname`,
				`od`.`mf_tooltip` AS `tooltip`,
				`ov`.`image`,
				`ovd`.`name`" . (  $this->isSeoEnabled() ? ",
				LOWER(REPLACE(REPLACE(REPLACE(TRIM(`ovd`.`name`), '\r', ''), '\n', ''), ' ', '-')) AS `keyword`" : '' ) . "
			FROM
				`" . DB_PREFIX . "product` AS `p`
			INNER JOIN
				`" . DB_PREFIX . "product_to_store` AS `p2s`
			ON
				`p`.`product_id` = `p2s`.`product_id` AND `p2s`.`store_id` = " . (int) $this->config->get( 'config_store_id' ) . "
			INNER JOIN
				`" . DB_PREFIX . "product_option_value` AS `pov`
			ON
				`p`.`product_id` = `pov`.`product_id`
			INNER JOIN
				`" . DB_PREFIX . "option_value` AS `ov`
			ON
				`ov`.`option_value_id` = `pov`.`option_value_id`
			INNER JOIN
				`" . DB_PREFIX . "option_value_description` AS `ovd`
			ON
				`ov`.`option_value_id` = `ovd`.`option_value_id` AND `ovd`.`language_id` = " . (int) $this->config->get('config_language_id') . "
			INNER JOIN
				`" . DB_PREFIX . "option` AS `o`
			ON
				`o`.`option_id` = `pov`.`option_id`
			INNER JOIN
				`" . DB_PREFIX . "option_description` AS `od`
			ON
				`od`.`option_id` = `o`.`option_id` AND `od`.`language_id` = " . (int) $this->config->get('config_language_id') . "
			{join}
			WHERE
				{conditions}
			GROUP BY
				`o`.`option_id`, `ov`.`option_value_id`
			ORDER BY
				`ov`.`sort_order`, `ovd`.`name`
		";
		
		$this->load->model('tool/image');
		
		$conditions		= $core->_baseConditions( array(), true );
		$conditions[]	= "`o`.`type` IN('radio','checkbox','select','image','image_radio')";
		$options		= array();
		$join			= $core->_baseJoin(array('p2s'));
		
		if( in_array( $core->route(), MegaFilterCore::$_specialRoute ) ) {
			$conditions[] = '(' . $core->_specialCol( '' ) . ') IS NOT NULL';
		}
		
		if( ! $this->stockStatusIsEnabled( $idx ) && ! empty( $core->_settings['in_stock_default_selected'] ) ) {
			$conditions[] = '`pov`.`quantity` > 0';
			$conditions[] = sprintf( '( `p`.`quantity` > 0 OR `p`.`stock_status_id` = %s )', $core->inStockStatus() );
		}
		
		$sql	= str_replace( array( '{conditions}', '{join}' ), array( implode( ' AND ', $conditions ), $join ), $sql );
		$sort	= array();
		
		foreach( $this->db->query( $sql )->rows as $option ) {
			/* @var $item array */
			$item = isset( $opts['default'] ) ? $opts['default'] : array();
			
			if( isset( $opts[$option['option_id']] ) ) {
				$item = $opts[$option['option_id']];
			}
			
			if( empty( $item['enabled'] ) ) continue;
			
			if( ! isset( $item['sort_order'] ) ) {
				$item['sort_order'] = 0;
			}
			
			if( ! isset( $options['o_'.$option['option_id']] ) ) {
				$options['o_'.$option['option_id']] = array(
					'id'					=> $option['option_id'],
					'type'					=> $item['type'],
					'base_type'				=> 'option',
					'sort_order'			=> $item['sort_order'],
					'name'					=> $option['gname'],
					'tooltip'				=> $option['tooltip'],
					'seo_name'				=> $option['option_id'] . 'o-' . $this->clear( $option['gname'] ),
					'options'				=> array(),
					'collapsed'				=> empty( $item['collapsed'] ) ? false : $item['collapsed'],
					'display_list_of_items'	=> empty( $item['display_list_of_items'] ) ? '' : $item['display_list_of_items'],
					'display_live_filter'	=> empty( $item['display_live_filter'] ) ? '' : $item['display_live_filter']
				);
			}
			
			if( ! empty( $item['sort_order_values'] ) )
				$sort['o_'.$option['option_id']] = $item['sort_order_values'];
			
			$value = array(
				'name'	=> $option['name'],
				'value'	=> $this->isSeoEnabled()?$option['keyword']:$option['option_value_id'],
				'key' => $option['option_value_id']
			);
			
			if( in_array( $item['type'], array( 'image', 'image_radio', 'image_list_radio', 'image_list_checkbox' ) ) ) {
				list( $w, $h ) = $this->_imageSize();
				
				$value['image'] = self::parseUrl( empty( $option['image'] ) ? $this->model_tool_image->resize('no_image.jpg', $w, $h) : $this->model_tool_image->resize($option['image'], $w, $h) );
			}
			
			$options['o_'.$option['option_id']]['options'][$option['option_value_id']] = $value;
		}
		
		foreach( $sort as $option_id => $type ) {
			$this->_sortOptions( $options[$option_id]['options'], $type, true );
		}
		
		return $options;
	}
	
	private function _imageSize() {
		$settings	= $this->settings();
		
		$w = empty( $settings['image_size_width'] ) ? 20 : (int) $settings['image_size_width'];
		$h = empty( $settings['image_size_height'] ) ? 20 : (int) $settings['image_size_height'];
		
		return array( $w, $h );
	}
	
	/**
	 * Utwórz listę atrybutów
	 * 
	 * @param array $attribs
	 * @return type 
	 */
	public function createAttribs( $core, $idx, array $attribs ) {
		$sql = "
			SELECT
				`a`.`attribute_id`,
				REPLACE(REPLACE(TRIM(pa.text), '\r', ''), '\n', '') AS `txt`,
				`ad`.`name`,
				`ad`.`mf_tooltip` AS `tooltip`,
				`agd`.`name` AS `gname`,
				`agd`.`attribute_group_id`
			FROM
				`" . DB_PREFIX . "product` AS `p`
			INNER JOIN
				`" . DB_PREFIX . "product_to_store` AS `pts`
			ON
				`p`.`product_id` = `pts`.`product_id` AND `pts`.`store_id` = " . (int) $this->config->get( 'config_store_id' ) . "
			INNER JOIN
				`" . DB_PREFIX . "product_attribute` AS `pa`
			ON
				`p`.`product_id` = `pa`.`product_id` AND `pa`.`language_id` = " . (int)$this->config->get('config_language_id') . "
			INNER JOIN
				`" . DB_PREFIX . "attribute` AS `a`
			ON
				`a`.`attribute_id` = `pa`.`attribute_id`
			INNER JOIN
				`" . DB_PREFIX . "attribute_description` AS `ad`
			ON
				`ad`.`attribute_id` = `a`.`attribute_id` AND `ad`.`language_id` = " . (int) $this->config->get('config_language_id') . "
			INNER JOIN
				`" . DB_PREFIX . "attribute_group` AS `ag`
			ON
				`ag`.`attribute_group_id` = `a`.`attribute_group_id`
			INNER JOIN
				`" . DB_PREFIX . "attribute_group_description` AS `agd`
			ON
				`agd`.`attribute_group_id` = `ag`.`attribute_group_id` AND `agd`.`language_id` = " . (int)$this->config->get('config_language_id') . "
			{join}
			WHERE
				{conditions}
			GROUP BY
				`txt`, `pa`.`attribute_id`
			HAVING 
				`txt` != ''
			ORDER BY
				`txt`
		";
		
		$this->load->model('tool/image');
		
		$conditions	= $core->_baseConditions( array(), true );
		$attributes = array();
		$join		= $core->_baseJoin(array('p2s'));
		$settings	= $this->settings();
		
		if( in_array( $core->route(), MegaFilterCore::$_specialRoute ) ) {
			$conditions[] = '(' . $core->_specialCol( '' ) . ') IS NOT NULL';
		}
		
		if( ! $this->stockStatusIsEnabled( $idx ) && ! empty( $core->_settings['in_stock_default_selected'] ) ) {
			$conditions[] = sprintf( '( `p`.`quantity` > 0 OR `p`.`stock_status_id` = %s )', $core->inStockStatus() );
		}
		
		$sql	= str_replace( array( '{conditions}', '{join}' ), array( implode( ' AND ', $conditions ), $join ), $sql );
		$sort	= array();
		$query	= $this->db->query( $sql );
		$rows	= $query && $query->rows ? $query->rows : array();
		
		foreach( $rows as $attribute ) {
			/* @var $item array */
			$item = isset( $attribs['default'] ) ? $attribs['default'] : array();
			
			if( isset( $attribs[$attribute['attribute_group_id']]['items'][$attribute['attribute_id']] ) ) {
				$item = $attribs[$attribute['attribute_group_id']]['items'][$attribute['attribute_id']];
			} else if( isset( $attribs['default_group'][$attribute['attribute_group_id']] ) ) {
				$item = $attribs['default_group'][$attribute['attribute_group_id']];
			}
			
			if( empty( $item['enabled'] ) ) continue;
			
			if( ! isset( $item['sort_order'] ) ) {
				$item['sort_order'] = 0;
			}
			
			$images = (array) $this->config->get('mega_filter_at_img_' . $attribute['attribute_id'] . '_' . $this->config->get('config_language_id'));
			
			if( ! isset( $attributes['a_'.$attribute['attribute_id']] ) ) {
				$attributes['a_'.$attribute['attribute_id']] = array(
					'id'					=> $attribute['attribute_id'],
					'group_id'				=> $attribute['attribute_group_id'],
					'type'					=> $item['type'],
					'base_type'				=> 'attribute',
					'sort_order'			=> empty( $attribs[$attribute['attribute_group_id']]['sort_order'] ) ? 0 : (int) $attribs[$attribute['attribute_group_id']]['sort_order'],
					'sort_order-sec'		=> $item['sort_order'],
					'name'					=> $attribute['name'],
					'tooltip'				=> $attribute['tooltip'],
					'seo_name'				=> $attribute['attribute_id'] . '-' . $this->clear( $attribute['name'] ),
					'options'				=> array(),
					'collapsed'				=> empty( $item['collapsed'] ) ? false : $item['collapsed'],
					'display_list_of_items'	=> empty( $item['display_list_of_items'] ) ? '' : $item['display_list_of_items'],
					'display_live_filter'	=> empty( $item['display_live_filter'] ) ? '' : $item['display_live_filter']
				);
			}
			
			$attribute['txt'] = htmlspecialchars_decode( $attribute['txt'] );
			
			if( ! empty( $settings['attribute_separator'] ) ) {
				$attribute['txt'] = array_map( 'trim', explode( $settings['attribute_separator'], $attribute['txt'] ) );
			} else {
				$attribute['txt'] = array( $attribute['txt'] );
			}
			
			$unique	= array();
			foreach( $attribute['txt'] as $text ) {
				$text = htmlspecialchars( $text );
				
				$k = md5( $text );
				
				if( isset( $unique[$text] ) ) continue;
				
				$unique[$text]	= true;
				$value			= array(
					'name' => $text,
					'value' => $text,
					'key' => $k
				);
				
				if( in_array( $item['type'], array( 'image', 'image_radio', 'image_list_radio', 'image_list_checkbox' ) ) ) {
					list( $w, $h ) = $this->_imageSize();
					
					$value['image'] = self::parseUrl( isset( $images[$k] ) ? $this->model_tool_image->resize($images[$k], $w, $h) : $this->model_tool_image->resize('no_image.jpg', $w, $h) );
				}
				
				$attributes['a_'.$attribute['attribute_id']]['options'][$k] = $value;
			}
			
			if( ! empty( $item['sort_order_values'] ) )
				$sort['a_'.$attribute['attribute_id']] = $item['sort_order_values'];
		}
		
		if( ! empty( $settings['attribute_separator'] ) ) {
			foreach( $attributes as $attribute_id => $attribute ) {
				if( ! empty( $attribute['options'] ) ) {
					$this->_sortOptions( $attribute['options'], empty( $sort[$attribute_id] ) ? '' : $sort[$attribute_id], true, $attribute_id );
				}
				
				$attributes[$attribute_id] = $attribute;
			}
		} else {
			foreach( $attributes as $attribute_id => $attribute ) {
				$this->_sortOptions( $attributes[$attribute_id]['options'], empty( $sort[$attribute_id] ) ? '' : $sort[$attribute_id], true, $attribute_id );
			}
			//foreach( $sort as $attribute_id => $type ) {
			//	$this->_sortOptions( $attributes[$attribute_id]['options'], $type, false, $attribute_id );
			//}
		}
		
		return $attributes;
	}
	
	public function _prepareVehiclesData( $data ) {
		if( ! empty( $data['makes'] ) ) {
			$this->load->model('tool/image');
			
			list( $w, $h ) = $this->_imageSize();
			
			foreach( $data['makes'] as $k => $v ) {
				$data['makes'][$k]['image'] = empty( $v['image'] ) ? '' : self::parseUrl( $this->model_tool_image->resize($v['image'], $w, $h) );
			}
		}
		
		return $data;
	}
	
	public function _prepareLevelsData( $data ) {
		$this->load->model('tool/image');
			
		list( $w, $h ) = $this->_imageSize();
			
		foreach( $data as $k => $v ) {
			foreach( $v as $k2 => $v2 ) {
				$data[$k][$k2]['image'] = empty( $v2['image'] ) ? '' : self::parseUrl( $this->model_tool_image->resize($v2['image'], $w, $h) );
			}
		}
		
		return $data;
	}
	
	public function hasVehicles() {
		if( ! $this->config->get( 'mfilter_vehicle_version' ) || ! $this->config->get( 'mfilter_vehicle_license' ) ) {
			return false;
		}
		
		require_once DIR_SYSTEM . 'library/mfilter_vehicle.php';
		
		if( ! class_exists( 'Mfilter_Vehicle' ) ) {
			return false;
		}
		
		return true;
	}
	
	public function hasLevels() {
		if( ! $this->config->get( 'mfilter_level_version' ) || ! $this->config->get( 'mfilter_level_license' ) ) {
			return false;
		}
		
		require_once DIR_SYSTEM . 'library/mfilter_level.php';
		
		if( ! class_exists( 'Mfilter_Level' ) ) {
			return false;
		}
		
		return true;
	}
	
	public function createVehicles( $idx, $core, $config ) {
		if( ! $this->hasVehicles() ) {
			return array();
		}
		
		$data = Mfilter_Vehicle::createVehicles( $this, $core, $config, $this->calculateNumberOfProducts( $idx ) && $this->showNumberOfProducts( $idx ) );
		
		if( ! empty( $data['vehicles']['options'] ) ) {
			$data['vehicles']['options'] = $this->_prepareVehiclesData( $data['vehicles']['options'] );
		}
		
		return $data;
	}
	
	public function createLevels( $idx, $core, $config ) {
		if( ! $this->hasLevels() ) {
			return array();
		}
		
		$data = Mfilter_Level::createLevels( $this, $core, $config, $this->calculateNumberOfProducts( $idx ) && $this->showNumberOfProducts( $idx ) );
		
		if( ! empty( $data['levels']['options'] ) ) {
			$data['levels']['options'] = $this->_prepareLevelsData( $data['levels']['options'] );
		}
		
		return $data;
	}
	
	public function vehiclesToJson( $idx, $core, array $data = array() ) {
		if( ! $this->hasVehicles() ) {
			return array();
		}
		
		return $this->_prepareVehiclesData( Mfilter_Vehicle::toJson( $this, $core, $data, $this->calculateNumberOfProducts( $idx ) && $this->showNumberOfProducts( $idx ) ) );
	}
	
	public function levelsToJson( $idx, $core, array $data = array() ) {
		if( ! $this->hasLevels() ) {
			return array();
		}
		
		return $this->_prepareLevelsData( Mfilter_Level::toJson( $this, $core, $data, $this->calculateNumberOfProducts( $idx ) && $this->showNumberOfProducts( $idx ) ) );
	}
	
	protected function getParseParams( & $core ) {
		if( isset( $this->request->get['mfp_temp'] ) ) {
			$this->request->get['mfp'] = $this->request->get['mfp_temp'];
			$core->parseParams();
		}
		
		$params = $core->getParseParams();
		
		if( isset( $this->request->get['mfp_temp'] ) ) {
			unset( $this->request->get['mfp'] );
			$core->parseParams();
		}
		
		return $params;
	}
	
	/**
	 * Utwórz listę kategorii 
	 */
	public function createCategories( & $core, $idx, $config ) {
		$categories = array();
		$params		= $this->getParseParams( $core );
		
		foreach( $config as $key => $category ) {
			$row = array(
				'sort_order'	=> isset( $category['sort_order'] ) ? $category['sort_order'] : 0,
				'type'			=> $category['type'],
				'base_type'		=> 'categories',
				'collapsed'		=> empty( $category['collapsed'] ) ? false : $category['collapsed'],
				'show_button'	=> empty( $category['show_button'] ) ? false : true,
				'name'			=> empty( $category['name'][$this->config->get('config_language_id')] ) ? current( $category['name'] ) : $category['name'][$this->config->get('config_language_id')],
			);
			
			$row['seo_name']	= 'c-' . $this->clear( $row['name'] ? $row['name'] : 'cat' ) . '-' . $key;
			$values				= empty( $params[$row['seo_name']] ) ? array() : $params[$row['seo_name']];
			
			switch( $category['type'] ) {
				case 'tree' : {
					if( NULL != ( $row['categories'] = $core->getTreeCategories( null, 'tree' ) ) || ! empty( $this->request->get['mfp_path'] ) || ! empty( $category['show_go_back_to_top'] ) ) {
						$row['top_path'] = 0;
						
						if( ! empty( $this->request->get['mfp_org_path'] ) ) {
							$row['top_path'] = explode( strpos( $this->request->get['mfp_org_path'], ',' ) ? ',' : '_', $this->request->get['mfp_org_path'] );
						} else if( ! empty( $this->request->get['path'] ) ) {
							$row['top_path'] = explode( '_', $this->request->get['path'] );
						}
						
						if( is_array( $row['top_path'] ) ) {
							array_pop( $row['top_path'] );
							$row['top_path'] = $row['top_path'] ? implode( '_', MegaFilterCore::_aliasesToIds( $this, 'category_id', $row['top_path'] ) ) : 0;
						}
						
						$row['top_url'] = $row['top_path'] ? $this->url->link( 'product/category', '&path=' . $row['top_path'], 'SSL' ) : '';
					} else {
						$row = NULL;
					}
					
					break;
				}
				case 'cat_checkbox' : {
					$row['seo_name'] = 'path';
					
					if( NULL == ( $row['categories'] = $core->getTreeCategories( ! empty( $this->request->get['mfp_org_path'] ) ? $this->request->get['mfp_org_path'] : NULL, 'checkbox' ) ) ) {
						$row = NULL;
					}
					
					break;
				}
				case 'related' : {
					$row['levels']		= array();
					$row['labels']		= array();
					$row['auto_levels']	= empty( $category['auto_levels'] ) ? false : true;
					$root_category_id	= empty( $category['root_category_id'] ) ? NULL : $category['root_category_id'];
					$start_id			= 0;
					
					if( ! empty( $category['root_category_type'] ) ) {
						switch( $category['root_category_type'] ) {
							case 'by_url' : {
								if( ! empty( $this->request->get['path'] ) ) {
									$path = explode( '_', $this->request->get['path'] );
									$start_id = count( $path ) - 1;
									$root_category_id = end( $path );
								}
								
								break;
							}
							case 'top_category' : {
								$root_category_id = 0;
								
								break;
							}
						}
					}
					
					if( ! empty( $category['levels'] ) ) {						
						$levels = $category['levels'];
							
						foreach( $category['levels'] as $level ) {
							$row['labels'][] = empty( $level[$this->config->get('config_language_id')] ) ? $this->language->get('text_select') : $level[$this->config->get('config_language_id')];
						}
						
						if( $start_id ) {
							if( empty( $category['auto_levels'] ) ) {
								$levels = array_slice( $levels, $start_id );
							} else {
								$levels = array_slice( $levels, $start_id, count( $values ) ? count( $values ) : 1 );
							}
							
							//$values = array_slice( $values, $start_id );
							$row['labels'] = array_slice( $row['labels'], $start_id );
						}
						
						$level_id = 0;
						foreach( $levels as $level ) {
							$level = array(
								'name'			=> $row['labels'][$level_id],
								'options'		=> array()
							);
							$value = empty( $values[$level_id-1] ) ? $root_category_id : $values[$level_id-1];
							
							if( ! $row['levels'] || $value ) {
								if( $value ) {
									$this->load->model('catalog/category');
									
									foreach( $this->model_catalog_category->getCategories( $value ) as $cat ) {
										$level['options'][$cat['category_id']] = $cat['name'];
									}
									
									//if( isset( $values[$level_id-1] ) ) {
										if( $level_id && ! isset( $row['levels'][$level_id-1]['options'][$value] ) ) {
											if( ! empty( $category['auto_levels'] ) ) {
												break;
											} else {
												$level['options'] = array();
											}
										}
									//}
								}
								
								if( ! $level['options'] && ( ! $value || ! $level_id ) ) {
									$row = NULL;
									break;
								}
							}
							
							$row['levels'][] = $level;
							$level_id++;
						}
						
						if( empty( $row['levels'] ) ) {
							$row = NULL;
						}
					} else {
						$row = NULL;
					}
					
					break;
				}
			}
			
			if( $row != NULL ) {
				$categories[] = $row;
			}
		}
		
		return $categories;
	}
	
	private static function _sortItems( $a, $b ) {
		$as = isset( self::$_tmp_sort_parameters['config'][md5($a['name'])] ) ? self::$_tmp_sort_parameters['config'][md5($a['name'])] : count(self::$_tmp_sort_parameters['config']);
		$bs = isset( self::$_tmp_sort_parameters['config'][md5($b['name'])] ) ? self::$_tmp_sort_parameters['config'][md5($b['name'])] : count(self::$_tmp_sort_parameters['config']);
		
		if( $as > $bs )
			return 1;
		
		if( $as < $bs )
			return -1;
		
		return 0;
	}
	
	private function _sortOptions( & $options, $sort, $a = false, $attribute_id = NULL ) {		
		if( $sort ) {
			list( $type, $order ) = explode( '_', $sort );
		} else {
			$type = $order = '';
		}
		
		if( $attribute_id ) {
			$attribute_id = str_replace(array(
				'a_', 'o_', 'f_'
			), '', $attribute_id);
		}
		
		self::$_tmp_sort_parameters = array(
			'attribute_id'	=> $attribute_id,
			'type'			=> $type,
			'order'			=> $order,
			'a'				=> $a,
			'options'		=> $options,
			'config'		=> $this->config->get('mega_filter_at_sort_' . $attribute_id . '_' . $this->config->get('config_language_id') )
		);
		
		if( ! self::$_tmp_sort_parameters['type'] && ! self::$_tmp_sort_parameters['config'] ) {
			self::$_tmp_sort_parameters = NULL;
			
			return;
		}
		
		if( ! self::$_tmp_sort_parameters['type'] && self::$_tmp_sort_parameters['attribute_id'] !== NULL && self::$_tmp_sort_parameters['config'] ) {
			uasort( $options, array( 'ModelModuleMegaFilter', '_sortItems' ) );
		} else {
			$tmp = array();
			
			foreach( $options as $k => $v ) {
				$tmp['_'.$k] = htmlspecialchars_decode( $v['name'] );
			}
			
			if( $order == 'desc' ) {
				arsort( $tmp, $type == 'string' ? SORT_STRING : SORT_NUMERIC );
			} else {
				asort( $tmp, $type == 'string' ? SORT_STRING : SORT_NUMERIC );
			}
			
			$tmp2 = array();
			
			foreach( $tmp as $k => $v ) {
				$tmp2[trim($k,'_')] = $options[trim($k,'_')];
			}
		
			$options = $tmp2;
		}
			
		self::$_tmp_sort_parameters = NULL;
	}
		
	/**
	 * Pobierz listę atrybutów
	 * 
	 * @return array 
	 */
	public function getAttributes( $core, $idx, array $base_attribs, array $attribs, array $opts, array $filters, array $categories, array $vehicles, array $levels ) {
		$attributes = 
			$this->createAttribs( $core, $idx, $attribs ) + 
			$this->createOptions( $core, $idx, $opts ) + 
			( MegaFilterCore::hasFilters() ? $this->createFilters( $core, $idx, $filters ) : array() ) + 
			$this->createCategories( $core, $idx, $categories );
		
		if( ! empty( $vehicles['enabled'] ) ) {
			$attributes += $this->createVehicles( $idx, $core, $vehicles );
		
			if( ! empty( $attributes['vehicle']['options'] ) ) {
				list( $w, $h ) = $this->_imageSize();

				foreach( $attributes['vehicle']['options'] as $k => $v ) {
					if( isset( $v['image'] ) ) {
						$attributes['vehicle']['options'][$k]['image_w'] = $w;
						$attributes['vehicle']['options'][$k]['image_h'] = $h;
						$attributes['vehicle']['options'][$k]['image'] = self::parseUrl( empty( $v['image'] ) ? $this->model_tool_image->resize('no_image.png', $w, $h) : $this->model_tool_image->resize($v['image'], $w, $h) );
					}
				}
			}
		}
		
		if( ! empty( $levels['enabled'] ) ) {
			$attributes += $this->createLevels( $idx, $core, $levels );
		
			if( ! empty( $attributes['level']['options'] ) ) {
				list( $w, $h ) = $this->_imageSize();

				foreach( $attributes['level']['options'] as $k => $v ) {
					if( isset( $v['image'] ) ) {
						$attributes['level']['options'][$k]['image_w'] = $w;
						$attributes['level']['options'][$k]['image_h'] = $h;
						$attributes['level']['options'][$k]['image'] = self::parseUrl( empty( $v['image'] ) ? $this->model_tool_image->resize('no_image.png', $w, $h) : $this->model_tool_image->resize($v['image'], $w, $h) );
					}
				}
			}
		}
		
		/**
		 * Dodaj podstawowe atrybuty
		 */
		if( ! empty( $base_attribs ) ) {
			foreach( $base_attribs as $type => $attribute ) {
				if( empty( $attribute['enabled'] ) ) continue;
				if( $attribute['enabled'] == 'logged' && ! $this->customer->isLogged() ) continue;
				
				if( ( $type == 'search' || $type == 'search_oc' ) && ( isset( $this->request->get['search'] ) || in_array( $core->route(), MegaFilterCore::$_searchRoute ) ) ) {
					continue;
				}
				
				$attribute['type']					= isset( $attribute['display_as_type'] ) ? $attribute['display_as_type'] : $type;
				$attribute['base_type']				= $type;
				$attribute['id']					= $type;
				$attribute['sort_order']			= empty( $attribute['sort_order'] ) ? 0 : (int) $attribute['sort_order'];
				$attribute['name']					= $this->language->get( 'name_' . $type );
				$attribute['seo_name']				= $type;
				$attribute['collapsed']				= empty( $attribute['collapsed'] ) ? false : $attribute['collapsed'];
				$attribute['display_list_of_items']	= empty( $attribute['display_list_of_items'] ) ? '' : $attribute['display_list_of_items'];
				$attribute['display_live_filter']	= empty( $attribute['display_live_filter'] ) ? '' : $attribute['display_live_filter'];
				
				switch( $type ) {
					case 'manufacturers' : {
						if( NULL != ( $attribute['options'] = $this->getManufacturers( $core ) ) ) {
							if( in_array( $attribute['type'], array( 'image', 'image_radio', 'image_list_checkbox', 'image_list_radio' ) ) ) {
								list( $w, $h ) = $this->_imageSize();

								foreach( $attribute['options'] as $k => $v ) {
									$attribute['options'][$k]['image'] = self::parseUrl( empty( $v['image'] ) ? $this->model_tool_image->resize('no_image.png', $w, $h) : $this->model_tool_image->resize($v['image'], $w, $h) );

									if( empty( $attribute['options'][$k]['image'] ) ) {
										$attribute['options'][$k]['image'] = self::parseUrl( $this->model_tool_image->resize('no_image.png', $w, $h) );
									}
								}
							}
						}
						
						break;
					}
					case 'discounts' : {
						$attribute['options'] = $this->getDiscounts( $core );
						
						break;
					}
					case 'stock_status' : {
						$attribute['options'] = $this->getStockStatuses();
					
						break;
					}
					case 'location' :
					case 'length' :
					case 'width' :
					case 'height' :
					case 'weight' :
					case 'mpn' : 
					case 'isbn' :
					case 'sku' :
					case 'upc' :
					case 'ean' :
					case 'jan' :
					case 'model' : {
						$attribute['options'] = $this->getOptionsByType( $type, $core );
						
						break;
					}
					case 'tags' : {
						$attribute['options'] = $this->getTags( $core );
						
						break;
					}
				}
				
				if( ! empty( $attribute['options'] ) || in_array( $type, array( 'rating', 'price', 'search' ) ) ) {
					$attributes[] = $attribute;
				}
			}
		}
		
		/**
		 * Posortuj 
		 */
		usort( $attributes, array( 'ModelModuleMegaFilter', '_sortAttributes' ) );
		
		return $attributes;
	}
	
	/**
	 * Sortowanie atrybutów
	 * 
	 * @param type $a
	 * @param type $b
	 * @return int 
	 */
	private static function _sortAttributes( $a, $b ) {
		$sa = (int) ( isset( $a['sort_order-sec'] ) ? $a['sort_order-sec'] : $a['sort_order'] );
		$sb = (int) ( isset( $b['sort_order-sec'] ) ? $b['sort_order-sec'] : $b['sort_order'] );
		
		if( $sa < $sb )
			return -1;
		
		if( $sa > $sb )
			return 1;
		
		return 0;
	}
	
	/**
	 * Wyczyść adres URL
	 * 
	 * @param string $str
	 * @param bool $clearOn
	 * @return string 
	 */
	public function clear( $str, $clearOn = true ) {
		$str = str_replace(array(
			'`', '~', '!', '@', '#', '$', '%', '^', '*', '(', ')', '+', '=', '[', '{', ']', '}', '\\', '|', ';', ':', "'", '"', ',', '<', '.', '>', '/', '?'
		), ' ', str_replace(array(
			'&'
		), array(
			'and'
		), htmlspecialchars_decode( $str )) );		
		
		if( ! $clearOn )
			return mb_strtolower( trim( preg_replace( '/-+/', '-', preg_replace( '/ +/', '-', $str ) ), '-' ), 'utf-8' );
		
		$unPretty = array(
			'À', 'à', 'Á', 'á', 'Â', 'â', 'Ã', 'ã', 'Ä', 'ä', 'Å', 'å', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ǟ', 'ǟ', 'Ǻ', 'ǻ', 'Α', 'α', 'ъ',
			'Ḃ', 'ḃ', 'Б', 'б',
			'Ć', 'ć', 'Ç', 'ç', 'Č', 'č', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Ч', 'ч', 'Χ', 'χ',
			'Ḑ', 'ḑ', 'Ď', 'ď', 'Ḋ', 'ḋ', 'Đ', 'đ', 'Ð', 'ð', 'Д', 'д', 'Δ', 'δ',
			'Ǳ',  'ǲ', 'ǳ', 'Ǆ', 'ǅ', 'ǆ', 
			'È', 'è', 'É', 'é', 'Ě', 'ě', 'Ê', 'ê', 'Ë', 'ë', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ę', 'ę', 'Ė', 'ė', 'Ʒ', 'ʒ', 'Ǯ', 'ǯ', 'Е', 'е', 'Э', 'э', 'Ε', 'ε',
			'Ḟ', 'ḟ', 'ƒ', 'Ф', 'ф', 'Φ', 'φ',
			'ﬁ', 'ﬂ', 
			'Ǵ', 'ǵ', 'Ģ', 'ģ', 'Ǧ', 'ǧ', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ǥ', 'ǥ', 'Г', 'г', 'Γ', 'γ',
			'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ж', 'ж', 'Х', 'х',
			'Ì', 'ì', 'Í', 'í', 'Î', 'î', 'Ĩ', 'ĩ', 'Ï', 'ï', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'И', 'и', 'Η', 'η', 'Ι', 'ι',
			'Ĳ', 'ĳ', 
			'Ĵ', 'ĵ',
			'Ḱ', 'ḱ', 'Ķ', 'ķ', 'Ǩ', 'ǩ', 'К', 'к', 'Κ', 'κ',
			'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Л', 'л', 'Λ', 'λ',
			'Ǉ', 'ǈ', 'ǉ', 
			'Ṁ', 'ṁ', 'М', 'м', 'Μ', 'μ',
			'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'Ñ', 'ñ', 'ŉ', 'Ŋ', 'ŋ', 'Н', 'н', 'Ν', 'ν',
			'Ǌ', 'ǋ', 'ǌ', 
			'Ò', 'ò', 'Ó', 'ó', 'Ô', 'ô', 'Õ', 'õ', 'Ö', 'ö', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ø', 'ø', 'Ő', 'ő', 'Ǿ', 'ǿ', 'О', 'о', 'Ο', 'ο', 'Ω', 'ω',
			'Œ', 'œ', 
			'Ṗ', 'ṗ', 'П', 'п', 'Π', 'π',
			'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Р', 'р', 'Ρ', 'ρ', 'Ψ', 'ψ',
			'Ś', 'ś', 'Ş', 'ş', 'Š', 'š', 'Ŝ', 'ŝ', 'Ṡ', 'ṡ', 'ſ', 'ß', 'С', 'с', 'Ш', 'ш', 'Щ', 'щ', 'Σ', 'σ', 'ς',
			'Ţ', 'ţ', 'Ť', 'ť', 'Ṫ', 'ṫ', 'Ŧ', 'ŧ', 'Þ', 'þ', 'Т', 'т', 'Ц', 'ц', 'Θ', 'θ', 'Τ', 'τ',
			'Ù', 'ù', 'Ú', 'ú', 'Û', 'û', 'Ũ', 'ũ', 'Ü', 'ü', 'Ů', 'ů', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ų', 'ų', 'Ű', 'ű', 'У', 'у',
			'В', 'в', 'Β', 'β',
			'Ẁ', 'ẁ', 'Ẃ', 'ẃ', 'Ŵ', 'ŵ', 'Ẅ', 'ẅ',
			'Ξ', 'ξ',
			'Ỳ', 'ỳ', 'Ý', 'ý', 'Ŷ', 'ŷ', 'Ÿ', 'ÿ', 'Й', 'й', 'Ы', 'ы', 'Ю', 'ю', 'Я', 'я', 'Υ', 'υ',
			'Ź', 'ź', 'Ž', 'ž', 'Ż', 'ż', 'З', 'з', 'Ζ', 'ζ',
			'Æ', 'æ', 'Ǽ', 'ǽ', 'а', 'А'
		);
		$pretty   = array(
			'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A',
			'B', 'b', 'B', 'b',
			'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'CH', 'ch', 'CH', 'ch',
			'D', 'd', 'D', 'd', 'D', 'd', 'D', 'd', 'D', 'd', 'D', 'd', 'D', 'd',
			'DZ', 'Dz', 'dz', 'DZ', 'Dz', 'dz',
			'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e',
			'F', 'f', 'f', 'F', 'f', 'F', 'f',
			'fi', 'fl',
			'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g',
			'H', 'h', 'H', 'h', 'ZH', 'zh', 'H', 'h',
			'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i',
			'IJ', 'ij',
			'J', 'j',
			'K', 'k', 'K', 'k', 'K', 'k', 'K', 'k', 'K', 'k',
			'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l',
			'LJ', 'Lj', 'lj',
			'M', 'm', 'M', 'm', 'M', 'm',
			'N', 'n', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'N', 'n', 'N', 'n', 'N', 'n',
			'NJ', 'Nj', 'nj',
			'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o',
			'OE', 'oe',
			'P', 'p', 'P', 'p', 'P', 'p', 'PS', 'ps',
			'R', 'r', 'R', 'r', 'R', 'r', 'R', 'r', 'R', 'r',
			'S', 's', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 's', 'ss', 'S', 's', 'SH', 'sh', 'SHCH', 'shch', 'S', 's', 's',
			'T', 't', 'T', 't', 'T', 't', 'T', 't', 'T', 't', 'T', 't', 'TS', 'ts', 'TH', 'th', 'T', 't',
			'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u',
			'V', 'v', 'V', 'v',
			'W', 'w', 'W', 'w', 'W', 'w', 'W', 'w',
			'X', 'x',
			'Y', 'y', 'Y', 'y', 'Y', 'y', 'Y', 'y', 'Y', 'y', 'Y', 'y', 'YU', 'yu', 'YA', 'ya', 'Y', 'y',
			'Z', 'z', 'Z', 'z', 'Z', 'z', 'Z', 'z', 'Z', 'z',
			'AE', 'ae', 'AE', 'ae', 'a', 'A'
		);
		
		$str = mb_strtolower( str_replace( $unPretty, $pretty, $str ), 'utf-8' );
		$str = trim( preg_replace('/[^A-Z^a-z^0-9]+/','-', $str), '-');
		return preg_replace( '/-+/', '-', $str );
	}
}