<?

namespace hobotix;

class hoboModelStocks extends hoboModel{


	public function getProductStocks($product_id){
		$stocks = [];

		$product_id_int = $this->getProductIdByUUID($product_id);

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
		
		if (!empty($stocks[0]) && !empty($stocks[0]['DrugstoreID'])){
			if (!is_numeric($stocks[0]['DrugstoreID'])){
				$query = $this->db->query("SELECT * FROM oc_location ol WHERE ol.uuid = '" . $this->db->escape($stocks[0]['DrugstoreID']) . "' LIMIT 1");
				if ($query->num_rows){
					$DrugstoreID = (int)$query->row['location_id'];
				}
			} else {
				$DrugstoreID = (int)$stocks[0]['DrugstoreID'];
			}				
		}		

		$this->db->query("DELETE FROM oc_stocks_existent WHERE drugstore_id = '" . (int)$DrugstoreID . "'" );	

		foreach (array_chunk($stocks, 1000) as $chunk) {
			$sql = "INSERT INTO oc_stocks_existent (`product_uuid`, `drugstore_id`) VALUES ";
			foreach ($chunk as $row) {
  				$sql .= "('" . $row['ProductID'] . "', '" . $DrugstoreID . "'),"; 
			}

			$sql = rtrim($sql, ',');
			$this->db->query($sql);
		}

		foreach ($stocks as $stock){		
			$stock['DrugstoreID'] = $DrugstoreID;
			$product_id = $this->updateProductStocks($stock['ProductID'], [$stock]);

			if ($product_id){				
				$result[] = [
					'ProductID' 	=> $stock['ProductID'],
					'ProductIDInt' 	=> $product_id,
					'Success' 		=> true
				];
			} else {
				$result[] = [
					'ProductID' 	=> $stock['ProductID'],
					'Success' 		=> false
				];
			}
		}

		$this->db->query("UPDATE oc_stocks SET quantity = 0, quantity_of_parts = 0, count = 0, counts_of_parts = 0, reserve = 0 WHERE product_uuid NOT IN (SELECT product_uuid FROM oc_stocks_existent WHERE drugstore_id = '" . (int)$DrugstoreID . "') AND location_id = '" . (int)$DrugstoreID . "'");
		$this->db->query("UPDATE oc_product p SET quantity = (SELECT SUM(quantity) FROM oc_stocks s WHERE s.product_id = p.product_id AND location_id IN (SELECT location_id FROM oc_location WHERE temprorary_closed = 0) GROUP BY s.product_id) WHERE p.is_preorder = 0");
		$this->db->query("UPDATE oc_product p SET is_onstock = IF(quantity <= 0, 0, 1);");

		return $result;
	}

	public function updateProductStocks($product_id, $stocks){		
		$product_id_int = $this->getProductIdByUUID($product_id);

		if (!$product_id_int){
			return false;
		}

		foreach ($stocks as $stock){

			if ($stock['ProductQuanity'] <= 0){
				$stock['ProductQuanity'] = 0;
			}

			$this->db->query("INSERT INTO oc_stocks SET
				product_id				= '" . (int)$product_id_int . "',
				product_uuid			= '" . $this->db->escape($product_id) . "',
				location_id 			= '" . (int)$stock['DrugstoreID'] . "',
				quantity 				= '" . (int)$stock['ProductQuanity'] . "',
				quantity_of_parts 		= '" . (int)$stock['ProductQuanity'] . "',
				count 					= '" . (int)$stock['ProductCount'] . "',
				reserve 				= '" . (int)$stock['ProductReserve'] . "'
				ON DUPLICATE KEY UPDATE
				product_uuid			= '" . $this->db->escape($product_id) . "',
				quantity 				= '" . (int)$stock['ProductQuanity'] . "',
				quantity_of_parts 		= '" . (int)$stock['ProductQuanity'] . "',				
				count 					= '" . (int)$stock['ProductCount'] . "',
				reserve 				= '" . (int)$stock['ProductReserve'] . "'");
		}

		return $product_id_int;
	}

}