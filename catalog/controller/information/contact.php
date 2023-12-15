<?php
	class ControllerInformationContact extends Controller {
		private $error = array();

		private function ecurl($url){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$out = curl_exec($ch);
			curl_close($ch);

			return $out;
		}

		private function download_dls($url) {
			$html = $this->ecurl($url);

			$doc = new DOMDocument();
			$doc->loadHTML($html);

			$html = str_replace('\images\\', '/images/', $html);

			$links = array();
			foreach ($doc->getElementsByTagName('link') as $link) {
				if ($link->getAttribute('rel') == 'stylesheet') {
					$links[] = $link->getAttribute('href');
				}
			}
			foreach ($doc->getElementsByTagName('script') as $script) {
				$links[] = $script->getAttribute('src');
			}

			foreach ($doc->getElementsByTagName('img') as $image) {
				$links[] = str_replace('\\', '/', $image->getAttribute('src'));
			}


			$base_url = parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST);
			foreach ($links as $link) {
				$local_path = DIR_APPLICATION . '../dls-data/' . $link;
				$dir = DIR_APPLICATION . '../dls-data/' . pathinfo($link,  PATHINFO_DIRNAME);

				if (!is_dir($dir)){
					mkdir($dir, 0755, true);
				}

				file_put_contents($local_path, $this->ecurl($base_url . $link));

				$html = str_replace($link, 'https://e-apteka.com.ua/dls-data' . $link, $html);
			}

			$html = str_replace('href="/"', ' href="https://pharmacy.dls.gov.ua"', $html);

			return $html;

		}

		public function dls(){
			$this->response->setOutput($this->download_dls('https://pharmacy.dls.gov.ua/check?EDRPOU=22974151'));
		}
		
		public function drugstores(){
			$this->load->language('information/contact');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrumb_home'),
			'href' => $this->url->link('common/home')
			);
			
			$data['heading_title'] = $this->language->get('heading_title');

				$data['hb_snippets_local_enable'] = $this->config->get('hb_snippets_local_enable');
				$data['hb_snippets_local_snippet'] = $this->config->get('hb_snippets_local_snippet');
				
			
			$data['text_location'] = $this->language->get('text_location');
			$data['text_store'] = $this->language->get('text_store');
			$data['text_contact'] = $this->language->get('text_contact');
			$data['text_address'] = $this->language->get('text_address');
			$data['text_telephone'] = $this->language->get('text_telephone');
			$data['text_fax'] = $this->language->get('text_fax');
			$data['text_open'] = $this->language->get('text_open');
			$data['text_comment'] = $this->language->get('text_comment');
			$data['text_readmore'] = $this->language->get('text_readmore');
			
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_email'] = $this->language->get('entry_email');
			$data['entry_enquiry'] = $this->language->get('entry_enquiry');
			
			$data['button_map'] = $this->language->get('button_map');
			
			if (isset($this->error['name'])) {
				$data['error_name'] = $this->error['name'];
				} else {
				$data['error_name'] = '';
			}
			
			if (isset($this->error['email'])) {
				$data['error_email'] = $this->error['email'];
				} else {
				$data['error_email'] = '';
			}
			
			if (isset($this->error['enquiry'])) {
				$data['error_enquiry'] = $this->error['enquiry'];
				} else {
				$data['error_enquiry'] = '';
			}
			
			$data['button_submit'] = $this->language->get('button_submit');
			
			$data['action'] = $this->url->link('information/contact', '', true);
			
			$this->load->model('tool/image');
			
			if ($this->config->get('config_image')) {
				$data['image'] = $this->model_tool_image->resize($this->config->get('config_image'), $this->config->get($this->config->get('config_theme') . '_image_location_width'), $this->config->get($this->config->get('config_theme') . '_image_location_height'));
				} else {
				$data['image'] = false;
			}
			
			$data['store'] = $this->config->get('config_name');
			$data['address'] = nl2br($this->config->get('config_address'));
			$data['geocode'] = $this->config->get('config_geocode');
			$data['geocode_hl'] = $this->config->get('config_language');
			$data['telephone'] = $this->config->get('config_telephone');
			$data['fax'] = $this->config->get('config_fax');
			$data['open'] = nl2br($this->config->get('config_open'));
			$data['comment'] = $this->config->get('config_comment');
						
			$data['locations'] = array();
			
			$this->load->model('localisation/location');
			
			$multilang_fields = array(
			'open',
			'address',
			'name',
			'comment'		
			);
			

			foreach((array)$this->model_localisation_location->getLocationsForMapPage() as $location_id) {
				$location_info = $this->model_localisation_location->getLocation($location_id);
				
				if ($location_info) {
					if ($location_info['image']) {
						$image = $this->model_tool_image->resize($location_info['image'], $this->config->get($this->config->get('config_theme') . '_image_location_width'), $this->config->get($this->config->get('config_theme') . '_image_location_height'));
						} else {
						$image = false;
					}
					
					$open_text = '';
					$open = '';
					$mcolor = 'red';
					$is_open_now = false;
					if ($location_info['open_struct']){
						date_default_timezone_set('Europe/Kiev');
						
						$_r = trim($location_info['open_struct']);
						
						if ($_r == '∞'){
							$open = $this->language->get('text_open_alltime');
							$open_text = $this->language->get('text_open_alltime');
							$is_open_now = true;
							} else {
							$a = explode(PHP_EOL, $location_info['open_struct']);													
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
								
								$date_now 	= DateTime::createFromFormat('H:i', date('H:i'));
								$date_open 	= DateTime::createFromFormat('H:i', $d[$day]['s']);					
								$date_close = DateTime::createFromFormat('H:i', $d[$day]['f']);
								
								if ($date_now > $date_open && $date_now < $date_close){
									$is_open_now = true;
									$to_close_h = date_diff($date_now, $date_close)->format('%h');
									$to_close_m = date_diff($date_now, $date_close)->format('%i');
									$open_text 	= sprintf($this->language->get('text_opened_now'), $to_close_h, $to_close_m);
									$open 		= sprintf($this->language->get('text_opened_now'), $to_close_h, $to_close_m);
								}
								
								if ($date_now > $date_close || $date_now < $date_open){
									$is_open_now 	= false;
									$to_close 		= date_diff($date_now, $date_open)->format('%h');
									$open_text 		= $this->language->get('text_closed_now');
									$open 			= $this->language->get('text_closed_now');
								}
							}
							
						}									
					}
					
					
					
					if ($is_open_now){
						$faclass = 'text-success';
						} else {
						$faclass = 'text-danger1';
					}
					
					if ($is_open_now){
						$mcolor = 'green';
						$tdclass = 'bg-success';
					}
					
					if (!$is_open_now){
						$mcolor = 'red';
						$tdclass = 'bg-danger';					
					}
					
					foreach ($multilang_fields as $_field){
						if ($_mlvalue = $this->model_localisation_location->getLocationML($location_info['location_id'], $_field)){
							${$_field} = $_mlvalue;
							} else {
							${$_field} = $location_info[$_field];
						}
					}								
					
					$data['text_we_work_while_no_light'] = $this->language->get('text_we_work_while_no_light');

					if (!empty($this->registry->get('branding')[$location_info['brand']])){
						$icon = HTTPS_SERVER . 'image/brand/marker-icon-'. $this->registry->get('branding')[$location_info['brand']] .'.png';
					} else {
						$icon = HTTPS_SERVER . 'image/brand/marker-icon-brand-default.png';
					}

					$name = $location_info['name'];
					if (!in_array($location_info['location_id'], $this->cart->getOpenedStores())){
						continue;
						$name 		= ' <b>[ТИМЧАСОВО НЕ ПРАЦЮЄ]</b> ' . $name;		
						$address 	= ' <b>[ТИМЧАСОВО НЕ ПРАЦЮЄ]</b> ' . $address;		

						$mcolor 	= 'grey';
						$tdclass 	= 'bg-danger';
						$icon 		= HTTPS_SERVER . 'image/brand/marker_grey.png';
					}
					
					$data['locations'][] = array(
					'location_id' => $location_info['location_id'],
					'name'        => $this->db->escape($name),
					'address'     => $this->db->escape(nl2br($address)),
					'geocode'     => $location_info['geocode'],
					'telephone'   => $location_info['telephone'],
					'email'   	  => $this->config->get('config_email'),
					'fax'         => $location_info['fax'],
					'image'       => $image,
					'open_text'   => $open_text,
					'open'        => nl2br($open),
					'tdclass' 	  => $tdclass,
					'faclass' 	  => $faclass,
					'open_text'   => $open_text,
					'icon' 	      => $icon,
					'comment'     => $location_info['comment'],
					'information_id' => $location_info['information_id'],
					'information_href' => $location_info['information_id']?$this->url->link('catalog/information', 'information_id=' . $location_info['information_id']):false
					);
				}
			}
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			
			$this->response->setOutput($this->load->view('information/drugstores', $data));
		}
		
		public function index() {
			$this->load->language('information/contact');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
		/*	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
				
				
				$mail->setTo($this->config->get('config_email'));
				//$mail->setTo('folder.list@gmail.com');
				$mail->setFrom($this->request->post['email']);
				$mail->setSender(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'));
				$mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name']), ENT_QUOTES, 'UTF-8'));
				$mail->setText($this->request->post['email'] . PHP_EOL . ' ' . $this->request->post['enquiry']);
				$mail->send();	
				
				$this->response->redirect($this->url->link('information/contact/success'));
			}
		*/
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrumb_home'),
			'href' => $this->url->link('common/home')
			);
			
			$data['heading_title'] = $this->language->get('heading_title');

				$data['hb_snippets_local_enable'] = $this->config->get('hb_snippets_local_enable');
				$data['hb_snippets_local_snippet'] = $this->config->get('hb_snippets_local_snippet');
				
			
			$data['text_location'] = $this->language->get('text_location');
			$data['text_store'] = $this->language->get('text_store');
			$data['text_contact'] = $this->language->get('text_contact');
			$data['text_address'] = $this->language->get('text_address');
			$data['text_telephone'] = $this->language->get('text_telephone');
			$data['text_fax'] = $this->language->get('text_fax');
			$data['text_open'] = $this->language->get('text_open');
			$data['text_comment'] = $this->language->get('text_comment');
			$data['text_readmore'] = $this->language->get('text_readmore');
			$data['text_geolocation'] = html_entity_decode($this->language->get('text_geolocation'), ENT_QUOTES, 'UTF-8');
			
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_email'] = $this->language->get('entry_email');
			$data['entry_enquiry'] = $this->language->get('entry_enquiry');
			
			$data['button_map'] = $this->language->get('button_map');
			
				if (isset($this->error['name'])) {
				$data['error_name'] = $this->error['name'];
				} else {
				$data['error_name'] = '';
			}
			
			if (isset($this->error['email'])) {
				$data['error_email'] = $this->error['email'];
				} else {
				$data['error_email'] = '';
			}
			
			if (isset($this->error['enquiry'])) {
				$data['error_enquiry'] = $this->error['enquiry'];
				} else {
				$data['error_enquiry'] = '';
			}
			
			$data['button_submit'] = $this->language->get('button_submit');
			
			$data['action'] = $this->url->link('information/contact', '', true);
			
			$this->load->model('tool/image');
			
			if ($this->config->get('config_image')) {
				$data['image'] = $this->model_tool_image->resize($this->config->get('config_image'), $this->config->get($this->config->get('config_theme') . '_image_location_width'), $this->config->get($this->config->get('config_theme') . '_image_location_height'));
				} else {
				$data['image'] = false;
			}
			
			$data['store'] = $this->config->get('config_name');
			$data['address'] = nl2br($this->config->get('config_address'));
			$data['geocode'] = $this->config->get('config_geocode');		
			$data['geocode_hl'] = $this->config->get('config_language');
			$data['telephone'] = $this->config->get('config_telephone');
			$data['fax'] = $this->config->get('config_fax');
			$data['open'] = nl2br($this->config->get('config_open'));
			$data['comment'] = $this->config->get('config_comment');
			
			if (isset($this->request->post['name'])) {
				$data['file'] = $this->request->post['file'];
			} 
			if (isset($this->request->post['name'])) {
				$data['name'] = $this->request->post['name'];
				} else {
				$data['name'] = $this->customer->getFirstName();
			}
			
			if (isset($this->request->post['email'])) {
				$data['email'] = $this->request->post['email'];
				} else {
				$data['email'] = $this->customer->getEmail();
			}
			
			if (isset($this->request->post['enquiry'])) {
				$data['enquiry'] = $this->request->post['enquiry'];
				} else {
				$data['enquiry'] = '';
			}
			
			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
				$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'), $this->error);
				} else {
				$data['captcha'] = '';
			}
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			
			$this->response->setOutput($this->load->view('information/contact', $data));
		}
		
		protected function validate() {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
				$this->error['name'] = $this->language->get('error_name');
			}
			
			if (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
				$this->error['email'] = $this->language->get('error_email');
			}
			
			if ((utf8_strlen($this->request->post['enquiry']) < 10) || (utf8_strlen($this->request->post['enquiry']) > 3000)) {
				$this->error['enquiry'] = $this->language->get('error_enquiry');
			}
			
			// Captcha
			/*
			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
				$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');
				
				if ($captcha) {
					$this->error['captcha'] = $captcha;
				}
			}
			*/
			
			return !$this->error;
		}
		
		public function success() {
			$this->load->language('information/contact');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrumb_home'),
			'href' => $this->url->link('common/home')
			);
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/contact')
			);
			
			$data['heading_title'] = $this->language->get('heading_title');

				$data['hb_snippets_local_enable'] = $this->config->get('hb_snippets_local_enable');
				$data['hb_snippets_local_snippet'] = $this->config->get('hb_snippets_local_snippet');
				
			
			$data['text_message'] = $this->language->get('text_success');
			
			$data['button_continue'] = $this->language->get('button_continue');
			
			$data['continue'] = $this->url->link('common/home');
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			
			$this->response->setOutput($this->load->view('common/success', $data));
		}
	}
	
