<?php
	class ModelSettingNodes extends Model {
		
		public function addNode($data) {	
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "nodes 
			SET 
			node_name = '" . $this->db->escape($data['node_name']) . "', 
			is_main = '" . (int)$data['is_main'] . "', 
			is_stock = '" . (int)$data['is_stock'] . "', 
			is_catalog = '" . (int)$data['is_catalog'] . "', 
			is_customer = '" . (int)$data['is_customer'] . "', 	
			is_cards = '" . (int)$data['is_cards'] . "',
			is_preorder = '" . (int)$data['is_preorder'] . "',
			node_url = '" . $this->db->escape($data['node_url']) . "', 			
			node_auth = '" . $this->db->escape($data['node_auth']) . "', 
			node_password = '" . $this->db->escape($data['node_password']) . "'");
			
			$node_id = $this->db->getLastId();
			
			return $node_id;
		}
		
		public function editNode($node_id, $data) {
			
			$this->db->query("UPDATE " . DB_PREFIX . "nodes 
			SET 
			node_name = '" . $this->db->escape($data['node_name']) . "', 
			is_main = '" . (int)$data['is_main'] . "', 
			is_stock = '" . (int)$data['is_stock'] . "', 
			is_catalog = '" . (int)$data['is_catalog'] . "', 
			is_customer = '" . (int)$data['is_customer'] . "',
 			is_cards = '" . (int)$data['is_cards'] . "',
 			is_preorder = '" . (int)$data['is_preorder'] . "',
			node_url = '" . $this->db->escape($data['node_url']) . "', 			
			node_auth = '" . $this->db->escape($data['node_auth']) . "', 
			node_password = '" . $this->db->escape($data['node_password']) . "'
			WHERE node_id = '" . (int)$node_id . "'");
			
			$node_id = $this->db->getLastId();
			
			return $node_id;
		}
		
		public function deleteNode($node_id) {
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "nodes WHERE node_id = '" . (int)$node_id . "'");
		}
		
		public function getNode($node_id) {
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "nodes WHERE node_id = '" . (int)$node_id . "' LIMIT 1");
			
			return $query->row;
		}
		
		public function getNodeName($node_id) {
			
			$query = $this->db->query("SELECT node_name FROM " . DB_PREFIX . "nodes WHERE node_id = '" . (int)$node_id . "' LIMIT 1");
			
			return isset($query->row['node_name'])?$query->row['node_name']:'';
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
		
		public function getNodeExchangeHistory($node_id) {
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "node_exchange_history WHERE node_id 	= '" . (int)$node_id . "' ORDER BY date_added DESC LIMIT 50");
				
			return $query->rows;	
		}
		
		public function getNodesForCatalogUpdate() {
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "nodes WHERE is_catalog = 1");
			
			if ($query->num_rows) {
				return $query->rows;			
				} else {
				return false;
			}
		}

		public function getNodesForCardsUpdate() {
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "nodes WHERE is_cards = 1");
			
			if ($query->num_rows) {
				return $query->rows;			
				} else {
				return false;
			}
		}
		
		public function getNodesForCustomerUpdate() {
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "nodes WHERE is_customer = 1");
			
			if ($query->num_rows) {
				return $query->rows;			
				} else {
				return false;
			}
		}

		public function getNodesForPreorderUpdate() {
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "nodes WHERE is_preorder = 1");
			
			if ($query->num_rows) {
				return $query->rows;			
				} else {
				return false;
			}
		}
		
		public function getNodesForStockUpdate() {
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "nodes WHERE is_stock = 1");
			
			if ($query->num_rows) {
				return $query->rows;			
				} else {
				return false;
			}
		}
		
		public function getNodes() {
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "nodes WHERE 1");
			
			return $query->rows;
		}
		
	}			