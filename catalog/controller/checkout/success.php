<?php
	
	
	class ControllerCheckoutSuccess extends Controller {
		public function index() {
			$barcodeValidator = new \Ced\Validator\Barcode();
			
			$data['tmdaccount_customcss'] = $this->config->get('tmdaccount_custom_css');
			$data['tmdaccount_status'] = $this->config->get('tmdaccount_status');
			$this->load->language('checkout/success');
			$this->load->language('checkout/detail_success');
				
				if (!isset($this->session->data['order_id']) && $_SERVER['REMOTE_ADDR'] == '31.43.104.37'){
					//$this->session->data['order_id'] = 161090;	
				}
			
			if (isset($this->session->data['order_id']) && (!empty($this->session->data['order_id']))) {
				$this->session->data['recent_order_id'] = $this->session->data['order_id'];
			}			
			
			if (isset($this->session->data['recent_order_id'])) {				
				
				$this->session->data['order_id'] = $this->session->data['recent_order_id'];
				
				$this->cart->clear();
				
				$this->load->model('checkout/order');
				$this->load->model('localisation/location');
				$this->load->model('tool/image');
				$this->load->model('catalog/product');
				
				$data['order'] = $this->model_checkout_order->getOrder($this->session->data['order_id']);
				$data['order']['total'] = $this->currency->format($data['order']['total'], $this->session->data['currency']);
				$data['products'] = array();

				if ($data['order']['total'] && $data['order']['payment_code'] == 'whitepay' /* && $data['order']['order_status_id'] == $this->config->get('whitepay_order_status_id') */){
					// $this->load->language('extension/payment/whitepay');					
					// $data['whitepay_payment'] = $this->url->link('extension/payment/whitepay/payment');
					// $data['whitepay_pay_button_text'] = $this->language->get('whitepay_pay_button_text');

					// $this->load->language('checkout/success');
					// $this->load->language('checkout/detail_success');
				}
				
				$data['text_success1'] = sprintf($this->language->get('text_success1'), $this->session->data['order_id']);
				$data['text_success2'] = $this->language->get('text_success2');
				$data['text_success3'] = $this->language->get('text_success3');
				$data['text_success4'] = $this->language->get('text_success4');
				$data['text_success5'] = $this->language->get('text_success5');
				$data['text_success6'] = $this->language->get('text_success6');
				$data['text_success7'] = $this->language->get('text_success7');
				
				$data['ecommerceData'] = array(
				'currencyCode' => $this->session->data['currency'],
				'id'		   => $this->session->data['order_id'],
				'email'		   => $data['order']['email'],
				'estimated_date' => date('Y-m-d', strtotime('+1 day')),
				'revenue'	   => (float)$data['order']['total'],
				'tax'	   	   => 0,
				'shipping'	   => $data['order']['shipping_method'],
				'affiliation'  => HTTP_SERVER,
				'coupon'	   => isset($this->session->data['coupon'])?$this->session->data['coupon']:false,
				'products'     => array()
				);
				
				if ($data['order']['shipping_code'] == 'multiflat.multiflat0'){
					$data['order']['shipping_method'] = $this->language->get('text_our_delivery');
				}
				
				$products = $this->model_checkout_order->getOrderProducts($this->session->data['order_id']);	
				$transactionGTINS = array();

				
				foreach ($products as $product) { 
					$real_product = $this->model_catalog_product->getProduct($product['product_id']);
					
					if ($real_product['image']) {
						$image = $this->model_tool_image->resize($real_product['image'], $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
						} else {
						$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
					}
					
					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($product['price'], $real_product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						$total = $this->currency->format($this->tax->calculate($product['price'] * $product['quantity'], $real_product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						} else {
						$price = false;
					}
					
					$real_product['ecommerceData']['price'] = $product['price'];
					$real_product['ecommerceData']['quantity'] = $product['quantity'];
					
					$gtin = false;
					if ($realProduct['ean']){
						$barcodeValidator->setBarcode($realProduct['ean']);
						if ($barcodeValidator->isValid()){
							$gtin = $barcodeValidator->getGTIN14();
						}
					}
					
					if ($gtin){
						$transactionGTINS[] = '{"gtin":"' . $gtin . '"}';
					}
					
					
					$data['ecommerceData']['products'][] = array(
					'id'  		=> $real_product['product_id'],
					'name'      => $real_product['ecommerceData']['name'],
					'brand'     => $real_product['ecommerceData']['brand'],
					'category'  => $real_product['ecommerceData']['category'],
					'price'     => $product['price'],
					'quantity'  => $product['quantity'],
					'total'  	=> $product['quantity'] * $product['price'],
					);
					
					$data['products'][] = array(
					'product_id'  		=> $real_product['product_id'],
					'seo'		  		=> $real_product['seo'],
					'ecommerceCurrency' => $this->session->data['currency'],
					'ecommerceData'	   	=> $real_product['ecommerceData'],
					'thumb'       		=> $image,
					'name'        		=> $real_product['name'],
					'manufacturer'       => $real_product['manufacturer'],
					'description' 		=> utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       		=> $price,
					'total'       		=> $total,
					'quantity'    		=> $product['quantity'],
					'special'     		=> $special,
					'tax'         		=> $tax,
					'rating'      		=> $rating,
					'reviews'     		=> $real_product['reviews'],
					'no_shipping' 		=> $real_product['no_shipping'],
					'no_payment'  		=> $real_product['no_payment'],
					'is_receipt'  		=> $real_product['is_receipt'],
					'is_thermolabel'  	=> $real_product['is_thermolabel'],
					'product_xdstickers' => $product_xdstickers,
					'minimum'     		=> $real_product['minimum'] > 0 ? $real_product['minimum'] : 1,
					'href'        		=> $this->url->link('product/product', 'product_id=' . $real_product['product_id'])
					);
				}
				
				$this->data['ecommerceData']['gtins'] = $transactionGTINS;
				
				$data['text_title'] = sprintf($this->language->get('text_title'), $this->session->data['order_id']);
				$data['text_product'] = $this->language->get('text_product');
				$data['text_price'] = $this->language->get('text_price');
				$data['text_qty'] = $this->language->get('text_qty');
				$data['text_total'] = $this->language->get('text_total');
				$data['text_details'] = $this->language->get('text_details');
				$data['text_name'] = $this->language->get('text_name');
				$data['text_shipping_name'] = $this->language->get('text_shipping_name');
				
				$data['text_company'] = $this->language->get('text_company');
				$data['text_email'] = $this->language->get('text_email');
				$data['text_shipping_email'] = $this->language->get('text_shipping_email');
				$data['text_phone'] = $this->language->get('text_phone');
				$data['text_fax'] = $this->language->get('text_fax');
				
				$data['text_delivery'] 		= $this->language->get('text_delivery');
				$data['text_payment'] 		= $this->language->get('text_payment');
				$data['text_address'] 		= $this->language->get('text_address');
				$data['text_callcenter'] 	= $this->language->get('text_callcenter');
				$data['text_seller'] 		= $this->language->get('text_seller');
				
				$data['text_allday'] = $this->language->get('text_seller');
				$data['text_datetime'] = $this->language->get('text_datetime');
				$data['text_order_id'] = $this->language->get('text_order_id');
				
				$data['text_worktime'] = $this->language->get('text_worktime');
				
				$data['callcenter_telephone'] = $this->config->get('config_telephone');
				$data['seller']	=	nl2br($this->config->get('config_address'));
				
				if ($data['order']['location_id']){
					$location_id = $data['order']['location_id'];					
				} elseif (strpos($data['order']['shipping_code'], 'multiflat') !== false){
					$location_id = 7;
					foreach (['Дарницький','Деснянський','Дніпровський'] as $leftShoreRegion){
						if (strpos($data['order']['shipping_address_1'], $leftShoreRegion) !== false){
							$location_id = 6; break;							
						}
					}
				} elseif (strpos($data['order']['shipping_code'], 'novaposhta') !== false || strpos($data['order']['shipping_code'], 'ukrposhta') !== false){
					$location_id = 7;
				}		

				if ($location_id){
					$this->load->model('localisation/location');
					$location_info = $this->model_localisation_location->getLocation($location_id);
					
					$multilang_fields = ['open'];
					foreach ($multilang_fields as $_field){
						if ($_mlvalue = $this->model_localisation_location->getLocationML($location_info['location_id'], $_field)){
							${$_field} = $_mlvalue;
							} else {
							${$_field} = $location_info[$_field];
						}
					}

					$real_seller = $location_info['address'];					
					$data['open'] = $open;
				}

				if ($real_seller){
					$data['seller'] = str_replace(['б-р Лесі Українки, 9', 'б-р Леси Украинки, 9'], $real_seller, $data['seller']);		
				}
				
				// Add to activity log
				if ($this->config->get('config_customer_activity')) {
					$this->load->model('account/activity');
					
					if ($this->customer->isLogged()) {
						$activity_data = array(
						'customer_id' => $this->customer->getId(),
						'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName(),
						'order_id'    => $this->session->data['order_id']
						);
						
						$this->model_account_activity->addActivity('order_account', $activity_data);
						} else {
						$activity_data = array(
						'name'     => $this->session->data['guest']['firstname'] . ' ' . $this->session->data['guest']['lastname'],
						'order_id' => $this->session->data['order_id']
						);
						
						$this->model_account_activity->addActivity('order_guest', $activity_data);
					}
				}
				
				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);
				unset($this->session->data['guest']);
				unset($this->session->data['comment']);
				unset($this->session->data['order_id']);
				unset($this->session->data['coupon']);
				unset($this->session->data['reward']);
				unset($this->session->data['voucher']);
				unset($this->session->data['vouchers']);
				unset($this->session->data['totals']);
			}
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
			);
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_basket'),
			'href' => $this->url->link('checkout/cart')
			);
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_checkout'),
			'href' => $this->url->link('checkout/checkout', '', true)
			);
			
			$data['heading_title'] = $this->language->get('heading_title');
			
			if ($this->customer->isLogged()) {
				$data['text_message'] = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', true), $this->url->link('account/order', '', true), $this->url->link('account/download', '', true), $this->url->link('information/contact'));
				} else {
				$data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
			}
			
			$data['button_continue'] = $this->language->get('button_continue');
			
			$data['continue'] = $this->url->link('common/home');
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			
			$this->response->setOutput($this->load->view('common/success', $data));
		}
	}										