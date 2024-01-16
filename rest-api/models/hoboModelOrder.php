<?

namespace hobotix;

class hoboModelOrder extends hoboModel{	
	private $leftShoreRegions = array('Дарницький','Деснянський','Дніпровський');
	private $shippingUUID     = '86fc6f5d-4aee-11ee-bba8-00505601220a';

	private function simpleCustomFieldsToValues($custom_field, $customer_field_value){			
		if ($custom_field == 'time') {
			$r = array(
				'2' =>    'з 10:00 до 14:00',
				'3' =>    'з 14:00 до 18:00',
				'4' =>    'з 19:00 до 23:59'
			);

			return isset($r[$customer_field_value]) ? $r[$customer_field_value] : false;
		}

		if ($custom_field == 'day') {

			if ($customer_field_value == '7') {
				return date('Y-m-d');
			}

			if ($customer_field_value == '8') {
				return date('Y-m-d', strtotime("+1 day"));
			}

			if ($customer_field_value == '9') {
				return date('Y-m-d', strtotime("+2 day"));
			}

			return false;
		}
	}

	private function getIfStreetIsOnLeftSide($street_id){
		$query = $this->db->query("SELECT district FROM `kyiv_streets` WHERE street_id = '" . (int)$street_id . "' LIMIT 1");
		$district = $query->row['district'];

		foreach ($this->leftShoreRegions as $region){

			if (strpos($district,$region) !== false){
				return true;
			}
		}

		return false;
	}

