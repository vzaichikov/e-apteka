<?php
	class ControllerProductSocialProgram extends Controller {
		
		public function listing(){
			$this->load->language('product/socialprogram');
			
			$this->load->model('catalog/socialprogram');
			$this->load->model('catalog/category');
			$this->load->model('catalog/product');
			$this->load->model('catalog/manufacturer');
			
			$this->load->model('tool/image');
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
			);
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_socialprograms'),
			'href' => $this->url->link('product/socialprogram/listing')
			);					
			
			$data['heading_title'] = $this->language->get('text_socialprograms');
			
			$data['socialprograms'] = array();
			$results = $this->model_catalog_socialprogram->getAllSocialprograms();	
			
			foreach ($results as $result) {
					
					if ($result['banner']) {
						$image = $this->model_tool_image->resize($result['banner'], 460, 200);
						} else {
						$image = $this->model_tool_image->resize('placeholder.png', 460, 200);
					}
					
					
					$data['socialprograms'][] = array(
					'name' 				=> $result['name'],
					'mini_description' 	=> $result['mini_description'],
					'image' 			=> $image,
					'href' 				=> $this->url->link('product/socialprogram', 'sopath=' . $this->request->get['sopath'] . '_' . $result['socialprogram_id'])
					);
				}
			
			$data['continue'] = $this->url->link('common/home');
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			
			$this->response->setOutput($this->load->view('product/socialprogram', $data));
		}
		
		
		public function index() {		
			$this->load->language('product/socialprogram');
			
			$this->load->model('catalog/socialprogram');
			$this->load->model('catalog/category');
			$this->load->model('catalog/product');
			$this->load->model('catalog/manufacturer');
			
			$this->load->model('tool/image');
			
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
			);
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_socialprograms'),
			'href' => $this->url->link('product/socialprogram/listing')
			);
			
			if (isset($this->request->get['sopath'])) {
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
				
				$sopath = '';
				
				$parts = explode('_', (string)$this->request->get['sopath']);
				
				$socialprogram_id = (int)array_pop($parts);
				
				$socialprogram_info = $this->model_catalog_socialprogram->getSocialprogram($socialprogram_id);		
				
				if ($socialprogram_info['manufacturer_id']) {
					$this->load->model('catalog/manufacturer');			
					$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($socialprogram_info['manufacturer_id']);
					
					$data['breadcrumbs'][] = array(
					'text' => $manufacturer_info['name'],
					'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $socialprogram_info['manufacturer_id'])
					);
				}
				
				foreach ($parts as $sopath_id) {
					if (!$sopath) {
						$sopath = (int)$sopath_id;
						} else {
						$sopath .= '_' . (int)$sopath_id;
					}
					
					$socialprogram_info = $this->model_catalog_socialprogram->getSocialprogram($sopath_id);										
					
					if ($socialprogram_info) {								
						$data['breadcrumbs'][] = array(
						'text' => $socialprogram_info['name'],
						'href' => $this->url->link('product/socialprogram', 'sopath=' . $sopath . $url)
						);
					}
				}
				} else {
				$socialprogram_id = 0;
			}
			
			$socialprogram_info = $this->model_catalog_socialprogram->getSocialprogram($socialprogram_id);
			
			if ($socialprogram_info) {
				
				if ($socialprogram_info['meta_title']) {
					$this->document->setTitle($socialprogram_info['meta_title']);
					} else {
					$this->document->setTitle($socialprogram_info['name']);
				}
				
				$data['socialprogram_name'] = $socialprogram_info['name'];
				$data['current_href'] = $this->url->link('product/socialprogram', 'sopath=' . $socialprogram_info['socialprogram_id'], true);
				
				
				if ($socialprogram_info['ratedata']){
					$data['ratedata'] = json_decode($socialprogram_info['ratedata'], true);
					} else {
					$data['ratedata'] = false;
				}
				
				$this->document->setDescription($socialprogram_info['meta_description']);
				$this->document->setKeywords($socialprogram_info['meta_keyword']);
				
				if ($socialprogram_info['meta_h1']) {
					$data['heading_title'] = $socialprogram_info['meta_h1'];
					} else {
					$data['heading_title'] = $socialprogram_info['name'];
				}
				
				
				$this->session->data['view_from'] = $socialprogram_info['name'];
				$data['currency'] = $this->session->data['currency'];
				
				$data['text_refine'] = $this->language->get('text_refine');
				$data['text_empty'] = $this->language->get('text_empty');
				$data['text_quantity'] = $this->language->get('text_quantity');
				$data['text_manufacturer'] = $this->language->get('text_manufacturer');
				$data['text_model'] = $this->language->get('text_model');
				$data['text_price'] = $this->language->get('text_price');
				$data['text_tax'] = $this->language->get('text_tax');
				$data['text_points'] = $this->language->get('text_points');
				$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
				$data['text_sort'] = $this->language->get('text_sort');
				$data['text_limit'] = $this->language->get('text_limit');
				
				$data['button_cart'] = $this->language->get('button_cart');
				$data['button_wishlist'] = $this->language->get('button_wishlist');
				$data['button_compare'] = $this->language->get('button_compare');
				$data['button_continue'] = $this->language->get('button_continue');
				$data['button_list'] = $this->language->get('button_list');
				$data['button_grid'] = $this->language->get('button_grid');
				
				
				$data['show_list'] = $socialprogram_info['list'];
				
				if ($socialprogram_info['image']) {
					$data['thumb'] = $this->model_tool_image->resize($socialprogram_info['image'], 1200, 500, false);				
					} else {
					$data['thumb'] = '';
				}
				
				if ($socialprogram_info['banner']) {
					$data['banner'] = $this->model_tool_image->resize($socialprogram_info['banner'], 1289, 531, false);				
					} else {
					$data['banner'] = '';
				}
				
				$data['description'] = html_entity_decode($socialprogram_info['description'], ENT_QUOTES, 'UTF-8');
				$data['compare'] = $this->url->link('product/compare');
				
				
				$data['socialprograms'] = array();
				
				$results = $this->model_catalog_socialprogram->getSocialprograms($socialprogram_id);
				
				foreach ($results as $result) {
					$filter_data = array(
					'filter_socialprogram_id'  => $result['socialprogram_id'],
					'filter_sub_socialprogram' => true
					);
					
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
						} else {
						$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
					}
					
					
					$data['socialprograms'][] = array(
					'name' 				=> $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
					'mini_description' 	=> $result['mini_description'],
					'image' 			=> $image,
					'href' 				=> $this->url->link('product/socialprogram', 'sopath=' . $this->request->get['sopath'] . '_' . $result['socialprogram_id'] . $url)
					);
				}
				
				
				$data['products'] = array();
				
				$filter_data = array(
				'filter_socialprogram_id' => $socialprogram_id,
				'filter_filter'      => $filter,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
				);
				
				$product_total = $this->model_catalog_product->getTotalProducts($filter_data);
				
				$results = $this->model_catalog_product->getProducts($filter_data);
				$data['products'] = $this->model_catalog_product->prepareProductArray($results);
				
				// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
				if ($page == 1) {
					$this->document->addLink($this->url->link('product/socialprogram', 'sopath=' . $socialprogram_info['socialprogram_id'], true), 'canonical');
					} elseif ($page == 2) {
					$this->document->addLink($this->url->link('product/socialprogram', 'sopath=' . $socialprogram_info['socialprogram_id'], true), 'prev');
					} else {
					$this->document->addLink($this->url->link('product/socialprogram', 'sopath=' . $socialprogram_info['socialprogram_id'] . '&page='. ($page - 1), true), 'prev');
				}
				
				if ($page > 1){
					$this->document->addLink($this->url->link('product/socialprogram', 'sopath=' . $socialprogram_info['socialprogram_id'] .  '&page=' . ($page)) , 'canonical');
					$this->document->setRobots("noindex, follow");
				}
				
				if ($limit && ceil($product_total / $limit) > $page) {
					$this->document->addLink($this->url->link('product/socialprogram', 'sopath=' . $socialprogram_info['socialprogram_id'] . '&page='. ($page + 1), true), 'next');
				}
				
				if ($page > 1){
					$this->document->setTitle(sprintf($this->language->get('text_page'), (int)$page) . $this->document->getTitle());
					$this->document->setDescription(sprintf($this->language->get('text_page'), (int)$page) . $this->document->getDescription());
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
				
				$this->response->setOutput($this->load->view('product/socialprogram', $data));
				} else {
				$url = '';
				
				if (isset($this->request->get['sopath'])) {
					$url .= '&sopath=' . $this->request->get['sopath'];
				}
				
				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
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
				'href' => $this->url->link('product/socialprogram', $url)
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
