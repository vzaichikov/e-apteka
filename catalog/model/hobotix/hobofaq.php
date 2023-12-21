<?php
	
	class ModelHobotixHoboFAQ extends Model {
	
		private function productReturnCall($query, $limit = 1){
			$this->load->model('catalog/product');
			$product_data = array();	
			
			if ($query->num_rows && $limit == 1){
				return $this->model_catalog_product->getProduct($query->row['product_id']);
			}
			
			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
			}
			
			return $product_data;
		}
	
		//Самый дешевый
		public function getCheapestProductsForCategory($category_id, $limit = 1){
			$query = $this->db->query("SELECT p.product_id
			FROM `oc_product` p
			LEFT JOIN `oc_product_to_store` p2s ON (p.product_id = p2s.product_id) 
			LEFT JOIN `oc_product_to_category` p2c ON (p2c.product_id = p.product_id)
			LEFT JOIN `oc_category_path` cp ON (p2c.category_id = cp.category_id)
			WHERE
			p.status = '1' AND 
			p.quantity > 0 AND
			p.price > 0 AND
			p.date_available <= NOW() AND 
			cp.path_id = '" . (int)$category_id . "' AND 
			p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY price ASC LIMIT " . (int)$limit);
			
			return $this->productReturnCall($query, $limit);
		}
		
		public function getCheapestProductsForManufacturer($manufacturer_id, $limit = 1){					
			$query = $this->db->query("SELECT p.product_id
			FROM `oc_product` p
			LEFT JOIN `oc_product_to_store` p2s ON (p.product_id = p2s.product_id) 	
			WHERE
			p.manufacturer_id = '" . (int)$manufacturer_id . "' AND
			p.status = '1' AND 
			p.quantity > 0 AND
			p.price > 0 AND
			p.date_available <= NOW() AND 		
			p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY price ASC LIMIT " . (int)$limit);
			
			return $this->productReturnCall($query, $limit);
		}
		
		//Самый дорогой
		public function getExpensiveProductsForCategory($category_id, $limit = 1){		
			$query = $this->db->query("SELECT p.product_id
			FROM `oc_product` p
			LEFT JOIN `oc_product_to_store` p2s ON (p.product_id = p2s.product_id) 
			LEFT JOIN `oc_product_to_category` p2c ON (p2c.product_id = p.product_id)
			LEFT JOIN `oc_category_path` cp ON (p2c.category_id = cp.category_id)
			WHERE
			p.status = '1' AND 
			p.quantity > 0 AND
			p.price > 0 AND
			p.date_available <= NOW() AND 
			cp.path_id = '" . (int)$category_id . "' AND 
			p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY price DESC LIMIT " . (int)$limit);
			
			return $this->productReturnCall($query, $limit);
		}
		
		public function getExpensiveProductsForManufacturer($manufacturer_id, $limit = 1){		
			$query = $this->db->query("SELECT p.product_id
			FROM `oc_product` p
			LEFT JOIN `oc_product_to_store` p2s ON (p.product_id = p2s.product_id) 	
			WHERE
			p.manufacturer_id = '" . (int)$manufacturer_id . "' AND
			p.status = '1' AND 
			p.quantity > 0 AND
			p.price > 0 AND
			p.date_available <= NOW() AND 
			p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY price DESC LIMIT " . (int)$limit);
			
			return $this->productReturnCall($query, $limit);
		}
		
		//Самый популярный
		public function getMostPopularProductsForCategory($category_id, $limit = 1){		
			$query = $this->db->query("SELECT p.product_id
			FROM `oc_product` p
			LEFT JOIN `oc_product_to_store` p2s ON (p.product_id = p2s.product_id) 
			LEFT JOIN `oc_product_to_category` p2c ON (p2c.product_id = p.product_id)
			LEFT JOIN `oc_category_path` cp ON (p2c.category_id = cp.category_id)
			WHERE
			p.status = '1' AND 
			p.quantity > 0 AND
			p.price > 0 AND
			p.date_available <= NOW() AND 
			cp.path_id = '" . (int)$category_id . "' AND 
			p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC LIMIT " . (int)$limit);
			
			return $this->productReturnCall($query, $limit);
		}
		
		public function getMostPopularProductsForManufacturer($manufacturer_id, $limit = 1){		
			$query = $this->db->query("SELECT p.product_id
			FROM `oc_product` p
			LEFT JOIN `oc_product_to_store` p2s ON (p.product_id = p2s.product_id) 
			WHERE
			p.manufacturer_id = '" . (int)$manufacturer_id . "' AND
			p.status = '1' AND 
			p.quantity > 0 AND
			p.price > 0 AND
			p.date_available <= NOW() AND 		
			p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC LIMIT " . (int)$limit);
			
			return $this->productReturnCall($query, $limit);
		}
		
		//Самый покупаемый
		public function getBestSellerProductsForCategory($category_id, $limit = 1){		
			$query = $this->db->query("SELECT op.product_id, COUNT(*) AS total
			FROM `oc_order_product` op 
			LEFT JOIN `oc_order` o ON (op.order_id = o.order_id) 
			LEFT JOIN `oc_product` p ON (op.product_id = p.product_id) 
			LEFT JOIN `oc_product_to_store` p2s ON (p.product_id = p2s.product_id) 
			LEFT JOIN `oc_product_to_category` p2c ON (p2c.product_id = p.product_id)
			LEFT JOIN `oc_category_path` cp ON (p2c.category_id = cp.category_id)
			WHERE 
			o.order_status_id > '0' AND 
			p.status = '1' AND 
			p.quantity > 0 AND
			p.price > 0 AND 
			p.date_available <= NOW() AND 
			cp.path_id = '" . (int)$category_id . "' AND 
			DATE(o.date_added) > DATE_SUB(NOW(), INTERVAL 3 MONTH) AND
			p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit, [], true);
			
			return $this->productReturnCall($query, $limit);	
		}
		
		public function getBestSellerProductsForManufacturer($manufacturer_id, $limit = 1){		
			$query = $this->db->query("SELECT op.product_id, COUNT(*) AS total
			FROM `oc_order_product` op 
			LEFT JOIN `oc_order` o ON (op.order_id = o.order_id) 
			LEFT JOIN `oc_product` p ON (op.product_id = p.product_id) 
			LEFT JOIN `oc_product_to_store` p2s ON (p.product_id = p2s.product_id) 	
			WHERE 
			p.manufacturer_id = '" . (int)$manufacturer_id . "' AND
			o.order_status_id > '0' AND 
			p.status = '1' AND 
			p.quantity > 0 AND 
			p.date_available <= NOW() AND
			DATE(o.date_added) > DATE_SUB(NOW(), INTERVAL 3 MONTH) AND 		
			p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);
			
			return $this->productReturnCall($query, $limit);	
		}
		
		//Самый обсуждаемый
		public function getMostReviewsProductsForCategory($category_id, $limit = 1){	
			$query = $this->db->query("SELECT r.product_id, COUNT(*) AS total
			FROM `oc_review` r 			
			LEFT JOIN `oc_product` p ON (r.product_id = p.product_id) 
			LEFT JOIN `oc_product_to_store` p2s ON (p.product_id = p2s.product_id) 
			LEFT JOIN `oc_product_to_category` p2c ON (p2c.product_id = p.product_id)
			LEFT JOIN `oc_category_path` cp ON (p2c.category_id = cp.category_id)
			WHERE 
			p.status = '1' AND 
			p.quantity > 0 AND
			p.price > 0 AND 
			p.date_available <= NOW() AND 
			cp.path_id = '" . (int)$category_id . "' AND 
			p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY r.product_id ORDER BY total DESC LIMIT " . (int)$limit);
			
			return $this->productReturnCall($query, $limit);
		}
		
		public function getMostReviewsProductsForManufacturer($manufacturer_id, $limit = 1){	
			$query = $this->db->query("SELECT r.product_id, COUNT(*) AS total
			FROM `oc_review` r 			
			LEFT JOIN `oc_product` p ON (r.product_id = p.product_id) 
			LEFT JOIN `oc_product_to_store` p2s ON (p.product_id = p2s.product_id) 
			WHERE
			p.manufacturer_id = '" . (int)$manufacturer_id . "' AND
			p.status = '1' AND 
			p.quantity > 0 AND
			p.price > 0 AND 
			p.date_available <= NOW() AND 		
			p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY r.product_id ORDER BY total DESC LIMIT " . (int)$limit);
			
			return $this->productReturnCall($query, $limit);
		}
		
		//Самый новый
		public function getNewestProductsForCategory($category_id, $limit = 1){	
			$query = $this->db->query("SELECT p.product_id
			FROM `oc_product` p
			LEFT JOIN `oc_product_to_store` p2s ON (p.product_id = p2s.product_id) 
			LEFT JOIN `oc_product_to_category` p2c ON (p2c.product_id = p.product_id)
			LEFT JOIN `oc_category_path` cp ON (p2c.category_id = cp.category_id)
			WHERE
			p.status = '1' AND 
			p.quantity > 0 AND
			p.price > 0 AND
			p.date_available <= NOW() AND 
			cp.path_id = '" . (int)$category_id . "' AND 			
			p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);
			
			return $this->productReturnCall($query, $limit);
		}
		
		public function getNewestProductsForManufacturer($manufacturer_id, $limit = 1){	
			$query = $this->db->query("SELECT p.product_id
			FROM `oc_product` p
			LEFT JOIN `oc_product_to_store` p2s ON (p.product_id = p2s.product_id) 
			WHERE
			p.manufacturer_id = '" . (int)$manufacturer_id . "' AND
			p.status = '1' AND 
			p.quantity > 0 AND
			p.price > 0 AND
			p.date_available <= NOW() AND 		
			p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);
			
			return $this->productReturnCall($query, $limit);
		}
		
		
		private function parseHandMadeFAQ($query){
			
			$data = array();
			
			foreach($query->rows as $faq) {
				$questions = unserialize($faq['question']);
				$answer = unserialize($faq['faq']);
				
				if (isset($questions[$this->config->get('config_language_id')]) && isset($answer[$this->config->get('config_language_id')])) {
				
				//	var_dump($answer[$this->config->get('config_language_id')]);
				
					$data[] = array(
					'question' 		=> html_entity_decode($questions[$this->config->get('config_language_id')]),
					'answer' 		=> html_entity_decode($answer[$this->config->get('config_language_id')]),
					'icon' 			=> $faq['icon'],
					'sort_order' 	=> $faq['sort_order']
					);
				}
			}
			
			return $data;
			
		}
		
		//FAQ заданный руками
		public function getProductFaq($product_id) {
			$query = $this->db->query("SELECT * FROM oc_product_faq WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");
			
			return $this->parseHandMadeFAQ($query);
		}
		
		
		public function getCategoryFaq($category_id) {
			$query = $this->db->query("SELECT * FROM oc_category_faq WHERE category_id = '" . (int)$category_id . "' ORDER BY sort_order ASC");
			
			return $this->parseHandMadeFAQ($query);
		}
		
		public function getManufacturerFaq($manufacturer_id) {
			$query = $this->db->query("SELECT * FROM oc_manufacturer_faq WHERE manufacturer_id = '" . (int)$manufacturer_id . "' ORDER BY sort_order ASC");
			
			return $this->parseHandMadeFAQ($query);
		}
		
		public function getInformationFaq($information_id) {
			$query = $this->db->query("SELECT * FROM oc_information_faq WHERE information_id = '" . (int)$information_id . "' ORDER BY sort_order ASC");
			
			return $this->parseHandMadeFAQ($query);
		}

		
	}			