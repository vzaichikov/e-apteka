<?php
	class ControllerExtensionModuleHTML extends Controller {
		public function index($setting) {
			
			if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
			
			
				if (isset($this->request->get['route']) && $this->request->get['route'] == 'product/product' && !empty($this->request->get['product_id'])){
					$this->load->model('catalog/product');
					$product = $this->model_catalog_product->getProduct($this->request->get['product_id']);
					
				//	$drugQuery = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$this->request->get['product_id'] . "' AND category_id IN (SELECT category_id FROM " . DB_PREFIX . "category_path WHERE path_id = 169)");
					
					
					if ($product['no_shipping'] || $product['no_payment']){
						if (!strpos($setting['name'], 'рецепт')){
							return '';
						}						
					} else {
						if (strpos($setting['name'], 'рецепт')){
							return '';
						}
					}

				}
			
				$data['heading_title'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['title'], ENT_QUOTES, 'UTF-8');
				$data['html'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['description'], ENT_QUOTES, 'UTF-8');
			}
			
			if (isset($this->request->get['route']) && $this->request->get['route'] == 'common/home'){
				
				return $this->load->view('extension/module/html_home', $data);
				
				} else {
				
				return $this->load->view('extension/module/html', $data);
				
			}
			
		}
	}
