<?php
	class ModelCatalogManufacturer extends Model {
		public function addManufacturer($data) {
			
			if (empty($data['name'])){
				$this->load->model('localisation/language');
				$language_info = $this->model_localisation_language->getLanguageByCode($this->config->get('config_language'));
				$front_language_id = $language_info['language_id'];
				$data['name'] = $data['manufacturer_description'][$front_language_id ]['name'];
			}
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer SET name = '" . $this->db->escape($data['name']) . "', uuid = '" . $this->db->escape($data['uuid']) . "', sort_order = '" . (int)$data['sort_order'] . "'");
			
			$manufacturer_id = $this->db->getLastId();
			
			if (isset($data['image'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET image = '" . $this->db->escape($data['image']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
			}
			
			foreach ($data['manufacturer_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_description SET manufacturer_id = '" . (int)$manufacturer_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', alternate_name = '" . $this->db->escape($value['alternate_name']) . "', country = '" . $this->db->escape($value['country']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', faq_name = '" . $this->db->escape($value['faq_name']) . "'");
			}
			

				
				$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_faq WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
				
				if (isset($data['manufacturer_faq'])) {
				foreach ($data['manufacturer_faq'] as $manufacturer_faq) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_faq SET manufacturer_id = '" . (int)$manufacturer_id . "', `question` = '" . $this->db->escape(serialize($manufacturer_faq['question'])) . "', `faq` = '" . $this->db->escape(serialize($manufacturer_faq['faq'])) . "', `icon` = '" . $this->db->escape($manufacturer_faq['icon']) . "', `sort_order` = '" . (int)$manufacturer_faq['sort_order'] . "'");
				}
				} 
			
			if (isset($data['manufacturer_store'])) {
				foreach ($data['manufacturer_store'] as $store_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . (int)$manufacturer_id . "', store_id = '" . (int)$store_id . "'");
				}
			}
			
			if (isset($data['keyword'])) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$manufacturer_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
			}
			
			$this->cache->delete('manufacturer');
			
			return $manufacturer_id;
		}
		
		public function editManufacturer($manufacturer_id, $data) {
			
			if (empty($data['name'])){
				$this->load->model('localisation/language');
				$language_info = $this->model_localisation_language->getLanguageByCode($this->config->get('config_language'));
				$front_language_id = $language_info['language_id'];
				$data['name'] = $data['manufacturer_description'][$front_language_id ]['name'];
			}
			
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET name = '" . $this->db->escape($data['name']) . "', uuid = '" . $this->db->escape($data['uuid']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
			
			if (isset($data['image'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET image = '" . $this->db->escape($data['image']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
			}
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_description WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
			
			foreach ($data['manufacturer_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_description SET manufacturer_id = '" . (int)$manufacturer_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', alternate_name = '" . $this->db->escape($value['alternate_name']) . "', country = '" . $this->db->escape($value['country']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', faq_name = '" . $this->db->escape($value['faq_name']) . "'");
			}
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
			

				
				$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_faq WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
				
				if (isset($data['manufacturer_faq'])) {
				foreach ($data['manufacturer_faq'] as $manufacturer_faq) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_faq SET manufacturer_id = '" . (int)$manufacturer_id . "', `question` = '" . $this->db->escape(serialize($manufacturer_faq['question'])) . "', `faq` = '" . $this->db->escape(serialize($manufacturer_faq['faq'])) . "', `icon` = '" . $this->db->escape($manufacturer_faq['icon']) . "', `sort_order` = '" . (int)$manufacturer_faq['sort_order'] . "'");
				}
				} 
			
			if (isset($data['manufacturer_store'])) {
				foreach ($data['manufacturer_store'] as $store_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . (int)$manufacturer_id . "', store_id = '" . (int)$store_id . "'");
				}
			}
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int)$manufacturer_id . "'");
			
			if ($data['keyword']) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$manufacturer_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
			}
			
			$this->cache->delete('manufacturer');
		}
		
		public function getManufacturerDescriptions($manufacturer_id) {
			$manufacturer_description_data = array();
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer_description WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
			
			foreach ($query->rows as $result) {
				$manufacturer_description_data[$result['language_id']] = array(
				'name'      		=> $result['name'],
				'country'      		=> $result['country'],
				'alternate_name'   	=> $result['alternate_name'],
				'description'      	=> $result['description'],
				'meta_description'  => $result['meta_description'],
				'meta_keyword'      => $result['meta_keyword'],
				'custom_title'      => $result['custom_title'],
				);
			}
			
			return $manufacturer_description_data;
		}
		
		public function deleteManufacturer($manufacturer_id) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_description WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int)$manufacturer_id . "'");
			
			$this->cache->delete('manufacturer');
		}
		
		public function getManufacturer($manufacturer_id) {
			$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int)$manufacturer_id . "') AS keyword FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
			
			return $query->row;
		}
		
		public function getAllManufacturers() {
			$sql = "SELECT m.manufacturer_id, md.name, m.uuid, m.sort_order FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (m.manufacturer_id = md.manufacturer_id) WHERE md.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			
			$sql .= " ORDER BY name";
			
			$query = $this->db->query($sql);
			
			return $query->rows;
		}
		
		public function getManufacturers($data = array()) {
			$sql = "SELECT * FROM " . DB_PREFIX . "manufacturer";
			
			$sql = "SELECT m.manufacturer_id, md.name, m.uuid, m.sort_order FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (m.manufacturer_id = md.manufacturer_id) WHERE md.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			
			if (!empty($data['filter_name'])) {
				$sql .= " AND name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
			}
			
			$sort_data = array(
			'name',
			'sort_order'
			);
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
				} else {
				$sql .= " ORDER BY name";
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
		
		

				public function getManufacturerFaq($manufacturer_id) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer_faq WHERE manufacturer_id = '" . (int)$manufacturer_id . "' ORDER BY sort_order ASC");
				return $query->rows;
				}
			
		public function getManufacturerStores($manufacturer_id) {
			$manufacturer_store_data = array();
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
			
			foreach ($query->rows as $result) {
				$manufacturer_store_data[] = $result['store_id'];
			}
			
			return $manufacturer_store_data;
		}
		
		public function getTotalManufacturers() {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "manufacturer");
			
			return $query->row['total'];
		}
	}
