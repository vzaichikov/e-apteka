<?php
class ModelEaptekaOrder extends Model
{
	public function writeOrderToRestAPI($order_id){

		$orders_query = $this->db->ncquery("SELECT *,  
			(SELECT os.name FROM `oc_order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = o.language_id) AS order_status, 
			(SELECT oc.customer_uuid FROM `oc_customer` oc WHERE oc.customer_id = o.customer_id) AS customer_uuid
			FROM `oc_order` o  WHERE order_id = '" . (int)$order_id . "' LIMIT 1");

		if ($orders_query->num_rows){
			$order = $orders_query->row;
			$products = [];
			$products_query = $this->db->ncquery("SELECT op.*, p.uuid, p.count_of_parts FROM `oc_order_product` op LEFT JOIN oc_product p ON p.product_id = op.product_id  WHERE op.order_id = '" . (int)$order['order_id'] . "'");
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
					'productPrice' 			=> $product['price'],
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
					'ipay_info'			=> ['order_id' => $order['order_id']],
					'ipay_description'	=> 'Оплата замовлення №' . $order['order_id'],
					'ipay_xml'			=> base64_encode($order['ipay_xml'])
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

				if ($drugstore_id){
					$drugstore_query = $this->db->query("SELECT uuid FROM oc_location WHERE location_id = '" . (int)$drugstore_id . "'");
					if (!empty($drugstore_query->row['uuid'])){
						$drugstore_uuid = $drugstore_query->row['uuid'];
					}
				}
			}

			$json = [
				'orderID' 		=> $order['order_id'],
				'orderUUID' 	=> $order['uuid'],
				'orderMSID' 	=> $order['eapteka_id'],					
				'orderStatus' 	=> $order['order_status'],
				'orderStatusID' => $order['order_status_id'],
				'orderTotal' 	=> $order['total'],

				'shippingInfo' 	=> [
					'shippingCode' 		=> $order['shipping_code'],
					'shippingMethod' 	=> $order['shipping_method'],
					'shippingCity' 		=> $order['shipping_city'],
					'shippingAddress' 	=> $order['shipping_address_1'],						
					'shippingDate' 		=> $shipping_date,
					'shippingTime' 		=> $shipping_time,
					'drugstoreID' 		=> $drugstore_id,
					'drugstoreUUID' 	=> $drugstore_uuid
				],


				'customerInfo' 	=> [
					'customerID' 				=> $order['customer_id'],
					'customerUUID' 				=> $order['customer_uuid'],
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

			addToJSONCachedFile(DIR_REST_API_ORDERS . $drugstore_uuid, $json, 'orderID');
		}
	}

}