<?

namespace hobotix;

class hoboModelOrder extends hoboModel{	
	private $leftShoreRegions = array('Дарницький','Деснянський','Дніпровський');


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

	public function getOrders($location_uuid){
		$orders = [];
		$query = $this->db->query("SELECT * FROM oc_order_queue_rest WHERE drugstore_uuid = '" . $this->db->escape($location_uuid) . "'");


		foreach ($query->rows as $row){
			$orders[] = json_decode($row['json'], true);
		}

		return $orders;
	}

	public function getOrdersFromFiles($location_id){
		$file = SELF_REST_PATH . '/queue/orders/' . $location_id . '/orders.json';

		if (file_exists($file)){
			$handler = fopen($file, 'r+');

			if (flock($handler,  LOCK_EX)){
				$orders = file_get_contents($file);
				fclose($handler);
				$orders = json_decode($orders, true);
			}
			
			if ($orders){
				return $orders;
			}
		}

		return [];
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

	public function confirmOrder($order_id, $data){
		$query = $this->db->query("UPDATE oc_order o SET o.uuid = '" . $this->db->escape($data['orderUUID']) . "', o.eapteka_id = '" . $this->db->escape($data['orderMSID']) . "' WHERE o.order_id = '" . (int)$order_id . "'");
		$order = $this->getOrder($order_id);		
		$customInfo = $this->db->ncquery("SELECT * FROM oc_order_simple_fields WHERE order_id = '". (int)$order_id ."'")->row;

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
			$drugstore_query = $this->db->query("SELECT uuid FROM oc_location WHERE location_id = '" . (int)$drugstore_id . "'");
			if (!empty($drugstore_query->row['uuid'])){
				$drugstore_uuid = $drugstore_query->row['uuid'];
			}
		}

		$this->db->query("DELETE FROM oc_order_queue_rest WHERE order_id = '" . $order_id . "'");

		return [
			'orderID' 		=> $order_id,
			'orderUUID' 	=> $order['uuid'],
			'orderMSID' 	=> $order['eapteka_id'],
			'drugstoreID' 	=> $drugstore_id,
			'drugstoreUUID' => $drugstore_uuid,
		];
	}
		

	public function editOrder(){
	}	

}