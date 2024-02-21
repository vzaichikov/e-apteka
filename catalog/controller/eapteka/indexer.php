<?php
	class ControllerEaptekaIndexer extends Controller {
		private $jsonKey = '';	
		private $pidCounter = 'eapteka-indexer.pid';
		private $todayCounter;
		private $todayLimit = 200;
		
		public function index(){
			if (!defined('OPENCART_CLI_MODE')){
				die('CLI ONLY');
			}
		}
		
		private function echoLine($line){
			$line = str_replace('<![CDATA[', '', $line);
			$line = str_replace(']]>', '', $line);
			echo $line . PHP_EOL;			
		}
		
		private function echoSimple($line){
			echo $line;			
		}
		
		private function addIndexerHistory($url){			
			$this->db->query("INSERT INTO " . DB_PREFIX . "indexer_history SET indexer_url = '" . $this->db->escape($url) . "', date_added = NOW()");			
		}
		
		private function updateURL($url){		
			if ($this->todayCounter == $this->todayLimit){
				$this->echoLine('[GINDXR] Хватает на сегодня!');
				die();
			}
			
			$client = new Google_Client();		
			$client->setAuthConfig(DIR_SYSTEM . GOOGLE_INDEXER_JSON);
			$client->addScope('https://www.googleapis.com/auth/indexing');
			
			
			// Get a Guzzle HTTP Client
			$httpClient = $client->authorize();
			$endpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';			
			
			$content = json_encode(array(
			'url' 	=> $url,
			'type' 	=> 'URL_UPDATED'
			));
			
			$this->echoSimple('[INDXR] Отправляем URL ' . $url );
			
			$response = $httpClient->post($endpoint, [ 'body' => $content ]);
			$status_code = $response->getStatusCode();
			
			$this->echoSimple(' -> ответ ' . $status_code);
			$this->echoLine('');
			
			$this->todayCounter++;
			
			if ($status_code == 200){
				$this->addIndexerHistory($url);
			}
			
			return $status_code;
		}
		
		private function sendCollectionURI($collection_id){
			$this->load->model('catalog/collection');
		
			$this->echoLine('[INDXR] Коллекция ' . $collection_id);
			
			$status_code = 200;
			if ($this->model_catalog_collection->getCollection($collection_id)){
				$status_code = $this->updateURL($this->url->link('catalog/collection', 'collection_id=' . $collection_id));
			}
			
			if (!empty($status_code) && $status_code == 200){
				return true;
			}
			
			return false;
		}
		
		private function sendCategoryURI($category_id){
			$this->load->model('catalog/category');			
		
			$this->echoLine('[INDXR] Категория ' . $category_id);
			
			$status_code = 200;
			if ($this->model_catalog_category->getCategory($category_id)){
				$status_code = $this->updateURL($this->url->link('catalog/category', 'category_id=' . $category_id));
			}
			
			if (!empty($status_code) && $status_code == 200){
				return true;
			}
			
			return false;
		}
		
		private function sendProductURI($product_id){
			$this->load->model('catalog/product');
		
			$this->echoLine('[INDXR] Товар ' . $product_id);
			
			$status_code = 200;
			if ($this->model_catalog_product->getProduct($product_id)){
				$status_code = $this->updateURL($this->url->link('catalog/product', 'product_id=' . $product_id));
			}
			
			if (!empty($status_code) && $status_code == 200){
				return true;
			}
			
			return false;
			
		}
		
		private function sendManufacturerURI($manufacturer_id){
			$this->load->model('catalog/manufacturer');
		
			$this->echoLine('[INDXR] Производитель ' . $manufacturer_id);
			
			$status_code = 200;
			if ($this->model_catalog_manufacturer->getManufacturer($manufacturer_id)){
				$status_code = $this->updateURL($this->url->link('catalog/manufacturer', 'manufacturer_id=' . $manufacturer_id));
			}
			
			if (!empty($status_code) && $status_code == 200){
				return true;
			}
			
			return false;
		}
		
		
		public function cron() {
			$this->todayCounter = 1;
			
			if (!defined('OPENCART_CLI_MODE')){
				die('CLI ONLY');
			}	
			
			$query = $this->db->ncquery("SELECT * FROM " . DB_PREFIX . "indexer_queue WHERE 1 ORDER BY RAND() LIMIT 199");
			
			foreach ($query->rows as $row){
				$result = false;
				
				switch ($row['indexer_entity_route']) {
					case 'catalog/collection/editCollection':
					$result = $this->sendCollectionURI($row['indexer_entity_id']);
					break;
					
					case 'catalog/category/editCategory':
					$result = $this->sendCategoryURI($row['indexer_entity_id']);
					break;
					
					case 'catalog/manufacturer/editManufacturer':
					$result = $this->sendManufacturerURI($row['indexer_entity_id']);
					break;
					
					case 'catalog/product/editProduct':
					$result = $this->sendProductURI($row['indexer_entity_id']);
					break;
				}
				
				
				if ($result){
					$query = $this->db->query("DELETE FROM " . DB_PREFIX . "indexer_queue WHERE indexer_id = '" . (int)$row['indexer_id'] . "'");
				}
			}
		}		
	}	