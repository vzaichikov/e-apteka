<?php 
class ControllerExtensionModulePopupCart extends Controller {

	public function ecommerceCheckoutSteps(){
		$this->load->model('catalog/product');
		$this->load->model('extension/module/popupcart');
		$this->load->model('tool/image');
		$this->load->model('tool/upload');
		
		$allowedEvents = array(
			'PopupCartOpened' => 1,
			'checkoutPageOpened' => 2
		);

		
		if (!empty($this->request->get['ecommerceEvent']) && isset($allowedEvents[$this->request->get['ecommerceEvent']])){
			$data['ecommerceEvent'] = $this->request->get['ecommerceEvent'];
			$data['ecommerceStep'] = $allowedEvents[$this->request->get['ecommerceEvent']];
		} else {
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
			$this->response->setOutput('');
		}

		$data['products'] = array();
		
		$products = array_reverse($this->cart->getProducts());

		foreach ($products as $product) {
			$real_product = $this->model_catalog_product->getProduct($product['product_id']);
		
			if ($product['image']) {
				$image = $this->model_tool_image->resize($product['image'], 140, 140);
			} else {
				$image = '';
			}

			$option_data = array();

			foreach ($product['option'] as $option) {
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
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value),
					'type'  => $option['type']
				);
			}

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $currency);
			} else {
				$price = false;
			}

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'], $currency);
			} else {
				$total = false;
			}

			$data['products'][] = array(
				'key'       	=> $product['cart_id'],
				'id'       		=> $product['product_id'],
				'ecommerceData' => $real_product['ecommerceData'],
				'thumb'     	=> $image,
				'name'      	=> $product['name'],
				'model'     	=> $product['model'],
				'option'   		=> $option_data,
				'recurring'		=> ($product['recurring'] ? $product['recurring']['name'] : ''),
				'manufacturer'	=> $product['manufacturer'],
				'quantity'  	=> $product['quantity'],
				'stock'   	 	=> $this->config->get('config_stock_checkout'),
				'minimum'    	=> $product['minimum'],
				'maximum'    	=> $product['maximum'],
				'price'     	=> $price,
				'total'     	=> $total,
				'href'      	=> $this->url->link('product/product', 'product_id=' . $product['product_id'], true)
			);				
		}
		
		
		
		$this->response->setOutput($this->load->view('structured/ecommerce_checkout', $data));
		
		
		
	}

	public function index() {
		$this->load->language('common/cart');
		$this->language->load('extension/module/popupcart');
		
		$this->load->model('extension/module/popupcart');
		
		$settings = $this->config->get('popupcart');
		$language_id = $this->config->get('config_language_id');
		
		$data['click_on_cart'] = isset($settings['click_on_cart']) ? true : false;
		$data['addtocart_logic'] = isset($settings['addtocart_logic']) ? true : false;
		$data['related'] = isset($settings['related_show']) ? true : false;
		$data['button_shopping_show'] = isset($settings['button_shopping_show']) ? true : false;
		$data['button_cart_show'] = isset($settings['button_cart_show']) ? true : false;
		$data['manufacturer_show'] = isset($settings['manufacturer_show']) ? true : false;
		$data['button_incart_logic'] = isset($settings['button_incart_logic']) ? true : false;
		
		$data['head'] = $settings['module_head'][$language_id];
		$data['button_shopping'] = $settings['button_shopping'][$language_id];
		$data['button_cart'] = $settings['button_cart'][$language_id];
		$data['button_checkout'] = $settings['button_checkout'][$language_id];
		$data['button_incart'] = $settings['button_incart'][$language_id];
		$data['button_incart_with_options'] = $settings['button_incart_with_options'][$language_id];
		$data['text_related'] = $settings['related_heading'][$language_id];
		
		$data['button_cart_default'] = $this->language->get('button_cart');
		$data['text_foto'] = $this->language->get('text_foto');
		$data['text_name'] = $this->language->get('text_name');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_quantity'] = $this->language->get('text_quantity');
		$data['text_price'] = $this->language->get('text_price');
		$data['text_total'] = $this->language->get('text_total');
		
		$data['in_stock'] = $this->language->get('text_in_stock');
		$data['left'] = $this->language->get('text_left');
		$data['left1'] = $this->language->get('text_left1');
		$data['just'] = $this->language->get('text_just');
		$data['pcs'] = $this->language->get('text_pcs');	
	/*	
		if (file_exists('catalog/view/theme/'.$this->config->get($this->config->get('config_theme') . '_directory').'/stylesheet/popupcart.css')) {
			$this->document->addStyle('catalog/view/theme/'.$this->config->get($this->config->get('config_theme') . '_directory').'/stylesheet/popupcart.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/popupcart.css');		
		}
		
		$this->document->addScript('catalog/view/javascript/popupcart.js');
	*/


		// Totals
		$this->load->model('extension/extension');

		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();
		
		if(VERSION >= 2.2) {
			$total_data = array(
				'totals' => &$totals,
				'taxes'  => &$taxes,
				'total'  => &$total
			);
		}
		
		$currency = $this->session->data['currency'];

		if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
			$sort_order = array();

			$results = $this->model_extension_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('extension/total/' . $result['code']);
					$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
				}
			}

			$sort_order = array();

			foreach ($totals as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $totals);
		}
		
		$data['totals'] = array();

		foreach ($totals as $total) {
			$data['totals'][] = array(
				'title' => $total['title'],
				'text'  => $this->currency->format($total['value'], $this->session->data['currency'])
			);
		}
		
		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_cart'] = $this->language->get('text_cart');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_recurring'] = $this->language->get('text_recurring');
		$data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $currency));
		$data['text_loading'] = $this->language->get('text_loading');

		$data['button_remove'] = $this->language->get('button_remove');
		
		$this->load->model('catalog/product');
		$this->load->model('extension/module/popupcart');
		$this->load->model('tool/image');
		$this->load->model('tool/upload');

		$data['products'] = array();
		
		$products = array_reverse($this->cart->getProducts());

		foreach ($products as $product) {
			$real_product = $this->model_catalog_product->getProduct($product['product_id']);
		
			if ($product['image']) {
				$image = $this->model_tool_image->resize($product['image'], 140, 140);
			} else {
				$image = '';
			}					

			$option_data = array();

			foreach ($product['option'] as $option) {
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
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value),
					'type'  => $option['type']
				);
			}

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $currency);
			} else {
				$price = false;
			}

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'], $currency);
			} else {
				$total = false;
			}

			$data['products'][] = array(
				'key'       	=> $product['cart_id'],
				'id'       		=> $product['product_id'],
				'ecommerceData' => $real_product['ecommerceData'],
				'thumb'     	=> $image,
				'name'      	=> $product['name'],
				'model'     	=> $product['model'],
				'option'   		=> $option_data,
				'recurring'		=> ($product['recurring'] ? $product['recurring']['name'] : ''),
				'manufacturer'	=> $product['manufacturer'],
				'quantity'  	=> $product['quantity'],
				'stock'   	 	=> $this->config->get('config_stock_checkout'),
				'minimum'    	=> $product['minimum'],
				'maximum'    	=> $product['maximum'],
				'price'     	=> $price,
				'total'     	=> $total,
				'href'      	=> $this->url->link('product/product', 'product_id=' . $product['product_id'], true)
			);				
		}

		$data['vouchers'] = array();

		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $key => $voucher) {
				$data['vouchers'][] = array(
					'key'         => $key,
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'])
				);
			}
		}
		
		$data['products_related'] = isset($settings['related_show']) ? $this->products_related() : array();

		$data['cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
	
		$this->response->setOutput($this->load->view('extension/module/popupcart', $data));
	}
	
	private function products_related() {
		$this->load->model('catalog/product');
		$this->load->model('extension/module/popupcart');
		$this->load->model('tool/image');
		$this->load->model('tool/upload');
		
		$products_data = array();
		
		$currency = $this->session->data['currency'];
	
		if($this->cart->getProducts()) {
			$results = array();
			$in_cart = array();
			
			$settings = $this->config->get('popupcart');
		
			foreach($this->cart->getProducts() as $result) {			
				if (isset($settings['related_product1'])) {
					$result1 = $this->model_extension_module_popupcart->getRelated($result['product_id']);
					foreach($result1 as $res1) {
						$results[] = $res1;
					}
				} 
				if (isset($settings['related_product2'])) {
					$result2 = $this->model_extension_module_popupcart->getRelated2($result['product_id']);
					foreach($result2 as $res2) {
						$results[] = $res2;
					}
				}
				$in_cart[] = $result['product_id'];
			}
			
			$products = array_unique(array_diff($results, $in_cart));
			
			foreach ($products as $product_id) {
				$result = $this->model_catalog_product->getProduct($product_id);
			
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], 100, 100);
				} else {
					$image = false;
				}
				
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $currency);
				} else {
					$price = false;
				}
						
				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $currency);
				} else {
					$special = false;
				}
				
				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
							
				$products_data[] = array(
					'product_id' => $result['product_id'],
					'thumb'   	 => $image,
					'name'    	 => $result['name'],
					'price'   	 => $price,
					'special' 	 => $special,
					'rating'     => $rating,
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}
			
			return $products_data;
		}
	}
}