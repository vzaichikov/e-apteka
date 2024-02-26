<?php
	class ControllerProductSpecial extends Controller {
		public function index() {
			$this->load->language('product/special');
			
			$this->load->model('catalog/product');
			
			$this->load->model('tool/image');
			
			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
				} else {
				$sort = 'p.xrating';
			}
			
			if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
				} else {
				$order = 'DESC';
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
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrumb_home'),
			'href' => $this->url->link('common/home')
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
			
			$data['heading_title'] = $this->language->get('heading_title');
			
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
			$data['text_not_in_stock'] = $this->language->get('text_not_in_stock');
			$data['text_has_analogs'] 	= $this->language->get('text_has_analogs');
			$data['text_dl_receipt'] = $this->language->get('text_dl_receipt');
			
			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_list'] = $this->language->get('button_list');
			$data['button_grid'] = $this->language->get('button_grid');
			$data['button_continue'] = $this->language->get('button_continue');
			
			$data['compare'] = $this->url->link('product/compare');
			
			$data['products'] = array();
			
			$filter_data = array(
			'sort'  				=> $sort,
			'order' 				=> $order,
			'filter_notnull_price' 	=> true,
			'filter_in_stock' 		=> true,
			'start' 				=> ($page - 1) * $limit,			
			'limit' 				=> $limit
			);
			
			$product_total = $this->model_catalog_product->getTotalProductSpecials();
			$product_total_info = $this->model_catalog_product->getTotalProductsInfo($filter_data);
			$data['seo'] = array(
			'name' 			=> 'Action',
			'offerCount' 	=> $product_total_info['total'],
			'highPrice' 	=> $product_total_info['max_price'],
			'lowPrice' 	=> $product_total_info['min_price'],
			'priceCurrency' => $this->session->data['currency'],
			);
			$results = $this->model_catalog_product->getProductSpecials($filter_data);			
			$data['products'] = $this->model_catalog_product->prepareProductArray($results);
			
			$url = '';
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			
			$data['text_name_order_count_asc'] = $this->language->get('text_name_order_count_asc');
			$data['text_name_order_count_desc'] = $this->language->get('text_name_order_count_desc');
			
			$data['sorts'] = array();
			
			$data['sorts'][] = array(
			'text'  => $this->language->get('text_default'),
			'value' => 'rating-DESC',
			'href'  => $this->url->link('product/special', '&sort=p.order_count&order=DESC' . $url)
			);
			
			$data['sorts'][] = array(
			'text'  => $this->language->get('text_price_asc'),
			'value' => 'p.price-ASC',
			'href'  => $this->url->link('product/special', '&sort=p.price&order=ASC' . $url)
			);
			
			$data['sorts'][] = array(
			'text'  => $this->language->get('text_price_desc'),
			'value' => 'p.price-DESC',
			'href'  => $this->url->link('product/special', '&sort=p.price&order=DESC' . $url)
			);			
			
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$data['loadmore_button'] 		= $this->config->get('loadmore_button_name_'.$this->config->get('config_language_id'));
			$data['loadmore_status'] 		= $this->config->get('loadmore_status');
			$data['loadmore_style'] 		= $this->config->get('loadmore_style');
			$data['loadmore_arrow_status'] 	= $this->config->get('loadmore_arrow_status');
			
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
				'href'  => $this->url->link('product/special', $url . '&limit=' . $value)
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
			$pagination->url = $this->url->link('product/special', $url . '&page={page}');
			
			$data['pagination'] = $pagination->render();
			
			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));
			
			// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
			if ($page == 1) {
				$this->document->addLink($this->url->link('product/special', '', true), 'canonical');
				} elseif ($page == 2) {
				$this->document->addLink($this->url->link('product/special', '', true), 'prev');
				} else {
				$this->document->addLink($this->url->link('product/special', 'page='. ($page - 1), true), 'prev');
			}
			
			if ($limit && ceil($product_total / $limit) > $page) {
				$this->document->addLink($this->url->link('product/special', 'page='. ($page + 1), true), 'next');
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
			
			$this->response->setOutput($this->load->view('product/special', $data));
		}
	}
