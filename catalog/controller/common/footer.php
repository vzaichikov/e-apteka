<?php
	class ControllerCommonFooter extends Controller {

		public function online(){
			// Whos Online
			if ($this->config->get('config_customer_online')) {
				$this->load->model('tool/online');
				
				if (isset($this->request->server['REMOTE_ADDR'])) {
					$ip = $this->request->server['REMOTE_ADDR'];
					} else {
					$ip = '';
				}
				
				if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
					$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
					} else {
					$url = '';
				}
				
				if (isset($this->request->server['HTTP_REFERER'])) {
					$referer = $this->request->server['HTTP_REFERER'];
					} else {
					$referer = '';
				}
				
				if (isset($this->request->server['HTTP_USER_AGENT'])) {
					$useragent = $this->request->server['HTTP_USER_AGENT'];	
					} else {
					$useragent = '';
				}
				
				$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer, $useragent, $this->crawlerDetect->isCrawler());
			}
		}


		public function index() {
			$this->load->language('common/footer');
			
			
			$data['scripts'] = $this->document->getScripts('footer');
			
			$data['text_applications'] = $this->language->get('text_applications');
			$data['text_information'] = $this->language->get('text_information');
			$data['text_service'] = $this->language->get('text_service');
			$data['text_extra'] = $this->language->get('text_extra');
			$data['text_contact_footer'] = $this->language->get('text_contact_footer');
			$data['text_contact_title'] = $this->language->get('text_contact_title');
			$data['text_return'] = $this->language->get('text_return');
			$data['text_sitemap'] = $this->language->get('text_sitemap');
			$data['text_manufacturers'] = $this->language->get('text_manufacturers');
			$data['text_collections'] = $this->language->get('text_collections');
			$data['text_voucher'] = $this->language->get('text_voucher');
			$data['text_affiliate'] = $this->language->get('text_affiliate');
			$data['text_special'] = $this->language->get('text_special');
			$data['text_account'] = $this->language->get('text_account');
			$data['text_order'] = $this->language->get('text_order');
			$data['text_wishlist'] = $this->language->get('text_wishlist');
			$data['text_newsletter'] = $this->language->get('text_newsletter');
			$data['text_promotions'] = $this->language->get('text_promotions');
			$data['text_alphabet_drugs'] = $this->language->get('text_alphabet_drugs');
			$data['text_drugstores'] = $this->language->get('text_drugstores');
			$data['text_newsfeed'] = $this->language->get('text_newsfeed');
			
			$data['text_pwa_1'] = $this->language->get('text_pwa_1');
			$data['text_pwa_2'] = $this->language->get('text_pwa_2');
			$data['text_pwa_btn_install'] = $this->language->get('text_pwa_btn_install');
			
			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') ) {
				$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'), $this->error);
				} else {
				$data['captcha'] = '';
			}
			
			$this->load->model('catalog/information');
			
			$data['informations'] = array();
			
			foreach ($this->model_catalog_information->getInformations() as $result) {
				if ($result['bottom']) {
					$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
					);
				}
			}
			
			$data['phone'] = $this->config->get('config_telephone');
			$data['address'] = $this->config->get('config_address');
			
			
			if ($this->config->get('config_address_' . $this->config->get('config_language_id'))){
				$data['address'] = $this->config->get('config_address_' . $this->config->get('config_language_id'));
			}
			
			$data['email'] = $this->config->get('config_email');

			$this->load->model('tool/image');
			$data['licence_logo'] = $this->model_tool_image->resize('catalog/dls.jpg', 70, 70);
			
			$data['newsfeed'] = $this->url->link('newsblog/category', 'newsblog_category_id=1');
			$data['useful'] = $this->url->link('newsblog/category', 'newsblog_category_id=2');
			$data['vacancies'] = $this->url->link('newsblog/category', 'newsblog_category_id=3');
			$data['loyality'] = $this->url->link('information/information', 'information_id=7');
			
			$data['text_newsfeed'] = $this->language->get('text_newsfeed');
			$data['text_useful'] = $this->language->get('text_useful');
			$data['text_vacancies'] = $this->language->get('text_vacancies');
			$data['text_loyality'] = $this->language->get('text_loyality');
			
			$data['drugstores'] = $this->url->link('information/contact/drugstores');
			$data['contact'] = $this->url->link('information/contact');
			$data['return'] = $this->url->link('account/return/add', '', true);
			$data['sitemap'] = $this->url->link('information/sitemap');
			$data['manufacturer'] = $this->url->link('product/manufacturer');
			$data['collections'] = $this->url->link('product/collection/listing');
			$data['voucher'] = $this->url->link('account/voucher', '', true);
			$data['affiliate'] = $this->url->link('affiliate/account', '', true);
			$data['special'] = $this->url->link('product/special');
			$data['account'] = $this->url->link('account/account', '', true);
			$data['order'] = $this->url->link('account/order', '', true);
			$data['wishlist'] = $this->url->link('account/wishlist', '', true);
			$data['newsletter'] = $this->url->link('account/newsletter', '', true);
			$data['promotions'] = $this->url->link('information/ochelp_special', '', true);
			
			$data['alphabet_drugs'] = $this->url->link('product/category', 'category_id=1', true);
			
			$data['text_1'] = $this->language->get('text_1');
			$data['text_2'] = sprintf($this->language->get('text_2'), date('Y'));	
			$data['text_3'] = $this->language->get('text_3');
			$data['text_4'] = $this->language->get('text_4');
			
			$data['text_button_loading'] = $this->language->get('text_button_loading');
			
			$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));
			
			if ($this->customer->isLogged()){
				$this->load->model('account/address');
				
				$_address = $this->model_account_address->getAddress($this->customer->getAddressId());
				
				if (!$_address || is_array($_address)){
					$this->load->model('localisation/country');
					$_country = $this->model_localisation_country->getCountry($this->config->get('config_country_id'));
					
					$_address = array(
					'country_id' => $this->config->get('config_country_id'),
					'country' => $_country['name']
					);
				}
				
				$data['push_customer_info'] = array(
				'customer_id'      	  => $this->customer->getId(),
				'customer_name'       => $this->customer->getFirstName(),
				'customer_email'      => $this->customer->getEmail(),
				'customer_phone'      => $this->customer->getTelephone(),
				'customer_country_id' => $_address['country_id'],
				'customer_country'    => $_address['country'],
				);
				
				} else {
				$data['push_customer_info'] = false;
			}
			
			$detect = new Mobile_Detect;
			$data['is_mobile'] = $detect->isMobile();
			
			$data['tip_state_unsubscribed'] = $this->language->get('tip_state_unsubscribed');
			$data['tip_state_subscribed'] = $this->language->get('tip_state_subscribed');
			$data['tip_state_blocked'] = $this->language->get('tip_state_blocked');
			$data['message_prenotify'] = $this->language->get('message_prenotify');
			$data['message_action_subscribed'] = $this->language->get('message_action_subscribed');
			$data['message_action_resubscribed'] = $this->language->get('message_action_resubscribed');
			$data['message_action_unsubscribed'] = $this->language->get('message_action_unsubscribed');
			$data['dialog_main_title'] = $this->language->get('dialog_main_title');
			$data['dialog_main_button_subscribe'] = $this->language->get('dialog_main_button_subscribe');
			$data['dialog_main_button_unsubscribe'] = $this->language->get('dialog_main_button_unsubscribe');
			$data['dialog_blocked_title'] = $this->language->get('dialog_blocked_title');
			$data['dialog_blocked_message'] = $this->language->get('dialog_blocked_message');
			$data['welcome_title'] = $this->language->get('welcome_title');
			$data['welcome_message'] = $this->language->get('welcome_message');
			$data['actionMessage'] = $this->language->get('actionMessage');
			$data['acceptButtonText'] = $this->language->get('acceptButtonText');
			$data['cancelButtonText'] = $this->language->get('cancelButtonText');
			
			// BuyOneClick
			$buyoneclick = $this->config->get('buyoneclick');
			$data['buyoneclick_status_product'] = $buyoneclick["status_product"];
			$data['buyoneclick_status_category'] = $buyoneclick["status_category"];
			$data['buyoneclick_status_module'] = $buyoneclick["status_module"];
			
			$data['buyoneclick_exan_status'] = $buyoneclick["exan_status"];
			
			$current_language_id = $this->config->get('config_language_id');
			$data['buyoneclick_success_field'] = isset($buyoneclick["success_field"][$current_language_id]) ? htmlspecialchars_decode($buyoneclick["success_field"][$current_language_id]) : '';
			
			$this->load->language('extension/module/buyoneclick');
			if ($data['buyoneclick_success_field'] == '') {
				$data['buyoneclick_success_field'] = $this->language->get('buyoneclick_success');
			}
			if ($data['btn_close_field'] == '') {
				$data['btn_close_field'] = $this->language->get('btn_close');
			}
			// BuyOneClickEnd
			
						
			
			if (!empty($this->request->get['route']) && $this->request->get['route'] == 'checkout/simplecheckout'){
				
				return $this->load->view('common/footer_simple', $data);
				
				} else {
				
				return $this->load->view('common/footer', $data);
			}
		}
	}
