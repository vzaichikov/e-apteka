<?php
	ini_set('memory_limit', '-1');
	class ControllerEaptekaCatalog extends Controller {
		private $updateFromLastFile = false;
		
		
		private $error 			= [];
		private $nodes 			= [];
		private $address 		= "";
		private $login 			= "";
		private $password 		= "";
		private $json_file 		= DIR_CATALOG . "../cron/data/catalog_test.json";
		private $last_file 		= DIR_CATALOG . "/catalog.json";
		private $exchange_data 	= "";
		private $httpcode 		= "";
		private $added_products 		= [];
		private $added_manufacturers 	= [];
		private $addedOrEditedProducts 	= [];
		private $bestsellers 			= [];				
		
		private $mapFieldsToGeneralLogic = [
		'КлассификаторАТХИМЯ' 	=> 'КлассификаторАТХ_ua',
		'КлассификаторАТХИМЯRU' => 'КлассификаторАТХ_ru',
		'СсылкаНоменклатураОсновноеДействуещиеВеществоНаименование' 	=> 'СсылкаНоменклатураОсновноеДействуещиеВеществоНаименование_ru',
		'СсылкаНоменклатураОсновноеДействуещиеВеществоНаименованиеУкр' 	=> 'СсылкаНоменклатураОсновноеДействуещиеВеществоНаименование_ua',
		'ДействуещиеВеществоНаименование' 								=> 'ДействуещиеВеществоНаименование_ru',
		'ДействуещиеВеществоНаименованиеУкр' 							=> 'ДействуещиеВеществоНаименование_ua'
		];
		
		private $main_category_name_id 	= 0;
		private $null_uuid 				= '00000000-0000-0000-0000-000000000000';
		
		private $category_name_array 		= array();
		private $category_uuid_array 		= array();
		private $manufacturer_name_array 	= array();
		private $manufacturer_uuid_array 	= array();
		private $pricegroup_name_array 		= array();
		private $pricegroup_uuid_array 		= array();
		private $product_name_array 		= array();
		private $product_uuid_array 		= array();
		private $attribute_name_array 		= array();
		private $socialprogram_name_array 	= array();
		
		private function convert($size){
			$unit=array('b','kb','mb','gb','tb','pb');
			return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
		}
		
		private function onlyNumbers($text){
			
			$text = trim($text);
			$text = trim($text, '0123456789');
			
			return (!$text || mb_strlen($text) == 0 || $text == "");
		}
		
		private function initNodes(){
			
			$this->load->model('setting/nodes');
			$this->nodes = $this->model_setting_nodes->getNodesForCatalogUpdate();		
		}

		public function reindexElastic(){
			$this->load->library('hobotix/ElasticSearch');
			$this->elasticSearch = new hobotix\ElasticSearch($this->registry);

			foreach ($this->addedOrEditedProducts as $product_id){
				$this->elasticSearch->reindexproduct($product_id);
			}
		}
		
		private function initCatalog(){
			$this->load->model('catalog/category');
			
			$this->added_products = array();
			$this->added_manufacturers = array();
			
			echo '[i] Инициализация категорий...' . PHP_EOL;
			$query = $this->db->query("SELECT category_id, name FROM oc_category_description WHERE 1");
			foreach ($query->rows as $row){
				$this->category_name_array[$row['name']] = $row['category_id'];
			}
			
			unset($query);
			$query = $this->db->query("SELECT category_id, uuid FROM oc_category WHERE 1");
			foreach ($query->rows as $row){
				$this->category_uuid_array[$row['uuid']] = $row['category_id'];
			}
			
			echo '[i] Инициализация брендов...' . PHP_EOL;
			unset($query);
			$query = $this->db->query("SELECT manufacturer_id, name, uuid FROM oc_manufacturer WHERE 1");
			unset($row);
			foreach ($query->rows as $row){
				$this->manufacturer_name_array[$row['name']] = $row['manufacturer_id'];
				$this->manufacturer_uuid_array[$row['uuid']] = $row['manufacturer_id'];
			}
			
			echo '[i] Инициализация типов цен...' . PHP_EOL;
			unset($query);
			$query = $this->db->query("SELECT pricegroup_id, name, uuid FROM oc_price_group WHERE 1");
			unset($row);
			foreach ($query->rows as $row){
				$this->pricegroup_name_array[$row['name']] = $row['pricegroup_id'];
				$this->pricegroup_uuid_array[$row['uuid']] = $row['pricegroup_id'];
			}
			
			echo '[i] Инициализация товаров...' . PHP_EOL;
			unset($query);
			$query = $this->db->query("SELECT product_id, name FROM oc_product_description WHERE 1");
			unset($row);
			foreach ($query->rows as $row){
				$this->product_name_array[$row['name']] = $row['product_id'];
			}
			
			$query = $this->db->query("SELECT product_id, original_name FROM oc_product_description WHERE 1");
			unset($row);
			foreach ($query->rows as $row){
				$this->product_name_array[$row['original_name']] = $row['product_id'];
			}
			
			$query = $this->db->query("SELECT product_id, uuid FROM oc_product WHERE 1");
			unset($row);
			foreach ($query->rows as $row){
				$this->product_uuid_array[$row['uuid']] = $row['product_id'];
			}
			
			
			echo '[i] Инициализация атрибутов...' . PHP_EOL;
			unset($query);
			$query = $this->db->query("SELECT attribute_id, 1c_name FROM oc_attribute_description WHERE 1");
			unset($row);
			foreach ($query->rows as $row){
				$this->attribute_name_array[$row['1c_name']] = $row['attribute_id'];
			}
			
			echo '[i] Инициализация соцпроектов...' . PHP_EOL;
			unset($query);
			$query = $this->db->query("SELECT socialprogram_id, sync_name FROM oc_socialprogram WHERE 1");
			unset($row);
			foreach ($query->rows as $row){
				$this->socialprogram_name_array[$row['sync_name']] = $row['socialprogram_id'];
			}
			
			echo '[i] Инициализировали массивы поиска. Заняли памяти ' . $this->convert(memory_get_usage(true)) . PHP_EOL;
			
			$category = array(
            'Ссылка' 	   => 'main-listing-letter-category',
            'СсылкаНаименование' => 'Справочник Лекарств'
			);
			
			$real_category = false;
			if ($category_id = $this->findCategory($category)){
				echo "[F] Нашли категорию " . $category['СсылкаНаименование'] . PHP_EOL;
				
				$real_category = $this->model_catalog_category->getCategory($category_id);
				$real_category['category_description'] = $this->model_catalog_category->getCategoryDescriptions($category_id);
				
				} else {
				echo "[NF] Не нашли категорию " . $category['СсылкаНаименование'] . PHP_EOL;
			}
			
			unset($data);
			$data = array(
            'category_description' => array(
			"2" => array(
			'name' 				=> 'Справочник Лекарств',
			'description'		=> $real_category?$real_category['category_description'][2]['description']:'',
			'alternate_name'		=> $real_category?$real_category['category_description'][2]['alternate_name']:'',
			'meta_title'        => $real_category?$real_category['category_description'][2]['meta_title']:'',
			'meta_description'  => $real_category?$real_category['category_description'][2]['meta_description']:'',
			'meta_keyword'      => $real_category?$real_category['category_description'][2]['meta_keyword']:'',
			),
			"3" => array(
			'name' 				=> 'Довідник ліків',
			'description' 		=> $real_category?$real_category['category_description'][3]['description']:'',
			'alternate_name'	=> $real_category?$real_category['category_description'][3]['alternate_name']:'',
			'meta_title'        => $real_category?$real_category['category_description'][3]['meta_title']:'',
			'meta_description'  => $real_category?$real_category['category_description'][3]['meta_description']:'',
			'meta_keyword'      => $real_category?$real_category['category_description'][3]['meta_keyword']:'',
			),
			"4" => array(
			'name' 				=> 'Medicines Reference',
			'description' 		=> $real_category?$real_category['category_description'][4]['description']:'',
			'alternate_name'	=> $real_category?$real_category['category_description'][4]['alternate_name']:'',
			'meta_title'        => $real_category?$real_category['category_description'][4]['meta_title']:'',
			'meta_description'  => $real_category?$real_category['category_description'][4]['meta_description']:'',
			'meta_keyword'      => $real_category?$real_category['category_description'][4]['meta_keyword']:'',
			)
            ),
            'category_store' => array(
			'0'
            ),
            'image'      	 => $real_category?$real_category['image']:'',			
            'parent_id'      => $real_category?$real_category['parent_id']:0,
			'show_subcats'      => $real_category?$real_category['show_subcats']:0,
            'sort_order'	 => $real_category?$real_category['sort_order']:0,
            'top' 			 => $real_category?$real_category['top']:0,
			'is_searched' 	 => $real_category?$real_category['is_searched']:0,
            'status' 		 => $real_category?$real_category['status']:'1',
            'column' 		 => $real_category?$real_category['column']:'2',
            'keyword'    	 => $real_category?$real_category['keyword']:'',
            'uuid'      	 => $real_category?$real_category['uuid']:'',
			'google_base_category_id' => $real_category?$real_category['google_base_category_id']:'',
            'no_fucken_path' => true
			);
			
			if ($category_id){
				$this->model_catalog_category->editCategory($category_id, $data);
				} else {
				$category_id = $this->model_catalog_category->addCategory($data);
				$this->category_name_array['Справочник Лекарств'] = $category_id;
				$this->category_uuid_array['main-listing-letter-category'] = $category_id;
			}
			
			$this->categoryUUID($category_id, 'main-listing-letter-category');
			$this->categoryURL($category_id, 'Справочник Лекарств');
			$this->main_category_name_id = $category_id;
			
			unset($data);
		}
		
		private function getJSONFromLastFile($params = array()){
			
			$constants = get_defined_constants(true);
			$json_errors = array();
			foreach ($constants["json"] as $name => $value) {
				if (!strncmp($name, "JSON_ERROR_", 11)) {
					$json_errors[$value] = $name;
				}
			}
			
			$data = file_get_contents($this->last_file);
			
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
			$this->load->model('setting/nodes');
			
			if (isset($json["#exception"])){
				return 'JSON_1C_EXCEPTION';
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
			curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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
			curl_setopt($ch, CURLOPT_USERPWD, $this->login.':'.$this->password);
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			
			$data = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$this->httpcode = $httpcode;
			
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
			
			
			curl_close($ch);
			
			
			echo PHP_EOL;
			echo '[i] END CURL DEBUG' . PHP_EOL;
			echo PHP_EOL;
			
			file_put_contents(DIR_CATALOG . '/catalog.json', $data);			
			
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
		
		public function productUUID($product_id, $uuid){
			$this->db->query("UPDATE oc_product SET uuid = '" . $this->db->escape($uuid) . "' WHERE product_id = '" . (int)$product_id . "'");
		}
		
		public function productUUIDProduct($product_id, $uuid){
			$this->db->query("UPDATE oc_product SET uuidProduct = '" . $this->db->escape($uuid) . "' WHERE product_id = '" . (int)$product_id . "'");
		}
		
		public function manufacturerUUID($manufacturer_id, $uuid){
			$this->db->query("UPDATE oc_manufacturer SET uuid = '" . $this->db->escape($uuid) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		}
		
		public function categoryUUID($category_id, $uuid){
			$this->db->query("UPDATE oc_category SET uuid = '" . $this->db->escape($uuid) . "' WHERE category_id = '" . (int)$category_id . "'");
		}
		
		public function categoryURL($category_id, $name){
			
			$key = $this->urlify(mb_strtolower($category_id . '-' .$name));
			if ($name){
				$this->db->query("REPLACE INTO oc_url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($key) . "'");
			}
			
			echo '[S] SEO URL: ' . $name .' >> ' . $key . PHP_EOL;		
		}
		
		public function manufacturerURL($manufacturer_id, $name){
			
			if ($name){
				$key = $this->urlify(mb_strtolower($manufacturer_id . '-' .$name));
				$this->db->query("REPLACE INTO oc_url_alias SET query = 'manufacturer_id=" . (int)$manufacturer_id . "', keyword = '" . $this->db->escape($key) . "'");
			}
			
			echo '[S] SEO URL: ' . $name .' >> ' . $key . PHP_EOL;			
		}
		
		public function productURL($product_id, $name){
			
			$key = $this->urlify(mb_strtolower($product_id . '-' .$name));
			if ($name){
				$this->db->query("REPLACE INTO oc_url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($key) . "'");
			}
			
			echo '[S] SEO URL: ' . $name .' >> ' . $key . PHP_EOL;			
		}
		
		public function updateProductSocialInfo($product_id, $data = array()){
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_socialprogram WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['product_socialprogram'])) {
				foreach ($data['product_socialprogram'] as $socialprogram_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_socialprogram SET product_id = '" . (int)$product_id . "', socialprogram_id = '" . (int)$socialprogram_id . "'");
				}
			}
			
			if(isset($data['main_socialprogram_id']) && $data['main_socialprogram_id'] > 0) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_socialprogram WHERE product_id = '" . (int)$product_id . "' AND socialprogram_id = '" . (int)$data['main_socialprogram_id'] . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_socialprogram SET product_id = '" . (int)$product_id . "', socialprogram_id = '" . (int)$data['main_socialprogram_id'] . "', main_socialprogram = 1");
				} elseif(isset($data['product_socialprogram'][0])) {
				$this->db->query("UPDATE " . DB_PREFIX . "product_to_socialprogram SET main_socialprogram = 1 WHERE product_id = '" . (int)$product_id . "' AND socialprogram_id = '" . (int)$data['product_socialprogram'][0] . "'");
			}			
		}
		
		public function makeDirName($name){
			
			$name = URLify::transliterate(URLify::rms($name));
			$name = str_replace('-','',$name);
			
			return $name;			
		}
		
		public function urlify($name){
			
			$key = URLify::transliterate(URLify::rms2($name));
			$key = trim($key, ' -');
			
			return $key;			
		}
		
		public function normalizeProductName($name){
			
			$name = trim($name);
			$name = ltrim($name, ')(!');
			
			return $name;			
		}
		
		public function normalizePriceGroupName($name){
			
			$name = trim($name);
			
			return $name;		
		}
		
		public function normalizeCategoryName($name){
			
			$name = trim($name);
			$name = trim($name, '(!}{');
			
			return $name;			
		}
		
		public function normalizeManufacturerName($name){
			
			$name = trim($name);
			$name = ltrim($name, '"');
			
			return $name;			
		}
		
		public function normalizeCategoryTree($category_tree){
			
			$category_remove_array = array(
            '!',
            '}',
            '{',
            '(растворители для ин',
            'Вода д/ин'
			
			);
			
			$category_tree = str_replace($category_remove_array, '', $category_tree);
			$category_tree = trim($category_tree);
			$category_tree = mb_substr($category_tree, 0, -1);
			
			return $category_tree;		
		}
				
		public function getCategoryFaq($category_id){
			
			$category_faqs = $this->model_catalog_category->getCategoryFaq($category_id);
			
			$unserialized = array();
			
			foreach ($category_faqs as $category_faq) {
				$unserialized[] = array(
				'question'       	=> unserialize($category_faq['question']),
				'faq'       		=> unserialize($category_faq['faq']),
				'icon'     			=> $category_faq['icon'],
				'sort_order' 		=> $category_faq['sort_order']
				);
			}
			
			return $unserialized;			
		}
		
		public function getProductFaq($product_id){
			
			$product_faqs = $this->model_catalog_product->getProductFaq($product_id);
			
			$unserialized = array();
			
			foreach ($product_faqs as $product_faq) {
				$unserialized[] = array(
				'question'       	=> unserialize($product_faq['question']),
				'faq'       		=> unserialize($product_faq['faq']),
				'icon'     			=> $product_faq['icon'],
				'sort_order' 		=> $product_faq['sort_order']
				);
			}
			
			return $unserialized;			
		}
		
		
		public function ifToAddAttribute($text){
			
			$to_add = true;
			
			if ($this->onlyNumbers($text)){
				if (mb_strlen($text) > 8){
					$to_add = false;
				}
			}
			
			return $to_add;
		}
		
		public function findAttribute($sync_name){
			$attribute_id = false;			
			
			if (isset($this->attribute_name_array[$sync_name])){				
				$attribute_id = $this->attribute_name_array[$sync_name];				
			}
			
			return $attribute_id;			
		}
		
		public function findMultiAttribute($sync_name){
			
			$attribute_id = false;
			
			$sync_name = 'multi:' . $sync_name;
			
			if (isset($this->attribute_name_array[$sync_name])){
				
				$attribute_id = $this->attribute_name_array[$sync_name];
				
			}
			
			return $attribute_id;					
		}
		
		public function findMultiLangAttribute($sync_name){
			
			$attribute_id = false;
			
			$sync_name = 'multilang:' . $sync_name;
			
			if (isset($this->attribute_name_array[$sync_name])){
				
				$attribute_id = $this->attribute_name_array[$sync_name];
				
			}
			
			return $attribute_id;
		}
				
		public function findIndexAttribute($sync_name, $iterator){
			$attribute_id = false;
			
			$sync_name = 'index:'.$sync_name.':' . $iterator;
			
			if (isset($this->attribute_name_array[$sync_name])){
				
				$attribute_id = $this->attribute_name_array[$sync_name];
				
			}
			
			return $attribute_id;		
		}
		
		public function findSocialProgram($socialprogram){
			$socialprogram_id = false;
			
			if (isset($this->socialprogram_name_array[$socialprogram])){
				
				$socialprogram_id = $this->socialprogram_name_array[$socialprogram];
				
			}
			
			return $socialprogram_id;			
		}
		
		public function findManufacturer($manufacturer){
			$manufacturer_id = false;
			
			if (isset($this->manufacturer_uuid_array[$manufacturer['Ссылка']])){
				
				$manufacturer_id = $this->manufacturer_uuid_array[$manufacturer['Ссылка']];
				
				} elseif (isset($this->manufacturer_name_array[$manufacturer['СсылкаНаименование']])){
				
				$manufacturer_id = $this->manufacturer_name_array[$manufacturer['СсылкаНаименование']];
				
			}
			
			return $manufacturer_id;			
		}
		
		public function findPriceGroup($pricegroup){
			$pricegroup_id = false;
			
			if (isset($this->pricegroup_uuid_array[$pricegroup['Ссылка']])){
				
				$pricegroup_id = $this->pricegroup_uuid_array[$pricegroup['Ссылка']];
				
				} elseif (isset($this->pricegroup_name_array[$pricegroup['СсылкаНаименование']])){
				
				$pricegroup_id = $this->pricegroup_name_array[$pricegroup['СсылкаНаименование']];
				
			}
			
			return $pricegroup_id;			
		}
		
		public function parseManufacturerCountry($manufacturer_name){
			
			if (strpos($manufacturer_name, ')')){
			}						
		}
		
		public function findCategory($category){
			
			$category_id = false;
			
			if (isset($this->category_uuid_array[$category['Ссылка']])){
				
				$category_id = $this->category_uuid_array[$category['Ссылка']];
				
				} elseif (isset($this->category_name_array[$category['СсылкаНаименование']])){
				
				$category_id = $this->category_name_array[$category['СсылкаНаименование']];
				
			}
			
			return $category_id;			
		}
		
		public function parseCategoryTree($category_tree, $product_name = ''){			
		}
		
		public function findProduct($product){
			
			$product_id = false;
			
			if (isset($this->product_uuid_array[$product['СсылкаНоменклатура']])){
				
				$product_id = $this->product_uuid_array[$product['СсылкаНоменклатура']];
				
				} elseif (isset($this->product_name_array[$product['СсылкаНаименование']])){
				
				$product_id = $this->product_name_array[$product['СсылкаНаименование']];
				
			}
			
			return $product_id;
		}		
		
		public function postActions(){
			$this->load->model('catalog/category');
			$this->load->model('catalog/manufacturer');
			$this->load->model('catalog/product');
			
			$this->initCatalog();			
			
			//Страна производитель
			
			if ($attribute_id = $this->findAttribute('ProductFieldMAP:MANUFACTURERCOUNTRY')){
				
				echo '[i] Пост-обработка.. Страна производитель, атрибут ' . $attribute_id . PHP_EOL;
				
				$this->db->query("DELETE FROM oc_product_attribute WHERE attribute_id = '" . (int)$attribute_id . "'");
				$this->db->query("INSERT IGNORE INTO oc_product_attribute (`product_id`,`attribute_id`,`language_id`,`text`) SELECT product_id, '" . (int)$attribute_id . "', '2', (SELECT country FROM oc_manufacturer_description WHERE manufacturer_id = oc_product.manufacturer_id AND language_id = '2') as text FROM oc_product WHERE manufacturer_id > 0");
				$this->db->query("INSERT IGNORE INTO oc_product_attribute (`product_id`,`attribute_id`,`language_id`,`text`) SELECT product_id, '" . (int)$attribute_id . "', '3', (SELECT country FROM oc_manufacturer_description WHERE manufacturer_id = oc_product.manufacturer_id AND language_id = '3') as text FROM oc_product WHERE manufacturer_id > 0");
				// $this->db->query("INSERT IGNORE INTO oc_product_attribute (`product_id`,`attribute_id`,`language_id`,`text`) SELECT product_id, '" . (int)$attribute_id . "', '4', (SELECT country FROM oc_manufacturer_description WHERE manufacturer_id = oc_product.manufacturer_id AND language_id = '4') as text FROM oc_product WHERE manufacturer_id > 0");
			}
			
			//Общая обработка
			$this->model_catalog_category->repairCategories();
			
			// //удаляем пустые категории
			// $query = $this->db->query("SELECT DISTINCT category_id FROM oc_category WHERE uuid = '' AND category_id NOT IN (SELECT DISTINCT(category_id) FROM oc_product_to_category WHERE 1)");
			// if ($query->num_rows) {
			// 	foreach ($query->rows as $row){
			// 		$this->model_catalog_category->deleteCategory($row['category_id']);
			// 		echo '[i] Пост-обработка.. Удаляем пустую категорию ' . $row['category_id'] . PHP_EOL;
			// 	}
			// }
			
			// //надо отключить пустые категории
			// echo '[i] Пост-обработка.. Отключение пустых категорий ' . PHP_EOL;
			
			// $filter_data = array(
            // 'start' => 0,
            // 'limit' => 10000
			// );
			
			// $categories = $this->model_catalog_category->getCategories($filter_data);
			
			// foreach ($categories as $category){
			// 	$filter_data = array(
            //     'filter_category_id' => $category['category_id'],
            //     'filter_sub_category' => true
			// 	);
				
			// 	$product_total = $this->model_catalog_product->getTotalProductsExtended($filter_data);
				
			// 	if ($product_total){
			// 		echo '[EXIST] Количество: ' . $product_total . ' в категории ' . html_entity_decode($category['name']) . PHP_EOL;
			// 		} else {
			// 		echo '[NOPRO] Количество: ' . $product_total . ' в категории ' . html_entity_decode($category['name']) . PHP_EOL;
			// 		$this->db->query("UPDATE oc_category SET status = 0 WHERE category_id = '" . (int)$category['category_id'] . "'");
			// 	}
			// }
			
			echo '[i] Пост-обработка.. Обработка товаров которые нельзя доставить или оплатить' . PHP_EOL;
			
			//	$this->db->query("UPDATE oc_product SET no_shipping = 0 WHERE 1");
			//	$this->db->query("UPDATE oc_product SET no_payment = 0 WHERE 1");
			
			$this->db->query("UPDATE oc_product SET no_shipping = 1 WHERE product_id IN (SELECT product_id FROM oc_product_to_category WHERE category_id IN (SELECT category_id FROM oc_category WHERE no_shipping = 1))");
			$this->db->query("UPDATE oc_product SET no_payment = 1 WHERE product_id IN (SELECT product_id FROM oc_product_to_category WHERE category_id IN (SELECT category_id FROM oc_category WHERE no_payment = 1))");
			
			echo '[i] Пост-обработка.. Чистка пустых брендов' . PHP_EOL;
			$filter_data = array(
            'start' => 0,
            'limit' => 10000
			);
			
			$manufacturers = $this->model_catalog_manufacturer->getManufacturers($filter_data);
			
			foreach ($manufacturers as $manufacturer){
				$filter_data = array(
                'filter_manufacturer_id' => $manufacturer['manufacturer_id'],
				);
				
				$product_total = $this->model_catalog_product->getTotalProductsExtended($filter_data);
				
				if ($product_total){
					echo '[EXIST] Количество: ' . $product_total . ' в производителе ' . html_entity_decode($manufacturer['name']) . PHP_EOL;
					} else {
					echo '[NOPRO] Количество: ' . $product_total . ' в производителе ' . html_entity_decode($manufacturer['name']) . PHP_EOL;
					$this->model_catalog_manufacturer->deleteManufacturer($manufacturer['manufacturer_id']);
				}
				
				
			}
			
			//Установка атрибута Бренд
			$this->db->query("INSERT INTO oc_product_attribute (`product_id`,`attribute_id`,`language_id`,`text`) SELECT product_id, 30, 2, isbn FROM oc_product WHERE LENGTH(isbn)>1 ON DUPLICATE KEY UPDATE `text` = (SELECT isbn FROM oc_product WHERE product_id = oc_product_attribute.product_id) ");
			
			$this->db->query("INSERT INTO oc_product_attribute (`product_id`,`attribute_id`,`language_id`,`text`) SELECT product_id, 30, 3, isbn FROM oc_product WHERE LENGTH(isbn)>1 ON DUPLICATE KEY UPDATE `text` = (SELECT isbn FROM oc_product WHERE product_id = oc_product_attribute.product_id) ");
			
			$this->db->query("INSERT INTO oc_product_attribute (`product_id`,`attribute_id`,`language_id`,`text`) SELECT product_id, 30, 4, isbn FROM oc_product WHERE LENGTH(isbn)>1 ON DUPLICATE KEY UPDATE `text` = (SELECT isbn FROM oc_product WHERE product_id = oc_product_attribute.product_id) ");
			
			echo '[i] Пост-обработка.. Чистка пустых записей' . PHP_EOL;
			$this->db->query("DELETE FROM oc_product_to_category WHERE category_id NOT IN (SELECT category_id FROM oc_category WHERE 1)");
			$this->db->query("DELETE FROM oc_category_description WHERE category_id NOT IN (SELECT category_id FROM oc_category WHERE 1)");
			$this->db->query("DELETE FROM oc_category_path WHERE category_id NOT IN (SELECT category_id FROM oc_category WHERE 1)");
			$this->db->query("DELETE FROM oc_category_path WHERE path_id NOT IN (SELECT category_id FROM oc_category WHERE 1)");
			
			//Обновляем поле TOP у категорий
			echo '[i] Пост-обработка.. Поле top у категорий' . PHP_EOL;
			$this->db->query("UPDATE oc_category SET top = 0 WHERE parent_id > 0");
			$this->db->query("UPDATE oc_category SET top = 1 WHERE parent_id = 0");
			
			echo '[i] Пост-обработка.. Обнуляем наличие' . PHP_EOL;
			$this->db->query("UPDATE oc_product SET quantity = 0 WHERE 1");
			
			echo '[i] Пост-обработка.. Установка цен и наличия' . PHP_EOL;
			$this->db->query("UPDATE oc_product p SET quantity = 
				(SELECT SUM(quantity) FROM oc_stocks s WHERE 
					s.product_id = p.product_id 
					AND location_id IN (SELECT location_id FROM oc_location WHERE temprorary_closed = 0)
					GROUP BY s.product_id) WHERE 1");
			$this->db->query("UPDATE oc_product p SET quantity = 0 WHERE quantity < 0");
			$this->db->query("UPDATE oc_product p SET is_onstock = 0 WHERE quantity <= 0");
			$this->db->query("UPDATE oc_stocks SET  quantity = 0 WHERE quantity < 0");
			$this->db->query("UPDATE oc_product p SET is_onstock = 1 WHERE quantity > 0");			
			
			
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
			WHERE is_onstock = 1	
			"
			);
			
			$this->db->query("DROP TABLE IF EXISTS oc_temp_stocks");
			$this->db->query("CREATE TEMPORARY TABLE IF NOT EXISTS oc_temp_stocks AS (SELECT * FROM oc_stocks)");
			$this->db->query("UPDATE oc_stocks os SET price = (SELECT MAX(price) FROM oc_temp_stocks os2 WHERE os2.product_id = os.product_id LIMIT 1)  WHERE product_id IN (SELECT DISTINCT product_id FROM oc_product WHERE is_preorder = 1)");
			$this->db->query("UPDATE oc_stocks os SET quantity = (SELECT MAX(quantity) FROM oc_temp_stocks os2 WHERE os2.product_id = os.product_id LIMIT 1)  WHERE product_id IN (SELECT DISTINCT product_id FROM oc_product WHERE is_preorder = 1)");
			$this->db->query("DROP TABLE IF EXISTS oc_temp_stocks");
			
			//Проставить параметр поиска is_searched
			/*
			$this->db->query("UPDATE oc_product SET is_searched = 0 WHERE 1");
			$this->db->query("UPDATE oc_product SET is_searched = 1 WHERE product_id IN 
			(SELECT product_id FROM oc_category_path cp LEFT JOIN oc_product_to_category p2c ON (cp.category_id = p2c.category_id) 
			WHERE cp.path_id IN (SELECT category_id FROM oc_category WHERE is_searched = 1)) 
			");
			*/

			$this->reindexElastic();
			
			//Пересчет бестселлеров по самым нижним категориям
			$this->db->query("UPDATE oc_product SET bestseller = 0 WHERE 1");
			$query = $this->db->query("SELECT category_id FROM oc_category WHERE category_id NOT IN (SELECT parent_id FROM oc_category) AND status = 1 AND parent_id <> 1");
			echo '[BESTSELLER] Пересчет хитов продаж' . PHP_EOL;
			foreach ($query->rows as $row){
				$filter_data = array(
					'filter_category_id'  => $row['category_id'],
					'filter_status'		  => true,
					'filter_instock'	  => true,
					'filter_sub_category' => false,
				);

				$total_products = $this->model_catalog_product->getTotalProductsExtended($filter_data);
				$bestsellers = $this->model_extension_module_xdstickers->getBestSellerProducts2((int)(($total_products*0.05)), $row['category_id'], true);

				echo '[BESTSELLER] Категория ' . $row['category_id'] . ', всего товаров: ' . $total_products . ', хиты: ' . implode(',', $bestsellers) .  PHP_EOL;

				if ($bestsellers){
					$this->db->query("UPDATE oc_product SET bestseller = 1 WHERE product_id IN (" . implode(',', $bestsellers) . ")");
				}	
			}
			unset($row);									
		}

		public function reparseArrayForMultilang($array){
			$reparsed = [];

			foreach ($array as $key => $value){
				if (!empty($this->mapFieldsToGeneralLogic[$key])){
					$reparsed[$this->mapFieldsToGeneralLogic[$key]] = $value;
				} else {
					$reparsed[$key] = $value;
				}
			}

			return $reparsed;
		}	

		
		public function reparseJSONToExcludeBadParams($json){			
			$resultJSON = [];
			
			foreach ($json as &$product){
				
				foreach ($this->mapFieldsToGeneralLogic as $key => $value){		
					$product[$value] = $product[$key];
					unset($product[$key]);
				}
				
				
				$resultJSON[] = $product;
			}
			
			return $resultJSON;
		}		
		
		public function reparseEnabledJSON($json){
			$tmpJSON = $json;
			$tmpJSON2 = $json;
			$resultJSON = array();
			$enabledExplicitJSON = array();
			$enabledExplicitJSONProduct = array();
			
			
			echo '[i] Репарсинг итерация 1 ' . PHP_EOL;
			foreach ($tmpJSON as $product){
				if (empty($product['СсылкаНоменклатура']) || !$product['СсылкаНоменклатура']){								
					} else {
					//Это товар, и он есть среди включенных
					if (!$product['СсылкаНеактивно']){
						$enabledExplicitJSON[] = $product['СсылкаНоменклатура'];
						$enabledExplicitJSONProduct[$product['СсылкаНоменклатура']] = $product;
					}				
				}
			}
			
			echo '[i] Репарсинг итерация 2 ' . PHP_EOL;
			foreach ($tmpJSON2 as &$product2){
				if (empty($product2['СсылкаНоменклатура']) || !$product2['СсылкаНоменклатура']){								
					} else {
					if (in_array($product2['СсылкаНоменклатура'], $enabledExplicitJSON)){
						$product2['СсылкаНеактивно'] = false;
						
						if (!empty($enabledExplicitJSONProduct[$product2['СсылкаНоменклатура']])){
							$product2 = $enabledExplicitJSONProduct[$product2['СсылкаНоменклатура']];
						}
					}			
				}
				
				$resultJSON[] = $product2;
			}
			
			return $resultJSON;
		}
		
		public function updateCatalog(){
			$this->load->model('catalog/product');
			$this->load->model('catalog/manufacturer');
			$this->load->model('catalog/category');
			$this->load->model('catalog/pricegroup');
			$this->load->model('setting/nodes');
			$this->load->model('catalog/ocfilter');
			$this->load->model('extension/module/xdstickers');
			
			
			$this->initNodes();
			if ($this->nodes){	
				foreach ($this->nodes as $node){
					print_r($node['node_id'] . "\n");
					//Ставим что все оке с нодой
					$this->model_setting_nodes->setNodeLastUpdateStatusSuccess($node['node_id']);
					
					$this->address = $node['node_url'];
					$this->login = $node['node_auth'];
					$this->password = $node['node_password'];
					
					echo '[i] Начинаем синхронизацию с узлом ' . $node['node_name'] . PHP_EOL;
					$this->model_setting_nodes->setNodeLastUpdateStatus($node['node_id'], 'NODE_EXCHANGE_START_PROCESS');
					
					//---------------------------- *JSON* ----------------------------
					if ($this->updateFromLastFile){
						$json = $this->getJSONFromLastFile();
						} else {
						$json = $this->getJSON();
					}
					
					if (!$json || !is_array($json)){
						$this->model_setting_nodes->setNodeLastUpdateStatus($node['node_id'], $json);
						$this->model_setting_nodes->setNodeLastUpdateStatusError($node['node_id']);
						
						$history_data = array(
						'status' => $json,
						'type'   => 'catalog',
						'json'   => $this->exchange_data,
						'is_error' => 1
						);
						
						$this->model_setting_nodes->addNodeExchangeHistory($node['node_id'], $history_data);
						
						//обработка после загрузки регулярная
						$this->postActions();
						
						
						if ($json != 'JSON_ERROR_NONE'){
							$this->load->library('hobotix/TelegramSender');
							$telegramSender = new hobotix\TelegramSender;
							
							$message = '';
							$message .= 'https://e-apteka.com.ua/error.jpg' . PHP_EOL;
							$message .= '<b>Господа, у нас ошибка обмена!</b>' . PHP_EOL;
							$message .= '<b>Скрипт:</b> ' . basename(__FILE__) . PHP_EOL;
							$message .= '<b>Узел:</b> ' . $node['node_name'] . PHP_EOL;
							$message .= '<b>URI:</b> ' . $this->address . PHP_EOL;
							$message .= '<b>Ошибка:</b> ' . $json . PHP_EOL;
							$message .= '<b>Код ответа:</b> ' . $this->httpcode . PHP_EOL;
							$message .= '<b>Данные:</b> ' . substr($this->exchange_data,0,500) . '';
							
							$telegramSender->SendMessage($message);
						}
						
						die('[ERR] Нет удалось разобрать JSON: ' . $json . PHP_EOL);
					}
					
					//---------------------------- *Старт* ----------------------------
					
					echo "[i] Разбираем товары..." . PHP_EOL;
					$i = 1;
					$cnt = count($json);
					
					
					if (!$cnt || $json == 'JSON_ERROR_NONE') {
						$this->model_setting_nodes->setNodeLastUpdateStatus($node['node_id'], 'JSON_ERROR_NONE');
						$this->model_setting_nodes->setNodeLastUpdateStatusError($node['node_id']);
						
						$history_data = array(
						'status' => 'JSON_ERROR_NONE',
						'type'   => 'catalog',
						'json'   => $this->exchange_data,
						'is_error' => 1
						);
						
						$this->model_setting_nodes->addNodeExchangeHistory($node['node_id'], $history_data);
						
						//обработка после загрузки регулярная
						$this->postActions();
						
						die('[ERR] Нет зарегистрированных изменений' . PHP_EOL);
					}
					
					$this->initCatalog();
					
					$json = $this->reparseEnabledJSON($json);
					$json = $this->reparseJSONToExcludeBadParams($json);
					
					unset($data);
					foreach ($json as $_product){
						
						echo "$i / $cnt" . PHP_EOL;
						$i++;
						
						$product = $_product;
						
						//---------------------------- *Проверки* ----------------------------
						if (!$product['СсылкаНоменклатураНаименование'] && $product['СсылкаНаименование']){
							$product['СсылкаНоменклатураНаименование'] = $product['СсылкаНаименование'];
						}
						
						if ($product['СсылкаНоменклатураНаименование'] && !$product['СсылкаНаименование']){
							$product['СсылкаНаименование'] = $product['СсылкаНоменклатураНаименование'];
						}
						
						$product['СсылкаНоменклатураНаименование'] = $this->normalizeProductName($product['СсылкаНоменклатураНаименование']);
						$product['СсылкаНаименование'] = $this->normalizeProductName($product['СсылкаНаименование']);
						
						$product['СсылкаРодительНаименование'] = $this->normalizeCategoryName($product['СсылкаРодительНаименование']);
						
						$product['СсылкаНоменклатураЦеноваяГруппаНаименование'] = $this->normalizePriceGroupName($product['СсылкаНоменклатураЦеноваяГруппаНаименование']);
						
						$product['СсылкаНоменклатураПроизводительНаименование'] = $this->normalizeProductName($product['СсылкаНоменклатураПроизводительНаименование']);
						$product['СсылкаНоменклатураПроизводительНаименование'] = $this->normalizeManufacturerName($product['СсылкаНоменклатураПроизводительНаименование']);
						
						if (!$product['СсылкаНоменклатураНаименование'] || !$product['СсылкаНаименование']){
							echo '[ERR] Пустое название товара, пропускаем...' . PHP_EOL;
							continue;
						}
						//---------------------------- *Проверки* ----------------------------
						
						
						//---------------------------- *Это категория* ----------------------------
						if (empty($product['СсылкаНоменклатура']) || !$product['СсылкаНоменклатура']){
							echo "[i] Это категория!" . PHP_EOL;
							
							$product['СсылкаНаименование'] = $this->normalizeCategoryName($product['СсылкаНаименование']);
							
							$category = array(
							'Ссылка' 	   => $product['Ссылка'],
							'СсылкаНаименование' => $product['СсылкаНаименование']
							);
							
							//---------------------------- Родитель категории ----------------------------
							$parent_id = 0;
							$real_category = false;
							if (!empty($product['СсылкаРодитель']) && $product['СсылкаРодитель'] && $product['СсылкаРодитель'] != $this->null_uuid) {
								$product['СсылкаНаименование'] = $this->normalizeCategoryName($product['СсылкаНаименование']);
								
								$parent = array(
								'Ссылка' 	   => $product['СсылкаРодитель'],
								'СсылкаНаименование' => $product['СсылкаРодительНаименование']
								);
								
								$real_category = false;
								if ($parent_id = $this->findCategory($parent)){
									
									echo "[F] Нашли родителя " . $product['СсылкаРодительНаименование'] . PHP_EOL;
									
									$real_category = $this->model_catalog_category->getCategory($parent_id);
									$real_category['category_description'] = $this->model_catalog_category->getCategoryDescriptions($parent_id);
									
									} else {
									
									echo "[NF] Не нашли родителя " . $product['СсылкаРодительНаименование'] . PHP_EOL;
								}
								
								unset($data);
								$data = array(
								'category_description' => array(
								"2" => array(
								//'name' 				=> $real_category?$real_category['category_description'][2]['name']:$product['СсылкаРодительНаименование'],
								'name' 				=> $product['СсылкаРодительНаименование'],
								'alternate_name'	=> $real_category?$real_category['category_description'][2]['alternate_name']:'',
								'seo_name' 			=> $real_category?$real_category['category_description'][2]['seo_name']:'',
								'faq_name' 			=> $real_category?$real_category['category_description'][2]['faq_name']:'',
								'description' 		=> $real_category?$real_category['category_description'][2]['description']:'',
								'meta_title'        => $real_category?$real_category['category_description'][2]['meta_title']:'',
								'meta_description'  => $real_category?$real_category['category_description'][2]['meta_description']:'',
								'meta_keyword'      => $real_category?$real_category['category_description'][2]['meta_keyword']:'',
								),
								"3" => array(
								'name' 				=> $real_category?$real_category['category_description'][3]['name']:$product['СсылкаРодительНаименование'],
								//'name' 				=> $product['СсылкаРодительНаименование'],
								'alternate_name'	=> $real_category?$real_category['category_description'][3]['alternate_name']:'',
								'seo_name' 			=> $real_category?$real_category['category_description'][3]['seo_name']:'',
								'faq_name' 			=> $real_category?$real_category['category_description'][3]['faq_name']:'',
								'description' 		=> $real_category?$real_category['category_description'][3]['description']:'',
								'meta_title'        => $real_category?$real_category['category_description'][3]['meta_title']:'',
								'meta_description'  => $real_category?$real_category['category_description'][3]['meta_description']:'',
								'meta_keyword'      => $real_category?$real_category['category_description'][3]['meta_keyword']:'',
								),
								// "4" => array(
								// 'name' 				=> $real_category?$real_category['category_description'][4]['name']:$product['СсылкаРодительНаименование'],
								// //'name' 				=> $product['СсылкаРодительНаименование'],
								// 'alternate_name'	=> $real_category?$real_category['category_description'][4]['alternate_name']:'',
								// 'seo_name' 			=> $real_category?$real_category['category_description'][4]['seo_name']:'',
								// 'faq_name' 			=> $real_category?$real_category['category_description'][4]['faq_name']:'',
								// 'description' 		=> $real_category?$real_category['category_description'][4]['description']:'',
								// 'meta_title'        => $real_category?$real_category['category_description'][4]['meta_title']:'',
								// 'meta_description'  => $real_category?$real_category['category_description'][4]['meta_description']:'',
								// 'meta_keyword'      => $real_category?$real_category['category_description'][4]['meta_keyword']:'',
								// )
								),
								'category_store' => array(
								'0'
								),
								'image'          => $real_category?$real_category['image']:'',
								'parent_id'      => $real_category?$real_category['parent_id']:0,
								'show_subcats'   => $real_category?$real_category['show_subcats']:0,
								'sort_order'     => $real_category?$real_category['sort_order']:0,
								'top' 			 => $real_category?$real_category['top']:0,
								'is_searched' 	 => $real_category?$real_category['is_searched']:0,
								'status'		 => $real_category?$real_category['status']:'1',
								'column' 		 => $real_category?$real_category['column']:'2',
								'keyword'    	 => $real_category?$real_category['keyword']:'',
								'uuid'      	 => $real_category?$real_category['uuid']:$product['СсылкаРодитель'],
								'no_fucken_path' => true,
								'google_base_category_id' => $real_category?$real_category['google_base_category_id']:'',
								'category_faq'	 => $real_category?$this->getCategoryFaq($real_category['category_id']):array()
								);
								
								if ($parent_id){
									$this->model_catalog_category->editCategory($parent_id, $data);
									} else {
									$parent_id = $this->model_catalog_category->addCategory($data);
									$this->category_name_array[$product['СсылкаРодительНаименование']] = $parent_id;
									$this->category_uuid_array[$product['СсылкаРодитель']] = $parent_id;
								}
								
								$this->categoryUUID($parent_id, $product['СсылкаРодитель']);
								$this->categoryURL($parent_id, $product['СсылкаРодительНаименование']);
								
							}
							
							if ($product['СсылкаРодитель'] == $this->null_uuid){
								
								echo "[ERR] NULL UUID, пропускаем категорию" . PHP_EOL;
								
							}
							//---------------------------- Родитель категории ----------------------------
							
							$real_category = false;
							if ($category_id = $this->findCategory($category)){
								echo "[F] Нашли категорию " . $product['СсылкаНаименование'] . PHP_EOL;
								
								$real_category = $this->model_catalog_category->getCategory($category_id);
								$real_category['category_description'] = $this->model_catalog_category->getCategoryDescriptions($category_id);
								
								} else {
								echo "[NF] Не нашли категорию " . $product['СсылкаНаименование'] . PHP_EOL;
							}
							
							unset($data);
							$data = array(
							'category_description' => array(
							"2" => array(
							//'name'			    => $real_category?$real_category['category_description'][2]['name']:$product['СсылкаНаименование'],
							'name' 				=> $product['СсылкаНаименование'],
							'alternate_name'	=> $real_category?$real_category['category_description'][2]['alternate_name']:'',
							'seo_name' 			=> $real_category?$real_category['category_description'][2]['seo_name']:'',
							'faq_name' 			=> $real_category?$real_category['category_description'][2]['faq_name']:'',
							'description' 		=> $real_category?$real_category['category_description'][2]['description']:'',
							'meta_title'        => $real_category?$real_category['category_description'][2]['meta_title']:'',
							'meta_description'  => $real_category?$real_category['category_description'][2]['meta_description']:'',
							'meta_keyword'      => $real_category?$real_category['category_description'][2]['meta_keyword']:'',
							),
							"3" => array(
							'name' 				=> $real_category?$real_category['category_description'][3]['name']:$product['СсылкаНаименование'],
							//'name' 				=> $product['СсылкаНаименование'],
							'alternate_name'	=> $real_category?$real_category['category_description'][3]['alternate_name']:'',
							'seo_name' 			=> $real_category?$real_category['category_description'][3]['seo_name']:'',
							'faq_name' 			=> $real_category?$real_category['category_description'][3]['faq_name']:'',
							'description' 		=> $real_category?$real_category['category_description'][3]['description']:'',
							'meta_title'        => $real_category?$real_category['category_description'][3]['meta_title']:'',
							'meta_description'  => $real_category?$real_category['category_description'][3]['meta_description']:'',
							'meta_keyword'      => $real_category?$real_category['category_description'][3]['meta_keyword']:'',
							),
							// "4" => array(
							// 'name' 				=> $real_category?$real_category['category_description'][4]['name']:$product['СсылкаНаименование'],
							// //'name' 				=> $product['СсылкаНаименование'],
							// 'alternate_name'	=> $real_category?$real_category['category_description'][4]['alternate_name']:'',
							// 'seo_name' 			=> $real_category?$real_category['category_description'][4]['seo_name']:'',
							// 'faq_name' 			=> $real_category?$real_category['category_description'][4]['faq_name']:'',
							// 'description' 		=> $real_category?$real_category['category_description'][4]['description']:'',
							// 'meta_title'        => $real_category?$real_category['category_description'][4]['meta_title']:'',
							// 'meta_description'  => $real_category?$real_category['category_description'][4]['meta_description']:'',
							// 'meta_keyword'      => $real_category?$real_category['category_description'][4]['meta_keyword']:'',
							// )
							),
							'category_store' => array(
							'0'
							),
							'image'      	 => $real_category?$real_category['image']:'',
							'parent_id'      => $parent_id,
							'show_subcats'   => $real_category?$real_category['show_subcats']:0,
							'sort_order' 	 => $real_category?$real_category['sort_order']:0,
							'top' 			 => $real_category?$real_category['top']:0,
							'is_searched' 	 => $real_category?$real_category['is_searched']:0,
							'status' 		 => $real_category?$real_category['status']:'1',
							'column'		 => $real_category?$real_category['column']:'2',
							'keyword'    	 => $real_category?$real_category['keyword']:'',
							'uuid'      	 => $real_category?$real_category['uuid']:$product['Ссылка'],
							'no_shipping' 	 => (isset($product['НетДоставки']) && $product['НетДоставки'])?'1':'0',
							'no_payment' 	 => (isset($product['НетОплатыОнлайн']) && $product['НетОплатыОнлайн'])?'1':'0',
							'no_advert' 	 => (isset($product['ЗапрещеноКРекламеВИнтернет']) && $product['ЗапрещеноКРекламеВИнтернет'])?'1':'0',
							'no_fucken_path' => true,
							'google_base_category_id' => $real_category?$real_category['google_base_category_id']:'',
							'category_faq'	 => $real_category?$this->getCategoryFaq($real_category['category_id']):array()
							);
							
							if ($category_id){
								$this->model_catalog_category->editCategory($category_id, $data);
								} else {
								$category_id = $this->model_catalog_category->addCategory($data);
								$this->category_name_array[$product['СсылкаНаименование']] = $category_id;
								$this->category_uuid_array[$product['Ссылка']] = $category_id;
							}
							
							$this->categoryUUID($category_id, $product['Ссылка']);
							$this->categoryURL($category_id, $product['СсылкаНаименование']);
							
							unset($data);
							continue;
						}
						//---------------------------- *Это категория* ----------------------------
						
						
						//---------------------------- *Категория* ----------------------------
						$product_category = array();
						$main_category_id = 0;
						
						//---------------------------- Категория товара ----------------------------
						if ($product['СсылкаРодитель'] && $product['СсылкаРодительНаименование']) {
							
							$category = array(
							'Ссылка' 	   => $product['СсылкаРодитель'],
							'СсылкаНаименование' => $product['СсылкаРодительНаименование']
							);
							
							$real_category = false;
							if ($category_id = $this->findCategory($category)){
								echo "[F] Нашли категорию " . $product['СсылкаРодительНаименование'] . PHP_EOL;
								
								$real_category = $this->model_catalog_category->getCategory($category_id);
								$real_category['category_description'] = $this->model_catalog_category->getCategoryDescriptions($category_id);
								
								} else {
								echo "[NF] Не нашли категорию " . $product['СсылкаРодительНаименование'] . PHP_EOL;
							}
							
							unset($data);
							$data = array(
							'category_description' => array(
							"2" => array(
							//'name'			    => $real_category?$real_category['category_description'][2]['name']:$product['СсылкаРодительНаименование'],
							'name' 				=> $product['СсылкаРодительНаименование'],
							'alternate_name'	=> $real_category?$real_category['category_description'][2]['alternate_name']:'',
							'seo_name' 			=> $real_category?$real_category['category_description'][2]['seo_name']:'',
							'faq_name' 			=> $real_category?$real_category['category_description'][2]['faq_name']:'',
							'description' 		=> $real_category?$real_category['category_description'][2]['description']:'',
							'meta_title'        => $real_category?$real_category['category_description'][2]['meta_title']:'',
							'meta_description'  => $real_category?$real_category['category_description'][2]['meta_description']:'',
							'meta_keyword'      => $real_category?$real_category['category_description'][2]['meta_keyword']:'',
							),
							"3" => array(
							'name' 				=> $real_category?$real_category['category_description'][3]['name']:$product['СсылкаРодительНаименование'],
							//'name' 				=> $product['СсылкаРодительНаименование'],
							'alternate_name'	=> $real_category?$real_category['category_description'][3]['alternate_name']:'',
							'seo_name' 			=> $real_category?$real_category['category_description'][3]['seo_name']:'',
							'faq_name' 			=> $real_category?$real_category['category_description'][3]['faq_name']:'',
							'description' 		=> $real_category?$real_category['category_description'][3]['description']:'',
							'meta_title'        => $real_category?$real_category['category_description'][3]['meta_title']:'',
							'meta_description'  => $real_category?$real_category['category_description'][3]['meta_description']:'',
							'meta_keyword'      => $real_category?$real_category['category_description'][3]['meta_keyword']:'',
							),
							// "4" => array(
							// 'name' 				=> $real_category?$real_category['category_description'][4]['name']:$product['СсылкаРодительНаименование'],
							// //'name' 				=> $product['СсылкаРодительНаименование'],
							// 'alternate_name'	=> $real_category?$real_category['category_description'][4]['alternate_name']:'',
							// 'seo_name' 			=> $real_category?$real_category['category_description'][4]['seo_name']:'',
							// 'faq_name' 			=> $real_category?$real_category['category_description'][4]['faq_name']:'',
							// 'description' 		=> $real_category?$real_category['category_description'][4]['description']:'',
							// 'meta_title'        => $real_category?$real_category['category_description'][4]['meta_title']:'',
							// 'meta_description'  => $real_category?$real_category['category_description'][4]['meta_description']:'',
							// 'meta_keyword'      => $real_category?$real_category['category_description'][4]['meta_keyword']:'',
							// )
							),
							'category_store' => array(
							'0'
							),
							'image'      	 => $real_category?$real_category['image']:'',
							'parent_id'      => $real_category?$real_category['parent_id']:0,
							'show_subcats'   => $real_category?$real_category['show_subcats']:0,
							'sort_order'	 => $real_category?$real_category['sort_order']:0,
							'top' 			 => $real_category?$real_category['top']:0,
							'is_searched' 	 => $real_category?$real_category['is_searched']:0,
							'status' 		 => $real_category?$real_category['status']:'1',
							'column' 		 => $real_category?$real_category['column']:'2',
							'keyword'    	 => $real_category?$real_category['keyword']:'',
							'uuid'      	 => $real_category?$real_category['uuid']:$product['СсылкаРодитель'],						
							'no_fucken_path' => true,
							'google_base_category_id' => $real_category?$real_category['google_base_category_id']:'',
							'category_faq'	 => $real_category?$this->getCategoryFaq($real_category['category_id']):array()
							);
							
							if ($category_id){
								$this->model_catalog_category->editCategory($category_id, $data);
								} else {
								$category_id = $this->model_catalog_category->addCategory($data);
								$this->category_name_array[$product['СсылкаРодительНаименование']] = $category_id;
								$this->category_uuid_array[$product['СсылкаРодитель']] = $category_id;
							}
							
							$this->categoryUUID($category_id, $product['СсылкаРодитель']);
							$this->categoryURL($category_id, $product['СсылкаРодительНаименование']);
							
							$main_category_id = $category_id;
							$product_category[] = $category_id;
							} else {
							
							echo '[ERR] Пустое название категории, пропускаем создание...' . PHP_EOL;
							
						}
						
						//---------------------------- Дополнительные категории товара ------------------
						
						for ($addtionalFieldCounter = 1; $addtionalFieldCounter <= 3; $addtionalFieldCounter++){
							$addtionalCategoryID = false;
							
							if (!empty($product['ПодкатегорияКаталога' . $addtionalFieldCounter]) && $product['ПодкатегорияКаталога' . $addtionalFieldCounter] != $this->null_uuid){
								
								$dataCategory = array('Ссылка' => $product['ПодкатегорияКаталога' . $addtionalFieldCounter]);
								
								if ($addtionalCategoryID = $this->findCategory($dataCategory)){
									echo "[F] Нашли дополнительную категорию " . $product['ПодкатегорияКаталога' . $addtionalFieldCounter] . PHP_EOL;
									$product_category[] = $addtionalCategoryID;
									
									} else {
									echo "[NF] Не нашли дополнительную категорию " . $product['ПодкатегорияКаталога' . $addtionalFieldCounter] . PHP_EOL;
								}
								
							}
							
						}
						//---------------------------- Категория товара ----------------------------
						
						//---------------------------- По 1 букве ----------------------------
						echo "[i] Разбираем категорию по первой букве". PHP_EOL;
						$product_name = $product['СсылкаНоменклатураНаименование'];
						if ($product_name){
							$first_letter = mb_substr($product_name, 0, 1, "UTF-8");
							
							if (is_numeric($first_letter)){
								$first_letter = '0-9';
								$category_names = array(
								'2' => 'Справочник лекарств ' . $first_letter,
								'3' => 'Довідник ліків ' . $first_letter,
							//	'4' => 'Medicines Reference ' . $first_letter,
								);
								} else {
								$category_names = array(
								'2' => 'Справочник лекарств на букву ' . $first_letter,
								'3' => 'Довідник ліків на букву ' . $first_letter,
							//	'4' => 'Medicines Reference ' . $first_letter,
								);
							}
							
							$sdata = array(
							'Ссылка' => md5($first_letter),
							'СсылкаНаименование' => $first_letter
							);
							
							$real_category = false;
							if ($category_id = $this->findCategory($sdata)){
								echo "[F] Нашли категорию по первой букве " . $first_letter . PHP_EOL;
								
								$real_category = $this->model_catalog_category->getCategory($category_id);
								$real_category['category_description'] = $this->model_catalog_category->getCategoryDescriptions($category_id);
								
								} else {
								echo "[NF] Не нашли категорию по первой букве " . $first_letter . PHP_EOL;
							}
							
							unset($data);
							$data = array(
							'category_description' => array(
							"2" => array(
							'name' 				=> $first_letter,
							'alternate_name'	=> $real_category?$real_category['category_description'][2]['alternate_name']:'',
							'seo_name' 			=> $real_category?$real_category['category_description'][2]['seo_name']:'',
							'faq_name' 			=> $real_category?$real_category['category_description'][2]['faq_name']:'',
							'description'		=> $real_category?$real_category['category_description'][2]['description']:'',
							'meta_title'        => $real_category?$real_category['category_description'][2]['meta_title']:'',
							'meta_description'  => $real_category?$real_category['category_description'][2]['meta_description']:'',
							'meta_keyword'      => $real_category?$real_category['category_description'][2]['meta_keyword']:'',
							),
							"3" => array(
							'name' 				=> $first_letter,
							'alternate_name'	=> $real_category?$real_category['category_description'][3]['alternate_name']:'',
							'seo_name' 			=> $real_category?$real_category['category_description'][3]['seo_name']:'',
							'faq_name' 			=> $real_category?$real_category['category_description'][3]['faq_name']:'',
							'description' 		=> $real_category?$real_category['category_description'][3]['description']:'',
							'meta_title'        => $real_category?$real_category['category_description'][3]['meta_title']:'',
							'meta_description'  => $real_category?$real_category['category_description'][3]['meta_description']:'',
							'meta_keyword'      => $real_category?$real_category['category_description'][3]['meta_keyword']:'',
							),
							// "4" => array(
							// 'name' 				=> $first_letter,
							// 'alternate_name'	=> $real_category?$real_category['category_description'][4]['alternate_name']:'',
							// 'seo_name' 			=> $real_category?$real_category['category_description'][4]['seo_name']:'',
							// 'faq_name' 			=> $real_category?$real_category['category_description'][4]['faq_name']:'',
							// 'description' 		=> $real_category?$real_category['category_description'][4]['description']:'',
							// 'meta_title'        => $real_category?$real_category['category_description'][4]['meta_title']:'',
							// 'meta_description'  => $real_category?$real_category['category_description'][4]['meta_description']:'',
							// 'meta_keyword'      => $real_category?$real_category['category_description'][4]['meta_keyword']:'',
							// )
							),
							'category_store' => array(
							'0'
							),
							'image'     	 => $real_category?$real_category['image']:'',
							'parent_id'      => $this->main_category_name_id,
							'show_subcats'   => $real_category?$real_category['show_subcats']:0,
							'sort_order'	 => $real_category?$real_category['sort_order']:0,
							'top' 			 =>	$real_category?$real_category['top']:0,
							'is_searched' 	 => $real_category?$real_category['is_searched']:0,
							'status' 		 => $real_category?$real_category['status']:1,
							'column'		 => $real_category?$real_category['column']:2,
							'keyword'    	 => $real_category?$real_category['keyword']:'',
							'uuid'   		 => md5($first_letter),	
							'google_base_category_id' => $real_category?$real_category['google_base_category_id']:'',
							'no_fucken_path' => true
							);
							
							
							if ($category_id){
								$this->model_catalog_category->editCategory($category_id, $data);
								} else {
								$category_id = $this->model_catalog_category->addCategory($data);
								$this->category_name_array[$first_letter] = $category_id;
							}
							
							$this->categoryURL($category_id, 'справочник-'.$first_letter);
							
							$product_category[] = $category_id;
							
							if (!$main_category_id){
								$main_category_id = $category_id;
							}
						}
						
						$product_category = array_unique($product_category);
						//---------------------------- *Категория* ----------------------------
						
			
						//---------------------------- *Бренд* ----------------------------
						$manufacturer = array(
						'Ссылка' 	   => $product['СсылкаНоменклатураПроизводитель'],
						'СсылкаНаименование' => $product['СсылкаНоменклатураПроизводительНаименование']
						);
						
						$real_manufacturer = false;
						if ($manufacturer_id = $this->findManufacturer($manufacturer)){
							echo "[F] Нашли бренд " . $product['СсылкаНоменклатураПроизводительНаименование'] . PHP_EOL;
							
							$real_manufacturer = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);
							$real_manufacturer['manufacturer_description'] = $this->model_catalog_manufacturer->getManufacturerDescriptions($manufacturer_id);
							
							} else {
							echo "[NF] Не нашли бренд " . $product['СсылкаНоменклатураПроизводительНаименование'] . PHP_EOL;
						}
						
						
						if (!trim($product['СсылкаНоменклатураПроизводительНаименование'])){
							if ($manufacturer_id){
								$product['СсылкаНоменклатураПроизводительНаименование'] = 'Manufacturer-' . $manufacturer_id;
								} else {
								$product['СсылкаНоменклатураПроизводительНаименование'] = 'Manufacturer-' . rand(1000, 10000);
							}
						}
						
						//COUNTRIES
						$countries = array(
						'2' => '',
						'3' => '',
						'4' => ''
						);
						if ($real_manufacturer){	
							if (trim($real_manufacturer['manufacturer_description'][2]['country'])){
								$countries[2] = trim($real_manufacturer['manufacturer_description'][2]['country']);
								} else {
								$countries[2] = getCountryNameFromManufacturerName($real_manufacturer['manufacturer_description'][2]['name']);
							}
							
							if (trim($real_manufacturer['manufacturer_description'][3]['country'])){
								$countries[3] = trim($real_manufacturer['manufacturer_description'][3]['country']);
								} else {
								$countries[3] = getCountryNameFromManufacturerName($real_manufacturer['manufacturer_description'][3]['name']);
							}
							
							if (trim($real_manufacturer['manufacturer_description'][4]['country'])){
								$countries[4] = trim($real_manufacturer['manufacturer_description'][4]['country']);
								} else {
								$countries[4] = getCountryNameFromManufacturerName($real_manufacturer['manufacturer_description'][4]['name']);
							}
						}
						
						if (!$countries[2]){
							$countries[2] = getCountryNameFromManufacturerName($product['СсылкаПроизводитель_ru']);													
						}
						
						if (!$countries[3]){
							$countries[3] = getCountryNameFromManufacturerName($product['СсылкаПроизводитель_ua']);													
						}
						
						if (!$countries[4]){
							$countries[4] = getCountryNameFromManufacturerName($product['СсылкаПроизводитель_en']);													
						}
						
						if (!$countries[2]){
							$countries[2] = getCountryNameFromManufacturerName($product['СсылкаНоменклатураПроизводительНаименование']);													
						}
						
						if (!$countries[3]){
							$countries[3] = getCountryNameFromManufacturerName($product['СсылкаНоменклатураПроизводительНаименование']);													
						}
						
						if (!$countries[4]){
							$countries[4] = getCountryNameFromManufacturerName($product['СсылкаНоменклатураПроизводительНаименование']);
						}
						
						unset($data);
						$data = array(
						'manufacturer_description' => array(
						"2" => array(
						'name'				=> $real_manufacturer?$real_manufacturer['manufacturer_description'][2]['name']:($product['СсылкаПроизводитель_ru']?$product['СсылкаПроизводитель_ru']:$product['СсылкаНоменклатураПроизводительНаименование']),
						'country'			=> $countries[2],
						'alternate_name' 	=> $real_manufacturer?$real_manufacturer['manufacturer_description'][2]['alternate_name']:'',
						'description' 		=> $real_manufacturer?$real_manufacturer['manufacturer_description'][2]['description']:'',
						'custom_title'  	=> $real_manufacturer?$real_manufacturer['manufacturer_description'][2]['custom_title']:'',
						'meta_description'  => $real_manufacturer?$real_manufacturer['manufacturer_description'][2]['meta_description']:'',
						'meta_keyword'      => $real_manufacturer?$real_manufacturer['manufacturer_description'][2]['meta_keyword']:'',
						),
						"3" => array(
						'name'				=> $real_manufacturer?$real_manufacturer['manufacturer_description'][3]['name']:($product['СсылкаПроизводитель_ua']?$product['СсылкаПроизводитель_ua']:$product['СсылкаНоменклатураПроизводительНаименование']),
						'alternate_name' 	=> $real_manufacturer?$real_manufacturer['manufacturer_description'][3]['alternate_name']:'',
						'country'			=> $countries[3],
						'description' 		=> $real_manufacturer?$real_manufacturer['manufacturer_description'][3]['description']:'',
						'custom_title' 		=> $real_manufacturer?$real_manufacturer['manufacturer_description'][3]['custom_title']:'',
						'meta_description'  => $real_manufacturer?$real_manufacturer['manufacturer_description'][3]['meta_description']:'',
						'meta_keyword'      => $real_manufacturer?$real_manufacturer['manufacturer_description'][3]['meta_keyword']:'',
						),
						// "4" => array(
						// 'name'				=> $real_manufacturer?$real_manufacturer['manufacturer_description'][4]['name']:($product['СсылкаПроизводитель_en']?$product['СсылкаПроизводитель_en']:$product['СсылкаНоменклатураПроизводительНаименование']),
						// 'country'			=> $countries[4],
						// 'alternate_name' 	=> $real_manufacturer?$real_manufacturer['manufacturer_description'][4]['alternate_name']:'',
						// 'description' 		=> $real_manufacturer?$real_manufacturer['manufacturer_description'][4]['description']:'',
						// 'custom_title' 		=> $real_manufacturer?$real_manufacturer['manufacturer_description'][4]['custom_title']:'',
						// 'meta_description'  => $real_manufacturer?$real_manufacturer['manufacturer_description'][4]['meta_description']:'',
						// 'meta_keyword'      => $real_manufacturer?$real_manufacturer['manufacturer_description'][4]['meta_keyword']:'',
						// )
						),
						'manufacturer_store' => array(
						'0'
						),
						'image'    		=> $real_manufacturer?$real_manufacturer['image']:'',
						'name' 			=> $real_manufacturer?$real_manufacturer['manufacturer_description'][2]['name']:($product['СсылкаПроизводитель_ru']?$product['СсылкаПроизводитель_ru']:$product['СсылкаНоменклатураПроизводительНаименование']),
						'sort_order' 	=> $real_manufacturer?$real_manufacturer['sort_order']:'0',
						'uuid' 		    => $product['СсылкаНоменклатураПроизводитель'],
						'keyword'    	=> $manufacturer_id?$this->urlify(mb_strtolower($manufacturer_id . '-' . $product['СсылкаНоменклатураПроизводительНаименование'])):$this->urlify(mb_strtolower($product['СсылкаНоменклатураПроизводительНаименование']))
						);
						
						if ($manufacturer_id){
							$this->model_catalog_manufacturer->editManufacturer($manufacturer_id, $data);
							} else {
							$manufacturer_id = $this->model_catalog_manufacturer->addManufacturer($data);
							$this->manufacturer_name_array[$product['СсылкаНоменклатураПроизводительНаименование']] = $manufacturer_id;
							$this->manufacturer_uuid_array[$product['СсылкаНоменклатураПроизводитель']] = $manufacturer_id;
							
							$this->added_manufacturers[$manufacturer_id] = $product['СсылкаНоменклатураПроизводительНаименование'];
						}
						
						$this->manufacturerUUID($manufacturer_id, $product['СсылкаНоменклатураПроизводитель']);
						$this->manufacturerURL($manufacturer_id, $product['СсылкаНоменклатураПроизводительНаименование']);
						
						
						//---------------------------- *Бренд* ----------------------------
						
						
						
						//---------------------------- *Атрибуты* ----------------------------
						$mapAttributes = array(
						'СсылкаНоменклатураФармакотерапевтическаяГруппаНаименование',
					//	'СсылкаНоменклатураОсновноеДействуещиеВеществоНаименование',				
						'СсылкаНоменклатураОтпускПоРецепту',
						'СсылкаНоменклатураТермолабильный',
						'СтранаПроисхождения',
					//	'КлассификаторАТХИМЯ',						
						);
						
						$mapMultilangAttributes = array(
						'ФормаВыпуска' => [
						'ru' => '2',
						'en' => '4',
						'uk' => '3'
						],
						'КлассификаторАТХ' => [
						'ru' => '2',
						'en' => '4',
						'ua' => '3'
						],
						'СсылкаНоменклатураОсновноеДействуещиеВеществоНаименование' => [
						'ru' => '2',
						'en' => '4',
						'ua' => '3'	
						]
						);
						
						$mapAttributesYesOnly = array(
						'НаркотическоеСредство',
						'ЯД',
						'ПКО',
						'ИНСУЛИН',
						);
						
						$mapMultiAttributes = array(
						'ДействуещииВещества' => 'ДействуещиеВеществоНаименование'
						);
						
						$mapIndexedAttributes = array(
						'ДействуещииВещества' => array(
						'max' => 5,
						'data' => array(
						'ДействуещиеВеществоНаименование',
						'Количество',
						'ЕдиницаИзмерения'
						)
						),
						);
						
						$guessRegexNameAttributes = array(
						'ОбъемВМиллилитрах' => array(
						'regex' => "[[0-9]+\sмл]",
						'int'  => true
						),
						);
						
						$product_attribute = [];
						
						//Мультиязычные атрибуты
						foreach ($mapMultilangAttributes as $map => $languageMap){
							
							if ($attribute_id = $this->findMultiLangAttribute($map)){																
								
								$value_array = array();
								
								$ifToAdd = false;
								foreach ($languageMap as $langCode => $landID){
									$text = '';
									if (isset($product[ $map . '_' . $langCode ]) && trim($product[ $map . '_' . $langCode ])) {
										$text = $product[ $map . '_' . $langCode ];
										$ifToAdd = true;
									}
									
									$value_array[$landID] = array('text' => $text);
								}
								
								if ($value_array && $ifToAdd){
									$product_attribute[] = array(
									'attribute_id' => $attribute_id,
									'product_attribute_description' => $value_array
									);									
									
									echo "[A] Атрибут " . $attribute_id . ', значение ' . $text . PHP_EOL;
									
									} else {
									
									echo "[AERR] Значение атрибута не подходит: " . $text . PHP_EOL;
									
								}
							}
						}						
						
						foreach ($mapIndexedAttributes as $map => $indexData){
							
							if (isset($product[$map])) {
								
								for ($iter = 0; $iter <= $indexData['max']; $iter++){
									
									if (is_array($product[$map]) && isset($product[$map][$iter])){
										
										if ($attribute_id = $this->findIndexAttribute($map, $iter)) {
											$product[$map][$iter] = $this->reparseArrayForMultilang($product[$map][$iter]);
											
											echo "[A] Нашли индексный атрибут " . $attribute_id . PHP_EOL;
											
											$val = [];
											$value_array = [];

											foreach ($indexData['data'] as $valmap){
												foreach ($languageMap as $langCode => $landID){												
													if (!empty($product[$map][$iter][$valmap . '_' . $langCode])){
														$value_array[$langCode][] =  $product[$map][$iter][$valmap . '_' . $langCode];
													} elseif (isset($product[$map][$iter][$valmap]) && $product[$map][$iter][$valmap]){
														$value_array[$langCode][] =  $product[$map][$iter][$valmap];
													}
												}												
											}								
											
											$text = [];
											foreach ($languageMap as $langCode => $landID){
												$text[$landID] = implode(' ', $value_array[$langCode]);
											}

											echo '[A] Значение: ' . $text[2] . PHP_EOL;
											
											if ($value_array && $text && $this->ifToAddAttribute($text[2]) && $this->ifToAddAttribute($text[3])){
												$product_attribute[] = array(
												'attribute_id' => $attribute_id,
												'product_attribute_description' => array(
												"2" => array(
												'text' => $text[2],
												),
												"3" => array(
												'text' => $text[3],
												),
												// "4" => array(
												// 'text' => $text[4],
												// )
												)
												);
												echo "[A] Атрибут " . $attribute_id . ', значение ' . $text . PHP_EOL;
												
												} else {
												
												echo "[AERR] Значение атрибута не подходит: " . $text . PHP_EOL;
												
											}
											
										}
									}																		
								}								
							}
						}
						
						//Атрибуты, значение которых только "да"
						foreach ($mapAttributesYesOnly as $map){
							$attribute_id = $this->findAttribute($map);
							
							if ($attribute_id && isset($product[$map])){
								
								echo "[A] Нашли атрибут, только да " . $attribute_id . PHP_EOL;
								
								$text = array();
								
								if ($product[$map] === true){
									$text[2] = "Да";
									$text[3] = "Так";
									$text[4] = "Yes";
								}
								
								if ($text && $text[2] && $text[3] && $text[4] && $this->ifToAddAttribute($text[2]) && $this->ifToAddAttribute($text[3]) && $this->ifToAddAttribute($text[4])){
									$product_attribute[] = array(
									'attribute_id' => $attribute_id,
									'product_attribute_description' => array(
									"2" => array(
									'text' => $text[2],
									),
									"3" => array(
									'text' => $text[3],
									),
									// "4" => array(
									// 'text' => $text[4],
									// )
									)
									);
									echo "[A] Атрибут " . $attribute_id . ', значение ' . $text[2] . PHP_EOL;
									}  else {
									
									echo "[AERR] Значение атрибута не подходит: " . $text[2] . PHP_EOL;
									
								}								
							}
						}
																
						foreach ($mapAttributes as $map){
							$attribute_id = $this->findAttribute($map);
							
							if ($attribute_id && isset($product[$map])){
								
								echo "[A] Нашли атрибут " . $attribute_id . PHP_EOL;
								
								$text = array();
								if ($product[$map] === false){
									$text[2] = "Нет";
									$text[3] = "Ні";
									$text[4] = "No";
									} elseif ($product[$map] === true){
									$text[2] = "Да";
									$text[3] = "Так";
									$text[4] = "Yes";
									} else {
									$text[2] = $product[$map];
									$text[3] = $product[$map];
									$text[4] = $product[$map];
								}
								
								if ($text && $text[2] && $text[3] && $text[4] && $this->ifToAddAttribute($text[2]) && $this->ifToAddAttribute($text[3]) && $this->ifToAddAttribute($text[4])){
									$product_attribute[] = array(
									'attribute_id' => $attribute_id,
									'product_attribute_description' => array(
									"2" => array(
									'text' => $text[2],
									),
									"3" => array(
									'text' => $text[3],
									),
									// "4" => array(
									// 'text' => $text[4],
									// )
									)
									);
									echo "[A] Атрибут " . $attribute_id . ', значение ' . $text[2] . PHP_EOL;
									
									} else {
									
									echo "[AERR] Значение атрибута не подходит: " . $text[2] . PHP_EOL;
									
								}
							}
						}
						
						unset($map);
						foreach ($mapMultiAttributes as $map => $maptext){
							$attribute_id = $this->findMultiAttribute($map, true);
							
							if ($attribute_id && isset($product[$map])){								
								
								echo "[A] Нашли мультиатрибут " . $attribute_id . PHP_EOL;
								
								$text = [];
								foreach ($product[$map] as $val){
									$val = $this->reparseArrayForMultilang($val);

									foreach ($languageMap as $langCode => $landID){	
										if (!empty($val[$maptext . '_' . $langCode]) && $this->ifToAddAttribute($val[$maptext . '_' . $langCode])){
											$text[$landID][] = $val[$maptext . '_' . $langCode];
										} elseif (!empty($val[$maptext]) && $this->ifToAddAttribute($val[$maptext])){
											$text[$landID] = $val[$maptext];
										}

									}
								}
								
								foreach ($languageMap as $langCode => $landID){	
									$text[$landID] = implode(';', $text[$landID]);
								}
								
								if ($text && $this->ifToAddAttribute($text[2]) && $this->ifToAddAttribute($text[3])){
									$product_attribute[] = array(
									'attribute_id' => $attribute_id,
									'product_attribute_description' => array(
									"2" => array(
									'text' => $text[2],
									),
									"3" => array(
									'text' => $text[3],
									),
									// "4" => array(
									// 'text' => $text[4],
									// )
									)
									);
									echo "[A] Атрибут " . $attribute_id . ', значение ' . $text[2] . PHP_EOL;
									
									} else {
									
									echo "[AERR] Значение атрибута не подходит " . PHP_EOL;
									
								}
								
							}							
						}
						
						unset($map);
						foreach ($guessRegexNameAttributes  as $map => $regex){
							$attribute_id = $this->findAttribute($map);
							
							$matches = array();
							
							if ($attribute_id && preg_match ( $regex['regex'] , $product['СсылкаНоменклатураНаименование'], $matches)){
								
								if (isset($matches[0]) && $matches[0]){
									
									echo "[A] Нашли regexp - атрибут " . $attribute_id . PHP_EOL;
									
									if ($regex['int']){
										$text = preg_replace('/[^0-9]/', '',  $matches[0]);
									}
									
									if ($text){
										$product_attribute[] = array(
										'attribute_id' => $attribute_id,
										'product_attribute_description' => array(
										"2" => array(
										'text' => $text,
										),
										"3" => array(
										'text' => $text,
										),
										// "4" => array(
										// 'text' => $text,
										// )
										)
										);
										
										echo "[A] В наименовании есть атрибут " . $attribute_id . ', значение ' . $text . PHP_EOL;
										
									}									
								}								
							}
						}
						//---------------------------- *Атрибуты* ----------------------------
						
						
						//---------------------------- *Ценовая группа* ----------------------------
						
						$pricegroup = array(
						'Ссылка' 	   => $product['СсылкаНоменклатураЦеноваяГруппа'],
						'СсылкаНаименование' => $product['СсылкаНоменклатураЦеноваяГруппаНаименование']
						);
						
						$pricegroup_id = 0;
						
						if ($product['СсылкаНоменклатураЦеноваяГруппа'] && $product['СсылкаНоменклатураЦеноваяГруппаНаименование']) {
							
							if ($pricegroup_id = $this->findPriceGroup($pricegroup)){
								echo "[F] Нашли ценовую группу " . $product['СсылкаНоменклатураЦеноваяГруппаНаименование'] . PHP_EOL;
								
								
								} else {
								echo "[NF] Не нашли ценовую группу " . $product['СсылкаНоменклатураЦеноваяГруппаНаименование'] . PHP_EOL;
							}
							
							$data = array(
							'name' => $product['СсылкаНоменклатураЦеноваяГруппаНаименование'],
							'uuid' => $product['СсылкаНоменклатураЦеноваяГруппа']
							);
							
							if ($pricegroup_id){
								
								$this->model_catalog_pricegroup->editPriceGroup($pricegroup_id, $data);
								
								} else {
								
								$pricegroup_id = $this->model_catalog_pricegroup->addPriceGroup($data);
								$this->pricegroup_name_array[$product['СсылкаНоменклатураЦеноваяГруппаНаименование']] = $pricegroup_id;
								$this->pricegroup_uuid_array[$product['СсылкаНоменклатураЦеноваяГруппа']] = $pricegroup_id;
							}
							
							} else {
							
							echo "[ERR] Пустая ценовая группа, пропускаем" . PHP_EOL;
							
						}
						
						//---------------------------- *Ценовая группа* ----------------------------
						
						
						
						//---------------------------- *Товар* ----------------------------
						$real_product = false;
						if ($product_id = $this->findProduct($product)){
							echo "[F] Нашли товар " . $product['СсылкаНоменклатураНаименование'] . PHP_EOL;
							
							$real_product = $this->model_catalog_product->getProduct($product_id);
							$real_product['product_description'] = $this->model_catalog_product->getProductDescriptions($product_id);
							
							} else {
							echo "[NF] Не нашли товар " . $product['СсылкаНоменклатураНаименование'] . PHP_EOL;
						}
						
						//Бренд
						if ($real_product && $text = $real_product['isbn']){
							if ($attribute_id = $this->findAttribute('ProductFieldMAP:ISBN')){
								$product_attribute[] = array(
								'attribute_id' => $attribute_id,
								'product_attribute_description' => array(
								"2" => array(
								'text' => $text,
								),
								"3" => array(
								'text' => $text,
								),
								// "4" => array(
								// 'text' => $text,
								// )
								)
								);
								echo "[A] У товара задан бренд " . $attribute_id . ', значение ' . $text . PHP_EOL;
							}
						}
						
						//Страна производитель
						if ($real_product && $real_product['manufacturer_id']){							
							if ($attribute_id = $this->findAttribute('ProductFieldMAP:MANUFACTURERCOUNTRY')){
								$product_attribute[] = array(
								'attribute_id' => $attribute_id,
								'product_attribute_description' => array(
								"2" => array(
								'text' => $countries[2],
								),
								"3" => array(
								'text' => $countries[3],
								),
								// "4" => array(
								// 'text' => $countries[4],
								// )
								)
								);
								
								$text = $countries[2];
								
								echo "[AСП] У товара задана страна-производитель " . $attribute_id . ', значение ' . $text . PHP_EOL;
							}														
						}

						//Торговое наименование
						if ($real_product && $real_product['reg_trade_name']){							
							if ($attribute_id = $this->findAttribute('ProductFieldMAP:REGTRADENAME')){
								$product_attribute[] = array(
								'attribute_id' => $attribute_id,
								'product_attribute_description' => array(
								"2" => array(
								'text' => $real_product['reg_trade_name'],
								),
								"3" => array(
								'text' => $real_product['reg_trade_name'],
								),
								// "4" => array(
								// 'text' => $real_product['reg_trade_name'],
								// )
								)
								);
								
								$text = $real_product['reg_trade_name'];
								
								echo "[AСП] У товара есть торговое наименование из реестра " . $attribute_id . ', значение ' . $real_product['reg_trade_name'] . PHP_EOL;
							}														
						}

						//Сроки хранения
						if ($real_product && $real_product['reg_save_terms']){							
							if ($attribute_id = $this->findAttribute('ProductFieldMAP:SAVETERMS')){
								$product_attribute[] = array(
								'attribute_id' => $attribute_id,
								'product_attribute_description' => array(
								"2" => array(
								'text' => $real_product['reg_save_terms'],
								),
								"3" => array(
								'text' => $real_product['reg_save_terms'],
								),
								// "4" => array(
								// 'text' => $real_product['reg_save_terms'],
								// )
								)
								);
								
								$text = $real_product['reg_save_terms'];
								
								echo "[AСП] У товара есть сроки хранения из реестра " . $attribute_id . ', значение ' . $real_product['reg_save_terms'] . PHP_EOL;
							}														
						}
						
						
						echo '[i] Основная категория: ' . $main_category_id . PHP_EOL;
						
						//Обработка специальных полей
						if ($product['НаркотическоеСредство'] || $product['ПКО']){
							$product['НетДоставки'] = true;
							$product['НетОплатыОнлайн'] = true;
						}

						//УБРАТЬ ЭТО!!!!
						if ($product['НаркотическоеСредство'] || $product['ПКО'] ||  $product['СсылкаНоменклатураТермолабильный']){
							$product['НетДоставки'] = true;
							$product['НетОплатыОнлайн'] = true;
						} else {
							$product['НетДоставки'] = false;
							$product['НетОплатыОнлайн'] = false;
						}

						
						$morion_code = '';
						if (trim($product['SKU'])){
							$morion_code = $product['SKU'];
						}
						
						$sku = $model = '';
						if (trim($product['КОДТОВАРА'])){
							$model = $product['КОДТОВАРА'];
							$sku = $product['КОДТОВАРА'];							
						}
						
						if (!$model){
							$model = $product['СсылкаНоменклатураНаименование'];
						}
						
						$enableProduct = 1;
						if ($product['СсылкаНеактивно']){
							$enableProduct = 0;
						}
						
						$social_parent_id = false;
						if ((isset($product['ОсновнойТоварСоцпрограммы']) && $product['ОсновнойТоварСоцпрограммы'])){
							$enableProduct = 0;
							
							//Ищем основной товар
							$findParentData = array(
							'СсылкаНоменклатура' => $product['ОсновнойТоварСоцпрограммы'],
							'СсылкаНаименование' => $product['ОсновнойТоварСоцпрограммы']
							);
							$social_parent_id = $this->findProduct($findParentData);
							
							if ($product['СсылкаНеактивно']){
								$social_parent_id = 0;
							}
							
							echo '[i] Социальная программа, основной товар: ' . $social_parent_id . PHP_EOL;
						}
						
						$product_names = array();
						
						if ($real_product && $real_product['dnup']){
							
							echo '[i] Названия товара не перезаписываются из 1С' . PHP_EOL;
							
							$product_names[2] = $real_product['product_description'][2]['name'];
							$product_names[3] = $real_product['product_description'][2]['name'];
							$product_names[4] = $real_product['product_description'][2]['name'];
							
							} else {
							
							$product_names[2] = $product['СсылкаНоменклатураНаименование']?$product['СсылкаНоменклатураНаименование']:$product['СсылкаНаименование_ru'];
							$product_names[3] = $product['СсылкаНаименование_ua']?$product['СсылкаНаименование_ua']:$product['СсылкаНаименование_ru'];
							$product_names[4] = $product['СсылкаНаименование_en']?$product['СсылкаНаименование_en']:$product['СсылкаНаименование_ru'];
							
						}
						
						$original_names = array(
						2 => $product['СсылкаНоменклатураНаименование']?$product['СсылкаНоменклатураНаименование']:$product['СсылкаНаименование_ru'],
						3 => $product['СсылкаНаименование_ua']?$product['СсылкаНаименование_ua']:$product['СсылкаНаименование_ru'],
						4 => $product['СсылкаНаименование_en']?$product['СсылкаНаименование_en']:$product['СсылкаНаименование_ru']
						);
						
						$product_option = array();
						if (!empty($product['kolvo_vupakovke'])){
							$count_of_parts = round((1 / $product['kolvo_vupakovke']));
							
							$product_option[] = array(
							'product_option_value' => array(
							array(
                            'option_value_id' => 2,
                            'quantity' => $count_of_parts * $real_product['quantity'],
                            'subtract' => 1,
                            'price' => round(($real_product['price'] / $count_of_parts), 2),
                            'price_prefix' => '=',
                            'points' => 0,
                            'points_prefix' => '+',
                            'weight' => 0,
                            'weight_prefix' => '+',							
							),							
							),
							'option_id' => 2,
							'name' => 'Упаковка',
							'type' => 'radio',
							'value' => '',
							'required' => 0
							);														
						}
						
						
						unset($data);
						$data = array(
						'product_description' => array(
						"2" => array(
						'name' 					=> $product_names[2],
						'original_name' 		=> $original_names[2],
						'seo_name'				=> $real_product?$real_product['product_description'][2]['seo_name']:'',
						'faq_name' 				=> $real_product?$real_product['product_description'][2]['faq_name']:'',
						'description'			=> $real_product?$real_product['product_description'][2]['description']:'',
						'instruction' 		    => $real_product?$real_product['product_description'][2]['instruction']:'',
						'tag'         		    => $real_product?$real_product['product_description'][2]['tag']:'',
						'meta_title'    	    => $real_product?$real_product['product_description'][2]['meta_title']:$product_names[2],
						'meta_description'      => $real_product?$real_product['product_description'][2]['meta_description']:'',
						'meta_keyword'          => $real_product?$real_product['product_description'][2]['meta_keyword']:'',
						),
						"3" => array(
						'name'					=> $product_names[3],
						'original_name' 		=> $original_names[3],
						'seo_name'				=> $real_product?$real_product['product_description'][3]['seo_name']:'',
						'faq_name' 				=> $real_product?$real_product['product_description'][3]['faq_name']:'',
						'description' 			=> $real_product?$real_product['product_description'][3]['description']:'',
						'instruction' 			=> $real_product?$real_product['product_description'][3]['instruction']:'',
						'tag'         			=> $real_product?$real_product['product_description'][3]['tag']:'',
						'meta_title'        	=> $real_product?$real_product['product_description'][3]['meta_title']:$product_names[3],
						'meta_description'      => $real_product?$real_product['product_description'][3]['meta_description']:'',
						'meta_keyword'          => $real_product?$real_product['product_description'][3]['meta_keyword']:''
						),
						// "4" => array(
						// 'name'					=> $product_names[4],
						// 'original_name' 		=> $original_names[4],
						// 'seo_name'				=> $real_product?$real_product['product_description'][4]['seo_name']:'',
						// 'faq_name' 				=> $real_product?$real_product['product_description'][4]['faq_name']:'',
						// 'description' 			=> $real_product?$real_product['product_description'][4]['description']:'',
						// 'instruction' 			=> $real_product?$real_product['product_description'][4]['instruction']:'',
						// 'tag'         			=> $real_product?$real_product['product_description'][4]['tag']:'',
						// 'meta_title'        	=> $real_product?$real_product['product_description'][4]['meta_title']:$product_names[4],
						// 'meta_description'      => $real_product?$real_product['product_description'][4]['meta_description']:'',
						// 'meta_keyword'          => $real_product?$real_product['product_description'][4]['meta_keyword']:''
						// )
						),
						'product_store' => array(
						'0'
						),
						'image' 						=> $real_product?$real_product['image']:'',
						'model'  						=> $model,
						'sku'    						=> $sku,
						'upc'    						=> $morion_code,
						'no_shipping' 					=> (isset($product['НетДоставки']) && $product['НетДоставки'])?'1':'0',
						'no_payment' 					=> (isset($product['НетОплатыОнлайн']) && $product['НетОплатыОнлайн'])?'1':'0',
						'no_advert' 	 				=> (isset($product['ЗапрещеноКРекламеВИнтернет']) && $product['ЗапрещеноКРекламеВИнтернет'])?'1':'0',
						'is_receipt' 					=> (isset($product['СсылкаНоменклатураОтпускПоРецепту']) && $product['СсылкаНоменклатураОтпускПоРецепту'])?'1':'0',
						'ean'    						=> trim($product['barcode_ean']),
						'jan'    						=> $real_product?$real_product['jan']:'',
						'isbn'    						=> $real_product?$real_product['isbn']:'',
						'mpn'     						=> !empty($product['number_reg_posvidchennya'])?trim($product['number_reg_posvidchennya']):'',
						'reg_number'					=> !empty($product['number_reg_posvidchennya'])?trim($product['number_reg_posvidchennya']):'',
						'keyword'     					=> $real_product?$real_product['keyword']:'',
						'location'     					=> '',
						'minimum'     					=> '',
						'subtract'     					=> '',
						'date_available'    			=> '',
						'manufacturer_id'    			=> $manufacturer_id,
						'product_attribute' 			=> $product_attribute,
						'product_category' 				=> $product_category,
						'main_category_id' 				=> $main_category_id,
						'price'     					=> $real_product?$real_product['price']:0,
						'points'     					=> '',
						'weight'     					=> '',
						'weight_class_id'    			=> '',
						'length'     					=> '',
						'width'     					=> '',
						'height'     					=> '',
						'length_class_id'    			=> '',
						'tax_class_id'     				=> '',
						'product_option'				=> $product_option,
						'pricegroup_id'     			=> $pricegroup_id,
						'sort_order'     				=> $real_product?$real_product['sort_order']:'',
						'backlight'     				=> $real_product?$real_product['backlight']:'',
						'is_preorder' 					=> (isset($product['ПодЗаказ']) && $product['ПодЗаказ'])?'1':'0',
						'is_thermolabel' 				=> (isset($product['СсылкаНоменклатураТермолабильный']) && $product['СсылкаНоменклатураТермолабильный'])?'1':'0',
						'is_drug' 						=> (isset($product['НаркотическоеСредство']) && $product['НаркотическоеСредство'])?'1':'0',
						'is_pko' 						=> (isset($product['ПКО']) && $product['ПКО'])?'1':'0',
						'dnup' 							=> (isset($real_product['dnup']) && $real_product['dnup'])?'1':'0',
						'bestseller' 					=> $real_product?$real_product['bestseller']:'',
						'status' 						=> $enableProduct,
						'stock_status_id' 				=> 8,
						'shipping'   					=> 1,
						'uuid' 							=> $product['СсылкаНоменклатура'],
						/* PARTS */
						'name_of_part'					=> !empty($product['name_ed_izm'])?trim($product['name_ed_izm']):'',
						'uuid_of_part'					=> !empty($product['uuid_ed_izm'])?trim($product['uuid_ed_izm']):'',						
						'count_of_parts'				=> !empty($product['kolvo_vupakovke'])?round((1 / $product['kolvo_vupakovke'])):1,
						/* PARTS */
						'quantity'   					=> $real_product?$real_product['quantity']:0,
						'social_program'				=> isset($product['Соцпрограмма'])?$product['Соцпрограмма']:'',
						'social_parent_id'				=> $social_parent_id,
						'social_parent_uuid'			=> isset($product['ОсновнойТоварСоцпрограммы'])?$product['ОсновнойТоварСоцпрограммы']:'',
						'product_analog' 				=> $real_product?$this->model_catalog_product->getProductAnalog($real_product['product_id']):array(),
						'product_light' 				=> $real_product?$this->model_catalog_product->getProductLight($real_product['product_id']):array(),
						'product_related' 				=> $real_product?$this->model_catalog_product->getProductRelated($real_product['product_id']):array(),
						'product_same' 					=> $real_product?$this->model_catalog_product->getProductSame($real_product['product_id']):array(),
						'product_special' 				=> $real_product?$this->model_catalog_product->getProductSpecials($real_product['product_id']):array(),
						'product_collection' 			=> $real_product?$this->model_catalog_product->getProductCollections($real_product['product_id']):array(),
						'product_socialprogram' 		=> $real_product?$this->model_catalog_product->getProductSocialprograms($real_product['product_id']):array(),
						'main_collection_id' 			=> $real_product?$this->model_catalog_product->getProductMainCollectionId($real_product['product_id']):array(),
						'ocfilter_product_option' 		=> $real_product?$this->model_catalog_ocfilter->getProductOCFilterValues($real_product['product_id']):array(),
						'product_faq' 					=> $real_product?$this->getProductFaq($real_product['product_id']):array(),
						'xdstickers' 					=> $real_product?$this->model_extension_module_xdstickers->getCustomXDStickersProduct($real_product['product_id']):array()
						);	
						
						//Обновление информации о социальной программе в основном товаре
						if ($social_parent_id){
							
							if ($socialprogram_id = $this->findSocialProgram($product['Соцпрограмма'])){
								
								echo '[i] Нашли социальную программу, обновляем основной товар: ' . $product['Соцпрограмма'] . PHP_EOL;
								
								$product_social_data = array(
								'product_socialprogram' => array($socialprogram_id),
								'main_socialprogram_id' => $socialprogram_id
								);
								
								$this->updateProductSocialInfo($social_parent_id, $product_social_data);
							}
						}
						
						
						if ($product_id){
							$this->model_catalog_product->editProduct($product_id, $data);
							} else {
							$product_id = $this->model_catalog_product->addProduct($data);
							$this->product_name_array[$product['СсылкаНоменклатураНаименование']] = $product_id;
							$this->product_uuid_array[$product['СсылкаНоменклатура']] = $product_id;
							
							$this->added_products[$product_id] = $product['СсылкаНоменклатураНаименование'];
						}
						
						$this->productUUID($product_id, $product['СсылкаНоменклатура']);
						$this->productURL($product_id, $product['СсылкаНоменклатураНаименование']);
						
					}

					$this->addedOrEditedProducts[] = $product_id;
					
					if ($this->added_products){
						$this->load->library('hobotix/TelegramSender');
						$telegramSender = new hobotix\TelegramSender;						
						$telegramSender->setGroupID(TELEGRAM_CONTENT_BOT_GROUP);
						
						$message = '';
						$message = 'https://e-apteka.com.ua/lots-of-happiness.jpg' . PHP_EOL;
						$message .= '<b>Девочки, нам тут добавили новые товары на сайт!</b>' . PHP_EOL . PHP_EOL;
						
						foreach ($this->added_products as $addedProductID => $addedProduct){
							$message .= '<b>Код товара ' . $addedProductID . '</b>, ' . $addedProduct . PHP_EOL;
						}
						
						$message .= PHP_EOL;
						$message .= 'Вперед, за работу!:)';
						
						$telegramSender->SendMessage($message);
					}
					
					if ($this->added_manufacturers){
						$this->load->library('hobotix/TelegramSender');
						$telegramSender = new hobotix\TelegramSender;
						
						$telegramSender->setGroupID(TELEGRAM_CONTENT_BOT_GROUP);
						
						$message = '';
						$message = 'https://e-apteka.com.ua/cat-with-hat.png' . PHP_EOL;
						$message .= '<b>Девочки, нам тут добавили новых производителей на сайт!</b>' . PHP_EOL . PHP_EOL;
						
						foreach ($this->added_manufacturers as $addedManufacturerID => $addedManufacturer){
							$message .= '<b>Код ' . $addedManufacturerID . '</b>, ' . $addedManufacturer . PHP_EOL;
						}
						
						$message .= PHP_EOL;
						$message .= 'Вперед, за работу!:)';
						
						$telegramSender->SendMessage($message);
					}
					
					$this->added_products = array();
					$this->added_manufacturers = array();
					
					
					//обработка после загрузки регулярная
					$this->postActions();
					
					$this->model_setting_nodes->setNodeLastUpdateStatus($node['node_id'], 'NODE_EXCHANGE_SUCCESS');
					$this->model_setting_nodes->setNodeLastUpdateStatusSuccess($node['node_id']);
					
					$history_data = array(
					'status' => 'NODE_EXCHANGE_SUCCESS',
					'type'   => 'catalog',
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
			
			
		}
		
	}																												