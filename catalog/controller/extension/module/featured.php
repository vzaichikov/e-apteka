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
                       $results[$product_id] = $product_info;
					}
				}

				  $data['products'] = $this->model_catalog_product->prepareProductArray($results);
				
			}
			
            if ($data['products']) {
                $return = $this->load->view('extension/module/featured', $data);
                return $return;
			}
		}
	}
