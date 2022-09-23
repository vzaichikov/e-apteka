<?php
class ControllerCheckoutOrderSuccess extends Controller {
	public function index() {
		$this->load->language('checkout/ordersuccess');
		$this->load->model('tool/image');

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

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_ordersuccess'),
			'href' => $this->url->link('checkout/ordersuccess')
		);
		
		$orderheading_title = $this->config->get('ordersucess_pageheading')[$this->config->get('config_language_id')]['pageheading'];
		if(!empty($orderheading_title)) {
		$data['heading_title'] = $orderheading_title;
		} else {
			$data['heading_title'] = $this->language->get('heading_title');
			
		}
		
		// Get Order
		$data['orderinvoice'] = $this->config->get('ordersucess_ordinvoc');
		$data['printinvoice'] = $this->config->get('ordersucess_printinvoice_status') ;
		$data['orderdetail']  = $this->config->get('ordersucess_orderdetail') ;
		$data['paymentaddress'] = $this->config->get('ordersucess_paymentadres');
		$data['shippingaddress'] = $this->config->get('ordersucess_shippingaddress');
		
		$data['titlebgcolor'] = $this->config->get('ordersucess_titlebgcolor');
		$data['titlecolor'] = $this->config->get('ordersucess_titlecolor');
		$data['showimage'] = $this->config->get('ordersucess_showimage');
		$data['productname'] = $this->config->get('ordersucess_proname');
		$data['productmodel'] = $this->config->get('ordersucess_model');
		$data['productsku'] = $this->config->get('ordersucess_sku');
		$data['productqty'] = $this->config->get('ordersucess_quantity');
		$data['productunitprice'] = $this->config->get('ordersucess_uniprice');
		$data['producttotal'] = $this->config->get('ordersucess_total');
		$data['facebookshare'] = $this->config->get('ordersucess_enablefacebookshare');
		$data['googleshare'] = $this->config->get('ordersucess_enablegoogleshare');
		$data['twittershare'] = $this->config->get('ordersucess_enabletwittershare');
		$data['text_share'] = $this->language->get('text_share');
		$data['customcss'] = $this->config->get('ordersucess_custom_css');
		$pageheading = $this->config->get('ordersucess_pageheading')[$this->config->get('config_language_id')]['pageheading'];
		if(!empty($pageheading)){		
			$data['heading_title'] = $pageheading;	
		} else{
			$data['heading_title'] = $this->language->get('text_order');	
		}
		
		$order_details = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['order_details'];
		if(!empty($order_details)){		
			$data['text_order_detail'] = $order_details;	
		} else{
			$data['text_order_detail'] = $this->language->get('text_order_detail');
		}
		
		$order_ids = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['order_id'];
		if(!empty($order_ids)){		
			$data['text_order_id'] = $order_ids;	
		} else{
			$data['text_order_id'] = $this->language->get('text_order_id');
		}
		
		$date_addeds = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['date_added'];
		if(!empty($date_addeds)){		
			$data['text_date_added'] = $date_addeds;	
		} else{
			$data['text_date_added'] = $this->language->get('text_date_added');
		}
				
		$payment_methods = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['payment_method'];
		if(!empty($payment_methods)){		
			$data['text_payment_method'] = $payment_methods;	
		} else{
			$data['text_payment_method'] = $this->language->get('text_payment_method');
		}
		
				
		$shipping_methods = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['shipping_method'];
		if(!empty($shipping_methods)){		
			$data['text_shipping_method'] = $shipping_methods;	
		} else{
			$data['text_shipping_method'] = $this->language->get('text_shipping_method');
		}
				
		$emails = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['email'];
		if(!empty($emails)){		
			$data['text_email'] = $emails;	
		} else{
			$data['text_email'] = $this->language->get('text_email');
		}
			
		$telephones = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['telephone'];
		if(!empty($telephones)){		
			$data['text_telephone'] = $telephones;	
		} else{
			$data['text_telephone'] = $this->language->get('text_telephone');
		}
			
		$orderstatuss = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['order_status'];
		if(!empty($orderstatuss)){		
			$data['text_orderstatus'] = $orderstatuss;	
		} else{
			$data['text_orderstatus'] = $this->language->get('text_orderstatus');
		}
		
