<?php
class ModelExtensionModuleRecentlyViewed extends Model {

	public function getRecentlyViewedProducts($customer_id, $limit, $current_product_id){
		$query = $this->db->query("SELECT product_id FROM `".DB_PREFIX."customer_product_viewed` WHERE `customer_id`='".(int)$customer_id."' AND product_id<>'".(int)$current_product_id."' ORDER BY date DESC LIMIT ".$limit);
		return $query->rows;
	}
	
	public function setRecentlyViewedProducts($customer_id, $product_id) {

		$this->db->query("INSERT INTO `".DB_PREFIX."customer_product_viewed` 
			SET `customer_id` = '" . (int)$customer_id . "', 
			product_id = '" . (int)$product_id . "', 
			date = NOW(),
			viewed = 1
			ON DUPLICATE KEY UPDATE viewed = viewed + 1");
				
	}
	
	public function isEnabled(){
		return true;
	}
}