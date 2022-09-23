<?php
	ini_set('memory_limit', '-1');
	class ControllerEaptekaCustomer extends Controller {
		private $error = array();
		private $nodes = array();
		private $address = "";
		private $login = "";
		private $password = "";
		private $json_file = DIR_CATALOG . "/customer.json";
		private $exchange_data = "";
		private $fastLogic = false;
		
		private $card_endpoint = '';
		
		private $customer_uuid_array = array();
		private $customer_group_uuid_array = array();
		
		private function convert($size)
		{
			$unit=array('b','kb','mb','gb','tb','pb');
			return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
		}
		
		private function initNodes(){
			
			$this->load->model('setting/nodes');
			$this->nodes = $this->model_setting_nodes->getNodesForCustomerUpdate();
			
			return $this;
		}
		
		private function setFastLogic(){
			
			if (defined('CUSTOMER_FAST')){
				$this->fastLogic = true;
				} else {
				$this->fastLogic = false;
			}
			
			return $this;
			
		}
		
		private function initCustomer(){
			
			if (!$this->fastLogic){
				echo '[i] Инициализация клиентов...' . PHP_EOL;
				$query = $this->db->query("SELECT customer_id, uuid FROM oc_customer WHERE 1");
				foreach ($query->rows as $row){
					$this->customer_uuid_array[$row['uuid']] = $row['customer_id'];
				}		
			}
			
			echo '[i] Инициализация групп...' . PHP_EOL;
			$query = $this->db->query("SELECT customer_group_id, uuid FROM oc_customer_group WHERE 1");
			foreach ($query->rows as $row){
				$this->customer_group_uuid_array[$row['uuid']] = $row['customer_group_id'];
			}	
			
			echo '[i] Инициализировали массивы поиска. Заняли памяти ' . $this->convert(memory_get_usage(true)) . PHP_EOL;			
		}
		
		public function customerUUID($customer_id, $uuid){
			$this->db->query("UPDATE oc_customer SET uuid = '" . $this->db->escape($uuid) . "' WHERE customer_id = '" . (int)$customer_id . "'");						
		}
		
		public function customerGroupUUID($customer_group_id, $uuid){
			$this->db->query("UPDATE oc_customer_group SET uuid = '" . $this->db->escape($uuid) . "' WHERE customer_group_id = '" . (int)$customer_group_id . "'");						
		}
		
		private function getJSONFromFile($params = array()){
			
			$constants = get_defined_constants(true);
			$json_errors = array();
			foreach ($constants["json"] as $name => $value) {
				if (!strncmp($name, "JSON_ERROR_", 11)) {
					$json_errors[$value] = $name;
				}
			}
			
			$data = file_get_contents($this->json_file);
			
			$data = trim($data);
			$bom = pack('H*','EFBBBF');
			$data = preg_replace('/[\x00-\x1F]/', '', $data);
			$data = preg_replace("/^$bom/", '', $data);
			
			$this->exchange_data = $data;
			
			if ($json = json_decode($data, true)){
				return $json;
				} else {
				return $json_errors[json_last_error()];
			}
			
		}
		
		private function parseExceptionJSON($json){
			
			if (isset($json["#exception"])){
				return "JSON_1C_EXCEPTION";
			}			
			
			
			
			return $json;
			
		}
		
		
		private function getJSON($params = array()){
			
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
			
			echo PHP_EOL;			
			echo '[i] CURL DEBUG' . PHP_EOL;
			echo PHP_EOL;
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->address);			

			var_dump($this->address);

			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			//curl_setopt($ch, CURLOPT_HTTPHEADER, $_headers);
			curl_setopt($ch, CURLOPT_TIMEOUT, 2000);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2000);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
			curl_setopt($ch, CURLOPT_USERAGENT, 'EAPTEKA 1C SYNC ' . VERSION);
			curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate");
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_USERPWD, $this->login.':'.$this->password);			
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			
			$data = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			echo PHP_EOL;
			echo '[i] END CURL DEBUG' . PHP_EOL;
			echo PHP_EOL;
			
			file_put_contents(DIR_CATALOG . '/customer.json', $data);
			
			$data = trim($data);
			$bom = pack('H*','EFBBBF');
			$data = preg_replace('/[\x00-\x1F]/', '', $data);
			$data = preg_replace("/^$bom/", '', $data);
			
			$this->exchange_data = $data;
			
			if ($json = json_decode($data, true)){
				return $this->parseExceptionJSON($json);
				} else {
				return $json_errors[json_last_error()];
			}
			
		}
		
		public function normalizeCustomerName($name){
			
			$name = trim($name);
			$name = ltrim($name, ')(!- ');
			$name = rtrim($name, ')(!- ');
			
			return $name;
			
		}
		
		public function parseCustomerName($name){
			
			$name = $this->normalizeCustomerName($name);
			
			$name = explode(' ', $name);
			
			$parts = array(
			'lastname' => $this->normalizeCustomerName($name[0]),
			'firstname' => isset($name[1])?$this->normalizeCustomerName($name[1]):'',
			'secondname' => isset($name[2])?$this->normalizeCustomerName($name[2]):'',			
			);
			
			return $parts;
			
		}
		
		private function findCustomerInDB($customer){
			$customer_id = false;
			
			$query = $this->db->query("SELECT customer_id FROM oc_customer WHERE uuid = '" . $this->db->escape($customer['СсылкаПартнер']) . "' LIMIT 1");
			
			if ($query->num_rows){
				$customer_id = $query->row['customer_id'];
			}
			
			return $customer_id;
		}
		
		
		public function findCustomer($customer){
			$customer_id = false;				
			
			if ($this->fastLogic){
				return $this->findCustomerInDB($customer);
			}
			
			if (isset($this->customer_uuid_array[$customer['СсылкаПартнер']])){
				$customer_id = $this->customer_uuid_array[$customer['СсылкаПартнер']];				
			}
			
			return $customer_id;
		}
		
		
		public function findCustomerGroup($customer_group){
			
			$customer_group_id = false;				
			
			if (isset($this->customer_group_uuid_array[$customer_group['СсылкаВладелец']])){				
				$customer_group_id = $this->customer_group_uuid_array[$customer_group['СсылкаВладелец']];				
			}
			
			return $customer_group_id;
		}
		
		public function postFastActions(){
		
			$this->db->query("UPDATE oc_customer SET customer_group_id = 1388 WHERE customer_group_id = '" . $this->config->get('config_customer_group_id') . "' AND LENGTH(card) > 1");
			
		}
		
		public function postActions(){
			
			if ($this->fastLogic){
				$this->postFastActions();
				return false;
			}
			
			echo '[POST] Обновляем авторизационный токен...' . PHP_EOL;
			$this->db->query("UPDATE oc_customer SET retoken = MD5(CONCAT(customer_id, '" . $this->config->get('config_encryption') . "'))");
			
			echo '[POST] Нормализуем БД...' . PHP_EOL;
			$this->db->query("UPDATE oc_customer SET firstname = TRIM(firstname)");
			$this->db->query("UPDATE oc_customer SET lastname = TRIM(lastname)");
			$this->db->query("UPDATE oc_customer SET email = TRIM(email)");
			$this->db->query("UPDATE oc_order SET telephone = REPLACE(telephone, ' ', '') ");
			$this->db->query("UPDATE oc_customer SET telephone = TRIM(telephone)");
			$this->db->query("UPDATE oc_customer SET telephone = REPLACE(telephone, ' ', '') ");
			$this->db->query("UPDATE oc_customer SET card = REPLACE(card, '00000', '')");
			$this->db->query("UPDATE oc_customer SET customer_group_id = 1388 WHERE customer_group_id = '" . $this->config->get('config_customer_group_id') . "' AND LENGTH(card) > 1");
			
		}
		
		
		public function updateCustomer(){
			$this->load->model('setting/nodes');
			$this->load->model('customer/customer');
			$this->load->model('customer/customer_group');
						
			$this->setFastLogic();					
			
			//	var_dump($this->fastLogic);
			//	die();
			
			$this->initNodes();
			if ($this->nodes){
				
				foreach ($this->nodes as $node){
					//Ставим что все оке с нодой
					$this->model_setting_nodes->setNodeLastUpdateStatusSuccess($node['node_id']);
					
					$this->address = $node['node_url'];
					$this->login = $node['node_auth'];
					$this->password = $node['node_password'];
					
					echo '[i] Начинаем синхронизацию с узлом ' . $node['node_name'] . PHP_EOL;
					$this->model_setting_nodes->setNodeLastUpdateStatus($node['node_id'], 'NODE_EXCHANGE_START_PROCESS');
					
					//---------------------------- *JSON* ----------------------------
					//$json = $this->getJSONFromFile();
					$json = $this->getJSON();
					
					if (!$json || !is_array($json)){
						
						$this->model_setting_nodes->setNodeLastUpdateStatus($node['node_id'], $json);						
						$this->model_setting_nodes->setNodeLastUpdateStatusError($node['node_id']);
						
						$history_data = array(
						'status' => $json,
						'type'   => 'customer',
						'json'   => $this->exchange_data,
						'is_error' => 1
						);
						
						$this->model_setting_nodes->addNodeExchangeHistory($node['node_id'], $history_data);
						
						if ($json != 'JSON_ERROR_NONE'){
							$this->load->library('hobotix/TelegramSender');
							$telegramSender = new hobotix\TelegramSender;
							
							$message = '';
							$message = 'https://e-apteka.com.ua/error.jpg' . PHP_EOL;
							$message .= '<b>Господа, у нас ошибка обмена!</b>' . PHP_EOL;
							$message .= '<b>Скрипт:</b> ' . basename(__FILE__) . PHP_EOL;
							$message .= '<b>Узел:</b> ' . $node['node_name'] . PHP_EOL;
							$message .= '<b>URI:</b> ' . $this->address . PHP_EOL;
							$message .= '<b>Ошибка:</b> ' . $json . '';
							
							$telegramSender->SendMessage($message);
						}
						
						die('Не удалось разобрать JSON: ' . $json . PHP_EOL);					
					}
					
					//---------------------------- *Старт* ----------------------------
					
					echo "Разбираем покупателей..." . PHP_EOL;
					$i = 1;
					$cnt = count($json);
					
					
					if (!$cnt || $json == 'JSON_ERROR_NONE') {
						$this->model_setting_nodes->setNodeLastUpdateStatus($node['node_id'], 'JSON_ERROR_NONE');
						$this->model_setting_nodes->setNodeLastUpdateStatusError($node['node_id']);
						
						$history_data = array(
						'status' => 'JSON_ERROR_NONE',
						'type'   => 'customer',
						'json'   => $this->exchange_data,
						'is_error' => 1
						);
						
						$this->model_setting_nodes->addNodeExchangeHistory($node['node_id'], $history_data);
						die('Нет зарегистрированных изменений' . PHP_EOL);
					}
					
					$this->initCustomer();
					
					foreach ($json as $_customer){
						
						echo "$i / $cnt" . PHP_EOL;
						$i++;
						
						$customer = $_customer;						
						
						if ($customer_group_id = $this->findCustomerGroup($customer)){
							echo ">> Нашли группу " . $customer['СсылкаВладелецНаименование'] . PHP_EOL;		
							} else {
							echo ">> Не нашли группу " . $customer['СсылкаВладелецНаименование'] . PHP_EOL;
						}
						
						$data = array(
						'customer_group_description' => array(
						"2" => array(								
						'description' => $customer['СсылкаВладелецНаименование'],
						'name' => $customer['СсылкаВладелецНаименование'],
						),
						"3" => array(								
						'description' => $customer['СсылкаВладелецНаименование'],
						'name' => $customer['СсылкаВладелецНаименование'],							
						)						
						),												
						'approval' => 0,
						'uuid' => $customer['СсылкаВладелец'],
						'sort_order' => 5
						);
						
						if ($customer_group_id){
							$this->model_customer_customer_group->editCustomerGroup($customer_group_id, $data);
							} else {
							$customer_group_id = $this->model_customer_customer_group->addCustomerGroup($data);
							$this->customer_group_uuid_array[$customer['СсылкаВладелец']] = $customer_group_id;
						}		
						
						$this->customerGroupUUID($customer_group_id, $customer['СсылкаВладелец']);
						
						$real_customer = false;
						if ($customer_id = $this->findCustomer($customer)){
							echo ">> Нашли покупателя " . $customer['СсылкаПартнерНаименование'] . PHP_EOL;
							
							$real_customer = $this->model_customer_customer->getCustomer($customer_id);
							$real_customer['address'] = $this->model_customer_customer->getAddresses($customer_id);
							
							} else {				
							echo ">> Не нашли покупателя " . $customer['СсылкаПартнерНаименование'] . PHP_EOL;			
						}
						
					   	$password = pin(4);
						
						//Телефон
						$telepone_changed = false;
						$telephone = '';
						//Если есть покупатель, и у него задан телефон
						if ($real_customer && trim($real_customer['telephone'])){
							
							//Если телефон на сайте не соответствует телефону в 1С, и телефон в 1С задан - то меняем на значение из 1С
							if (trim($customer['телефон']) && (trim(normalizePhone($real_customer['telephone'])) != normalizePhone($customer['телефон']))){
								$telepone_changed = true;
								$telephone = $customer['телефон'];
								} else {
								//Иначе оставляем телефон из базы сайта
								$telephone = $real_customer['telephone'];
							}
							
							} else {
							
							//Либо нет покупателя, либо у него не задан телефон и он задан в 1С
							if (!$telephone && trim($customer['телефон'])){
								$telepone_changed = true;
								$telephone = $customer['телефон'];
							}
						}
						
						if ($telephone){
							$telephone = normalizePhone($telephone);
						}
						
						if ($telepone_changed){
							echo 'Телефон обновлен! Новый ' . $telephone . PHP_EOL;
						}
						
						//Электронная почта
						if ($real_customer && trim($real_customer['email'])){
							$email = $real_customer['email'];
							} else {
							$email = $customer['эп'];
						}
						
						//Карта
						if ($real_customer && trim($real_customer['card'])){
							$card = $real_customer['card'];
							} else {
							$card = $customer['СсылкаШтрихкод'];
						}
						
						$card = trim(str_replace('00000', '', $card));
						
						$name_array = $this->parseCustomerName($customer['СсылкаПартнерНаименование']);
						
						if ($real_customer && $real_customer['address']){
							$address_ids = array_keys ($real_customer['address']);
							
							foreach ($address_ids as $_id){								
								$real_customer['address'][$_id]['firstname'] = $name_array['firstname']?$name_array['firstname']:$real_customer['address'][$_id]['firstname'];
								$real_customer['address'][$_id]['lastname'] = $name_array['lastname']?$name_array['lastname']:$real_customer['address'][$_id]['lastname'];
								$real_customer['address'][$_id]['address_1'] = $customer['адрес']?$customer['адрес']:$real_customer['address'][$_id]['address_1'];
								break;																
							}
							
							$address = $real_customer['address'];
							
							} else {
							
							$address = array();
							
							/*
								$address = array(
								'default' 		=> array(
								'firstname' 	=> 	$name_array['firstname'],
								'lastname' 		=> 	$name_array['lastname'],
								'company'  		=> '',
								'address_1'  	=> $customer['адрес'],
								'address_2' 	=> '',
								'city'  		=> '',
								'postcode'  	=> '',
								'country_id'  	=> '220',									
								'zone_id'  		=> '',
								'custom_field'  => '',
								'default' 		=> '1'
								)														
								);
							*/
							
							
						}
						
						$data = array(						
						'customer_group_id' => $customer_group_id,
						'store_id' => 0,
						'language_id' 	=> $this->config->get('config_language_id'),
						'firstname' 	=> $name_array['firstname'],
						'secondname' 	=> $name_array['secondname'],
						'lastname' 		=> $name_array['lastname'],
						'email' 		=> $email,
						'telephone' 	=> $telephone,
						'fax' 			=> $real_customer?$real_customer['fax']:'',
						'cart' 			=> $real_customer?$real_customer['cart']:'',
						'wishlist' 		=> $real_customer?$real_customer['wishlist']:'',
						'newsletter' 	=> $real_customer?$real_customer['newsletter']:'1',
						'custom_field' 	=> $real_customer?$real_customer['custom_field']:'',
						'ip' 			=> $real_customer?$real_customer['ip']:'',
						'status' 		=> $real_customer?$real_customer['status']:'1',
						'approved' 		=> $real_customer?$real_customer['approved']:'1',
						'safe' 			=> $real_customer?$real_customer['safe']:'1',
						'token' 		=> $real_customer?$real_customer['token']:'',
						'code' 			=> $real_customer?$real_customer['code']:'',
						'social_id' 	=> $real_customer?$real_customer['social_id']:'',
						'date_added' 	=> $real_customer?$real_customer['date_added']:date('Y-m-d H:i:s'),
						'card' 			=> $card,
						'uuid' 			=> $customer['СсылкаПартнер'],							
						'password' 		=> $password,
						'address' 		=> $address
						);
						
						if ($customer_id){
							$this->model_customer_customer->editCustomer($customer_id, $data);
							} else {
							$customer_id = $this->model_customer_customer->addCustomer($data);							
							$this->customer_uuid_array[$customer['СсылкаПартнер']] = $customer_id;
						}	
						
						$this->customerUUID($customer_id, $customer['СсылкаПартнер']);
						
					}
					
					
					if ($telephone && $telepone_changed){
						echo 'Отправляем SMS с пин-кодом' . PHP_EOL;
						$smsText = 'Вітаємо! Ваш пін-код для входу на сайт https://e-apteka.com.ua: ' . $password;
						$this->TurboSMS->addToQueue($telephone, $smsText);
					}
					
					$this->model_setting_nodes->setNodeLastUpdateStatus($node['node_id'], 'NODE_EXCHANGE_SUCCESS');
					$this->model_setting_nodes->setNodeLastUpdateStatusSuccess($node['node_id']);
					
					$history_data = array(
					'status' => 'NODE_EXCHANGE_SUCCESS',
					'type'   => 'customer',
					'json'   => '',
					'is_error' => 0
					);
					
					$this->model_setting_nodes->addNodeExchangeHistory($node['node_id'], $history_data);
					
					//end foreach nodes	
				}
				//end ifnodes
				} else {
				
				echo '[i] Не найдено узлов для синхронизации каталога' . PHP_EOL;
				
			}
			
			$this->postActions();
			
		}
		
	}																									