<?php
	

class ModelToolOnline extends Model {
	
	public function addOnline($ip, $customer_id, $url, $referer, $useragent, $is_bot) {
	
		$this->db->query("DELETE FROM `" . DB_PREFIX . "customer_online` WHERE date_added < '" . date('Y-m-d H:i:s', strtotime('-30 minute')) . "'");

		$this->db->query("REPLACE INTO `" . DB_PREFIX . "customer_online` SET `ip` = '" . $this->db->escape($ip) . "', `customer_id` = '" . (int)$customer_id . "', `url` = '" . $this->db->escape($url) . "', `referer` = '" . $this->db->escape($referer) . "', `useragent` = '" . $this->db->escape($useragent) . "', is_bot = '" . (int)$is_bot . "', `date_added` = '" . $this->db->escape(date('Y-m-d H:i:s')) . "'");
	}
}
