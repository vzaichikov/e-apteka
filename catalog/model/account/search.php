<?php
class ModelAccountSearch extends Model {
	public function addSearch($data) {
		
		if (isset($this->request->server['REMOTE_ADDR'])) {
			$ip = $this->request->server['REMOTE_ADDR'];
		} else {
			$ip = '';
		}
		
		$this->db->query("INSERT INTO `" . DB_PREFIX . "customer_search` 
			SET `store_id` = '" . (int)$this->config->get('config_store_id') . "', 
			`language_id` = '" . (int)$this->config->get('config_language_id') . "', 
			`customer_id` = '" . (int)$this->customer->getId() . "',			
			`keyword` = '" . $this->db->escape($data['keyword']) . "',	
			`results` = '" . $this->db->escape($data['results']) . "',
			`ip` = '" . $this->db->escape($ip) . "', 
			`date_added` = NOW()");
	}

	public function limitSearch($data){
		$query = $this->db->query(
			"SELECT COUNT(*) as count FROM `" . DB_PREFIX . "customer_search` 
			WHERE ip = '" . $this->db->escape($data['ip']) . "' 
			AND timestamp >= '" . strtotime('-3 minute') . "'"
		);
		
		return $query->row['count'];
		
	}
	
	public function addSearchIDX($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "customer_search_idx` 
			SET `entity_type` = '" . (!empty($data['entity_type'])?$this->db->escape($data['entity_type']):'f') . "',
			`entity_id` = '" . (!empty($data['entity_id'])?(int)$data['entity_id']:0) . "', 
			`keyword` = '" . $this->db->escape($data['keyword']) . "'			
			ON DUPLICATE KEY UPDATE count = count + 1");
	}
}
