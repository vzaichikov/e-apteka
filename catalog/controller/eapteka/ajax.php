<?php
	class ControllerEaptekaAjax extends Controller {
		
		public function index(){			
			if (empty($this->request->get['modpath'])){
				$this->response->setOutput('');
				} else {
				$data = [];
				if (!empty($this->request->get['group'])){
					$exploded = explode(';', $this->request->get['modpath']);
					foreach ($exploded as $line){
						if (trim($line)){
							
							try{
								
								$data[] = [
								'path' 	=> $line,
								'html'	=> $this->load->controller($line)
								];
								
								} catch (Exception $e){
							}
							
						}
					}		
					
					return $this->load->view('structured/module', $data);
					
					} else {
					try{				
						$data['data'] = $this->load->controller($this->request->get['modpath']);
						} catch (Exception $e){
						$data['data'] = '';
					}				
					return $this->load->view('structured/module', $data);	
					
				}				
			}
		}

		public function mhttest(){
			$this->load->library('hobotix/MHTParser');

			$file = DIR_INSTRUCTIONS . '8b/a8/8ba8f8815d9b2e5006514d79b1776208.mht';

			$MHTParser = new \hobotix\MHTParser($file);
			$MHTParser->parse();
			if ($html = $MHTParser->get_html()){
				
				$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
				$mpdf->WriteHTML($html);
				$mpdf->Output('output.pdf', \Mpdf\Output\Destination::INLINE);
			}

		}

		public function downloadinstruction(){
			$this->load->model('catalog/product');		
			
			$product_id = false;
			if (isset($this->request->get['x'])) {
				$product_id = (int)$this->request->get['x'];
			}

			$filepath 	= '';
			$extension 	= '';
			if (isset($this->request->get['dpath'])) {
				$filepath 	= base64_decode($this->request->get['dpath']);
				$filepath 	= str_ireplace('../', '', $filepath);
				$extension 	= pathinfo($filepath, PATHINFO_EXTENSION);
			}			

			$product_info = $this->model_catalog_product->getProduct($product_id);

			if (!$product_id || !$filepath || !$extension || !$product_info || !file_exists(DIR_INSTRUCTIONS . $filepath)){
				header('HTTP/1.0 404 Not Found');
				exit();
			} else {
				$outfile = rawurlencode('Інструкція до ' . str_replace(['.'], ['_'], $product_info['name']) . '-E-APTEKA.COM.UA.pdf');

				if ($extension == 'pdf'){

					header('Content-Type: application/pdf');
					header('X-Instruction: from-likreestr');				
					header('Cache-Control: public, max-age=0');
					readfile(DIR_INSTRUCTIONS . $filepath);

				} elseif ($extension == 'html'){
					if (file_exists(DIR_INSTRUCTIONS . str_ireplace('.html', '.pdf', $filepath))){

						header('Content-Type: application/pdf');						
						header('X-Instruction: from-file');				
						header('Cache-Control: public, max-age=0');
						readfile(DIR_INSTRUCTIONS . str_ireplace('.html', '.pdf', $filepath));

					} else {
						try{

							header('X-Instruction: from-mpdf');
							$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
							$mpdf->WriteHTML(file_get_contents(DIR_INSTRUCTIONS . $filepath));
							$mpdf->Output($outfile, \Mpdf\Output\Destination::INLINE);

						} catch (\Mpdf\MpdfException $e){
							header('HTTP/1.0 500 Server Creating PDF Error');
							echo('Error downloading PDF, sorry ' . $e->getMessage());
						}
					}
				}			
			}
		}
		

		public function instruction() {
			$this->load->language('product/product');
			$this->load->model('catalog/product');		
			
			if (isset($this->request->get['x'])) {
				$product_id = (int)$this->request->get['x'];
				} else {
				$product_id = 0;
			}
			
			$ajaxrequest = (!empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
			
			if (!$ajaxrequest){
				$this->response->redirect($this->url->link('product/product', 'product_id=' . $product_id), 301);	
			}							

			if ($instruction = $this->model_catalog_product->getProductInstruction($product_id)){		

				if ($instruction['from'] == 'db'){

					$data['type']		 = 'inline';
					$data['instruction'] = html_entity_decode($instruction['instruction'], ENT_QUOTES, 'UTF-8');

				} elseif ($instruction['from'] == 'file'){

					if ($instruction['type'] == 'pdf'){
						$data['type']		 = 'embed';
						$data['extension']	 = 'pdf';
						$data['instruction'] = HTTPS_IMG_SERVER . 'instruction/' . $instruction['instruction'];
					}

					if ($instruction['type'] == 'html'){
						$data['type']		 = 'inline';
						$data['extension']	 = 'html';
						$data['instruction'] = html_entity_decode($instruction['instruction'], ENT_QUOTES, 'UTF-8');
					}
				}			

			} else {
				$data['instruction'] = '';
			}						
			
			$this->response->setOutput($this->load->view('product/structured/instruction', $data));			
		}	

		public function likreestr() {
			$this->load->language('product/product');
			$this->load->model('catalog/product');		
			
			if (isset($this->request->get['x'])) {
				$product_id = (int)$this->request->get['x'];
				} else {
				$product_id = 0;
			}
			
			$ajaxrequest = (!empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
			
			if (!$ajaxrequest){
				$this->response->redirect($this->url->link('product/product', 'product_id=' . $product_id), 301);	
			}							

			$likreestr = $this->model_catalog_product->getProductLikReestr($product_id);
			$data['likreestr'] = json_decode($likreestr)?json_decode($likreestr, true):false;
			
			$this->response->setOutput($this->load->view('product/structured/likreestr', $data));			
		}	
		
	}
