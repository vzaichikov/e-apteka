<?php
	ini_set('memory_limit', '-1');
	class ControllerEaptekaStocks extends Controller {
		private $error 			= [];
		private $nodes 			= [];
		private $address 		= "";
		private $login 			= "";
		private $password 		= "";
		private $last_update 	= "";
		private $full_update 	= false;
		private $json_file 		= DIR_CATALOG . "../cron/data/stocks_test.json";
		private $file 			= 'stocks.json';
		private $exchange_data 	= "";
		private $raw_data 		= "";
		private $httpcode 		= "";
		private $method			= "";
		private $ocfilter_option_id = 10053;
		private $ocfilter_location_mapping = [];
		
		private $product_uuid_array = array();
		private $location_name_array = array();
		private $location_uuid_array = array();
		
		private function convert($size)
		{
			$unit=array('b','kb','mb','gb','tb','pb');
			return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
		}
		
		private function initNodes(){			
			$this->load->model('setting/nodes');
			$this->nodes = $this->model_setting_nodes->getNodesForStockUpdate();						
		}

		private function initPreorderNodes(){			
			$this->load->model('setting/nodes');
			$this->nodes = $this->model_setting_nodes->getNodesForPreorderUpdate();						
		}

		private function setMethod($method){
			$this->method = $method;
		}

		private function setFile($file){
			$this->file = $file;
		}
		
		private function parseDate($date){						
		}
		
		private function initCatalog(){	
			$this->load->model('localisation/location');
			$this->load->model('catalog/product');
			
			echo '[i] Инициализация товаров...' . PHP_EOL;
			$query = $this->db->query("SELECT product_id, uuid FROM oc_product WHERE 1");
			foreach ($query->rows as $row){
				$this->product_uuid_array[$row['uuid']] = $row['product_id'];
			}			
						
			echo '[i] Инициализация записей базы...' . PHP_EOL;
			
			//очистка базы наличия от аптек, которые не поддерживают обновление наличия
			$query = $this->db->query("DELETE FROM oc_stocks WHERE location_id NOT IN (SELECT location_id FROM oc_location WHERE is_stock = 1)");
			
			//выбираем все записи, которые уже есть
			$query = $this->db->query("SELECT product_id, location_id FROM oc_stocks WHERE 1");
			unset($row);
			$stock_row_exists = array();
			foreach ($query->rows as $row){
				$stock_row_exists[$row['product_id'].':'.$row['location_id']] = '';
			}
			
			//а теперь все товары
			$query = $this->db->query("SELECT DISTINCT(product_id) FROM oc_product WHERE 1");			
			$stocks = $this->model_localisation_location->getLocationForStocks();
			unset($row);
			foreach ($query->rows as $row){								
				
				foreach ($stocks as $_stock){					
					if (!isset($stock_row_exists[$row['product_id'].':'.$_stock['location_id']])){
						
						$data = array(
						'product_id' => $row['product_id'],
						'location_id' => $_stock['location_id']
						);
						
						$this->model_catalog_product->initProductStocks($data);
						
						echo '>> Инициализация записи таблицы наличия для ' . $row['product_id'] . ':' . $_stock['location_id'] . PHP_EOL;			
					}					
				}				
			}	
			
			echo '[i] Инициализация аптек...' . PHP_EOL;
			$query = $this->db->query("SELECT location_id, uuid, name FROM oc_location WHERE 1");
			unset($row);
			foreach ($query->rows as $row){
				$this->location_uuid_array[$row['uuid']] = $row['location_id'];
			}

			echo '[i] Инициализация названий аптек...' . PHP_EOL;
			$this->db->query("UPDATE oc_location_description SET name = TRIM(name), address = TRIM(address) WHERE 1");
			$query = $this->db->query("SELECT ld.location_id, ld.name, ld.address FROM oc_location_description ld LEFT JOIN oc_location l ON (ld.location_id = l.location_id) WHERE language_id = '" . $this->config->get('config_language_id') . "' AND l.temprorary_closed = 0");
			unset($row);
			foreach ($query->rows as $row){
				$this->location_name_array[$row['address']] = $row['location_id'];
			}

			echo '[i] Инициализация названий OCFILTER...' . PHP_EOL;
			$this->db->query("UPDATE oc_ocfilter_option_value_description SET name = TRIM(name) WHERE `option_id` = '" . (int)$this->ocfilter_option_id . "'");
			$query = $this->db->query("SELECT * FROM `oc_ocfilter_option_value_description` WHERE `option_id` = '" . (int)$this->ocfilter_option_id . "' AND language_id = '" . $this->config->get('config_language_id') . "'");
			unset($row);			

			foreach ($query->rows as $row){
				if (!empty($this->location_name_array[$row['name']])){
					$this->ocfilter_location_mapping[$this->location_name_array[$row['name']]] = $row['value_id'];
				} else {
					echo '[i] Не нашли аптеку ' . $row['name'] . PHP_EOL;
				}
			}	
			echo '[i] Инициализировали массивы поиска. Заняли памяти ' . $this->convert(memory_get_usage(true)) . PHP_EOL;					
		}
		
		private function parseExceptionJSON($json){
			
			if (isset($json["#exception"])){
				return "JSON_1C_EXCEPTION";
			}			
			
			return $json;			
		}
		
		private function fixBuggyJSON(){
			copy (DIR_CATALOG . '/stocks.json' , DIR_CATALOG . '/bugjson/stocks-' . date('Y-m-d-H-i-s') . '.json' );
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
				return $this->parseExceptionJSON($json);
				} else {
				return $json_errors[json_last_error()];
			}			
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
			
			$_date = date('c', (strtotime($this->last_update) - 600 * 100));
			$_date = explode('+', $_date);
			$_date = $_date[0];
			
			if ($this->full_update) {
				$_date = '2011-01-01T00:00';
			}					
			
			$this->address = str_replace(
			array('_DATETIME_'),
			array($_date),
			$this->address
			);
			
			$data = array("LastUpdate" => $_date);
			
			echo '[i] Установили дату выгрузки: ' . $_date . PHP_EOL;
			echo PHP_EOL;	
			
			echo PHP_EOL;			
			echo '[i] CURL DEBUG' . PHP_EOL;
			echo PHP_EOL;			
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->address);
			curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $_headers);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			//	curl_setopt($ch, CURLOPT_TIMEOUT_MS, 10000);
			//	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 10000);
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
			
			if ($httpcode != 200){
				
				$this->load->library('hobotix/TelegramSender');
				$telegramSender = new hobotix\TelegramSender;
				
				$message = '';
				$message = 'https://e-apteka.com.ua/error500.jpg' . PHP_EOL;
				$message .= '<b>Уважаемые, что-то пошло не так!</b>' . PHP_EOL;
				$message .= '<b>Скрипт:</b> ' . basename(__FILE__) . PHP_EOL;
				$message .= '<b>Узел:</b> ' . $this->address . PHP_EOL;					
				$message .= '<b>Код ответа:</b> ' . $httpcode . '';
				
				$telegramSender->SendMessage($message);
				die();
				
			}
			
			$this->raw_data = $data;
			$this->httpcode = $httpcode;
			
			if($curlerror = curl_errno($ch))
			{
				return 'Ошибка CURL: ' . curl_error($ch) . PHP_EOL;
			}
			
			curl_close($ch);
			
			echo PHP_EOL;
			echo '[i] END CURL DEBUG' . PHP_EOL;
			echo PHP_EOL;
			
			file_put_contents(DIR_CATALOG . '/' . $this->file, $data);
			
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
		
		public function normalizeProductName($name){			
			$name = trim($name);
			$name = ltrim($name, ')(');
			
			return $name;			
		}
				
		public function findProduct($product){			
			$product_id = false;				
			
			if (isset($this->product_uuid_array[$product])){
				
				$product_id = $this->product_uuid_array[$product];
				
			}
			
			return $product_id;
		}
		
		public function findLocation($location){		
			$location_id = false;				
			
			if (isset($this->location_uuid_array[$location])){
				
				$location_id = $this->location_uuid_array[$location];
				
			}
			
			return $location_id;
		}
		
		public function updateStocksFull(){			
			$this->full_update = true;			
			$this->updateStocks();
			$this->updatePreorder();		
		}
		
		public function updateStocks(){
			$this->load->model('catalog/product');
			$this->load->model('catalog/manufacturer');
			$this->load->model('catalog/category');
			$this->load->model('setting/nodes');
			
			$this->initNodes();
			$this->setMethod('PUT');
			if ($this->nodes){
				
				foreach ($this->nodes as $node){					
					$this->model_setting_nodes->setNodeLastUpdateStatusSuccess($node['node_id']);
					
					$this->address = $node['node_url'];
					$this->login = $node['node_auth'];
					$this->password = $node['node_password'];
					$this->last_update = $node['node_last_update'];
					$this->last_registered = $node['node_last_registered'];
					
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
						'type'   => 'stocks',
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
							$message .= '<b>Ошибка:</b> ' . $json . '' . PHP_EOL;
							$message .= '<b>Код ответа:</b> ' . $this->httpcode . PHP_EOL;
							$message .= '<b>Данные:</b> ' . substr($this->exchange_data,0,500) . '' . PHP_EOL;
							$message .= '<b>Данные RAW:</b> ' . $this->raw_data . '' . PHP_EOL;
							
							$telegramSender->SendMessage($message);
						}
						
						$this->fixBuggyJSON();
						
						die('Не удалось разобрать JSON: ' . $json . PHP_EOL);						
					}
					
					//---------------------------- *Старт* ----------------------------
					
					echo "Разбираем товары..." . PHP_EOL;
					$i = 1;
					$cnt = count($json);
					
					if (!$cnt || $json == 'JSON_ERROR_NONE') {
						$this->model_setting_nodes->setNodeLastUpdateStatus($node['node_id'], 'JSON_ERROR_NONE');
						$this->model_setting_nodes->setNodeLastUpdateStatusError($node['node_id']);
						
						$history_data = array(
						'status' => 'JSON_ERROR_NONE',
						'type'   => 'stocks',
						'json'   => $this->exchange_data,
						'is_error' => 1
						);
						
						$this->model_setting_nodes->addNodeExchangeHistory($node['node_id'], $history_data);
						die('Нет зарегистрированных изменений' . PHP_EOL);
					}
					
					$this->initCatalog();
					
					/*
						$collapsed = array();
						foreach ($json as $_stock){
						
						if (!isset($collapsed[$_stock['OuterSystemSkuRef'].':'.$_stock['StoreRef']])){
						$collapsed[$_stock['OuterSystemSkuRef'].':'.$_stock['StoreRef']] = array(
						'quantity' => ((int)$_stock['Counts'] - (int)$_stock['Reserve']),
						'price' => (float)$_stock['Price'],
						'count' => (int)$_stock['Counts'],
						'reserve' => (int)$_stock['Reserve']
						);							
						} else {
						
						$collapsed[$_stock['OuterSystemSkuRef'].':'.$_stock['StoreRef']]['count'] += (int)$_stock['Counts'];
						$collapsed[$_stock['OuterSystemSkuRef'].':'.$_stock['StoreRef']]['reserve'] += (int)$_stock['Reserve'];
						$collapsed[$_stock['OuterSystemSkuRef'].':'.$_stock['StoreRef']]['price'] = max($collapsed[(float)$_stock['OuterSystemSkuRef'].':'.$_stock['StoreRef']]['price'], (float)$_stock['Price']);
						$collapsed[$_stock['OuterSystemSkuRef'].':'.$_stock['StoreRef']]['quantity'] = ((int)$_stock['Counts'] - (int)$_stock['Reserve']);
						
						}
						}
					*/
					
					unset($_stock);
					foreach ($json as $_stock){
						
						echo "$i / $cnt" . PHP_EOL;
						$i++;
						
						$stock = $_stock;
						
						if ($product_id = $this->findProduct($_stock['OuterSystemSkuRef'])){
							
							echoLine("Нашли товар " . $product_id . " - " . $_stock['OuterSystemSkuRef'] , 's');	
							
							if ($location_id = $this->findLocation($_stock['StoreRef'])){
								echoLine("Нашли аптеку " . $location_id . " - " . $_stock['StoreRef'] , 's');										
								} else {
								echoLine("Не нашли аптеку " . $_stock['StoreRef'] , 'e');								
							}
							
							} else {
							echoLine("Не нашли товар " . $_stock['OuterSystemSkuRef'] , 'e');														
						}
						
						if ($product_id && $location_id){														
							$quantity = ((int)$_stock['Counts'] - (int)$_stock['Reserve']);
							if ($quantity < 0){ $quantity = 0; }
							
							$price = (float)$_stock['Price'];
							if (!empty($_stock['PriceSait']) && (float)$_stock['PriceSait'] > 0){
								$price = (float)$_stock['PriceSait'];								
								echoLine('Найдена цена сайта ' . (float)$_stock['PriceSait'] . ', обычная цена ' . (float)$_stock['Price'] . ' устанавливаем!', 'i');	
							}

							if (empty($this->ocfilter_location_mapping[$location_id])){
								echoLine('Нету маппинга аптеки ' . $location_id, 'e');
							} else {
								echoLine('Есть маппинг аптеки ' . $location_id . ' > ' . $this->ocfilter_location_mapping[$location_id], 's');								
							}
							
							$data = array(
							'product_id' 		=> $product_id,
							'location_id' 		=> $location_id,
							'quantity' 			=> ((int)$_stock['Counts'] - (int)$_stock['Reserve']),
						//	'price' 			=> (float)$_stock['Price'],
							'price_retail' 		=> (float)$_stock['Price'],
							'price' 			=> $price,
							'price_of_part' 	=> 0,
							'price_of_part_retail' => 0,
							'quantity_of_parts' => 0,
							'count' 			=> (int)$_stock['Counts'],
							'reserve' 			=> (int)$_stock['Reserve'],
							'ocfilter_value_id' => !empty($this->ocfilter_location_mapping[$location_id])?(int)$this->ocfilter_location_mapping[$location_id]:0
							);
							
							//echo 'product_id-'.$product_id.' location_id-'.$location_id. ' quantity-'.(int)$_stock['Counts'] - (int)$_stock['Reserve'].' price-'.(float)$_stock['Price'].' count-'.(int)$_stock['Counts'].' reserve-'.(int)$_stock['Reserve'];
							
                            $this->model_catalog_product->updateProductStocks($data);
							
						}												
					}
					
					//end foreach nodes											
					echo '[i] Обработка после окончания работы с узлом' . PHP_EOL;
					
					echo '[i] Пост-обработка.. Обнуляем наличие' . PHP_EOL;
					$this->db->query("UPDATE oc_product SET quantity = 0 WHERE is_preorder = 0");
					
					echo '[i] Пост-обработка.. Установка цен и наличия' . PHP_EOL;

					$this->db->query("UPDATE oc_product p SET quantity = 
					(SELECT SUM(quantity) FROM oc_stocks s WHERE 
					s.product_id = p.product_id
					AND location_id IN (SELECT location_id FROM oc_location WHERE temprorary_closed = 0)
					GROUP BY s.product_id) WHERE p.is_preorder = 0");									

					$this->db->query("UPDATE oc_product p SET quantity 		= 0 WHERE quantity < 0");	
					$this->db->query("UPDATE oc_product p SET is_onstock 	= 0 WHERE quantity <= 0");	
					$this->db->query("UPDATE oc_stocks SET quantity 		= 0 WHERE quantity < 0");											
					$this->db->query("UPDATE oc_product p SET is_onstock 	= 1 WHERE quantity > 0");	
					
					//Уведомление о косяках				
					$query = $this->db->query("SELECT p.*, pd.name FROM `oc_product` p LEFT JOIN `oc_product_description` pd ON (pd.product_id = p.product_id AND language_id = 2) WHERE quantity > 0 AND price <= 0");
					
					
					if ($query->num_rows){
						$this->load->library('hobotix/TelegramSender');
						$telegramSender = new hobotix\TelegramSender;
						
						$message = '';
						$message = 'https://e-apteka.com.ua/error.jpg' . PHP_EOL;
						$message .= '<b>Джентльмены, у нас ерунда с ценами!</b>' . PHP_EOL;
						$message .= 'Товары, с нулевой ценой в наличии: ' . PHP_EOL;
						foreach ($query->rows as $row){
							$message .= $row['name'] . ' - ' . $row['model'] . ' (' . $row['uuid'] . ')' . PHP_EOL;
						}
						$telegramSender->SendMessage($message);	
						$this->fixBuggyJSON();
					}					
					
					$this->db->query("UPDATE `oc_product` SET quantity = 0 WHERE price <= 0");
					
					$this->db->query("UPDATE
						oc_product p
						LEFT JOIN oc_stocks s ON
						p.product_id = s.product_id AND s.location_id =(
							SELECT	
							l.location_id
							FROM
							oc_location l
							WHERE
							l.default_price = 1
							LIMIT 1
							)
						SET
						p.price_retail = IF(
							s.quantity > 0 AND s.price_retail > 0,
							s.price_retail,
							(
								SELECT
								MAX(s2.price_retail)
								FROM
								oc_stocks s2	
								WHERE
								s2.product_id = p.product_id AND s2.price_retail > 0 AND s2.quantity > 0
								GROUP BY
								s2.product_id
								)
							)
						WHERE is_onstock = 1"
					);
					
					$this->db->query("UPDATE
						oc_product p
						LEFT JOIN oc_stocks s ON
						p.product_id = s.product_id AND s.location_id =(
							SELECT	
							l.location_id
							FROM
							oc_location l
							WHERE
							l.default_price = 1
							LIMIT 1
							)
						SET
						p.price = IF(
							s.quantity > 0 AND s.price > 0,
							s.price,
							(
								SELECT
								MAX(s2.price)
								FROM
								oc_stocks s2	
								WHERE
								s2.product_id = p.product_id AND s2.price > 0 AND s2.quantity > 0
								GROUP BY
								s2.product_id
								)
							)
						WHERE is_onstock = 1"
					);
					
					$this->db->query("UPDATE oc_product_option_value oopv LEFT JOIN oc_product p ON (p.product_id = oopv.product_id AND option_id = 2 AND option_value_id = 2) SET oopv.quantity = (p.quantity * p.count_of_parts), oopv.price = ROUND(p.price / p.count_of_parts, 2) WHERE oopv.product_id = p.product_id AND option_id = 2 AND option_value_id = 2");

					$this->db->query("UPDATE oc_product_option_value oopv LEFT JOIN oc_product p ON (p.product_id = oopv.product_id AND option_id = 2 AND option_value_id = 2) SET oopv.quantity = (p.quantity * p.count_of_parts), oopv.price_retail = ROUND(p.price_retail / p.count_of_parts, 2) WHERE oopv.product_id = p.product_id AND option_id = 2 AND option_value_id = 2");
					
					$this->db->query("UPDATE oc_stocks os LEFT JOIN oc_product p ON (p.product_id = os.product_id) SET os.quantity_of_parts = (os.quantity * p.count_of_parts), os.price_of_part = ROUND(os.price / p.count_of_parts, 2)");					
					$this->db->query("UPDATE oc_product p SET p.price_of_part = ROUND(p.price / p.count_of_parts, 2) WHERE p.count_of_parts > 0");

					$this->db->query("UPDATE oc_stocks os LEFT JOIN oc_product p ON (p.product_id = os.product_id) SET os.quantity_of_parts = (os.quantity * p.count_of_parts), os.price_of_part_retail = ROUND(os.price_retail / p.count_of_parts, 2)");
					$this->db->query("UPDATE oc_product p SET p.price_of_part_retail = ROUND(p.price_retail / p.count_of_parts, 2) WHERE p.count_of_parts > 0");
					
					$this->model_setting_nodes->setNodeLastUpdateStatus($node['node_id'], 'NODE_EXCHANGE_SUCCESS');
					$this->model_setting_nodes->setNodeLastUpdateStatusSuccess($node['node_id']);
					
					$history_data = array(
					'status' => 'NODE_EXCHANGE_SUCCESS',
					'type'   => 'stocks',
					'json'   => '',
					'is_error' => 0
					);
					
					$this->model_setting_nodes->addNodeExchangeHistory($node['node_id'], $history_data);
				}

				//Обновляем значения OCFILTER
				//очистка значений
				echo '[i] Пост-обработка.. Значения OCFILTER' . PHP_EOL;
				$this->db->query("DELETE FROM oc_ocfilter_option_value_to_product WHERE option_id = '" . (int)$this->ocfilter_option_id . "'");		

				unset($location_id);
				unset($value_id);
				foreach ($this->ocfilter_option_id as $location_id => $value_id){
					$this->db->query("UPDATE oc_stocks SET ocfilter_value_id = '" . (int)$value_id . "' WHERE location_id = '" . (int)$location_id . "'");
				}

				$this->db->query("INSERT IGNORE INTO oc_ocfilter_option_value_to_product (product_id, option_id, value_id, slide_value_min, slide_value_max) SELECT product_id, '" . (int)$this->ocfilter_option_id . "', ocfilter_value_id, 0, 0 FROM oc_stocks WHERE quantity > 0 AND ocfilter_value_id > 0");


				
				//	$this->cache->flush();
				
				//end ifnodes
				} else {
				
				echo '[i] Не найдено узлов для синхронизации каталога' . PHP_EOL;
				
			}						
		}
		
		public function updatePreorder(){

			$this->load->library('hobotix/ElasticSearch');
			$this->elasticSearch = new hobotix\ElasticSearch($this->registry);

			$this->initPreorderNodes();
			$this->setMethod('GET');
			if ($this->nodes){				
				foreach ($this->nodes as $node){					
					$this->model_setting_nodes->setNodeLastUpdateStatusSuccess($node['node_id']);
					
					$this->address 			= $node['node_url'];
					$this->login 			= $node['node_auth'];
					$this->password 		= $node['node_password'];
					$this->last_update 		= $node['node_last_update'];
					$this->last_registered 	= $node['node_last_registered'];
					
					echo '[i] Начинаем синхронизацию с узлом ' . $node['node_name'] . PHP_EOL;
					$this->model_setting_nodes->setNodeLastUpdateStatus($node['node_id'], 'NODE_EXCHANGE_START_PROCESS');

					$this->setFile('preorder.json');
					$json = $this->getJSON();
									

					if (!$json || !is_array($json)){
						$this->model_setting_nodes->setNodeLastUpdateStatus($node['node_id'], $json);						
						$this->model_setting_nodes->setNodeLastUpdateStatusError($node['node_id']);
						
						$history_data = array(
						'status' => $json,
						'type'   => 'preorder',
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
							$message .= '<b>Ошибка:</b> ' . $json . '' . PHP_EOL;
							$message .= '<b>Код ответа:</b> ' . $this->httpcode . PHP_EOL;
							$message .= '<b>Данные:</b> ' . substr($this->exchange_data,0,500) . '' . PHP_EOL;
							$message .= '<b>Данные RAW:</b> ' . $this->raw_data . '' . PHP_EOL;
							
							$telegramSender->SendMessage($message);
						}
						
						$this->fixBuggyJSON();						
						die('Не удалось разобрать JSON: ' . $json . PHP_EOL);						
					}

					if (!$this->product_uuid_array){
						$this->initCatalog();
					}

					echoLine("[i] Разбираем товары", 's');
					$i = 1;
					$cnt = count($json);
					
					if (!$cnt || $json == 'JSON_ERROR_NONE') {
						$this->model_setting_nodes->setNodeLastUpdateStatus($node['node_id'], 'JSON_ERROR_NONE');
						$this->model_setting_nodes->setNodeLastUpdateStatusError($node['node_id']);
						
						$history_data = array(
						'status' => 'JSON_ERROR_NONE',
						'type'   => 'preorder',
						'json'   => $this->exchange_data,
						'is_error' => 1
						);
						
						$this->model_setting_nodes->addNodeExchangeHistory($node['node_id'], $history_data);
						die('Нет зарегистрированных изменений' . PHP_EOL);
					}

					$this->db->query("UPDATE oc_product SET is_preorder = 0 WHERE 1");	
					foreach ($json as $preorder){						
						echo "$i / $cnt" . PHP_EOL;
						$i++;

						if ($product_id = $this->findProduct($preorder['GUID'])){							
							echoLine(" Нашли товар " . $product_id . " - " . $preorder['GUID'], 's');	
							} else {							
							echoLine(" Не нашли товар " . $product_id . " - " . $preorder['GUID'], 'e');								
						}

						//Проверяем, есть ли товар на остатках
						$stocks = $this->db->query("SELECT SUM(quantity) as stocks FROM " . DB_PREFIX . "stocks s WHERE s.product_id = '" . (int)$product_id . "'")->row['stocks'];

						if ($product_id && !empty($preorder['PRICE']) && (int)$stocks == 0){
							$this->db->query("UPDATE oc_product SET is_preorder = 1, quantity = 10, price = '" . (float)$preorder['PRICE'] . "' WHERE product_id = '" . (int)$product_id . "'");					
						} elseif ($product_id && (int)$stocks == 0){
							$this->db->query("UPDATE oc_product SET is_preorder = 0, quantity = 0, price = '0' WHERE product_id = '" . (int)$product_id . "'");
						} else {
							//?
						}

						$this->elasticSearch->reindexproduct($product_id);
					}

					$this->db->query("UPDATE oc_product p SET quantity = 
					(SELECT SUM(quantity) FROM oc_stocks s WHERE 
					s.product_id = p.product_id
					AND location_id IN (SELECT location_id FROM oc_location WHERE temprorary_closed = 0)
					GROUP BY s.product_id) WHERE p.is_preorder = 0");	

					$this->db->query("UPDATE oc_product_option_value oopv LEFT JOIN oc_product p ON (p.product_id = oopv.product_id AND option_id = 2 AND option_value_id = 2) SET oopv.quantity = (p.quantity * p.count_of_parts), oopv.price = ROUND(p.price / p.count_of_parts, 2) WHERE oopv.product_id = p.product_id AND option_id = 2 AND option_value_id = 2");

					$this->db->query("UPDATE oc_product p SET p.price_of_part = ROUND(p.price / p.count_of_parts, 2) WHERE p.count_of_parts > 0");

					$this->model_setting_nodes->setNodeLastUpdateStatus($node['node_id'], 'NODE_EXCHANGE_SUCCESS');
					$this->model_setting_nodes->setNodeLastUpdateStatusSuccess($node['node_id']);
					
					$history_data = array(
					'status' => 'NODE_EXCHANGE_SUCCESS',
					'type'   => 'preorder',
					'json'   => '',
					'is_error' => 0
					);
					
					$this->model_setting_nodes->addNodeExchangeHistory($node['node_id'], $history_data);

				}
			} else {
				
				echo '[i] Не найдено узлов для синхронизации каталога' . PHP_EOL;
				
			}
		}
	}							