	<?php
	ini_set('memory_limit', '-1');
	class ControllerEaptekaCards extends Controller {
		private $error = array();
		private $address = "";
		private $login = "";
		private $password = "";
		private $nodes = [];
		private $json_file = DIR_CATALOG . "/cards.json";
		private $data = array();

		private function setData($data){

			$this->data = $data;

		}

		public function __construct($registry){
			parent::__construct($registry);

			$this->load->model('setting/nodes');
			$this->nodes = $this->model_setting_nodes->getNodesForCardsUpdate();


		}

		public function setNode($node){

			$this->address = $node['node_url'];
			$this->login = $node['node_auth'];
			$this->password = $node['node_password'];

		}

		public function postActions(){
			echo '[POST] Обновляем авторизационный токен...' . PHP_EOL;
			$this->db->query("UPDATE oc_customer SET retoken = MD5(CONCAT(customer_id, '" . $this->config->get('config_encryption') . "'))");
				
				echo '[POST] Нормализуем БД...' . PHP_EOL;
				$this->db->query("UPDATE oc_customer SET firstname = TRIM(firstname)");
				$this->db->query("UPDATE oc_customer SET lastname = TRIM(lastname)");
				$this->db->query("UPDATE oc_customer SET email = TRIM(email)");
				$this->db->query("UPDATE oc_customer SET telephone = TRIM(telephone)");
			}
			
			public function preActions(){
				
				echo '[PRE] Приводим телефоны к единому формату...' . PHP_EOL;
				$this->db->query("UPDATE oc_customer SET telephone = '' WHERE telephone LIKE('%@%')");
				$this->db->query("UPDATE oc_customer SET telephone = TRIM(telephone)");
				
				$query = $this->db->query("SELECT customer_id, telephone FROM oc_customer WHERE LENGTH(telephone) > 0");
				
				foreach ($query->rows as $row){				
					$phone = normalizePhone($row['telephone']);
					
					if ($phone != $row['telephone']){
						echoLine($row['telephone'] . ' -> ' . $phone);
						$this->db->query("UPDATE oc_customer SET telephone = '" . $this->db->escape($phone) . "' WHERE customer_id = '" . (int)$row['customer_id'] . "'");				
					}
					
				}
				
				echo '[PRE] Имена...' . PHP_EOL;
				$this->db->query("UPDATE oc_customer SET firstname = TRIM(firstname), lastname = TRIM(lastname)");
			}
			
			
			private function updateCustomer($customer_id, $data){						
				$this->db->query("UPDATE oc_customer SET uuid = '" . $this->db->escape($data['customer_uuid']) . "', card_uuid = '" . $this->db->escape($data['uuid']) . "', card = '" . $this->db->escape($data['card']) . "' WHERE customer_id = '" . (int)$customer_id . "'");
			}
			
			public function updateCards(){
				
				$this->preActions();
				
				
				$this->load->model('customer/customer');
				$this->load->model('setting/nodes');
				$this->load->library('hobotix/TelegramSender');
				$telegramSender = new hobotix\TelegramSender;

				foreach ($this->nodes as $node){
					$this->setNode($node);

					$this->model_setting_nodes->setNodeLastUpdateStatusSuccess($node['node_id']);
					$this->model_setting_nodes->setNodeLastUpdateStatus($node['node_id'], 'NODE_EXCHANGE_START_PROCESS');

					$query = $this->db->query("SELECT customer_id FROM oc_customer WHERE (uuid = '' OR card = '') AND LENGTH(telephone) > 5");

					echo '[i] Всего покупателей ' . count($query->rows) . PHP_EOL;

					foreach ($query->rows as $row){
						$customer = $this->model_customer_customer->getCustomer($row['customer_id']);
						$customer['address'] = $this->model_customer_customer->getAddresses($row['customer_id']);

						$address = '';
						if ($customer['address_id']){
							$address = !empty($customer['address'][$customer['address_id']])?$customer['address'][$customer['address_id']]['address_1']:'';
							$address .= ' ' . !empty($customer['address'][$customer['address_id']])?$customer['address'][$customer['address_id']]['address_2']:'';
							$address = trim($address);
						}

						if (!$customer['firstname']){
							$customer['firstname'] = 'Клиент сайта ' . $customer['customer_id'];
						}

						$json = array(
							'customer_id' 	=> $customer['customer_id'],
							'firstname' 	=> $customer['firstname'],
							'lastname' 		=> $customer['lastname'],
							'email' 		=> $customer['email'],
							'telephone' 	=> normalizePhone($customer['telephone']),
							'address'		=> $address,		
							'city'			=> !empty($customer['address'][$customer['address_id']])?$customer['address'][$customer['address_id']]['city']:'',
							'zone'			=> !empty($customer['address'][$customer['address_id']])?$customer['address'][$customer['address_id']]['zone']:'',
						);

						$this->setData(json_encode($json));

						echo '[i] Покупатель ' . $customer['firstname'] . ' ' . $customer['lastname'] . ', ' . $customer['email'] . ', ' . $customer['telephone'] . ', делаем запрос...  ' . PHP_EOL;

						$json = $this->doRequest();

						if (!$json || !is_array($json)){				
							$message = '';
							$message = 'https://e-apteka.com.ua/error500.jpg' . PHP_EOL;
							$message .= '<b>Господа, у нас ошибка обмена!</b>' . PHP_EOL;
							$message .= '<b>Скрипт:</b> ' . basename(__FILE__) . PHP_EOL;
							$message .= '<b>Узел:</b> ' . $this->address . PHP_EOL;
							$message .= '<b>URI:</b> ' . $this->address . PHP_EOL;
							$message .= '<b>Ошибка:</b> ' . serialize($json) . '';

							$telegramSender->SendMessage($message);

							$this->model_setting_nodes->setNodeLastUpdateStatus($node['node_id'], $json);						
							$this->model_setting_nodes->setNodeLastUpdateStatusError($node['node_id']);

							die('Не удалось разобрать JSON: ' . serialize($json) . PHP_EOL);	
						}

						if (empty($json['uuid']) || empty($json['customer_uuid']) || empty($json)){
							$message = '';
							$message = 'https://e-apteka.com.ua/error500.jpg' . PHP_EOL;
							$message .= '<b>Что-то пошло не так!</b>' . PHP_EOL;
							$message .= '<b>Скрипт:</b> ' . basename(__FILE__) . PHP_EOL;
							$message .= '<b>Узел:</b> ' . $this->address . PHP_EOL;
							$message .= '<b>URI:</b> ' . $this->address . PHP_EOL;
							$message .= '<b>Ошибка:</b> Пустые поля в ответе ' . serialize($json);

							$telegramSender->SendMessage($message);

							die('Пустые поля в ответе: ' . serialize($json) . PHP_EOL);	
						}

						$this->model_setting_nodes->addNodeExchangeHistory($node['node_id'], $history_data);
						$this->updateCustomer($customer['customer_id'], $json);
					}

					$this->model_setting_nodes->setNodeLastUpdateStatus($node['node_id'], 'NODE_EXCHANGE_SUCCESS');
					$this->model_setting_nodes->setNodeLastUpdateStatusSuccess($node['node_id']);
				}
				
				$this->postActions();
				
			}
			
			private function doRequest(){
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
				
			//	echo PHP_EOL;			
			//	echo '[i] CURL DEBUG' . PHP_EOL;
			//echo PHP_EOL;
				
				$ch = curl_init();
				
				curl_setopt($ch, CURLOPT_URL, $this->address);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $_headers);
				curl_setopt($ch, CURLOPT_TIMEOUT, 20000);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20000);
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
				
				if ($httpcode != 200){
					
					$this->load->library('hobotix/TelegramSender');
					$telegramSender = new hobotix\TelegramSender;
					
					$message = '';
					$message = 'https://e-apteka.com.ua/error500.jpg' . PHP_EOL;
					$message .= '<b>Уважаемые, что-то пошло не так!</b>' . PHP_EOL;
					$message .= '<b>Скрипт:</b> ' . basename(__FILE__) . PHP_EOL;
					$message .= '<b>Узел:</b> ' . $this->address . PHP_EOL;	
					$message .= '<b>Передал данные:</b> ' . $this->data . PHP_EOL;
					$message .= '<b>Код ответа:</b> ' . $httpcode . '';
					
					$telegramSender->SendMessage($message);
					die();
					
				}
				
				curl_close($ch);
				
			//	echo PHP_EOL;
			//	echo '[i] END CURL DEBUG' . PHP_EOL;
			//echo PHP_EOL;
				
				file_put_contents(DIR_CATALOG . '/cards.json', $data);
				
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
			
			private function parseExceptionJSON($json){
				
				if (isset($json["#exception"])){
					return "JSON_1C_EXCEPTION";
				}			
				
				return $json;
				
			}
			
		}						