<?php
class ModelExtensionModuleXDStickers extends Model {
	public function getCustomXDSticker($xdsticker_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "xdstickers WHERE xdsticker_id = '" . (int)$xdsticker_id . "'");
		return $query->row;
	}
	
	public function getCustomXDStickersProduct($product_id) {
		$query = $this->db->query("SELECT `xdsticker_id` FROM " . DB_PREFIX . "xdstickers_product WHERE product_id = '" . (int)$product_id . "'");
		
		
		
		if ($query) {
			return $query->rows;
		} else {
			return false;
		}
	}
	
	public function getBestSellerProducts($limit, $parent_id = 0, $doNotReturnFull = false) {
		$this->load->model('catalog/product');
		
		$product_data = array();
		
		$sql = "SELECT op.product_id, SUM(op.quantity) AS total ";
		
		if ($parent_id > 0) {
			$sql .= " FROM " . DB_PREFIX . "category_path cp
			LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)
			LEFT JOIN " . DB_PREFIX . "order_product op ON (op.product_id = p2c.product_id)
			";
		} else {
			$sql .= " FROM " . DB_PREFIX . "order_product op ";
		}
		
		$sql .= " LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id)
		LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id)
		LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)
		WHERE o.order_status_id > '0' AND p.status = '1' AND p.quantity > '0' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
		
		if ($parent_id > 0) {
			$sql .= " AND cp.path_id = '" . (int)$parent_id . "'";
		}
		
		$sql .= " GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit;
		$query = $this->db->query($sql);
		
		foreach ($query->rows as $result) {
			if ($doNotReturnFull){
				$product_data[$result['product_id']] = $result['product_id'];
			} else {
				$product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
			}
		}
		
		
		return $product_data;
	}
	
	public function getCustomXDStickers($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "xdstickers";
		$sort_data = array(
			'name',
			'status'
		);
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY xdsticker_id";
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
		if ($query) {
			return $query->rows;
		} else {
			return false;
		}
	}
}	