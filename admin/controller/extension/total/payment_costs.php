<?php
class ControllerExtensionTotalPaymentCosts extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/total/payment_costs');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('payment_costs', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=total', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_commission'] = $this->language->get('entry_commission');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_costs'] = $this->language->get('column_costs');

		$data['error_permission'] = $this->language->get('error_permission');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_total'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=total', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/total/payment_costs', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/total/payment_costs', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=total', true);

		if (isset($this->request->post['payment_costs_status'])) {
			$data['payment_costs_status'] = $this->request->post['payment_costs_status'];
		} else {
			$data['payment_costs_status'] = $this->config->get('payment_costs_status');
		}

		if (isset($this->request->post['payment_costs_sort_order'])) {
			$data['payment_costs_sort_order'] = $this->request->post['payment_costs_sort_order'];
		} else {
			$data['payment_costs_sort_order'] = $this->config->get('payment_costs_sort_order');
		}

		if (isset($this->request->post['payment_costs'])) {
			$data['payment_costs'] = $this->request->post['payment_costs'];
		} elseif ($this->config->get('payment_costs')) {
			$data['payment_costs'] = $this->config->get('payment_costs');
		} else {
			$data['payment_costs'] = array();
		}

		$this->load->model('extension/extension');

		$extensions = $this->model_extension_extension->getInstalled('payment');

		$data['extensions'] = array();

		foreach ($extensions as $extension) {
			if (file_exists(DIR_APPLICATION . 'controller/extension/payment/' . $extension . '.php')) {
				$this->load->language('extension/payment/' . $extension);

				if (isset($data['payment_costs'][$extension])) {
					$cost = (float)$data['payment_costs'][$extension];
				} else {
					$cost = 0;
				}

				$data['extensions'][] = array(
					'name'       => $this->language->get('heading_title'),
					'code'       => $extension,
					'cost'       => $cost
				);
			}
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/total/payment_costs', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/total/payment_costs')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (isset($this->request->post['payment_costs'])) {
			foreach ($this->request->post['payment_costs'] as $code => $cost) {
				$this->request->post['payment_costs'][$code] = (float)trim(str_replace(',', '.', $cost));
			}
			if ($this->config->get('payment_costs')) {
				$this->request->post['payment_costs'] = array_merge($this->config->get('payment_costs'),$this->request->post['payment_costs']);
			}
		}
		return !$this->error;
	}
}