	public function getOrderJSON($order_id, $action = false){

		if (!is_numeric($order_id)){
			$orders_query = $this->db->query("SELECT order_id FROM oc_order WHERE uuid = '" . $this->db->escape($order_id) . "' OR eapteka_id = '" . $this->db->escape($order_id) . "' LIMIT 1");

			if ($orders_query->num_rows){
				$order_id = $orders_query->row['order_id'];
			} else {
				return false;
			}

		}

		$orders_query = $this->db->ncquery("SELECT *,  
			(SELECT os.name FROM `oc_order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = o.language_id) AS order_status, 
			(SELECT oc.customer_uuid FROM `oc_customer` oc WHERE oc.customer_id = o.customer_id) AS customer_uuid
			FROM `oc_order` o  WHERE order_id = '" . (int)$order_id . "' LIMIT 1");

		if (!$orders_query->num_rows){
			return false;
		}

		if ($orders_query->num_rows){
			$order = $orders_query->row;
			$products = [];
			$products_query = $this->db->ncquery("SELECT op.*, p.uuid, p.count_of_parts, p.price as price_full FROM `oc_order_product` op LEFT JOIN oc_product p ON p.product_id = op.product_id  WHERE op.order_id = '" . (int)$order['order_id'] . "'");
			foreach ($products_query->rows as $product){
				$options = $this->db->ncquery("SELECT * FROM oc_order_option WHERE order_id = '" . (int)$order['order_id'] . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'")->rows;

				$product['quantity_parts'] = $product['quantity'];					
				if ($product['count_of_parts'] && $options && !empty($options[0]) && $options[0]['option_id'] == 2){
					$product['quantity'] = round(((round((1 / $product['count_of_parts']), 3)) * $product['quantity']), 3);
				}

				$products[] = [
					'productID' 			=> $product['product_id'],
					'productName' 			=> $product['name'],
					'productUUID' 			=> $product['uuid'],
					'productQuantity' 		=> $product['quantity'],
					'productQuantityParts' 	=> $product['quantity_parts'],
					'productExactPrice' 	=> $product['price'],
					'productPrice' 			=> $product['price_full'],
					'productTotal' 			=> $product['total'],
				];
			}

			$totals = [];
			$totals_query = $this->db->ncquery("SELECT * FROM `oc_order_total` ot WHERE ot.order_id = '" . (int)$order['order_id'] . "'");
			foreach ($totals_query->rows as $total){
				$totals[] = [
					'totalName' 	=> $total['title'],
					'totalCode' 	=> $total['code'],
					'totalTotal' 	=> $total['value']
				];

				if ($total['code'] == 'shipping' && (float)$total['value'] > 0){
					$products[] = [
						'productID' 			=> 'shipping',
						'productName' 			=> 'shipping',
						'productUUID' 			=> $this->shippingUUID,
						'productQuantity' 		=> 1,
						'productQuantityParts' 	=> 1,
						'productExactPrice' 	=> $total['value'],
						'productPrice' 			=> $total['value'],
						'productTotal' 			=> $total['value'],
					];
				}
			}


			$histories = [];
			$histories_query = $this->db->ncquery("SELECT oh.order_status_id, date_added, os.name AS status, oh.comment, oh.notify FROM oc_order_history oh LEFT JOIN oc_order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order['order_id'] . "' AND os.language_id = '3' ORDER BY oh.date_added DESC");
			foreach ($histories_query->rows as $history){
				$histories[] = [
					'statusName' 	=> $history['status'],
					'statusDate' 	=> $history['date_added'],
					'statusComment' => !empty($history['comment'])?$history['comment']:null
				];
			}

			$payment_info = [
				'paymentCode' 			=> $order['payment_code'],
				'paymentMethod' 		=> $order['payment_method'],
				'ipay' => [
					'ipay_id' 			=> $order['ipay_id'],
					'ipay_amount' 		=> $order['ipay_amount'],
					'ipay_info'			=> ['order_id' => $order['order_id']]
					// 'ipay_description'	=> 'Оплата замовлення №' . $order['order_id'],
					// 'ipay_xml'			=> base64_encode($order['ipay_xml'])
				]
			];		


			$customInfo = $this->db->ncquery("SELECT * FROM oc_order_simple_fields WHERE order_id = '". (int)$order['order_id'] ."'")->row;
			$shipping_date = null;
			$shipping_time = null;

			if (!empty($customInfo['day'])) {
				$shipping_date = $this->simpleCustomFieldsToValues('day', $customInfo['day']);
			}

			if (!empty($customInfo['time'])) {
				$shipping_time = $this->simpleCustomFieldsToValues('time', $customInfo['time']);
			}

			$drugstore_id 	= null;
			$drugstore_uuid = REST_API_NOLOCATION_UUID;

			if ($order['shipping_code'] == 'pickup.pickup') {
				if ($order['location_id'] || (!empty($customInfo['location_id']))) {						
					if (!empty($customInfo['location_id'])){
						$drugstore_id = (int)$customInfo['location_id'];
					} elseif ($order['location_id']){
						$drugstore_id = (int)$order['location_id'];
					}
				}			
			}

			if ($order['shipping_code'] == 'multiflat.multiflat0' || $order['shipping_code'] == 'multiflat.multiflat1') {
				$drugstore_id = 7;

				if (isset($customInfo['shipping_courier_street'])) {
					if ($this->getIfStreetIsOnLeftSide($customInfo['shipping_courier_street'])) {				
						$drugstore_id = 6;
					}
				}
			}	

			if (in_array($order['shipping_code'], ['novaposhta.warehouse', 'novaposhta.doors', 'ukrposhta.express_w', 'ukrposhta.express_d'])){
				$drugstore_id = 7;
			}

			if (!$order['location_id']){
				$drugstore_id = 7;
			}

			if ($drugstore_id){
				$drugstore_query = $this->db->query("SELECT uuid, name FROM oc_location WHERE location_id = '" . (int)$drugstore_id . "'");
				if (!empty($drugstore_query->row['uuid'])){
					$drugstore_uuid = $drugstore_query->row['uuid'];
					$drugstore_name = $drugstore_query->row['name'];
				}
			}


			$json = [
				'orderID' 		=> $order['order_id'],
				'orderUUID' 	=> $order['uuid'],
				'orderMSID' 	=> $order['eapteka_id'],					
				'orderStatus' 	=> $order['order_status'],
				'orderStatusID' => $order['order_status_id'],
				'orderPaid' 	=> (bool)$order['paid'],
				'orderTotal' 	=> $order['total'],
				'orderComment' 	=> $order['comment'],

				'shippingInfo' 	=> [
					'shippingCode' 		=> $order['shipping_code'],
					'shippingMethod' 	=> $order['shipping_method'],
					'shippingCity' 		=> $order['shipping_city'],
					'shippingAddress' 	=> $order['shipping_address_1'],					
					'shippingDate' 		=> $shipping_date,
					'shippingTime' 		=> $shipping_time,
					'drugstoreID' 		=> $drugstore_id,
					'drugstoreUUID' 	=> $drugstore_uuid,
					'drugstoreUnknown'  => ($order['location_id'] == '0')?true:false
				],

				'novaPoshtaInfo' => [
					'novaPoshtaAreaUUID' 		=> $order['novaposhta_area_guid'],
					'novaPoshtaCityUUID' 		=> $order['novaposhta_city_guid'],
					'novaPoshtaWarehouseUUID' 	=> $order['novaposhta_warehouse_guid']
				],

				'customerInfo' 	=> [
					'customerID' 				=> $order['customer_id'],
					'customerUUID' 				=> $order['customer_uuid'],
					'customerEmail' 			=> $order['email'],
					'recipientName' 			=> $order['firstname'],
					'recipientLastname' 		=> !empty($order['lastname'])?$order['lastname']:null,
					'recipientPhone'    		=> normalizePhone($order['telephone']),						
					'otherRecipientName' 		=> !empty($order['shipping_firstname'])?$order['shipping_firstname']:null,
					'otherRecipientLastname' 	=> !empty($order['shipping_lastname'])?$order['shipping_lastname']:null,
					'otherRecipientPhone'   	=> !empty(normalizePhone($order['fax']))?normalizePhone($order['fax']):null,
				],


				'totalsInfo' 	=> $totals,
				'paymentInfo' 	=> $payment_info,
				'historyInfo' 	=> $histories,
				'productsList' 	=> $products
			];

			if ($action == 'queue'){
				$this->db->query("INSERT INTO oc_order_queue_rest SET 
					drugstore_uuid 	= '" . $this->db->escape($drugstore_uuid) . "',
					order_id 		= '" . (int)$order['order_id'] . "',
					shipping_code 	= '" . $this->db->escape($order['shipping_code']) . "',
					total 			= '" . (float)($order['total']) . "',
					date_added 		= '" . $this->db->escape($order['date_added']) . "',
					json 			= '" . $this->db->escape(json_encode($json)) . "'
					ON DUPLICATE KEY UPDATE
					shipping_code 	= '" . $this->db->escape($order['shipping_code']) . "', 
					total 			= '" . (float)($order['total']) . "',
					date_added 		= '" . $this->db->escape($order['date_added']) . "',
					json 			= '" . $this->db->escape(json_encode($json)) . "'		
					");

				return [
					'orderID' 		=> $order_id,
					'drugstoreID' 	=> $drugstore_id,
					'drugstoreUUID' => $drugstore_uuid
				];
			}
			
			if ($action == 'return'){
				return $json;
			}			
		}
	}

	public function getOrderStatuses(){
		$result = [];
		$query = $this->db->ncquery("SELECT * FROM oc_order_status");		

		if ($query->num_rows){
			foreach ($query->rows as $row){				
				if (empty($result[$row['order_status_id']])){
					$result[$row['order_status_id']] = [
						'orderStatusID' 		=> $row['order_status_id'],
						'orderStatusName_RU' 	=> '',
						'orderStatusName_UA' 	=> '',
					];
				}		
			}

			foreach ($query->rows as $row){
				if ($row['language_id'] == 2){
					$result[$row['order_status_id']]['orderStatusName_RU'] = $row['name'];
				}
				
				if ($row['language_id'] == 3){
					$result[$row['order_status_id']]['orderStatusName_UA'] = $row['name'];
				}
			}

			$result = array_values($result);

			return $result;
		}

		return false;
	}

	public function getOrders($location_uuid){
		$orders = [];
		$query = $this->db->query("SELECT * FROM oc_order_queue_rest WHERE drugstore_uuid = '" . $this->db->escape($location_uuid) . "'");


		foreach ($query->rows as $row){
			$orders[] = json_decode($row['json'], true);
		}

		return $orders;
	}

	public function getOrder($order_id){
		$query = $this->db->ncquery("SELECT * FROM oc_order o WHERE o.order_id = '" . (int)$order_id . "' OR uuid = '" . $this->db->escape($order_id) . "' LIMIT 1");		

		if ($query->num_rows){
			return $query->row;
		}

		return false;
	}

	public function addOrderHistory($order_id, $data){
		$this->db->query("UPDATE oc_order SET order_status_id = '" . (int)$data['orderStatusID'] . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

		if (empty($data['orderComment'])){
			$data['orderComment'] = '';
		}

		$this->db->query("INSERT INTO oc_order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$data['orderStatusID'] . "', notify = '" . (int)false . "', comment = '" . $this->db->escape($data['orderComment']) . "', date_added = NOW()");

		$order = $this->getOrder($order_id);	

		return [
			'orderID' 		=> $order_id,
			'orderUUID' 	=> $order['uuid'],
			'orderStatusID' => $order['order_status_id'],
		];
	}

	public function confirmOrder($order_id, $data){
		$query = $this->db->query("UPDATE oc_order o SET o.uuid = '" . $this->db->escape($data['orderUUID']) . "', o.eapteka_id = '" . $this->db->escape($data['orderMSID']) . "' WHERE o.order_id = '" . (int)$order_id . "'");
		$order = $this->getOrder($order_id);				

		$this->db->query("DELETE FROM oc_order_queue_rest WHERE order_id = '" . $order_id . "'");

		return [
			'orderID' 		=> $order_id,
			'orderUUID' 	=> $order['uuid'],
			'orderMSID' 	=> $order['eapteka_id']
		];
	}
		
	public function editOrder(){
	}	

}