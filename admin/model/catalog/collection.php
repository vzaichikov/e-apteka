<?php
class ModelCatalogCollection extends Model {
	public function addCollection($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "collection SET parent_id = '" . (int)$data['parent_id'] . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', list = '" . (int)$data['list'] . "', date_modified = NOW(), date_added = NOW()");

		$collection_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "collection SET image = '" . $this->db->escape($data['image']) . "' WHERE collection_id = '" . (int)$collection_id . "'");
		}

		foreach ($data['collection_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "collection_description SET collection_id = '" . (int)$collection_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', alternate_name = '" . $this->db->escape($value['alternate_name']) . "', normalized_name = '" . $this->db->escape(normalizeString($value['name'])) . "',  soundex_name = '" . $this->db->escape(transSoundex($value['name'])) . "', banner = '" . $this->db->escape($value['banner']) . "', description = '" . $this->db->escape($value['description']) . "', mini_description = '" . $this->db->escape($value['mini_description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "collection_path` WHERE collection_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "collection_path` SET `collection_id` = '" . (int)$collection_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "collection_path` SET `collection_id` = '" . (int)$collection_id . "', `path_id` = '" . (int)$collection_id . "', `level` = '" . (int)$level . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_collection WHERE collection_id = '" . (int)$collection_id . "'");
		
		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_collection SET product_id = '" . (int)$product_id . "', collection_id = '" . (int)$collection_id . "', main_collection = 1");
			}
		}

		if (isset($data['collection_filter'])) {
			foreach ($data['collection_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "collection_filter SET collection_id = '" . (int)$collection_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['collection_store'])) {
			foreach ($data['collection_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "collection_to_store SET collection_id = '" . (int)$collection_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// Set which layout to use with this collection
		if (isset($data['collection_layout'])) {
			foreach ($data['collection_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "collection_to_layout SET collection_id = '" . (int)$collection_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'collection_id=" . (int)$collection_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('collection');

		return $collection_id;
	}

	public function editCollection($collection_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "collection SET parent_id = '" . (int)$data['parent_id'] . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', list = '" . (int)$data['list'] . "', date_modified = NOW() WHERE collection_id = '" . (int)$collection_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "collection SET image = '" . $this->db->escape($data['image']) . "' WHERE collection_id = '" . (int)$collection_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "collection_description WHERE collection_id = '" . (int)$collection_id . "'");

		foreach ($data['collection_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "collection_description SET collection_id = '" . (int)$collection_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', alternate_name = '" . $this->db->escape($value['alternate_name']) . "', normalized_name = '" . $this->db->escape(normalizeString($value['name'])) . "',  soundex_name = '" . $this->db->escape(transSoundex($value['name'])) . "', banner = '" . $this->db->escape($value['banner']) . "', description = '" . $this->db->escape($value['description']) . "', mini_description = '" . $this->db->escape($value['mini_description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "collection_path` WHERE path_id = '" . (int)$collection_id . "' ORDER BY level ASC");

		if ($query->rows) {
			foreach ($query->rows as $collection_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "collection_path` WHERE collection_id = '" . (int)$collection_path['collection_id'] . "' AND level < '" . (int)$collection_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "collection_path` WHERE collection_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "collection_path` WHERE collection_id = '" . (int)$collection_path['collection_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "collection_path` SET collection_id = '" . (int)$collection_path['collection_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "collection_path` WHERE collection_id = '" . (int)$collection_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "collection_path` WHERE collection_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "collection_path` SET collection_id = '" . (int)$collection_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "collection_path` SET collection_id = '" . (int)$collection_id . "', `path_id` = '" . (int)$collection_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "collection_filter WHERE collection_id = '" . (int)$collection_id . "'");

		if (isset($data['collection_filter'])) {
			foreach ($data['collection_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "collection_filter SET collection_id = '" . (int)$collection_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_collection WHERE collection_id = '" . (int)$collection_id . "'");
		
		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_collection SET product_id = '" . (int)$product_id . "', collection_id = '" . (int)$collection_id . "', main_collection = 1");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "collection_to_store WHERE collection_id = '" . (int)$collection_id . "'");

		if (isset($data['collection_store'])) {
			foreach ($data['collection_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "collection_to_store SET collection_id = '" . (int)$collection_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "collection_to_layout WHERE collection_id = '" . (int)$collection_id . "'");

		if (isset($data['collection_layout'])) {
			foreach ($data['collection_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "collection_to_layout SET collection_id = '" . (int)$collection_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'collection_id=" . (int)$collection_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'collection_id=" . (int)$collection_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('collection');
	}

	public function deleteCollection($collection_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "collection_path WHERE collection_id = '" . (int)$collection_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "collection_path WHERE path_id = '" . (int)$collection_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCollection($result['collection_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "collection WHERE collection_id = '" . (int)$collection_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "collection_description WHERE collection_id = '" . (int)$collection_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "collection_filter WHERE collection_id = '" . (int)$collection_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "collection_to_store WHERE collection_id = '" . (int)$collection_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "collection_to_layout WHERE collection_id = '" . (int)$collection_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_collection WHERE collection_id = '" . (int)$collection_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'collection_id=" . (int)$collection_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_collection WHERE collection_id = '" . (int)$collection_id . "'");

		$this->cache->delete('collection');
	}

	public function repairCollections($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "collection WHERE parent_id = '" . (int)$parent_id . "'");

		foreach ($query->rows as $collection) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "collection_path` WHERE collection_id = '" . (int)$collection['collection_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "collection_path` WHERE collection_id = '" . (int)$parent_id . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "collection_path` SET collection_id = '" . (int)$collection['collection_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "collection_path` SET collection_id = '" . (int)$collection['collection_id'] . "', `path_id` = '" . (int)$collection['collection_id'] . "', level = '" . (int)$level . "'");

			$this->repairCollections($collection['collection_id']);
		}
	}

	public function getCollection($collection_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "collection_path cp LEFT JOIN " . DB_PREFIX . "collection_description cd1 ON (cp.path_id = cd1.collection_id AND cp.collection_id != cp.path_id) WHERE cp.collection_id = c.collection_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.collection_id) AS path, (SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'collection_id=" . (int)$collection_id . "') AS keyword FROM " . DB_PREFIX . "collection c LEFT JOIN " . DB_PREFIX . "collection_description cd2 ON (c.collection_id = cd2.collection_id) WHERE c.collection_id = '" . (int)$collection_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	
	public function getCollectionProducts($collection_id) {
		$product_collection_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_collection WHERE collection_id = '" . (int)$collection_id . "'");

		foreach ($query->rows as $result) {
			$product_collection_data[] = $result['product_id'];
		}

		return $product_collection_data;
	}

	public function getCollectionsByParentId($parent_id = 0) {
		$query = $this->db->query("SELECT *, md.name as manufacturer, (SELECT COUNT(parent_id) FROM " . DB_PREFIX . "collection WHERE parent_id = c.collection_id) AS children FROM " . DB_PREFIX . "collection c 
		LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (c.manufacturer_id = md.manufacturer_id AND md.language_id = '" . (int)$this->config->get('config_language_id') . "')
		LEFT JOIN " . DB_PREFIX . "collection_description cd ON (c.collection_id = cd.collection_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 		
		ORDER BY c.sort_order, cd.name");

		return $query->rows;
	}

	public function getCollections($data = array()) {
		$sql = "SELECT cp.collection_id AS collection_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, cd1.alternate_name,  md.name as manufacturer, c1.parent_id, c1.sort_order, c1.status,(select count(product_id) as product_count from " . DB_PREFIX . "product_to_collection pc where pc.collection_id = c1.collection_id) as product_count FROM " . DB_PREFIX . "collection_path cp 
		LEFT JOIN " . DB_PREFIX . "collection c1 ON (cp.collection_id = c1.collection_id) 
		LEFT JOIN " . DB_PREFIX . "collection c2 ON (cp.path_id = c2.collection_id)
		LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (c1.manufacturer_id = md.manufacturer_id AND md.language_id = '" . (int)$this->config->get('config_language_id') . "')
		LEFT JOIN " . DB_PREFIX . "collection_description cd1 ON (cp.path_id = cd1.collection_id) 
		LEFT JOIN " . DB_PREFIX . "collection_description cd2 ON (cp.collection_id = cd2.collection_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cp.collection_id";

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

	public function getCollectionDescriptions($collection_id) {
		$collection_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "collection_description WHERE collection_id = '" . (int)$collection_id . "'");

		foreach ($query->rows as $result) {
			$collection_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'banner'           => $result['banner'],
				'alternate_name'   => $result['alternate_name'],
				'meta_title'       => $result['meta_title'],
				'meta_h1'          => $result['meta_h1'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description'],
				'mini_description' => $result['mini_description']
			);
		}

		return $collection_description_data;
	}
	
	public function getCollectionPath($collection_id) {
		$query = $this->db->query("SELECT collection_id, path_id, level FROM " . DB_PREFIX . "collection_path WHERE collection_id = '" . (int)$collection_id . "'");

		return $query->rows;
	}
	
	public function getCollectionFilters($collection_id) {
		$collection_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "collection_filter WHERE collection_id = '" . (int)$collection_id . "'");

		foreach ($query->rows as $result) {
			$collection_filter_data[] = $result['filter_id'];
		}

		return $collection_filter_data;
	}

	public function getCollectionStores($collection_id) {
		$collection_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "collection_to_store WHERE collection_id = '" . (int)$collection_id . "'");

		foreach ($query->rows as $result) {
			$collection_store_data[] = $result['store_id'];
		}

		return $collection_store_data;
	}

	public function getCollectionLayouts($collection_id) {
		$collection_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "collection_to_layout WHERE collection_id = '" . (int)$collection_id . "'");

		foreach ($query->rows as $result) {
			$collection_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $collection_layout_data;
	}

	public function getTotalCollections() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "collection");

		return $query->row['total'];
	}

	public function getAllCollections() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "collection c LEFT JOIN " . DB_PREFIX . "collection_description cd ON (c.collection_id = cd.collection_id) LEFT JOIN " . DB_PREFIX . "collection_to_store c2s ON (c.collection_id = c2s.collection_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  ORDER BY c.parent_id, c.sort_order, cd.name");

		$collection_data = array();
		foreach ($query->rows as $row) {
			$collection_data[$row['parent_id']][$row['collection_id']] = $row;
		}

		return $collection_data;
	}
	
	public function getTotalCollectionsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "collection_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}
