<?php
	class ControllerExtensionModuleAlsoViewed extends Controller {
		public function index($setting) {
			$this->load->model('module/alsoviewed');
			$this->load->language('module/alsoviewed');
					
			$data['heading_title'] = $this->language->get('heading_title');
			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['text_tax'] = $this->language->get('text_tax');
			
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$data['data']['alsoviewed'] = str_replace('http', 'https', $this->config->get('alsoviewed'));
				} else {
				$data['data']['alsoviewed'] = $this->config->get('alsoviewed');
			}
			
			$data['data']['alsoviewed'] = $this->config->get('alsoviewed_module');
			
			$moduleSetting = $this->model_module_alsoviewed->getSetting('alsoviewed', $this->config->get('config_store_id'));
			$data['moduleData'] = isset($moduleSetting['alsoviewed']) ? $moduleSetting['alsoviewed'] : array ();
			
			if(!isset($data['moduleData']['PanelName'][$this->config->get('config_language')])){
				$data['PanelName'] = $data['heading_title'];
				} else {
				$data['PanelName'] = $data['moduleData']['PanelName'][$this->config->get('config_language')];
			}
			
			
			if (isset($this->request->get['product_id'])) {
				$alsoViewedProducts = $this->listalsoViewedById((int)$this->request->get['product_id'],(int)$data['moduleData']['NumberOfProducts']);
				} else {
				$alsoViewedProducts = array();
			}
			
			
			$this->load->model('tool/image');
			
			/***theme's changes***/
			$data['store_id'] = $this->config->get('config_store_id');
			$store_id = $this->config->get('config_store_id');
			$data['lang'] = $this->config->get('config_language_id');
			$lang = $this->config->get('config_language_id');
			$data['theme'] = $this->config->get('theme_default_directory');
			$data['registry'] = $this->registry;
			$data['our_url'] = $this->registry->get('url');
			$this->load->model('soconfig/general');
			
			/* PAGE PRODUCT */
			$text_config = array(
			'product_catalog_mode',
			'other_catalog_column_lg',
			'other_catalog_column_md',
			'other_catalog_column_sm',
			'other_catalog_column_xs',
			'secondimg',
			'rating_status',
			'lstdescription_status',
			'sale_status',
			'new_status',
			'days',
			'quick_status',
			'discount_status',
			'countdown_status',
			'sale_text',
			'new_text',
			'quick_view_text',
			'scroll_animation',
			);
			
			foreach ($text_config as $text ) {
				$data[$text] = '';//$this->soconfig->get_settings($text);
			}
			
			//Language Variables
			$this->load->language('extension/soconfig/soconfig');
			$data['lang_todaysdeal'] = $this->language->get('lang_todaysdeal');
			$data["view_details"]  	= $this->language->get('view_details');
			$data['countdown_title_day'] 	= $this->language->get('countdown_title_day');
			$data['countdown_title_hour'] 	= $this->language->get('countdown_title_hour');
			$data['countdown_title_minute'] = $this->language->get('countdown_title_minute');
			$data['countdown_title_second'] = $this->language->get('countdown_title_second');
			/***end theme's changes***/
			
			$data['products'] = array();
			foreach($alsoViewedProducts as $product_info){
				if ($product_info) {
					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], $data['moduleData']['PictureWidth'], $data['moduleData']['PictureHeight']);
						} else {
						$image = $this->model_tool_image->resize('placeholder.png', $data['moduleData']['PictureWidth'], $data['moduleData']['PictureHeight']);
					}
					
					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						} else {
						$price = false;
					}
					
					if ((float)$product_info['special']) {
						$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						} else {
						$special = false;
					}
					
					if ((float)$product_info['special']) {
						$discount = '-'.round((($product_info['price'] - $product_info['special'])/$product_info['price'])*100, 0).'%';
						} else {
						$discount = false;
					}
					
					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
						} else {
						$tax = false;
					}
					
					if ($this->config->get('config_review_status')) {
						$rating = $product_info['rating'];
						} else {
						$rating = false;
					}
					
					$data['products'][] = array(
					'product_id'  => $product_info['product_id'],
					'thumb'       => $image,
					'name'        => $product_info['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'special_end_date'  => $this->model_soconfig_general->getDateEnd($product_info['product_id']),
					'date_available'  => $product_info['date_available'],
					'discount'  => $discount,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
					);
				}
			}
			
			if ($data['products']) {
				return $this->load->view('extension/module/alsoviewed', $data);
			}
		}
		
		public function getindex() {
			$this->response->setOutput($this->index());
		}
		
		public function getCatalogURL($store_id){
			if(isset($store_id) && $store_id){
				$storeURL = $this->db->query('SELECT url FROM `'.DB_PREFIX.'store` WHERE store_id=' . $store_id)->row['url'];
				}elseif (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
				$storeURL = HTTPS_SERVER;
				} else {
				$storeURL = HTTP_SERVER;
			} 
			return $storeURL;
		}
		
		private function listalsoViewedById($product_id, $limit=5) {
			$this->load->model('catalog/product');
			$data = $this->db->query("SELECT * FROM `" . DB_PREFIX . "alsoviewed` WHERE `low` = $product_id OR `high` = $product_id ORDER BY `number` DESC LIMIT $limit");
			
			$rows = $data->rows;
			$products = array();
			
			foreach ($rows as $row) {
				if ($row['low'] == $product_id) {
					$pid = $row['high'];
					} else {
					$pid = $row['low'];
				}
				$products[$pid] = $this->model_catalog_product->getProduct($pid);
			}
			return $products;
		}
		
	}
?>