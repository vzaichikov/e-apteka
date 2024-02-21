<?php
	class ControllerCatalogOchelpSpecial extends Controller {
		private $error = array();
		
		public function index() {
			$this->load->language('catalog/ochelp_special');
			
			$this->load->model('catalog/ochelp_special');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$check_tables = $this->model_catalog_ochelp_special->checkTables();
			
			if ($check_tables) {
				$this->getList();
				} else {
				$this->setting(1);
			}
		}
		
		public function add() {
			$this->load->language('catalog/ochelp_special');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->load->model('catalog/ochelp_special');
			
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
				$this->model_catalog_ochelp_special->addSpecial($this->request->post);
				
				$this->session->data['success'] = $this->language->get('text_success');
				
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
				
				$this->response->redirect($this->url->link('catalog/ochelp_special', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
			
			$this->getForm();
		}
		
		public function edit() {
			$this->load->language('catalog/ochelp_special');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->load->model('catalog/ochelp_special');
			
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
				$this->model_catalog_ochelp_special->editSpecial($this->request->get['special_id'], $this->request->post);
				
				$this->session->data['success'] = $this->language->get('text_success');
				
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
				
				$this->response->redirect($this->url->link('catalog/ochelp_special', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
			
			$this->getForm();
		}
		
		public function delete() {
			$this->load->language('catalog/ochelp_special');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->load->model('catalog/ochelp_special');
			
			if (isset($this->request->post['selected']) && $this->validateDelete()) {
				foreach ($this->request->post['selected'] as $special_id) {
					$this->model_catalog_ochelp_special->deleteSpecial($special_id);
				}
				
				$this->session->data['success'] = $this->language->get('text_success');
				
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
				
				$this->response->redirect($this->url->link('catalog/ochelp_special', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
			
			$this->getList();
		}
		
		private function getList() {
			
			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
				} else {
				$sort = 's.date_end';
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
			
			$url = '';
			
			$this->load->language('catalog/ochelp_special');
			
			$this->load->model('catalog/ochelp_special');
			
			$data['heading_title'] = $this->language->get('heading_title');
			
			$data['text_list'] = $this->language->get('text_list');
			$data['text_confirm'] = $this->language->get('text_confirm');
			$data['text_no_results'] = $this->language->get('text_no_results');
			
			$data['column_image'] = $this->language->get('column_image');
			$data['column_title'] = $this->language->get('column_title');
			$data['column_date_added'] = $this->language->get('column_date_added');
			$data['column_date_end'] = $this->language->get('column_date_end');
			$data['column_status'] = $this->language->get('column_status');
			$data['column_action'] = $this->language->get('column_action');
			
			$data['button_add'] = $this->language->get('button_add');
			$data['button_edit'] = $this->language->get('button_edit');
			$data['button_delete'] = $this->language->get('button_delete');
			$data['button_setting'] = $this->language->get('button_setting');
			
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
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_home'),
			'separator' => false,
			);
			
			$data['breadcrumbs'][] = array(
			'href' => $this->url->link('catalog/ochelp_special', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('heading_title'),
			'separator' => ' :: ',
			);
			
			$data['add'] = $this->url->link('catalog/ochelp_special/add', 'token=' . $this->session->data['token'], 'SSL');
			$data['delete'] = $this->url->link('catalog/ochelp_special/delete', 'token=' . $this->session->data['token'], 'SSL');
			$data['setting'] = $this->url->link('catalog/ochelp_special/setting', 'token=' . $this->session->data['token'], 'SSL');
			
			$this->load->model('tool/image');
			
			$data['specials'] = array();
			
			$filter_data = array(
			'sort' => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin'),
			);
			
			$results = $this->model_catalog_ochelp_special->getSpecials($filter_data);
			
			foreach ($results as $result) {
				
				if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
					$image = $this->model_tool_image->resize($result['image'], 40, 40);
					} else {
					$image = $this->model_tool_image->resize('placeholder.png', 40, 40);
				}
				
				if ($result['banner'] && file_exists(DIR_IMAGE . $result['banner'])) {
					$banner = $this->model_tool_image->resize($result['banner'], 40, 40);
					} else {
					$banner = $this->model_tool_image->resize('placeholder.png', 40, 40);
				}
				
				$data['specials'][] = array(
				'special_id' 	=> $result['special_id'],
				'title' 		=> $result['title'],
				'image' 		=> $image,
				'banner' 		=> $banner,
				'date_added' 	=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'date_end' 		=> date($this->language->get('date_format_short'), strtotime($result['date_end'])),
				'active_now' 	=> ($result['date_end'] >= date('Y-m-d')),
				'status' 		=> (int)$result['status'],
				'homepage' 		=> (int)$result['homepage'],
				'retail' 		=> (int)$result['retail'],
				'selected' 		=> isset($this->request->post['selected']) && in_array($result['special_id'], $this->request->post['selected']),
				'edit' 			=> $this->url->link('catalog/ochelp_special/edit', 'token=' . $this->session->data['token'] . '&special_id=' . $result['special_id'], 'SSL'),
				);
			}
			
			if (isset($this->request->post['selected'])) {
				$data['selected'] = (array) $this->request->post['selected'];
				} else {
				$data['selected'] = array();
			}
			
			$url = '';
			
			if ($order == 'ASC') {
				$url .= '&order=DESC';
				} else {
				$url .= '&order=ASC';
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$data['sort_title'] = $this->url->link('catalog/ochelp_special', 'token=' . $this->session->data['token'] . '&sort=nd.title' . $url, 'SSL');
			$data['sort_date_added'] = $this->url->link('catalog/ochelp_special', 'token=' . $this->session->data['token'] . '&sort=s.date_added' . $url, 'SSL');
			$data['sort_date_end'] = $this->url->link('catalog/ochelp_special', 'token=' . $this->session->data['token'] . '&sort=s.date_end' . $url, 'SSL');
			
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$special_total = $this->model_catalog_ochelp_special->getTotalSpecial();
			
			$pagination = new Pagination();
			$pagination->total = $special_total;
			$pagination->page = $page;
			$pagination->limit = $this->config->get('config_limit_admin');
			$pagination->url = $this->url->link('catalog/ochelp_special', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
			$data['pagination'] = $pagination->render();
			
			$data['results'] = sprintf($this->language->get('text_pagination'), ($special_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($special_total - $this->config->get('config_limit_admin'))) ? $special_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $special_total, ceil($special_total / $this->config->get('config_limit_admin')));
			
			$data['sort'] = $sort;
			$data['order'] = $order;
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
			$this->response->setOutput($this->load->view('catalog/ochelp_special_list.tpl', $data));
			
		}
		
		private function getForm() {
			
			$this->load->language('catalog/ochelp_special');
			
			$this->load->model('catalog/ochelp_special');
			
			//CKEditor
			//CKEditor
			if ($this->config->get('config_editor_default')) {
				$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
				$this->document->addScript('view/javascript/ckeditor/ckeditor_init.js');
				} else {
				$this->document->addScript('view/javascript/summernote/summernote.js');
				$this->document->addScript('view/javascript/summernote/lang/summernote-' . $this->language->get('lang') . '.js');
				$this->document->addScript('view/javascript/summernote/opencart.js');
				$this->document->addStyle('view/javascript/summernote/summernote.css');
			}
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$data['heading_title'] = $this->language->get('heading_title');
			
			$data['text_form'] = !isset($this->request->get['special_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
			$data['text_default'] = $this->language->get('text_default');
			$data['text_enabled'] = $this->language->get('text_enabled');
			$data['text_disabled'] = $this->language->get('text_disabled');
			$data['text_image_manager'] = $this->language->get('text_image_manager');
			$data['text_browse'] = $this->language->get('text_browse');
			$data['text_clear'] = $this->language->get('text_clear');
			
			$data['text_select_all'] = $this->language->get('text_select_all');
			$data['text_unselect_all'] = $this->language->get('text_unselect_all');
			
			$data['entry_title'] = $this->language->get('entry_title');
			$data['entry_meta_title'] = $this->language->get('entry_meta_title');
			$data['entry_meta_h1'] = $this->language->get('entry_meta_h1');
			$data['entry_meta_description'] = $this->language->get('entry_meta_description');
			$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
			$data['entry_description'] = $this->language->get('entry_description');
			$data['entry_date_added'] = $this->language->get('entry_date_added');
			$data['entry_date_end'] = $this->language->get('entry_date_end');
			
			$data['entry_product'] = $this->language->get('entry_product');
			$data['entry_current_price'] = $this->language->get('entry_current_price');
			$data['entry_current_special'] = $this->language->get('entry_current_special');
			$data['entry_price'] = $this->language->get('entry_price');
			$data['entry_percent'] = $this->language->get('entry_percent');
			
			$data['entry_store'] = $this->language->get('entry_store');
			$data['entry_keyword'] = $this->language->get('entry_keyword');
			$data['entry_image'] = $this->language->get('entry_image');
			$data['entry_banner'] = $this->language->get('entry_banner');
			$data['entry_sort_order'] = $this->language->get('entry_sort_order');
			$data['entry_counter'] = $this->language->get('entry_counter');
			$data['entry_total'] = $this->language->get('entry_total');
			$data['entry_show_title'] = $this->language->get('entry_show_title');
			$data['entry_status'] = $this->language->get('entry_status');
			
			$data['button_add'] = $this->language->get('button_add');
			$data['button_remove'] = $this->language->get('button_remove');
			$data['button_save'] = $this->language->get('button_save');
			$data['button_cancel'] = $this->language->get('button_cancel');
			
			$data['tab_general'] = $this->language->get('tab_general');
			$data['tab_data'] = $this->language->get('tab_data');
			$data['tab_special'] = $this->language->get('tab_special');
			
			$data['help_keyword'] = $this->language->get('help_keyword');
			
			$data['token'] = $this->session->data['token'];
			$data['ckeditor'] = $this->config->get('config_editor_default');
			
			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
				} else {
				$data['error_warning'] = '';
			}
			
			if (isset($this->error['title'])) {
				$data['error_title'] = $this->error['title'];
				} else {
				$data['error_title'] = array();
			}
			
			if (isset($this->error['description'])) {
				$data['error_description'] = $this->error['description'];
				} else {
				$data['error_description'] = array();
			}
			
			if (isset($this->error['meta_title'])) {
				$data['error_meta_title'] = $this->error['meta_title'];
				} else {
				$data['error_meta_title'] = array();
			}
			
			if (isset($this->error['keyword'])) {
				$data['error_keyword'] = $this->error['keyword'];
				} else {
				$data['error_keyword'] = '';
			}
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_home'),
			'separator' => false,
			);
			
			$data['breadcrumbs'][] = array(
			'href' => $this->url->link('catalog/ochelp_special', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('heading_title'),
			'separator' => ' :: ',
			);
			
			if (!isset($this->request->get['special_id'])) {
				$data['action'] = $this->url->link('catalog/ochelp_special/add', 'token=' . $this->session->data['token'], 'SSL');
				} else {
				$data['action'] = $this->url->link('catalog/ochelp_special/edit', 'token=' . $this->session->data['token'] . '&special_id=' . $this->request->get['special_id'], 'SSL');
			}
			
			$data['cancel'] = $this->url->link('catalog/ochelp_special', 'token=' . $this->session->data['token'], 'SSL');
			
			if ((isset($this->request->get['special_id'])) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
				$special_info = $this->model_catalog_ochelp_special->getSpecial($this->request->get['special_id']);
			}
			
			$this->load->model('localisation/language');
			
			$data['languages'] = $this->model_localisation_language->getLanguages();
			
			$data['lang'] = $this->language->get('lang');
			
			if (isset($this->request->post['special_description'])) {
				$data['special_description'] = $this->request->post['special_description'];
				} elseif (isset($this->request->get['special_id'])) {
				$data['special_description'] = $this->model_catalog_ochelp_special->getSpecialDescriptions($this->request->get['special_id']);
				} else {
				$data['special_description'] = array();
			}
			
			$this->load->model('tool/image');
			
			foreach ($data['special_description'] as $language_id => &$special_description){
				if (!empty($special_description) && is_file(DIR_IMAGE . $special_description['banner'])) {
					$special_description['banner_thumb'] = $this->model_tool_image->resize($special_description['banner'], 100, 100);
					} else {
					$special_description['banner_thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
				}
			}
					
			foreach ($data['special_description'] as $language_id => &$description){
				if (!empty($description) && is_file(DIR_IMAGE . $description['image'])) {
					$description['thumb'] = $this->model_tool_image->resize($description['image'], 100, 100);
					} else {
					$description['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
				}
			}
			
			if (isset($this->request->post['date_added'])) {
				$data['date_added'] = $this->request->post['date_added'];
				} elseif (isset($special_info['date_added'])) {
				$data['date_added'] = $special_info['date_added'];
				} else {
				$data['date_added'] = date('Y-m-d');
			}
			
			if (isset($this->request->post['date_end'])) {
				$data['date_end'] = $this->request->post['date_end'];
				} elseif (isset($special_info['date_end'])) {
				$data['date_end'] = $special_info['date_end'];
				} else {
				$data['date_end'] = date('Y-m-d');
			}		
			
			$this->load->model('setting/store');
			
			$data['stores'] = $this->model_setting_store->getStores();
			
			if (isset($this->request->post['special_store'])) {
				$data['special_store'] = $this->request->post['special_store'];
				} elseif (isset($special_info)) {
				$data['special_store'] = $this->model_catalog_ochelp_special->getSpecialStores($this->request->get['special_id']);
				} else {
				$data['special_store'] = array(0);
			}
			
			if (isset($this->request->post['keyword'])) {
				$data['keyword'] = $this->request->post['keyword'];
				} elseif (isset($special_info)) {
				$data['keyword'] = $special_info['keyword'];
				} else {
				$data['keyword'] = '';
			}
			
			if (isset($this->request->post['sort_order'])) {
				$data['sort_order'] = $this->request->post['sort_order'];
				} elseif (isset($special_info)) {
				$data['sort_order'] = $special_info['sort_order'];
				} else {
				$data['sort_order'] = '';
			}
			
			if (isset($this->request->post['counter'])) {
				$data['counter'] = $this->request->post['counter'];
				} elseif (isset($special_info)) {
				$data['counter'] = $special_info['counter'];
				} else {
				$data['counter'] = '';
			}
			
			if (isset($this->request->post['total'])) {
				$data['total'] = $this->request->post['total'];
				} elseif (isset($special_info)) {
				$data['total'] = $special_info['total'];
				} else {
				$data['total'] = '0';
			}
			
			if (isset($this->request->post['show_title'])) {
				$data['show_title'] = $this->request->post['show_title'];
				} elseif (isset($special_info)) {
				$data['show_title'] = $special_info['show_title'];
				} else {
				$data['show_title'] = '';
			}
			
			if (isset($this->request->post['status'])) {
				$data['status'] = $this->request->post['status'];
				} elseif (isset($special_info)) {
				$data['status'] = $special_info['status'];
				} else {
				$data['status'] = '';
			}

			if (isset($this->request->post['homepage'])) {
				$data['homepage'] = $this->request->post['homepage'];
				} elseif (isset($special_info)) {
				$data['homepage'] = $special_info['homepage'];
				} else {
				$data['homepage'] = '';
			}

			if (isset($this->request->post['retail'])) {
				$data['retail'] = $this->request->post['retail'];
				} elseif (isset($special_info)) {
				$data['retail'] = $special_info['retail'];
				} else {
				$data['retail'] = '';
			}
			
			if (isset($this->request->post['image'])) {
				$data['image'] = $this->request->post['image'];
				} elseif (!empty($special_info)) {
				$data['image'] = $special_info['image'];
				} else {
				$data['image'] = '';
			}
			
			$this->load->model('tool/image');
			
			if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
				$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
				} elseif (!empty($special_info) && is_file(DIR_IMAGE . $special_info['image'])) {
				$data['thumb'] = $this->model_tool_image->resize($special_info['image'], 100, 100);
				} else {
				$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
			}
			
			if (isset($this->request->post['banner'])) {
				$data['banner'] = $this->request->post['banner'];
				} elseif (!empty($special_info)) {
				$data['banner'] = $special_info['banner'];
				} else {
				$data['banner'] = '';
			}
			
			if (isset($this->request->post['banner']) && is_file(DIR_IMAGE . $this->request->post['banner'])) {
				$data['banner_thumb'] = $this->model_tool_image->resize($this->request->post['banner'], 100, 100);
				} elseif (!empty($special_info) && is_file(DIR_IMAGE . $special_info['banner'])) {
				$data['banner_thumb'] = $this->model_tool_image->resize($special_info['banner'], 100, 100);
				} else {
				$data['banner_thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
			}
			
			$this->load->model('catalog/product');
			
			if (isset($this->request->post['special_product'])) {
				$products = $this->request->post['special_product'];
				} elseif (isset($this->request->get['special_id'])) {
				$products = $this->model_catalog_ochelp_special->getSpecialProduct($this->request->get['special_id']);
				} else {
				$products = array();
			}
			
			$this->load->model('tool/image');
			
			$data['special_products'] = array();
			
			foreach ($products as $product) {
				$special_product = $this->model_catalog_product->getProduct($product['product_id']);
				
				if (is_file(DIR_IMAGE . $special_product['image'])) {
					$image = $this->model_tool_image->resize($special_product['image'], 40, 40);
					} else {
					$image = $this->model_tool_image->resize('no_image.png', 40, 40);
				}
				
				if ($special_product) {
					$data['special_products'][] = array(
					'product_id' => $special_product['product_id'],
					'image'      => $image,
					'name'       => $special_product['name'],
					'current_price' => $special_product['price'],
					'current_specials' => $this->model_catalog_product->getProductSpecials($product['product_id']),
					'price'      => $product['price'],
					'percent'    => $product['percent']
					);
				}
			}
			
			$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
			$this->response->setOutput($this->load->view('catalog/ochelp_special_form.tpl', $data));
			
		}
		
		public function setting($check = 0) {
			$this->load->language('catalog/ochelp_special');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->load->model('setting/setting');
			$this->load->model('catalog/ochelp_special');
			
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateSetting()) {
				$this->model_setting_setting->editSetting('special_setting', $this->request->post);
				
				$this->model_catalog_ochelp_special->setUrlAlias($this->request->post['special_keyword']);
				
				$this->session->data['success'] = $this->language->get('text_success');
				
				$this->cache->delete('special_setting');
				
				$this->response->redirect($this->url->link('catalog/ochelp_special', 'token=' . $this->session->data['token'], 'SSL'));
			}
			
			$data['token'] = $this->session->data['token'];
			
			$data['check'] = $check; //Check if tables not install, show install button
			
			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
				} else {
				$data['error_warning'] = '';
			}
			
			if (isset($this->error['thumb'])) {
				$data['error_thumb'] = $this->error['thumb'];
				} else {
				$data['error_thumb'] = '';
			}
			
			if (isset($this->error['popup'])) {
				$data['error_popup'] = $this->error['popup'];
				} else {
				$data['error_popup'] = '';
			}
			
			if (isset($this->error['description_limit'])) {
				$data['error_limit'] = $this->error['description_limit'];
				} else {
				$data['error_limit'] = '';
			}
			
			$data['heading_title'] = $this->language->get('heading_title');
			
			$data['text_yes'] = $this->language->get('text_yes');
			$data['text_no'] = $this->language->get('text_no');
			
			$data['button_save'] = $this->language->get('button_save');
			$data['button_cancel'] = $this->language->get('button_cancel');
			$data['button_install'] = $this->language->get('button_install');
			
			$data['entry_thumb'] = $this->language->get('entry_thumb');
			$data['entry_popup'] = $this->language->get('entry_popup');
			$data['entry_share'] = $this->language->get('entry_share');
			$data['entry_limit'] = $this->language->get('entry_limit');
			$data['entry_special_keyword'] = $this->language->get('entry_special_keyword');
			
			$data['entry_width'] = $this->language->get('entry_width');
			$data['entry_height'] = $this->language->get('entry_height');
			
			$data['action'] = $this->url->link('catalog/ochelp_special/setting', 'token=' . $this->session->data['token'], 'SSL');
			$data['cancel'] = $this->url->link('catalog/ochelp_special', 'token=' . $this->session->data['token'], 'SSL');
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_home'),
			'separator' => false,
			);
			
			$data['breadcrumbs'][] = array(
			'href' => $this->url->link('catalog/ochelp_special', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('heading_title'),
			'separator' => ' :: ',
			);
			
			$data['breadcrumbs'][] = array(
			'href' => $this->url->link('catalog/ochelp_special/setting', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_special_setting'),
			'separator' => ' :: ',
			);
			
			if (isset($this->request->post['special_setting'])) {
				$special_setting = $this->request->post['special_setting'];
				} elseif ($this->config->get('special_setting')) {
				$special_setting = $this->config->get('special_setting');
				} else {
				$special_setting = array();
			}
			
			if (isset($special_setting['special_thumb_width'])) {
				$data['special_thumb_width'] = $special_setting['special_thumb_width'];
				} else {
				$data['special_thumb_width'] = '';
			}
			
			if (isset($special_setting['special_thumb_height'])) {
				$data['special_thumb_height'] = $special_setting['special_thumb_height'];
				} else {
				$data['special_thumb_height'] = '';
			}
			
			if (isset($special_setting['special_popup_width'])) {
				$data['special_popup_width'] = $special_setting['special_popup_width'];
				} else {
				$data['special_popup_width'] = '';
			}
			
			if (isset($special_setting['special_popup_height'])) {
				$data['special_popup_height'] = $special_setting['special_popup_height'];
				} else {
				$data['special_popup_height'] = '';
			}
			
			if (isset($special_setting['description_limit'])) {
				$data['description_limit'] = $special_setting['description_limit'];
				} else {
				$data['description_limit'] = '';
			}
			
			if (isset($special_setting['special_share'])) {
				$data['special_share'] = $special_setting['special_share'];
				} else {
				$data['special_share'] = '';
			}
			
			$this->load->model('catalog/url_alias');
			
			$url_alias_info = $this->model_catalog_ochelp_special->getUrlAlias('information/ochelp_special');
			
			if($url_alias_info){
				$data['special_keyword'] = $url_alias_info['keyword'];
				}else{
				$data['special_keyword'] = '';
			}
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
			$this->response->setOutput($this->load->view('catalog/ochelp_special_setting.tpl', $data));
		}
		
		public function install() {
			$this->load->language('catalog/ochelp_special');
			
			$this->load->model('catalog/ochelp_special');
			
			$json = array();
			
			if (!$this->user->hasPermission('modify', 'catalog/ochelp_special')) {
				$json['error'] = $this->language->get('error_permission');
				} else {
				$this->model_catalog_ochelp_special->install();
				
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('catalog/ochelp_special', 'token=' . $this->session->data['token'], 'SSL'));
				
				$json['success'] = $this->language->get('text_install_success');
			}
			
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
		
		protected function validateForm() {
			if (!$this->user->hasPermission('modify', 'catalog/ochelp_special')) {
				$this->error['warning'] = $this->language->get('error_permission');
			}
			
			foreach ($this->request->post['special_description'] as $language_id => $value) {
				if ((strlen($value['title']) < 3) || (strlen($value['title']) > 255)) {
					$this->error['title'][$language_id] = $this->language->get('error_title');
				}
				
				if (strlen($value['description']) < 3) {
					$this->error['description'][$language_id] = $this->language->get('error_description');
				}
			}
			
			if (utf8_strlen($this->request->post['keyword']) > 0) {
				$this->load->model('catalog/url_alias');
				
				$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);
				
				if ($url_alias_info && isset($this->request->get['special_id']) && $url_alias_info['query'] != 'special_id=' . $this->request->get['special_id']) {
					$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
				}
				
				if ($url_alias_info && !isset($this->request->get['special_id'])) {
					$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
				}
			}
			
			return !$this->error;
		}
		
		protected function validateDelete() {
			if (!$this->user->hasPermission('modify', 'catalog/ochelp_special')) {
				$this->error['warning'] = $this->language->get('error_permission');
			}
			
			return !$this->error;
		}
		
		protected function validateSetting() {
			if (!$this->user->hasPermission('modify', 'catalog/ochelp_special')) {
				$this->error['warning'] = $this->language->get('error_permission');
			}
			
			$special_setting = $this->request->post['special_setting'];
			
			if (!$special_setting['special_thumb_width'] || !$special_setting['special_thumb_height']) {
				$this->error['thumb'] = $this->language->get('error_thumb');
			}
			
			if (!$special_setting['special_popup_width'] || !$special_setting['special_popup_height']) {
				$this->error['popup'] = $this->language->get('error_popup');
			}
			
			if (!$special_setting['description_limit']) {
				$this->error['description_limit'] = $this->language->get('error_description_limit');
			}
			
			if (utf8_strlen($this->request->post['special_keyword']) > 0) {
				$this->load->model('catalog/url_alias');
				
				$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['special_keyword']);
				
				if ($url_alias_info && $url_alias_info['query'] != 'information/ochelp_special') {
					$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
				}
			}
			
			return !$this->error;
		}
		
		public function autocomplete() {
			$json = array();
			
			if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
				$this->load->model('catalog/product');
				
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
					$limit = 20;
				}
				
				$filter_data = array(
				'filter_name' => $filter_name,
				'filter_model' => $filter_model,
				'start' => 0,
				'limit' => $limit,
				);
				
				$results = $this->model_catalog_product->getProducts($filter_data);
				
				foreach ($results as $result) {
					$json[] = array(
					'product_id' => $result['product_id'],
					'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model' => $result['model'],
					'price' => $result['price'],
					);
				}
			}
			
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}		