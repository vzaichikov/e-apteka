<?php
	class ControllerProductCollection extends Controller {
		
		public function listing(){
			$this->load->language('product/collection');
			$this->load->model('catalog/collection');
			$this->load->model('tool/image');
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
			);
			
			$data['collections'] = array();
			
			$results = $this->model_catalog_collection->getCollections(0);
			
			foreach ($results as $result) {
				$filter_data = array(
				'filter_collection_id'  => $result['collection_id'],
				'filter_sub_collection' => true
				);
				
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
					} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
				}
				
				
				$data['collections'][] = array(
				'name' 				=> $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
				'mini_description' 	=> $result['mini_description'],
				'image' 			=> $image,
				'href' 				=> $this->url->link('product/collection', 'colpath=' . $this->request->get['colpath'] . '_' . $result['collection_id'] . $url)
				);
			}
			
			$this->document->setTitle($this->language->get('text_collections'));
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			
			$this->response->setOutput($this->load->view('product/collection', $data));
			
		}
		
		
		public function index() {				
			$this->load->language('product/collection');
						
			$this->load->model('catalog/collection');
			$this->load->model('catalog/category');
			$this->load->model('catalog/product');
			$this->load->model('catalog/manufacturer');		
			$this->load->model('tool/image');
			
			if (isset($this->request->get['filter'])) {
				$filter = $this->request->get['filter'];
				} else {
				$filter = '';
			}
			
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
				$limit = (int)$this->request->get['limit'];
				} else {
				$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
			}
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
			);
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_collections'),
			'href' => $this->url->link('product/collection/listing')
			);
			
			if (isset($this->request->get['colpath'])) {
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
				
				$colpath = '';
				
				$parts = explode('_', (string)$this->request->get['colpath']);
				
				$collection_id = (int)array_pop($parts);
				$collection_info = $this->model_catalog_collection->getCollection($collection_id);		
			/*	
				if ($collection_info['manufacturer_id']) {
					$this->load->model('catalog/manufacturer');			
					$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($collection_info['manufacturer_id']);
					
					$data['breadcrumbs'][] = array(
					'text' => $manufacturer_info['name'],
					'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $collection_info['manufacturer_id'])
					);
				}
			*/
				
				foreach ($parts as $colpath_id) {
					if (!$colpath) {
						$colpath = (int)$colpath_id;
						} else {
						$colpath .= '_' . (int)$colpath_id;
					}
					
					$collection_info = $this->model_catalog_collection->getCollection($colpath_id);										
					
					if ($collection_info) {								
						$data['breadcrumbs'][] = array(
						'text' => $collection_info['name'],
						'href' => $this->url->link('product/collection', 'colpath=' . $colpath . $url)
						);
					}
				}
				} else {
				$collection_id = 0;
			}
			
			$collection_info = $this->model_catalog_collection->getCollection($collection_id);
			
			if ($collection_info) {
				
				if ($collection_info['meta_title']) {
					$this->document->setTitle($collection_info['meta_title']);
					} else {
					$this->document->setTitle($collection_info['name']);
				}
				
				$data['collection_name'] = $collection_info['name'];
				$data['current_href'] = $this->url->link('product/collection', 'colpath=' . $collection_info['collection_id'], true);
				
				
				$this->document->setDescription($collection_info['meta_description']);
				$this->document->setKeywords($collection_info['meta_keyword']);
				
				if ($collection_info['meta_h1']) {
					$data['heading_title'] = $collection_info['meta_h1'];
					} else {
					$data['heading_title'] = $collection_info['name'];
				}
				
				
				$this->session->data['view_from'] = $collection_info['name'];
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
				
				
				
				
				/*	
					// Set the last collection breadcrumb
					$data['breadcrumbs'][] = array(
					'text' => $collection_info['name'],
					'href' => $this->url->link('product/collection', 'colpath=' . $this->request->get['colpath'])
					);
				*/
				
				$data['show_list'] = $collection_info['list'];
				
				if ($collection_info['image']) {
					$data['thumb'] = $this->model_tool_image->resize($collection_info['image'], 1200, 500, false);				
					} else {
					$data['thumb'] = '';
				}
				
				if ($collection_info['banner']) {
					$data['banner'] = $this->model_tool_image->resize($collection_info['banner'], 1289, 531, false);				
					} else {
					$data['banner'] = '';
				}
				
				$data['description'] = html_entity_decode($collection_info['description'], ENT_QUOTES, 'UTF-8');
				$data['compare'] = $this->url->link('product/compare');
				
				$url = '';
				
				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}
				
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}
				
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
				
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
				
				$data['collections'] = array();
				
				$results = $this->model_catalog_collection->getCollections($collection_id);
				
				foreach ($results as $result) {
					$filter_data = array(
					'filter_collection_id'  => $result['collection_id'],
					'filter_sub_collection' => true
					);
					
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], 500, 300);
						} else {
						$image = $this->model_tool_image->resize('placeholder.png', 500, 300);
					}
					
					
					$data['collections'][] = array(
					'name' 				=> $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
					'mini_description' 	=> $result['mini_description'],
					'image' 			=> $image,
					'href' 				=> $this->url->link('product/collection', 'colpath=' . $this->request->get['colpath'] . '_' . $result['collection_id'] . $url)
					);
				}
				
				
				$data['products'] = array();
				
				$filter_data = array(
				'filter_collection_id' => $collection_id,
				'filter_sub_collection' => true,
				'filter_filter'      => $filter,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
				);
				
				$product_total = $this->model_catalog_product->getTotalProducts($filter_data);
				
				$results = $this->model_catalog_product->getProducts($filter_data);
				$data['products'] = $this->model_catalog_product->prepareProductArray($results);
				
				$url = '';
				
				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}
				
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
				
				$data['sorts'] = array();
				
				$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/collection', 'colpath=' . $this->request->get['colpath'] . '&sort=p.sort_order&order=ASC' . $url)
				);
				
				$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/collection', 'colpath=' . $this->request->get['colpath'] . '&sort=pd.name&order=ASC' . $url)
				);
				
				$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/collection', 'colpath=' . $this->request->get['colpath'] . '&sort=pd.name&order=DESC' . $url)
				);
				
				$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/collection', 'colpath=' . $this->request->get['colpath'] . '&sort=p.price&order=ASC' . $url)
				);
				
				$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/collection', 'colpath=' . $this->request->get['colpath'] . '&sort=p.price&order=DESC' . $url)
				);
				
				if ($this->config->get('config_review_status')) {
					$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/collection', 'colpath=' . $this->request->get['colpath'] . '&sort=rating&order=DESC' . $url)
					);
					
					$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/collection', 'colpath=' . $this->request->get['colpath'] . '&sort=rating&order=ASC' . $url)
					);
				}
				
				$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/collection', 'colpath=' . $this->request->get['colpath'] . '&sort=p.model&order=ASC' . $url)
				);
				
				$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/collection', 'colpath=' . $this->request->get['colpath'] . '&sort=p.model&order=DESC' . $url)
				);
				
				$url = '';
				
				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}
				
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}
				
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
				
				$data['limits'] = array();
				
				$limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));
				
				sort($limits);
				
				foreach($limits as $value) {
					$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/collection', 'colpath=' . $this->request->get['colpath'] . $url . '&limit=' . $value)
					);
				}
				
				$url = '';
				
				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}
				
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
					$this->document->setRobotsMeta("noindex, follow");
				}
				
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
					$this->document->setRobotsMeta("noindex, follow");
				}
				
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
					$this->document->setRobotsMeta("noindex, follow");
				}
				
				$pagination = new Pagination();
				$pagination->total = $product_total;
				$pagination->page = $page;
				$pagination->limit = $limit;
				$pagination->url = $this->url->link('product/collection', 'colpath=' . $this->request->get['colpath'] . $url . '&page={page}');
				
				$data['pagination'] = $pagination->render();
				
				$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));
				
				//big page fix
				if ($product_total > 0 && ceil($product_total / $limit) < $page){
					$this->response->redirect($this->url->link('product/collection', 'colpath=' . $collection_info['collection_id']));
				}
				
				// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
				if ($page == 1) {
					$this->document->addLink($this->url->link('product/collection', 'colpath=' . $collection_info['collection_id'], true), 'canonical');
					} elseif ($page == 2) {
					$this->document->addLink($this->url->link('product/collection', 'colpath=' . $collection_info['collection_id'], true), 'prev');
					} else {
					$this->document->addLink($this->url->link('product/collection', 'colpath=' . $collection_info['collection_id'] . '&page='. ($page - 1), true), 'prev');
				}
				
				if ($page > 1){
					$this->document->addLink($this->url->link('product/collection', 'colpath=' . $collection_info['collection_id'] .  '&page=' . ($page)) , 'canonical');
					$this->document->setRobotsMeta("noindex, follow");
				}
				
				if ($limit && ceil($product_total / $limit) > $page) {
					$this->document->addLink($this->url->link('product/collection', 'colpath=' . $collection_info['collection_id'] . '&page='. ($page + 1), true), 'next');
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
				
				$this->response->setOutput($this->load->view('product/collection', $data));
				} else {
				$url = '';
				
				if (isset($this->request->get['colpath'])) {
					$url .= '&colpath=' . $this->request->get['colpath'];
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
				'href' => $this->url->link('product/collection', $url)
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
