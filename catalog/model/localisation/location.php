<?php
	class ModelLocalisationLocation extends Model {
		public function getLocation($location_id) {
			$query = $this->db->query("SELECT l.*, l.name as main_name, ld.name as name, l.address as main_address, ld.address as address FROM " . DB_PREFIX . "location l
			LEFT JOIN " . DB_PREFIX . "location_description ld ON (l.location_id = ld.location_id)
			WHERE l.location_id = '" . (int)$location_id . "' AND ld.language_id = '" . (int)$this->config->get('config_language_id') . "'");
			
			return $query->row;
		}

		public function getLocationsGood($filter_data = []) {
			$sql = "SELECT l.*, 
			l.name as main_name, 
			ld.name as name, 
			l.address as main_address, 
			ld.address as address 
			FROM " . DB_PREFIX . "location l
			LEFT JOIN " . DB_PREFIX . "location_description ld ON (l.location_id = ld.location_id)
			WHERE l.temprorary_closed = '0' AND ld.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			if (!empty($filter_data['filter_can_sell_drugs'])){
				$sql .= " AND can_sell_drugs = 1";
			}

			$query = $this->db->query($sql);
			
			return $query->rows;
		}
		
		public function getLocations() {
			$query = $this->db->query("SELECT location_id FROM " . DB_PREFIX . "location WHERE 1");
			
			return $query->rows;
		}

		public function getLocationsForMapPage() {
			$query = $this->db->query("SELECT location_id FROM " . DB_PREFIX . "location WHERE 1 order by temprorary_closed ASC");

			$result = [];

			foreach ($query->rows as $row){
				$result[] = $row['location_id'];
			}
			
			return $result;
		}
		
		public function getLocationML($location_id, $field = false) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "location_description WHERE location_id = '" . (int)$location_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
			
			if ($field){
				return isset($query->row[$field])?$query->row[$field]:false;
				} else {
				return $query->row;
			}
		}
		
		public function getLocationNode($location_id) {
			$query = $this->db->query("SELECT n.* FROM " . DB_PREFIX . "location l
			LEFT JOIN " . DB_PREFIX . "nodes n ON l.node_id = n.node_id WHERE location_id = '" . (int)$location_id . "'");
			
			return $query->row;
		}
		
		public function setNodeLastUpdateStatus($node_id, $status) {
			
			$this->db->query("UPDATE " . DB_PREFIX . "nodes 
			SET 
			node_last_update = NOW(),
			node_last_update_status = '" . $this->db->escape($status) . "'
			WHERE node_id = '" . (int)$node_id . "'");
		}
		
		public function setNodeLastUpdateStatusSuccess($node_id) {
			
			$this->db->query("UPDATE " . DB_PREFIX . "nodes 
			SET 
			node_last_update_error = 0		
			WHERE node_id = '" . (int)$node_id . "'");
		}
		
		public function setNodeLastUpdateStatusError($node_id) {
			
			$this->db->query("UPDATE " . DB_PREFIX . "nodes 
			SET 
			node_last_update_error = 1			
			WHERE node_id = '" . (int)$node_id . "'");
		}
		
		public function addNodeExchangeHistory($node_id, $data) {
			
			$this->db->query("DELETE FROM `" . DB_PREFIX . "node_exchange_history` 
				WHERE DATE(date_added) < NOW() - INTERVAL 10 DAY AND node_id = '" . (int)$node_id . "'");
			
			$this->db->query("
			INSERT INTO " . DB_PREFIX . "node_exchange_history 
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
			$query = $this->db->query("SELECT uuid FROM " . DB_PREFIX . "location WHERE location_id = '" . (int)$location_id . "'");
			
			if ($query->num_rows && $query->row['uuid']){
				return $query->row['uuid'];
				} else {
				return '';
			}
		}
	}	