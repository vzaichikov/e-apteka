<?php
class ControllerExtensionModuleCategoryWall extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/category_wall');
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('category_wall', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$version = '1.0.1';
		$data['text_info'] = $this->language->get('heading_title') . ' - ' . $version ;
		$data['text_page_module'] = $this->language->get('text_page_module');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['entry_width'] = $this->language->get('entry_width');
        $data['entry_height'] = $this->language->get('entry_height');
        $data['entry_image'] = $this->language->get('entry_image');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}

		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/category_wall', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/category_wall', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->post['category_wall_status'])) {
			$data['category_wall_status'] = $this->request->post['category_wall_status'];
		} else {
			$data['category_wall_status'] = $this->config->get('category_wall_status');
		}

		if (isset($this->request->post['category_wall_width'])) {
            $data['category_wall_width'] = $this->request->post['category_wall_width'];
        } else {
        	$data['category_wall_width'] = $this->config->get('category_wall_width');
        }

        if (isset($this->request->post['category_wall_height'])) {
        	$data['category_wall_height'] = $this->request->post['category_wall_height'];
        } else{
            $data['category_wall_height'] = $this->config->get('category_wall_height');
        }

        if (isset($this->request->post['category_wall_type'])) {
        	$data['category_wall_type'] = $this->request->post['category_wall_type'];
        } else{
            $data['category_wall_type'] = $this->config->get('category_wall_type');
        }

        if (isset($this->request->post['category_wall_category_limit'])) {
        	$data['category_wall_category_limit'] = $this->request->post['category_wall_category_limit'];
        } else{
            $data['category_wall_category_limit'] = $this->config->get('category_wall_category_limit');
        }

        if (isset($this->request->post['category_wall_product_limit'])) {
        	$data['category_wall_product_limit'] = $this->request->post['category_wall_product_limit'];
        } else{
            $data['category_wall_product_limit'] = $this->config->get('category_wall_product_limit');
        }

        if (isset($this->request->post['category_wall_product_threshold'])) {
        	$data['category_wall_product_threshold'] = $this->request->post['category_wall_product_threshold'];
        } else{
            $data['category_wall_product_threshold'] = $this->config->get('category_wall_product_threshold');
        }
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/category_wall', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/category_wall')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->request->post['category_wall_width']) {
			$this->error['width'] = $this->language->get('error_width');
		}
		if (!$this->request->post['category_wall_height']) {
			$this->error['height'] = $this->language->get('error_height');
		}
		return !$this->error;
	}
}