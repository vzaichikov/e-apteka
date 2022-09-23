<?php
class ModelCatalogSocialprogram extends Model {
	public function addSocialprogram($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "socialprogram SET parent_id = '" . (int)$data['parent_id'] . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', list = '" . (int)$data['list'] . "', sync_name = '" . $this->db->escape($data['sync_name']) . "', date_modified = NOW(), date_added = NOW()");

		$socialprogram_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "socialprogram SET image = '" . $this->db->escape($data['image']) . "' WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");
		}

		foreach ($data['socialprogram_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "socialprogram_description SET socialprogram_id = '" . (int)$socialprogram_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', banner = '" . $this->db->escape($value['banner']) . "', description = '" . $this->db->escape($value['description']) . "', mini_description = '" . $this->db->escape($value['mini_description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "socialprogram_path` WHERE socialprogram_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "socialprogram_path` SET `socialprogram_id` = '" . (int)$socialprogram_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "socialprogram_path` SET `socialprogram_id` = '" . (int)$socialprogram_id . "', `path_id` = '" . (int)$socialprogram_id . "', `level` = '" . (int)$level . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_socialprogram WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");
		
		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_socialprogram SET product_id = '" . (int)$product_id . "', socialprogram_id = '" . (int)$socialprogram_id . "', main_socialprogram = 1");
			}
		}

		if (isset($data['socialprogram_filter'])) {
			foreach ($data['socialprogram_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "socialprogram_filter SET socialprogram_id = '" . (int)$socialprogram_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['socialprogram_store'])) {
			foreach ($data['socialprogram_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "socialprogram_to_store SET socialprogram_id = '" . (int)$socialprogram_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// Set which layout to use with this socialprogram
		if (isset($data['socialprogram_layout'])) {
			foreach ($data['socialprogram_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "socialprogram_to_layout SET socialprogram_id = '" . (int)$socialprogram_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'socialprogram_id=" . (int)$socialprogram_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('socialprogram');

		return $socialprogram_id;
	}

	public function editSocialprogram($socialprogram_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "socialprogram SET parent_id = '" . (int)$data['parent_id'] . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', list = '" . (int)$data['list'] . "', sync_name = '" . $this->db->escape($data['sync_name']) . "', date_modified = NOW() WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "socialprogram SET image = '" . $this->db->escape($data['image']) . "' WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "socialprogram_description WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");

		foreach ($data['socialprogram_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "socialprogram_description SET socialprogram_id = '" . (int)$socialprogram_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', banner = '" . $this->db->escape($value['banner']) . "', description = '" . $this->db->escape($value['description']) . "', mini_description = '" . $this->db->escape($value['mini_description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "socialprogram_path` WHERE path_id = '" . (int)$socialprogram_id . "' ORDER BY level ASC");

		if ($query->rows) {
			foreach ($query->rows as $socialprogram_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "socialprogram_path` WHERE socialprogram_id = '" . (int)$socialprogram_path['socialprogram_id'] . "' AND level < '" . (int)$socialprogram_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "socialprogram_path` WHERE socialprogram_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "socialprogram_path` WHERE socialprogram_id = '" . (int)$socialprogram_path['socialprogram_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "socialprogram_path` SET socialprogram_id = '" . (int)$socialprogram_path['socialprogram_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "socialprogram_path` WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "socialprogram_path` WHERE socialprogram_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "socialprogram_path` SET socialprogram_id = '" . (int)$socialprogram_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "socialprogram_path` SET socialprogram_id = '" . (int)$socialprogram_id . "', `path_id` = '" . (int)$socialprogram_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "socialprogram_filter WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");

		if (isset($data['socialprogram_filter'])) {
			foreach ($data['socialprogram_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "socialprogram_filter SET socialprogram_id = '" . (int)$socialprogram_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_socialprogram WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");
		
		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_socialprogram SET product_id = '" . (int)$product_id . "', socialprogram_id = '" . (int)$socialprogram_id . "', main_socialprogram = 1");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "socialprogram_to_store WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");

		if (isset($data['socialprogram_store'])) {
			foreach ($data['socialprogram_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "socialprogram_to_store SET socialprogram_id = '" . (int)$socialprogram_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "socialprogram_to_layout WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");

		if (isset($data['socialprogram_layout'])) {
			foreach ($data['socialprogram_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "socialprogram_to_layout SET socialprogram_id = '" . (int)$socialprogram_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'socialprogram_id=" . (int)$socialprogram_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'socialprogram_id=" . (int)$socialprogram_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('socialprogram');
	}

	public function deleteSocialprogram($socialprogram_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "socialprogram_path WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "socialprogram_path WHERE path_id = '" . (int)$socialprogram_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteSocialprogram($result['socialprogram_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "socialprogram WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "socialprogram_description WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "socialprogram_filter WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "socialprogram_to_store WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "socialprogram_to_layout WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_socialprogram WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'socialprogram_id=" . (int)$socialprogram_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_socialprogram WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");

		$this->cache->delete('socialprogram');
	}

	public function repairSocialprograms($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "socialprogram WHERE parent_id = '" . (int)$parent_id . "'");

		foreach ($query->rows as $socialprogram) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "socialprogram_path` WHERE socialprogram_id = '" . (int)$socialprogram['socialprogram_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "socialprogram_path` WHERE socialprogram_id = '" . (int)$parent_id . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "socialprogram_path` SET socialprogram_id = '" . (int)$socialprogram['socialprogram_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "socialprogram_path` SET socialprogram_id = '" . (int)$socialprogram['socialprogram_id'] . "', `path_id` = '" . (int)$socialprogram['socialprogram_id'] . "', level = '" . (int)$level . "'");

			$this->repairSocialprograms($socialprogram['socialprogram_id']);
		}
	}

	public function getSocialprogram($socialprogram_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "socialprogram_path cp LEFT JOIN " . DB_PREFIX . "socialprogram_description cd1 ON (cp.path_id = cd1.socialprogram_id AND cp.socialprogram_id != cp.path_id) WHERE cp.socialprogram_id = c.socialprogram_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.socialprogram_id) AS path, (SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'socialprogram_id=" . (int)$socialprogram_id . "') AS keyword FROM " . DB_PREFIX . "socialprogram c LEFT JOIN " . DB_PREFIX . "socialprogram_description cd2 ON (c.socialprogram_id = cd2.socialprogram_id) WHERE c.socialprogram_id = '" . (int)$socialprogram_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	
	public function getSocialprogramProducts($socialprogram_id) {
		$product_socialprogram_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_socialprogram WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");

		foreach ($query->rows as $result) {
			$product_socialprogram_data[] = $result['product_id'];
		}

		return $product_socialprogram_data;
	}

	public function getSocialprogramsByParentId($parent_id = 0) {
		$query = $this->db->query("SELECT *, md.name as manufacturer, (SELECT COUNT(parent_id) FROM " . DB_PREFIX . "socialprogram WHERE parent_id = c.socialprogram_id) AS children FROM " . DB_PREFIX . "socialprogram c 
		LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (c.manufacturer_id = md.manufacturer_id AND md.language_id = '" . (int)$this->config->get('config_language_id') . "')
		LEFT JOIN " . DB_PREFIX . "socialprogram_description cd ON (c.socialprogram_id = cd.socialprogram_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 		
		ORDER BY c.sort_order, cd.name");

		return $query->rows;
	}

	public function getSocialprograms($data = array()) {
		$sql = "SELECT cp.socialprogram_id AS socialprogram_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, md.name as manufacturer, c1.parent_id, c1.sort_order, c1.status,(select count(product_id) as product_count from " . DB_PREFIX . "product_to_socialprogram pc where pc.socialprogram_id = c1.socialprogram_id) as product_count FROM " . DB_PREFIX . "socialprogram_path cp 
		LEFT JOIN " . DB_PREFIX . "socialprogram c1 ON (cp.socialprogram_id = c1.socialprogram_id) 
		LEFT JOIN " . DB_PREFIX . "socialprogram c2 ON (cp.path_id = c2.socialprogram_id)
		LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (c1.manufacturer_id = md.manufacturer_id AND md.language_id = '" . (int)$this->config->get('config_language_id') . "')
		LEFT JOIN " . DB_PREFIX . "socialprogram_description cd1 ON (cp.path_id = cd1.socialprogram_id) 
		LEFT JOIN " . DB_PREFIX . "socialprogram_description cd2 ON (cp.socialprogram_id = cd2.socialprogram_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cp.socialprogram_id";

		$sort_data = array(
			'product_count',
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getSocialprogramDescriptions($socialprogram_id) {
		$socialprogram_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "socialprogram_description WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");

		foreach ($query->rows as $result) {
			$socialprogram_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'banner'           => $result['banner'],
				'meta_title'       => $result['meta_title'],
				'meta_h1'          => $result['meta_h1'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description'],
				'mini_description' => $result['mini_description']
			);
		}

		return $socialprogram_description_data;
	}
	
	public function getSocialprogramPath($socialprogram_id) {
		$query = $this->db->query("SELECT socialprogram_id, path_id, level FROM " . DB_PREFIX . "socialprogram_path WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");

		return $query->rows;
	}
	
	public function getSocialprogramFilters($socialprogram_id) {
		$socialprogram_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "socialprogram_filter WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");

		foreach ($query->rows as $result) {
			$socialprogram_filter_data[] = $result['filter_id'];
		}

		return $socialprogram_filter_data;
	}

	public function getSocialprogramStores($socialprogram_id) {
		$socialprogram_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "socialprogram_to_store WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");

		foreach ($query->rows as $result) {
			$socialprogram_store_data[] = $result['store_id'];
		}

		return $socialprogram_store_data;
	}

	public function getSocialprogramLayouts($socialprogram_id) {
		$socialprogram_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "socialprogram_to_layout WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");

		foreach ($query->rows as $result) {
			$socialprogram_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $socialprogram_layout_data;
	}

	public function getTotalSocialprograms() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "socialprogram");

		return $query->row['total'];
	}

	public function getAllSocialprograms() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "socialprogram c LEFT JOIN " . DB_PREFIX . "socialprogram_description cd ON (c.socialprogram_id = cd.socialprogram_id) LEFT JOIN " . DB_PREFIX . "socialprogram_to_store c2s ON (c.socialprogram_id = c2s.socialprogram_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  ORDER BY c.parent_id, c.sort_order, cd.name");

		$socialprogram_data = array();
		foreach ($query->rows as $row) {
			$socialprogram_data[$row['parent_id']][$row['socialprogram_id']] = $row;
		}

		return $socialprogram_data;
	}
	
	public function getTotalSocialprogramsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "socialprogram_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}
