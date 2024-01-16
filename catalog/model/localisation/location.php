<?php
	class ModelLocalisationLocation extends Model {
		public function getLocation($location_id) {
			$query = $this->db->query("SELECT l.*, 
				ld.name as name_overload, 
				ld.brand as brand_overload,
				ld.open as open_overload,
				ld.address as address_overload,
				ld.comment as comment_overload
				FROM oc_location l
			LEFT JOIN oc_location_description ld ON (l.location_id = ld.location_id)
			WHERE l.location_id = '" . (int)$location_id . "' AND ld.language_id = '" . (int)$this->config->get('config_language_id') . "'");

			foreach (['open', 'address', 'name', 'brand', 'comment'] as $field){
				if (!empty($query->row[$field . '_overload'])){
					$query->row[$field] = $query->row[$field . '_overload'];
				}
			}
			
			return $query->row;
		}

		public function getLocationsGood($filter_data = []) {
			$sql = "SELECT l.*, 
			l.name as main_name, 
			ld.name as name, 
			l.address as main_address, 
			ld.address as address,
			l.brand 
			FROM oc_location l
			LEFT JOIN oc_location_description ld ON (l.location_id = ld.location_id)
			WHERE l.temprorary_closed = '0' AND ld.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			if (!empty($filter_data) && (!empty($filter_data['novaposhta_city_guid']) || !empty($filter_data['city']))){
				if (!empty($filter_data['novaposhta_city_guid']) && !empty($filter_data['city'])){
					$sql .= " AND ( ";
					$sql .= " l.city_id = '" . $this->db->escape($filter_data['novaposhta_city_guid']) . "' OR LOWER(l.city) = '" . $this->db->escape(mb_strtolower($filter_data['city'])) . "'";

					if (in_array(mb_strtolower($filter_data['city']), $this->cart->getDefaultCityNames()) || $filter_data['novaposhta_city_guid'] == $this->cart->getDefaultCityRef()){
						$sql .= " OR LOWER(l.address) LIKE '%київська обл.%' ";
					}

					$sql .= " ) ";	
				} elseif (!empty($filter_data['novaposhta_city_guid']) && empty($filter_data['city'])){
					$sql .= " AND ( ";
					$sql .= " l.city_id = '" . $this->db->escape($filter_data['novaposhta_city_guid']) . "'";

					if ($filter_data['novaposhta_city_guid'] == $this->cart->getDefaultCityRef()){
						$sql .= " OR LOWER(l.address) LIKE '%київська обл.%' ";
					}

					$sql .= " ) ";	
				} elseif (empty($filter_data['novaposhta_city_guid']) && !empty($filter_data['city'])){
					$sql .= " AND ( ";
					$sql .= " LOWER(l.city) = '" . $this->db->escape(mb_strtolower($filter_data['city'])) . "'";

					if (in_array(mb_strtolower($filter_data['city']), $this->cart->getDefaultCityNames())){
						$sql .= " OR LOWER(l.address) LIKE '%київська обл.%' ";
					}

					$sql .= " ) ";		
				}					
			}			

			if (!empty($filter_data['filter_can_sell_drugs'])){
				$sql .= " AND can_sell_drugs = 1";
			}

			if (!empty($filter_data['filter_can_free_stocks'])){
				$sql .= " AND (can_free_stocks = 1)";
			}

			$query = $this->db->query($sql);
			
			return $query->rows;
		}
		
		public function getLocations() {
			$query = $this->db->query("SELECT location_id FROM oc_location WHERE 1");
			
			return $query->rows;
		}

		public function getLocationsForMapPage() {
			$query = $this->db->query("SELECT location_id FROM oc_location WHERE 1 order by temprorary_closed ASC");

			$result = [];

			foreach ($query->rows as $row){
				$result[] = $row['location_id'];
			}
			
			return $result;
		}
		
		public function getLocationML($location_id, $field = false) {
			$query = $this->db->query("SELECT * FROM oc_location_description WHERE location_id = '" . (int)$location_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
			
			if ($field){
				return isset($query->row[$field])?$query->row[$field]:false;
				} else {
				return $query->row;
			}
		}
		
		public function getLocationNode($location_id) {
			$query = $this->db->query("SELECT n.* FROM oc_location l
			LEFT JOIN oc_nodes n ON l.node_id = n.node_id WHERE location_id = '" . (int)$location_id . "'");
			
			return $query->row;
		}
		
		public function setNodeLastUpdateStatus($node_id, $status) {
			
			$this->db->query("UPDATE oc_nodes 
			SET 
			node_last_update = NOW(),
			node_last_update_status = '" . $this->db->escape($status) . "'
			WHERE node_id = '" . (int)$node_id . "'");
		}
		
		public function setNodeLastUpdateStatusSuccess($node_id) {
			
			$this->db->query("UPDATE oc_nodes 
			SET 
			node_last_update_error = 0		
			WHERE node_id = '" . (int)$node_id . "'");
		}
		
		public function setNodeLastUpdateStatusError($node_id) {
			
			$this->db->query("UPDATE oc_nodes 
			SET 
			node_last_update_error = 1			
			WHERE node_id = '" . (int)$node_id . "'");
		}
		
		public function addNodeExchangeHistory($node_id, $data) {
			
			$this->db->query("DELETE FROM `oc_node_exchange_history` 
				WHERE DATE(date_added) < NOW() - INTERVAL 10 DAY AND node_id = '" . (int)$node_id . "'");
			
			$this->db->query("
			INSERT INTO oc_node_exchange_history 
			SET 
			node_id 	= '" . (int)$node_id . "',
			date_added  = NOW(),
			status 		= '" . $this->db->escape($data['status']) . "',
			type 		= '" . $this->db->escape($data['type']) . "',
			json 		= '" . $this->db->escape($data['json']) . "',
			is_error 	= '" . (int)$data['is_error'] . "'");
		}
		
		public function getLocationProductPrice($product_id, $location_id) {
			
			
		}
		
		public function getLocationUUID($location_id) {
			$query = $this->db->query("SELECT uuid FROM oc_location WHERE location_id = '" . (int)$location_id . "'");
			
			if ($query->num_rows && $query->row['uuid']){
				return $query->row['uuid'];
				} else {
				return '';
			}
		}
	}	