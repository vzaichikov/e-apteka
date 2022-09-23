<?php
class ControllerDesignTranslate extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('design/translate');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/translate');

		$this->getList();
	}

	public function add() {
		$this->load->language('design/translate');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/translate');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_translate->addTranslate($this->request->post);

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

			$this->response->redirect($this->url->link('design/translate', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('design/translate');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/translate');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_translate->editTranslate($this->request->get['translate_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('design/translate', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('design/translate');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/translate');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $translate_id) {
				$this->model_design_translate->deleteTranslate($translate_id);
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

			$this->response->redirect($this->url->link('design/translate', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ad.name';
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
			'href' => $this->url->link('design/translate', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('design/translate/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('design/translate/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['translates'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$translate_total = $this->model_design_translate->getTotalTranslates();

		$results = $this->model_design_translate->getTranslates($filter_data);

		foreach ($results as $result) {
			$data['translates'][] = array(
				'translate_id'    => $result['translate_id'],
				'translate_group_id'            => $result['translate_group_id'],
				'status'            => $result['status'],
				'lower'            => $result['lower'],
				'layout_id'            => $result['layout_id'],
				'translates' => $this->model_design_translate->getTranslateDescriptions($result['translate_id']),
				'sort_order'      => $result['sort_order'],
				'edit'            => $this->url->link('design/translate/edit', 'token=' . $this->session->data['token'] . '&translate_id=' . $result['translate_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_translate_group'] = $this->language->get('column_translate_group');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_enabled'] = $this->language->get('text_enabled');

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

		$data['sort_name'] = $this->url->link('design/translate', 'token=' . $this->session->data['token'] . '&sort=ad.name' . $url, true);
		$data['sort_translate_group'] = $this->url->link('design/translate', 'token=' . $this->session->data['token'] . '&sort=translate_group' . $url, true);
		$data['sort_sort_order'] = $this->url->link('design/translate', 'token=' . $this->session->data['token'] . '&sort=a.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->load->model('design/layout');

		$layouts = $this->model_design_layout->getLayouts();
		
		$data['layouts'] = array();
		foreach($layouts as $row){
			$data['layouts'][$row['layout_id']] = $row;
		}
		
		$data['layouts'][0]['name'] = 'Все';
		
		$pagination = new Pagination();
		$pagination->total = $translate_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('design/translate', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($translate_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($translate_total - $this->config->get('config_limit_admin'))) ? $translate_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $translate_total, ceil($translate_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('design/translate_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['translate_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_translate_group'] = $this->language->get('entry_translate_group');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['entry_status'] = $this->language->get('entry_status');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['entry_lower'] = $this->language->get('entry_lower');
		$data['entry_layout'] = $this->language->get('entry_layout');

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

		if (isset($this->error['translate_group'])) {
			$data['error_translate_group'] = $this->error['translate_group'];
		} else {
			$data['error_translate_group'] = '';
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
			'href' => $this->url->link('design/translate', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['translate_id'])) {
			$data['action'] = $this->url->link('design/translate/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('design/translate/edit', 'token=' . $this->session->data['token'] . '&translate_id=' . $this->request->get['translate_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('design/translate', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['translate_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$translate_info = $this->model_design_translate->getTranslate($this->request->get['translate_id']);
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['translate_description'])) {
			$data['translate_description'] = $this->request->post['translate_description'];
		} elseif (isset($this->request->get['translate_id'])) {
			$data['translate_description'] = $this->model_design_translate->getTranslateDescriptions($this->request->get['translate_id']);
		} else {
			$data['translate_description'] = array();
		}

		if (isset($this->request->post['translate_group_id'])) {
			$data['translate_group_id'] = $this->request->post['translate_group_id'];
		} elseif (!empty($translate_info)) {
			$data['translate_group_id'] = $translate_info['translate_group_id'];
		} else {
			$data['translate_group_id'] = '';
		}

		//$this->load->model('design/translate_group');

		$data['translate_groups'] = array();//$this->model_design_translate_group->getTranslateGroups();

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($translate_info)) {
			$data['sort_order'] = $translate_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($translate_info)) {
			$data['status'] = $translate_info['status'];
		} else {
			$data['status'] = '';
		}

		if (isset($this->request->post['lower'])) {
			$data['lower'] = $this->request->post['lower'];
		} elseif (!empty($translate_info)) {
			$data['lower'] = $translate_info['lower'];
		} else {
			$data['lower'] = '';
		}

		if (isset($this->request->post['layout_id'])) {
			$data['layout_id'] = $this->request->post['layout_id'];
		} elseif (!empty($translate_info)) {
			$data['layout_id'] = $translate_info['layout_id'];
		} else {
			$data['layout_id'] = '';
		}
		
		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('design/translate_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'design/translate')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['translate_group_id']) {
			$this->error['translate_group'] = $this->language->get('error_translate_group');
		}

		foreach ($this->request->post['translate_description'] as $language_id => $value) {
			//if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 364)) {
			//	$this->error['name'][$language_id] = $this->language->get('error_name');
			//}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'design/translate')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('design/translate');

		foreach ($this->request->post['selected'] as $translate_id) {
			//$product_total = $this->model_design_translate->getTotalProductsByTranslateId($translate_id);

			if ($product_total) {
				$this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);
			}
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('design/translate');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_design_translate->getTranslates($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'translate_id'    => $result['translate_id'],
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'translate_group' => $result['translate_group']
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