		$payment_addresss = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['payment_address'];
		if(!empty($payment_addresss)){		
			$data['text_payment_address'] = $payment_addresss;	
		} else{
			$data['text_payment_address'] = $this->language->get('text_payment_address');
		}
		
		$shipping_addresss = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['shipping_address'];
		if(!empty($shipping_addresss)){		
			$data['text_shipping_address'] = $shipping_addresss;	
		} else{
			$data['text_shipping_address'] = $this->language->get('text_shipping_address');
		}
		
		$images = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['image'];
		if(!empty($images)){		
			$data['column_image'] = $images;	
		} else{
			$data['column_image'] = $this->language->get('column_image');
		}
		
		$product_names = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['product_name'];
		if(!empty($product_names)){		
			$data['column_name'] = $product_names;	
		} else{
			$data['column_name'] = $this->language->get('column_name');
		}
		
		$models = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['model'];
		if(!empty($models)){		
			$data['column_model'] = $models;	
		} else{
			$data['column_model'] = $this->language->get('column_model');
		}
		
		$skus = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['sku'];
		if(!empty($skus)){		
			$data['column_sku'] = $skus;	
		} else{
			$data['column_sku'] = $this->language->get('column_sku');
		}		
		
		$quantitys = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['quantity'];
		if(!empty($quantitys)){		
			$data['column_quantity'] = $quantitys;	
		} else{
			$data['column_quantity'] = $this->language->get('column_quantity');
		}
		
		$prices = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['price'];
		if(!empty($prices)){		
			$data['column_price'] = $prices;	
		} else{
			$data['column_price'] = $this->language->get('column_price');
		}
		
		$totals = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['total'];
		if(!empty($totals)){		
			$data['column_total'] = $totals;	
		} else{
			$data['column_total'] = $this->language->get('column_total');
		}
		
		
		$invoiceprint = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['printinvoice'];
		if(!empty($invoiceprint)){		
			$data['button_invoice_print'] = $invoiceprint;	
		} else{
			$data['button_invoice_print'] = $this->language->get('button_invoice_print');
		}
		
		$continues = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['continue'];
		if(!empty($continues)){		
			$data['button_continue'] = $continues;	
		} else{
			$data['button_continue'] = $this->language->get('button_continue');
		}
		
		// invoice
		
		$invoice_pages = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['invoice_page'];
		if(!empty($invoice_pages)){		
			$data['text_invoice_no'] = $invoice_pages;	
		} else{
			$data['text_invoice_no'] = $this->language->get('text_invoice_no');
		}
		
		$data['text_history'] = $this->language->get('text_history');
		$data['text_comment'] = $this->language->get('text_comment');
		$data['text_no_results'] = $this->language->get('text_no_results');
		
		
		$data['column_action'] = $this->language->get('column_action');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_status'] = $this->language->get('column_status');
	
