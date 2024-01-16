<?php
	class ControllerCatalogProduct extends Controller {

	public function filter() {
		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product/filter');
		} else {
			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}
	}

	public function category() {
		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product/category');
		} else {
			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}
	}

	public function load_popup() {
		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product/load_popup');
		} else {
			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}
	}

	public function refresh_data() {
		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product/refresh_data');
		} else {
			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}
	}

	public function quick_update() {
		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product/quick_update');
		} else {
			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}
	}
			
		private $error = array();
		

	public function qsave() {
		$this->language->load('catalog/product');

		$this->load->model('catalog/product');

		$json = array();

		if ($this->validateForm()) {
			$this->model_catalog_product->editProduct($this->request->get['product_id'], $this->request->post);
			$json['success'] = ($this->language->get('text_success')).' --- '.(date("Y-m-d - H:i:s"));
		} else {
			$json['error'] = $this->error;
		}

		$this->response->addHeader('Content-Type: application/json; charset=utf-8');
		$this->response->setOutput(json_encode($json));
	}
			
		public function index() {

		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product');
		}
			
			$this->load->language('catalog/product');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->load->model('catalog/product');			
			
			$this->getList();
		}
		
		public function add() {
			$this->load->language('catalog/product');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->load->model('catalog/product');
			
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
				$this->model_catalog_product->addProduct($this->request->post);
				
				$this->session->data['success'] = $this->language->get('text_success');
				
				$url = '';
				

				if ($this->config->get('aqe_status') && $this->config->get('aqe_catalog_products_status')) {
					foreach ($this->config->get('aqe_catalog_products') as $column => $attr) {
						if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
							$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
						}
					}
					if (isset($this->request->get['filter_sub_category'])) {
						$url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
					}
				}
				
				if (isset($this->request->get['filter_name'])) {
					$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
				}
				
				if (isset($this->request->get['filter_model'])) {
					$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
				}
				
				if (isset($this->request->get['filter_price'])) {
					$url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
				}
				
				if (isset($this->request->get['filter_quantity'])) {
					$url .= '&filter_quantity=' . urlencode(html_entity_decode($this->request->get['filter_quantity'], ENT_QUOTES, 'UTF-8'));
				}
				
				if (isset($this->request->get['filter_status'])) {
					$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
				}
				
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . urlencode(html_entity_decode($this->request->get['sort'], ENT_QUOTES, 'UTF-8'));
				}
				
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . urlencode(html_entity_decode($this->request->get['order'], ENT_QUOTES, 'UTF-8'));
				}
				
				if (isset($this->request->get['page'])) {
					$url .= '&page=' . urlencode(html_entity_decode($this->request->get['page'], ENT_QUOTES, 'UTF-8'));
				}
				
				$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
			}
			
			$this->getForm();
		}
		
		public function edit() {
			$this->load->language('catalog/product');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->load->model('catalog/product');
			
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
				$this->model_catalog_product->editProduct($this->request->get['product_id'], $this->request->post);
				
				$this->session->data['success'] = $this->language->get('text_success');

			$url = '';


			if ($this->config->get('aqe_status') && $this->config->get('aqe_catalog_products_status')) {
				foreach ($this->config->get('aqe_catalog_products') as $column => $attr) {
					if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
						$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
					}
				}
				if (isset($this->request->get['filter_sub_category'])) {
					$url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
				}
			}
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . urlencode(html_entity_decode($this->request->get['filter_quantity'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . urlencode(html_entity_decode($this->request->get['sort'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . urlencode(html_entity_decode($this->request->get['order'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . urlencode(html_entity_decode($this->request->get['page'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['product_id'])) {
				$url .= '&product_id=' . urlencode(html_entity_decode($this->request->get['product_id'], ENT_QUOTES, 'UTF-8'));
				$this->response->redirect($this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . $url, true));
			}


			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}
		
	public function delete() {

		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product/delete');
		}

		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->deleteProduct($product_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';


			if ($this->config->get('aqe_status') && $this->config->get('aqe_catalog_products_status')) {
				foreach ($this->config->get('aqe_catalog_products') as $column => $attr) {
					if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
						$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
					}
				}
				if (isset($this->request->get['filter_sub_category'])) {
					$url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
				}
			}
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . urlencode(html_entity_decode($this->request->get['filter_quantity'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . urlencode(html_entity_decode($this->request->get['sort'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . urlencode(html_entity_decode($this->request->get['order'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . urlencode(html_entity_decode($this->request->get['page'], ENT_QUOTES, 'UTF-8'));
			}

			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	public function merge(){
		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product/merge');
		}
	}
		
	public function copy() {

		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product/copy');
		}

		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->copyProduct($product_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';


			if ($this->config->get('aqe_status') && $this->config->get('aqe_catalog_products_status')) {
				foreach ($this->config->get('aqe_catalog_products') as $column => $attr) {
					if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
						$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
					}
				}
				if (isset($this->request->get['filter_sub_category'])) {
					$url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
				}
			}
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . urlencode(html_entity_decode($this->request->get['filter_quantity'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . urlencode(html_entity_decode($this->request->get['sort'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . urlencode(html_entity_decode($this->request->get['order'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . urlencode(html_entity_decode($this->request->get['page'], ENT_QUOTES, 'UTF-8'));
			}

			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}
		
		protected function getList() {
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
				} else {
				$filter_name = null;
			}
			
			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
				} else {
				$filter_model = null;
			}
			
			if (isset($this->request->get['filter_price'])) {
				$filter_price = $this->request->get['filter_price'];
				} else {
				$filter_price = null;
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$filter_quantity = $this->request->get['filter_quantity'];
				} else {
				$filter_quantity = null;
			}
			
			if (isset($this->request->get['filter_status'])) {
				$filter_status = $this->request->get['filter_status'];
				} else {
				$filter_status = null;
			}
			
			if (isset($this->request->get['filter_image'])) {
				$filter_image = $this->request->get['filter_image'];
				} else {
				$filter_image = null;
			}
			
			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
				} else {
				$sort = 'pd.name';
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
			
			$url = '';
			

		if ($this->config->get('aqe_status') && $this->config->get('aqe_catalog_products_status')) {
			foreach ($this->config->get('aqe_catalog_products') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
			}
		}
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . urlencode(html_entity_decode($this->request->get['filter_quantity'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_image'])) {
				$url .= '&filter_image=' . urlencode(html_entity_decode($this->request->get['filter_image'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . urlencode(html_entity_decode($this->request->get['sort'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . urlencode(html_entity_decode($this->request->get['order'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . urlencode(html_entity_decode($this->request->get['page'], ENT_QUOTES, 'UTF-8'));
			}
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true)
			);
			
			$data['add'] = $this->url->link('catalog/product/add', 'token=' . $this->session->data['token'] . $url, true);
			$data['copy'] = $this->url->link('catalog/product/copy', 'token=' . $this->session->data['token'] . $url, true);
			$data['delete'] = $this->url->link('catalog/product/delete', 'token=' . $this->session->data['token'] . $url, true);
			
			$data['products'] = array();
			
			$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_model'	  => $filter_model,
			'filter_price'	  => $filter_price,
			'filter_quantity' => $filter_quantity,
			'filter_status'   => $filter_status,
			'filter_image'    => $filter_image,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
			);
			
			$this->load->model('tool/image');
			
			$product_total = $this->model_catalog_product->getTotalProducts($filter_data);
			
			$results = $this->model_catalog_product->getProducts($filter_data);
			
			foreach ($results as $result) {
				if (is_file(DIR_IMAGE . $result['image'])) {
					$image = $this->model_tool_image->resize($result['image'], 40, 40);
					} else {
					$image = $this->model_tool_image->resize('no_image.png', 40, 40);
				}
				
				$special = false;
				
				$product_specials = $this->model_catalog_product->getProductSpecials($result['product_id']);
				
				foreach ($product_specials  as $product_special) {
					if (($product_special['date_start'] == '0000-00-00' || strtotime($product_special['date_start']) < time()) && ($product_special['date_end'] == '0000-00-00' || strtotime($product_special['date_end']) > time())) {
						$special = $product_special['price'];
						
						break;
					}
				}
				
				$data['products'][] = array(
				'product_id' => $result['product_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'model'      => $result['model'],
				'price'      => $result['price'],
				'special'    => $special,
				'quantity'   => $result['quantity'],
				'status'     => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'] . $url, true)
				);
			}
			
			$data['heading_title'] = $this->language->get('heading_title');
			
			$data['text_list'] = $this->language->get('text_list');
			$data['text_enabled'] = $this->language->get('text_enabled');
			$data['text_disabled'] = $this->language->get('text_disabled');
			$data['text_no_results'] = $this->language->get('text_no_results');
			$data['text_confirm'] = $this->language->get('text_confirm');
			
			$data['column_image'] = $this->language->get('column_image');
			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_status'] = $this->language->get('column_status');
			$data['column_action'] = $this->language->get('column_action');
			
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_model'] = $this->language->get('entry_model');
			$data['entry_price'] = $this->language->get('entry_price');
			$data['entry_quantity'] = $this->language->get('entry_quantity');
			$data['entry_status'] = $this->language->get('entry_status');
			$data['entry_image'] = $this->language->get('entry_image');
			
			$data['button_copy'] = $this->language->get('button_copy');
			$data['button_add'] = $this->language->get('button_add');
			$data['button_edit'] = $this->language->get('button_edit');
			$data['button_delete'] = $this->language->get('button_delete');
			$data['button_filter'] = $this->language->get('button_filter');
			
			$data['token'] = $this->session->data['token'];
			
			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
				} else {
				$data['error_warning'] = '';
			}
			
			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];
				
				unset($this->session->data['success']);
				} else {
				$data['success'] = '';
			}
			
			if (isset($this->request->post['selected'])) {
				$data['selected'] = (array)$this->request->post['selected'];
				} else {
				$data['selected'] = array();
			}
			
			$url = '';
			

		if ($this->config->get('aqe_status') && $this->config->get('aqe_catalog_products_status')) {
			foreach ($this->config->get('aqe_catalog_products') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
			}
		}
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . urlencode(html_entity_decode($this->request->get['filter_quantity'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_image'])) {
				$url .= '&filter_image=' . urlencode(html_entity_decode($this->request->get['filter_image'], ENT_QUOTES, 'UTF-8'));
			}
			
			if ($order == 'ASC') {
				$url .= '&order=DESC';
				} else {
				$url .= '&order=ASC';
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . urlencode(html_entity_decode($this->request->get['page'], ENT_QUOTES, 'UTF-8'));
			}
			
			$data['sort_name'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, true);
			$data['sort_model'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, true);
			$data['sort_price'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, true);
			$data['sort_quantity'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, true);
			$data['sort_status'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, true);
			$data['sort_order'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, true);
			
			$url = '';
			

		if ($this->config->get('aqe_status') && $this->config->get('aqe_catalog_products_status')) {
			foreach ($this->config->get('aqe_catalog_products') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
			}
		}
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . urlencode(html_entity_decode($this->request->get['filter_quantity'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_image'])) {
				$url .= '&filter_image=' . urlencode(html_entity_decode($this->request->get['filter_image'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . urlencode(html_entity_decode($this->request->get['sort'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . urlencode(html_entity_decode($this->request->get['order'], ENT_QUOTES, 'UTF-8'));
			}
			
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $this->config->get('config_limit_admin');
			$pagination->url = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
			
			$data['pagination'] = $pagination->render();
			
			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));
			
			$data['filter_name'] = $filter_name;
			$data['filter_model'] = $filter_model;
			$data['filter_price'] = $filter_price;
			$data['filter_quantity'] = $filter_quantity;
			$data['filter_status'] = $filter_status;
			$data['filter_image'] = $filter_image;
			
			$data['sort'] = $sort;
			$data['order'] = $order;
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
			$this->response->setOutput($this->load->view('catalog/product_list', $data));
		}
		
		protected function getForm() {
			$data['heading_title'] = $this->language->get('heading_title');

			$this->document->addStyle('view/stylesheet/ocfilter/ocfilter.css');
			$this->document->addScript('view/javascript/ocfilter/ocfilter.js');				
			
			$data['text_form'] = !isset($this->request->get['product_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
			$data['text_enabled'] = $this->language->get('text_enabled');
			$data['text_disabled'] = $this->language->get('text_disabled');
			$data['text_none'] = $this->language->get('text_none');
			$data['text_yes'] = $this->language->get('text_yes');
			$data['text_no'] = $this->language->get('text_no');
			$data['text_plus'] = $this->language->get('text_plus');
			$data['text_minus'] = $this->language->get('text_minus');
			$data['text_default'] = $this->language->get('text_default');
			$data['text_option'] = $this->language->get('text_option');
			$data['text_option_value'] = $this->language->get('text_option_value');
			$data['text_select'] = $this->language->get('text_select');
			$data['text_percent'] = $this->language->get('text_percent');
			$data['text_amount'] = $this->language->get('text_amount');
			
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_description'] = $this->language->get('entry_description');
			$data['entry_meta_title'] = $this->language->get('entry_meta_title');
			$data['entry_meta_description'] = $this->language->get('entry_meta_description');
			$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
			$data['entry_keyword'] = $this->language->get('entry_keyword');
			$data['entry_model'] = $this->language->get('entry_model');
			$data['entry_sku'] = $this->language->get('entry_sku');
			$data['entry_upc'] = $this->language->get('entry_upc');
			$data['entry_ean'] = $this->language->get('entry_ean');
			$data['entry_jan'] = $this->language->get('entry_jan');
			$data['entry_isbn'] = $this->language->get('entry_isbn');
			$data['entry_mpn'] = $this->language->get('entry_mpn');
			$data['entry_location'] = $this->language->get('entry_location');
			$data['entry_minimum'] = $this->language->get('entry_minimum');
			$data['entry_shipping'] = $this->language->get('entry_shipping');
			$data['entry_date_available'] = $this->language->get('entry_date_available');
			$data['entry_quantity'] = $this->language->get('entry_quantity');
			$data['entry_stock_status'] = $this->language->get('entry_stock_status');
			$data['entry_price'] = $this->language->get('entry_price');
			$data['entry_tax_class'] = $this->language->get('entry_tax_class');
			$data['entry_points'] = $this->language->get('entry_points');
			$data['entry_option_points'] = $this->language->get('entry_option_points');
			$data['entry_subtract'] = $this->language->get('entry_subtract');
			$data['entry_weight_class'] = $this->language->get('entry_weight_class');
			$data['entry_weight'] = $this->language->get('entry_weight');
			$data['entry_dimension'] = $this->language->get('entry_dimension');
			$data['entry_length_class'] = $this->language->get('entry_length_class');
			$data['entry_length'] = $this->language->get('entry_length');
			$data['entry_width'] = $this->language->get('entry_width');
			$data['entry_height'] = $this->language->get('entry_height');
			$data['entry_image'] = $this->language->get('entry_image');
			$data['entry_additional_image'] = $this->language->get('entry_additional_image');
			$data['entry_store'] = $this->language->get('entry_store');
			$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
			$data['entry_download'] = $this->language->get('entry_download');
			$data['entry_category'] = $this->language->get('entry_category');
			$data['entry_filter'] = $this->language->get('entry_filter');
			$data['entry_related'] = $this->language->get('entry_related');
			$data['entry_analog'] = $this->language->get('entry_analog');
			$data['entry_same'] = $this->language->get('entry_same');
			$data['entry_attribute'] = $this->language->get('entry_attribute');
			$data['entry_text'] = $this->language->get('entry_text');
			$data['entry_option'] = $this->language->get('entry_option');
			$data['entry_option_value'] = $this->language->get('entry_option_value');
			$data['entry_required'] = $this->language->get('entry_required');
			$data['entry_sort_order'] = $this->language->get('entry_sort_order');
			$data['entry_status'] = $this->language->get('entry_status');
			$data['entry_date_start'] = $this->language->get('entry_date_start');
			$data['entry_date_end'] = $this->language->get('entry_date_end');
			$data['entry_priority'] = $this->language->get('entry_priority');
			$data['entry_tag'] = $this->language->get('entry_tag');
			$data['entry_customer_group'] = $this->language->get('entry_customer_group');
			$data['entry_reward'] = $this->language->get('entry_reward');
			$data['entry_layout'] = $this->language->get('entry_layout');
			$data['entry_recurring'] = $this->language->get('entry_recurring');
			$data['entry_main_category'] = $this->language->get('entry_main_category');
			$data['entry_main_collection'] = $this->language->get('entry_main_collection');
			
			
			$data['help_keyword'] = $this->language->get('help_keyword');
			$data['help_sku'] = $this->language->get('help_sku');
			$data['help_upc'] = $this->language->get('help_upc');
			$data['help_ean'] = $this->language->get('help_ean');
			$data['help_jan'] = $this->language->get('help_jan');
			$data['help_isbn'] = $this->language->get('help_isbn');
			$data['help_mpn'] = $this->language->get('help_mpn');
			$data['help_minimum'] = $this->language->get('help_minimum');
			$data['help_manufacturer'] = $this->language->get('help_manufacturer');
			$data['help_stock_status'] = $this->language->get('help_stock_status');
			$data['help_points'] = $this->language->get('help_points');
			$data['help_category'] = $this->language->get('help_category');
			$data['help_filter'] = $this->language->get('help_filter');
			$data['help_download'] = $this->language->get('help_download');
			$data['help_related'] = $this->language->get('help_related');
			$data['help_same'] = $this->language->get('help_same');
			$data['help_analog'] = $this->language->get('help_analog');
			$data['help_tag'] = $this->language->get('help_tag');
			
			$data['button_save'] = $this->language->get('button_save');
			$data['button_cancel'] = $this->language->get('button_cancel');

				$data['column_faq_name'] = $this->language->get('column_faq_name');
				$data['column_question'] = $this->language->get('column_question');
				$data['column_faq'] = $this->language->get('column_faq');
				$data['column_icon'] = $this->language->get('column_icon');
				$data['tab_faq'] = $this->language->get('tab_faq');
				$data['faq_name'] = $this->language->get('faq_name');
				$data['button_remove'] = $this->language->get('button_remove');
			
			$data['button_attribute_add'] = $this->language->get('button_attribute_add');
			$data['button_option_add'] = $this->language->get('button_option_add');
			$data['button_option_value_add'] = $this->language->get('button_option_value_add');
			$data['button_discount_add'] = $this->language->get('button_discount_add');
			$data['button_special_add'] = $this->language->get('button_special_add');
			$data['button_image_add'] = $this->language->get('button_image_add');
			$data['button_remove'] = $this->language->get('button_remove');
			$data['button_recurring_add'] = $this->language->get('button_recurring_add');
			$data['tab_ocfilter'] = $this->language->get('tab_ocfilter');
			$data['entry_values'] = $this->language->get('entry_values');
			$data['ocfilter_select_category'] = $this->language->get('ocfilter_select_category');			
			$data['tab_general'] = $this->language->get('tab_general');
			$data['tab_data'] = $this->language->get('tab_data');
			$data['tab_same'] = $this->language->get('tab_same');
			$data['tab_attribute'] = $this->language->get('tab_attribute');
			$data['tab_option'] = $this->language->get('tab_option');
			$data['tab_recurring'] = $this->language->get('tab_recurring');
			$data['tab_discount'] = $this->language->get('tab_discount');
			$data['tab_special'] = $this->language->get('tab_special');
			$data['tab_image'] = $this->language->get('tab_image');
			$data['tab_links'] = $this->language->get('tab_links');
			$data['tab_reward'] = $this->language->get('tab_reward');
			$data['tab_design'] = $this->language->get('tab_design');
			$data['tab_openbay'] = $this->language->get('tab_openbay');

			$this->load->model('catalog/ehealth');
			
			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
				} else {
				$data['error_warning'] = '';
			}
			
			if (isset($this->error['name'])) {
				$data['error_name'] = $this->error['name'];
				} else {
				$data['error_name'] = array();
			}
			
			if (isset($this->error['meta_title'])) {
				$data['error_meta_title'] = $this->error['meta_title'];
				} else {
				$data['error_meta_title'] = array();
			}
			
			if (isset($this->error['model'])) {
				$data['error_model'] = $this->error['model'];
				} else {
				$data['error_model'] = '';
			}
			
			if (isset($this->error['keyword'])) {
				$data['error_keyword'] = $this->error['keyword'];
				} else {
				$data['error_keyword'] = '';
			}
			
			$url = '';
			

		if ($this->config->get('aqe_status') && $this->config->get('aqe_catalog_products_status')) {
			foreach ($this->config->get('aqe_catalog_products') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
			}
		}
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . urlencode(html_entity_decode($this->request->get['filter_quantity'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . urlencode(html_entity_decode($this->request->get['sort'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . urlencode(html_entity_decode($this->request->get['order'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . urlencode(html_entity_decode($this->request->get['page'], ENT_QUOTES, 'UTF-8'));
			}
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true)
			);
			
			if (!isset($this->request->get['product_id'])) {
				$data['action'] = $this->url->link('catalog/product/add', 'token=' . $this->session->data['token'] . $url, true);
				} else {
				$data['action'] = $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] . $url, true);
			}
			


			$data['pidqs'] = isset($this->request->get['product_id']) ? $this->request->get['product_id'] : '';			
			$data['cancel'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true);
			
			if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
				$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
				$data['product_id'] = $product_info['product_id'];								
				$data['reg_json'] = json_decode($product_info['reg_json'])?json_decode($product_info['reg_json'], true):false;
				$data['ms_json'] = json_decode($product_info['ms_json'])?json_decode($product_info['ms_json'], true):false;

				$data['reg_trade_name']			= $product_info['reg_trade_name'];						
				$data['reg_unpatented_name']	= $product_info['reg_unpatented_name'];
				$data['reg_save_terms']			= $product_info['reg_save_terms'];
				$data['reg_atx_1']				= $product_info['reg_atx_1'];
				$data['reg_atx_2']				= $product_info['reg_atx_2'];
				$data['reg_atx_3']				= $product_info['reg_atx_3'];
				$data['reg_instruction']		= $product_info['reg_instruction'];

				if (file_exists(DIR_INSTRUCTIONS . $product_info['reg_instruction'])){
					$data['reg_instruction_html'] 	= HTTPS_CATALOG . 'instructions/' . $product_info['reg_instruction'];
				}

				if (file_exists(DIR_INSTRUCTIONS . str_replace('.html', '.pdf', $product_info['reg_instruction']))){
					$data['reg_instruction_pdf'] 	= HTTPS_CATALOG . 'instructions/' . str_replace('.html', '.pdf', $product_info['reg_instruction']);
				}						
			}
			
			$data['token'] = $this->session->data['token'];
			
			$this->load->model('localisation/language');
			
			$data['languages'] = $this->model_localisation_language->getLanguages();
			
			if (isset($this->request->post['product_description'])) {
				$data['product_description'] = $this->request->post['product_description'];
				} elseif (isset($this->request->get['product_id'])) {
				$data['product_description'] = $this->model_catalog_product->getProductDescriptions($this->request->get['product_id']);
				} else {
				$data['product_description'] = array();
			}
			
			if (isset($this->request->post['model'])) {
				$data['model'] = $this->request->post['model'];
				} elseif (!empty($product_info)) {
				$data['model'] = $product_info['model'];
				} else {
				$data['model'] = '';
			}
			
			if (isset($this->request->post['uuid'])) {
				$data['uuid'] = $this->request->post['uuid'];
				} elseif (!empty($product_info)) {
				$data['uuid'] = $product_info['uuid'];
				} else {
				$data['uuid'] = '';
			}

			if (isset($this->request->post['ehealth_id'])) {
				$data['ehealth_id'] = $this->request->post['ehealth_id'];
				} elseif (!empty($product_info)) {
				$data['ehealth_id'] = $product_info['ehealth_id'];
				} else {
				$data['ehealth_id'] = '';
			}

			if (isset($this->request->post['program_id'])) {
				$data['program_id'] = $this->request->post['program_id'];
				} elseif (!empty($product_info)) {
				$data['program_id'] = $product_info['program_id'];
				} else {
				$data['program_id'] = '';
			}

			$data['ehealth'] = '';
			if ($data['ehealth_id']){				
				$data['ehealth_info'] = $this->model_catalog_ehealth->getEhealthProduct($data['ehealth_id'], $data['program_id']);

				if (!empty($data['ehealth_info']['trade_name'])){
					$data['ehealth'] 			= $data['ehealth_info']['trade_name'];
					$data['ehealth_program'] 	= $data['ehealth_info']['program_name'];
				}
			}

			if (isset($this->request->post['ehealth_id_1'])) {
				$data['ehealth_id_1'] = $this->request->post['ehealth_id_1'];
				} elseif (!empty($product_info)) {
				$data['ehealth_id_1'] = $product_info['ehealth_id_1'];
				} else {
				$data['ehealth_id_1'] = '';
			}

			if (isset($this->request->post['program_id_1'])) {
				$data['program_id_1'] = $this->request->post['program_id_1'];
				} elseif (!empty($product_info)) {
				$data['program_id_1'] = $product_info['program_id_1'];
				} else {
				$data['program_id_1'] = '';
			}

			$data['ehealth_1'] = '';
			if ($data['ehealth_id_1']){
				$data['ehealth_info_1'] = $this->model_catalog_ehealth->getEhealthProduct($data['ehealth_id_1'], $data['program_id_1']);

				if (!empty($data['ehealth_info_1']['trade_name'])){
					$data['ehealth_1'] 			= $data['ehealth_info_1']['trade_name'];
					$data['ehealth_program_1'] 	= $data['ehealth_info_1']['program_name'];
				}
			}

			if (isset($this->request->post['ehealth_id_2'])) {
				$data['ehealth_id_2'] = $this->request->post['ehealth_id_2'];
				} elseif (!empty($product_info)) {
				$data['ehealth_id_2'] = $product_info['ehealth_id_2'];
				} else {
				$data['ehealth_id_2'] = '';
			}

			if (isset($this->request->post['program_id_2'])) {
				$data['program_id_2'] = $this->request->post['program_id_2'];
				} elseif (!empty($product_info)) {
				$data['program_id_2'] = $product_info['program_id_2'];
				} else {
				$data['program_id_2'] = '';
			}

			$data['ehealth_2'] = '';
			if ($data['ehealth_id_2']){
				$data['ehealth_info_2'] = $this->model_catalog_ehealth->getEhealthProduct($data['ehealth_id_2'], $data['program_id_2']);

				if (!empty($data['ehealth_info_2']['trade_name'])){
					$data['ehealth_2'] 			= $data['ehealth_info_2']['trade_name'];
					$data['ehealth_program_2'] 	= $data['ehealth_info_2']['program_name'];
				}
			}

			if (isset($this->request->post['ehealth_id_3'])) {
				$data['ehealth_id_3'] = $this->request->post['ehealth_id_3'];
				} elseif (!empty($product_info)) {
				$data['ehealth_id_3'] = $product_info['ehealth_id_3'];
				} else {
				$data['ehealth_id_3'] = '';
			}

			if (isset($this->request->post['program_id_3'])) {
				$data['program_id_3'] = $this->request->post['program_id_3'];
				} elseif (!empty($product_info)) {
				$data['program_id_3'] = $product_info['program_id_3'];
				} else {
				$data['program_id_3'] = '';
			}

			$data['ehealth_3'] = '';
			if ($data['ehealth_id_3']){
				$data['ehealth_info_3'] = $this->model_catalog_ehealth->getEhealthProduct($data['ehealth_id_3'], $data['program_id_3']);

				if (!empty($data['ehealth_info_3']['trade_name'])){
					$data['ehealth_3'] 			= $data['ehealth_info_3']['trade_name'];
					$data['ehealth_program_3'] 	= $data['ehealth_info_3']['program_name'];
				}
			}
			
			if (isset($this->request->post['reg_number'])) {
				$data['reg_number'] = $this->request->post['reg_number'];
				} elseif (!empty($product_info)) {
				$data['reg_number'] = $product_info['reg_number'];
				} else {
				$data['reg_number'] = '';
			}
			
			if (isset($this->request->post['sku'])) {
				$data['sku'] = $this->request->post['sku'];
				} elseif (!empty($product_info)) {
				$data['sku'] = $product_info['sku'];
				} else {
				$data['sku'] = '';
			}
			
			if (isset($this->request->post['upc'])) {
				$data['upc'] = $this->request->post['upc'];
				} elseif (!empty($product_info)) {
				$data['upc'] = $product_info['upc'];
				} else {
				$data['upc'] = '';
			}
			
			if (isset($this->request->post['ean'])) {
				$data['ean'] = $this->request->post['ean'];
				} elseif (!empty($product_info)) {
				$data['ean'] = $product_info['ean'];
				} else {
				$data['ean'] = '';
			}
			
			if (isset($this->request->post['jan'])) {
				$data['jan'] = $this->request->post['jan'];
				} elseif (!empty($product_info)) {
				$data['jan'] = $product_info['jan'];
				} else {
				$data['jan'] = '';
			}
			
			if (isset($this->request->post['isbn'])) {
				$data['isbn'] = $this->request->post['isbn'];
				} elseif (!empty($product_info)) {
				$data['isbn'] = $product_info['isbn'];
				} else {
				$data['isbn'] = '';
			}
			
			if (isset($this->request->post['mpn'])) {
				$data['mpn'] = $this->request->post['mpn'];
				} elseif (!empty($product_info)) {
				$data['mpn'] = $product_info['mpn'];
				} else {
				$data['mpn'] = '';
			}
			
			if (isset($this->request->post['location'])) {
				$data['location'] = $this->request->post['location'];
				} elseif (!empty($product_info)) {
				$data['location'] = $product_info['location'];
				} else {
				$data['location'] = '';
			}
			
			if (isset($this->request->post['backlight'])) {
				$data['backlight'] = $this->request->post['backlight'];
				} elseif (!empty($product_info)) {
				$data['backlight'] = $product_info['backlight'];
				} else {
				$data['backlight'] = '';
			}
			
			if (isset($this->request->post['name_of_part'])) {
				$data['name_of_part'] = $this->request->post['name_of_part'];
				} elseif (!empty($product_info)) {
				$data['name_of_part'] = $product_info['name_of_part'];
				} else {
				$data['name_of_part'] = '';
			}
			
			if (isset($this->request->post['uuid_of_part'])) {
				$data['uuid_of_part'] = $this->request->post['uuid_of_part'];
				} elseif (!empty($product_info)) {
				$data['uuid_of_part'] = $product_info['uuid_of_part'];
				} else {
				$data['uuid_of_part'] = '';
			}
			
			if (isset($this->request->post['count_of_parts'])) {
				$data['count_of_parts'] = $this->request->post['count_of_parts'];
				} elseif (!empty($product_info)) {
				$data['count_of_parts'] = $product_info['count_of_parts'];
				} else {
				$data['count_of_parts'] = 1;
			}
			
			if (isset($this->request->post['social_program'])) {
				$data['social_program'] = $this->request->post['social_program'];
				} elseif (!empty($product_info)) {
				$data['social_program'] = $product_info['social_program'];
				} else {
				$data['social_program'] = '';
			}
			
			if (isset($this->request->post['social_parent_id'])) {
				$data['social_parent_id'] = $this->request->post['social_parent_id'];
				} elseif (!empty($product_info)) {
				$data['social_parent_id'] = $product_info['social_parent_id'];
				} else {
				$data['social_parent_id'] = 0;
			}
			
			if (isset($this->request->post['social_parent_uuid'])) {
				$data['social_parent_uuid'] = $this->request->post['social_parent_uuid'];
				} elseif (!empty($product_info)) {
				$data['social_parent_uuid'] = $product_info['social_parent_uuid'];
				} else {
				$data['social_parent_uuid'] = '';
			}
			
			if ($data['social_child'] = $this->model_catalog_product->getSocialChildProduct($this->request->get['product_id'])){
				$social_child_stocks = $this->model_catalog_product->getProductStocks($data['social_child']['product_id']);
				$data['social_child_stocks'] = array();
				
				foreach ($social_child_stocks as $social_child_stock){
					
					$data['social_child_stocks'][] = array(
					'name' => $social_child_stock['name'],
					'quantity' => $social_child_stock['quantity'],
					'price' => $this->currency->format($social_child_stock['price'], $this->config->get('config_currency')),
					'reserve' => $social_child_stock['reserve']			
					);
					
				}
			}

			if (isset($this->request->post['has_dl_price'])) {
				$data['has_dl_price'] = $this->request->post['has_dl_price'];
				} elseif (!empty($product_info)) {
				$data['has_dl_price'] = $product_info['has_dl_price'];
				} else {
				$data['has_dl_price'] = 0;
			}

			if (isset($this->request->post['dl_price'])) {
				$data['dl_price'] = $this->request->post['dl_price'];
				} elseif (!empty($product_info)) {
				$data['dl_price'] = $product_info['dl_price'];
				} else {
				$data['dl_price'] = 0;
			}
			
			$stocks = $this->model_catalog_product->getProductStocks($this->request->get['product_id']);		
			$data['stocks'] = array();
			
			foreach ($stocks as $stock){
				
				$data['stocks'][] = array(
				'name' 			=> $stock['name'],
				'quantity' 		=> $stock['quantity'],
				'price' 		=> $this->currency->format($stock['price'], $this->config->get('config_currency')),
				'price_retail' 	=> $this->currency->format($stock['price_retail'], $this->config->get('config_currency')),
				'reserve' 		=> $stock['reserve']			
				);
				
			}
			
			
			$this->load->model('setting/store');
			
			$data['stores'] = $this->model_setting_store->getStores();
			
			if (isset($this->request->post['product_store'])) {
				$data['product_store'] = $this->request->post['product_store'];
				} elseif (isset($this->request->get['product_id'])) {
				$data['product_store'] = $this->model_catalog_product->getProductStores($this->request->get['product_id']);
				} else {
				$data['product_store'] = array(0);
			}
			
			if (isset($this->request->post['keyword'])) {
				$data['keyword'] = $this->request->post['keyword'];
				} elseif (!empty($product_info)) {
				$data['keyword'] = $product_info['keyword'];
				} else {
				$data['keyword'] = '';
			}
			
			if (isset($this->request->post['shipping'])) {
				$data['shipping'] = $this->request->post['shipping'];
				} elseif (!empty($product_info)) {
				$data['shipping'] = $product_info['shipping'];
				} else {
				$data['shipping'] = 1;
			}
			
			if (isset($this->request->post['price'])) {
				$data['price'] = $this->request->post['price'];
				} elseif (!empty($product_info)) {
				$data['price'] = $product_info['price'];
				} else {
				$data['price'] = '';
			}
			
			if (isset($this->request->post['price_retail'])) {
				$data['price_retail'] = $this->request->post['price_retail'];
				} elseif (!empty($product_info)) {
				$data['price_retail'] = $product_info['price_retail'];
				} else {
				$data['price_retail'] = '';
			}
			
			$this->load->model('catalog/recurring');
			
			$data['recurrings'] = $this->model_catalog_recurring->getRecurrings();
			
			if (isset($this->request->post['product_recurrings'])) {
				$data['product_recurrings'] = $this->request->post['product_recurrings'];
				} elseif (!empty($product_info)) {
				$data['product_recurrings'] = $this->model_catalog_product->getRecurrings($product_info['product_id']);
				} else {
				$data['product_recurrings'] = array();
			}
			
			$this->load->model('localisation/tax_class');
			
			$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
			
			if (isset($this->request->post['tax_class_id'])) {
				$data['tax_class_id'] = $this->request->post['tax_class_id'];
				} elseif (!empty($product_info)) {
				$data['tax_class_id'] = $product_info['tax_class_id'];
				} else {
				$data['tax_class_id'] = 0;
			}
			
			$this->load->model('catalog/pricegroup');
			
			$data['pricegroups'] = $this->model_catalog_pricegroup->getPriceGroups();
			
			if (isset($this->request->post['pricegroup_id'])) {
				$data['pricegroup_id'] = $this->request->post['pricegroup_id'];
				} elseif (!empty($product_info)) {
				$data['pricegroup_id'] = $product_info['pricegroup_id'];
				} else {
				$data['pricegroup_id'] = 0;
			}
			
			if (isset($this->request->post['date_available'])) {
				$data['date_available'] = $this->request->post['date_available'];
				} elseif (!empty($product_info)) {
				$data['date_available'] = ($product_info['date_available'] != '0000-00-00') ? $product_info['date_available'] : '';
				} else {
				$data['date_available'] = date('Y-m-d');
			}
			
			if (isset($this->request->post['quantity'])) {
				$data['quantity'] = $this->request->post['quantity'];
				} elseif (!empty($product_info)) {
				$data['quantity'] = $product_info['quantity'];
				} else {
				$data['quantity'] = 1;
			}
			
			if (isset($this->request->post['minimum'])) {
				$data['minimum'] = $this->request->post['minimum'];
				} elseif (!empty($product_info)) {
				$data['minimum'] = $product_info['minimum'];
				} else {
				$data['minimum'] = 1;
			}
			
			if (isset($this->request->post['subtract'])) {
				$data['subtract'] = $this->request->post['subtract'];
				} elseif (!empty($product_info)) {
				$data['subtract'] = $product_info['subtract'];
				} else {
				$data['subtract'] = 1;
			}
			
			if (isset($this->request->post['is_preorder'])) {
				$data['is_preorder'] = $this->request->post['is_preorder'];
				} elseif (!empty($product_info)) {
				$data['is_preorder'] = $product_info['is_preorder'];
				} else {
				$data['is_preorder'] = 0;
			}
			
			if (isset($this->request->post['is_thermolabel'])) {
				$data['is_thermolabel'] = $this->request->post['is_thermolabel'];
				} elseif (!empty($product_info)) {
				$data['is_thermolabel'] = $product_info['is_thermolabel'];
				} else {
				$data['is_thermolabel'] = 0;
			}
			
			if (isset($this->request->post['is_pko'])) {
				$data['is_pko'] = $this->request->post['is_pko'];
				} elseif (!empty($product_info)) {
				$data['is_pko'] = $product_info['is_pko'];
				} else {
				$data['is_pko'] = 0;
			}
			
			if (isset($this->request->post['is_drug'])) {
				$data['is_drug'] = $this->request->post['is_drug'];
				} elseif (!empty($product_info)) {
				$data['is_drug'] = $product_info['is_drug'];
				} else {
				$data['is_drug'] = 0;
			}

			if (isset($this->request->post['is_poison'])) {
				$data['is_poison'] = $this->request->post['is_poison'];
				} elseif (!empty($product_info)) {
				$data['is_poison'] = $product_info['is_poison'];
				} else {
				$data['is_poison'] = 0;
			}
			
			if (isset($this->request->post['bestseller'])) {
				$data['bestseller'] = $this->request->post['bestseller'];
				} elseif (!empty($product_info)) {
				$data['bestseller'] = $product_info['bestseller'];
				} else {
				$data['bestseller'] = 0;
			}
			
			if (isset($this->request->post['dnup'])) {
				$data['dnup'] = $this->request->post['dnup'];
				} elseif (!empty($product_info)) {
				$data['dnup'] = $product_info['dnup'];
				} else {
				$data['dnup'] = 0;
			}
			
			if (isset($this->request->post['sort_order'])) {
				$data['sort_order'] = $this->request->post['sort_order'];
				} elseif (!empty($product_info)) {
				$data['sort_order'] = $product_info['sort_order'];
				} else {
				$data['sort_order'] = 1;
			}
			
			$this->load->model('localisation/stock_status');
			
			$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();
			
			if (isset($this->request->post['stock_status_id'])) {
				$data['stock_status_id'] = $this->request->post['stock_status_id'];
				} elseif (!empty($product_info)) {
				$data['stock_status_id'] = $product_info['stock_status_id'];
				} else {
				$data['stock_status_id'] = 0;
			}
			
			if (isset($this->request->post['status'])) {
				$data['status'] = $this->request->post['status'];
				} elseif (!empty($product_info)) {
				$data['status'] = $product_info['status'];
				} else {
				$data['status'] = true;
			}
			
			if (isset($this->request->post['no_payment'])) {
				$data['no_payment'] = $this->request->post['no_payment'];
				} elseif (!empty($product_info)) {
				$data['no_payment'] = $product_info['no_payment'];
				} else {
				$data['no_payment'] = false;
			}
			
			if (isset($this->request->post['no_shipping'])) {
				$data['no_shipping'] = $this->request->post['no_shipping'];
				} elseif (!empty($product_info)) {
				$data['no_shipping'] = $product_info['no_shipping'];
				} else {
				$data['no_shipping'] = false;
			}
			
			if (isset($this->request->post['no_advert'])) {
				$data['no_advert'] = $this->request->post['no_advert'];
				} elseif (!empty($product_info)) {
				$data['no_advert'] = $product_info['no_advert'];
				} else {
				$data['no_advert'] = false;
			}
			
			if (isset($this->request->post['is_receipt'])) {
				$data['is_receipt'] = $this->request->post['is_receipt'];
				} elseif (!empty($product_info)) {
				$data['is_receipt'] = $product_info['is_receipt'];
				} else {
				$data['is_receipt'] = false;
			}
			
			if (isset($this->request->post['weight'])) {
				$data['weight'] = $this->request->post['weight'];
				} elseif (!empty($product_info)) {
				$data['weight'] = $product_info['weight'];
				} else {
				$data['weight'] = '';
			}
			
			$this->load->model('localisation/weight_class');
			
			$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();
			
			if (isset($this->request->post['weight_class_id'])) {
				$data['weight_class_id'] = $this->request->post['weight_class_id'];
				} elseif (!empty($product_info)) {
				$data['weight_class_id'] = $product_info['weight_class_id'];
				} else {
				$data['weight_class_id'] = $this->config->get('config_weight_class_id');
			}
			
			if (isset($this->request->post['length'])) {
				$data['length'] = $this->request->post['length'];
				} elseif (!empty($product_info)) {
				$data['length'] = $product_info['length'];
				} else {
				$data['length'] = '';
			}
			
			if (isset($this->request->post['width'])) {
				$data['width'] = $this->request->post['width'];
				} elseif (!empty($product_info)) {
				$data['width'] = $product_info['width'];
				} else {
				$data['width'] = '';
			}
			
			if (isset($this->request->post['height'])) {
				$data['height'] = $this->request->post['height'];
				} elseif (!empty($product_info)) {
				$data['height'] = $product_info['height'];
				} else {
				$data['height'] = '';
			}
			
			$this->load->model('localisation/length_class');
			
			$data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();
			
			if (isset($this->request->post['length_class_id'])) {
				$data['length_class_id'] = $this->request->post['length_class_id'];
				} elseif (!empty($product_info)) {
				$data['length_class_id'] = $product_info['length_class_id'];
				} else {
				$data['length_class_id'] = $this->config->get('config_length_class_id');
			}
			
			$this->load->model('catalog/manufacturer');
			
			if (isset($this->request->post['manufacturer_id'])) {
				$data['manufacturer_id'] = $this->request->post['manufacturer_id'];
				} elseif (!empty($product_info)) {
				$data['manufacturer_id'] = $product_info['manufacturer_id'];
				} else {
				$data['manufacturer_id'] = 0;
			}
			
			if (isset($this->request->post['manufacturer'])) {
				$data['manufacturer'] = $this->request->post['manufacturer'];
				} elseif (!empty($product_info)) {
				$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($product_info['manufacturer_id']);
				
				if ($manufacturer_info) {
					$data['manufacturer'] = $manufacturer_info['name'];
					} else {
					$data['manufacturer'] = '';
				}
				} else {
				$data['manufacturer'] = '';
			}
			
			//Collect
			$this->load->model('catalog/collection');
			
			$filter_data = array(
			'sort'        => 'name',
			'order'       => 'ASC'
			);
			
			$data['collections'] = $this->model_catalog_collection->getCollections($filter_data);
			
			if (isset($this->request->post['main_collection_id'])) {
				$data['main_collection_id'] = $this->request->post['main_collection_id'];
				} elseif (isset($product_info)) {
				$data['main_collection_id'] = $this->model_catalog_product->getProductMainCollectionId($this->request->get['product_id']);
				} else {
				$data['main_collection_id'] = 0;
			}
			
			if (isset($this->request->post['product_collection'])) {
				$data['product_collection'] = $this->request->post['product_collection'];
				} elseif (isset($this->request->get['product_id'])) {
				$data['product_collection'] = $this->model_catalog_product->getProductCollections($this->request->get['product_id']);
				} else {
				$data['product_collection'] = array();
			}
			
			//Collect
			$this->load->model('catalog/socialprogram');
			
			$filter_data = array(
			'sort'        => 'name',
			'order'       => 'ASC'
			);
			
			$data['socialprograms'] = $this->model_catalog_socialprogram->getSocialprograms($filter_data);
			
			if (isset($this->request->post['main_socialprogram_id'])) {
				$data['main_socialprogram_id'] = $this->request->post['main_socialprogram_id'];
				} elseif (isset($product_info)) {
				$data['main_socialprogram_id'] = $this->model_catalog_product->getProductMainSocialProgramId($this->request->get['product_id']);
				} else {
				$data['main_socialprogram_id'] = 0;
			}
			
			if (isset($this->request->post['product_socialprogram'])) {
				$data['product_socialprogram'] = $this->request->post['product_socialprogram'];
				} elseif (isset($this->request->get['product_id'])) {
				$data['product_socialprogram'] = $this->model_catalog_product->getProductSocialprograms($this->request->get['product_id']);
				} else {
				$data['product_socialprogram'] = array();
			}
			
			// Categories
			$this->load->model('catalog/category');
			
			if (isset($this->request->post['product_category'])) {
				$categories = $this->request->post['product_category'];
				} elseif (isset($this->request->get['product_id'])) {
				$categories = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
				} else {
				$categories = array();
			}
			
			if (isset($this->request->post['primenenie'])) {
				$primenenie = $this->request->post['primenenie'];
				} elseif (isset($this->request->get['product_id'])) {
				$primenenie = $this->model_catalog_product->getProductPrimenenie($this->request->get['product_id']);
				} else {
				$primenenie = array();
			}
			
			
			if (isset($this->request->post['tags'])) {
				$tags = $this->request->post['tags'];
				} elseif (isset($this->request->get['product_id'])) {
				$tags = $this->model_catalog_product->getProductTags($this->request->get['product_id']);
				} else {
				$tags = array();
			}
			
			$this->load->model('simple_blog/article');
			
			$data['product_primenenie'] = array();
			
			foreach ($primenenie as $simple_blog_article_id) {
				$article_info = $this->model_simple_blog_article->getArticle($simple_blog_article_id);
				
				if ($article_info) {
					$data['product_primenenie'][] = array(
					'simple_blog_article_id' => $article_info['simple_blog_article_id'],
					'article_title'        => $article_info['article_title'],
					'primenenie'        => $article_info['primenenie'],
					);
				}
			}
			
			$data['product_tags'] = array();
			
			foreach ($tags as $simple_blog_article_id) {
				$article_info = $this->model_simple_blog_article->getArticle($simple_blog_article_id);
				
				if ($article_info) {
					$data['product_tags'][] = array(
					'simple_blog_article_id' => $article_info['simple_blog_article_id'],
					'article_title'        => $article_info['article_title'],
					'tags'        => $article_info['tags'],
					);
				}
			}
			
			$data['product_categories'] = array();
			
			foreach ($categories as $category_id) {
				$category_info = $this->model_catalog_category->getCategory($category_id);
				
				if ($category_info) {
					$data['product_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
					);
				}
			}
			
			$data['product_categories'] = array();
			
			foreach ($categories as $category_id) {
				$category_info = $this->model_catalog_category->getCategory($category_id);
				
				if ($category_info) {
					$data['product_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
					);
				}
			}
			
			if (isset($this->request->post['main_category_id'])) {
				$data['main_category_id'] = $this->request->post['main_category_id'];
				} elseif (isset($product_info)) {
				$data['main_category_id'] = $this->model_catalog_product->getProductMainCategoryId($this->request->get['product_id']);
				} else {
				$data['main_category_id'] = 0;
			}
			
			// Filters
			$this->load->model('catalog/filter');
			
			if (isset($this->request->post['product_filter'])) {
				$filters = $this->request->post['product_filter'];
				} elseif (isset($this->request->get['product_id'])) {
				$filters = $this->model_catalog_product->getProductFilters($this->request->get['product_id']);
				} else {
				$filters = array();
			}
			
			$data['product_filters'] = array();
			
			foreach ($filters as $filter_id) {
				$filter_info = $this->model_catalog_filter->getFilter($filter_id);
				
				if ($filter_info) {
					$data['product_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
					);
				}
			}
			
			// Attributes
			$this->load->model('catalog/attribute');
			
			if (isset($this->request->post['product_attribute'])) {
				$product_attributes = $this->request->post['product_attribute'];
				} elseif (isset($this->request->get['product_id'])) {
				$product_attributes = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);
				} else {
				$product_attributes = array();
			}
			
			$data['product_attributes'] = array();
			
			foreach ($product_attributes as $product_attribute) {
				$attribute_info = $this->model_catalog_attribute->getAttribute($product_attribute['attribute_id']);
				
				if ($attribute_info) {
					$data['product_attributes'][] = array(
					'attribute_id'                  => $product_attribute['attribute_id'],
					'name'                          => $attribute_info['name'],
					'product_attribute_description' => $product_attribute['product_attribute_description']
					);
				}
			}
			
			// Options
			$this->load->model('catalog/option');
			
			if (isset($this->request->post['product_option'])) {
				$product_options = $this->request->post['product_option'];
				} elseif (isset($this->request->get['product_id'])) {
				$product_options = $this->model_catalog_product->getProductOptions($this->request->get['product_id']);
				} else {
				$product_options = array();
			}
			
			$data['product_options'] = array();
			
			foreach ($product_options as $product_option) {
				$product_option_value_data = array();
				
				if (isset($product_option['product_option_value'])) {
					foreach ($product_option['product_option_value'] as $product_option_value) {
						$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'price'                   => $product_option_value['price'],
						'price_prefix'            => $product_option_value['price_prefix'],
						'points'                  => $product_option_value['points'],
						'points_prefix'           => $product_option_value['points_prefix'],
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix']
						);
					}
				}
				
				$data['product_options'][] = array(
				'product_option_id'    => $product_option['product_option_id'],
				'product_option_value' => $product_option_value_data,
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],
				'value'                => isset($product_option['value']) ? $product_option['value'] : '',
				'required'             => $product_option['required']
				);
			}
			
			$data['option_values'] = array();
			
			foreach ($data['product_options'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					if (!isset($data['option_values'][$product_option['option_id']])) {
						$data['option_values'][$product_option['option_id']] = $this->model_catalog_option->getOptionValues($product_option['option_id']);
					}
				}
			}
			
			$this->load->model('customer/customer_group');
			
			$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
			
			if (isset($this->request->post['product_discount'])) {
				$product_discounts = $this->request->post['product_discount'];
				} elseif (isset($this->request->get['product_id'])) {
				$product_discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
				} else {
				$product_discounts = array();
			}
			
			$data['product_discounts'] = array();
			
			foreach ($product_discounts as $product_discount) {
				$data['product_discounts'][] = array(
				'customer_group_id' => $product_discount['customer_group_id'],
				'quantity'          => $product_discount['quantity'],
				'priority'          => $product_discount['priority'],
				'price'             => $product_discount['price'],
				'date_start'        => ($product_discount['date_start'] != '0000-00-00') ? $product_discount['date_start'] : '',
				'date_end'          => ($product_discount['date_end'] != '0000-00-00') ? $product_discount['date_end'] : ''
				);
			}
			
			if (isset($this->request->post['product_special'])) {
				$product_specials = $this->request->post['product_special'];
				} elseif (isset($this->request->get['product_id'])) {
				$product_specials = $this->model_catalog_product->getProductSpecials($this->request->get['product_id']);
				} else {
				$product_specials = array();
			}
			
			$data['product_specials'] = array();
			
			foreach ($product_specials as $product_special) {
				$data['product_specials'][] = array(
				'customer_group_id' => $product_special['customer_group_id'],
				'priority'          => $product_special['priority'],
				'price'             => $product_special['price'],
				'type'              => $product_special['type'],
				'date_start'        => ($product_special['date_start'] != '0000-00-00') ? $product_special['date_start'] : '',
				'date_end'          => ($product_special['date_end'] != '0000-00-00') ? $product_special['date_end'] :  ''
				);
			}
			
			// Image
			if (isset($this->request->post['image'])) {
				$data['image'] = $this->request->post['image'];
				} elseif (!empty($product_info)) {
				$data['image'] = $product_info['image'];
				} else {
				$data['image'] = '';
			}
			
			$this->load->model('tool/image');
			
			if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
				$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
				} elseif (!empty($product_info) && is_file(DIR_IMAGE . $product_info['image'])) {
				$data['thumb'] = $this->model_tool_image->resize($product_info['image'], 100, 100);
				} else {
				$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
			}
			
			$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
			
			// Images
			if (isset($this->request->post['product_image'])) {
				$product_images = $this->request->post['product_image'];
				} elseif (isset($this->request->get['product_id'])) {
				$product_images = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
				} else {
				$product_images = array();
			}
			
			$data['product_images'] = array();
			
			foreach ($product_images as $product_image) {
				if (is_file(DIR_IMAGE . $product_image['image'])) {
					$image = $product_image['image'];
					$thumb = $product_image['image'];
					} else {
					$image = '';
					$thumb = 'no_image.png';
				}
				
				$data['product_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order' => $product_image['sort_order']
				);
			}
			
			// Downloads
			$this->load->model('catalog/download');
			
			if (isset($this->request->post['product_download'])) {
				$product_downloads = $this->request->post['product_download'];
				} elseif (isset($this->request->get['product_id'])) {
				$product_downloads = $this->model_catalog_product->getProductDownloads($this->request->get['product_id']);
				} else {
				$product_downloads = array();
			}
			
			$data['product_downloads'] = array();
			
			foreach ($product_downloads as $download_id) {
				$download_info = $this->model_catalog_download->getDownload($download_id);
				
				if ($download_info) {
					$data['product_downloads'][] = array(
					'download_id' => $download_info['download_id'],
					'name'        => $download_info['name']
					);
				}
			}
			
			if (isset($this->request->post['product_related'])) {
				$products = $this->request->post['product_related'];
				} elseif (isset($this->request->get['product_id'])) {
				$products = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
				} else {
				$products = array();
			}
			
			$data['product_relateds'] = array();
			
			foreach ($products as $product_id) {
				$related_info = $this->model_catalog_product->getProduct($product_id);
				
				if ($related_info) {
					$data['product_relateds'][] = array(
					'product_id' => $related_info['product_id'],
					'name'       => $related_info['name']
					);
				}
			}
			
			if (isset($this->request->post['product_analog'])) {
				$products = $this->request->post['product_analog'];
				} elseif (isset($this->request->get['product_id'])) {
				$products = $this->model_catalog_product->getProductAnalog($this->request->get['product_id']);
				} else {
				$products = array();
			}
			
			$data['product_analogs'] = array();
			
			foreach ($products as $product_id) {
				$analog_info = $this->model_catalog_product->getProduct($product_id);
				
				if ($analog_info) {
					$data['product_analogs'][] = array(
					'product_id' => $analog_info['product_id'],
					'name'       => $analog_info['name']
					);
				}
			}
			
			//Легкие аналоги для подконтрольных
			if (isset($this->request->post['product_light'])) {
				$products = $this->request->post['product_light'];
				} elseif (isset($this->request->get['product_id'])) {
				$products = $this->model_catalog_product->getProductLight($this->request->get['product_id']);
				} else {
				$products = array();
			}
			
			$data['product_lights'] = array();
			
			foreach ($products as $product_id) {
				$light_info = $this->model_catalog_product->getProduct($product_id);
				
				if ($light_info) {
					$data['product_lights'][] = array(
					'product_id' => $light_info['product_id'],
					'name'       => $light_info['name']
					);
				}
			}
			
			if (isset($this->request->post['product_light'])) {
				$products = $this->request->post['product_light'];
				} elseif (isset($this->request->get['product_id'])) {
				$products = $this->model_catalog_product->getProductLight($this->request->get['product_id']);
				} else {
				$products = array();
			}
			
			$data['product_lights'] = array();
			
			foreach ($products as $product_id) {
				$light_info = $this->model_catalog_product->getProduct($product_id);
				
				if ($light_info) {
					$data['product_lights'][] = array(
					'product_id' => $light_info['product_id'],
					'name'       => $light_info['name']
					);
				}
			}
			
			if (isset($this->request->post['product_same'])) {
				$products = $this->request->post['product_same'];
				} elseif (isset($this->request->get['product_id'])) {
				$products = $this->model_catalog_product->getProductSame($this->request->get['product_id']);
				} else {
				$products = array();
			}
			
			$data['product_sames'] = array();
			
			foreach ($products as $product_id) {
				$same_info = $this->model_catalog_product->getProduct($product_id);
				
				if ($same_info) {
					$data['product_sames'][] = array(
					'product_id' => $same_info['product_id'],
					'name'       => $same_info['name']
					);
				}
			}
			
			if (isset($this->request->post['points'])) {
				$data['points'] = $this->request->post['points'];
				} elseif (!empty($product_info)) {
				$data['points'] = $product_info['points'];
				} else {
				$data['points'] = '';
			}
			
			if (isset($this->request->post['product_reward'])) {
				$data['product_reward'] = $this->request->post['product_reward'];
				} elseif (isset($this->request->get['product_id'])) {
				$data['product_reward'] = $this->model_catalog_product->getProductRewards($this->request->get['product_id']);
				} else {
				$data['product_reward'] = array();
			}
			
				
				$data['product_faq'] = array(); 
				if (isset($this->request->post['product_faq'])) {
				$product_faq = $this->request->post['product_faq'];
				} elseif (isset($this->request->get['product_id'])) {
				$product_faq = $this->model_catalog_product->getProductFaq($this->request->get['product_id']);
				} else {
				$product_faq = array();
				}
				
				$data['product_faq'] = array();
				
				foreach ($product_faq as $product_faq) {
				$data['product_faq'][] = array(
				'question'       => unserialize($product_faq['question']),
				'faq'       => unserialize($product_faq['faq']),
				'icon'     => $product_faq['icon'],
				'sort_order' => $product_faq['sort_order']
				);
				}
			
			if (isset($this->request->post['product_layout'])) {
				$data['product_layout'] = $this->request->post['product_layout'];
				} elseif (isset($this->request->get['product_id'])) {
				$data['product_layout'] = $this->model_catalog_product->getProductLayouts($this->request->get['product_id']);
				} else {
				$data['product_layout'] = array();
			}
			
			$this->load->model('design/layout');
			
			$data['layouts'] = $this->model_design_layout->getLayouts();
			
			// XD Stickers start
			$this->load->language('extension/module/xdstickers');
			$this->load->model('extension/module/xdstickers');
			$data['xdstickers_product'] = array();
			$data['tab_xdstickers'] = $this->language->get('tab_xdstickers');
			$data['entry_xdstickers'] = $this->language->get('entry_xdstickers');
			$data['xdstickers'] = $this->model_extension_module_xdstickers->getCustomXDStickers();
			if (isset($this->request->post['xdstickers'])) {
				$data['xdstickers_product'] = $this->request->post['xdstickers'];
				} elseif (isset($this->request->get['product_id'])) {
				$xdstickers_products = array();
				$xdstickers_products = $this->model_extension_module_xdstickers->getCustomXDStickersProduct($this->request->get['product_id']);
				foreach ($xdstickers_products as $xdstickers_product) {
					$data['xdstickers_product'][] = $xdstickers_product['xdsticker_id'];
				}
				} else {
				$data['xdstickers_product'] = array();
			}
			// XD Stickers end
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
			$this->response->setOutput($this->load->view('catalog/product_form', $data));
		}
		
		protected function validateForm() {
			if (!$this->user->hasPermission('modify', 'catalog/product')) {
				$this->error['warning'] = $this->language->get('error_permission');
			}
			
			foreach ($this->request->post['product_description'] as $language_id => $value) {
				if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
					$this->error['name'][$language_id] = $this->language->get('error_name');
				}
				
				if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
					//$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
				}
			}
			
			if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 400)) {
				$this->error['model'] = $this->language->get('error_model');
			}
			
			if (utf8_strlen($this->request->post['keyword']) > 0) {
				$this->load->model('catalog/url_alias');
				
				$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);
				
				if ($url_alias_info && isset($this->request->get['product_id']) && $url_alias_info['query'] != 'product_id=' . $this->request->get['product_id']) {
					$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
				}
				
				if ($url_alias_info && !isset($this->request->get['product_id'])) {
					$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
				}
			}
			
			if ($this->error && !isset($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_warning');
			}
			
			return !$this->error;
		}
		
		protected function validateDelete() {
			if (!$this->user->hasPermission('modify', 'catalog/product')) {
				$this->error['warning'] = $this->language->get('error_permission');
			}
			
			return !$this->error;
		}
		
		protected function validateCopy() {
			if (!$this->user->hasPermission('modify', 'catalog/product')) {
				$this->error['warning'] = $this->language->get('error_permission');
			}
			
			return !$this->error;
		}
		
		public function autocomplete() {

		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product/autocomplete');
		}
			
			$json = array();
			
			if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
				$this->load->model('catalog/product');
				$this->load->model('catalog/option');
				
				if (isset($this->request->get['filter_name'])) {
					$filter_name = $this->request->get['filter_name'];
					} else {
					$filter_name = '';
				}
				
				if (isset($this->request->get['filter_model'])) {
					$filter_model = $this->request->get['filter_model'];
					} else {
					$filter_model = '';
				}
				
				if (isset($this->request->get['limit'])) {
					$limit = $this->request->get['limit'];
					} else {
					$limit = 5;
				}
				
				$filter_data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
				);
				
				$results = $this->model_catalog_product->getProducts($filter_data);
				
				foreach ($results as $result) {
					$option_data = array();
					
					$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);
					
					foreach ($product_options as $product_option) {
						$option_info = $this->model_catalog_option->getOption($product_option['option_id']);
						
						if ($option_info) {
							$product_option_value_data = array();
							
							foreach ($product_option['product_option_value'] as $product_option_value) {
								$option_value_info = $this->model_catalog_option->getOptionValue($product_option_value['option_value_id']);
								
								if ($option_value_info) {
									$product_option_value_data[] = array(
									'product_option_value_id' => $product_option_value['product_option_value_id'],
									'option_value_id'         => $product_option_value['option_value_id'],
									'name'                    => $option_value_info['name'],
									'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
									'price_prefix'            => $product_option_value['price_prefix']
									);
								}
							}
							
							$option_data[] = array(
							'product_option_id'    => $product_option['product_option_id'],
							'product_option_value' => $product_option_value_data,
							'option_id'            => $product_option['option_id'],
							'name'                 => $option_info['name'],
							'type'                 => $option_info['type'],
							'value'                => $product_option['value'],
							'required'             => $product_option['required']
							);
						}
					}
					
					$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price']
					);
				}
			}
			
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}
