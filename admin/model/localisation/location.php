<?php
	class ModelLocalisationLocation extends Model {
		public function addLocation($data) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "location SET name = '" . $this->db->escape($data['name']) . "', address = '" . $this->db->escape($data['address']) . "', geocode = '" . $this->db->escape($data['geocode']) . "', gmaps_link = '" . $this->db->escape($data['gmaps_link']) . "', brand = '" . $this->db->escape($data['brand']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', image = '" . $this->db->escape($data['image']) . "', city = '" . $this->db->escape($data['city']) . "', city_id = '" . $this->db->escape($data['city_id']) . "', open = '" . $this->db->escape($data['open']) . "', open_struct = '" . $this->db->escape($data['open_struct']) . "', node_id = '" . (int)$data['node_id'] . "', is_stock = '" . (int)$data['is_stock'] . "', can_sell_drugs = '" . (int)$data['can_sell_drugs'] . "', temprorary_closed = '" . (int)$data['temprorary_closed'] . "', information_id = '" . (int)$data['information_id'] . "', default_price = '" . (int)$data['default_price'] . "', sort_order = '" . (int)$data['sort_order'] . "', delivery_times = '" . $this->db->escape($data['delivery_times']) . "', comment = '" . $this->db->escape($data['comment']) . "', uuid = '" . $this->db->escape($data['uuid']) . "'");
			
			$location_id = $this->db->getLastId();
			
			foreach ($data['location_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "location_description SET location_id = '" . (int)$location_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', open = '" . $this->db->escape($value['open']) . "', comment = '" . $this->db->escape($value['comment']) . "', brand = '" . $this->db->escape($value['brand']) . "', address = '" . $this->db->escape($value['address']) . "', delivery_times = '" . $this->db->escape($value['delivery_times']) . "'");
			}
			
			return $location_id;
		}
		
		public function editLocation($location_id, $data) {
			$this->db->query("UPDATE " . DB_PREFIX . "location SET name = '" . $this->db->escape($data['name']) . "', address = '" . $this->db->escape($data['address']) . "', geocode = '" . $this->db->escape($data['geocode']) . "', gmaps_link = '" . $this->db->escape($data['gmaps_link']) . "', brand = '" . $this->db->escape($data['brand']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', image = '" . $this->db->escape($data['image']) . "', open = '" . $this->db->escape($data['open']) . "', city = '" . $this->db->escape($data['city']) . "', city_id = '" .  $this->db->escape($data['city_id']) . "', open_struct = '" . $this->db->escape($data['open_struct']) . "', node_id = '" . (int)$data['node_id'] . "', is_stock = '" . (int)$data['is_stock'] . "', can_sell_drugs = '" . (int)$data['can_sell_drugs'] . "', temprorary_closed = '" . (int)$data['temprorary_closed'] . "', information_id = '" . (int)$data['information_id'] . "', default_price = '" . (int)$data['default_price'] . "', sort_order = '" . (int)$data['sort_order'] . "', delivery_times = '" . $this->db->escape($data['delivery_times']) . "', comment = '" . $this->db->escape($data['comment']) . "', uuid = '" . $this->db->escape($data['uuid']) . "' WHERE location_id = '" . (int)$location_id . "'");
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "location_description WHERE location_id = '" . (int)$location_id . "'");
			
			foreach ($data['location_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "location_description SET location_id = '" . (int)$location_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', open = '" . $this->db->escape($value['open']) . "', comment = '" . $this->db->escape($value['comment']) . "', brand = '" . $this->db->escape($value['brand']) . "', address = '" . $this->db->escape($value['address']) . "', delivery_times = '" . $this->db->escape($value['delivery_times']) . "'");
			}
		}
		
		public function deleteLocation($location_id) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "location WHERE location_id = " . (int)$location_id);
			$this->db->query("DELETE FROM " . DB_PREFIX . "location_description WHERE location_id = " . (int)$location_id);
		}
		
		public function getLocation($location_id) {				
			$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "location WHERE location_id = '" . (int)$location_id . "'");			
			
			return $query->row;
		}
		
		public function getLocationDescriptions($location_id) {
			$location_description_data = array();
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "location_description WHERE location_id = '" . (int)$location_id . "'");
			
			foreach ($query->rows as $result) {
				$location_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'open'       	   => $result['open'],
				'comment' 		   => $result['comment'],
				'address'     	   => $result['address'],
				'brand'     	   => $result['brand'],
				'delivery_times'   => $result['delivery_times']
				);
			}
			
			return $location_description_data;
		}
		
		public function getLocationForStocks() {
			$query = $this->db->query("SELECT DISTINCT location_id FROM " . DB_PREFIX . "location WHERE is_stock = 1");
			
			if ($query->num_rows) {
				return $query->rows;			
				} else {
				return false;
			}
		}
		
		public function getLocations($data = array()) {
			$sql = "SELECT * FROM " . DB_PREFIX . "location";
			
			$sort_data = array(
			'name',
			'address',
			'location_id',
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
		
		public function getTotalLocations() {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "location");
			
			return $query->row['total'];
		}
	}