		$data['button_cart'] = $this->language->get('button_cart');
			
		
		$this->load->model('checkout/order');
		$this->load->model('account/order');
		$this->load->model('catalog/product');
		$this->load->model('tool/upload');
			
		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}
		if (!empty($order_id)) {
		
		$data['invoice'] = $this->url->link('checkout/ordersuccess/invoice', '&order_id=' . (int)$this->request->get['order_id'], true);	
		$order_info = $this->model_checkout_order->getOrder($order_id);
		 //print_r($order_info); die();
		if ($order_info) {
		
			$data['order_id'] = $this->request->get['order_id'];
			$data['email']    = $order_info['email'];
			$data['telephone']= $order_info['telephone'];
			$data['orderstatusname'] = $order_info['order_status'];
			
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));
			$data['order_id'] = $this->request->get['order_id'];
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));

			if ($order_info['payment_address_format']) {
				$format = $order_info['payment_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname' => $order_info['payment_firstname'],
				'lastname'  => $order_info['payment_lastname'],
				'company'   => $order_info['payment_company'],
				'address_1' => $order_info['payment_address_1'],
				'address_2' => $order_info['payment_address_2'],
				'city'      => $order_info['payment_city'],
				'postcode'  => $order_info['payment_postcode'],
				'zone'      => $order_info['payment_zone'],
				'zone_code' => $order_info['payment_zone_code'],
				'country'   => $order_info['payment_country']
			);

			$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$data['payment_method'] = $order_info['payment_method'];

			if ($order_info['shipping_address_format']) {
				$format = $order_info['shipping_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname' => $order_info['shipping_firstname'],
				'lastname'  => $order_info['shipping_lastname'],
				'company'   => $order_info['shipping_company'],
				'address_1' => $order_info['shipping_address_1'],
				'address_2' => $order_info['shipping_address_2'],
				'city'      => $order_info['shipping_city'],
				'postcode'  => $order_info['shipping_postcode'],
				'zone'      => $order_info['shipping_zone'],
				'zone_code' => $order_info['shipping_zone_code'],
				'country'   => $order_info['shipping_country']
			);

			$data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$data['shipping_method'] = $order_info['shipping_method'];

			$this->load->model('catalog/product');
			$this->load->model('tool/upload');

			// Products
			$relatedproduct = $this->config->get('ordersucess_title');
			if(!empty($relatedproduct)){		
				$data['text_relatedproduct'] = $relatedproduct;	
			} else{
				$data['text_relatedproduct'] = $this->language->get('text_relatedproduct');
			}
			
			$data['text_tax'] = $this->language->get('text_tax');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
		    $data['button_compare'] = $this->language->get('button_compare');
			
			$data['order']['products'] = array();

			$products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);
			
			foreach ($products as $product) {
				$option_data = array();

				$options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

				foreach ($options as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$value = $upload_info['name'];
						} else {
							$value = '';
						}
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				$product_info = $this->model_catalog_product->getProduct($product['product_id']);
			
				$this->load->model('tool/image');				
				
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('ordersucess_proimg_width'), $this->config->get('ordersucess_proimg_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 40,40);
				}
				
				$data['order']['products'][] = array(
					'name'     => $product['name'],
					'sku'      => $product['sku'],
					'image'    => $image,				
					'model'    => $product['model'],
					'option'   => $option_data,
					'quantity' => $product['quantity'],
					'href'        => urlencode($this->url->link('product/product', 'product_id=' . $product['product_id'])),
					'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					
				
				);
			}

			// Voucher
			$data['vouchers'] = array();

			$voucherss = $this->model_account_order->getOrderVouchers($this->request->get['order_id']);

			foreach ($voucherss as $voucher) {
				$data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}

			// Totals
			$data['totals'] = array();
			$totals = $this->model_account_order->getOrderTotals($this->request->get['order_id']);

			foreach ($totals as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
				);
			}
			
			$message='';
			
			$accounttext = $this->config->get('ordersucess_shortcut')[$this->config->get('config_language_id')]['account_lable'];			
			if(!empty($accounttext)){		
				$text_account = $accounttext;	
			} else{
				$text_account = $this->language->get('text_account');
			}
			
			$orderhistory = $this->config->get('ordersucess_shortcut')[$this->config->get('config_language_id')]['order_history'];			
			if(!empty($orderhistory)){		
				$text_orderhistory = $orderhistory;	
			} else{
				$text_orderhistory = $this->language->get('text_orderhistory');
			}
			
			$downloadss = $this->config->get('ordersucess_shortcut')[$this->config->get('config_language_id')]['downloads'];			
			if(!empty($downloadss)){		
				$text_download = $downloadss;	
			} else{
				$text_download = $this->language->get('text_download');
			}
			
			$contactuss = $this->config->get('ordersucess_shortcut')[$this->config->get('config_language_id')]['contactus'];			
			if(!empty($contactuss)){		
				$text_contactus = $contactuss;	
			} else{
				$text_contactus = $this->language->get('text_contactus');
			}
			
			
			$find = array(
				'{order_id}',
				'{firstname}',
				'{lastname}',
				'{account}',
				'{order_history}',
				'{downloads}',
				'{contact_us}'
					
			);
			
			$replace = array(
				'order_id' 	 => $order_info['order_id'],
				'firstname'  => $order_info['payment_firstname'],
				'lastname'   => $order_info['payment_lastname'],
				'account'    => '<a target="_blank" href="'. $this->url->link('account/account') .'"> '. $text_account .'</a>',
				
				'order_history'    =>  '<a target="_blank"" href="'.$this->url->link('account/order').'">'.$text_orderhistory.'</a>',
				'downloads'    =>  '<a target="_blank" href="'.$this->url->link('account/download').'"> '.$text_download.'</a>',
				'contact_us'    =>  '<a target="_blank" href="'.$this->url->link('information/contact').'"> '.$contactuss.'</a>',
				
			);	
			
			if ($this->customer->isLogged()) {
				$message = $this->config->get('ordersucess_reguser')[$this->config->get('config_language_id')]['reguser'];
			if(empty($message)) {
				$message = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', true), $this->url->link('account/order', '', true), $this->url->link('account/download', '', true), $this->url->link('information/contact'));	
			}
			} else {
				$message = $this->config->get('ordersucess_guestuser')[$this->config->get('config_language_id')]['guestuser'];
				if(empty($message))
				{
					$message =  sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));		
				}
			}
			
			//$data['text_message'] = html_entity_decode(str_replace($find, $replace,$message));
			$data['text_message'] = html_entity_decode(str_replace(array("\r\n", "\r", "\n"), '<br/>', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $message)))));	
		}
		
		
		
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$data['relproducts'] = array();
		$orderlimit = 4;	
		
		if (!empty($this->config->get('ordersucess_product'))) {
			$products = array_slice($this->config->get('ordersucess_product'), 0, (int)$orderlimit);
			
			foreach ($products as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {
				
					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], 200,200);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', 200,200);
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

					$data['relproducts'][] = array(
						'product_id'  => $product_info['product_id'],
						'thumb'       => $image,
						'name'        => $product_info['name'],
						'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'tax'         => $tax,
						'rating'      => $rating,
						'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
					);
				}
			}
		}
		
		
		// Products
		
		
		$data['continue'] = $this->url->link('common/home');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
		// Google  tracking ///
		//////   Google: Order sucess conversion  
			
			
			
			$tmdqc_trackingcode = $this->config->get('ordersucess_google_conversion');
			if($tmdqc_trackingcode){
				
			$find = array(
				'{language_code}',
				'{order_total}',
				'{currency_code}',
			);
			
			$replace = array(
			 $this->session->data['language'],
			 $this->cart->getTotal(),
			 $this->session->data['currency'],
			);
			
			$data['tracking'] = str_replace(array("\r\n", "\r", "\n"), '', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '', trim(str_replace($find, $replace, $tmdqc_trackingcode))));
			}
			
		
		// Google tracking ///
		
		$this->response->setOutput($this->load->view('checkout/ordersuccess', $data));
		}
			
		
	}
	
	public function invoice() {
		$this->load->language('checkout/ordersuccess');
		$this->load->model('tool/image');
		$data['title'] = $this->language->get('text_invoice');

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}

		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');
		
		$invoices = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['invoice_page'];
		if(!empty($invoices)){		
			$data['text_invoice'] = $invoices;	
		} else{
			$data['text_invoice'] = $this->language->get('text_invoice');
		}
		
		$invoorder_detail = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['invoorder_details'];
		if(!empty($invoorder_detail)){		
			$data['text_order_detail'] = $invoorder_detail;	
		} else{
			$data['text_order_detail'] = $this->language->get('text_order_detail');
		}
		
		$invoicetelephones = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['invotelephone'];
		if(!empty($invoicetelephones)){		
			$data['text_telephone'] = $invoicetelephones;	
		} else{
			$data['text_telephone'] = $this->language->get('text_telephone');
		}
		
		$invoiceemail = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['invoemail'];
		if(!empty($invoiceemail)){		
			$data['text_email'] = $invoiceemail;	
		} else{
			$data['text_email'] = $this->language->get('text_email');
		}
		
		$invoicedate_added = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['invodate_added'];
		if(!empty($invoicedate_added)){		
			$data['text_date_added'] = $invoicedate_added;	
		} else{
			$data['text_date_added'] = $this->language->get('text_date_added');
		}
		
		$invoice_order_id = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['invoorder_id'];
		if(!empty($invoice_order_id)){		
			$data['text_order_id'] = $invoice_order_id;	
		} else{
			$data['text_order_id'] = $this->language->get('text_order_id');
		}
		
		$payment_addresss = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['payment_address'];
		if(!empty($payment_addresss)){		
			$data['text_payment_address'] = $payment_addresss;	
		} else{
			$data['text_payment_address'] = $this->language->get('text_payment_address');
		}
		
		$shipping_addresss = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['shipping_address'];
		if(!empty($shipping_addresss)){		
			$data['text_shipping_address'] = $shipping_addresss;	
		} else{
			$data['text_shipping_address'] = $this->language->get('text_shipping_address');
		}
		
		$invoice_payment_method = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['invopayment_method'];
		if(!empty($invoice_payment_method)){		
			$data['text_payment_method'] = $invoice_payment_method;	
		} else{
			$data['text_payment_method'] = $this->language->get('text_payment_method');
		}
		
		
		$invoice_shipping_method = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['invoshipping_method'];
		if(!empty($invoice_shipping_method)){		
			$data['text_shipping_method'] = $invoice_shipping_method;	
		} else{
			$data['text_shipping_method'] = $this->language->get('text_shipping_method');
		}
		
		
		$invo_image = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['invoimage'];
		if(!empty($invo_image)){		
			$data['column_image'] = $invo_image;	
		} else{
			$data['column_image'] = $this->language->get('column_image');
		}		
		
		$invo_name = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['invoproduct_name'];
		if(!empty($invo_name)){		
			$data['column_name'] = $invo_name;	
		} else{
			$data['column_name'] = $this->language->get('column_name');
		}		
		
		$invo_model = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['invomodel'];
		if(!empty($invo_model)){		
			$data['column_model'] = $invo_model;	
		} else{
			$data['column_model'] = $this->language->get('column_model');
		}	
		
		$invo_sku = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['invosku'];
		if(!empty($invo_sku)){		
			$data['column_sku'] = $invo_sku;	
		} else{
			$data['column_sku'] = $this->language->get('column_sku');
		}
		
		$invo_quantity = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['invoquantity'];
		if(!empty($invo_quantity)){		
			$data['column_quantity'] = $invo_quantity;	
		} else{
			$data['column_quantity'] = $this->language->get('column_quantity');
		}
		
		$invo_price = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['invoprice'];
		if(!empty($invo_price)){		
			$data['column_price'] = $invo_price;	
		} else{
			$data['column_price'] = $this->language->get('column_price');
		}
		
		$invo_total = $this->config->get('ordersucess_language')[$this->config->get('config_language_id')]['invototal'];
		if(!empty($invo_total)){		
			$data['column_total'] = $invo_total;	
		} else{
			$data['column_total'] = $this->language->get('column_total');
		}
		
		$data['text_invoice_no'] = $this->language->get('text_invoice_no');
		$data['text_invoice_date'] = $this->language->get('text_invoice_date');
	
		
		
		$data['text_fax']   = $this->language->get('text_fax');
		
		$data['text_website'] = $this->language->get('text_website');
		
		
		$data['text_comment'] = $this->language->get('text_comment');
		

		$data['column_product'] = $this->language->get('column_product');
		
		$data['orderinvoice'] = $this->config->get('ordersucess_ordinvoc');
		$data['printinvoice'] = $this->config->get('ordersucess_printinvoice_status') ;
		$data['orderdetail']  = $this->config->get('ordersucess_orderdetail') ;
		$data['paymentaddress'] = $this->config->get('ordersucess_paymentadres');
		$data['shippingaddress'] = $this->config->get('ordersucess_shippingaddress');
		
		$data['titlebgcolor'] = $this->config->get('ordersucess_titlebgcolor');
		$data['titlecolor'] = $this->config->get('ordersucess_titlecolor');
		$data['showimage'] = $this->config->get('ordersucess_showimage');
		$data['productname'] = $this->config->get('ordersucess_productname');
		$data['productmodel'] = $this->config->get('ordersucess_model');
		$data['productsku'] = $this->config->get('ordersucess_sku');
		$data['productqty'] = $this->config->get('ordersucess_quantity');
		$data['productunitprice'] = $this->config->get('ordersucess_unitprice');
		$data['producttotal'] = $this->config->get('ordersucess_total');
		$this->load->model('checkout/order');
		$this->load->model('account/order');

		$this->load->model('setting/setting');

		$data['orders'] = array();

		$orders = array();

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
		}

		foreach ($orders as $order_id) {
			$order_info = $this->model_checkout_order->getOrder($order_id);

			if ($order_info) {
				$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

				if ($store_info) {
					$store_address = $store_info['config_address'];
					$store_email = $store_info['config_email'];
					$store_telephone = $store_info['config_telephone'];
					$store_fax = $store_info['config_fax'];
				} else {
					$store_address = $this->config->get('config_address');
					$store_email = $this->config->get('config_email');
					$store_telephone = $this->config->get('config_telephone');
					$store_fax = $this->config->get('config_fax');
				}

				if ($order_info['invoice_no']) {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}

				if ($order_info['payment_address_format']) {
					$format = $order_info['payment_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['payment_firstname'],
					'lastname'  => $order_info['payment_lastname'],
					'company'   => $order_info['payment_company'],
					'address_1' => $order_info['payment_address_1'],
					'address_2' => $order_info['payment_address_2'],
					'city'      => $order_info['payment_city'],
					'postcode'  => $order_info['payment_postcode'],
					'zone'      => $order_info['payment_zone'],
					'zone_code' => $order_info['payment_zone_code'],
					'country'   => $order_info['payment_country']
				);

				$payment_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['shipping_firstname'],
					'lastname'  => $order_info['shipping_lastname'],
					'company'   => $order_info['shipping_company'],
					'address_1' => $order_info['shipping_address_1'],
					'address_2' => $order_info['shipping_address_2'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);

				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				$this->load->model('tool/upload');

				$product_data = array();

				$products = $this->model_account_order->getOrderProducts($order_id);
				//print_r($products); die();
				foreach ($products as $product) {
					$option_data = array();

					$options = $this->model_account_order->getOrderOptions($order_id, $product['order_product_id']);

					foreach ($options as $option) {
						if ($option['type'] != 'file') {
							$value = $option['value'];
						} else {
							$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

							if ($upload_info) {
								$value = $upload_info['name'];
							} else {
								$value = '';
							}
						}

						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $value
						);
					}
					
					if ($product['image']) {
					$image = $this->model_tool_image->resize($product['image'], 40, 40);
					} else {
					$image = $this->model_tool_image->resize('placeholder.png', 40,40);
					}

				
					if (is_file(DIR_IMAGE . $product['image'])) {
					$image = $this->model_tool_image->resize($product['image'], 40, 40);
					} else {
						$image = $this->model_tool_image->resize('no_image.png', 40, 40);
					}
			

					$product_data[] = array(
						'name'     => $product['name'],
						'sku'      => $product['sku'],
						'image'    => $image,
						'model'    => $product['model'],
						'option'   => $option_data,
						'quantity' => $product['quantity'],
						'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				$voucher_data = array();

				$vouchers = $this->model_account_order->getOrderVouchers($order_id);

				foreach ($vouchers as $voucher) {
					$voucher_data[] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				$total_data = array();

				$totals = $this->model_account_order->getOrderTotals($order_id);

				foreach ($totals as $total) {
					$total_data[] = array(
						'title' => $total['title'],
						'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				$data['orders'][] = array(
					'order_id'	       => $order_id,
					'invoice_no'       => $invoice_no,
					'date_added'       => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
					'store_name'       => $order_info['store_name'],
					'store_url'        => rtrim($order_info['store_url'], '/'),
					'store_address'    => nl2br($store_address),
					'store_email'      => $store_email,
					'store_telephone'  => $store_telephone,
					'store_fax'        => $store_fax,
					'email'            => $order_info['email'],
					'telephone'        => $order_info['telephone'],
					'shipping_address' => $shipping_address,
					'shipping_method'  => $order_info['shipping_method'],
					'payment_address'  => $payment_address,
					'payment_method'   => $order_info['payment_method'],
					'product'          => $product_data,
					'voucher'          => $voucher_data,
					'total'            => $total_data,
					'comment'          => nl2br($order_info['comment'])
				);
			}
		}
		
		

		$this->response->setOutput($this->load->view('checkout/order_invoice', $data));
	}
	
	
}