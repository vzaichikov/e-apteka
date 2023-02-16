<?php
	class ControllerProductProduct extends Controller {
		private $error = array();		

		public function stocks(){
			$this->load->model('catalog/product');		
			$this->load->model('localisation/location');

			$this->load->language('product/product');

			if (isset($this->request->get['x'])) {
				$product_id = (int)$this->request->get['x'];
			} else {
				$product_id = 0;
			}

			$results = $this->model_catalog_product->getProductStocks($product_id);


			$multilang_fields = array(
				'open',
				'address',
				'name',
				'comment'		
			);

			foreach ($results as $result) {

				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], 100, 100);
				} else {
					$image = false;
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				$open = '';
				$mcolor = 'red';
				$is_open_now = false;
					//parse open time struct
				if ($result['open_struct']){
					date_default_timezone_set('Europe/Kiev');

					$_r = trim($result['open_struct']);

					if ($_r == '∞'){
						$open = $this->language->get('text_open_alltime');
						$open_text = $this->language->get('text_open_alltime');
						$is_open_now = true;
					} else {
						$a = explode(PHP_EOL, $result['open_struct']);													
						$d = array();
						foreach ($a as $k => &$v){
							$v = trim($v);
							$c = explode('/', $v);
							$z = explode('-', $c[1]);
							$d[$c[0]] = array(
								's' => $z[0],
								'f' => $z[1]								
							);
						}

						$day = date('N');
						$nday = date('N', strtotime('+1 day'));

						if (!isset($d[$day])){
							$open .= $this->language->get('text_closed_today');
							$open_text .= $this->language->get('text_closed_today');
							$is_open_now = false;
						} else {

							$date_now = DateTime::createFromFormat('H:i', date('H:i'));
							$date_open = DateTime::createFromFormat('H:i', $d[$day]['s']);					
							$date_close = DateTime::createFromFormat('H:i', $d[$day]['f']);

							if ($date_now > $date_open && $date_now < $date_close){
								$is_open_now = true;
								$to_close_h = date_diff($date_now, $date_close)->format('%h');
								$to_close_m = date_diff($date_now, $date_close)->format('%i');
								$open_text = sprintf($this->language->get('text_opened_now'), $to_close_h, $to_close_m);
								$open = sprintf($this->language->get('text_opened_now'), $to_close_h, $to_close_m);
							}

							if ($date_now > $date_close || $date_now < $date_open){
								$is_open_now = false;
								$to_close = date_diff($date_now, $date_open)->format('%h');
								$open_text = $this->language->get('text_closed_now');
								$open = $this->language->get('text_closed_now');
							}
						}

					}									
				}

				if ($is_open_now){
					$faclass = 'text-success';
				} else {
					$faclass = 'text-danger1';
				}

				if ($is_open_now && $result['quantity'] && $price){
					$mcolor = 'green';
					$tdclass = 'bg-success';
				}

				if (!$is_open_now || !$result['quantity'] || !$price){
					$mcolor = 'red';
					$tdclass = 'bg-danger';					
				}

				if (!$is_open_now && $result['quantity'] && $price){
					$mcolor = 'yellow';
					$tdclass = 'bg-warning';
				}

				/*	foreach ($multilang_fields as $_field){
						if ($_mlvalue = $this->model_localisation_location->getLocationML($result['location_id'], $_field)){
							${$_field} = $_mlvalue;
							} else {
							${$_field} = $result[$_field];
						}
					}	
				*/
					$data['text_we_work_while_no_light'] = $this->language->get('text_we_work_while_no_light');
					
					$data['stocks'][] = array(
						'name'			=> $result['name'],
						'address'		=> $result['address'],
						'location_id'	=> $result['location_id'],
						'image' 		=> $image,
						'stock' 		=> $result['quantity'],
						'geocode' 		=> $result['geocode'],
						'gmaps_link' 	=> $result['gmaps_link'],
						'open_text' 	=> $open_text,
						'open'			=> $result['open'],
						'tdclass' 		=> $tdclass,
						'faclass' 		=> $faclass,
						'icon' 	    	=> HTTPS_SERVER . 'image/gmarkers/source/marker_' . $mcolor . '.png',
						'price' 		=> ($result['quantity'] && $price)?$price:$this->language->get('text_preorder'),					
					);									
				}		

				$tmp_stocks = [];
				foreach ($data['stocks'] as $stock){
					if ($stock['stock'] > 0){
						array_unshift($tmp_stocks, $stock);
					} else {
						array_push($tmp_stocks, $stock);
					}
				}

			//	$data['stocks'] = $tmp_stocks;

				$data['text_is_in_stock_in_drugstores'] = $this->language->get('text_is_in_stock_in_drugstores');
				$data['text_make_route'] = $this->language->get('text_make_route');
				$data['text_make_reserve'] = $this->language->get('text_make_reserve');

				$this->response->setOutput($this->load->view('product/structured/stocks', $data));		

			}

		public function instruction() {
			$this->load->language('product/product');
			$this->load->model('catalog/product');		
			
			if (isset($this->request->get['product_id'])) {
				$product_id = (int)$this->request->get['product_id'];
				} else {
				$product_id = 0;
			}
			
			$ajaxrequest = (!empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
			
			if (!$ajaxrequest){
				$this->response->redirect($this->url->link('product/product', 'product_id=' . $product_id), 301);	
			}							

			$data['instruction'] = html_entity_decode($this->model_catalog_product->getProductInstruction($product_id), ENT_QUOTES, 'UTF-8');
			
			$this->response->setOutput($this->load->view('product/structured/instruction', $data));			
		}	

		public function likreestr() {
			$this->load->language('product/product');
			$this->load->model('catalog/product');		
			
			if (isset($this->request->get['product_id'])) {
				$product_id = (int)$this->request->get['product_id'];
				} else {
				$product_id = 0;
			}
			
			$ajaxrequest = (!empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
			
			if (!$ajaxrequest){
				$this->response->redirect($this->url->link('product/product', 'product_id=' . $product_id), 301);	
			}							

			$likreestr = $this->model_catalog_product->getProductLikReestr($product_id);
			$data['likreestr'] = json_decode($likreestr)?json_decode($likreestr, true):false;
			
			$this->response->setOutput($this->load->view('product/structured/likreestr', $data));			
		}	

		public function delivery_pay(){
			$this->load->language('product/delivery_pay');
			$this->load->model('catalog/product');

			if (isset($this->request->get['product_id'])) {
				$product_id = (int)$this->request->get['product_id'];
				} else {
				$product_id = 0;
			}
			
			$ajaxrequest = (!empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

			if (!$ajaxrequest){
			//	$this->response->redirect($this->url->link('product/product', 'product_id=' . $product_id), 301);	
			}

			$results = $this->model_catalog_product->getProductStocks($product_id);

			if ($results){

			}

			$this->response->setOutput($this->load->view('product/structured/delivery_pay', $data));
		}
		
		public function getEcommerceInfo(){
			$json = array();
			
			if (isset($this->request->get['product_id'])) {
                $product_id = (int)$this->request->get['product_id'];
				} else {
                $product_id = 0;
			}
			
			$this->load->model('catalog/product');
            $product_info = $this->model_catalog_product->getProduct($product_id);
						
			if ($product_info) {											
				$json['currency'] 	= $this->session->data['currency'];
				$json['id'] 		= $product_info['ecommerceData']['id'];
				$json['name'] 		= $product_info['ecommerceData']['name'];				
				$json['price'] 		= $product_info['ecommerceData']['price'];
				$json['gtin'] 		= $product_info['ecommerceData']['gtin'];
				$json['brand'] 		= $product_info['ecommerceData']['brand'];				
				$json['category']   = $product_info['ecommerceData']['category'];
				
				$json = array_map('prepareEcommString', $json);				
			}			
			
			$this->response->setOutput(json_encode($json));
		}
				
		public function index($tab = false) {
			$devMode = $data['devMode'] = ($this->customer->getEmail() == 'dev@e-apteka.com.ua');
			
			$this->load->language('product/product');
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrumb_home'),
			'href' => $this->url->link('common/home')
			);
			
			$this->load->model('catalog/category');
			
			if (isset($this->request->get['path'])) {
				$path = '';
				
				$parts = explode('_', (string)$this->request->get['path']);
				
				$category_id = (int)array_pop($parts);
				
				foreach ($parts as $path_id) {
					if (!$path) {
						$path = $path_id;
						} else {
						$path .= '_' . $path_id;
					}
					
					$category_info = $this->model_catalog_category->getCategory($path_id);
					
					if ($category_info) {
						$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'path=' . $path)
						);
					}
				}
				
				// Set the last category breadcrumb
				$category_info = $this->model_catalog_category->getCategory($category_id);
				
				if ($category_info) {
					$url = '';
					
					if (isset($this->request->get['sort'])) {
						$url .= '&sort=' . $this->request->get['sort'];
					}
					
					if (isset($this->request->get['order'])) {
						$url .= '&order=' . $this->request->get['order'];
					}
					
					if (isset($this->request->get['page'])) {
						$url .= '&page=' . $this->request->get['page'];
					}
					
					if (isset($this->request->get['limit'])) {
						$url .= '&limit=' . $this->request->get['limit'];
					}
					
					$data['breadcrumbs'][] = array(
					'text' => $category_info['name'],
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url)
					);
				}
			}
			
			$this->load->model('catalog/manufacturer');
			
			if (isset($this->request->get['manufacturer_id'])) {
				$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_brand'),
				'href' => $this->url->link('product/manufacturer')
				);
				
				$url = '';
				
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}
				
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
				
				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}
				
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
				
				$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);
				
				if ($manufacturer_info) {
					$data['breadcrumbs'][] = array(
					'text' => $manufacturer_info['name'],
					'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url)
					);
				}
			}
			
			if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
				$url = '';
				
				if (isset($this->request->get['search'])) {
					$url .= '&search=' . $this->request->get['search'];
				}
				
				if (isset($this->request->get['tag'])) {
					$url .= '&tag=' . $this->request->get['tag'];
				}
				
				if (isset($this->request->get['description'])) {
					$url .= '&description=' . $this->request->get['description'];
				}
				
				if (isset($this->request->get['category_id'])) {
					$url .= '&category_id=' . $this->request->get['category_id'];
				}
				
				if (isset($this->request->get['sub_category'])) {
					$url .= '&sub_category=' . $this->request->get['sub_category'];
				}
				
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}
				
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
				
				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}
				
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
				
				/*	$data['breadcrumbs'][] = array(
					'text' => $this->language->get('text_search'),
					'href' => $this->url->link('product/search', $url)
					);
				*/
			}
			
			if (isset($this->request->get['product_id'])) {
				$product_id = (int)$this->request->get['product_id'];
				} else {
				$product_id = 0;
			}
			// die('+++'.$product_id); 
			$this->load->model('catalog/product');
			
			$product_info_tmp = $this->model_catalog_product->getProduct($product_id);
			$product_info = $product_info_tmp;
			$product_info['previous'] = $product_info_tmp;
			$product_info['next'] = $product_info_tmp;
			
			if(isset($product_info_tmp['special_date_end']) AND $product_info_tmp['special_date_end']){
				$data['special_date_end'] = $product_info_tmp['special_date_end'];
			}
			
			if ($product_info && !empty($product_info['product_id'])) {
				
				if (isset($this->request->get['search']) && $this->config->get('config_customer_search')) {
                    $this->load->model('account/search');                                       
                    
                    $search_data = array(
                    'keyword'       => $this->request->get['search'],                    
                    'entity_type'   => 'p',
					'entity_id'   	=> $product_info['product_id'],
                    );
                    
                    $this->model_account_search->addSearchIDX($search_data);
				}
				
				
				$this->load->model('catalog/review');
				$data['seo'] = $product_info['seo'];
				$data['reviews'] = $this->model_catalog_review->getReviewsByProductId($product_id, 0, 100);
				if(isset($data['reviews']) AND count($data['reviews'])){ 
					
					$text = '"review": [';
					foreach($data['reviews'] AS $row){
						if($row['author'] == "" || ctype_space($row['author'])){
							$row['author'] = 'Провизор';
						}
						$text .= '{
							"@type": "Review",
							"author": {
								"@type": "Person",
								"name": "' . $row['author'] . '"
								},
								"datePublished": "' . $row['date_added'] . '",
								"description": "' . removequotes($row['text']) . '",
								"name": "' . removequotes($product_info['name']) . '",
								"reviewRating": {
									"@type": "Rating",
									"bestRating": "5",
									"ratingValue": "'.$row['rating'].'",
									"worstRating": "1"
								}
							},';
						}
						$text = trim($text, ',');
						$text .= "],";
						
						$data['seo'] = str_replace('"offers"',$text."\n".'"offers"', $data['seo']);
					}
				


				$this->load->model('extension/module/recently_viewed');

				if ($this->customer->isLogged()){
					$this->model_extension_module_recently_viewed->setRecentlyViewedProducts($this->customer->getId(), $product_info['product_id']);
				}
				
				if($this->model_extension_module_recently_viewed->isEnabled()){
					if(!empty($this->request->cookie['recently_viewed'])) {
						$recently_viewed = json_decode(base64_decode($this->request->cookie['recently_viewed']), true);
						$recently_viewed[$product_info['product_id']] = date("Y-m-d");	

						uasort($recently_viewed, function($a, $b){ return strtotime($a) > strtotime($b); });					

						if (count($recently_viewed) > 21){
							$recently_viewed = array_slice($recently_viewed, -20, null, true);
						}

					} else {

						$recently_viewed[$product_info['product_id']] = date("Y-m-d");
					}

					$recently_viewed = base64_encode(json_encode($recently_viewed));
					setcookie('recently_viewed', $recently_viewed, 0, '/', $this->request->server['HTTP_HOST']);
					
				}
				
				//Акции				
				$this->load->model('catalog/ochelp_special');
				$data['current_action'] = $this->model_catalog_ochelp_special->getActiveSpecialByProduct($product_info['product_id']);
				
				if ($data['current_action']){
					$data['current_action']['href'] = $this->url->link('information/ochelp_special', 'special_id=' . $data['current_action']['special_id']);
					$data['current_action']['date_end'] = dateDiff(date('Y-m-d', strtotime($data['current_action']['date_end'])));						
					$data['text_action'] = $this->language->get('text_action');
					$data['button_show_more'] = $this->language->get('button_show_more');
					$data['text_special'] = sprintf($this->language->get('text_action_left'), $data['current_action']['date_end']);
				}
				
				
				$url = '';
				
				if (isset($this->request->get['path'])) {
					$url .= '&path=' . $this->request->get['path'];
				}
				
				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}
				
				if (isset($this->request->get['manufacturer_id'])) {
					$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
				}
				
				if (isset($this->request->get['search'])) {
					$url .= '&search=' . $this->request->get['search'];
				}
				
				if (isset($this->request->get['tag'])) {
					$url .= '&tag=' . $this->request->get['tag'];
				}
				
				if (isset($this->request->get['description'])) {
					$url .= '&description=' . $this->request->get['description'];
				}
				
				if (isset($this->request->get['category_id'])) {
					$url .= '&category_id=' . $this->request->get['category_id'];
				}
				
				if (isset($this->request->get['sub_category'])) {
					$url .= '&sub_category=' . $this->request->get['sub_category'];
				}
				
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}
				
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
				
				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}
				
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
				/*	
					$data['breadcrumbs'][] = array(
					'text' => $product_info['name'],
					'href' => $this->url->link('product/product', $url . '&product_id=' . $this->request->get['product_id'])
					);
				*/	
				$this->document->setTitle($product_info['meta_title']);
				$this->document->setDescription($product_info['meta_description']);
				$this->document->setKeywords($product_info['meta_keyword']);
				$this->document->addLink($this->url->link('product/product', 'product_id=' . $this->request->get['product_id']), 'canonical');
				
				
				$this->document->addLink($this->url->link('product/amp_product', 'product_id=' . $this->request->get['product_id']), 'amphtml');
				if (isset($this->request->get['add'])) {
					$this->cart->add($this->request->get['product_id']);
					$this->response->redirect($this->url->link('checkout/cart'));
				}
				
				$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
				$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
				/*	$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
					$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
					$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
				*/
				
				$data['heading_title'] = $product_info['name'];
				
				$data['text_select'] = $this->language->get('text_select');
				$data['text_manufacturer'] = $this->language->get('text_manufacturer');
				$data['text_model'] = $this->language->get('text_model');
				$data['text_reward'] = $this->language->get('text_reward');
				$data['text_points'] = $this->language->get('text_points');
				$data['text_stock'] = $this->language->get('text_stock');
				$data['text_discount'] = $this->language->get('text_discount');
				$data['text_tax'] = $this->language->get('text_tax');
				$data['text_option'] = $this->language->get('text_option');
				$data['text_minimum'] = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
				$data['text_write'] = $this->language->get('text_write');
				$data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));
				$data['text_note'] = $this->language->get('text_note');
				$data['text_tags'] = $this->language->get('text_tags');
				$data['text_related'] = $this->language->get('text_related');
				$data['text_payment_recurring'] = $this->language->get('text_payment_recurring');
				$data['text_loading'] = $this->language->get('text_loading');
				$data['text_wherebuy'] = $this->language->get('text_wherebuy');
				$data['text_not_in_stock'] = $this->language->get('text_not_in_stock');
				$data['text_is_in_stock_in_drugstores'] = $this->language->get('text_is_in_stock_in_drugstores');
				
				$data['text_yourprice'] = $this->language->get('text_yourprice');
				$data['text_genprice'] = $this->language->get('text_genprice');
				$data['text_picture_may_differ'] = $this->language->get('text_picture_may_differ');
				
				$data['entry_qty'] = $this->language->get('entry_qty');
				$data['entry_name'] = $this->language->get('entry_name');
				$data['entry_review'] = $this->language->get('entry_review');
				$data['entry_email'] = $this->language->get('entry_email');
				$data['entry_rating'] = $this->language->get('entry_rating');
				$data['entry_good'] = $this->language->get('entry_good');
				$data['entry_bad'] = $this->language->get('entry_bad');
				
				$data['button_cart'] = $this->language->get('button_cart');
				$data['button_wishlist'] = $this->language->get('button_wishlist');
				$data['button_compare'] = $this->language->get('button_compare');
				$data['button_upload'] = $this->language->get('button_upload');
				$data['button_continue'] = $this->language->get('button_continue');
				
				$this->load->model('catalog/review');
				
				$data['text_delivery_pay'] = $this->language->get('text_delivery_pay');
				$data['text_avaliable_in_drugstores'] = $this->language->get('text_avaliable_in_drugstores');
				$data['text_all_about_product'] = $this->language->get('text_all_about_product');
				
				$data['tab_description'] = $this->language->get('tab_description');
				$data['tab_instruction'] = $this->language->get('tab_instruction');
				$data['tab_likreestr'] = $this->language->get('tab_likreestr');
				$data['tab_analogs'] = $this->language->get('tab_analogs');
				$data['tab_same'] = $this->language->get('tab_same');
				$data['tab_attribute'] = $this->language->get('tab_attribute');
				$data['tab_review'] = sprintf($this->language->get('tab_review'), $product_info['reviews']);
				
				$data['product_id'] = (int)$this->request->get['product_id'];
				$data['manufacturer'] = $product_info['manufacturer'];
				$data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
				$data['model'] = $product_info['model'];
				$data['brand'] = $product_info['isbn'];
				$data['text_brand'] = $this->language->get('text_brand');
				
				
				$data['is_preorder'] = $product_info['is_preorder'];
				$data['text_preorder'] = $this->language->get('text_preorder');
				$data['reward'] = $product_info['reward'];
				$data['points'] = $product_info['points'];
				$data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
				$data['instruction'] = html_entity_decode($product_info['instruction'], ENT_QUOTES, 'UTF-8');
				$data['likreestr'] 	 = json_decode($product_info['reg_json'])?json_decode($product_info['reg_json'], true):false;
				
				$data['config_free_shipping'] = $this->config->get('config_free_shipping');
				
				$this->load->model('tool/tool');
				$data['instruction'] = $data['instruction'];//$this->model_tool_tool->clear_tags($data['instruction']);
				$data['description'] = $data['description'];//$this->model_tool_tool->clear_tags($data['description']);
				
				$data['title_primenenie'] = $this->language->get('title_primenenie');
				$data['title_tags'] = $this->language->get('title_tags');
				
				
				$this->load->model('simple_blog/article');
				
				$data['product_primenenie'] = array();
				$data['product_tags'] = array();

			/*	$primenenie = $this->model_catalog_product->getProductPrimenenie($this->request->get['product_id']);
				$data['product_primenenie'] = array();
				
				foreach ($primenenie as $simple_blog_article_id) {
					$article_info = $this->model_simple_blog_article->getArticle($simple_blog_article_id);
					
					if ($article_info) {
						$data['product_primenenie'][] = array(
						'simple_blog_article_id' => $article_info['simple_blog_article_id'],
						'article_title'        => $article_info['article_title'],
						'primenenie'        => $article_info['primenenie'],
						'href'      => $this->url->link('simple_blog/article', 'simple_blog_article_id=' . $article_info['simple_blog_article_id']),
						);
					}
				}
				
				
				$tags = $this->model_catalog_product->getProductTags($this->request->get['product_id']);
				$data['product_tags'] = array();
				
				foreach ($tags as $simple_blog_article_id) {
					$article_info = $this->model_simple_blog_article->getArticle($simple_blog_article_id);
					
					if ($article_info) {
						$data['product_tags'][] = array(
						'simple_blog_article_id' => $article_info['simple_blog_article_id'],
						'article_title'        => $article_info['article_title'],
						'tags'        => $article_info['tags'],
						'href'      => $this->url->link('simple_blog/article', 'simple_blog_article_id=' . $article_info['simple_blog_article_id']),
						);
					}
				}
			*/
				
				
				$data['instruction_print'] = $this->url->link('product/product/instruction', 'product_id=' . $product_info['product_id']);
				
				if ($product_info['quantity'] <= 0) {
					$data['stock'] = $product_info['stock_status'];
					} elseif ($this->config->get('config_stock_display')) {
					$data['stock'] = $product_info['quantity'];
					} else {
					$data['stock'] = $this->language->get('text_instock');
				}
				
				
				$this->load->model('tool/image');
				
				if ($product_info['image']) {
					$data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height'));
					} else {
					$data['popup'] = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height'));;
				}
				
				
				if ($product_info['image']) {
					$data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height'));
					} else {
					$data['thumb'] = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height'));;
				}
				
				$data['images'] = array();
				
				$results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
				
				foreach ($results as $result) {
					$data['images'][] = array(
					'popup' => $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height')),
					'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_additional_width'), $this->config->get($this->config->get('config_theme') . '_image_additional_height'))
					);
				}
				
				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					$data['numeric_price'] = $product_info['price'];
					} else {
					$data['price'] = false;
				}
				
				if ($this->customer->isLogged() && $product_info['has_pricegroup_discount'] && $product_info['price'] < $product_info['general_price'] && !$product_info['special']){
					$data['general_price'] = $this->currency->format($this->tax->calculate($product_info['general_price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);				
					} else {
					$data['general_price'] = false;
				}
				
				if ((float)$product_info['special']) {
					$data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
					$data['special'] = false;
				}
				
				$multiflat = $this->config->get('multiflat')[0];
				$main_category_id = $this->model_catalog_product->getMainCategory($this->request->get['product_id']);
				$result_price = (float)$product_info['special']?(float)$product_info['special']:(float)$product_info['price'];
				
				$data['free_shipping_kyiv'] = false;
				$data['free_shipping_ukraine'] = false;
				$data['delivery_to_ukraine_unavailable'] = false;
				$data['text_free_shipping_kyiv'] = $this->language->get('text_free_shipping_kyiv');
				$data['text_free_shipping_ukraine'] = $this->language->get('text_free_shipping_ukraine');
				
				//Новая Почта
				$config_novaposhta = $this->settings = $this->config->get('novaposhta');
				$unavailable_novaposhta = (int)$config_novaposhta['shipping_methods']['warehouse']['minimum_order_amount'];
				
				if ($unavailable_novaposhta && ($unavailable_novaposhta > $data['price'] || ($data['special'] && $unavailable_novaposhta > $data['special']))){
					$data['delivery_to_ukraine_unavailable'] = true;
					$data['text_delivery_to_ukraine_unavailable'] = sprintf($this->language->get('text_delivery_to_ukraine_unavailable'), $this->currency->format($this->tax->calculate($unavailable_novaposhta, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
				}							
				
				if ($result_price && $multiflat['free_from'] && (int)$multiflat['category_id']){			
					if ($result_price >= $multiflat['free_from'] && $main_category_id['category_id'] != (int)$multiflat['category_id']){
						$data['free_shipping_kyiv'] = true;
					}
					
					$free_novaposhta = (int)$config_novaposhta['shipping_methods']['warehouse']['free_shipping'];
					
					$config_ukrposhta = $this->config->get('ukrposhta');
					$free_ukrposhta = (int)$config_ukrposhta['shipping_methods']['express_w']['free_shipping'];
					
					$free_max = max($free_novaposhta, $free_ukrposhta);
					
					if ($result_price && !$product_info['no_shipping'] && $free_max && ($result_price > $free_max)){
						$data['free_shipping_ukraine'] = true;
					}
				}	
				
				$data['is_receipt'] = ($product_info['no_payment'] || $product_info['is_receipt']);
				
				if ($data['is_receipt']) {
					$data['free_shipping_kyiv'] = false;
					$data['free_shipping_ukraine'] = false;
				}
				
				if ($this->config->get('config_tax')) {
					$data['tax'] = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
					} else {
					$data['tax'] = false;
				}
				
				$discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
				
				$data['discounts'] = array();
				
				foreach ($discounts as $discount) {
					$data['discounts'][] = array(
					'quantity' => $discount['quantity'],
					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'])
					);
				}
				
				$data['options'] = array();
				
				foreach ($this->model_catalog_product->getProductOptions($this->request->get['product_id']) as $option) {
					$product_option_value_data = array();
					
					foreach ($option['product_option_value'] as $option_value) {
						if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
							if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
								$price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
								} else {
								$price = false;
							}
							
							$product_option_value_data[] = array(
							'product_option_value_id' => $option_value['product_option_value_id'],
							'option_value_id'         => $option_value['option_value_id'],
							'name'                    => $option_value['name'],
							'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
							'price'                   => $price,
							'price_prefix'            => $option_value['price_prefix']
							);
						}
					}
					
					$data['options'][] = array(
					'product_option_id'    => $option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'            => $option['option_id'],
					'name'                 => $option['name'],
					'type'                 => $option['type'],
					'value'                => $option['value'],
					'required'             => $option['required']
					);
				}
				
				if ($data['options']){
					$data['text_full_pack'] = sprintf($this->language->get('text_full_pack'), $product_info['count_of_parts']);
					$data['text_part_pack'] = $this->language->get('text_part_pack');
				}
				
				
				if ($product_info['minimum']) {
					$data['minimum'] = $product_info['minimum'];
					} else {
					$data['minimum'] = 1;
				}
				
				$data['review_status'] = $this->config->get('config_review_status');
				
				if ($this->config->get('config_review_guest') || $this->customer->isLogged()) {
					$data['review_guest'] = true;
					} else {
					$data['review_guest'] = false;
				}
				
				if ($this->customer->isLogged()) {
					$data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
					$data['customer_email'] = $this->customer->getEmail();
					} else {
					$data['customer_name'] = '';
					$data['customer_email'] = '';
				}
				
				$data['reviews'] = sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']);
				$data['rating'] = (int)$product_info['rating'];
				
				// Captcha
				if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
					$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));
					} else {
					$data['captcha'] = '';
				}
				
				$data['share'] = $this->url->link('product/product', 'product_id=' . (int)$this->request->get['product_id']);				
				$data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);

				$data['atx_tree'] = [];
				if ($product_info['reg_atx_1']){
					$data['reg_atx_1'] = $product_info['reg_atx_1'];
					$atx_path = $this->model_catalog_category->getCategoryByATX($product_info['reg_atx_1']);
					$atx_path = rtrim($atx_path, '_');


					$path = '';
					foreach (explode('_', $atx_path) as $category_id) {
						if (!$path) {
							$path = $category_id;
						} else {
							$path .= '_' . $category_id;
						}

						$category_info = $this->model_catalog_category->getCategory($category_id);

						if ($category_info) {
							$category_name = mb_strstr($category_info['name'], '(ATX-код', true);							

							$data['atx_tree'][] = [
								'atx_code' 	=> $category_info['atx_code'],
								'href' 		=> $this->url->link('product/category', 'path=' . $path),
								'name' 		=> $category_name,
							];
						}
					}

					array_shift($data['atx_tree']);
				}
				
				$detect = new \Mobile_Detect();
				$data['disable_map'] = $data['is_mobile'] = $detect->isMobile();
				
				$data['stocks'] = array();
				$data['geocode'] = $this->config->get('config_geocode');			
												
				//same
				$results = $this->model_catalog_product->getProductSame($this->request->get['product_id']);
				
				if (!$results){					
					$results = $this->model_catalog_product->guessSameProducts($product_info['name'], $this->request->get['product_id'], 12, false);
				}
				
				$data['same'] = $this->model_catalog_product->prepareProductArray($results);							
				
				$data['entry_view_else'] = $this->language->get('entry_view_else');
				$data['quantity_stock'] = $product_info['quantity'];
				
				$data['is_receipt'] = ($product_info['no_payment'] || $product_info['is_receipt']);
				$data['text_is_receipt'] = $this->language->get('text_is_receipt');
				$data['text_is_receipt2'] = $this->language->get('text_is_receipt2');
				
				$data['no_fast_order'] = false;//($product_info['is_pko'] || $product_info['is_drug']);
				
				$data['is_thermolabel'] = $product_info['is_thermolabel'];
				$data['text_product_is_thermolabel'] = $this->language->get('text_product_is_thermolabel');
				
				
				//lights				
				$results = $this->model_catalog_product->getProductLights($this->request->get['product_id'], true);	
				$data['lights'] = $this->model_catalog_product->prepareProductArray($results);			
				
				//analogs
				if ($product_info['quantity'] > 0) {					
					$results = $this->model_catalog_product->getProductAnalog($this->request->get['product_id']);
					} else {					
					$results = $this->model_catalog_product->getProductAnalog($this->request->get['product_id'], true);					
				}				
				$data['analogs'] = $this->model_catalog_product->prepareProductArray($results);	
				
				
				//$results = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
				$results = $this->model_catalog_product->getProductAlsoBought($this->request->get['product_id']);
				$data['products'] = $this->model_catalog_product->prepareProductArray($results);
				
				if ($data['products']){
					$slider_data = array(
					'slider_class' 			=> 'blue',
					'slider_title'    		=> $this->language->get('text_alsobought'),
					'slider_products' 		=> $data['products']
					);
					
					$data['products_rendered'] = $this->load->view('product/structured/products_slider', array_merge($data, $slider_data));
				}
				
				$data['gtin'] = $product_info['ean'];
				
				//collection
				$data['collection'] = false;
				$data['collection_products'] = false;
				$data['text_all_collection_products'] = $this->language->get('text_all_collection_products');
				if ($collection_id = $this->model_catalog_product->getProductCollection($this->request->get['product_id'])){
					$this->load->model('catalog/collection');
					
					$collection = $this->model_catalog_collection->getCollection($collection_id);
					
					$data['text_collection'] = $this->language->get('text_collection');
					
					if ($collection){
						$data['collection'] = $collection['name'];
						$data['collection_href'] = $this->url->link('catalog/collection', 'collection_id=' . $collection['collection_id']);
					}
					
					
					$filter_data = array(
					'filter_collection_id' => $collection_id,
					'filter_notnull_price' => true,
					'sort' => 'pd.name',
					);
					
					$results = $this->model_catalog_product->getProducts($filter_data);
					$data['collection_products'] = $this->model_catalog_product->prepareProductArray($results);
					
					if ($data['collection_products']){
						$slider_data = array(
						'slider_class' 			=> 'blue',
						'slider_title'    		=> $data['collection'],
						'slider_products' 		=> $data['collection_products']
						);
						
						$data['collection_rendered'] = $this->load->view('product/structured/products_slider', array_merge($data, $slider_data));
					}
					
				}
				
				
				//Что выводить в блоке под товаром
				//Товар обычный, не рецептурный, есть в наличии, значит можно вывести дозировки, но только те, которые дороже и в нал
				$data['proposal'] = array();
				$data['is_good_proposal'] = false;
				if ($product_info['quantity'] > 0 && !$data['is_receipt']){
					$results = $this->model_catalog_product->getProductAnalogSame($this->request->get['product_id'], $expensive = true);
					$data['proposal'] = $this->model_catalog_product->prepareProductArray($results);
					$data['proposal_text'] = $this->language->get('proposal_text_same_expensive');
				}
				
				if ($product_info['quantity'] == 0 && !$data['is_receipt']){
					$results = $this->model_catalog_product->getProductAnalogSame($this->request->get['product_id']);
					$data['is_good_proposal'] = true;
					$data['proposal'] = $this->model_catalog_product->prepareProductArray($results);
					$data['proposal_text'] = $this->language->get('proposal_text_same_fornotinstock');					
				}
				
				if ($data['is_receipt'] && $results = $this->model_catalog_product->getProductLights($this->request->get['product_id'])){
					$data['proposal'] = $this->model_catalog_product->prepareProductArray($results);
					$data['proposal_text'] = $this->language->get('proposal_text_ligts');
					$data['text_is_receipt'] = $this->language->get('text_is_receipt_2');
				}
				
				
				if ($data['proposal']){
					$slider_data = array(
					'slider_class' 			=> $data['is_good_proposal']?'green':'blue',
					'slider_title'    		=> $data['proposal_text'],
					'slider_products' 		=> $data['proposal']
					);
					
					$data['proposal_rendered'] = $this->load->view('product/structured/products_slider', array_merge($data, $slider_data));
				}
				
				
				$data['tags'] = array();
				
				if ($product_info['tag']) {
					$tags = explode(',', $product_info['tag']);
					
					foreach ($tags as $tag) {
						$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('product/search', 'tag=' . trim($tag))
						);
					}
				}
				
				//!overload for deletion
				$data['tags'] = array();
				
				$data['recurrings'] = $this->model_catalog_product->getProfiles($this->request->get['product_id']);
				
				$this->model_catalog_product->updateViewed($this->request->get['product_id']);
				$this->model_catalog_product->catchAlsoViewed($this->request->get['product_id']);
				
				$data['column_left'] = $this->load->controller('common/column_left');
				$data['column_right'] = $this->load->controller('common/column_right');
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');
				
				
				
				// BuyOneClick
				$this->load->model('setting/setting');
				$current_language_id = $this->config->get('config_language_id');
				
				$buyoneclick = $this->config->get('buyoneclick');
				$data['buyoneclick_name'] = isset($buyoneclick["name"][$current_language_id]) ? $buyoneclick["name"][$current_language_id] : '';
				$data['buyoneclick_status_product'] = $buyoneclick["status_product"];
				$data['buyoneclick_status_module'] = $buyoneclick["status_module"];
				
				$data['buyoneclick_ya_status'] 					= $buyoneclick['ya_status'];
				$data['buyoneclick_ya_counter'] 				= $buyoneclick['ya_counter'];
				$data['buyoneclick_ya_identificator'] 			= $buyoneclick['ya_identificator'];
				$data['buyoneclick_ya_identificator_send'] 		= $buyoneclick['ya_identificator_send'];
				$data['buyoneclick_ya_identificator_success'] 	= $buyoneclick['ya_identificator_success'];
				
				$data['buyoneclick_google_status'] 				= $buyoneclick['google_status'];
				$data['buyoneclick_google_category_btn'] 		= $buyoneclick['google_category_btn'];
				$data['buyoneclick_google_action_btn'] 			= $buyoneclick['google_action_btn'];
				$data['buyoneclick_google_category_send'] 		= $buyoneclick['google_category_send'];
				$data['buyoneclick_google_action_send'] 		= $buyoneclick['google_action_send'];
				$data['buyoneclick_google_category_success'] 	= $buyoneclick['google_category_success'];
				$data['buyoneclick_google_action_success'] 		= $buyoneclick['google_action_success'];
				
				$this->load->language('extension/module/buyoneclick');
				if (!isset($data['buyoneclick_name']) || $data['buyoneclick_name'] == '') {
					$data['buyoneclick_name'] = $this->language->get('buyoneclick_button');
				}
				$data['buyoneclick_text_loading'] = $this->language->get('buyoneclick_text_loading');
				// BuyOneClickEnd
				
				$this->response->setOutput($this->load->view('product/product', $data));
				} else {
				$url = '';
				
				if (isset($this->request->get['path'])) {
					$url .= '&path=' . $this->request->get['path'];
				}
				
				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}
				
				if (isset($this->request->get['manufacturer_id'])) {
					$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
				}
				
				if (isset($this->request->get['search'])) {
					$url .= '&search=' . $this->request->get['search'];
				}
				
				if (isset($this->request->get['tag'])) {
					$url .= '&tag=' . $this->request->get['tag'];
				}
				
				if (isset($this->request->get['description'])) {
					$url .= '&description=' . $this->request->get['description'];
				}
				
				if (isset($this->request->get['category_id'])) {
					$url .= '&category_id=' . $this->request->get['category_id'];
				}
				
				if (isset($this->request->get['sub_category'])) {
					$url .= '&sub_category=' . $this->request->get['sub_category'];
				}
				
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}
				
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
				
				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}
				
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
				
				$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('product/product', $url . '&product_id=' . $product_id)
				);
				
				$this->document->setTitle($this->language->get('text_error'));
				
				$data['heading_title'] = $this->language->get('text_error');
				
				$data['text_error'] = $this->language->get('text_error');
				
				$data['button_continue'] = $this->language->get('button_continue');
				
				$data['continue'] = $this->url->link('common/home');
				
				$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
				
				//	$data['column_left'] = $this->load->controller('common/column_left');
				//	$data['column_right'] = $this->load->controller('common/column_right');
				//	$data['content_top'] = $this->load->controller('common/content_top');
				$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');
				
				$this->response->setOutput($this->load->view('error/not_found', $data));
			}
		}
			
		public function review() {
			$this->load->language('product/product');
			
			$this->load->model('catalog/review');
			
			$data['text_no_reviews'] = $this->language->get('text_no_reviews');
			
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
				} else {
				$page = 1;
			}
			
			$data['reviews'] = array();
			
			$review_total = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);
			
			$results = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);
			
			foreach ($results as $result) {
				$data['reviews'][] = array(
				'author'     => $result['author'],
				'text'       => nl2br($result['text']),
				'rating'     => (int)$result['rating'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
				);
			}
			
			$pagination = new Pagination();
			$pagination->total = $review_total;
			$pagination->page = $page;
			$pagination->limit = 5;
			$pagination->url = $this->url->link('product/product/review', 'product_id=' . $this->request->get['product_id'] . '&page={page}');
			
			$data['pagination'] = $pagination->render();
			
			$data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($review_total - 5)) ? $review_total : ((($page - 1) * 5) + 5), $review_total, ceil($review_total / 5));
			
			$this->response->setOutput($this->load->view('product/review', $data));
		}
		
		public function write() {
			$this->load->language('product/product');
			
			$json = array();
			
			if ($this->request->server['REQUEST_METHOD'] == 'POST') {
				
				if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25 || ctype_space($this->request->post['name']))) {
					$json['error'] = $this->language->get('error_name');
				}
				
				if ((utf8_strlen($this->request->post['email']) < 5) && !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
					$json['error'] = $this->language->get('error_email');
				}
				
				if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
					$json['error'] = $this->language->get('error_text');
				}
				
				if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
					$json['error'] = $this->language->get('error_rating');
				}
				
				// Captcha
				if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
					$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');
					
					if ($captcha) {
						$json['error'] = $captcha;
					}
				}
				
				
				if (!isset($json['error'])) {
					$this->load->model('catalog/review');
					
					$this->model_catalog_review->addReview($this->request->get['product_id'], $this->request->post);
					
					$json['success'] = $this->language->get('text_success');
				}
			}
			
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
		
		public function getRecurringDescription() {
			$this->load->language('product/product');
			$this->load->model('catalog/product');
			
			if (isset($this->request->post['product_id'])) {
				$product_id = $this->request->post['product_id'];
				} else {
				$product_id = 0;
			}
			
			if (isset($this->request->post['recurring_id'])) {
				$recurring_id = $this->request->post['recurring_id'];
				} else {
				$recurring_id = 0;
			}
			
			if (isset($this->request->post['quantity'])) {
				$quantity = $this->request->post['quantity'];
				} else {
				$quantity = 1;
			}
			
			$product_info = $this->model_catalog_product->getProduct($product_id);
			$recurring_info = $this->model_catalog_product->getProfile($product_id, $recurring_id);
			
			$json = array();
			
			if ($product_info && $recurring_info) {
				if (!$json) {
					$frequencies = array(
					'day'        => $this->language->get('text_day'),
					'week'       => $this->language->get('text_week'),
					'semi_month' => $this->language->get('text_semi_month'),
					'month'      => $this->language->get('text_month'),
					'year'       => $this->language->get('text_year'),
					);
					
					if ($recurring_info['trial_status'] == 1) {
						$price = $this->currency->format($this->tax->calculate($recurring_info['trial_price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						$trial_text = sprintf($this->language->get('text_trial_description'), $price, $recurring_info['trial_cycle'], $frequencies[$recurring_info['trial_frequency']], $recurring_info['trial_duration']) . ' ';
						} else {
						$trial_text = '';
					}
					
					$price = $this->currency->format($this->tax->calculate($recurring_info['price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					
					if ($recurring_info['duration']) {
						$text = $trial_text . sprintf($this->language->get('text_payment_description'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
						} else {
						$text = $trial_text . sprintf($this->language->get('text_payment_cancel'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
					}
					
					$json['success'] = $text;
				}
			}
			
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}
