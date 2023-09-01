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
	}


	public function updatePrices($prices){
		$result = [];

		foreach ($prices as $price){
			$product_id = $price['ProductID'];

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
				$this->updateProductPrice($product_id, $price['ProductPrice']);

				$result[] = $this->getProductPrice($product_id);
			} else {
				$result[] = [
					'ProductID' => $price['ProductID'],
					'Success' 	=> false
				];
			}
		}

		return $result;
	}



















}