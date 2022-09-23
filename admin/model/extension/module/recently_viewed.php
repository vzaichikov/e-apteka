<?php
class ModelExtensionModuleRecentlyViewed extends Model {

	public function createSchema(){
		$this->deleteSchema();
		$sql = "CREATE TABLE `".DB_PREFIX."customer_product_viewed`(
				id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
				customer_id int COMMENT 'customer_id from `".DB_PREFIX."customer',
				product_id int COMMENT 'product_id from `".DB_PREFIX."product',
				viewed_on datetime)";
		$this->db->query($sql);
	}
	
	public function deleteSchema(){
		$sql = "DROP TABLE IF EXISTS `".DB_PREFIX."customer_product_viewed`";
		$this->db->query($sql);
	}
}