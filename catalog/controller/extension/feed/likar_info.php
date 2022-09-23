<?php
	class ControllerExtensionFeedLikarInfo extends Controller {
		public function index() {
			if ($this->config->get('likar_info_status')) {
				$output  = '<?xml version="1.0" encoding="UTF-8"?>';		
				
				$this->load->model('catalog/product');
				$this->load->model('tool/image');
				
				
				$data = 
				$products = $this->model_catalog_product->getProducts();
				
				$output .= '<itemset>';
				
				foreach ($products as $product) {
					$do = true;
					
					$price = $product['price'];
					if ($product['special']){
						$price = $product['special'];
					}
					
					if ($this->config->get('likar_info_nullprice')) {
						$do = true;
					} else {
						$do = ($price > 0);
					}
					
					if ($this->config->get('likar_info_nullquantity')) {
						$do = $do;
					} else {
						$do = $do && ($product['quantity'] > 0);
					}
					
					if ($do) {
						
						$output .= '<item>';
						$output .= '<url>' . $this->url->link('product/product', 'product_id=' . $product['product_id']) . '</url>';
						$output .= '<price>' . number_format($price, 2) . '</price>';
						$output .= '<title>' . $this->normalize(htmlentities($product['name'])) . '</title>';
						$output .= '<vendor>' . $this->normalize(htmlentities($product['manufacturer'])) . '</vendor>';
						$output .= '<unit>' . htmlentities($this->guessUnit($product['name'])) . '</unit>';
						$output .= '<quantity>' . $product['quantity'] . '</quantity>';
						$output .= '<sale>0</sale>';
						$output .= '<country>0</country>';
						$output .= '</item>';
						
					}
				}
				
				
				$output .= '</itemset>';
				
				$this->response->addHeader('Content-Type: application/xml');
				$this->response->addHeader('Last-Modified: ' . date('r'));
				$this->response->setOutput($output);
			}
		}
		
		private function normalize($st){
					
			$st = str_replace('&Auml;','Ä',$st);
			$st = str_replace('&auml;','ä',$st);
			$st = str_replace('&Uuml;','Ü',$st);
			$st = str_replace('&uuml;','ü',$st);
			$st = str_replace('&Ouml;','Ö',$st);
			$st = str_replace('&ouml;','ö',$st);
			$st = str_replace('&szlig;','ß',$st);
			$st = str_replace('&Oslash;','Ø',$st);
			$st = str_replace('&rdquo;','',$st);
			$st = str_replace('&ldquo;','',$st);
			$st = str_replace('&lsquo;','',$st);
			$st = str_replace('&rsquo;','',$st);
			$st = str_replace('&laquo;','',$st);
			$st = str_replace('&raquo;','',$st);
			$st = str_replace('&deg;','',$st);
			
			return $st;
		}
		
		private function guessUnit($name){
			
			$substr_array = array(
			'флакон' => 'фл',
			' фл '   => 'фл',
			' амп '  => 'амп',
			);
			
			
			foreach ($substr_array as $search => $unit){
				if (strpos($name, $search)){
					return $unit;
				}
			}
			
			return 'шт';
			
			}
		}			