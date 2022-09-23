<?php
	class ControllerExtensionModuleFeatured extends Controller {
		public function index($setting) {
            $this->load->language('extension/module/featured');
			
            $data['heading_title'] = $this->language->get('heading_title');
			
            if(isset($setting['name']) AND !empty($setting['name'])){
                $data['heading_title'] = $setting['name'];
			}
			
			if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
				$data['heading_title'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['title'], ENT_QUOTES, 'UTF-8');
				$data['html'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['description'], ENT_QUOTES, 'UTF-8');
			}
			
            if(isset($setting['icon'])){
                $data['icon'] = $setting['icon'];
				}else{
                $data['icon'] = '';
			}
			
            $data['text_tax'] = $this->language->get('text_tax');
			
            $data['button_cart'] = $this->language->get('button_cart');
            $data['button_wishlist'] = $this->language->get('button_wishlist');
            $data['button_compare'] = $this->language->get('button_compare');
			
            $this->load->model('catalog/product');
			
            $this->load->model('tool/image');
			
            $data['products'] = array();
			
            if (!$setting['limit']) {
                $setting['limit'] = 4;
			}
			
            if (!empty($setting['product'])) {
                $products = array_slice($setting['product'], 0, (int)$setting['limit']);
				
                foreach ($products as $product_id) {
                    $product_info = $this->model_catalog_product->getProduct($product_id);
					
                    if ($product_info && $product_info['price'] > 0) {
                        if ($product_info['image']) {
                            $image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
							} else {
                            $image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
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
						
                        if ($this->config->get('config_review_status') AND $product_info['rating'] > 0) {
                            $rating = $product_info['rating'];
							} else {
                            $rating = 5;
						}
						
                        $data['products'][] = array(
						'product_id'  => $product_info['product_id'],
						'seo'  => '', //$product_info['seo'],
						'quantity'    => $product_info['quantity'],
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
			
            if ($data['products']) {
                $return = $this->load->view('extension/module/featured', $data);
                return $return;
			}
		}
	}
