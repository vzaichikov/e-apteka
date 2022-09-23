<?php
	class ControllerEaptekaImageSearch extends Controller {
		private $QwantImageSearch;
		
		
		
		public function index(){
			
			
			
		}
		
		private function normalizeName($name){
			
			$name = URLify::transliterate(URLify::rms($name));
			$name = str_replace('-','_',$name);
			$name = trim($name);
			
			return $name;
		}
		
		public function updateProductImage(){
			$product_id = (int)$this->request->post['product_id'];
			$media = $this->request->post['media'];
			
			
			$media_md5 = md5($media);
			
			$ext = pathinfo($media, PATHINFO_EXTENSION);
			
			$allowed = array(
				'jpg',
				'jpeg',
				'png',
				'gif'			
			);
			
			if (!in_array($ext, $allowed)){
				throw new \Exception('EXT NOT SUPPORTED');
			}
			
			$image = file_get_contents($media);
			
			if ($image){
				
				$path = $media_md5[0] . '/' . $media_md5[1] . '/' . $product_id;
				
				$fake_dir = 'catalog/product/'. $path . '/';
				$real_dir = DIR_IMAGE .'catalog/product/'. $path . '/';
				
				if (!is_dir($real_dir)){
					mkdir($real_dir, 0755, true);
				}
								
				$fname = pathinfo($media, PATHINFO_BASENAME);
				$this->load->model('catalog/product');
				$product_info = $this->model_catalog_product->getProduct($product_id);			
				$filename = $this->normalizeName($product_info['name']) . '.' . $ext;
				
				$fake_image = $fake_dir . '' . $filename;
				
				file_put_contents($real_dir . $filename, $image);
				
				$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($fake_image) . "' WHERE product_id = '" . (int)$product_id . "'");
				
				$this->load->model('tool/image');
				
				$json['success'] = 'success';
				$json['thumb'] = $this->model_tool_image->resize($fake_image, 100, 100);
				$json['image'] = $fake_image;
				
				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($json));
				
			}
		}
		
		
		public function getQwantImages(){
			$this->load->library('hobotix/QwantImageSearch');
			$this->QwantImageSearch = new hobotix\QwantImageSearch;
			
			$this->load->model('catalog/product');
			
			$json = array();
			
			if (isset($this->request->post['searchtext'])){
				/*
					$product_id = (int)$this->request->post['product_id'];
					$product_info = $this->model_catalog_product->getProduct($product_id);
				*/
				
				$data = array(
				'query' => $this->request->post['searchtext']
				);
				
				try {
					$json = $this->QwantImageSearch->searchForImage($data);
				} catch (Exception $e) {

						$json['explanation'] = $e->getMessage();

				}
				
				$this->response->setOutput($this->load->view('extension/module/imagesearch', $json));
				
				} else {
				
				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($json));
				
			}
			
			
			
			
		}
		
		
		
		
		
		
		
		
		
		
	}	