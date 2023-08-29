<?php
	class ControllerProductCategory extends Controller {
		public function index() {
			$this->load->language('product/category');
			
			$this->load->model('catalog/category');
			$this->load->model('catalog/product');
			
			$this->load->model('tool/image');
			
			if (isset($this->request->get['filter'])) {
				$filter = $this->request->get['filter'];
				} else {
				$filter = '';
			}
			
			if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
				} else {
				$order = 'DESC';
			}
			
			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
				} else {
				$sort = 'rating';
			}
			
			if (isset($this->request->get['page'])) {
				$this->document->addLink($this->url->link('product/category', 'path=' . $this->request->get['path'] . '&page=' . $this->request->get['page'], true), 'canonical');
				$page = (int)$this->request->get['page'];
				} else {
				$this->document->addLink($this->url->link('product/category', 'path=' . $this->request->get['path'], true), 'canonical');
				$page = 1;
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = (int)$this->request->get['limit'];
				} else {
				$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
			}
			
			// OCFilter start
			if (isset($this->request->get['filter_ocfilter'])) {
				$filter_ocfilter = $this->request->get['filter_ocfilter'];
				} else {
				$filter_ocfilter = '';
			}
			// OCFilter end
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
            'text' => $this->language->get('breadcrumb_home'),
            //'text' => '<svg class="icon breadcrumb__home-icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#home"></use></svg>',
            'href' => $this->url->link('common/home')
			);
			
			if (isset($this->request->get['path'])) {
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
				
				$path = '';
				
				$parts = explode('_', (string)$this->request->get['path']);
				
				$category_id = (int)array_pop($parts);
				$parts = explode('_', (string)$this->model_catalog_category->getFullCategoryPath($category_id));
				
				foreach ($parts as $path_id) {
					if (!$path) {
						$path = (int)$path_id;
						} else {
						$path .= '_' . (int)$path_id;
					}
					
					$category_info = $this->model_catalog_category->getCategory($path_id);
					
					if ($category_info) {
						$data['breadcrumbs'][] = array(
                        'text' => $category_info['name'],
                        'href' => $this->url->link('product/category', 'path=' . $path . $url)
						);
					}
				}
				} else {
				$category_id = 0;
			}
			
			$this->load->model('setting/setting');
			$current_language_id = $this->config->get('config_language_id');
			$data['loadmore_button'] = $this->config->get('loadmore_button_name_'.$current_language_id);
			$data['loadmore_status'] = $this->config->get('loadmore_status');
			$data['loadmore_style'] = $this->config->get('loadmore_style');
			$data['loadmore_arrow_status'] = $this->config->get('loadmore_arrow_status');
			
			
			$category_info = $this->model_catalog_category->getCategory($category_id);
			
			if ($category_info) {
				
				if (isset($this->request->get['search']) && $this->config->get('config_customer_search')) {
                    $this->load->model('account/search');                                       
                    
                    $search_data = array(
                    'keyword'       => $this->request->get['search'],                    
                    'entity_type'   => 'c',
					'entity_id'   	=> $category_info['category_id'],
                    );
                    
                    $this->model_account_search->addSearchIDX($search_data);
				}
				
				
				$this->document->setTitle($category_info['meta_title']);
				$this->document->setDescription($category_info['meta_description']);
				$this->document->setKeywords($category_info['meta_keyword']);						
				
				$data['heading_title'] = trim($category_info['seo_name'])?$category_info['seo_name']:$category_info['name'];
				
				$data['text_refine'] 		= $this->language->get('text_refine');
				$data['text_empty'] 		= $this->language->get('text_empty');
				$data['text_quantity'] 		= $this->language->get('text_quantity');
				$data['text_manufacturer'] 	= $this->language->get('text_manufacturer');
				$data['text_model'] 		= $this->language->get('text_model');
				$data['text_price'] 		= $this->language->get('text_price');
				$data['text_tax'] 			= $this->language->get('text_tax');
				$data['text_points'] 		= $this->language->get('text_points');
				$data['text_compare'] 		= sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
				$data['text_sort'] 			= $this->language->get('text_sort');
				$data['text_limit'] 		= $this->language->get('text_limit');
				$data['text_not_in_stock'] 	= $this->language->get('text_not_in_stock');
				$data['text_has_analogs'] 	= $this->language->get('text_has_analogs');
				$data['text_dl_receipt'] 	= $this->language->get('text_dl_receipt');
				
				$data['text_name_order_count_asc'] = $this->language->get('text_name_order_count_asc');
				$data['text_name_order_count_desc'] = $this->language->get('text_name_order_count_desc');
				$data['status_widget'] = (int)$category_info['status_widget'];
				$data['button_cart'] = $this->language->get('button_cart');
				$data['button_wishlist'] = $this->language->get('button_wishlist');
				$data['button_compare'] = $this->language->get('button_compare');
				$data['button_continue'] = $this->language->get('button_continue');
				$data['button_list'] = $this->language->get('button_list');
				$data['button_grid'] = $this->language->get('button_grid');
				
				$data['text_write'] = $this->language->get('text_write');
				$data['text_writes'] = $this->language->get('text_writes');
				
				$data['text_special_time_to_left'] = $this->language->get('text_special_time_to_left');
				
				/*
					// Set the last category breadcrumb
					$data['breadcrumbs'][] = array(
					'text' => $category_info['name'],
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'])
					);
				*/
				
				if ($category_info['image']) {
					$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get($this->config->get('config_theme') . '_image_category_width'), $this->config->get($this->config->get('config_theme') . '_image_category_height'));
					} else {
					$data['thumb'] = '';
				}
				if ($category_info['icon']) {
					$data['icon'] = $category_info['icon'];
					} else {
					$data['icon'] = '';
				}
				
				$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
				$data['compare'] = $this->url->link('product/compare');
				
				$this->load->model('tool/tool');
				$data['description'] = $this->model_tool_tool->clear_tags($data['description']);
				
				
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
				
				
				
				$data['categories'] = array();								
				if ($this->mobileDetect->isMobile() && $page == 1 && !$category_info['show_subcats']){
					$results = $this->model_catalog_category->getCategories($category_id);
					
					foreach ($results as $result) {
						$filter_data = array(
						'filter_category_id'  => $result['category_id'],
						'filter_sub_category' => true
						);
						
						$data['categories'][] = array(
						'icon' => $result['icon'],					
						'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
						);
					}	
				}
				
				$data['products'] = array();
				
				$filter_data = array(
                'filter_category_id' => $category_id,
                'filter_filter'      => $filter,
                'filter_sub_category' => true,
                'sort'               => $sort,
                'order'              => $order,
                'start'              => ($page - 1) * $limit,
                'limit'              => $limit
				);
				
				// OCFilter start
				$filter_data['filter_ocfilter'] = $filter_ocfilter;
				
				if ($this->config->get('ocfilter_sub_category')) {
					if (empty($filter_data['filter_sub_category'])) {
						$filter_data['filter_sub_category'] = true;
					}
					
					if (isset($this->request->get['filter_ocfilter'])) {
						$data['categories'] = array();
					}
				}
				// OCFilter end
				
				$product_total = $this->model_catalog_product->getTotalProducts($filter_data);
				$product_total_info = $this->model_catalog_product->getTotalProductsInfo($filter_data);
				$data['seo'] = [
                	'name' 			=> $category_info['name'],
                	'offerCount' 	=> $product_total_info['total'],
                	'highPrice' 	=> $product_total_info['max_price'],
                	'lowPrice' 		=> $product_total_info['min_price'],
                	'priceCurrency' => $this->session->data['currency'],
				];
				
				$data['show_subcats'] = $category_info['show_subcats'];
				
				if ($category_info['show_subcats']){
					$data['products'] = array();
					} else {
					$results = $this->model_catalog_product->getProducts($filter_data);
					$data['products'] = $this->model_catalog_product->prepareProductArray($results);
				}
				
				$filter_data = array(
                'filter_category_id' => $category_id,
				'filter_sub_category' => false,
                'start'              => 1,
                'limit'              => 10
				);
				
				$results = $this->model_catalog_product->getProductSpecials($filter_data);
				
				$data['special_products'] = array();
				
				foreach ($results as $result) {
					
					if(!isset($result['product_id'])) continue;
					
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
					
					$data['special_products'][] = array(
                    'product_id'  => $result['product_id'],
                    'seo'  => '', //$result['seo'],
                    'thumb'       => $image,
                    'name'        => $result['name'],
                    'review_status'        => true,
                    'reviews'        => $result['reviews'],
                    'date_end'        => $result['date_end'],
                    'rating'        => $result['rating'],
					'dateDiff' => dateDiff($result['date_end']),
                    'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
                    'price'       => $price,
                    'special'     => $special,
                    'tax'         => $tax,
                    'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
                    'rating'      => $result['rating'],
                    'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url)
					);
				}
				
				
				$url = '';
				
				// OCFilter start
				if (isset($this->request->get['filter_ocfilter'])) {
					$url .= '&filter_ocfilter=' . $this->request->get['filter_ocfilter'];
				}
				// OCFilter end
				
				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}
				
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
				
				$data['sorts'] = array();
				
				$data['sorts'][] = array(
                'text'  => $this->language->get('text_default'),
                'value' => 'rating-DESC',
                'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.order_count&order=DESC' . $url)
				);		
				
				$data['sorts'][] = array(
                'text'  => $this->language->get('text_price_asc'),
                'value' => 'p.price-ASC',
                'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
				);
				
				$data['sorts'][] = array(
                'text'  => $this->language->get('text_price_desc'),
                'value' => 'p.price-DESC',
                'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
				);
				
				
				$url = '';
				
				// OCFilter start
				if (isset($this->request->get['filter_ocfilter'])) {
					$url .= '&filter_ocfilter=' . $this->request->get['filter_ocfilter'];
				}
				// OCFilter end
				
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
				
				$limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 
				$this->config->get($this->config->get('config_theme') . '_product_limit') * 2,
				$this->config->get($this->config->get('config_theme') . '_product_limit') * 3
				));
				
				sort($limits);
				
				foreach($limits as $value) {
					$data['limits'][] = array(
                    'text'  => $value,
                    'value' => $value,
                    'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
					);
				}
				
				$url = '';
				
				// OCFilter start
				if (isset($this->request->get['filter_ocfilter'])) {
					$url .= '&filter_ocfilter=' . $this->request->get['filter_ocfilter'];
				}
				// OCFilter end
				
				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}
				
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
					$this->document->setRobotsMeta("noindex, nofollow");
				}
				
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
					$this->document->setRobotsMeta("noindex, nofollow");
				}
				
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
					$this->document->setRobotsMeta("noindex, nofollow");
				}
				
				if (isset($this->request->get['min_price'])) {
					$this->document->setRobotsMeta("noindex, nofollow");
				}
				
				$pagination = new Pagination();
				$pagination->total = $product_total;
				$pagination->page = $page;
				$pagination->limit = $limit;
				$pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');
				
				$data['pagination'] = $pagination->render();
				
				$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));
				
				//	$this->document->addLink($this->url->link('product/category', 'path=' . $this->request->get['path'], true), 'canonical');
				
				
				// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
				if ($page == 1) {
					$this->document->addLink($this->url->link('product/category', 'path=' . $this->request->get['path'], true), 'canonical');
					} elseif ($page == 2) {
					$this->document->addLink($this->url->link('product/category', 'path=' . $this->request->get['path'], true), 'prev');
					} else {
					$this->document->addLink($this->url->link('product/category', 'path=' . $this->request->get['path'] . '&page='. ($page - 1), true), 'prev');
				}
				
				if ($limit && ceil($product_total / $limit) > $page) {
					$this->document->addLink($this->url->link('product/category', 'path=' . $this->request->get['path'] . '&page='. ($page + 1), true), 'next');
				}
				
				$num_pages = ceil($product_total / $limit);
				
				
				// Canonical
				if ($page > 1) {				
					$this->document->setRobotsMeta("noindex, follow");
				}
				
				// Next
				if ($page < $num_pages) {
					$data['next_page'] = $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&page=' . ($page + 1), true);
					$this->document->addLink($data['next_page'], 'next');
					} else {
					$data['next_page'] = false;
				}
				
				
				// Prev
				if ($page > 1) {
					if ($page == 2) {
						$data['prev_page'] = $this->url->link('product/category', 'path=' . $this->request->get['path'], true);
						$this->document->addLink($data['prev_page'], 'prev');
						} else {
						$data['prev_page'] = $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&page=' . ($page - 1), true);
						$this->document->addLink($data['prev_page'], 'prev');
					}
					} else {
					$data['prev_page'] = false;
				}
				
				$data['sort'] = $sort;
				$data['order'] = $order;
				$data['limit'] = $limit;

				if ($category_id == CATEGORY_SUBSTANCES){
					$this->data['display_small_subcategories'] = 1;
				}
				
				// OCFilter Start
				if (isset($this->request->get['filter_ocfilter'])) {
					if (!$product_total) {
						$this->response->redirect($this->url->link('product/category', 'path=' . $this->request->get['path']));
					}
					
					if (isset($data['description_bottom'])) {
						$data['description_bottom'] = '';
					}
					
					if (isset($data['description_2'])) {
						$data['description_2'] = '';
					}
					
					if (isset($data['description'])) {
						$data['description'] = '';
					}
					
					if (isset($data['ext_description'])) {
						$data['ext_description'] = '';
					}
					
					$this->document->deleteLink('canonical');
					$this->document->deleteLink('prev');
					$this->document->deleteLink('next');
					
					if ($page > 1) {
						$this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&filter_ocfilter=' . $this->request->get['filter_ocfilter'], true), 'canonical');
					}
					
					if ($page == 2) {
						$this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&filter_ocfilter=' . $this->request->get['filter_ocfilter'], true), 'prev');
						} else if ($page > 2) {
						$this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&filter_ocfilter=' . $this->request->get['filter_ocfilter'] . '&page=' . ($page - 1), true), 'prev');
					}
					
					if ($limit && ceil($product_total / $limit) > $page) {
						$this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&filter_ocfilter=' . $this->request->get['filter_ocfilter'] . '&page=' . ($page + 1), true), 'next');
					}
				}
				
				$ocfilter_page_info = $this->load->controller('extension/module/ocfilter/getPageInfo');
				
				if ($ocfilter_page_info) {
					$this->document->setTitle($ocfilter_page_info['meta_title']);
					
					if ($ocfilter_page_info['meta_description']) {
						$this->document->setDescription($ocfilter_page_info['meta_description']);
					}
					
					if ($ocfilter_page_info['meta_keyword']) {
						$this->document->setKeywords($ocfilter_page_info['meta_keyword']);
					}
					
					$data['heading_title'] = $ocfilter_page_info['title'];
					
					if ($ocfilter_page_info['description'] && !isset($this->request->get['page']) && !isset($this->request->get['sort']) && !isset($this->request->get['order']) && !isset($this->request->get['search']) && !isset($this->request->get['limit'])) {
						if (isset($data['description_bottom'])) {
							$data['description_bottom'] = html_entity_decode($ocfilter_page_info['description'], ENT_QUOTES, 'UTF-8');
							} else if (isset($data['description_2'])) {
							$data['description_2'] = html_entity_decode($ocfilter_page_info['description'], ENT_QUOTES, 'UTF-8');
							} else if (isset($data['description'])) {
							$data['description'] = html_entity_decode($ocfilter_page_info['description'], ENT_QUOTES, 'UTF-8');
							} else if (isset($data['ext_description'])) {
							$data['ext_description'] = html_entity_decode($ocfilter_page_info['description'], ENT_QUOTES, 'UTF-8');
						}
					}
					
					$data['breadcrumbs'][] = array(
					'text' => $ocfilter_page_info['title'],
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url)
					);
					} else {
					
					if (isset($this->request->get['filter_ocfilter'])){
						$this->document->setRobotsMeta("noindex, nofollow");
						$this->document->addLink($this->url->link('product/category', 'path=' . $this->request->get['path'], true), 'canonical');
					}
					
					$meta_title = $this->document->getTitle();
					$meta_description = $this->document->getDescription();
					$meta_keyword = $this->document->getKeywords();
					
					$filter_title = $this->load->controller('extension/module/ocfilter/getSelectedsFilterTitle');
					
					if ($filter_title) {
						if (false !== strpos($meta_title, '{filter}')) {
							$meta_title = trim(str_replace('{filter}', $filter_title, $meta_title));
							} else {
							$meta_title .= ' ' . $filter_title;
						}
						
						$this->document->setTitle($meta_title);
						
						if ($meta_description) {
							if (false !== strpos($meta_description, '{filter}')) {
								$meta_description = trim(str_replace('{filter}', $filter_title, $meta_description));
								} else {
								$meta_description .= ' ' . $filter_title;
							}
							
							$this->document->setDescription($meta_description);
						}
						
						if ($meta_keyword) {
							if (false !== strpos($meta_keyword, '{filter}')) {
								$meta_keyword = trim(str_replace('{filter}', $filter_title, $meta_keyword));
								} else {
								$meta_keyword .= ' ' . $filter_title;
							}
							
							$this->document->setKeywords($meta_keyword);
						}
						
						$heading_title = $data['heading_title'];
						
						if (false !== strpos($heading_title, '{filter}')) {
							$heading_title = trim(str_replace('{filter}', $filter_title, $heading_title));
							} else {
							$heading_title .= ' ' . $filter_title;
						}
						
						$data['heading_title'] = $data['seo_h1'] = $heading_title;
						
						$data['description_bottom'] = '';
						$data['description_2'] = '';
						$data['description'] = '';
						$data['ext_description'] = '';
						
						$data['breadcrumbs'][] = array(
						'text' => (utf8_strlen($heading_title) > 30 ? utf8_substr($heading_title, 0, 30) . '..' : $heading_title),
						'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url)
						);
						} else {
						$this->document->setTitle(trim(str_replace('{filter}', '', $meta_title)));
						$this->document->setDescription(trim(str_replace('{filter}', '', $meta_description)));
						$this->document->setKeywords(trim(str_replace('{filter}', '', $meta_keyword)));
						
						$data['heading_title'] = $data['seo_h1'] = trim(str_replace('{filter}', '', $data['heading_title']));
					}
				}
				// OCFilter End
				
				$data['continue'] = $this->url->link('common/home');
				
				if ($category_info['show_subcats']){
					$data['column_left'] = $this->load->controller('common/column_right');
					$data['column_right'] = '';
					} else {
					$data['column_left'] = $this->load->controller('common/column_left');
					$data['column_right'] = $this->load->controller('common/column_right');
				}
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');
				
				
				$banner = $category_info['banner'];
				
				$setting = [
                'width' => 804,
                'height' => 374,
                'width_mobil' => 290,
                'height_mobil' => 440,
                'category' => 1,
				];
				if($banner == 0){
					$setting['banner_id'] = 11;
					}else{
					$setting['banner_id'] = $banner;
				}
				
				$data['banner'] = $this->load->controller('extension/module/banner',  $setting);
				
				$this->response->setOutput($this->load->view('product/category', $data));
				} else {
				$url = '';
				
				if (isset($this->request->get['path'])) {
					$url .= '&path=' . $this->request->get['path'];
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
                'href' => $this->url->link('product/category', $url)
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
	
