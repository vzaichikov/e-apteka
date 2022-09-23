<?php
	class ControllerApiProduct extends Controller {
			
		public function getProductFullInformation(){
			
			
			
			
			
			
			
			
			
			
			
			
			
		}
		
		public function getProductURL(){
			
			$json = array();
			
			if (!isset($this->session->data['api_id'])) {
				$json['error'] = $this->language->get('error_permission');
				} else {
				
				$this->load->model('catalog/product');				
				
				if (!isset($this->request->post['uuids'])){
					$json['error'] = 'ERROR_NO_UUIDS';
					} elseif (!json_decode(normalize1CInput($this->request->post['uuids']))){
					$json['error'] = 'ERROR_JSON_DECODE';
					} elseif (!count(json_decode(normalize1CInput($this->request->post['uuids'])))){
					$json['error'] = 'ERROR_JSON_EMPTY_ARRAY';
				}
				
				
				if (!isset($json['error'])){
					
					$json['success'] = 'SUCCESS';
					$json['results'] = array();
					$_uuids = json_decode(normalize1CInput($this->request->post['uuids']));
					
					foreach ($_uuids as $uuid){
						
						if ($product_id = $this->model_catalog_product->getProductIDByUUID($uuid)) {						
							$json['results'][$uuid] = $this->url->link('product/product', 'product_id=' . $product_id);
							} else {
							$json['results'][$uuid] = 'ERROR_PRODUCT_NOT_FOUND';
						}						
					}					
				}																			
			}
			
			
			if (isset($this->request->server['HTTP_ORIGIN'])) {
				$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
				$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
				$this->response->addHeader('Access-Control-Max-Age: 1000');
				$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
			}
			
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));			
		}
		
		
		public function getProductImage(){
			
			$this->load->model('catalog/product');	
			$this->load->model('tool/image');
			
			$json = array();	
			
			if (!isset($this->session->data['api_id'])) {
				$json['error'] = $this->language->get('error_permission');
				} else {
				
				if (!isset($this->request->post['uuids'])){
					$json['error'] = 'ERROR_NO_UUIDS';
					} elseif (!json_decode(normalize1CInput($this->request->post['uuids']))){
					$json['error'] = 'ERROR_JSON_DECODE';
					} elseif (!count(json_decode(normalize1CInput($this->request->post['uuids'])))){
					$json['error'] = 'ERROR_JSON_EMPTY_ARRAY';
				}
				
				if (!isset($json['error'])){
					
					$json['success'] = 'SUCCESS';
					$json['results'] = array();
					$_uuids = json_decode(normalize1CInput($this->request->post['uuids']));
					
					
					
					foreach ($_uuids as $uuid){
						
						if ($product = $this->model_catalog_product->getProductByUUID($uuid)) {
							
							if ($product['image']){
								
								if (file_exists(DIR_IMAGE . $product['image'])) {
									
									$json['results'][$uuid] = array(
										'original' => $this->config->get('config_url') . 'image/' . $product['image'],
										'resized'  => $this->model_tool_image->resize($product['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'))								
									);								
									
									} else {
									
									$json['results'][$uuid] = 'ERROR_IMAGE_FILE_NOT_EXISTS';
									
								}
								
								} else {
								$json['results'][$uuid] = 'ERROR_IMAGE_EMPTY';
							}
							
							
							} else {
							
							$json['results'][$uuid] = 'ERROR_PRODUCT_NOT_FOUND';
							
						}						
					}					
				}				
			}
			
			if (isset($this->request->server['HTTP_ORIGIN'])) {
				$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
				$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
				$this->response->addHeader('Access-Control-Max-Age: 1000');
				$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
			}
			
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
			
		}
	}				