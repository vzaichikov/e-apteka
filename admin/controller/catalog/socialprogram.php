<?php
	class ControllerCatalogSocialprogram extends Controller {
		private $error = array();
		private $socialprogram_id = 0;
		private $path = array();
		
		public function index() {
			$this->load->language('catalog/socialprogram');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->load->model('catalog/socialprogram');
			
			$this->getList();
		}
		
		public function add() {
			$this->load->language('catalog/socialprogram');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->load->model('catalog/socialprogram');
			
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
				$this->model_catalog_socialprogram->addSocialprogram($this->request->post);
				
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
				
				$this->response->redirect($this->url->link('catalog/socialprogram', 'token=' . $this->session->data['token'] . $url, true));
			}
			
			$this->getForm();
		}
		
		public function edit() {
			$this->load->language('catalog/socialprogram');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->load->model('catalog/socialprogram');
			
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
				$this->model_catalog_socialprogram->editSocialprogram($this->request->get['socialprogram_id'], $this->request->post);
				
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
				
				$this->response->redirect($this->url->link('catalog/socialprogram', 'token=' . $this->session->data['token'] . $url, true));
			}
			
			$this->getForm();
		}
		
		public function delete() {
			$this->load->language('catalog/socialprogram');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->load->model('catalog/socialprogram');
			
			if (isset($this->request->post['selected']) && $this->validateDelete()) {
				foreach ($this->request->post['selected'] as $socialprogram_id) {
					$this->model_catalog_socialprogram->deleteSocialprogram($socialprogram_id);
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
				
				$this->response->redirect($this->url->link('catalog/socialprogram', 'token=' . $this->session->data['token'] . $url, true));
			}
			
			$this->getList();
		}
		
		public function repair() {
			$this->load->language('catalog/socialprogram');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->load->model('catalog/socialprogram');
			
			if ($this->validateRepair()) {
				$this->model_catalog_socialprogram->repairSocialprograms();
				
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
				
				$this->response->redirect($this->url->link('catalog/socialprogram', 'token=' . $this->session->data['token'] . $url, true));
			}
			
			$this->getList();
		}
		
		protected function getList() {
			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
				} else {
				$sort = 'name';
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
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
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
			'href' => $this->url->link('catalog/socialprogram', 'token=' . $this->session->data['token'] . $url, true)
			);
			
			$data['add'] = $this->url->link('catalog/socialprogram/add', 'token=' . $this->session->data['token'] . $url, true);
			$data['delete'] = $this->url->link('catalog/socialprogram/delete', 'token=' . $this->session->data['token'] . $url, true);
			$data['repair'] = $this->url->link('catalog/socialprogram/repair', 'token=' . $this->session->data['token'] . $url, true);
			
			$data['socialprograms'] = array();
			
			if (isset($this->request->get['path'])) {
				if ($this->request->get['path'] != '') {
					$this->path = explode('_', $this->request->get['path']);
					$this->socialprogram_id = end($this->path);
					$this->session->data['path'] = $this->request->get['path'];
					} else {
					unset($this->session->data['path']);
				}
				} elseif (isset($this->session->data['path'])) {
				$this->path = explode('_', $this->session->data['path']);
				$this->socialprogram_id = end($this->path);
			}
			
			$data['socialprograms'] = $this->getSocialprograms(0);
			
			$socialprogram_total = count($data['socialprograms']);
			
			$data['heading_title'] = $this->language->get('heading_title');
			
			$data['text_list'] = $this->language->get('text_list');
			$data['text_no_results'] = $this->language->get('text_no_results');
			$data['text_confirm'] = $this->language->get('text_confirm');
			
			$data['column_name'] = $this->language->get('column_name');
			$data['column_sort_order'] = $this->language->get('column_sort_order');
			$data['column_action'] = $this->language->get('column_action');
			
			$data['button_add'] = $this->language->get('button_add');
			$data['button_edit'] = $this->language->get('button_edit');
			$data['button_delete'] = $this->language->get('button_delete');
			$data['button_rebuild'] = $this->language->get('button_rebuild');
			
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
			
			if ($order == 'ASC') {
				$url .= '&order=DESC';
				} else {
				$url .= '&order=ASC';
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$data['sort_name'] = $this->url->link('catalog/socialprogram', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
			$data['sort_sort_order'] = $this->url->link('catalog/socialprogram', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, true);
			
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}
			
			$pagination = new Pagination();
			$pagination->total = $socialprogram_total;
			$pagination->page = $page;
			$pagination->limit = $this->config->get('config_limit_admin');
			$pagination->url = $this->url->link('catalog/socialprogram', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
			
			$data['pagination'] = $pagination->render();
			
			$data['results'] = sprintf($this->language->get('text_pagination'), ($socialprogram_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($socialprogram_total - $this->config->get('config_limit_admin'))) ? $socialprogram_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $socialprogram_total, ceil($socialprogram_total / $this->config->get('config_limit_admin')));
			
			$data['sort'] = $sort;
			$data['order'] = $order;
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
			$this->response->setOutput($this->load->view('catalog/socialprogram_list', $data));
		}
		
		protected function getForm() {
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
			
			$data['heading_title'] = $this->language->get('heading_title');
			
			$data['text_form'] = !isset($this->request->get['socialprogram_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
			$data['text_none'] = $this->language->get('text_none');
			$data['text_default'] = $this->language->get('text_default');
			$data['text_enabled'] = $this->language->get('text_enabled');
			$data['text_disabled'] = $this->language->get('text_disabled');
			
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_description'] = $this->language->get('entry_description');
			$data['entry_meta_title'] = $this->language->get('entry_meta_title');
			$data['entry_meta_h1'] = $this->language->get('entry_meta_h1');
			$data['entry_meta_description'] = $this->language->get('entry_meta_description');
			$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
			$data['entry_keyword'] = $this->language->get('entry_keyword');
			$data['entry_parent'] = $this->language->get('entry_parent');
			$data['entry_filter'] = $this->language->get('entry_filter');
			$data['entry_store'] = $this->language->get('entry_store');
			$data['entry_image'] = $this->language->get('entry_image');
			$data['entry_top'] = $this->language->get('entry_top');
			$data['entry_column'] = $this->language->get('entry_column');
			$data['entry_sort_order'] = $this->language->get('entry_sort_order');
			$data['entry_status'] = $this->language->get('entry_status');
			$data['entry_layout'] = $this->language->get('entry_layout');
			$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
			$data['entry_related'] = $this->language->get('entry_related');
			
			$data['help_filter'] = $this->language->get('help_filter');
			$data['help_keyword'] = $this->language->get('help_keyword');
			$data['help_top'] = $this->language->get('help_top');
			$data['help_column'] = $this->language->get('help_column');
			$data['help_related'] = $this->language->get('help_related');
			
			$data['button_save'] = $this->language->get('button_save');
			$data['button_cancel'] = $this->language->get('button_cancel');
			
			$data['tab_general'] = $this->language->get('tab_general');
			$data['tab_data'] = $this->language->get('tab_data');
			$data['tab_design'] = $this->language->get('tab_design');
			
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
			
			if (isset($this->error['keyword'])) {
				$data['error_keyword'] = $this->error['keyword'];
				} else {
				$data['error_keyword'] = '';
			}
			
			if (isset($this->error['parent'])) {
				$data['error_parent'] = $this->error['parent'];
				} else {
				$data['error_parent'] = '';
			}
			
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
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/socialprogram', 'token=' . $this->session->data['token'] . $url, true)
			);
			
			if (!isset($this->request->get['socialprogram_id'])) {
				$data['action'] = $this->url->link('catalog/socialprogram/add', 'token=' . $this->session->data['token'] . $url, true);
				} else {
				$data['action'] = $this->url->link('catalog/socialprogram/edit', 'token=' . $this->session->data['token'] . '&socialprogram_id=' . $this->request->get['socialprogram_id'] . $url, true);
			}
			
			$data['cancel'] = $this->url->link('catalog/socialprogram', 'token=' . $this->session->data['token'] . $url, true);
			
			if (isset($this->request->get['socialprogram_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
				$socialprogram_info = $this->model_catalog_socialprogram->getSocialprogram($this->request->get['socialprogram_id']);
			}
			
			$data['token'] = $this->session->data['token'];
			$data['ckeditor'] = $this->config->get('config_editor_default');
			
			$this->load->model('localisation/language');
			
			$data['languages'] = $this->model_localisation_language->getLanguages();
			
			$data['lang'] = $this->language->get('lang');
			
			if (isset($this->request->post['socialprogram_description'])) {
				$data['socialprogram_description'] = $this->request->post['socialprogram_description'];
				} elseif (isset($this->request->get['socialprogram_id'])) {
				$data['socialprogram_description'] = $this->model_catalog_socialprogram->getSocialprogramDescriptions($this->request->get['socialprogram_id']);
				} else {
				$data['socialprogram_description'] = array();
			}
			
			$this->load->model('tool/image');

			foreach ($data['socialprogram_description'] as $language_id => &$description){
				if (!empty($description) && is_file(DIR_IMAGE . $description['banner'])) {
					$description['thumb'] = $this->model_tool_image->resize($description['banner'], 100, 100);
					} else {
					$description['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
				}
			}
			
			
			// Socialprograms
			$socialprograms = $this->model_catalog_socialprogram->getAllSocialprograms();
			
			$data['socialprograms'] = $this->getAllSocialprograms($socialprograms);
			
			if (isset($socialprogram_info)) {
				unset($data['socialprograms'][$socialprogram_info['socialprogram_id']]);
			}
			
			if (isset($this->request->post['parent_id'])) {
				$data['parent_id'] = $this->request->post['parent_id'];
				} elseif (!empty($socialprogram_info)) {
				$data['parent_id'] = $socialprogram_info['parent_id'];
				} else {
				$data['parent_id'] = 0;
			}
			
			$this->load->model('catalog/manufacturer');
			
			$data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();
			
			if (isset($this->request->post['manufacturer_id'])) {
				$data['manufacturer_id'] = $this->request->post['manufacturer_id'];
				} elseif (!empty($socialprogram_info)) {
				$data['manufacturer_id'] = $socialprogram_info['manufacturer_id'];
				} else {
				$data['manufacturer_id'] = 0;
			}
			
			if (isset($this->request->post['sync_name'])) {
				$data['sync_name'] = $this->request->post['sync_name'];
				} elseif (!empty($socialprogram_info)) {
				$data['sync_name'] = $socialprogram_info['sync_name'];
				} else {
				$data['sync_name'] = '';
			}
			
			$this->load->model('catalog/product');
			
			if (isset($this->request->post['product_related'])) {
				$products = $this->request->post['product_related'];
				} elseif (isset($this->request->get['socialprogram_id'])) {
				$products = $this->model_catalog_socialprogram->getSocialprogramProducts($this->request->get['socialprogram_id']);
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
			
			$this->load->model('catalog/filter');
			
			if (isset($this->request->post['socialprogram_filter'])) {
				$filters = $this->request->post['socialprogram_filter'];
				} elseif (isset($this->request->get['socialprogram_id'])) {
				$filters = $this->model_catalog_socialprogram->getSocialprogramFilters($this->request->get['socialprogram_id']);
				} else {
				$filters = array();
			}
			
			$data['socialprogram_filters'] = array();
			
			foreach ($filters as $filter_id) {
				$filter_info = $this->model_catalog_filter->getFilter($filter_id);
				
				if ($filter_info) {
					$data['socialprogram_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
					);
				}
			}
			
			$this->load->model('setting/store');
			
			$data['stores'] = $this->model_setting_store->getStores();
			
			if (isset($this->request->post['socialprogram_store'])) {
				$data['socialprogram_store'] = $this->request->post['socialprogram_store'];
				} elseif (isset($this->request->get['socialprogram_id'])) {
				$data['socialprogram_store'] = $this->model_catalog_socialprogram->getSocialprogramStores($this->request->get['socialprogram_id']);
				} else {
				$data['socialprogram_store'] = array(0);
			}
			
			if (isset($this->request->post['keyword'])) {
				$data['keyword'] = $this->request->post['keyword'];
				} elseif (!empty($socialprogram_info)) {
				$data['keyword'] = $socialprogram_info['keyword'];
				} else {
				$data['keyword'] = '';
			}
			
			if (isset($this->request->post['image'])) {
				$data['image'] = $this->request->post['image'];
				} elseif (!empty($socialprogram_info)) {
				$data['image'] = $socialprogram_info['image'];
				} else {
				$data['image'] = '';
			}
			
			$this->load->model('tool/image');
			
			if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
				$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
				} elseif (!empty($socialprogram_info) && is_file(DIR_IMAGE . $socialprogram_info['image'])) {
				$data['thumb'] = $this->model_tool_image->resize($socialprogram_info['image'], 100, 100);
				} else {
				$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
			}
			
			$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
			
			if (isset($this->request->post['top'])) {
				$data['top'] = $this->request->post['top'];
				} elseif (!empty($socialprogram_info)) {
				$data['top'] = $socialprogram_info['top'];
				} else {
				$data['top'] = 0;
			}
			
			if (isset($this->request->post['column'])) {
				$data['column'] = $this->request->post['column'];
				} elseif (!empty($socialprogram_info)) {
				$data['column'] = $socialprogram_info['column'];
				} else {
				$data['column'] = 1;
			}
			
			if (isset($this->request->post['sort_order'])) {
				$data['sort_order'] = $this->request->post['sort_order'];
				} elseif (!empty($socialprogram_info)) {
				$data['sort_order'] = $socialprogram_info['sort_order'];
				} else {
				$data['sort_order'] = 0;
			}
			
			if (isset($this->request->post['list'])) {
				$data['list'] = $this->request->post['list'];
				} elseif (!empty($socialprogram_info)) {
				$data['list'] = $socialprogram_info['list'];
				} else {
				$data['list'] = false;
			}
			
			if (isset($this->request->post['status'])) {
				$data['status'] = $this->request->post['status'];
				} elseif (!empty($socialprogram_info)) {
				$data['status'] = $socialprogram_info['status'];
				} else {
				$data['status'] = true;
			}
			
			if (isset($this->request->post['socialprogram_layout'])) {
				$data['socialprogram_layout'] = $this->request->post['socialprogram_layout'];
				} elseif (isset($this->request->get['socialprogram_id'])) {
				$data['socialprogram_layout'] = $this->model_catalog_socialprogram->getSocialprogramLayouts($this->request->get['socialprogram_id']);
				} else {
				$data['socialprogram_layout'] = array();
			}
			
			$this->load->model('design/layout');
			
			$data['layouts'] = $this->model_design_layout->getLayouts();
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
			$this->response->setOutput($this->load->view('catalog/socialprogram_form', $data));
		}
		
		protected function validateForm() {
			if (!$this->user->hasPermission('modify', 'catalog/socialprogram')) {
				$this->error['warning'] = $this->language->get('error_permission');
			}
			
			foreach ($this->request->post['socialprogram_description'] as $language_id => $value) {
				if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
					$this->error['name'][$language_id] = $this->language->get('error_name');
				}
			}
			
			if (isset($this->request->get['socialprogram_id']) && $this->request->post['parent_id']) {
				$results = $this->model_catalog_socialprogram->getSocialprogramPath($this->request->post['parent_id']);
				
				foreach ($results as $result) {
					if ($result['path_id'] == $this->request->get['socialprogram_id']) {
						$this->error['parent'] = $this->language->get('error_parent');
						
						break;
					}
				}
			}
			
			if (utf8_strlen($this->request->post['keyword']) > 0) {
				$this->load->model('catalog/url_alias');
				
				$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);
				
				if ($url_alias_info && isset($this->request->get['socialprogram_id']) && $url_alias_info['query'] != 'socialprogram_id=' . $this->request->get['socialprogram_id']) {
					$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
				}
				
				if ($url_alias_info && !isset($this->request->get['socialprogram_id'])) {
					$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
				}
			}
			
			if ($this->error && !isset($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_warning');
			}
			
			return !$this->error;
		}
		
		protected function validateDelete() {
			if (!$this->user->hasPermission('modify', 'catalog/socialprogram')) {
				$this->error['warning'] = $this->language->get('error_permission');
			}
			
			return !$this->error;
		}
		
		protected function validateRepair() {
			if (!$this->user->hasPermission('modify', 'catalog/socialprogram')) {
				$this->error['warning'] = $this->language->get('error_permission');
			}
			
			return !$this->error;
		}
		
		private function getSocialprograms($parent_id, $parent_path = '', $indent = '') {
			$socialprogram_id = array_shift($this->path);
			
			$output = array();
			
			static $href_socialprogram = null;
			static $href_action = null;
			
			if ($href_socialprogram === null) {
				$href_socialprogram = $this->url->link('catalog/socialprogram', 'token=' . $this->session->data['token'] . '&path=', 'SSL');
				$href_action = $this->url->link('catalog/socialprogram/update', 'token=' . $this->session->data['token'] . '&socialprogram_id=', 'SSL');
			}
			
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
			
			$results = $this->model_catalog_socialprogram->getSocialprogramsByParentId($parent_id);
			
			foreach ($results as $result) {
				$path = $parent_path . $result['socialprogram_id'];
				
				$href = ($result['children']) ? $href_socialprogram . $path : '';
				
				$name = $result['name'];
				
				if ($socialprogram_id == $result['socialprogram_id']) {
					$name = '<b>' . $name . '</b>';
					
					$data['breadcrumbs'][] = array(
					'text'      => $result['name'],
					'href'      => $href,
					'separator' => ' :: '
					);
					
					$href = '';
				}
				
				$selected = isset($this->request->post['selected']) && in_array($result['socialprogram_id'], $this->request->post['selected']);
				
				$action = array();
				
				$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $href_action . $result['socialprogram_id']
				);
				
				$output[$result['socialprogram_id']] = array(
				'socialprogram_id' => $result['socialprogram_id'],
				'name'        => $name,
				'manufacturer' => $result['manufacturer'],
				'sort_order'  => $result['sort_order'],
				'selected'    => $selected,
				'action'      => $action,
				'edit'        => $this->url->link('catalog/socialprogram/edit', 'token=' . $this->session->data['token'] . '&socialprogram_id=' . $result['socialprogram_id'] . $url, 'SSL'),
				'delete'      => $this->url->link('catalog/socialprogram/delete', 'token=' . $this->session->data['token'] . '&socialprogram_id=' . $result['socialprogram_id'] . $url, 'SSL'),
				'href'        => $href,
				'indent'      => $indent
				);
				
				if ($socialprogram_id == $result['socialprogram_id']) {
					$output += $this->getSocialprograms($result['socialprogram_id'], $path . '_', $indent . str_repeat('&nbsp;', 8));
				}
			}
			
			return $output;
		}
		
		private function getAllSocialprograms($socialprograms, $parent_id = 0, $parent_name = '') {
			$output = array();
			
			if (array_key_exists($parent_id, $socialprograms)) {
				if ($parent_name != '') {
					//$parent_name .= $this->language->get('text_separator');
					$parent_name .= ' &gt; ';
				}
				
				foreach ($socialprograms[$parent_id] as $socialprogram) {
					$output[$socialprogram['socialprogram_id']] = array(
					'socialprogram_id' => $socialprogram['socialprogram_id'],
					'name'        => $parent_name . $socialprogram['name']
					);
					
					$output += $this->getAllSocialprograms($socialprograms, $socialprogram['socialprogram_id'], $parent_name . $socialprogram['name']);
				}
			}
			
			uasort($output, array($this, 'sortByName'));
			
			return $output;
		}
		
		function sortByName($a, $b) {
			return strcmp($a['name'], $b['name']);
		}
		
		public function autocomplete() {
			$json = array();
			
			if (isset($this->request->get['filter_name'])) {
				$this->load->model('catalog/socialprogram');
				
				$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'sort'        => 'name',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 5
				);
				
				$results = $this->model_catalog_socialprogram->getSocialprograms($filter_data);
				
				foreach ($results as $result) {
					$json[] = array(
					'socialprogram_id' => $result['socialprogram_id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
					);
				}
			}
			
			$sort_order = array();
			
			foreach ($json as $key => $value) {
				$sort_order[$key] = $value['name'];
			}
			
			array_multisort($sort_order, SORT_ASC, $json);
			
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}
