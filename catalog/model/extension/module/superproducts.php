<?php
class ModelExtensionModuleSuperproducts extends Model {
	public function getProducts($data = array()) {

	  if ($this->config->get('superproductsadmin_enable_cache')) {
        $product_data = $this->cache->get('superproducts.items.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$this->config->get('config_customer_group_id') . '.' . $data['mid'] . '.' . $data['product_group'] . '.' . $data['product_group_b'] . '.' . $data['limit'] . '.' . $data['brand'] . '.' . $data['tag'] . '.' . $data['category']);
      } else {
        $product_data = array();
      }

      $product_data = !is_array($product_data) ? array() : $product_data;

      if (!$product_data) {
		$this->load->model('catalog/product');

		if ($data['product_group_b'] == 'latest' || $data['product_group'] == 'popular' || $data['product_group_b'] == 'popular' || $data['product_group_b'] == 'bestseller') $data['order'] = 'DESC';

		if($data['product_group_b'] == 'special') {
			$extra_q_specials = "LEFT JOIN " . DB_PREFIX . "product_special ps ON (ps.product_id = p.product_id) WHERE ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) AND";
		} else {
			$extra_q_specials = " WHERE";
		}

		if($data['product_group_b'] == 'bestseller') {
			$query_start = "op.product_id, SUM(op.quantity) AS best_total";
			$query_b1 = " FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id)";
		} else {
			$query_start = "p.product_id";
			$query_b1 = " FROM " . DB_PREFIX . "product p";
		}

		$sql = "SELECT ".$query_start.", (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

		if ($data['category'] && $data['product_group'] == 'bycat' && $data['product_group_b'] != 'bestseller') {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id) LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "product_to_category p2c LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
			}
		} else {
			$sql .= $query_b1;
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) ".$extra_q_specials." pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if ($data['category'] && $data['product_group'] == 'bycat' && $data['product_group_b'] != 'bestseller') {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['category'] . "'";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['category'] . "'";
			}
		} elseif ($data['category'] && $data['product_group'] == 'bycat' && $data['product_group_b'] == 'bestseller') {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND p.product_id IN (SELECT p2c.product_id FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id) WHERE cp.path_id.path_id = '" . (int)$data['category'] . "')";
			} else {
				$sql .= " AND p.product_id IN (SELECT p2c.product_id FROM " . DB_PREFIX . "product_to_category p2c WHERE p2c.category_id = '" . (int)$data['category'] . "')";
			}
		}

		if ($data['tag'] && $data['product_group'] == 'bytag') {
			$sql .= " AND pd.tag LIKE '%" . $this->db->escape($data['tag']) . "%'";
		}

		if ($data['brand'] && $data['product_group'] == 'byman') {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['brand'] . "'";
		}

		$sql .= " GROUP BY p.product_id";

		if ($data['product_group_b'] == 'bestseller') {
			$sql .= " ORDER BY best_total";
		} elseif ($data['product_group_b'] == 'specials') {
			$sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special ELSE p.price END)";
		} elseif ($data['product_group'] == 'random' || $data['product_group_b'] == 'random') {
			$sql .= " ORDER BY RAND()";
		} elseif ($data['product_group'] == 'popular' || $data['product_group_b'] == 'popular') {
			$sql .= " ORDER BY p.viewed";
		} elseif ($data['product_group_b'] == 'latest') {
			$sql .= " ORDER BY p.date_added";
		} else {
			$sql .= " ORDER BY p.sort_order";
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

		$query = $this->db->query($sql);
		
		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
		}

		if ($this->config->get('superproductsadmin_enable_cache') && $product_data) {
        	$this->cache->set('superproducts.items.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$this->config->get('config_customer_group_id') . '.' . $data['mid'] . '.' . $data['product_group'] . '.' . $data['product_group_b'] . '.' . $data['limit'] . '.' . $data['brand'] . '.' . $data['tag'] . '.' . $data['category'], $product_data);
        }

	  }

		return $product_data;
	}
	public function getABProducts($pid, $fromcart, $limit) {

		if ($limit < 1) {
			$limit = 5;
		}

		$pid = !$pid ? array(0) : $pid;

		$product_data = array();

		$productCondition1 = !$fromcart ? "op.product_id <> '".$pid."'" : "op.product_id not in (" . implode(', ', $pid) . ")";
		$productCondition2 = !$fromcart ? "ocp.product_id = '".$pid."'" : "ocp.product_id in (" . implode(', ', $pid) . ")";

		$this->load->model('catalog/product');

		$sql = "SELECT DISTINCT op.product_id FROM " . DB_PREFIX . "order_product op INNER JOIN " . DB_PREFIX . "order o on (o.order_id = op.order_id) INNER JOIN " . DB_PREFIX . "product p ON (op.product_id = p.product_id) INNER JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) where ".$productCondition1." AND o.customer_id in (Select oc.customer_id from " . DB_PREFIX . "order oc LEFT JOIN " . DB_PREFIX . "order_product ocp on (oc.order_id = ocp.order_id) where ".$productCondition2.") AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' LIMIT 0," . (int)$limit;

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
		}

		return $product_data;
	}
}