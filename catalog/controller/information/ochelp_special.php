<?php
	
	class ControllerInformationOchelpSpecial extends Controller {
		
		private function prepareSpecialsArchive($results){
			$this->load->model('catalog/ochelp_special');			
			$this->load->model('tool/image');
			$this->load->language('information/ochelp_special');
			
			$_data = array();
			$_data['specials'] = array();
			
			if ($results) {						
				
				$setting = array();
				
				if ($this->config->get('special_setting')) {
					$setting = $this->config->get('special_setting');
					} else {
					$setting['description_limit'] = '300';
					$setting['special_thumb_width'] = '400';
					$setting['special_thumb_height'] = '300';
				}								
				
				foreach ($results as $result) {
					
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $setting['special_thumb_width'], $setting['special_thumb_height']);
						} else {
						$image = false;
					}
					
					if($result['date_end'] == '0000-00-00' || strtotime($result['date_end']) == strtotime(date('Y-m-d')) || $result['date_end'] == '0'){
						$date_end = false;
						} else {
						$date_end = date('Y-m-d', strtotime($result['date_end']));
					}
					
					$description = utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 200);
					$description = substr(rtrim($description, "!,.-"), 0, strrpos($description, ' '));
					
					$_data['specials'][] = array(
					'title' => $result['title'],
					'thumb' => $image,
					'date_end' => $date_end,
					'counter' => $result['counter'],
					'dateDiff' => dateDiff($date_end),
					'active' => $date_end?($date_end >= date('Y-m-d')):true,				
					'description' => $description . '...',
					'href' => $this->url->link('information/ochelp_special/info', 'special_id=' . $result['special_id']),
					'posted' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					);
				}
				
			}
			
			return $_data['specials'];
			
		}
		
		public function index() {
			$this->load->language('information/ochelp_special');
			
			$this->load->model('catalog/ochelp_special');
			$this->load->model('tool/image');
			
			$this->data['text_day'] = $this->language->get('day');
			$this->data['text_hour'] = $this->language->get('hour');
			$this->data['text_minute'] = $this->language->get('minute');
			$this->data['text_sec'] = $this->language->get('sec');
			$this->data['text_byu'] = $this->language->get('byu');
			$this->data['end_date'] = date('Y-m-d H:i:s', $actions['date_end']);
			
			$lang = mb_strtolower($this->language->get('code'));
			
			if ($lang !== 'en') {
				//	$this->document->addScript('catalog/view/javascript/timer/jquery.countdown-' . $lang . '.js');
			}
			
			$sort = 's.date_added';
			$order = 'DESC';
			$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
			
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
				} else {
				$page = 1;
			}						
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$data['heading_title'] = $this->language->get('heading_title');
			$data['text_specials_archive'] = $this->language->get('text_specials_archive');
			
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_special'] = $this->language->get('text_special');
			$data['text_days'] = $this->language->get('text_days');
			$data['text_special_label'] = $this->language->get('text_special_label');
			
			$data['heading_title'] = $this->language->get('heading_title');
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_ended'] = $this->language->get('text_ended');
			
			$data['text_promo_ended'] = $this->language->get('text_promo_ended');
			$data['text_action_time_to_end'] = $this->language->get('text_action_time_to_end');
			$data['special_time_left_long'] = $this->language->get('special_time_left_long');
			
			$data['button_grid'] = $this->language->get('button_grid');
			$data['button_list'] = $this->language->get('button_list');
			
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_limit'] = $this->language->get('text_limit');
			
			$data['text_more'] = $this->language->get('text_more');
			
			$data['text_days'] = $this->language->get('text_days');
			$data['text_hours'] = $this->language->get('text_hours');
			$data['text_minutes'] = $this->language->get('text_minutes');
			$data['text_seconds'] = $this->language->get('text_seconds');
			
			$data['button_continue'] = $this->language->get('button_continue');
			$data['continue'] = $this->url->link('common/home');
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home'),
			);
			
			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}						
			
			$filter_data = array(
			'sort' 	=> $sort,
			'order' => $order,
			'start' => ($page - 1) * $limit,
			'limit' => $limit,
			);
			
			$results = $this->model_catalog_ochelp_special->getSpecials($filter_data);
			$data['specials'] = $this->prepareSpecialsArchive($results);
			
			$results = $this->model_catalog_ochelp_special->getSpecialsArchive($filter_data);
			$data['specials_archive'] = $this->prepareSpecialsArchive($results);
			
			$url = '';
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}				
			
			$special_total = $this->model_catalog_ochelp_special->getTotalSpecial();
			
			$pagination = new Pagination();
			$pagination->total = $special_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('information/ochelp_special', $url . '&page={page}');
			
			$data['pagination'] = $pagination->render();
			
			$data['results'] = sprintf($this->language->get('text_pagination'), ($special_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($special_total - $limit)) ? $special_total : ((($page - 1) * $limit) + $limit), $special_total, ceil($special_total / $limit));
			
			if ($page == 1) {
				$this->document->addLink($this->url->link('information/ochelp_special', '', true), 'canonical');
				} elseif ($page == 2) {
				$this->document->addLink($this->url->link('information/ochelp_special', '', true), 'prev');
				} else {
				$this->document->addLink($this->url->link('information/ochelp_special', '&page=' . ($page - 1), true), 'prev');
			}
			
			if ($limit && ceil($special_total / $limit) > $page) {
				$this->document->addLink($this->url->link('information/ochelp_special', '&page=' . ($page + 1), true), 'next');
			}
			
			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;
			
			$data['continue'] = $this->url->link('common/home');
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			
			$this->response->setOutput($this->load->view('information/ochelp_special_list', $data));
			
		}
		
		public function info() {
			$this->language->load('information/ochelp_special');
			
			$data['oct_popup_view_data'] = $this->config->get('oct_popup_view_data');
			$data['button_popup_view'] = $this->language->get('button_popup_view');	
			
			
			$lang = mb_strtolower($this->language->get('code'));
			
			$this->load->model('catalog/ochelp_special');
			
			$this->load->model('tool/image');			
			$this->load->model('catalog/category');
			$this->load->model('catalog/product');
			$this->load->model('catalog/manufacturer');
			
			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
				} else {
				$sort = 'p.sort_order';
			}
			
			if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
				} else {
				$order = 'ASC';
			}
			
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
				} else {
				$page = 1;
			}		
			
			if (isset($this->request->get['limit'])) {
				$limit = (int) $this->request->get['limit'];
				} else {
				$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
			}
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home'),
			'text' => $this->language->get('text_home'),
			);
			
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/ochelp_special', $url),
			);
			
			$data['text_special_label'] = $this->language->get('text_special_label');
			$data['text_empty'] = $this->language->get('text_empty_products');
			$data['text_quantity'] = $this->language->get('text_quantity');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_price'] = $this->language->get('text_price');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_special'] = $this->language->get('text_special');
			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_limit'] = $this->language->get('text_limit');
			
			$data['text_promo_ended'] = $this->language->get('text_promo_ended');
			$data['text_action_time_to_end'] = $this->language->get('text_action_time_to_end');
			$data['special_time_left_long'] = $this->language->get('special_time_left_long');
			
			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_list'] = $this->language->get('button_list');
			$data['button_grid'] = $this->language->get('button_grid');
			$data['button_special'] = $this->language->get('button_special');
			$data['button_continue'] = $this->language->get('button_continue');
			
			$data['text_days'] = $this->language->get('text_days');
			$data['text_hours'] = $this->language->get('text_hours');
			$data['text_minutes'] = $this->language->get('text_minutes');
			$data['text_seconds'] = $this->language->get('text_seconds');
			
			if (isset($this->request->get['special_id'])) {
				$special_id = $this->request->get['special_id'];
				} else {
				$special_id = 0;
			}
			
			$result = $this->model_catalog_ochelp_special->getSpecial($this->request->get['special_id']);
			
			if ($result) {
				
				
				if ($result['meta_title']) {
					$this->document->setTitle($result['meta_title']);
					} else {
					$this->document->setTitle($result['title']);
				}
				
				$this->document->setDescription($result['meta_description']);
				$this->document->setKeywords($result['meta_keyword']);
				
				if ($result['meta_h1']) {
					$data['heading_title'] = $result['meta_h1'];
					} else {
					$data['heading_title'] = $result['title'];
				}								
				
				$this->document->addLink($this->url->link('information/ochelp_special', 'special_id=' . $this->request->get['special_id']), 'canonical');
				
				
				if ($this->config->get('special_setting')) {
					$setting = $this->config->get('special_setting');
					} else {
					$setting['special_thumb_width'] = '220';
					$setting['special_thumb_height'] = '220';
					$setting['special_popup_width'] = '560';
					$setting['special_popup_height'] = '560';
				}
				
				if (isset($setting['share'])) {
					$data['share'] = $setting['share'];
					} else {
					$data['share'] = false;
				}
				
				if (isset($result['counter'])) {
					$data['counter'] = $result['counter'];
					} else {
					$data['counter'] = false;
				}
				
				$this->load->model('tool/image');
				
				if ($result['image']) {
					$data['thumb'] = $this->model_tool_image->resize($result['image'], $setting['special_thumb_width'], $setting['special_thumb_height']);
					} else {
					$data['thumb'] = '';
				}
				
				if ($result['banner']) {
					$data['banner'] = $this->model_tool_image->resize($result['banner'], $setting['special_popup_width'], $setting['special_popup_height']);
					} else {
					$data['banner'] = '';
				}
				
				if ($this->config->get('hb_snippets_og_enable') == '1'){
					
					$this->document->setOpengraph('og:title', $data['heading_title']);
					$this->document->setOpengraph('og:type', 'website');
					$this->document->setOpengraph('og:site_name', $this->config->get('config_name'));
					if ($data['banner']){
						$this->document->setOpengraph('og:image', $data['banner']);
						$this->document->setOgImage($data['banner']);
					}
					$this->document->setOpengraph('og:url', $this->url->link('information/ochelp_special', 'special_id=' . $this->request->get['special_id']));
					$this->document->setOpengraph('og:description', $result['description']);
				}
				
				$data['posted'] = date($this->language->get('date_format_short'), strtotime($result['date_added']));
				
				$data['description'] = html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8');
				
				if($result['date_end'] == '0000-00-00' || $result['date_end'] < date('Y-m-d') || $result['date_end'] == '0'){
					$data['date_end'] = false;
					}else{
					$data['date_end'] = date('Y-m-d', strtotime($result['date_end']));
				}
				
				$data['special_date_diff'] = $data['date_end'];
				
				$data['special_list'] = $this->url->link('information/ochelp_special');
				$data['continue'] = $this->url->link('common/home');
				$data['compare'] = $this->url->link('product/compare');
				
				$data['products'] = array();
					
					
					
				$filter_data = array(
				'special_id' => $result['special_id'],
				'sort'       => $sort,
				'order'      => $order,
				'start'      => ($page - 1) * $limit,
				'limit'      => $limit,
				);
				$data['show_stock'] = true;
				$product_total = $this->model_catalog_ochelp_special->getTotalSpecialProducts($result['special_id']);
				
				$results = $this->model_catalog_ochelp_special->getSpecialProducts($filter_data);
				
				foreach ($results as $result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
						} else {
						$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
					}
					
					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						} else {
						$price = false;
					}
					
					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						} else {
						$special = false;
					}
					
					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
						} else {
						$tax = false;
					}
					
					if ($this->config->get('config_review_status')) {
						$rating = (int)$result['rating'];
						} else {
						$rating = false;
					}
					
					$data['products'][] = array(
                    'product_id'  => $result['product_id'],
                    'seo'  => '',//$result['seo'],
                    'thumb'       => $image,
                    'quantity'    => $result['quantity'],
                    'name'        => $result['name'],
                    'review_status'        => true,
                    'reviews'        => $result['reviews'],
                    'rating'        => $result['rating'],
                    'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
                    'price'       => $price,
                    'special'     => $special,
                    'tax'         => $tax,
                    'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
                    'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url)
					);
				}
				
				
				//Еще акции
				$filter_data = array(
				'sort' => 'rand()',
				'order' => 'DESC',
				'exclude' => $this->request->get['special_id'],
				'start' => 0,
				'limit' => 3,
				);
				
				$results = $this->model_catalog_ochelp_special->getSpecials($filter_data);
				$data['specials'] = $this->prepareSpecialsArchive($results);
				
				$data['text_more_actions'] = $this->language->get('text_more_actions');
				$data['text_more'] = $this->language->get('text_more');
				
				$url = '';
				
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
				
				$data['sorts'] = array();
				
				$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('information/ochelp_special/info', 'special_id=' . $this->request->get['special_id'] . '&sort=p.sort_order&order=ASC' . $url)
				);
				
				$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('information/ochelp_special/info', 'special_id=' . $this->request->get['special_id'] . '&sort=pd.name&order=ASC' . $url)
				);
				
				$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('information/ochelp_special/info', 'special_id=' . $this->request->get['special_id'] . '&sort=pd.name&order=DESC' . $url)
				);
				
				$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('information/ochelp_special/info', 'special_id=' . $this->request->get['special_id'] . '&sort=p.price&order=ASC' . $url)
				);
				
				$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('information/ochelp_special/info', 'special_id=' . $this->request->get['special_id'] . '&sort=p.price&order=DESC' . $url)
				);
				
				if ($this->config->get('config_review_status')) {
					$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('information/ochelp_special/info', 'special_id=' . $this->request->get['special_id'] . '&sort=rating&order=DESC' . $url)
					);
					
					$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('information/ochelp_special/info', 'special_id=' . $this->request->get['special_id'] . '&sort=rating&order=ASC' . $url)
					);
				}
				
				$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('information/ochelp_special/info', 'special_id=' . $this->request->get['special_id'] . '&sort=p.model&order=ASC' . $url)
				);
				
				$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('information/ochelp_special/info', 'special_id=' . $this->request->get['special_id'] . '&sort=p.model&order=DESC' . $url)
				);
				
				$url = '';
				
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}
				
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
				
				$data['limits'] = array();
				
				$limits = array_unique(array($this->config->get('config_product_limit'), 25, 50, 75, 100));
				
				sort($limits);
				
				foreach($limits as $value) {
					$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('information/ochelp_special/info', 'special_id=' . $this->request->get['special_id'] . $url . '&limit=' . $value)
					);
				}
				
				$url = '';
				
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}
				
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
				
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
				
				$pagination = new Pagination();
				$pagination->total = $product_total;
				$pagination->page = $page;
				$pagination->limit = $limit;
				$pagination->url = $this->url->link('information/ochelp_special/info', 'special_id=' . $this->request->get['special_id'] .  $url . '&page={page}');
				
				$data['pagination'] = $pagination->render();
				
				$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));
				
				// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
				if ($page == 1) {
					$this->document->addLink($this->url->link('information/ochelp_special/info', 'special_id=' . $this->request->get['special_id'], 'SSL'), 'canonical');
					} elseif ($page == 2) {
					$this->document->addLink($this->url->link('information/ochelp_special/info', 'special_id=' . $this->request->get['special_id'], 'SSL'), 'prev');
					} else {
					$this->document->addLink($this->url->link('information/ochelp_special/info', 'special_id=' . $this->request->get['special_id'] . $url . '&page='. ($page - 1), 'SSL'), 'prev');
				}
				
				if ($limit && ceil($product_total / $limit) > $page) {
					$this->document->addLink($this->url->link('information/ochelp_special/info', 'special_id=' . $this->request->get['special_id'] . $url . '&page='. ($page + 1), 'SSL'), 'next');
				}
				
				$data['sort'] = $sort;
				$data['order'] = $order;
				$data['limit'] = $limit;
				
				$data['continue'] = $this->url->link('common/home');
				
				$data['column_left'] = $this->load->controller('common/column_left');
				$data['column_right'] = $this->load->controller('common/column_right');
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');
				
				$this->response->setOutput($this->load->view('information/ochelp_special', $data));
				
				} else {
				$url = '';
				
				if (isset($this->request->get['special_id'])) {
					$url .= '&special_id=' . $this->request->get['special_id'];
				}
				
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}
				
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
				
				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}
				
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
				
				$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('information/ochelp_special/info', $url),
				);
				
				$this->document->setTitle($this->language->get('text_error'));
				
				$data['heading_title'] = $this->language->get('text_error');
				
				$data['text_error'] = $this->language->get('text_error');
				
				$data['button_continue'] = $this->language->get('button_continue');
				
				$data['continue'] = $this->url->link('common/home');
				
				$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
				
				$data['column_left'] = $this->load->controller('common/column_left');
				$data['column_right'] = $this->load->controller('common/column_right');
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');
				
				$this->response->setOutput($this->load->view('error/not_found', $data));
			}
		}
	}													