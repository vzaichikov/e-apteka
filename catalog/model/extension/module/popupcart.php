<?php
class ModelExtensionModulePopupCart extends Model {

	public function getRelated($product_id) {
		$product_data = array();
		$limit = 10;

		if (isset($product_id) && (int)$product_id > 0) {
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."product_related pr LEFT JOIN ".DB_PREFIX."product p ON (pr.related_id = p.product_id) LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pr.product_id = '".(int)$product_id."' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '".(int)$this->config->get('config_store_id')."' LIMIT ".(int)$limit);
			foreach ($query->rows as $result) {
				$product_data[] = $result['related_id'];
			}
		}

		return $product_data;
	}

	public function getRelated2($product_id) {
		$product_data = array();
		$limit = 10;
		
		if (isset($product_id) && (int)$product_id > 0) {		
			$query = $this->db->query("SELECT op.product_id FROM ".DB_PREFIX."order_product op LEFT JOIN ".DB_PREFIX."product p ON (op.product_id = p.product_id) LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN ".DB_PREFIX."order_product op1 ON (op1.order_id = op.order_id) WHERE op1.product_id = '".(int)$product_id."' AND op.product_id <> '".(int)$product_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '".(int)$this->config->get('config_store_id')."' GROUP BY op.product_id LIMIT ".(int)$limit);
			foreach ($query->rows as $result) {
				$product_data[] = $result['product_id'];
			}					
		}
		
		return $product_data;
	}
}
?>