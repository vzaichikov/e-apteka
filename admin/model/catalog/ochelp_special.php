<?php
class ModelCatalogOchelpSpecial extends Model {
	private $customerGroups = array(1);
	
	
	private function editProductSpecialData($data){
		$this->load->model('catalog/product');
		
		$product = $this->model_catalog_product->getProduct($data['product_id']);
		
		if ($product){
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$data['product_id'] . "'");	
			
			if (((float)$data['price'] + (float)$data['percent'] > 0)){					
				
				foreach ($this->customerGroups as $customer_group_id){
					if ((float)$data['price']){							
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET
							product_id 			= '" . (int)$data['product_id'] . "',
							customer_group_id 	= '" . $customer_group_id . "',
							priority 			= '0',
							type 				= '=',
							price 				= '" . (float)$data['price'] . "',
							date_start 			= DATE(NOW() - INTERVAL 2 DAY),
							date_end 			= '" . $this->db->escape(date('Y-m-d', strtotime($data['date_end']))) . "',
							timer 				= 0,
							product_special_group_id = 0
							");				
					} elseif ((float)$data['percent']){
						
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET
							product_id 			= '" . (int)$data['product_id'] . "',
							customer_group_id 	= '" . $customer_group_id . "',
							priority 			= '0',
							type 				= '%',
							price 				= '" . (float)$data['percent'] . "',
							date_start 			= DATE(NOW() - INTERVAL 2 DAY),
							date_end 			= '" . $this->db->escape(date('Y-m-d', strtotime($data['date_end']))) . "',
							timer 				= 0,
							product_special_group_id = 0
							");
					}
				}
			}
		}				
	}
	
	
	public function addSpecial($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "special SET date_end = '" . $this->db->escape($data['date_end']) . "', sort_order = '" . (int)$data['sort_order'] . "', counter = '" . (int)$data['counter'] . "', total = '" . (int)$data['total'] . "', show_title = '" . (int)$data['show_title'] . "', status = '" . (int)$data['status'] . "', homepage = '" . (int)$data['homepage'] . "', retail = '" . (int)$data['retail'] . "', date_added = now()");
		
		$special_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "special SET image = '" . $this->db->escape($data['image']) . "' WHERE special_id = '" . (int)$special_id . "'");
		}
		
		if (isset($data['banner'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "special SET banner = '" . $this->db->escape($data['banner']) . "' WHERE special_id = '" . (int)$special_id . "'");
		}
		
		foreach ($data['special_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "special_description SET special_id = '" . (int)$special_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', banner = '" . $this->db->escape($value['banner']) . "', image = '" . $this->db->escape($value['image']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "',  meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}
		
		if (isset($data['special_store'])) {
			foreach ($data['special_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "special_to_store SET special_id = '" . (int)$special_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		
		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'special_id=" . (int)$special_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$status = $data['status'];
		if (isset($data['special_product'])) {
			foreach ($data['special_product'] as $_data) {
				$_data['date_end'] = $data['date_end'];
				$this->db->query("INSERT INTO " . DB_PREFIX . "special_product SET special_id = '" . (int)$special_id . "', product_id = '" . (int)$_data['product_id'] . "', price = '" . (float)$_data['price'] . "',  percent = '" . (float)$_data['percent'] . "'");
				if ($status){
					$this->editProductSpecialData($_data);
				}
			}
		}
		
		$this->cache->delete('ochelp_special');
	}
	
	public function editSpecial($special_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "special SET date_end = '" . $this->db->escape($data['date_end']) . "', sort_order = '" . (int)$data['sort_order'] . "', counter = '" . (int)$data['counter'] . "', total = '" . (int)$data['total'] . "',  show_title = '" . (int)$data['show_title'] . "', homepage = '" . (int)$data['homepage'] . "', retail = '" . (int)$data['retail'] . "', status = '" . (int)$data['status'] . "' WHERE special_id = '" . (int)$special_id . "'");
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "special SET image = '" . $this->db->escape($data['image']) . "' WHERE special_id = '" . (int)$special_id . "'");
		}
		
		if (isset($data['banner'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "special SET banner = '" . $this->db->escape($data['banner']) . "' WHERE special_id = '" . (int)$special_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "special_description WHERE special_id = '" . (int)$special_id . "'");
		
		foreach ($data['special_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "special_description SET special_id = '" . (int)$special_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', banner = '" . $this->db->escape($value['banner']) . "', image = '" . $this->db->escape($value['image']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "',  meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "special_to_store WHERE special_id = '" . (int)$special_id . "'");
		
		if (isset($data['special_store'])) {
			foreach ($data['special_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "special_to_store SET special_id = '" . (int)$special_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'special_id=" . (int)$special_id . "'");
		
		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'special_id=" . (int)$special_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "special_product WHERE special_id = '" . (int)$special_id . "'");
		
		$status = $data['status'];
		if (isset($data['special_product'])) {
			foreach ($data['special_product'] as $_data) {
				$_data['date_end'] = $data['date_end'];
				$this->db->query("INSERT INTO " . DB_PREFIX . "special_product SET special_id = '" . (int)$special_id . "', product_id = '" . (int)$_data['product_id'] . "', price = '" . (float)$_data['price'] . "',  percent = '" . (float)$_data['percent'] . "'");
				if ($status){
					$this->editProductSpecialData($_data);
				}
			}
		}
		
		$this->cache->delete('ochelp_special');
	}
	
	public function deleteSpecial($special_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "special WHERE special_id = '" . (int)$special_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "special_description WHERE special_id = '" . (int)$special_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "special_product WHERE special_id = '" . (int)$special_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "special_to_store WHERE special_id = '" . (int)$special_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'special_id=" . (int)$special_id . "'");
		
		$this->cache->delete('ochelp_special');
	}
	
	public function getSpecials($data = array()) {
		if ($data) {
			$sql = "SELECT *, s.image as oneimage, s.banner as onebanner FROM " . DB_PREFIX . "special s LEFT JOIN " . DB_PREFIX . "special_description sd ON (s.special_id = sd.special_id) WHERE sd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			
			$sort_data = array(
				'sd.title',
				's.date_added',
				's.date_end',
			);
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY sd.title";
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
		} else {
			$special_data = $this->cache->get('special.' . (int)$this->config->get('config_language_id'));
			
			if (!$special_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "special s LEFT JOIN " . DB_PREFIX . "special_description sd ON (s.special_id = sd.special_id) WHERE sd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY sd.title");
				
				$special_data = $query->rows;
				
				$this->cache->set('special.' . (int)$this->config->get('config_language_id'), $special_data);
			}
			
			return $special_data;
		}
	}
	
	public function getSpecial($special_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'special_id=" . (int)$special_id . "') AS keyword FROM " . DB_PREFIX . "special s LEFT JOIN " . DB_PREFIX . "special_description sd ON (s.special_id = sd.special_id) WHERE s.special_id = '" . (int)$special_id . "' AND sd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
			
			return $query->row;
		}
		
		public function getSpecialDescriptions($special_id) {
			$special_description_data = array();
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "special_description WHERE special_id = '" . (int)$special_id . "'");
			
			foreach ($query->rows as $result) {
				$special_description_data[$result['language_id']] = array(
					'title' => $result['title'],
					'description' => $result['description'],
					'image' => $result['image'],
					'banner' => $result['banner'],
					'meta_title' => $result['meta_title'],
					'meta_h1' => $result['meta_h1'],
					'meta_description' => $result['meta_description'],
					'meta_keyword' => $result['meta_keyword'],
				);
			}
			
			return $special_description_data;
		}
		
		public function getSpecialStores($special_id) {
			$specialpage_store_data = array();
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "special_to_store WHERE special_id = '" . (int)$special_id . "'");
			
			foreach ($query->rows as $result) {
				$specialpage_store_data[] = $result['store_id'];
			}
			
			return $specialpage_store_data;
		}
		
		public function getTotalSpecial() {
			
			$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "special");
			
			return $query->row['total'];
		}
		
		public function getSpecialProduct($special_id) {
			
			$product_data = array();
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "special_product WHERE special_id = '" . (int)$special_id . "'");
			
			foreach ($query->rows as $result) {
				$product_data[] = array(
					'product_id' => $result['product_id'],
					'price' => $result['price'],
					'percent' => $result['percent']
				);
			}
			
			return $product_data;
		}
		
		public function setUrlAlias($keyword) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'information/ochelp_special'");
			if ($query) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'information/ochelp_special'");
				$this->db->query("INSERT INTO `" . DB_PREFIX . "url_alias` SET `query` = 'information/ochelp_special', `keyword` = '" . $this->db->escape($keyword) . "'");
			} else {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "url_alias` SET `query` = 'information/ochelp_special', `keyword` = '" . $this->db->escape($keyword) . "'");
			}
		}
		
		public function getUrlAlias($alias) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'information/ochelp_special'");
			
			return $query->row;
		}
		
		public function checkTables() {
			$check = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "special'");
			$check_2 = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "special_description'");
			$check_3 = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "special_to_store'");
			
			if($check->num_rows && $check_2->num_rows && $check_3->num_rows){
				return true;
			}else{
				return false;
			}
		}
		
		public function install() {
			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "special` (
				`special_id` int(11) NOT NULL auto_increment, 
				`image` VARCHAR(255) COLLATE utf8_general_ci default NULL, 
				`sort_order` int(3) NOT NULL default '0',
				`date_added` date default NULL,
				`date_end` date default NULL,
				`counter` tinyint(1) NOT NULL default '0',
				`total` tinyint(1) NOT NULL default '0',
				`show_title` tinyint(1) NOT NULL default '0',
				`status` tinyint(1) NOT NULL default '0',
				PRIMARY KEY (`special_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
			
			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "special_description` (
				`special_id` int(11) NOT NULL default '0', 
				`language_id` int(11) NOT NULL default '0', 
				`title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
				`description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,  
				`meta_title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
				`meta_h1` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
				`meta_description` VARCHAR(255) COLLATE utf8_general_ci NOT NULL, 
				`meta_keyword` varchar(255) COLLATE utf8_general_ci NOT NULL, 
				PRIMARY KEY (`special_id`,`language_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
			
			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "special_product` (
				`special_id` int(11) NOT NULL, 
				`product_id` int(11) NOT NULL,
				`price` decimal(15,4) NOT NULL DEFAULT '0.0000',
				`percent` decimal(3) NOT NULL DEFAULT '000', 
				PRIMARY KEY (`special_id`,`product_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
			
			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "special_to_store` (
				`special_id` int(11) NOT NULL, 
				`store_id` int(11) NOT NULL, 
				PRIMARY KEY (`special_id`, `store_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		}
	}			