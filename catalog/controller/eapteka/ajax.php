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

		public function stocks(){
			$this->load->model('catalog/product');		
			$this->load->model('localisation/location');

			$this->load->language('product/product');

			if (isset($this->request->get['x'])) {
				$product_id = (int)$this->request->get['x'];
			} else {
				$product_id = 0;
			}

			$results = $this->model_catalog_product->getProductStocks($product_id);
			$multilang_fields = array(
				'open',
				'address',
				'name',
				'comment'		
			);

			$data['text_is_in_stock_in_drugstores'] = $this->language->get('text_is_in_stock_in_drugstores');
			$data['text_make_route'] 				= $this->language->get('text_make_route');
			$data['text_make_reserve'] 				= $this->language->get('text_make_reserve');

			$data['text_we_work_while_no_light'] 	= $this->language->get('text_we_work_while_no_light');
			$data['text_we_can_deliver_in_2_days'] 	= $this->language->get('text_we_can_deliver_in_2_days');
			$data['text_we_can_deliver_in_4_days'] 	= $this->language->get('text_we_can_deliver_in_4_days');

			foreach ($results as $result) {

				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], 100, 100);
				} else {
					$image = false;
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				$open = '';
				$mcolor = 'red';
				$is_open_now = false;					
				if ($result['open_struct']){
					date_default_timezone_set('Europe/Kiev');

					$_r = trim($result['open_struct']);

					if ($_r == '∞'){
						$open = $this->language->get('text_open_alltime');
						$open_text = $this->language->get('text_open_alltime');
						$is_open_now = true;
					} else {
						$a = explode(PHP_EOL, $result['open_struct']);													
						$d = array();
						foreach ($a as $k => &$v){
							$v = trim($v);
							$c = explode('/', $v);
							$z = explode('-', $c[1]);
							$d[$c[0]] = array(
								's' => $z[0],
								'f' => $z[1]								
							);
						}

						$day = date('N');
						$nday = date('N', strtotime('+1 day'));

						if (!isset($d[$day])){
							$open .= $this->language->get('text_closed_today');
							$open_text .= $this->language->get('text_closed_today');
							$is_open_now = false;
						} else {

							$date_now = DateTime::createFromFormat('H:i', date('H:i'));
							$date_open = DateTime::createFromFormat('H:i', $d[$day]['s']);					
							$date_close = DateTime::createFromFormat('H:i', $d[$day]['f']);

							if ($date_now > $date_open && $date_now < $date_close){
								$is_open_now = true;
								$to_close_h = date_diff($date_now, $date_close)->format('%h');
								$to_close_m = date_diff($date_now, $date_close)->format('%i');
								$open_text = sprintf($this->language->get('text_opened_now'), $to_close_h, $to_close_m);
								$open = sprintf($this->language->get('text_opened_now'), $to_close_h, $to_close_m);
							}

							if ($date_now > $date_close || $date_now < $date_open){
								$is_open_now = false;
								$to_close = date_diff($date_now, $date_open)->format('%h');
								$open_text = $this->language->get('text_closed_now');
								$open = $this->language->get('text_closed_now');
							}
						}

					}									
				}

				if ($is_open_now){
					$faclass = 'text-success';
				} else {
					$faclass = 'text-danger1';
				}

				if ($is_open_now && $result['quantity'] && $price){
					$mcolor = 'green';
					$tdclass = 'bg-success';
				}

				if (!$is_open_now || !$result['quantity'] || !$price){
					$mcolor = 'red';
					$tdclass = 'bg-danger';					
				}

				if (!$is_open_now && $result['quantity'] && $price){
					$mcolor = 'yellow';
					$tdclass = 'bg-warning';
				}

				$text_class 		= 'text-success';
				$stock_text 		= $result['quantity'] . ' шт.';
				$stock_icon 		= 'fa-clock-o';
				$can_not_deliver 	= false;

				if ($result['quantity'] >= 3){
					
					$text_class = 'text-success';
					$stock_text = $result['quantity'] . ' шт.';
					$stock_icon = 'fa-check';

				} elseif ($result['quantity'] > 0){					
					$text_class = 'text-warning';
					$stock_text = $result['quantity'] . ' шт.';
					$stock_icon = 'fa-check';
				} elseif ($result['is_pko'] && $result['quantity'] == 0) {
					$text_class = 'text-danger';
					$stock_text = $result['quantity'] . ' шт.';
					$stock_icon = 'fa-times';
					$can_not_deliver = true;
				} else {
					$text_class = 'text-warning';
					$stock_text = $this->language->get('text_we_can_deliver_in_2_days');
					$stock_icon = 'fa-clock-o';
				}

				if ($result['is_preorder']){
					$text_class = 'text-warning';
					$stock_text = $this->language->get('text_we_can_deliver_in_4_days');
					$stock_icon = 'fa-clock-o';
				}

				$data['stocks'][] = array(
					'name'			=> $result['name'],
					'address'		=> $result['address'],
					'location_id'	=> $result['location_id'],
					'image' 		=> $image,
					'is_preorder' 	=> $result['is_preorder'],
					'text_class' 	=> $text_class,
					'stock_text'	=> $stock_text,
					'stock_icon'	=> $stock_icon,
					'can_not_deliver' => $can_not_deliver,
					'stock' 		=> $result['quantity'],
					'geocode' 		=> $result['geocode'],
					'gmaps_link' 	=> $result['gmaps_link'],
					'open_text' 	=> $open_text,
					'open'			=> $result['open'],
					'tdclass' 		=> $tdclass,
					'faclass' 		=> $faclass,
					'icon' 	    	=> HTTPS_SERVER . 'image/gmarkers/source/marker_' . $mcolor . '.png',
					'price' 		=> ($result['quantity'] && $price)?$price:$this->language->get('text_preorder'),					
				);									
			}		

			$tmp_stocks = [];
			foreach ($data['stocks'] as $stock){
				if ($stock['stock'] > 0){
					array_unshift($tmp_stocks, $stock);
				} else {
					array_push($tmp_stocks, $stock);
				}
			}

			if ($this->mobileDetect->isMobile()){
				$this->response->setOutput($this->load->view('product/structured/stocks_mobile', $data));				
			} else {		
				$this->response->setOutput($this->load->view('product/structured/stocks', $data));		
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
					header('Content-Disposition: inline; filename="' . $outfile . '"');	
					header('X-Instruction: from-likreestr');				
					header('Cache-Control: public, max-age=0');
					readfile(DIR_INSTRUCTIONS . $filepath);

				} elseif ($extension == 'html'){
					if (file_exists(DIR_INSTRUCTIONS . str_ireplace('.html', '.pdf', $filepath))){

						header('Content-Type: application/pdf');
						header('Content-Disposition: inline; filename="' . $outfile . '"');						
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
			$data['text_get_instruction'] = $this->language->get('text_get_instruction');
			
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
						$data['reg_instruction_pdf_href'] = $this->url->link('eapteka/ajax/downloadinstruction', 'x=' . $product_id . '&dpath=' . base64_encode($instruction['file']));
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
			
			if ($this->mobileDetect->isMobile()){
				$this->response->setOutput($this->load->view('product/structured/likreestr_mobile', $data));
			} else {
				$this->response->setOutput($this->load->view('product/structured/likreestr', $data));
			}			
						
		}	
		
	}
