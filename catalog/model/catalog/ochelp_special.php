<?php

class ModelCatalogOchelpSpecial extends Model {

	public function getSpecial($special_id) {
		$query = $this->db->query("SELECT DISTINCT *, s.image as oneimage, s.banner as onebanner, (SELECT keyword FROM oc_url_alias WHERE query = 'special_id=" . (int)$special_id . "') AS keyword FROM oc_special s LEFT JOIN oc_special_description sd ON (s.special_id = sd.special_id) WHERE s.special_id = '" . (int)$special_id . "' AND sd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	
	public function getActiveSpecialByProduct($product_id){
			
			$query = $this->db->query("SELECT DISTINCT * FROM oc_special s 
			LEFT JOIN oc_special_product sp on (s.special_id = sp.special_id)
			LEFT JOIN oc_special_to_store s2s ON (s.special_id = s2s.special_id)
			WHERE product_id = '" . (int)$product_id . "' AND s2s.store_id = '" . (int) $this->config->get('config_store_id') . "' AND s.status = '1' AND (date_end = '0000-00-00' OR date_end >= DATE(NOW())) LIMIT 1");
			
			if($query->num_rows){
				return $this->getSpecial($query->row['special_id']);
				}else{
				return false;
			}

		}

	public function getSpecials($data) {
		$sql = "SELECT *, s.image as oneimage, s.banner as onebanner  FROM oc_special s LEFT JOIN oc_special_description sd ON (s.special_id = sd.special_id) LEFT JOIN oc_special_to_store s2s ON (s.special_id = s2s.special_id) WHERE sd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND s2s.store_id = '" . (int) $this->config->get('config_store_id') . "' AND s.status = '1' AND (date_end = '0000-00-00' OR date_end > DATE(NOW()))";
		
		if (!empty($data['exclude'])){
			$sql .= " AND s.special_id <> '" . (int)$data['exclude'] . "'";
		}

		if (!empty($data['filter_homepage'])){
			$sql .= " AND s.homepage = '" . (int)$data['filter_homepage'] . "'";
		}

		if (!empty($data['filter_image'])){
			$sql .= " AND (s.image <> '' OR s.banner <> '')";
		}

		$sort_data = array(
			'sd.title',
			's.date_added',
			'rand()'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sd.title";
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
				$data['limit'] = 10;
			}

			$sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
		}			

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getSpecialsArchive($data) {
		$sql = "SELECT *, s.image as oneimage, s.banner as onebanner  FROM oc_special s LEFT JOIN oc_special_description sd ON (s.special_id = sd.special_id) LEFT JOIN oc_special_to_store s2s ON (s.special_id = s2s.special_id) WHERE sd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND s2s.store_id = '" . (int) $this->config->get('config_store_id') . "' AND s.status = '1' AND date_end <= DATE(NOW())";

		$sort_data = array(
			'sd.title',
			's.date_added',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sd.title";
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
				$data['limit'] = 10;
			}

			$sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getSpecialShort($limit) {
		$query = $this->db->query("SELECT *, s.image as oneimage, s.banner as onebanner FROM oc_special s LEFT JOIN oc_special_description sd ON (s.special_id = sd.special_id) LEFT JOIN oc_special_to_store s2s ON (s.special_id = s2s.special_id) WHERE sd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND s2s.store_id = '" . (int) $this->config->get('config_store_id') . "' AND s.status = '1' ORDER BY s.date_added DESC LIMIT " . (int) $limit);

		return $query->rows;
	}

	public function getTotalSpecial() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM oc_special s LEFT JOIN oc_special_to_store s2s ON (s.special_id = s2s.special_id) WHERE s2s.store_id = '" . (int) $this->config->get('config_store_id') . "' AND s.status = '1' AND date_end > DATE(NOW())");

		if ($query->row) {
			return $query->row['total'];
		} else {
			return false;
		}
	}

	public function getSpecialByProductId($product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM oc_special s LEFT JOIN oc_special_product sp on (s.special_id = sp.special_id) WHERE product_id = '" . (int)$product_id . "'");
		
		if($query->num_rows){
			return $this->getSpecial($query->row['special_id']);
		}else{
			return false;
		}

	}

	public function getSpecialProduct($product_id, $special_id) {
		$query = $this->db->query("SELECT * FROM oc_special_product WHERE product_id = '" . (int)$product_id . "' AND special_id = '" . (int)$special_id . "'");
		
		if($query->num_rows){
			return $query->row;
		}else{
			return false;
		}		
	}

	public function getSpecialProductIdTotal($product_id) {
		$this->load->model('catalog/ochelp_special');

		$query = $this->db->query("SELECT * FROM oc_special_product WHERE product_id = '" . (int)$product_id . "'");

		return $query->row;
	}


	public function getSpecialProducts($data = array()) {
		$sql = "SELECT DISTINCT sp.product_id, (SELECT AVG(rating) FROM oc_review r1 WHERE r1.product_id = sp.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM oc_special_product sp LEFT JOIN oc_product p ON (sp.product_id = p.product_id) LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id) LEFT JOIN oc_product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND sp.special_id = '" . (int)$data['special_id'] . "' GROUP BY sp.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.price',
			'rating',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY p.is_onstock DESC, LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY p.is_onstock DESC, " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.is_onstock DESC, p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
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

		$product_data = array();			

		$query = $this->db->query($sql);

		$this->load->model('catalog/product');
		
		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
		}

		return $product_data;
	}
		public function getTotalSpecialProducts($special_id) {
		$query = $this->db->query("SELECT COUNT(DISTINCT sp.product_id) AS total FROM oc_special_product sp LEFT JOIN oc_product p ON (sp.product_id = p.product_id) LEFT JOIN oc_product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND sp.special_id = '" . (int)$special_id . "'");

		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}

}