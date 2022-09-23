<?php
	class ControllerFeedGoogleMerchantCli extends Controller {
		
		private $barcodeValidator;
		private $color_option_id = 14;
		private $default_language_id = 2;
		private $default_google_base_category = 518;
		private $exclude_categories = array(1);
		private $counts = array(
		'no_price' 		=> 0,
		'no_payment' 	=> 0,
		'is_receipt' 	=> 0,
		);
		
		private $deliveries = array(
		'ru-ru' => array(
		'Доставка по Киеву',
		),
		'uk-ua' => array(
		'Доставка по Україні м. Київ',
		)
		);
		
		private function is_color($option_id){
			if (is_array($this->color_option_id)){
				return in_array($option_id, $this->color_option_id);
				} else {
				return ($option_id == $this->color_option_id);
			}
		}
		
		private function normalizeForGoogle($text){
			$text = str_replace('&nbsp;', ' ', $text);
			$text = str_replace(' & ', ' and ', $text);
			$text = str_replace('&', ' and ', $text);
			$text = preg_replace("/&#?[a-z0-9]{2,8};/i","",$text);
			
			return $text;
		}
		
		
		private function echoLine($line){
			$line = str_replace('<![CDATA[', '', $line);
			$line = str_replace(']]>', '', $line);
			echo $line . PHP_EOL;			
		}
		
		private function echoSimple($line){
			echo $line;			
		}
		
		private function memoryUnits($size)
		{
			$unit=array('b','kb','mb','gb','tb','pb');
			return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
		}
		
		protected function getPath($parent_id, $current_path = '') {
			$category_info = $this->model_catalog_category->getCategory($parent_id);
			
			if ($category_info) {
				if (!$current_path) {
					$new_path = $category_info['category_id'];
					} else {
					$new_path = $category_info['category_id'] . '_' . $current_path;
				}
				
				$path = $this->getPath($category_info['parent_id'], $new_path);
				
				if ($path) {
					return $path;
					} else {
					return $new_path;
				}
			}
		}
		
		private function formatProductAttributes($attribute_groups){
			
			$result = '';
			foreach ($attribute_groups as $ag){
				if (!empty($ag['attribute'])){
					foreach ($ag['attribute'] as $attribute){
						$result .= $attribute['name'] . ' : ' . $attribute['text'] . '. ';
					}					
				}
			}
			
			$result = trim($result);
			
			return $result;
		}
		
		protected function printItem($product, $google_base_category){
			
			if ($product['price'] <= 0){
				$this->echoLine('[FRBD] Товар ' . $product['name'] . ', цена меньше 0');
				$this->counts['no_price']++;
				return '';
			}
		
			$output = '';
			
			$attributes = $this->model_catalog_product->getProductAttributes($product['product_id']);
			
			$product['description'] = $this->normalizeForGoogle(strip_tags(html_entity_decode($product['description'], ENT_QUOTES, 'UTF-8')));
			
			if ($attributes){
				$product['description'] .= $this->formatProductAttributes($attributes);
			}
			
			if (mb_strlen($product['description']) >= 1000){
				$product['description'] = mb_substr($product['description'], 0, 996) . '...';
			}
			
			$output .= '<item>' . PHP_EOL;
			$output .= '<title><![CDATA[' . $this->normalizeForGoogle($product['name']) . ']]></title>' . PHP_EOL;
			$output .= '<link>' . $this->url->link('product/product', 'product_id=' . $product['product_id']) . '</link>' . PHP_EOL;
			$output .= '<description><![CDATA[' . $product['description'] . ']]></description>' . PHP_EOL;
			$output .= '<g:brand><![CDATA[' . html_entity_decode($product['manufacturer'], ENT_QUOTES, 'UTF-8') . ']]></g:brand>' . PHP_EOL;
			$output .= '<g:condition>new</g:condition>' . PHP_EOL;

			if ($product['no_payment'] == 1 || $product['is_receipt'] == 1 || $product['no_advert'] == 1){
				$output .= '<g:excluded_destination>Shopping_ads</g:excluded_destination>' . PHP_EOL;
				$output .= '<g:excluded_destination>Buy_on_Google_listings</g:excluded_destination>' . PHP_EOL;
				$output .= '<g:excluded_destination>Display_ads</g:excluded_destination>' . PHP_EOL;
				$output .= '<g:excluded_destination>Free_listings</g:excluded_destination>' . PHP_EOL;
			}
			
			$productID = $product['product_id'];
			if ($this->config->get('config_language_id') != $this->default_language_id){
				$productID .= '-' . $this->config->get('config_language_id');
			}
			
			$output .= '<g:id>' . $productID . '</g:id>' . PHP_EOL;
			
			if (!empty($product['item_group_id'])){
				$output .= '<g:item_group_id>' . trim($product['item_group_id']) . '</g:item_group_id>' . PHP_EOL;
			}
			
			if (!empty($product['size'])){
				$output .= '<g:size><![CDATA[' . trim($product['size']) . ']]></g:size>' . PHP_EOL;
			}
			
			if (!empty($product['color'])){
				$output .= '<g:color><![CDATA[' . trim($product['color']) . ']]></g:color>' . PHP_EOL;
			}
			
			if ($product['image']) {
				$output .= '  <g:image_link><![CDATA[' . trim($this->model_tool_image->resize($product['image'], 720, 720)) . ']]></g:image_link>' . PHP_EOL;
				} else {
				$output .= '  <g:image_link></g:image_link>';
			}
			
			$images = $this->model_catalog_product->getProductImages($product['product_id']);
			if ($images){
				foreach ($images as $image) {
					$output .= '  <g:additional_image_link><![CDATA[' . trim($this->model_tool_image->resize($image['image'], 720, 720)) . ']]></g:additional_image_link>' . PHP_EOL;
				}
			}
						
			
			if ($attributes){
				foreach ($attributes as $ag){
					if (!empty($ag['attribute'])){
						foreach ($ag['attribute'] as $attribute){
							if (!$attribute['highlight'] && trim($attribute['text'])){
								$output .= '<g:product_detail>' . PHP_EOL;
								$output .= '<g:section_name><![CDATA[' . $ag['name'] . ']]></g:section_name>' . PHP_EOL;
								$output .= '<g:attribute_name><![CDATA[' . $attribute['name'] . ']]></g:attribute_name>' . PHP_EOL;
								$output .= '<g:attribute_value><![CDATA[' . $attribute['text'] . ']]></g:attribute_value>' . PHP_EOL;
								$output .= '</g:product_detail>' . PHP_EOL;
							}
						}					
					}
				}
			}
												
			$gtin = false;
			if ($product['ean']) {
				
				$this->barcodeValidator->setBarcode($product['ean']);
				if ($this->barcodeValidator->isValid()){
					$gtin = $this->barcodeValidator->getGTIN14();
				}				
				
			}

			if ($gtin){
				$output .= '  <g:gtin><![CDATA[' . $gtin . ']]></g:gtin>' . PHP_EOL;	
			}
			
			if ($product['manufacturer']) {
				$output .= '  <g:brand><![CDATA[' . $product['manufacturer'] . ']]></g:brand>' . PHP_EOL;
			}
			$output .= '  <g:model_number><![CDATA[' . trim($product['model']) . ']]></g:model_number>' . PHP_EOL;
			
			
			if ($product['mpn']) {
				$output .= '  <g:mpn><![CDATA[' . $product['mpn'] . ']]></g:mpn>' ;			
			}
			
			if (!$product['sku'] && !$gtin && !$product['manufacturer']){
				$output .= '  <g:identifier_exists>false</g:identifier_exists>' . PHP_EOL;
			}
			
			$currencies = array(
			'UAH'
			);
			
			if (in_array($this->session->data['currency'], $currencies)) {
				$currency_code = $this->session->data['currency'];
				$currency_value = $this->currency->getValue($this->session->data['currency']);
				} else {
				$currency_code = 'UAH';
				$currency_value = $this->currency->getValue('UAH');
			}
			
			$output .= '  <g:price>' . $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id']), $currency_code, $currency_value, false) . ' ' . $currency_code . '</g:price>' . PHP_EOL;
			
			if ((float)$product['special']) {
				$output .= '  <g:sale_price_effective_date></g:sale_price_effective_date>' . PHP_EOL;
				$output .= '  <g:sale_price>' .  $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id']), $currency_code, $currency_value, false) . ' ' . $currency_code . '</g:sale_price>'. PHP_EOL;
			}
			
			/*
				$multiflat = $this->config->get('multiflat')[0];
				$main_category_id = $this->model_catalog_product->getMainCategory($this->request->get['product_id']);
				$result_price = (float)$product['special']?(float)$product['special']:(float)$product['price'];
				
				$delivery_price = 'NOPE';
				if ($result_price && $multiflat['free_from'] && (int)$multiflat['category_id']){			
				if ($result_price >= $multiflat['free_from'] && $main_category_id['category_id'] != (int)$multiflat['category_id']){
				$delivery_price = 0;
				} elseif ($main_category_id['category_id'] == (int)$multiflat['category_id']){
				$delivery_price = $multiflat['category_cost'];
				}
				}
				
				if ($delivery_price !== 'NOPE'){
				$output .= '	<g:shipping>' . PHP_EOL;						
				$output .= '		<g:country>UA</g:country>' . PHP_EOL;
				$output .= '		<g:service>' . $delivery . '</g:service>' . PHP_EOL;
				$output .= '		<g:price> ' . $this->currency->format($this->tax->calculate($delivery_price, $product['tax_class_id']), $currency_code, $currency_value, false) . ' '. $currency_code . '</g:price>' . PHP_EOL;					
				$output .= '	</g:shipping>' . PHP_EOL;
				}
				
			*/		
			if ($google_base_category['google_base_category_id']){
				$output .= '  <g:google_product_category>' . $google_base_category['google_base_category_id'] . '</g:google_product_category>' . PHP_EOL;
				} else {
				$output .= '  <g:google_product_category>' . $this->default_google_base_category . '</g:google_product_category>' . PHP_EOL;
			}
			
			$categories = $this->model_catalog_product->getCategoriesExceptListing($product['product_id']);
			
			foreach ($categories as $category) {
				$path = $this->getPath($category['category_id']);
				
				if ($path) {
					$string = '';
					
					foreach (explode('_', $path) as $path_id) {
						$category_info = $this->model_catalog_category->getCategory($path_id);
						
						if ($category_info) {
							if (!$string) {
								$string = $category_info['name'];
								} else {
								$string .= ' &gt; ' . $category_info['name'];
							}
						}
					}
					
					$output .= '<g:product_type><![CDATA[' . $string . ']]></g:product_type>' . PHP_EOL;
				}
			}
			
			
			if ($zeroPathCollection = $this->model_catalog_product->getProductCollectionLevelZero($product['product_id'])){			
				$output .= '  <g:custom_label_0><![CDATA[' . $zeroPathCollection['name'] . ']]></g:custom_label_0>' . PHP_EOL;	
			}
			
			$custom_label_1 = '';
			$steps = array(0,100,200,300,500,1000,1500,2000,2500,3000,5000,1000000);
			
			for ($i = 0; $i<=(count($steps)-2); $i++){
				if ($product['price'] > $steps[$i] && $product['price'] <= $steps[$i+1]){
					$output .= '  <g:custom_label_1><![CDATA[' . 'price_' . $steps[$i] . '_' . $steps[$i+1] . ']]></g:custom_label_1>' . PHP_EOL;	
				}			
			}
			
			
			
			$output .= '  <g:quantity>' . $product['quantity'] . '</g:quantity>' . PHP_EOL;
			$output .= '  <g:weight>' . $this->weight->format($product['weight'], $product['weight_class_id']) . '</g:weight>' . PHP_EOL;
			$output .= '  <g:availability><![CDATA[' . ($product['quantity'] ? 'in stock' : 'out of stock') . ']]></g:availability>' . PHP_EOL;
			$output .= '</item>';
			
			return $output;			
		}
		
		protected function printGoogleBaseCategory($google_base_category, $filter_sub_category = false){						
			
			$output = '';
			
			$filter_data = array(
			'filter_category_id'  => $google_base_category['category_id'],
			'filter_sub_category' => false,
			'filter_notnull_price'=> true,
			'filter_filter'       => false
			);
			
			if ($filter_sub_category){
				$filter_data['filter_sub_category'] = true;
			}
			
			$products = $this->model_catalog_product->getProducts($filter_data);	
			$this->echoLine('[GMC] Товаров: ' . count($products));
			
			$counter = 0;
			foreach ($products as $product) {
				
				if ($counter % 50 == 0){
					$this->echoSimple($counter . '...');	
				}
				$counter++;
				
				$output .= $this->printItem($product, $google_base_category);					
			}
			$this->echoLine('');
			$this->echoLine('');
			
			unset($products);
			unset($product);
			
			return $output;
		}

		public function localstock(){

			if (!defined('OPENCART_CLI_MODE')){
				die('CLI ONLY');
			}			

			error_reporting(E_ALL);		
			ini_set('display_errors', 'On');
			ini_set('memory_limit', '1024M');

			$this->echoLine('[GMCS TIME] Начали в ' . date('H:i:s'));
			
			$this->load->model('catalog/product');

			$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = 0 WHERE quantity < 0 ");
			$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = 0 WHERE quantity < 0 ");
			$this->db->query("UPDATE " . DB_PREFIX . "stocks SET quantity = 0 WHERE quantity < 0 ");
			
			$this->load->model('localisation/language');
			$languages = $this->model_localisation_language->getLanguages();
			
			foreach ($languages as $language){							
				
				$this->config->set('config_language_id', $language['language_id']);
				$this->config->set('config_language', $language['code']);
				$this->config->set('config_language_code_explicit', $language['code']);										
				
				$this->echoLine('[GMCS] Язык ' . $language['code']);
				
				$currency_code = $this->config->get('config_currency');			
				$currency_value = $this->currency->getValue($currency_code);

				$products = $this->model_catalog_product->getLocalStockFeedProducts();	
				
				$file = DIR_FEEDS . 'google-merchant-localstock-feed-' . $language['code'] . '.xml';
				
				$output  = '<?xml version="1.0" encoding="UTF-8" ?>' . PHP_EOL;
				$output .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">' . PHP_EOL;
				$output .= '<channel>' . PHP_EOL;
				$output .= '<title><![CDATA[' . $this->config->get('config_name') . ']]></title>' . PHP_EOL;
				$output .= '<description><![CDATA[' . $this->config->get('config_meta_description') . ']]></description>' . PHP_EOL;
				$output .= '<link><![CDATA[' . $this->config->get('config_url') . ']]></link>' . PHP_EOL;

				foreach ($products as $product){
					$output .= '<item>' . PHP_EOL;	
					
					$productID = $product['product_id'];
					if ($this->config->get('config_language_id') != $this->default_language_id){
						$productID .= '-' . $this->config->get('config_language_id');
					}
					
					$output .= '<g:id>' . $productID . '</g:id>' . PHP_EOL;
					$output .= '<g:quantity><![CDATA[' . $product['quantity'] . ']]></g:quantity>' . PHP_EOL;
					$output .= '<g:store_code><![CDATA[drugstore' . $product['location_id'] . ']]></g:store_code>' . PHP_EOL;
					$output .= '<g:pickup_method><![CDATA[reserve]]></g:pickup_method>' . PHP_EOL;
					$output .= '<g:pickup_sla><![CDATA[same day]]></g:pickup_sla>' . PHP_EOL;

					$output .= '<g:availability><![CDATA[' . ($product['quantity'] ? 'in stock' : 'out of stock') . ']]></g:availability>' . PHP_EOL;
					$output .= '<g:price><![CDATA[' . $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id']), $currency_code, $currency_value, false) . ' ' . $currency_code . ']]></g:price>' . PHP_EOL;					
					if ((float)$product['special']) {
						$output .= '<g:sale_price_effective_date></g:sale_price_effective_date>' . PHP_EOL;
						$output .= '<g:sale_price><![CDATA[' .  $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id']), $currency_code, $currency_value, false) . ' ' . $currency_code . ']]></g:sale_price>' . PHP_EOL;
					}
					$output .= '</item>' . PHP_EOL;	
					
				}

				$output .= '</channel>'. PHP_EOL;
				$output .= '</rss>'. PHP_EOL;
				
				$handle = fopen($file, 'w+');
				flock($handle, LOCK_EX);
				fwrite($handle, $output);
				flock($handle, LOCK_UN);
				fclose($handle);
				
				unset($output);
				gc_collect_cycles();
				
				$this->echoLine('[GMCS TIME] Закончили в ' . date('H:i:s'));
			}


		}
		
		
		public function supplemental(){
			
			if (!defined('OPENCART_CLI_MODE')){
				die('CLI ONLY');
			}
			
		//	$this->cache->flush();
			
			error_reporting(E_ALL);		
			ini_set('display_errors', 'On');
			ini_set('memory_limit', '1024M');
			
			$this->echoLine('[GMCS TIME] Начали в ' . date('H:i:s'));
			
			$this->load->model('catalog/product');
			
			$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = 0 WHERE quantity < 0 ");
			$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = 0 WHERE quantity < 0 ");
			
			$this->load->model('localisation/language');
			$languages = $this->model_localisation_language->getLanguages();
			
			foreach ($languages as $language){							
				
				$this->config->set('config_language_id', $language['language_id']);
				$this->config->set('config_language', $language['code']);
				$this->config->set('config_language_code_explicit', $language['code']);										
				
				$this->echoLine('[GMCS] Язык ' . $language['code']);
				
				$currency_code = $this->config->get('config_currency');			
				$currency_value = $this->currency->getValue($currency_code);
				
				$products = $this->model_catalog_product->getSupplementalFeedProducts();	
				
				$file = DIR_FEEDS . 'google-merchant-supplemental-feed-' . $language['code'] . '.xml';
				
				$output  = '<?xml version="1.0" encoding="UTF-8" ?>' . PHP_EOL;
				$output .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">' . PHP_EOL;
				$output .= '<channel>' . PHP_EOL;
				$output .= '<title><![CDATA[' . $this->config->get('config_name') . ']]></title>' . PHP_EOL;
				$output .= '<description><![CDATA[' . $this->config->get('config_meta_description') . ']]></description>' . PHP_EOL;
				$output .= '<link><![CDATA[' . $this->config->get('config_url') . ']]></link>' . PHP_EOL;
				
				foreach ($products as $product){
					$output .= '<item>' . PHP_EOL;	
					
					$productID = $product['product_id'];
					if ($this->config->get('config_language_id') != $this->default_language_id){
						$productID .= '-' . $this->config->get('config_language_id');
					}
					
					$output .= '<g:id>' . $productID . '</g:id>' . PHP_EOL;					
					$output .= '<g:quantity><![CDATA[' . $product['quantity'] . ']]></g:quantity>' . PHP_EOL;
					$output .= '<g:availability><![CDATA[' . ($product['quantity'] ? 'in stock' : 'out of stock') . ']]></g:availability>' . PHP_EOL;
					$output .= '<g:price><![CDATA[' . $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id']), $currency_code, $currency_value, false) . ' ' . $currency_code . ']]></g:price>' . PHP_EOL;					
					if ((float)$product['special']) {
						$output .= '<g:sale_price_effective_date></g:sale_price_effective_date>' . PHP_EOL;
						$output .= '<g:sale_price><![CDATA[' .  $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id']), $currency_code, $currency_value, false) . ' ' . $currency_code . ']]></g:sale_price>' . PHP_EOL;
					}
					$output .= '</item>' . PHP_EOL;	
				}
				
				$output .= '</channel>'. PHP_EOL;
				$output .= '</rss>'. PHP_EOL;
				
				$handle = fopen($file, 'w+');
				flock($handle, LOCK_EX);
				fwrite($handle, $output);
				flock($handle, LOCK_UN);
				fclose($handle);
				
				unset($output);
				gc_collect_cycles();
				
				$this->echoLine('[GMCS TIME] Закончили в ' . date('H:i:s'));			
				
			}
			
			//	header('Content-Type: application/xml');
			//	echo($output);
			
		}
		
		public function cron() {	
			if (!defined('OPENCART_CLI_MODE')){
				die('CLI ONLY');
			}
			
			$this->barcodeValidator = new \Ced\Validator\Barcode();
			
			//$this->cache->flush();
			
			error_reporting(E_ALL);		
			ini_set('display_errors', 'On');
			ini_set('memory_limit', '1024M');
			
			$this->echoLine('[GMC TIME] Начали в ' . date('H:i:s'));
			
			if ($this->config->get('google_base_status')) {
				$this->load->model('extension/feed/google_base');
				$this->load->model('catalog/category');
				$this->load->model('catalog/product');
				$this->load->model('tool/image');
				
				$this->load->model('localisation/language');
				$languages = $this->model_localisation_language->getLanguages();
				
				foreach ($languages as $language){	
					
					$this->config->set('config_language_id', $language['language_id']);
					$this->config->set('config_language', $language['code']);
					$this->config->set('config_language_code_explicit', $language['code']);										
					
					$this->echoLine('[GMC] Язык ' . $language['code']);
					
					
					$output  = '<?xml version="1.0" encoding="UTF-8" ?>' . PHP_EOL;
					$output .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">' . PHP_EOL;
					$output .= '  <channel>' . PHP_EOL;
					$output .= '  <title>' . $this->config->get('config_name') . '</title>' . PHP_EOL;
					$output .= '  <description>' . $this->config->get('config_meta_description') . '</description>' . PHP_EOL;
					$output .= '  <link>' . $this->config->get('config_url') . '</link>' . PHP_EOL;							
					
					$file = DIR_FEEDS . 'google-merchant-feed-' . $language['code'] . '.xml';
					
					$this->echoLine('Файл ' . $file);		
					
					$google_base_categories = $this->model_extension_feed_google_base->getCategories();						
					
					foreach ($google_base_categories as $google_base_category) {
						
						$this->echoLine('[GMC] Начали категорию ' . $google_base_category['category_id']);
						
						$output .= $this->printGoogleBaseCategory($google_base_category);										
						
						gc_collect_cycles();
						$this->echoLine('[GMC mem] Занято памяти ' . $this->memoryUnits(memory_get_usage(true)));
					}
					
					$output .= '  </channel>' . PHP_EOL;
					$output .= '</rss>' . PHP_EOL;
					
					$handle = fopen($file, 'w+');
					flock($handle, LOCK_EX);
					fwrite($handle, $output);
					flock($handle, LOCK_UN);
					fclose($handle);
					
					unset($output);
					unset($google_base_category);
					gc_collect_cycles();									
					
				/*
					$file = DIR_FEEDS . 'google-merchant-feed-full-' . $language['code'] . '.xml';
					$this->echoLine('Файл ' . $file);	
					
					$output  = '<?xml version="1.0" encoding="UTF-8" ?>' . PHP_EOL;
					$output .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">' . PHP_EOL;
					$output .= '  <channel>' . PHP_EOL;
					$output .= '  <title>' . $this->config->get('config_name') . '</title>' . PHP_EOL;
					$output .= '  <description>' . $this->config->get('config_meta_description') . '</description>' . PHP_EOL;
					$output .= '  <link>' . $this->config->get('config_url') . '</link>' . PHP_EOL;
					
					$google_base_categories = $this->model_catalog_category->getCategories(0);								
					foreach ($google_base_categories as $google_base_category) {
						if (!in_array($google_base_category['category_id'], $this->exclude_categories)){
							
							$this->echoLine('[GMC] Начали категорию ' . $google_base_category['category_id']);
							
							$output .= $this->printGoogleBaseCategory($google_base_category, true);										
							
							gc_collect_cycles();
							$this->echoLine('[GMC mem] Занято памяти ' . $this->memoryUnits(memory_get_usage(true)));
						}
					}
					
					$output .= '  </channel>' . PHP_EOL;
					$output .= '</rss>' . PHP_EOL;
					
					$handle = fopen($file, 'w+');
					flock($handle, LOCK_EX);
					fwrite($handle, $output);
					flock($handle, LOCK_UN);
					fclose($handle);
				*/
					
					unset($output);
					unset($google_base_category);
					unset($google_base_categories);
					gc_collect_cycles();
					
					$this->echoLine('[GMC TIME] Закончили в ' . date('H:i:s'));					
					
				}
				
			}
		}	
	}																				