<?php
	class ControllerReportProductPurchased extends Controller {
		public function index() {
			$this->load->language('report/product_purchased');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			if (isset($this->request->get['filter_date_start'])) {
				$filter_date_start = $this->request->get['filter_date_start'];
				} else {
				$filter_date_start = '2020-06-01';
			}
			
			if (isset($this->request->get['filter_date_end'])) {
				$filter_date_end = $this->request->get['filter_date_end'];
				} else {
				$filter_date_end = '';
			}
			
			if (isset($this->request->get['filter_order_status_id'])) {
				$filter_order_status_id = $this->request->get['filter_order_status_id'];
				} else {
				$filter_order_status_id = 0;
			}
			
			if (isset($this->request->get['filter_category_id'])) {
				$filter_category_id = $this->request->get['filter_category_id'];
				} else {
				$filter_category_id = 0;
			}
			
			if (isset($this->request->get['filter_collection_id'])) {
				$filter_collection_id = $this->request->get['filter_collection_id'];
				} else {
				$filter_collection_id = 0;
			}
			
			if (isset($this->request->get['filter_manufacturer_id'])) {
				$filter_manufacturer_id = $this->request->get['filter_manufacturer_id'];
				} else {
				$filter_manufacturer_id = 0;
			}
			
			if (isset($this->request->get['filter_count_conversion'])) {
				$filter_count_conversion = $this->request->get['filter_count_conversion'];
				} else {
				$filter_count_conversion = 0;
			}
			
			if (isset($this->request->get['filter_product_name'])) {
				$filter_product_name = $this->request->get['filter_product_name'];
				} else {
				$filter_product_name = '';
			}
			
			if ($filter_count_conversion && strtotime($filter_date_start) <= strtotime('2021-01-15')){
				$filter_date_start = '2021-01-15';
			}
			
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
				} else {
				$page = 1;
			}
			
			$url = '';
			
			if (isset($this->request->get['filter_date_start'])) {
				$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
			}
			
			if (isset($this->request->get['filter_date_end'])) {
				$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
			}
			
			if (isset($this->request->get['filter_order_status_id'])) {
				$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
			}
			
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
			}
			
			if (isset($this->request->get['filter_collection_id'])) {
				$url .= '&filter_collection_id=' . $this->request->get['filter_collection_id'];
			}
			
			if (isset($this->request->get['filter_manufacturer_id'])) {
				$url .= '&filter_manufacturer_id=' . $this->request->get['filter_manufacturer_id'];
			}
			
			if (isset($this->request->get['filter_count_conversion'])) {
				$url .= '&filter_count_conversion=' . $this->request->get['filter_count_conversion'];
			}
			
			if (isset($this->request->get['filter_product_name'])) {
				$url .= '&filter_product_name=' . $this->request->get['filter_product_name'];
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'] . $url, true)
			);
			
			$this->load->model('report/product');
			$this->load->model('tool/image');
			
			$data['products'] = array();
			
			$filter_data = array(
			'filter_date_start'	     	=> $filter_date_start,
			'filter_date_end'	     	=> $filter_date_end,
			'filter_order_status_id' 	=> $filter_order_status_id,
			'filter_category_id' 		=> $filter_category_id,
			'filter_collection_id' 		=> $filter_collection_id,
			'filter_manufacturer_id' 	=> $filter_manufacturer_id,
			'filter_count_conversion' 	=> $filter_count_conversion,
			'filter_product_name' 		=> $filter_product_name,
			'start'                  	=> ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                  	=> 100
			);
			
			$product_total = $this->model_report_product->getTotalPurchased($filter_data);
			
			$results = $this->model_report_product->getPurchased($filter_data);
			
			$data['totals'] = array(
			'min_price' => 0,
			'avg_price' => 0,
			'max_price' => 0,
			'quantity' 	=> 0,
			'total' 	=> 0,
			'viewed' 	=> 0,
			);
			
			foreach ($results as $result) {
			
				
				$viewed_filter_data = array(
					'filter_product_id' 		=> $result['product_id'],
					'filter_date_start'	     	=> $filter_date_start,
					'filter_date_end'	     	=> $filter_date_end,
				);
				$viewed = $this->model_report_product->getProductCustomerViewed($viewed_filter_data);
				
					
				$data['totals']['min_price'] 	+= $result['min_price'];
				$data['totals']['avg_price'] 	+= $result['avg_price'];
				$data['totals']['max_price'] 	+= $result['max_price'];
				$data['totals']['quantity'] 	+= $result['quantity'];
				$data['totals']['total'] 		+= $result['total'];
				$data['totals']['viewed'] 		+= $viewed;
				
				$data['products'][] = array(
				'name'       	=> $result['name'],
				'product_id' 	=> $result['product_id'],
				'model'      	=> $result['model'],
				'image'      	=> $this->model_tool_image->resize($result['image'], 40, 40),
				'viewed'	 	=> $viewed,
				'quantity'   	=> $result['quantity'],
				'manufacturer' 	=> $result['manufacturer'],
				'collection'  	=> $this->model_report_product->getMainCollectionName($result['product_id']),
				'category'  	=> $this->model_report_product->getMainCategoryName($result['product_id']),
				'min_price' 	=> $this->currency->format($result['min_price'], $this->config->get('config_currency')),
				'max_price' 	=> $this->currency->format($result['max_price'], $this->config->get('config_currency')),
				'avg_price' 	=> $this->currency->format($result['avg_price'], $this->config->get('config_currency')),
				'conversion' 	=> $viewed?round(($result['quantity'] / $viewed) * 100, 2).'%':'∞',
				'total'      	=> $this->currency->format($result['total'], $this->config->get('config_currency'))
				);
			}
			
			$data['totals'] = array(
			'min_price' => $this->currency->format($data['totals']['min_price'], $this->config->get('config_currency')),
			'avg_price' => $this->currency->format($data['totals']['avg_price'], $this->config->get('config_currency')),
			'max_price' => $this->currency->format($data['totals']['max_price'], $this->config->get('config_currency')),
			'quantity' 	=> $data['totals']['quantity'],
			'total' 	=> $this->currency->format($data['totals']['total'], $this->config->get('config_currency')),
			'viewed' 	=> $data['totals']['viewed'],
			'conversion' => $data['totals']['viewed']?round(($data['totals']['quantity'] / $data['totals']['viewed']) * 100, 2).'%':'∞',
			);
			
			$data['heading_title'] = $this->language->get('heading_title');
			
			$data['text_list'] = $this->language->get('text_list');
			$data['text_no_results'] = $this->language->get('text_no_results');
			$data['text_confirm'] = $this->language->get('text_confirm');
			$data['text_all_status'] = $this->language->get('text_all_status');
			
			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_total'] = $this->language->get('column_total');
			
			$data['entry_date_start'] = $this->language->get('entry_date_start');
			$data['entry_date_end'] = $this->language->get('entry_date_end');
			$data['entry_status'] = $this->language->get('entry_status');
			
			$data['button_filter'] = $this->language->get('button_filter');
			
			$this->load->model('catalog/manufacturer');			
			$data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();
			
			$this->load->model('catalog/collection');			
			$data['collections'] = $this->model_catalog_collection->getCollections();
			
			$this->load->model('catalog/category');			
			$data['categories'] = $this->model_catalog_category->getCategories();
			
			$data['token'] = $this->session->data['token'];
			
			$this->load->model('localisation/order_status');
			
			$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
			
			$url = '';
			
			if (isset($this->request->get['filter_date_start'])) {
				$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
			}
			
			if (isset($this->request->get['filter_date_end'])) {
				$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
			}
			
			if (isset($this->request->get['filter_order_status_id'])) {
				$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
			}
			
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
			}
			
			if (isset($this->request->get['filter_collection_id'])) {
				$url .= '&filter_collection_id=' . $this->request->get['filter_collection_id'];
			}
			
			if (isset($this->request->get['filter_manufacturer_id'])) {
				$url .= '&filter_manufacturer_id=' . $this->request->get['filter_manufacturer_id'];
			}
			
			if (isset($this->request->get['filter_count_conversion'])) {
				$url .= '&filter_count_conversion=' . $this->request->get['filter_count_conversion'];
			}
			
			if (isset($this->request->get['filter_product_name'])) {
				$url .= '&filter_product_name=' . $this->request->get['filter_product_name'];
			}
			
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $this->config->get('config_limit_admin');
			$pagination->url = $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
			
			$data['pagination'] = $pagination->render();
			
			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));
			
			$data['filter_date_start'] = $filter_date_start;
			$data['filter_date_end'] = $filter_date_end;
			$data['filter_order_status_id'] = $filter_order_status_id;
			$data['filter_category_id'] = $filter_category_id;
			$data['filter_collection_id'] = $filter_collection_id;
			$data['filter_manufacturer_id'] = $filter_manufacturer_id;
			$data['filter_count_conversion'] = $filter_count_conversion;
			$data['filter_product_name'] = $filter_product_name;
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
			$this->response->setOutput($this->load->view('report/product_purchased', $data));
		}
	}	