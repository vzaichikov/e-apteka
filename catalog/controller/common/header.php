<?php
	class ControllerCommonHeader extends Controller {
		public function index() {
			$this->load->controller('startup/hoboseo/postSeoPro');
						
			$this->load->model('extension/extension');
			$this->load->model('extension/module/xdstickers');
			$this->load->model('tool/image');
			$this->load->model('catalog/ochelp_special');
			$this->load->model('catalog/product');
			
			$data['analytics'] = [];			
			$analytics = $this->model_extension_extension->getExtensions('analytics');
			
			foreach ($analytics as $analytic) {
				if ($this->config->get($analytic['code'] . '_status')) {
					$data['analytics'][] = $this->load->controller('extension/analytics/' . $analytic['code'], $this->config->get($analytic['code'] . '_status'));
				}
			}
			
			if ($this->request->server['HTTPS']) {
				$server = $this->config->get('config_ssl');
				} else {
				$server = $this->config->get('config_url');
			}
			
			$data['base'] 			= $server;
			$data['description'] 	= $this->document->getDescription();
			$data['title'] 			= $this->document->getTitle();
			$data['keywords'] 		= $this->document->getKeywords();
			$data['robots_meta'] 	= $this->document->getRobotsMeta();			
			$data['noindex'] 		= $this->document->isNoindex();			
			$data['links'] 			= $this->document->getLinks();
			$data['styles'] 		= $this->document->getStyles();
			$data['scripts'] 		= $this->document->getScripts();
			$data['htmllang'] 		= $this->language->get('code');
			$data['lang'] 			= $this->language->get('code');
			$data['direction'] 		= $this->language->get('direction');
			$data['text_page'] 		= $this->language->get('text_page');
			$data['tlt_metatags'] 	= $this->document->getTLTMetaTags();
			
			if (!empty($this->request->get['page']) && is_numeric($this->request->get['page']) && (int)$this->request->get['page'] > 1){
				$data['seo_page'] 		= (int)$this->request->get['page'];					
				$data['title'] 			= sprintf($this->language->get('text_page'), (int)$this->request->get['page']) . $data['title'];
				$data['description'] 	= sprintf($this->language->get('text_page'), (int)$this->request->get['page']) . $data['description'];
			}
			
			$data['licence_logo'] = $this->model_tool_image->resize('licence-logo.png', 140, 70);
			$data['licence_href'] = $this->url->link('information/contact/dls');
			
			$data['name'] = $this->config->get('config_name');
			
			if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
				$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
				} else {
				$data['logo'] = '';
			}
			
			$this->load->model('setting/setting');
			$xdstickers = $this->config->get('xdstickers');
			$data['xdstickers_status'] = $xdstickers['status'];
			if ($xdstickers['status']) {
				$data['xdstickers'] = [];
				$data['xdstickers_position'] = $xdstickers['position'];
				$data['xdstickers_inline_styles'] = $xdstickers['inline_styles'];
				$data['xdstickers'][] = array(
				'id'			=> 'xdsticker_sale',
				'bg'			=> $xdstickers['sale']['bg'],
				'color'			=> $xdstickers['sale']['color'],
				'status'		=> $xdstickers['sale']['status'],
				);
				$data['xdstickers'][] = array(
				'id'			=> 'xdsticker_bestseller',
				'bg'			=> $xdstickers['bestseller']['bg'],
				'color'			=> $xdstickers['bestseller']['color'],
				'status'		=> $xdstickers['bestseller']['status'],
				);
				$data['xdstickers'][] = array(
				'id'			=> 'xdsticker_novelty',
				'bg'			=> $xdstickers['novelty']['bg'],
				'color'			=> $xdstickers['novelty']['color'],
				'status'		=> $xdstickers['novelty']['status'],
				);
				$data['xdstickers'][] = array(
				'id'			=> 'xdsticker_last',
				'bg'			=> $xdstickers['last']['bg'],
				'color'			=> $xdstickers['last']['color'],
				'status'		=> $xdstickers['last']['status'],
				);
				$data['xdstickers'][] = array(
				'id'			=> 'xdsticker_freeshipping',
				'bg'			=> $xdstickers['freeshipping']['bg'],
				'color'			=> $xdstickers['freeshipping']['color'],
				'status'		=> $xdstickers['freeshipping']['status'],
				);
				
				if (isset($xdstickers['stock']) && !empty($xdstickers['stock'])) {
					foreach($xdstickers['stock'] as $key => $value) {
						if (isset($value['status']) && $value['status'] == '1') {
							$data['xdstickers'][] = array(
							'id'			=> 'xdsticker_stock_' . $key,
							'bg'			=> $value['bg'],
							'color'			=> $value['color'],
							'status'		=> $value['status'],
							);
						}
					}
				}

				$custom_xdstickers = $this->model_extension_module_xdstickers->getCustomXDStickers();
				if (!empty($custom_xdstickers)) {
					foreach ($custom_xdstickers as $custom_xdsticker) {
						$custom_sticker_id = 'xdsticker_' . $custom_xdsticker['xdsticker_id'];
						$data['xdstickers'][] = array(
						'id'			=> $custom_sticker_id,
						'bg'			=> $custom_xdsticker['bg_color'],
						'color'			=> $custom_xdsticker['color_color'],
						'status'		=> $custom_xdsticker['status'],
						);
					}
				}
			}
			
			$languages 			= $this->registry->get('languages');
			$default_language 	= $this->config->get('config_language');			
			
			$real_url = $this->request->server['REQUEST_URI'];
			foreach ($languages as $language){	
				if (strpos(trim($this->request->server['REQUEST_URI']),  '/' . $language['urlcode'] . '/') === 0){
					$real_url = str_replace('/' . $language['urlcode'] . '/', '', trim($real_url));
				}
			}
			
			$real_url = ltrim($real_url, '/');		
			
			unset($language);			
			foreach ($languages as $language){
				if ($language['code'] == $default_language){
					if ($this->request->server['REQUEST_URI'] == '' || $this->request->server['REQUEST_URI'] == '/'){
						$hreflang = trim(HTTPS_SERVER . $real_url, '/');
						} else {
						$hreflang = HTTPS_SERVER . $real_url;
					}
					$this->document->addHrefLang($language['hreflang'], $hreflang);
					} else {
					$this->document->addHrefLang($language['hreflang'], (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')) ? HTTPS_SERVER : HTTP_SERVER) . $language['urlcode'] . '/' . $real_url);
				}
				
			}
			
			$data['languages'] = $languages;			
			$data['hreflangs'] = $this->document->getHrefLangs();
			
			$this->load->language('common/header');
			$data['store_url'] = HTTPS_SERVER;
			
			$data['text_home'] 			= $this->language->get('text_home');
			$data['text_callcenter'] 	= $this->language->get('text_callcenter');
			$data['text_mycard'] 		= $this->language->get('text_mycard');
			$data['text_mycard_small'] 	= $this->language->get('text_mycard_small');
			$data['text_simple_call'] 	= $this->language->get('text_simple_call');
			
			if ($this->customer->isLogged()) {
				$this->load->model('account/wishlist');			
				$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());							
				} else {
				$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
			}
			
			if ($this->customer->isLogged()) {
				$data['card'] = $this->customer->getCard();	
				$data['cardmodal'] = $this->load->controller('account/account/cardmodal');
				} else {
				$data['card'] = false;
			}
			
			$data['text_compare'] 		= sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$data['text_logged'] 		= sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));
			$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
			
			$data['text_account'] = $this->language->get('text_account');
			
			if ($this->customer->isLogged()){
				$data['text_account'] = $this->customer->getFirstName();
			}			
			$data['text_register'] = $this->language->get('text_register');
			$data['text_login'] = $this->language->get('text_login');
			$data['text_order'] = $this->language->get('text_order');
			$data['text_transaction'] = $this->language->get('text_transaction');
			$data['text_download'] = $this->language->get('text_download');
			$data['text_logout'] = $this->language->get('text_logout');
			$data['text_checkout'] = $this->language->get('text_checkout');
			$data['text_category'] = $this->language->get('text_category');
			$data['text_all'] = $this->language->get('text_all');
			
			$data['text_a'] = $this->language->get('text_a');
			$data['text_de'] = $this->language->get('text_de');
			$data['text_about'] = $this->language->get('text_about');
			$data['text_special'] = $this->language->get('text_special');
			$data['text_promotions'] = $this->language->get('text_promotions');
			$data['text_spr'] = $this->language->get('text_spr');
			$data['text_order_call'] = $this->language->get('text_order_call');
			$data['telephone'] = $this->config->get('config_telephone');
			
			
			$data['home'] = $this->url->link('common/home');
			$data['wishlist'] = $this->url->link('account/wishlist', '', true);
			$data['compare'] = $this->url->link('product/compare', '', true);
			$data['logged'] = $this->customer->isLogged();
			$data['account'] = $this->url->link('account/account', '', true);
			$data['register'] = $this->url->link('account/register', '', true);
			$data['login'] = $this->url->link('account/login', '', true);
			$data['order'] = $this->url->link('account/order', '', true);
			$data['transaction'] = $this->url->link('account/transaction', '', true);
			$data['download'] = $this->url->link('account/download', '', true);
			$data['logout'] = $this->url->link('account/logout', '', true);
			$data['shopping_cart'] = $this->url->link('checkout/cart');
			$data['checkout'] = $this->url->link('checkout/checkout', '', true);
			$data['contact'] = $this->url->link('information/contact');
			$data['drugstores'] = $this->url->link('information/contact/drugstores');
			$data['specials'] = $this->url->link('product/special');
			$data['promotions'] = $this->url->link('information/ochelp_special', '', true);			
			$data['brands'] 	= $this->url->link('product/manufacturer');			
			$data['contacts'] 	= $this->url->link('information/contact');
			$data['delivery'] 	= $this->url->link('information/information', 'information_id=6');
			$data['loyality'] 	= $this->url->link('information/information', 'information_id=7');
			$data['about_us'] 	= $this->url->link('information/information', 'information_id=4');
			$data['newsfeed'] 	= $this->url->link('simple_blog/article');
			$data['spravochnik'] = $this->url->link('product/category', 'path=1');
			$data['vacancies'] = $this->url->link('newsblog/category', 'newsblog_category_id=3');			
			
			$buyoneclick = $this->config->get('buyoneclick');
			$data['buyoneclick_status_product'] 	= $buyoneclick["status_product"];
			$data['buyoneclick_status_category'] 	= $buyoneclick["status_category"];
			$data['buyoneclick_status_module'] 		= $buyoneclick["status_module"];			
			$data['buyoneclick_style_status'] 		= $buyoneclick["style_status"];
			$data['buyoneclick_validation_type'] 	= $buyoneclick["validation_type"];			
			$data['buyoneclick_exan_status'] 		= $buyoneclick["exan_status"];			
			$data['buyoneclick_ya_status'] 					= $buyoneclick['ya_status'];
			$data['buyoneclick_ya_counter'] 				= $buyoneclick['ya_counter'];
			$data['buyoneclick_ya_identificator'] 			= $buyoneclick['ya_identificator'];
			$data['buyoneclick_ya_identificator_send'] 		= $buyoneclick['ya_identificator_send'];
			$data['buyoneclick_ya_identificator_success'] 	= $buyoneclick['ya_identificator_success'];			
			$data['buyoneclick_google_status'] 				= $buyoneclick['google_status'];
			$data['buyoneclick_google_category_btn'] 		= $buyoneclick['google_category_btn'];
			$data['buyoneclick_google_action_btn'] 			= $buyoneclick['google_action_btn'];
			$data['buyoneclick_google_category_send'] 		= $buyoneclick['google_category_send'];
			$data['buyoneclick_google_action_send'] 		= $buyoneclick['google_action_send'];
			$data['buyoneclick_google_category_success'] 	= $buyoneclick['google_category_success'];
			$data['buyoneclick_google_action_success'] 		= $buyoneclick['google_action_success'];
			

			$data['display_promotions'] = $this->model_catalog_ochelp_special->getTotalSpecial();
			$data['display_specials'] = $this->model_catalog_product->getTotalProductSpecials();
			$data['text_vacancies'] = $this->language->get('text_vacancies');
			$data['store_id'] = $this->config->get('config_store_id');
			$data['lang'] = $this->config->get('config_language_id');
			
			$store_id = $this->config->get('config_store_id');
			$lang = $this->config->get('config_language_id');
			$data['registry'] = $this->registry;
			
			/*---------------- STYLES -------------*/									
			$generalCSS = [			
				'catalog/view/javascript/font-awesome4.7/css/font-awesome.css',
				'catalog/view/theme/default/stylesheet/stylesheet.css',
				'catalog/view/theme/default/stylesheet/main.css',
				'catalog/view/javascript/IMCallMeAskMe/jquery.imcallback.css',
				'catalog/view/theme/default/stylesheet/popupcart.css',
				'catalog/view/theme/default/stylesheet/swiper.min.css'
			];						
			
			$data['general_minified_css_uri'] = HTTPS_SERVER . \hobotix\MinifyAdaptor::createFile($generalCSS, 'css');

			$addedCSS = [];
			foreach ($data['styles'] as $style) {				
				$href = $style['href'];
				
				if (stripos($href, '?v=')){
					$version = explode("?v=",$href);
					$href = $version[0];
				}
				
				$addedCSS[$href] = $href;
			}
			
			if ($addedCSS){
				$data['added_minified_css_uri'] = HTTPS_SERVER . \hobotix\MinifyAdaptor::createFile($addedCSS, 'css');
			}
			/*---------------- END STYLES -------------*/
			
			/*---------------- SCRIPTS -------------*/			
			$generalJS = [
				'catalog/view/theme/default/js/lib/slick.min.js',
				'catalog/view/javascript/common.js',
				'catalog/view/javascript/ecommerce.functions.js',
				'catalog/view/javascript/inputmask.js',
				'catalog/view/javascript/popupcart.js',
				'catalog/view/theme/default/js/main.js',
				'catalog/view/javascript/IMCallMeAskMe/jquery.imcallask.js',
			//	'catalog/view/javascript/social_auth.js',
				'catalog/view/theme/default/js/swiper.min.js',
			//	'catalog/view/javascript/html5-qrcode.min.v2.2.5.js',
				'catalog/view/theme/default/js/lib/jquery.magnific-popup.min.js',
				'catalog/view/theme/default/js/lib/jquery.maskedinput.js',
				'catalog/view/theme/default/js/lib/jquery.mCustomScrollbar.concat.min.js'
			];					
			
			$data['general_minified_js_uri'] = HTTPS_SERVER . \hobotix\MinifyAdaptor::createFile($generalJS, 'js');
						
			$data['incompatible_scripts'] = [];
			foreach ($data['scripts'] as $script) {
				if (stripos('//', $script) !== false){
					$data['incompatible_scripts'][] = $script;
				}
			}						
			
			$addedJS = [];
			foreach ($data['scripts'] as $script) {
				if (!in_array($script, $data['incompatible_scripts'])) {
					
					if (stripos($script, '?v=')){
						$version = explode("?v=",$script);
						$script = $version[0];
					}
					
					$addedJS[] = $script; 
				}
			}
			
			if ($addedJS){				
				$query = "f=" . implode(',', $t);
				$data['added_minified_js_uri'] = HTTPS_SERVER . \hobotix\MinifyAdaptor::createFile($addedJS, 'js');
			}			
			/*---------------- END SCRIPTS -------------*/
			
			
			$data['pwaInstallKey'] = md5('pwainstall' . $this->request->server['REMOTE_ADDR'] . date('d') . $this->config->get('config_encryption'));
			$data['pwaSessionKey'] = md5('pwasession' . $this->request->server['REMOTE_ADDR'] . date('d') . $this->config->get('config_encryption'));
			
			$data['spsroute'] = $this->url->link('eapteka/pwa/sps', 'pwaSessionKey=' . $data['pwaSessionKey']);
			$data['spiroute'] = $this->url->link('eapteka/pwa/spi', 'pwaInstallKey=' . $data['pwaInstallKey']);
			
			$data['pwasession'] = $this->customer->getPWASession();	
			
			$data['search'] 	= $this->load->controller('common/search');						
			$data['loginmodal'] = $this->load->controller('account/loginmodal');
			$data['language'] 	= $this->load->controller('common/language');
			$data['currency'] 	= $this->load->controller('common/currency');
			$data['catalog'] 	= $this->load->controller('common/afterload/catalog');
			
			if (isset($this->request->get['route']) AND strlen($this->request->get['route']) != 0) {
				if (isset($this->request->get['product_id'])) {
					$class = '-' . $this->request->get['product_id'];
					} elseif (isset($this->request->get['path'])) {
					$class = '-' . $this->request->get['path'];
					} elseif (isset($this->request->get['manufacturer_id'])) {
					$class = '-' . $this->request->get['manufacturer_id'];
					} elseif (isset($this->request->get['information_id'])) {
					$class = '-' . $this->request->get['information_id'];
					} else {
					$class = '';
				}
				
				$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
				} else {
				$data['class'] = 'common-home';
			}
			
			$this->load->model('design/layout');
			$layout_id = $this->model_design_layout->getLayout('common/header');
			
			if ($layout_id){
				
				$this->load->model('extension/module');
				
				$data['modules'] = [];
				$modules = $this->model_design_layout->getLayoutModules($layout_id, 'content_top');
				
				foreach ($modules as $module) {
					
					$part = explode('.', $module['code']);
					
					if (isset($part[0]) && $this->config->get($part[0] . '_status')) {
						$module_data = $this->load->controller('extension/module/' . $part[0]);
						
						if ($module_data) {
							$data['modules'][] = $module_data;
						}
					}
					
					if (isset($part[1])) {
						$setting_info = $this->model_extension_module->getModule($part[1]);
						
						if ($setting_info && $setting_info['status']) {
							$setting_info['position'] 		= 'content_top';
							$setting_info['block_layout'] 	= 'header';
							$output = $this->load->controller('extension/module/' . $part[0], $setting_info);
							
							if ($output) {
								$data['modules'][] = $output;
							}
						}
					}
				}
			}		
			
			if (!empty($this->request->get['route']) && $this->request->get['route'] == 'checkout/simplecheckout'){
				
				return $this->load->view('common/header_simple', $data);
				
				} else {
				return $this->load->view('common/header', $data);
			}
		}
	}
	
	
