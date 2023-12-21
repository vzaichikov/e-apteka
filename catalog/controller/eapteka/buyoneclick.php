<?php
	class ControllerEaptekaBuyoneclick extends Controller {	
		private $fastOrderStatus = 11;

		public function calculate(){
			$quantity = (int)$this->request->get['q'];
			$price    = (float)$this->request->get['p'];

			$result = $this->currency->format($quantity * $price, $this->session->data['currency']);

			$this->response->setOutput($result);
		}
		
		public function submit() {
			$buyoneclick = $this->config->get('buyoneclick');
			$buyoneclick_exan_status = $buyoneclick['exan_status'];
			$buyoneclick_success_type = $buyoneclick['success_type'];
			
			$data['logged'] = $this->customer->isLogged();
			
			$customer_id = $this->customer->isLogged();
			$customer_group_id = $this->customer->getGroupId();
			
			$firstname = $this->customer->getFirstName();
			$lastname = $this->customer->getLastName();
			$email = $this->customer->getEmail()?$this->customer->getEmail():'';
			
		
			
			if (isset($this->request->post['boc_phone'])) {
				$phone = $this->request->post['boc_phone'];
				} else {
				$phone = $this->customer->getTelephone();
			}	
			
			$this->load->language('extension/module/buyoneclick');
			$json = array();
			if (!empty($this->session->data['boc_product_id'])) {
				$product_id = (int)$this->session->data['boc_product_id'];
				} else if (isset($this->request->post['boc_product_id'])) {
				$product_id = (int)$this->request->post['boc_product_id'];
				} else {
				$product_id = 0;
			}
			
			
			$boc_title = $this->language->get('buyoneclick_title');
			
			if (isset($this->request->post['boc_message'])) {
				$comment = $this->request->post['boc_message'];
				} else {
				$comment = '';
			}			
			
			$this->load->model('catalog/product');
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if ($product_info) {
				if (!empty($this->session->data['boc_product_quantity'])) {
					$product_quantity = (int)$this->session->data['boc_product_quantity'];
					} else {
					$product_quantity = $product_info['minimum'] ? $product_info['minimum'] : 1;
				}

				if (!empty($this->request->post['quantity-popup-main'])){
					$product_quantity = (int)$this->request->post['quantity-popup-main'];
				}

				if (!empty($this->session->data['boc_product_option'])) {
					$product_option = $this->session->data['boc_product_option'];
					} else {
					$product_option = array();
				}
				
				if (!$json) {
					$boc_price = (float)$product_info['price'];
					if ((float)$product_info['special']) {
						$boc_price = (float)$product_info['special'];
					}
					
					$discounts = $this->model_catalog_product->getProductDiscounts($product_id);
					if ($discounts) {
						foreach ($discounts as $discount) {
							if ($discount['quantity'] <= $product_quantity) {
								$boc_price = (float)$discount['price'];
							}
						}
					}
										
					if (!$product_option) {
						$boc_unit_price = $boc_price;
						$boc_total = $boc_price * $product_quantity;
						$boc_unit_tax = $this->tax->getTax($boc_price, $product_info['tax_class_id']);
						
						} else {
						$option_total = 0;
						foreach ($product_option as $option) {
							if ($option['value_price_prefix'] == '+') {
								$option_total += (float)$option['value_price_value'];
								} else if ($option['value_price_prefix'] == '-') {
								$option_total -= (float)$option['value_price_value'];
								} else if ($option['value_price_prefix'] == '=') {
								$option_total = (float)$option['value_price_value'];
							}
						}
						$boc_unit_tax = $this->tax->getTax(($option_total * $product_quantity), $product_info['tax_class_id']);
						
						$boc_price = $option_total;
						$boc_unit_price = $option_total;
						$boc_total = $option_total * $product_quantity;
					}
					
					
					$boc_tax_total = $boc_unit_tax * $product_quantity;
					$boc_order_total = $boc_total;
										
					$order_data['products'][] = array (
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name'],
					'model'      => $product_info['model'],
					'option'     => $product_option,
					'download'   => '',
					'quantity'   => $product_quantity,
					'subtract'   => $product_info['subtract'],
					'price'      => $boc_unit_price,
					'total'      => $boc_total,
					'tax'        => $boc_unit_tax,
					'reward'     => $product_info['reward']
					);					
					
					$order_data['totals'] = array();
					
					$this->load->language('checkout/checkout');
					$order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
					$order_data['store_id'] = $this->config->get('config_store_id');
					$order_data['store_name'] = $this->config->get('config_name');
					if ($order_data['store_id']) {
						$order_data['store_url'] = $this->config->get('config_url');
						} else {
						$order_data['store_url'] = HTTP_SERVER;
					}
					
					$exan = '';								
					
					$order_data['customer_id'] = $customer_id;
					$order_data['customer_group_id'] = $customer_group_id;
					$order_data['firstname'] = $firstname;
					$order_data['lastname'] = $lastname;
					$order_data['email'] = $email;
					$order_data['telephone'] = $phone;
					$order_data['fax'] = $fax;
					$order_data['custom_field'] = array();
					$order_data['payment_firstname'] = $firstname;
					$order_data['payment_lastname'] = $lastname;
					$order_data['payment_company'] = '';
					$order_data['payment_address_1'] = $boc_title;
					$order_data['payment_address_2'] = '';
					$order_data['payment_city'] = '';
					$order_data['payment_postcode'] = '';
					$order_data['payment_zone'] = '';
					$order_data['payment_zone_id'] = '';
					$order_data['payment_country'] = '';
					$order_data['payment_country_id'] = '';
					$order_data['payment_address_format'] = '';
					$order_data['payment_custom_field'] = array();
					$order_data['payment_method'] = $boc_title;
					$order_data['payment_code'] = 'cod';
					$order_data['shipping_firstname'] = $firstname;
					$order_data['shipping_lastname'] = $lastname;
					$order_data['shipping_company'] = '';
					$order_data['shipping_address_1'] = $boc_title;
					$order_data['shipping_address_2'] = '';
					$order_data['shipping_city'] = '';
					$order_data['shipping_postcode'] = '';
					$order_data['shipping_zone'] = '';
					$order_data['shipping_zone_id'] = '';
					$order_data['shipping_country'] = '';
					$order_data['shipping_country_id'] = '';
					$order_data['shipping_address_format'] = '';
					$order_data['shipping_custom_field'] = array();
					$order_data['shipping_method'] = '';
					$order_data['shipping_code'] = '';
					$order_data['comment'] = $comment;
					$order_data['total'] = $boc_order_total;
					$order_data['affiliate_id'] = 0;
					$order_data['commission'] = 0;
					$order_data['marketing_id'] = 0;
					$order_data['tracking'] = '';
					
					$order_data['fastorder'] = true;

					//Перезагрузка данных для резерва
					if (!empty($this->request->post['location_id'])){
						$this->load->model('localisation/location');
						$location = $this->model_localisation_location->getLocation($this->request->post['location_id']);
						
						if ($location){
							$order_data['payment_address_1'] = $location['address'];
							$order_data['payment_city'] = 'Київ';

							$order_data['shipping_address_1'] = $location['address'];
							$order_data['shipping_city'] = 'Київ';

							$order_data['shipping_method'] = 'Самовивіз з аптеки';
							$order_data['shipping_code'] = 'pickup.pickup';
							$order_data['location_id']	= $location['location_id'];
						}
					}
					
					$order_data['language_id'] = $this->config->get('config_language_id');
					$order_data['currency_id'] = $this->currency->getId($this->session->data['currency']);
					$order_data['currency_code'] = $this->session->data['currency'];
					$order_data['currency_value'] = $this->currency->getValue($this->session->data['currency']);
					$order_data['ip'] = $this->request->server['REMOTE_ADDR'];
					if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
						$order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
						} elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
						$order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
						} else {
						$order_data['forwarded_ip'] = '';
					}
					if (isset($this->request->server['HTTP_USER_AGENT'])) {
						$order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
						} else {
						$order_data['user_agent'] = '';
					}
					if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
						$order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
						} else {
						$order_data['accept_language'] = '';
					}				
					
					$this->load->model('checkout/order');
					$data['order_id'] = $this->model_checkout_order->addOrder($order_data);
					$this->session->data['recent_order_id'] = $data['order_id'];
					
					
					unset($this->session->data['boc_product_option']);
					unset($this->session->data['boc_product_id']);
					unset($this->session->data['boc_product_quantity']);
					
					if (empty($data['order_id'])) {
						$json['error']['order'] = $this->language->get('error_order');
						} else {
						
						$this->model_checkout_order->addOrderHistory($data['order_id'], $this->fastOrderStatus, $comment = '', $notify = false, $override = false, $redirect = false);
						$json['success'] = sprintf($this->language->get('text_success'), $data['order_id'], $phone);
						
											
						if (!empty($location)){	
							$location_message = "[B]Клієнт оформив швидкий резерв в аптеці " . $location['address'] . "[/B]";
						} else {
							$location_message = "[B]Замовлення без резервування на будь-якій аптеці![/B]";
						}

						if ($buyoneclick_success_type == '1') {
							//$json['redirect'] = $this->url->link('checkout/success', '', 'SSL');
						}
					}
					
					
					} else {

					$json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']));
				}
				
				} else {
				$json['error']['product'] = $this->language->get('error_product');
			}

			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}								