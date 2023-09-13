<?php
	class ControllerEaptekaOrder extends Controller
	{
		private $address = "";
		private $login = "";
		private $node_id = 0;
		private $order_id = 0;
		private $password = "";
		private $data = "";
		private $global_location_id = 7;
		
		private $sendFastOrders = true;
		
		private $excludedOrderStatuses = [
		8, //Выполнен
		5  //Отменен
		];
		
		private $leftShoreRegions = array('Дарницький','Деснянський','Дніпровський');
		
		public function index()
		{ }

		public function test(){			
			error_reporting(true);
			ini_set('display_errors', true);

			 $this->load->model('eapteka/order');
			// $query = $this->db->query("SELECT order_id FROM `oc_order` WHERE order_id >= 172006 AND order_status_id > 0 AND order_status_id NOT IN (8,4)");

			// foreach ($query->rows as $row){
			// 	$json = $this->model_eapteka_order->writeOrderToRestAPI($row['order_id']);			 	
			// }			

			$json = $this->model_eapteka_order->writeOrderToRestAPI(172345);

			$this->log->debug($json);
		}
			
		
		private function getCustomFieldValue($custom_field_id, $custom_field_value_id){
			$query = $this->db->query("SELECT name FROM `" . DB_PREFIX . "custom_field_value_description` WHERE custom_field_id = '" . (int) $this->db->escape($custom_field_id) . "' AND custom_field_value_id = '" . (int) $this->db->escape($custom_field_value_id) . "' AND language_id = '" . $this->config->get('config_language_id') . "'");
			
			return isset($query->row['name']) ? $query->row['name'] : '';
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
		
		private function setNode($node){
			
			$this->node_id 	= $node['node_id'];
			$this->address 	= $node['node_url'];
			$this->login 	= $node['node_auth'];
			$this->password = $node['node_password'];
		}
		
		private function setCurrentOrderID($order_id){
			$this->order_id = $order_id;
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
					return date('Ymd');
				}
				
				if ($customer_field_value == '8') {
					return date('Ymd', strtotime("+1 day"));
				}
				
				if ($customer_field_value == '9') {
					return date('Ymd', strtotime("+2 day"));
				}
				
				return false;
			}
		}
		
		private function customFieldsToValues($custom_field_id, $customer_field_value_id){			
			if ($custom_field_id == 2) {
				$r = array(
                4 =>     'з 10:00 до 14:00',
                10 =>    'з 14:00 до 18:00',
                11 =>    'з 19:00 до 23:59'
				);
				
				return isset($r[$customer_field_value_id]) ? $r[$customer_field_value_id] : false;
			}
			
			if ($custom_field_id == 3) {
				
				if ($customer_field_value_id == 7) {
					return date('Ymd');
				}
				
				if ($customer_field_value_id == 8) {
					return date('Ymd', strtotime("+1 day"));
				}
				
				if ($customer_field_value_id == 9) {
					return date('Ymd', strtotime("+2 day"));
				}
				
				return false;
			}
		}

		private function sendOrderAlertToBitrix($order_id){

			$this->load->library('hobotix/BitrixBot');
			$this->bitrixBot = new hobotix\BitrixBot($this->registry);

			$this->load->model('checkout/order');
			if ($order = $this->model_checkout_order->getOrder($order_id)){

				if ($order['shipping_code'] == 'multiflat.multiflat1'){

					$message = array(
						'message' => ':!: :!: Замовлення з експрес-доставкою!',
						'attach' => array(
							"ID" => 1,
							"COLOR" => "#29619b",
							"BLOCKS" => Array(
								Array("USER" => Array(
									"NAME"      => "Зверніть увагу, у замовленні " . $order_id . " клієнт обрав експрес-доставку по Києву",
									"AVATAR"    => "https://e-apteka.com.ua/bitrix/images/bitrixavatar.jpg",
								)),

								Array("DELIMITER" => Array(
									'SIZE' => 200,
									'COLOR' => "#c6c6c6"
								)),

								Array("MESSAGE" => "[I]Номер замовлення 1С[/I] [B]" . $order['eapteka_id'] . "[/B]"),
								Array("MESSAGE" => "[I]Номер замовлення сайта[/I] " . $order_id),
								Array("MESSAGE" => "[I]Телефон клієнта[/I] " . $order['telephone']),						

							)));

					try{
						if (!$this->bitrixBot->logRequest()->loadConfigFile()->validateAppsConfig()){
							return;
						}

						$this->bitrixBot->sendMessageToGroup(BITRIX_24_FASTORDER_GROUP, $message);

					} catch(Exception $e){}
				}
			}
		}
		
		private function setData($data)
		{
			$this->data = json_encode($data);
		}
		
		private function setGlobalLocationID($location_id)
		{
			$this->global_location_id = $location_id;
		}
		
		private function updateOrderJSON($order_id, $location_json)
		{
			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET location_json = '" . $this->db->escape(json_encode($location_json)) . "' WHERE order_id = '" . (int) $order_id . "'");
		}
		
		private function updateOrderFullJSON($order_id, $full_json)
		{
			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET full_json = '" . $this->db->escape(json_encode($full_json)) . "' WHERE order_id = '" . (int) $order_id . "'");
		}
		
		private function updateOrderUUID($order_id, $uuid){
			
			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET uuid = '" . $this->db->escape($uuid) . "' WHERE order_id = '" . (int) $order_id . "'");
			
		}
		
		private function updateOrderEaptekaID($order_id, $eapteka_id){			
			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET eapteka_id = '" . $this->db->escape($eapteka_id) . "' WHERE order_id = '" . (int) $order_id . "'");						
		}
		
		private function getOrderEaptekaID($order_id){
			
			$query = $this->db->query("SELECT eapteka_id FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int) $order_id . "'");
			
			if ($query->num_rows){
				return $query->row['eapteka_id'];
				} else {
				return false;
			}
			
		}
		
		private function getOrderUUID($order_id){
			$query = $this->db->query("SELECT uuid FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int) $order_id . "'");
			
			if ($query->num_rows){
				return $query->row['uuid'];
				} else {
				return '';
			}
		}
		
		private function getOrderIDByUUID($uuid){			
			$query = $this->db->query("SELECT order_id FROM `" . DB_PREFIX . "order` WHERE uuid = '" . $this->db->escape( $uuid ). "'");
			
			if ($query->num_rows){
				return $query->row['order_id'];
				} else {
				return '';
			}
		}
				
		private function prepareComment($data = array())
		{
			return implode(PHP_EOL, $data);
		}
		
		public function monitorqueue(){
			$this->load->library('hobotix/TelegramSender');
			$telegramSender = new hobotix\TelegramSender;
			
			$query = $this->db->query("SELECT COUNT(*) as total FROM `" . DB_PREFIX . "order_queue`");
			
			if ($query->row['total'] > 5){				
				$message = '';
				$message .= 'https://e-apteka.com.ua/cat_info.jpg' . PHP_EOL;
				$message .= '<b>Возможно, что-то пошло не так</b>' . PHP_EOL;
				$message .= '<b>В очереди на обмен сейчас ' . $query->row['total'] . ' заказов</b>' . PHP_EOL;
				$message .= '<b>Скрипт:</b> ' . basename(__FILE__) . PHP_EOL;
				
				$telegramSender->SendMessage($message);
			}
			
			//Все заказы кроме быстрых
			$query = $this->db->query("SELECT order_id FROM `" . DB_PREFIX . "order`  WHERE eapteka_id = ''  AND fastorder = 0 AND DATE(date_added) >= '2020-11-06' AND order_status_id > 0 AND order_id NOT IN (SELECT order_id FROM `" . DB_PREFIX . "order_queue` WHERE 1)");
			
			//Быстрые заказы с 23.02.2022
			if ($this->sendFastOrders){
				$query2 = $this->db->query("SELECT order_id FROM `" . DB_PREFIX . "order`  WHERE eapteka_id = ''  AND fastorder = 1 AND order_id > 151124 AND order_status_id > 0 AND order_id NOT IN (SELECT order_id FROM `" . DB_PREFIX . "order_queue` WHERE 1)");
			}
			
			$concatenatedQuery = [];
			
			if ($query->num_rows){
				foreach ($query->rows as $row){
					$concatenatedQuery[] = $row;
				}
			}
			
			if ($this->sendFastOrders){
				if ($query2->num_rows){
					foreach ($query2->rows as $row2){
						$concatenatedQuery[] = $row2;
					}
				}
			}
			
			
			if ($concatenatedQuery){
				
				$missedOrders = array();
				foreach ($concatenatedQuery as $row){
					
					$order_id = $row['order_id'];
					
					$order_info = $this->model_checkout_order->getOrder($order_id);
					$order_products = $this->model_checkout_order->getOrderProducts($order_id);
				
				if ($order_info && $order_products) {
					$this->db->query("INSERT INTO  `" . DB_PREFIX . "order_queue` SET order_id = '" . (int)$order_id . "', date_added = NOW()");
					$missedOrders[] = $order_id;
				}
				
				}
				
				$message = '';
				$message .= 'https://e-apteka.com.ua/cat_coder.jpg' . PHP_EOL;
				$message .= '<b>[INFO]</b> This is test debug piece of information <b>[INFO]</b>' . PHP_EOL;
				$message .= '<b>[ENGINE DEBUG]</b> Unescaped numeric ' . implode(', ', $missedOrders) . ' in virtual debug sequence <b>[ENGINE DEBUG]</b>' . PHP_EOL;
				$message .= '<b>[PHP DEBUG]</b> Stack trace is not used in this case, cause of unlimitness of tracing <b>[PHP DEBUG]</b>' . PHP_EOL;
				
				//	$telegramSender->SendMessage($message);
			}			
		}
		
		private function startQueue(){			
			if (file_exists(DIR_CACHE . 'orderqueue.pid')){				
				die('[EAPTEKA SYNC] Очередь работает!' . PHP_EOL);
				} else {
				touch(DIR_CACHE . 'orderqueue.pid');
			}						
		}
		
		private function stopQueue(){			
			if (file_exists(DIR_CACHE . 'orderqueue.pid')){
				unlink(DIR_CACHE . 'orderqueue.pid');
			}			
		}
				
		public function orderstatus(){
			$this->load->model('localisation/location');
			$this->load->model('checkout/order');
			
			$this->setGlobalLocationID(7);
			$this->setNode($this->model_localisation_location->getLocationNode($this->global_location_id));

			$sql = "SELECT order_id, eapteka_id, uuid, date_added FROM `" . DB_PREFIX . "order` 
			WHERE  
			order_status_id > 0 ";
			
			if ($this->sendFastOrders){
				$sql .= "AND ((fastorder = 0 AND DATE(date_added) >= '2022-01-01') OR DATE(date_added) >= '2022-02-02')";		
			} else {
				$sql .= "AND ((fastorder = 0 AND DATE(date_added) >= '2022-01-01'))";
			}
			
			$sql .= "AND eapteka_id <> ''
			AND uuid <> ''
			AND order_status_id NOT IN (" . implode(',', $this->excludedOrderStatuses) . ") ORDER BY RAND() LIMIT 500";
			
			$query = $this->db->query($sql);
			
			if ($query->num_rows){
				$orders = [];
				foreach ($query->rows as $row){				
					$orders[] = [
					'uuid' 	 => $row['uuid'], 
					'number' => $row['eapteka_id'],
					'year'	 => date('Y', strtotime($row['date_added']))
					];
				}
			}
			
			if ($orders){
				$json = array(
				'status' 	=> 'true',
				'stock'		=> '0b9f4dbf-2777-11ec-9fcd-000c29276315',
				'orders' 	=> $orders
				);
				
				$this->setData($json);
				
				$result = $this->pushJSON();	
				
				print_r($result);					
				
				foreach ($result as $order){
					
					echoLine('[STATUS] Заказ ' . $order['uuid'] . '');
					
					$order_status_id = (int)$order['status'];
					
					if ($order_status_id && $order_id = $this->getOrderIDByUUID($order['uuid'])){
						
						if ($order_info = $this->model_checkout_order->getOrder($order_id)){
							
							if ($order_status_id != $order_info['order_status_id']){		
								
								echoLine('[STATUS] Заказ ' . $order_id .', новый статус: ' . $order_status_id);
								
								$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
								
								$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = 'false', comment = '', date_added = NOW()");
							}
							
						}
						
						} else {
						
						echoLine('[STATUS] Заказ ' . $order['uuid'] .' не найден');
						
					}
				}
				
			}
		}
				
		public function queue(){
			$this->load->model('checkout/order');
			
			$this->monitorqueue();
			$this->startQueue();
			
			$orderQuery = $this->db->ncquery("SELECT * FROM `" . DB_PREFIX . "order_queue` ORDER BY date_added ASC LIMIT 3");
			
			foreach ($orderQuery->rows as $row){
				$order_info = $this->model_checkout_order->getOrder($row['order_id']);			
				
				if (!$order_info){
					$this->db->ncquery("DELETE FROM `" . DB_PREFIX . "order_queue` WHERE order_id = '" . (int)$row['order_id'] . "'");	
					
					$success = true;
					continue;
				}	
				
				if (!$this->sendFastOrders && $order_info['fastorder']){
					echo '[EAPTEKA SYNC] Это быстрый заказ! Удаляем заказ ' . (int)$row['order_id'] . ' из очереди' . PHP_EOL  . PHP_EOL;
					$this->db->ncquery("DELETE FROM `" . DB_PREFIX . "order_queue` WHERE order_id = '" . (int)$row['order_id'] . "'");
					
					$success = true;
					} else {
					
					
					$this->setGlobalLocationID(7);
					$result = $this->sendOrder($row['order_id']);			
					
					$success = false;
					
					//Предоплата
					if ($order_info['order_status_id'] == 9){
						if (is_array($result) && isset($result['answer']) && trim($result['answer']) == 'Добавлена информация о предоплате'){
							$success = true;
						}
						
						if (is_array($result) && isset($result['answer']) && trim($result['answer']) == 'Повторная отправка информации о предоплате, полученной ранее!'){
							$success = true;
						}
						
						if (is_array($result) && isset($result['answer']) && trim($result['answer']) == 'Повторная посылка, заказ не обновлялся'){
							$success = true;
						}
						
						if (is_array($result) && isset($result['answer']) && trim($result['answer']) == 'Заказ не найден или заблокирован'){
							$success = true;
						}
						
						if (is_array($result) && isset($result['answer']) && trim($result['answer']) == 'Чек пробит'){
							$success = true;
						}
						
						//Не предоплата
						} else {
						
						if (is_array($result) && isset($result['id_order']) && trim($result['id_order']) && trim($result['id_order']) != 'null'){
							$success = true;
						}
						
						if (is_array($result) && isset($result['answer']) && trim($result['answer']) == 'Добавлена информация о предоплате'){
							$success = true;
						}
						
						if (is_array($result) && isset($result['answer']) && trim($result['answer']) == 'Повторная посылка, заказ не обновлялся'){
							$success = true;
						}
						
						if (is_array($result) && isset($result['answer']) && trim($result['answer']) == 'Повторная отправка информации о предоплате, полученной ранее!'){
							$success = true;
						}
						
						if (is_array($result) && isset($result['answer']) && trim($result['answer']) == 'Заказ не найден или заблокирован'){
							$success = true;
						}
						
						if (is_array($result) && isset($result['answer']) && trim($result['answer']) == 'Чек пробит'){
							$success = true;
						}
					}
					
					
					//ADD TO HISTORY
					if (!is_array($result)){
						$result = array('result' => $result);
					}
					
					if ($success){
						
						echo '[EAPTEKA SYNC] Удаляем заказ ' . (int)$row['order_id'] . ' из очереди' . PHP_EOL  . PHP_EOL;
						$this->db->ncquery("DELETE FROM `" . DB_PREFIX . "order_queue` WHERE order_id = '" . (int)$row['order_id'] . "'");
						
						} else {
						$this->load->library('hobotix/TelegramSender');
						$telegramSender = new hobotix\TelegramSender;
						
						$message = '';
						$message .= 'https://e-apteka.com.ua/fiasko.jpg' . PHP_EOL;
						$message .= '<b>Джентльмены, у нас ошибка отправки инфы о заказе ' . $row['order_id'] . '!</b>' . PHP_EOL;
						$message .= '<b>Скрипт:</b> ' . basename(__FILE__) . PHP_EOL;
						$message .= '<b>Статус заказа: ' . $order_info['order_status_id'] . ' </b>' . PHP_EOL;
						$message .= '<b>Узел:</b> ' . $this->global_location_id . PHP_EOL;
						$message .= '<b>Ответочка:</b> ' . substr(serialize($result),0,500) . '';
						
						$telegramSender->SendMessage($message);
					}					
				}
			}
			
			$this->stopQueue();		
		}
								
		private function pushJSON(){
			$this->load->model('localisation/location');
			//	$log = new Log('send_to_odinass.txt');
			//	$log->write(serialize($this->address));
			
			if ($this->address) {
				
				$this->model_localisation_location->setNodeLastUpdateStatusSuccess($this->node_id);
				
				$constants = get_defined_constants(true);
				$json_errors = array();
				foreach ($constants["json"] as $name => $value) {
					if (!strncmp($name, "JSON_ERROR_", 11)) {
						$json_errors[$value] = $name;
					}
				}
				
				$_headers = [
				'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
				'Accept-Encoding: gzip, deflate',
				'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
				'Cache-Control: max-age=0',
				'Connection: keep-alive',
				'Upgrade-Insecure-Requests: 1'
				];
				
				echo '[EAPTEKA SYNC] --------------------------------------------------' . PHP_EOL;
				echo '[EAPTEKA SYNC] Отправляем данные ' . serialize($this->data) . PHP_EOL;
				echo '[EAPTEKA SYNC] --------------------------------------------------' . PHP_EOL;
				
				file_put_contents(DIR_LOGS . 'json.order.log/' . $this->order_id . '.' . date('Y.m.d.h.i.s') . '.json', $this->data);
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $this->address);
				curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $_headers);
				curl_setopt($ch, CURLOPT_TIMEOUT, 2000);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2000);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
				curl_setopt($ch, CURLOPT_USERAGENT, 'EAPTEKA 1C SYNC ' . VERSION);
				curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate");
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_USERPWD, $this->login . ':' . $this->password);
				curl_setopt($ch, CURLOPT_VERBOSE, true);
				
				$data = curl_exec($ch);
				$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				
				//	$data = 'Сгенерированная ошибка!';	
				
				curl_close($ch);
				
				var_dump($data);
				
				$data = trim($data);
				$bom = pack('H*', 'EFBBBF');
				$data = preg_replace('/[\x00-\x1F]/', '', $data);
				$data = preg_replace("/^$bom/", '', $data);
				
				echo '[EAPTEKA SYNC] --------------------------------------------------' . PHP_EOL;
				echo '[EAPTEKA SYNC] Получили данные ' . $data . PHP_EOL;
				echo '[EAPTEKA SYNC] --------------------------------------------------' . PHP_EOL;
				
				$this->db->query("INSERT IGNORE INTO `oc_order_send_history` SET
				`order_id` = '" . $this->order_id . "',
				`date_added` = NOW(),
				`data` = '" . $this->db->escape(json_encode($this->data)) . "',
				`json` = '" . $this->db->escape($data) . "'");
				
				if ($json = json_decode($data, true)) {
					
					$this->model_localisation_location->setNodeLastUpdateStatus($this->node_id, 'NODE_ORDER_UPLOAD_SUCCESS');
					$this->model_localisation_location->setNodeLastUpdateStatusSuccess($this->node_id);
					
					$history_data = array(
					'status' => 'NODE_ORDER_UPLOAD_SUCCESS',
					'type'   => 'order',
					'json'   => $data,
					'is_error' => 0
					);
					$this->model_localisation_location->addNodeExchangeHistory($this->node_id, $history_data);
					
					return $json;
					} else {
					
					$this->model_localisation_location->setNodeLastUpdateStatus($this->node_id, $json_errors[json_last_error()]);
					$this->model_localisation_location->setNodeLastUpdateStatusError($this->node_id);
					
					$history_data = array(
					'status' => $json_errors[json_last_error()],
					'type'   => 'order',
					'json'   => $data,
					'is_error' => 1
					);
					$this->model_localisation_location->addNodeExchangeHistory($this->node_id, $history_data);
					
					return array(
					'error'=> $json_errors[json_last_error()],
					'data' => $data
					);
				}
				} else {
				
				return 'ERROR_INVALID_NODE';
			}
		}
		
		public function addOrderToQueue(&$route = '', &$input_data = array(), &$output = null){
			$this->load->model('checkout/order');
			$this->load->model('account/order');
			$this->load->model('catalog/product');
			$this->load->model('localisation/location');
			$this->load->model('tool/simplecustom');  
			
			$order_id = (isset($input_data[0]) && is_int($input_data[0]) && $input_data[0]) ? $input_data[0] : false;
			
			$redirect = true;
			if (isset($input_data[5]) && $input_data[5] == false){
				$redirect = false;	
			}
			
			if (!$order_id) {
				
			} else {

				$order_info = $this->model_checkout_order->getOrder($order_id);
				$order_products = $this->model_checkout_order->getOrderProducts($order_id);

				if ($order_info && $order_products) {
					$this->load->model('eapteka/order');
					$this->model_eapteka_order->writeOrderToRestAPI($order_id);
				}

				if ($redirect){
					$this->response->redirect($this->url->link('checkout/success'));
				}
			}
		}
				
		public function sendOrder($order_id){
			$this->load->model('checkout/order');
			$this->load->model('account/customer');
			$this->load->model('account/order');
			$this->load->model('catalog/product');
			$this->load->model('localisation/location');
			$this->load->model('tool/simplecustom');
			$this->load->model('catalog/product');   
			
			if (!$order_id) {
				die();
			}			
			
			$this->setCurrentOrderID($order_id);
			echo '[EAPTEKA SYNC] Начали работу с заказом ' . $order_id . PHP_EOL;
			
			$order_info 		= $this->model_checkout_order->getOrder($order_id);
			$order_products 	= $this->model_checkout_order->getOrderProducts($order_id);
			$customer_info 		= $this->model_account_customer->getCustomer($order_info['customer_id']);
			$customInfo 		= $this->model_tool_simplecustom->getCustomFields('order', $order_info['order_id'], $order_info['language_code'], false);
			$customInfoValues 	= $this->model_tool_simplecustom->getCustomFields('order', $order_info['order_id'], $order_info['language_code'], false);
			
			$result_json = array();
			
			if ($order_info && $order_products) {
				$this->setGlobalLocationID(7);
				
				$products = array();
				foreach ($order_products as $product) {
					
					$real_product 	= $this->model_catalog_product->getProduct($product['product_id']);
					$options 		= $this->model_checkout_order->getOrderOptions($order_id, $product['order_product_id']);
					
					$product['quantity_parts'] = $product['quantity'];					
					if ($real_product['count_of_parts'] && $options && !empty($options[0]) && $options[0]['option_id'] == 2){
						$product['quantity'] = round(((round((1 / $real_product['count_of_parts']), 3)) * $product['quantity']), 3);
					}
					
					$products[] = array(
					'product_id'     	=> $product['product_id'],
					'amount'        	=> $product['quantity'],
					'amount_ed_izm'		=> $product['quantity_parts'],
					'price'          	=> $product['price'],
					'total'          	=> $product['total'],
					'name'           	=> $product['name'],
					'model'          	=> $product['model'],
					'nomenclature'     	=> $this->model_catalog_product->getProductUUID($product['product_id']),
					'stock'         	=> '',
					'stock_name'     	=> ''
					);
				}
				
				$dd = '';
				if (isset($customInfo['day'])) {
					if ($this->simpleCustomFieldsToValues('day', $customInfo['day'])) {
						$dd = $this->simpleCustomFieldsToValues('day', $customInfo['day']);
						} else {
						$dd = $this->simpleCustomFieldsToValues('day', $customInfo['day']);
					}
				}
				
				$id = '';
				if (isset($customInfo['time'])) {
					if ($this->simpleCustomFieldsToValues('time', $customInfo['time'])) {
						$id = $this->simpleCustomFieldsToValues('time', $customInfo['time']);
						} else {
						$id = $this->simpleCustomFieldsToValues('time', $customInfo['time']);
					}
				}
				
				$ks = '';
				if (isset($customInfoValues['shipping_kyivshore'])) {
					$ks = $customInfoValues['shipping_kyivshore'];
				}								
				
				//куда отправлять
				//первый вариант - доставка курьером, разделение по левому и правому берегу
				if ($order_info['shipping_code'] == 'multiflat.multiflat0' || $order_info['shipping_code'] == 'multiflat.multiflat1') {
					//по дефолту - 5 аптека
					$this->setGlobalLocationID(7);
					
					if (isset($customInfo['shipping_courier_street'])) {
						if ($this->getIfStreetIsOnLeftSide($customInfo['shipping_courier_street'])) {
							
							echoLine('[SIDE] Левый берег!');
							
							//4 аптека в случае левого берега
							$this->setGlobalLocationID(6);
						}
					}
				}								
				
				if ($order_info['shipping_code'] == 'pickup.pickup') {					
					$location_id = 7;

					if ($order_id == '154316'){
						var_dump($order_info);
						die();
					}
					
					if ($order_info['location_id'] || (isset($customInfo['location_id']) && $customInfo['location_id'])) {
						
						if (isset($customInfo['location_id']) && $customInfo['location_id']){
							$location_id = (int)$customInfo['location_id'];
						} elseif ($order_info['location_id']){
							$location_id = (int)$order_info['location_id'];
						}
						
						if ($location_id && $this->model_localisation_location->getLocation($location_id) && $this->model_localisation_location->getLocationNode($location_id)) {
							$this->setGlobalLocationID($location_id);
						}
					}
				}				
				
				$payment_info = array(
					'ipay' => array(
						'ipay_id' 			=> $order_info['ipay_id'],
						'ipay_amount' 		=> $order_info['ipay_amount'],
						'ipay_info'			=> array('order_id' => $order_id),
						'ipay_description'	=> 'Оплата замовлення №' . $order_id,
						'ipay_xml'			=> base64_encode($order_info['ipay_xml'])
					),
					'whitepay' => array(
						'whitepay_id' 			=> $order_info['whitepay_order_id'],
						'whitepay_status'		=> $order_info['whitepay_status'],
						'whitepay_amount'		=> $order_info['whitepay_amount'],						
						'whitepay_json'			=> $order_info['whitepay_json']
					)
				);		
				
				$order_histories = array();
				foreach ($this->model_account_order->getOrderHistories($order_id) as $order_history){
					$order_histories[] = array(
					'status' 			=> $order_history['status'],
					'order_status_id' 	=> $order_history['order_status_id'],
					'date_added'		=> date('Ymd', strtotime($order_history['date_added']))
					);
				}
				
				$comment_array = array(
				'Номер заказа: ' . $order_info['order_id'], 
				'Доставка: ' . $order_info['shipping_method'], 
				'Оплата: ' . $order_info['payment_method']
				);
				
				if (trim($order_info['payment_city'])){
					$comment_array[]= 'Город: ' . $order_info['payment_city'];				
				}
				
				$comment_array[]= $order_info['comment'];
				
				$delivery_address = trim($order_info['shipping_city'] . ', ' . $order_info['shipping_address_1'] . ' ' . $order_info['shipping_address_2']);
				if ($order_info['shipping_code'] == 'pickup.pickup'){
					$delivery_address = 'Самовывоз';
				}
				
				$this->db->query("UPDATE `" . DB_PREFIX . "order` SET telephone = '" . $this->db->escape($order_info['telephone']) . "', fax = '" . $this->db->escape($order_info['fax']) . "'  WHERE order_id = '" . (int)$order_id . "'");
				
				if (empty(trim($order_info['fax']))){
					$order_info['fax'] = $order_info['telephone'];
				}
				
				$data = array(
				'source'             	=> 'e-apteka.com.ua',
				'status'				=> 'false',
				'Ordercancel'         	=> 'false',
				'ZakazUID'             	=> $this->getOrderUUID($order_id),
				'order_id'          	=> $order_id,
				'order_status_id'       => $order_info['order_status_id'],
				'order_status'       	=> $order_info['order_status'],
				'order_histories'       => $order_histories,
				'barcode'            	=> $customer_info?$customer_info['card']:'',			
				'phone'              	=> normalizePhone($order_info['telephone']),
				'phone2'            	=> normalizePhone($order_info['fax']),
				'city'              	=> trim($order_info['payment_city']),
				'addressdostavka'    	=> $delivery_address,
				'recipient'         	=> trim($order_info['firstname'] . ' ' . $order_info['lastname']),
				'recipient2'         	=> trim($order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname']),
				'stock'              	=> $this->model_localisation_location->getLocationUUID($this->global_location_id),
				'pay_by_card'          	=> ($order_info['payment_code'] == 'free_checkout'),
				'goods'              	=> $products,
				'shipping_code'     	=> $order_info['shipping_code'],
				'shipping_method'    	=> $order_info['shipping_method'],
				'payment_code'         	=> $order_info['payment_code'],
				'payment_method'     	=> $order_info['payment_method'],
				'payment_info'			=> $payment_info,
				'current_time'			=> date('Y.m.d H:i:s'),
				'komorder'             	=> $this->prepareComment($comment_array),
				'komdostavka'         	=> $this->prepareComment($comment_array),
				'KyivShore'            	=> $ks,
				'DateDostavka'        	=> $dd,
				'Intdostavka'          	=> $id,
				'customer_info'			=> array(
				'customer_id'	=> !empty($order_info['customer_id'])?$order_info['customer_id']:'',
				'uuid' 			=> !empty($customer_info['uuid'])?$customer_info['uuid']:'',
				'card' 			=> !empty($customer_info['card'])?$customer_info['card']:'',
				'firstname' 	=> !empty($customer_info['firstname'])?$customer_info['firstname']:'',
				'lastname' 		=> !empty($customer_info['lastname'])?$customer_info['lastname']:'',
				'telephone'		=> !empty($customer_info['telephone'])?$customer_info['telephone']:'',
				'email'			=> !empty($customer_info['email'])?$customer_info['email']:''
				)
				);			
				
				$this->setNode($this->model_localisation_location->getLocationNode($this->global_location_id));
				
				$tryMax = 3;
				$tryCounter = 0;
				
				if ($order_info['order_status_id'] == 9){		
					
					$statusSent = false;
					$statusHistory = array();
					
					for ($tryCounter = 0; $tryCounter <= $tryMax; $tryCounter++){
						
						$data['ZakazUID'] = $this->getOrderUUID($order_id);
						echo '[EAPTEKA SYNC] Заказ с iPay, цикл из 4 штук, UUID ' . $data['ZakazUID'] . PHP_EOL;
						
						$this->setData($data);
						$result = $this->pushJSON();	
						
						$statusHistory[] = serialize($result);
						
						if (is_array($result) && isset($result['answer']) && (trim($result['answer']) == 'Добавлена информация о предоплате' || trim($result['answer']) == 'Повторная отправка информации о предоплате, полученной ранее!') || trim($result['answer']) == 'Чек пробит'){
							//Все ок
							$statusSent = true;
							echo '[EAPTEKA SYNC] Удаляем заказ ' . (int)$order_id . ' из очереди' . PHP_EOL  . PHP_EOL;
							$query = $this->db->query("DELETE FROM `" . DB_PREFIX . "order_queue` WHERE order_id = '" . (int)$order_id . "'");
							break;
							
							} elseif (is_array($result) && isset($result['id_order'])){
							$result_json[] = array(
							'location_id' 		=> $this->global_location_id,
							'uuid'        		=> $result['id_order'],
							'text_id'     		=> $result['number_order'],
							'no_comment'  		=> $result['Net'],								
							);
							
							$this->updateOrderUUID($order_id, $result['id_order']);
							$this->updateOrderEaptekaID($order_id, $result['number_order']);
							$this->updateOrderJSON($order_id, $result_json);
							$this->updateOrderFullJSON($order_id, $result);
						}
						
						
						sleep(1);
						
						//Это новый заказ, была первая отправка
					}					
					
					if (!$statusSent){
						$this->load->library('hobotix/TelegramSender');
						$telegramSender = new hobotix\TelegramSender;
						
						$lineHistory = '<b>История ответок:</b> ';
						foreach ($statusHistory as $statusHistoryLine){
							$lineHistory .= '<b>-></b>' . $statusHistoryLine . PHP_EOL;
						}
						
						$message = '';
						$message .= 'https://e-apteka.com.ua/fiasko.jpg' . PHP_EOL;
						$message .= '<b>Джентльмены, у нас ошибка отправки инфы о заказе ' . $order_id . '!</b>' . PHP_EOL;
						$message .= '<b>Заказ оплачен с iPay!</b>' . PHP_EOL;
						$message .= '<b>Статус заказа ' . $order_info['order_status_id'] . '</b>' . PHP_EOL;
						$message .= '<b>Скрипт:</b> ' . basename(__FILE__) . PHP_EOL;
						$message .= '<b>Узел:</b> ' . $this->global_location_id . PHP_EOL;
						$message .= '<b>Откуда:</b> ' . 'Первичный цикл из 5 отправок' . PHP_EOL;
						$message .= $lineHistory;
						$message .= '<b>Ответочка:</b> ' . substr(serialize($result),0,500) . '';
						
						$telegramSender->SendMessage($message);
					}
					
					} else {
					
					$data['ZakazUID'] = $this->getOrderUUID($order_id);
					echo '[EAPTEKA SYNC] Заказ не в статусе 9' . $data['ZakazUID'] . PHP_EOL;
					
					$this->setData($data);
					$result = $this->pushJSON();										
					
					if (!is_array($result)) {
						
						$this->load->library('hobotix/TelegramSender');
						$telegramSender = new hobotix\TelegramSender;
						
						$message = '';
						$message .= 'https://e-apteka.com.ua/fiasko.jpg' . PHP_EOL;
						$message .= '<b>Джентльмены, у нас ошибка отправки инфы о заказе!</b>' . PHP_EOL;
						$message .= '<b>Скрипт:</b> ' . basename(__FILE__) . PHP_EOL;
						$message .= '<b>Узел:</b> ' . $this->global_location_id . PHP_EOL;
						$message .= '<b>Ответочка:</b> ' . substr(serialize($result),0,500) . '';
						
						$telegramSender->SendMessage($message);
						
						//Это был новый заказ
						} elseif (is_array($result) && isset($result['id_order'])){
						
						$result_json[] = array(
						'location_id' => $this->global_location_id,
						'uuid'        => $result['id_order'],
						'text_id'     => $result['number_order'],
						'no_comment'  => $result['Net'],
						);
						
						
						$this->updateOrderUUID($order_id, $result['id_order']);
						$this->updateOrderEaptekaID($order_id, $result['number_order']);
						$this->updateOrderJSON($order_id, $result_json);
						$this->updateOrderFullJSON($order_id, $result);
						} else {
						
						echo '[EAPTEKA SYNC] Это пока что непонятная ситуация, ' . $data['ZakazUID'] . PHP_EOL;
						
					}
				}
				
				return $result;
			}
		}
	}
