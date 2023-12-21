<?

namespace hobotix;

class hoboModelPrice extends hoboModel{	


	public function getProductPrice($product_id){
		$prices = [];

		$product_id_int = $product_id;

		if (!is_numeric($product_id)){
			$query = $this->db->query("SELECT product_id FROM oc_product WHERE uuid = '" . $this->db->escape($product_id) . "' LIMIT 1");

			if ($query->num_rows){
				$product_id_int = $query->row['product_id'];
			} else {
				$product_id_int = 0;
			}
		}

		$query = $this->db->query("SELECT price FROM oc_product WHERE product_id = '" . (int)$product_id_int . "'");

		foreach ($query->rows as $row){
			$prices = [				
				'ProductID' 				=> $product_id, 					
				'ProductPrice' 				=> $row['price'],
				'Success' 					=> true
			];
		}

		return $prices;
	}


	public function updateProductPrice($product_id, $price){
		$this->db->query("UPDATE oc_product SET price = '" . (float)$price . "' WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("UPDATE oc_stocks SET price = '" . (float)$price . "' WHERE product_id = '" . (int)$product_id . "'");

		$this->db->query("UPDATE oc_product_option_value oopv LEFT JOIN oc_product p ON (p.product_id = oopv.product_id AND option_id = 2 AND option_value_id = 2) SET oopv.quantity = (p.quantity * p.count_of_parts), oopv.price = ROUND(p.price / p.count_of_parts, 2) WHERE oopv.product_id = '" . (int)$product_id . "' AND option_id = 2 AND option_value_id = 2");

		$this->db->query("UPDATE oc_product p SET p.price_of_part = ROUND(p.price / p.count_of_parts, 2) WHERE p.product_id = '" . (int)$product_id . "' AND p.count_of_parts > 0");
	}

	public function postAction(){
		$this->db->query("UPDATE oc_product SET status = '0' WHERE price = '0'");
	}

	public function updatePrices($prices){
		$result = [];

		foreach ($prices as $price){
			$product_id_int = $this->getProductIdByUUID($price['ProductID']);

			if ($product_id_int){
				$this->updateProductPrice($product_id_int, $price['ProductPrice']);
				$result[] = [
					'ProductID' => $price['ProductID'],
					'Success' 	=> true
				];
			} else {
				$result[] = [
					'ProductID' => $price['ProductID'],
					'Success' 	=> false
				];
			}
		}

		$this->postAction();

		return $result;
	}


/*************************************************************************************
* 
* PREORDER
* 
/*************************************************************************************/
	public function getProductPreorders(){
		$preorders = [];
		$query = $this->db->query("SELECT product_id, price, is_preorder, uuid FROM oc_product WHERE is_preorder = '1'");

		foreach ($query->rows as $row){
			$preorders[] = [				
				'ProductID' 				=> $row['product_id'], 					
				'ProductUUID' 				=> $row['uuid'],
				'ProductPrice' 				=> $row['price'],
				'ProductPreOrder' 			=> $row['is_preorder']
			];
		}

		return $preorders;
	}


	public function getProductPreorder($product_id){
		$preorders = [];

		$product_id_int = $product_id;

		if (!is_numeric($product_id)){
			$query = $this->db->query("SELECT product_id FROM oc_product WHERE uuid = '" . $this->db->escape($product_id) . "' LIMIT 1");

			if ($query->num_rows){
				$product_id_int = $query->row['product_id'];
			} else {
				$product_id_int = 0;
			}
		}

		$query = $this->db->query("SELECT price, is_preorder FROM oc_product WHERE product_id = '" . (int)$product_id_int . "'");

		foreach ($query->rows as $row){
			$prices = [				
				'ProductID' 				=> $product_id, 					
				'ProductPrice' 				=> $row['price'],
				'ProductPreOrder' 			=> $row['is_preorder'],
				'Success' 					=> true
			];
		}

		return $prices;
	}

	public function updateProductPreorder($product_id, $price){
		$stocks = $this->db->query("SELECT SUM(quantity) as stocks FROM oc_stocks s WHERE s.product_id = '" . (int)$product_id . "'")->row['stocks'];

		if ($product_id && !empty($price) && (float)$price > 0 && (int)$stocks == 0){
			$this->db->query("UPDATE oc_product SET is_preorder = 1, quantity = 10 WHERE product_id = '" . (int)$product_id . "'");	
			$this->updateProductPrice($product_id, $price);

		} elseif ($product_id && (empty($price) || (float)$price == 0) && (int)$stocks == 0){
			$this->db->query("UPDATE oc_product SET is_preorder = 0, quantity = 0, price = '0' WHERE product_id = '" . (int)$product_id . "'");
		}
	}


	public function updatePreorder($preorders){
		$result = [];

		$this->db->query("UPDATE oc_product SET is_preorder = 0 WHERE 1");
		
		foreach ($preorders as $preorder){
			$product_id 	= $preorder['ProductID'];
			$product_id_int = $product_id;

			if (!is_numeric($product_id)){
				$query = $this->db->query("SELECT product_id FROM oc_product WHERE uuid = '" . $this->db->escape($product_id) . "' LIMIT 1");

				if ($query->num_rows){
					$product_id_int = $query->row['product_id'];
				} else {
					$product_id_int = 0;
				}
			}


			if ($product_id_int){
				$this->updateProductPreorder($product_id_int, $preorder['ProductPrice']);

				$result[] = $this->getProductPreorder($product_id_int);
			} else {
				$result[] = [
					'ProductID' => $preorder['ProductID'],
					'Success' 	=> false
				];
			}
		}

		return $result;
	}
}