<?php
	class ModelReportProduct extends Model {
		public function getProductsViewed($data = array()) {
			$sql = "SELECT pd.name, p.model, p.viewed FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.viewed > 0 ORDER BY p.viewed DESC";
			
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
			
			return $query->rows;
		}
		
		public function getTotalProductViews() {
			$query = $this->db->query("SELECT SUM(viewed) AS total FROM " . DB_PREFIX . "product");
			
			return $query->row['total'];
		}
		
		public function getTotalProductsViewed() {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE viewed > 0");
			
			return $query->row['total'];
		}
		
		public function reset() {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = '0'");
		}
		
		public function getMainCategoryName($product_id) {
			
			$query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "product_to_category p2c LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = p2c.category_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "') WHERE product_id = '" . (int)$product_id . "' ORDER BY main_category DESC LIMIT 1");
			
			return !empty($query->row['name'])?$query->row['name']:'';
		}
		
		public function getMainCollectionName($product_id) {
			
			$query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "product_to_collection p2c LEFT JOIN " . DB_PREFIX . "collection_description cd ON (cd.collection_id = p2c.collection_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "') WHERE product_id = '" . (int)$product_id . "' ORDER BY main_collection DESC LIMIT 1");
			
			return !empty($query->row['name'])?$query->row['name']:'';
		}
		
		public function getProductCustomerViewed($data = array()){
			$sql = "SELECT SUM(viewed) as total FROM `".DB_PREFIX."customer_product_viewed` ";
			
			$sql .=  " WHERE product_id = '". (int)$data['filter_product_id'] ."'";
			
			if (!empty($data['filter_date_start'])) {
				$sql .= " AND DATE(date) >= '" . $this->db->escape($data['filter_date_start']) . "'";
			}
			
			if (!empty($data['filter_date_end'])) {
				$sql .= " AND DATE(date) <= '" . $this->db->escape($data['filter_date_end']) . "'";
			}
			
			$sql .= " GROUP BY product_id";
			
			$query = $this->db->query($sql);
			
			return !empty($query->row['total'])?$query->row['total']:0;
		}
		
		public function getPurchased($data = array()) {
			$sql = "SELECT op.name, op.model, op.product_id, p.viewed, p.image, md.name as manufacturer, SUM(op.quantity) AS quantity, AVG(op.price) as avg_price, MIN(op.price) as min_price,  MAX(op.price) as max_price,  SUM(op.price * op.quantity) AS total 
			FROM " . DB_PREFIX . "order_product op 
			LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id)
			LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = op.product_id)
			LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (md.manufacturer_id = p.manufacturer_id AND md.language_id = '" . (int)$this->config->get('config_language_id') . "')
			";
			
			if (!empty($data['filter_order_status_id'])) {
				$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
				} else {
				$sql .= " WHERE o.order_status_id > '0'";
			}
			
			if (!empty($data['filter_date_start'])) {
				$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
			}
			
			if (!empty($data['filter_date_end'])) {
				$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
			}
			
			if (!empty($data['filter_category_id'])) {
				$sql .= " AND op.product_id IN (SELECT product_id FROM product_to_category WHERE category_id = '" . (int)$data['filter_category_id'] . "')";
			}
			
			if (!empty($data['filter_collection_id'])) {
				$sql .= " AND op.product_id IN (SELECT product_id FROM product_to_collection WHERE collection_id = '" . (int)$data['filter_collection_id'] . "')";
			}
			
			if (!empty($data['filter_manufacturer_id'])) {
				$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
			}
			
			if (!empty($data['filter_product_name'])) {
				$sql .= " AND op.product_id IN (SELECT product_id FROM " . DB_PREFIX . "product_description WHERE LOWER(name) LIKE ('%" . $this->db->escape(mb_strtolower($data['filter_product_name'])) . "%'))";
			}
			
			if (!empty($data['filter_date_end'])) {
				$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
			}
			
			$sql .= " GROUP BY op.product_id ORDER BY total DESC";
			
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
			
			return $query->rows;
		}
		
		public function getTotalPurchased($data) {
			$sql = "SELECT COUNT(DISTINCT op.product_id) AS total FROM `" . DB_PREFIX . "order_product` op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) 
			LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = op.product_id)";
			
			if (!empty($data['filter_order_status_id'])) {
				$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
				} else {
				$sql .= " WHERE o.order_status_id > '0'";
			}
			
			if (!empty($data['filter_date_start'])) {
				$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
			}
			
			if (!empty($data['filter_date_end'])) {
				$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
			}
			
			if (!empty($data['filter_category_id'])) {
				$sql .= " AND op.product_id IN (SELECT product_id FROM product_to_category WHERE category_id = '" . (int)$data['filter_category_id'] . "')";
			}
			
			if (!empty($data['filter_collection_id'])) {
				$sql .= " AND op.product_id IN (SELECT product_id FROM product_to_collection WHERE collection_id = '" . (int)$data['filter_collection_id'] . "')";
			}
			
			if (!empty($data['filter_manufacturer_id'])) {
				$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
			}
			
			if (!empty($data['filter_product_name'])) {
				$sql .= " AND op.product_id IN (SELECT product_id FROM " . DB_PREFIX . "product_description WHERE LOWER(name) LIKE ('%" . $this->db->escape(mb_strtolower($data['filter_product_name'])) . "%'))";
			}
			
			$query = $this->db->query($sql);
			
			return $query->row['total'];
		}
	}
