<?

namespace hobotix;

class hoboModelStocks extends hoboModel{


	public function getProductStocks($product_id){
		$stocks = [];

		$product_id_int = $product_id;

		if (!is_numeric($product_id)){
			$query = $this->db->query("SELECT product_id FROM oc_product WHERE uuid = '" . $this->db->escape($product_id) . "' LIMIT 1");

			if ($query->num_rows){
				$product_id_int = $query->row['product_id'];
			} else {
				$product_id_int = 0;
			}
		}

		$query = $this->db->query("SELECT s.*, l.uuid FROM oc_stocks s LEFT JOIN oc_location l ON (s.location_id = l.location_id) WHERE product_id = '" . (int)$product_id_int . "'");

		foreach ($query->rows as $row){
			$stocks[] = [
				'ProductID' 				=> $product_id, 	
				'DrugstoreID' 				=> $row['location_id'],
				'DrugstoreUUID' 			=> $row['uuid'],
				'ProductQuanity' 			=> $row['quantity'],
				'ProductQuanityParts' 		=> $row['quantity_of_parts'],
				'ProductPrice' 				=> $row['price'],
				'ProductPriceRetail'		=> $row['price_retail'],
				'ProductPriceOfPart'		=> $row['price_of_part'],
				'ProductPriceOfPartRetail'	=> $row['price_of_part_retail'],
				'ProductCount'				=> $row['count'],
				'ProductCountOfParts'		=> $row['counts_of_parts'],
				'ProductReserve'			=> $row['reserve'],
				'ProductReserveOfParts'		=> $row['reserve_of_parts']
			];
		}

		return $stocks;
	}

	public function updateStocks($stocks){
		$result = [];
		
		foreach ($stocks as $stock){
			$updatedStock = $this->updateProductStocks($stock['ProductID'], [$stock]);

			if ($updatedStock){				
				$result[] = [
					'ProductID' 	=> $stock['ProductID'],
					'DrugstoreID' 	=> $stock['DrugstoreID'],
					'Success' 		=> true
				];
			} else {
				$result[] = [
					'ProductID' 	=> $stock['ProductID'],
					'DrugstoreID' 	=> $stock['DrugstoreID'],
					'Success' 		=> false
				];
			}
		}

		return $result;
	}

	public function setProductQuantity($product_id){
	//	$this->db->query("UPDATE oc_product SET quantity = (SELECT SUM(quantity) FROM oc_stocks WHERE product_id = '" . (int)$product_id . "') WHERE product_id = '" . (int)$product_id . "'");

		$this->db->query("UPDATE oc_product p SET quantity = (SELECT SUM(quantity) FROM oc_stocks s WHERE location_id IN (SELECT location_id FROM oc_location WHERE temprorary_closed = 0) AND s.product_id = '" . (int)$product_id . "') WHERE p.product_id = '" . (int)$product_id . "'");
	}


	public function updateProductStocks($product_id, $stocks){
		if (!is_numeric($product_id)){
			$query = $this->db->query("SELECT product_id FROM oc_product WHERE uuid = '" . $this->db->escape($product_id) . "' LIMIT 1");

			if ($query->num_rows){
				$product_id = $query->row['product_id'];
			} else {
				$product_id = 0;
			}
		}

		if (!$product_id){
			return [];
		}

		foreach ($stocks as $stock){
			if (empty($stock['ProductQuanity'])){
				$stock['ProductQuanity'] = $stock['ProductCount'] - $stock['ProductReserve'];
			}

			if (empty($stock['ProductQuanityParts'])){
				$stock['ProductQuanityParts'] = $stock['ProductCount'] - $stock['ProductReserve'];
			}

			if (empty($stock['ProductPrice'])){
				$stock['ProductPrice'] = 0;
			}

			if (empty($stock['ProductPriceRetail'])){
				$stock['ProductPriceRetail'] = 0;
			}

			if (empty($stock['ProductPriceOfPart'])){
				$stock['ProductPriceOfPart'] = 0;
			}

			if (empty($stock['ProductPriceOfPartRetail'])){
				$stock['ProductPriceOfPartRetail'] = 0;
			}

			if (empty($stock['ProductCountOfParts'])){
				$stock['ProductCountOfParts'] = 0;
			}

			if (empty($stock['ProductReserveOfParts'])){
				$stock['ProductReserveOfParts'] = 0;
			}

			$this->db->query("INSERT INTO oc_stocks SET
				product_id			= '" . (int)$product_id . "',
				location_id 		= '" . (int)$stock['DrugstoreID'] . "',
				quantity 			= '" . (int)$stock['ProductQuanity'] . "',
				quantity_of_parts 	= '" . (int)$stock['ProductQuanityParts'] . "',
				price 				= '" . (float)$stock['ProductPrice'] . "',
				price_retail 		= '" . (float)$stock['ProductPriceRetail'] . "',
				price_of_part 		= '" . (float)$stock['ProductPriceOfPart'] . "',
				price_of_part_retail 	= '" . (float)$stock['ProductPriceOfPartRetail'] . "',
				count 					= '" . (int)$stock['ProductCount'] . "',
				counts_of_parts 		= '" . (int)$stock['ProductCountOfParts'] . "',
				reserve 				= '" . (int)$stock['ProductReserve'] . "',
				reserve_of_parts 		= '" . (int)$stock['ProductReserveOfParts'] . "'
				ON DUPLICATE KEY UPDATE
				quantity 			= '" . (int)$stock['ProductQuanity'] . "',
				quantity_of_parts 	= '" . (int)$stock['ProductQuanityParts'] . "',
				price 				= '" . (float)$stock['ProductPrice'] . "',
				price_retail 		= '" . (float)$stock['ProductPriceRetail'] . "',
				price_of_part 		= '" . (float)$stock['ProductPriceOfPart'] . "',
				price_of_part_retail 	= '" . (float)$stock['ProductPriceOfPartRetail'] . "',
				count 					= '" . (int)$stock['ProductCount'] . "',
				counts_of_parts 		= '" . (int)$stock['ProductCountOfParts'] . "',
				reserve 				= '" . (int)$stock['ProductReserve'] . "',
				reserve_of_parts 		= '" . (int)$stock['ProductReserveOfParts'] . "'");
		}

		$this->setProductQuantity($product_id);

		return $this->getProductStocks($product_id);
	}

}