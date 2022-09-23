<?php
	class ModelCatalogCategory extends Model {
		public function getCategory($category_id) {
			$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");
			
			return $query->row;
		}
		
		public function getCategories($parent_id = 0) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");
			
			return $query->rows;
		}
		
		
		public function getCategoriesForElasticGenerateCache() {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE  cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' AND c.parent_id != '1' ORDER BY c.sort_order, LCASE(cd.name)");
			
			return $query->rows;
		}
		
		
		public function getCategoryFilters($category_id) {
			$implode = array();
			
			$query = $this->db->query("SELECT filter_id FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");
			
			foreach ($query->rows as $result) {
				$implode[] = (int)$result['filter_id'];
			}
			
			$filter_group_data = array();
			
			if ($implode) {
				$filter_group_query = $this->db->query("SELECT DISTINCT f.filter_group_id, fgd.name, fg.sort_order FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_group fg ON (f.filter_group_id = fg.filter_group_id) LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY f.filter_group_id ORDER BY fg.sort_order, LCASE(fgd.name)");
				
				foreach ($filter_group_query->rows as $filter_group) {
					$filter_data = array();
					
					$filter_query = $this->db->query("SELECT DISTINCT f.filter_id, fd.name FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND f.filter_group_id = '" . (int)$filter_group['filter_group_id'] . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY f.sort_order, LCASE(fd.name)");
					
					foreach ($filter_query->rows as $filter) {
						$filter_data[] = array(
                        'filter_id' => $filter['filter_id'],
                        'name'      => $filter['name']
						);
					}
					
					if ($filter_data) {
						$filter_group_data[] = array(
                        'filter_group_id' => $filter_group['filter_group_id'],
                        'name'            => $filter_group['name'],
                        'filter'          => $filter_data
						);
					}
				}
			}
			
			return $filter_group_data;
		}
		
		public function getFullCategoryPath($category_id) {

			if (!$path = $this->cache->get('catfullpath.' . (int)$category_id . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'))){

				$path = '';
				$category = $this->db->query("SELECT category_id, parent_id FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'")->row;
				if (!$category) return '';
				$path = '';
				while ($category['parent_id']){
					$path = $category['parent_id'] . '_' . $path;
					$category = $this->db->query("SELECT category_id, parent_id FROM " . DB_PREFIX . "category WHERE category_id = '" . $category['parent_id']. "'")->row;
				}

				$this->cache->set('catfullpath.' . (int)$category_id . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'), $path);

			}

			return $path;
		}
		
		public function getProductCategoryPath($product_id) {
			$max_level = 3;
			
			$sql = "SELECT " . DB_PREFIX . "product_to_category.category_id FROM " . DB_PREFIX . "product_to_category LEFT JOIN " . DB_PREFIX . "category ON " . DB_PREFIX . "product_to_category.category_id = " . DB_PREFIX . "category.category_id WHERE product_id = '" . $product_id . "' ORDER BY parent_id DESC, main_category DESC LIMIT 1";
			
			$query = $this->db->query($sql);
			$category_id = $query->num_rows ? (int)$query->row['category_id'] : 0;
			
			$sql = "SELECT CONCAT_WS('_'";
			for ($i = $max_level-1; $i >= 0; --$i) {
				$sql .= ",t$i.category_id";
			}
			$sql .= ") AS path FROM " . DB_PREFIX . "category t0";
			for ($i = 1; $i < $max_level; ++$i) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "category t$i ON (t$i.category_id = t" . ($i-1) . ".parent_id)";
			}
			$sql .= " WHERE t0.category_id = '" . $category_id . "'";
			
			$query = $this->db->query($sql);
			
			$s = '';
			if ($query->row['path'] && $a = explode('_', $query->row['path'])){
				
				$cats = array();
				foreach ($a as $cid){
					$cat = $this->getCategory($cid);
					$cats[] = $cat['name'];
				}
				
				$s = implode('/', $cats);
				
			}
			
			return $s;
		}
		
		public function getCategoryLayoutId($category_id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
			
			if ($query->num_rows) {
				return $query->row['layout_id'];
				} else {
				return 0;
			}
		}
		
		public function getTotalCategoriesByCategoryId($parent_id = 0) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");
			
			return $query->row['total'];
		}
	}
