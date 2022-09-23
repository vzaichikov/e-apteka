<?php
class ControllerExtensionModuleLoadMore extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/loadmore');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('loadmore_', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['loadmore_button_name'] = $this->language->get('loadmore_button_name');
		$data['loadmore_button_name_title'] = $this->language->get('loadmore_button_name_title');
		$data['loadmore_style_title'] = $this->language->get('loadmore_style_title');
		$data['loadmore_default_style_title'] = $this->language->get('loadmore_default_style_title');
		$data['loadmore_arrow_status_title'] = $this->language->get('loadmore_arrow_status_title');
		$data['loadmore_status_title'] = $this->language->get('loadmore_status_title');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
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
			'href' => $this->url->link('extension/module/loadmore', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/loadmore', 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true);
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$languages = $this->model_localisation_language->getLanguages();		

		foreach ($languages as $language) {
			if (isset($this->request->post['loadmore_button_name_'.$language['language_id']])) {
				$data['loadmore_button_name_'.$language['language_id']] = $this->request->post['loadmore_button_name_'.$language['language_id']];
			} else {
				$data['loadmore_button_name_'.$language['language_id']] = $this->config->get('loadmore_button_name_'.$language['language_id']);
			}
		}
		
		if (isset($this->request->post['loadmore_style'])) {
			$data['loadmore_style'] = $this->request->post['loadmore_style'];
		} else if ($this->config->get('loadmore_style')) {
			$data['loadmore_style'] = $this->config->get('loadmore_style');
		} else {
			$data['loadmore_style'] = 'display:inline-block; margin:0 auto 20px auto; padding: 0.5em 2em; border: 1px solid #069; border-radius: 5px; text-decoration:none; text-transform:uppercase;';
		}
		
		if (isset($this->request->post['loadmore_arrow_status'])) {
			$data['loadmore_arrow_status'] = $this->request->post['loadmore_arrow_status'];
		} else {
			$data['loadmore_arrow_status'] = $this->config->get('loadmore_arrow_status');
		}

		if (isset($this->request->post['loadmore_status'])) {
			$data['loadmore_status'] = $this->request->post['loadmore_status'];
		} else {
			$data['loadmore_status'] = $this->config->get('loadmore_status');
		}		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');		

		$this->response->setOutput($this->load->view('extension/module/loadmore', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/loadmore')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
}