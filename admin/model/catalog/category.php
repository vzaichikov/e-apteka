<?php
	class ModelCatalogCategory extends Model {
		public function addCategory($data) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', uuid = '" . $this->db->escape($data['uuid']) . "', sort_order = '" . (int)$data['sort_order'] . "', banner = '" . (int)$data['banner'] . "', status_widget = '" . (int)$data['status_widget'] . "', is_searched = '" . (int)$data['is_searched'] . "', show_subcats = '" . (int)$data['show_subcats'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");
			
			$category_id = $this->db->getLastId();
			
			if (isset($data['image'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int)$category_id . "'");
			}
			
			if (isset($data['icon'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "category SET icon = '" . $this->db->escape($data['icon']) . "' WHERE category_id = '" . (int)$category_id . "'");
			}
			
			if (isset($data['no_payment'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "category SET no_payment = '" . (int)$data['no_payment'] . "' WHERE category_id = '" . (int)$category_id . "'");
			}
			
			if (isset($data['no_shipping'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "category SET no_shipping = '" . (int)$data['no_shipping'] . "' WHERE category_id = '" . (int)$category_id . "'");
			}
			
			foreach ($data['category_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', alternate_name = '" . $this->db->escape($value['alternate_name']) . "', normalized_name = '" . $this->db->escape(normalizeString($value['name'])) . "',  soundex_name = '" . $this->db->escape(transSoundex($value['name'])) . "', seo_name = '" . $this->db->escape($value['seo_name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', faq_name = '" . $this->db->escape($value['faq_name']) . "'");
			}
			if (isset($data['category_banner'])) {
				foreach ($data['category_banner'] as $cat_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_banners SET parent_id = '" . (int)$category_id . "', category_id='" . (int)$cat_id . "'");
					$this->db->query("UPDATE " . DB_PREFIX . "category SET banner = '" . (int)$data['banner'] . "' WHERE category_id = '" . (int)$cat_id . "'");
				}
			}
			// MySQL Hierarchical Data Closure Table Pattern
			$level = 0;
			
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");
			
			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");
				
				$level++;
			}
			
			$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', `level` = '" . (int)$level . "'");
			
			if (isset($data['category_filter'])) {
				foreach ($data['category_filter'] as $filter_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_filter SET category_id = '" . (int)$category_id . "', filter_id = '" . (int)$filter_id . "'");
				}
			}
			
			if (isset($data['category_store'])) {
				foreach ($data['category_store'] as $store_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
				}
			}
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "category_faq WHERE category_id = '" . (int)$category_id . "'");
			
			if (isset($data['category_faq'])) {
				foreach ($data['category_faq'] as $category_faq) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_faq SET category_id = '" . (int)$category_id . "', `question` = '" . serialize(removeApostrophe($category_faq['question'])) . "', `faq` = '" . serialize(removeApostrophe($category_faq['faq'])) . "', `icon` = '" . $this->db->escape($category_faq['icon']) . "', `sort_order` = '" . (int)$category_faq['sort_order'] . "'");
				}
			} 
			
			// Set which layout to use with this category
			if (isset($data['category_layout'])) {
				foreach ($data['category_layout'] as $store_id => $layout_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_layout SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
				}
			}
			
			if (isset($data['keyword'])) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
			}
			
			//GOOGLE
			$this->db->query("DELETE FROM " . DB_PREFIX . "google_base_category_to_category WHERE category_id = '" . (int)$category_id . "'");
			
			if (!empty($data['google_base_category_id'])){
				$this->load->model('extension/feed/google_base');
				$data['category_id'] = $category_id;
				$this->model_extension_feed_google_base->addCategory($data);
			}
			
			$this->cache->delete('category');
			
			return $category_id;
		}
		
		public function editCategory($category_id, $data) {
			
			$this->db->query("UPDATE " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', uuid = '" . $this->db->escape($data['uuid']) . "', sort_order = '" . (int)$data['sort_order'] . "', banner = '" . (int)$data['banner'] . "', status_widget = '" . (int)$data['status_widget'] . "', is_searched = '" . (int)$data['is_searched'] . "', show_subcats = '" . (int)$data['show_subcats'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");
			
			if (isset($data['image'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int)$category_id . "'");
			}
			
			if (isset($data['icon'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "category SET icon = '" . $this->db->escape($data['icon']) . "' WHERE category_id = '" . (int)$category_id . "'");
			}
			
			if (isset($data['no_payment'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "category SET no_payment = '" . (int)$data['no_payment'] . "' WHERE category_id = '" . (int)$category_id . "'");
			}
			
			if (isset($data['no_shipping'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "category SET no_shipping = '" . (int)$data['no_shipping'] . "' WHERE category_id = '" . (int)$category_id . "'");
			}
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
			
			foreach ($data['category_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', alternate_name = '" . $this->db->escape($value['alternate_name']) . "', normalized_name = '" . $this->db->escape(normalizeString($value['name'])) . "',  soundex_name = '" . $this->db->escape(transSoundex($value['name'])) . "', seo_name = '" . $this->db->escape($value['seo_name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', faq_name = '" . $this->db->escape($value['faq_name']) . "'");
			}
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "category_banners WHERE parent_id = '" . (int)$category_id . "'");
			if (isset($data['category_banner'])) {
				foreach ($data['category_banner'] as $cat_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_banners SET parent_id = '" . (int)$category_id . "', category_id='" . (int)$cat_id . "'");
					$this->db->query("UPDATE " . DB_PREFIX . "category SET banner = '" . (int)$data['banner'] . "' WHERE category_id = '" . (int)$cat_id . "'");
				}
			}
			// MySQL Hierarchical Data Closure Table Pattern
			if (empty($data['no_fucken_path'])) {
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE path_id = '" . (int)$category_id . "' ORDER BY level ASC");
				
				if ($query->rows) {
					foreach ($query->rows as $category_path) {
						// Delete the path below the current one
						$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_path['category_id'] . "' AND level < '" . (int)$category_path['level'] . "'");
						
						$path = array();
						
						// Get the nodes new parents
						$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");
						
						foreach ($query->rows as $result) {
							$path[] = $result['path_id'];
						}
						
						// Get whats left of the nodes current path
						$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_path['category_id'] . "' ORDER BY level ASC");
						
						foreach ($query->rows as $result) {
							$path[] = $result['path_id'];
						}
						
						// Combine the paths with a new level
						$level = 0;
						
						foreach ($path as $path_id) {
							$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_path['category_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");
							
							$level++;
						}
					}
					} else {
					// Delete the path below the current one
					$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_id . "'");
					
					// Fix for records with no paths
					$level = 0;
					
					$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");
					
					foreach ($query->rows as $result) {
						$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");
						
						$level++;
					}
					
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', level = '" . (int)$level . "'");
				}
			}
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");
			
			if (isset($data['category_filter'])) {
				foreach ($data['category_filter'] as $filter_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_filter SET category_id = '" . (int)$category_id . "', filter_id = '" . (int)$filter_id . "'");
				}
			}
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "category_faq WHERE category_id = '" . (int)$category_id . "'");
			
			if (isset($data['category_faq'])) {
				foreach ($data['category_faq'] as $category_faq) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_faq SET category_id = '" . (int)$category_id . "', `question` = '" . serialize(removeApostrophe($category_faq['question'])) . "', `faq` = '" . serialize(removeApostrophe($category_faq['faq'])) . "', `icon` = '" . $this->db->escape($category_faq['icon']) . "', `sort_order` = '" . (int)$category_faq['sort_order'] . "'");
				}
			} 
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");
			
			if (isset($data['category_store'])) {
				foreach ($data['category_store'] as $store_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
				}
			}
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");
			
			if (isset($data['category_layout'])) {
				foreach ($data['category_layout'] as $store_id => $layout_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_layout SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
				}
			}
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "'");
			
			if ($data['keyword']) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
			}
			
			//GOOGLE
			$this->db->query("DELETE FROM " . DB_PREFIX . "google_base_category_to_category WHERE category_id = '" . (int)$category_id . "'");
			
			if (!empty($data['google_base_category_id'])){
				$this->load->model('extension/feed/google_base');
				$data['category_id'] = $category_id;
				$this->model_extension_feed_google_base->addCategory($data);
			}
			
			$this->cache->delete('category');
		}
		
		public function deleteCategory($category_id) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "category_path WHERE category_id = '" . (int)$category_id . "'");
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_path WHERE path_id = '" . (int)$category_id . "'");
			
			foreach ($query->rows as $result) {
				$this->deleteCategory($result['category_id']);
			}
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$category_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_category WHERE category_id = '" . (int)$category_id . "'");
			
			$this->cache->delete('category');
		}
		
		public function repairCategories($parent_id = 0) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$parent_id . "'");
			
			foreach ($query->rows as $category) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category['category_id'] . "'");
				
				// Fix for records with no paths
				$level = 0;
				
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$parent_id . "' ORDER BY level ASC");
				
				foreach ($query->rows as $result) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");
					
					$level++;
				}
				
				$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$category['category_id'] . "', level = '" . (int)$level . "'");
				
				$this->repairCategories($category['category_id']);
			}
		}
		
		public function getCategory($category_id) {
			$query = $this->db->query("SELECT DISTINCT *, (SELECT google_base_category_id FROM " . DB_PREFIX . "google_base_category_to_category WHERE category_id = c.category_id LIMIT 1) as google_base_category_id, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id AND cp.category_id != cp.path_id) WHERE cp.category_id = c.category_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.category_id) AS path, (SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "') AS keyword FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (c.category_id = cd2.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");
			
			return $query->row;
		}
		
		
		public function getCategoryInfo($category_id) {
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id='" . (int)$category_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
			
			return $query->row;
		}
		public function getCategoryBanners($category_id) {
			$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category_banners WHERE parent_id='" . (int)$category_id . "'");
			return $query->rows;
		}
		
		public function getCategoryFaq($category_id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_faq WHERE category_id = '" . (int)$category_id . "' ORDER BY sort_order ASC");
			return $query->rows;
		}
		
		public function getCategories($data = array()) {
			$sql = "SELECT c1.banner, cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, cd1.alternate_name,  c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id) LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			
			if (!empty($data['filter_name'])) {
				$sql .= " AND cd2.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
			}
			if (!empty($data['category_id'])) {
				$sql .= " AND c1.parent_id= '" . (int)$data['category_id'] . "'";
			}
			
			$sql .= " GROUP BY cp.category_id";
			
			$sort_data = array(
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
		
		public function getCategoryDescriptions($category_id) {
			$category_description_data = array();
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
			
			foreach ($query->rows as $result) {
				$category_description_data[$result['language_id']] = array(
                'name'             => $result['name'],
				'seo_name'         => $result['seo_name'],
				'alternate_name'   => $result['alternate_name'],
                'meta_title'       => $result['meta_title'],
                'meta_description' => $result['meta_description'],
                'meta_keyword'     => $result['meta_keyword'],
                'description'      => $result['description'],
				'faq_name'     	   => $result['faq_name']
				);
			}
			
			return $category_description_data;
		}
		
		
		
		public function getCategoryPath($category_id) {
			$query = $this->db->query("SELECT category_id, path_id, level FROM " . DB_PREFIX . "category_path WHERE category_id = '" . (int)$category_id . "'");
			
			return $query->rows;
		}
		
		public function getCategoryFilters($category_id) {
			$category_filter_data = array();
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");
			
			foreach ($query->rows as $result) {
				$category_filter_data[] = $result['filter_id'];
			}
			
			return $category_filter_data;
		}
		
		public function getCategoryStores($category_id) {
			$category_store_data = array();
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");
			
			foreach ($query->rows as $result) {
				$category_store_data[] = $result['store_id'];
			}
			
			return $category_store_data;
		}
		
		public function getCategoryLayouts($category_id) {
			$category_layout_data = array();
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");
			
			foreach ($query->rows as $result) {
				$category_layout_data[$result['store_id']] = $result['layout_id'];
			}
			
			return $category_layout_data;
		}
		
		public function getTotalCategories() {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category");
			
			return $query->row['total'];
		}
		
		public function getTotalCategoriesByLayoutId($layout_id) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");
			
			return $query->row['total'];
		}
	}
