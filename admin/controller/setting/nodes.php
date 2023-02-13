<?php
	class ControllerSettingNodes extends Controller {
		private $error = array();
		
		public function index() {
			$this->load->language('setting/nodes');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->load->model('setting/nodes');
			
			$this->getList();
		}

		public function changetoGW() {

			$this->db->query("UPDATE oc_nodes SET node_url = REPLACE(node_url, 'http://gwr.', 'http://gw.')");
			if (file_exists(DIR_CACHE . 'orderqueue.pid')){
				unlink(DIR_CACHE . 'orderqueue.pid');				
			}

			$this->response->redirect($this->url->link('setting/nodes', 'token=' . $this->session->data['token'] . $url, true));
		}

		public function changetoGWR() {

			$this->db->query("UPDATE oc_nodes SET node_url = REPLACE(node_url, 'http://gw.', 'http://gwr.')");
			if (file_exists(DIR_CACHE . 'orderqueue.pid')){
				unlink(DIR_CACHE . 'orderqueue.pid');				
			}

			$this->response->redirect($this->url->link('setting/nodes', 'token=' . $this->session->data['token'] . $url, true));
		}

		public function clearQueue() {

			if (file_exists(DIR_CACHE . 'orderqueue.pid')){
				unlink(DIR_CACHE . 'orderqueue.pid');				
			}

			$this->response->redirect($this->url->link('setting/nodes', 'token=' . $this->session->data['token'] . $url, true));

		}
		
		public function add() {
			$this->load->language('setting/nodes');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->load->model('setting/nodes');
			
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
				$this->model_setting_nodes->addNode($this->request->post);
				
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
				
				$this->response->redirect($this->url->link('setting/nodes', 'token=' . $this->session->data['token'] . $url, true));
			}
			
			$this->getForm();
		}
		
		public function edit() {
			$this->load->language('setting/nodes');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->load->model('setting/nodes');
			
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
				$this->model_setting_nodes->editNode($this->request->get['node_id'], $this->request->post);
				
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
				
				$this->response->redirect($this->url->link('setting/nodes', 'token=' . $this->session->data['token'] . $url, true));
			}
			
			$this->getForm();
		}
		
		public function delete() {
			$this->load->language('setting/nodes');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->load->model('setting/nodes');
			
			if (isset($this->request->post['selected']) && $this->validateDelete()) {
				foreach ($this->request->post['selected'] as $node_id) {
					$this->model_setting_nodes->deleteNode($node_id);
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
				
				$this->response->redirect($this->url->link('setting/nodes', 'token=' . $this->session->data['token'] . $url, true));
			}
			
			$this->getList();
		}
		
		protected function getForm() {
			$data['heading_title'] = $this->language->get('heading_title');
			
			$data['text_form'] = !isset($this->request->get['node_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
			$data['tab_general'] = $this->language->get('tab_general');
			$data['text_enabled'] = $this->language->get('text_enabled');
			$data['text_disabled'] = $this->language->get('text_disabled');
			
			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
				} else {
				$data['error_warning'] = '';
			}
			
			if (isset($this->error['title'])) {
				$data['error_title'] = $this->error['title'];
				} else {
				$data['error_title'] = '';
			}
			
			if (isset($this->error['code'])) {
				$data['error_code'] = $this->error['code'];
				} else {
				$data['error_code'] = '';
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
			
			if (!isset($this->request->get['node_id'])) {
				$data['action'] = $this->url->link('setting/nodes/add', 'token=' . $this->session->data['token'] . $url, true);
				} else {
				$data['action'] = $this->url->link('setting/nodes/edit', 'token=' . $this->session->data['token'] . '&node_id=' . $this->request->get['node_id'] . $url, true);
			}
			
			$data['cancel'] = $this->url->link('setting/nodes', 'token=' . $this->session->data['token'] . $url, true);
			
			if (isset($this->request->get['node_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
				$node_info = $this->model_setting_nodes->getNode($this->request->get['node_id']);
			}
			
			$txt_fields = array(
			'node_name',
			'node_url',
			'node_auth',
			'node_password'						
			);
			
			$bool_fields = array(
			'is_main',
			'is_stock',
			'is_catalog',
			'is_customer',
			'is_cards',
			'is_preorder',
			);
			
			foreach ($txt_fields as $_field){
				
				if (isset($this->request->post[$_field])) {
					$data[$_field] = $this->request->post[$_field];
					} elseif (!empty($node_info)) {
					$data[$_field] = $node_info[$_field];
					} else {
					$data[$_field] = '';
				}
				
			}
			
			unset($_field);
			foreach ($bool_fields as $_field){
				
				if (isset($this->request->post[$_field])) {
					$data[$_field] = $this->request->post[$_field];
					} elseif (!empty($node_info)) {
					$data[$_field] = $node_info[$_field];
					} else {
					$data[$_field] = 0;
				}
				
			}
			
			$data['button_add'] = $this->language->get('button_add');
			$data['button_edit'] = $this->language->get('button_edit');
			$data['button_delete'] = $this->language->get('button_delete');
			$data['button_save'] = $this->language->get('button_save');
			$data['button_cancel'] = $this->language->get('button_cancel');
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
			$this->response->setOutput($this->load->view('setting/nodes_form', $data));
		}
		
		protected function getList() {
			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);
			
			
			$data['changetoGW'] = $this->url->link('setting/nodes/changetoGW', 'token=' . $this->session->data['token'], true);
			$data['changetoGWR'] = $this->url->link('setting/nodes/changetoGWR', 'token=' . $this->session->data['token'], true);
			$data['clearQueue'] = $this->url->link('setting/nodes/clearQueue', 'token=' . $this->session->data['token'], true);
			$data['add'] = $this->url->link('setting/nodes/add', 'token=' . $this->session->data['token'], true);
			$data['delete'] = $this->url->link('setting/nodes/delete', 'token=' . $this->session->data['token'], true);
			
			$data['stores'] = array();
			
			
			$results = $this->model_setting_nodes->getNodes();
			
			foreach ($results as $result) {
				$data['nodes'][] = array(
				'node_id' 				=> $result['node_id'],
				'node_name'    		 	=> $result['node_name'],
				'is_main'      			=> $result['is_main'],
				'is_stock'      		=> $result['is_stock'],
				'is_catalog'      		=> $result['is_catalog'],
				'is_customer'      		=> $result['is_customer'],
				'is_cards'      		=> $result['is_cards'],
				'node_url'      		=> $result['node_url'],
				'node_auth'      		=> $result['node_auth'],			
				'node_last_update'      => date($this->language->get('datetime_format'), strtotime($result['node_last_update'])),
				'node_last_update_status'     => $result['node_last_update_status']?$result['node_last_update_status']:'NODE_EXCHANGE_NEVER_HAPPENED',
				'node_last_update_error'      => $result['node_last_update_status']?$result['node_last_update_error']:true,
				'edit'     				=> $this->url->link('setting/nodes/edit', 'token=' . $this->session->data['token'] . '&node_id=' . $result['node_id'], true),
				'history'     			=> $this->url->link('setting/nodes/history', 'token=' . $this->session->data['token'] . '&node_id=' . $result['node_id'], true)
				);
			}

			$data['queue_running'] = (file_exists(DIR_CACHE . 'orderqueue.pid'));
			
			$data['heading_title'] = $this->language->get('heading_title');
			
			$data['text_list'] = $this->language->get('text_list');
			$data['text_no_results'] = $this->language->get('text_no_results');
			$data['text_confirm'] = $this->language->get('text_confirm');
			
			$data['column_name'] = $this->language->get('column_name');
			$data['column_url'] = $this->language->get('column_url');
			$data['column_action'] = $this->language->get('column_action');
			
			$data['button_add'] = $this->language->get('button_add');
			$data['button_edit'] = $this->language->get('button_edit');
			$data['button_delete'] = $this->language->get('button_delete');
			
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
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
			$this->response->setOutput($this->load->view('setting/nodes_list', $data));
		}
				
		
		public function history() {
			$this->load->model('setting/nodes');
			$this->load->language('setting/nodes');			
			$this->document->setTitle($this->language->get('heading_title'));
		
			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
								
			if (!isset($this->request->get['node_id'])){
				$this->response->redirect($this->url->link('setting/nodes', 'token=' . $this->session->data['token'], true));
			}
			
			if (isset($this->request->get['node_id'])) {
				$node_id = $this->request->get['node_id'];
				$node_info = $this->model_setting_nodes->getNode($this->request->get['node_id']);
				$data['node_info'] = $node_info;
			}
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('setting/nodes', 'token=' . $this->session->data['token'], true)
			);
			
			$data['breadcrumbs'][] = array(
			'text' => $node_info['node_name'],
			'href' => $this->url->link('setting/nodes/history', 'token=' . $this->session->data['token'] . '&node_id=' . $node_id, true)
			);
								
			$results = $this->model_setting_nodes->getNodeExchangeHistory($node_id);
			
			$data['histories'] = array();
			
			foreach ($results as $result) {
				$data['histories'][] = array(
					'date_added'      => date($this->language->get('datetime_format'), strtotime($result['date_added'])),
					'status'      	  => $result['status'],
					'type'      	  => $result['type'],
					'is_error'        => $result['is_error'],
					'json'      	  => $result['json']
				);
			}
			
			$data['heading_title'] = $this->language->get('heading_title');
			
			$data['cancel'] = $this->url->link('setting/nodes', 'token=' . $this->session->data['token'] . $url, true);
			
			$data['text_list'] = $this->language->get('text_list');
			$data['text_no_results'] = $this->language->get('text_no_results');
			$data['text_confirm'] = $this->language->get('text_confirm');
			
			$data['column_name'] = $this->language->get('column_name');
			$data['column_url'] = $this->language->get('column_url');
			$data['column_action'] = $this->language->get('column_action');
			
			$data['button_add'] = $this->language->get('button_add');
			$data['button_edit'] = $this->language->get('button_edit');
			$data['button_delete'] = $this->language->get('button_delete');
			$data['button_cancel'] = $this->language->get('button_cancel');
			
			
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
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
			$this->response->setOutput($this->load->view('setting/nodes_history', $data));
		}
		
		protected function validateDelete() {
			if (!$this->user->hasPermission('modify', 'setting/nodes')) {
				$this->error['warning'] = $this->language->get('error_permission');
			}			
			
			return !$this->error;
		}
		
		protected function validateForm() {
			if (!$this->user->hasPermission('modify', 'setting/nodes')) {
				$this->error['warning'] = $this->language->get('error_permission');
			}
			
			if ((utf8_strlen($this->request->post['node_name']) < 3) || (utf8_strlen($this->request->post['node_name']) > 255)) {
				$this->error['title'] = $this->language->get('error_title');
			}
			
			if (utf8_strlen($this->request->post['node_url']) < 10) {
				$this->error['code'] = $this->language->get('error_code');
			}
			
			return !$this->error;
		}
	}				