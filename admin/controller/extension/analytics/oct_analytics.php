<?php
/**************************************************************/
/*	@copyright	OCTemplates 2018.							  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */
/**************************************************************/

class ControllerExtensionAnalyticsOCTAnalytics extends Controller {
	private $error = array();

	public function index() {
		$data = array();
        $data = array_merge($data, $this->load->language('extension/analytics/oct_analytics'));

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('oct_analytics', $this->request->post, $this->request->get['store_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=analytics', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['google_code'])) {
			$data['error_google_code'] = $this->error['google_code'];
		} else {
			$data['error_google_code'] = '';
		}

		if (isset($this->error['yandex_code'])) {
			$data['error_yandex_code'] = $this->error['yandex_code'];
		} else {
			$data['error_yandex_code'] = '';
		}

		if (isset($this->error['yandex_container'])) {
			$data['error_yandex_container'] = $this->error['yandex_container'];
		} else {
			$data['error_yandex_container'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=analytics', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/analytics/oct_analytics', 'token=' . $this->session->data['token'] . '&store_id=' . $this->request->get['store_id'], true)
		);

		$data['action'] = $this->url->link('extension/analytics/oct_analytics', 'token=' . $this->session->data['token'] . '&store_id=' . $this->request->get['store_id'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=analytics', true);

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['oct_analytics_status'])) {
			$data['oct_analytics_status'] = $this->request->post['oct_analytics_status'];
		} else {
			$data['oct_analytics_status'] = $this->model_setting_setting->getSettingValue('oct_analytics_status', $this->request->get['store_id']);
		}

		if (isset($this->request->post['oct_analytics_position'])) {
			$data['oct_analytics_position'] = $this->request->post['oct_analytics_position'];
		} else {
			$data['oct_analytics_position'] = $this->model_setting_setting->getSettingValue('oct_analytics_position', $this->request->get['store_id']);
		}

		if (isset($this->request->post['oct_analytics_targets'])) {
			$data['oct_analytics_targets'] = $this->request->post['oct_analytics_targets'];
		} else {
			$data['oct_analytics_targets'] = json_decode($this->model_setting_setting->getSettingValue('oct_analytics_targets', $this->request->get['store_id']));
		}

		if (isset($this->request->post['oct_analytics_google_status'])) {
			$data['oct_analytics_google_status'] = $this->request->post['oct_analytics_google_status'];
		} else {
			$data['oct_analytics_google_status'] = $this->model_setting_setting->getSettingValue('oct_analytics_google_status', $this->request->get['store_id']);
		}

		if (isset($this->request->post['oct_analytics_google_code'])) {
			$data['oct_analytics_google_code'] = $this->request->post['oct_analytics_google_code'];
		} else {
			$data['oct_analytics_google_code'] = $this->model_setting_setting->getSettingValue('oct_analytics_google_code', $this->request->get['store_id']);
		}

		if (isset($this->request->post['oct_analytics_google_webmaster_code'])) {
			$data['oct_analytics_google_webmaster_code'] = $this->request->post['oct_analytics_google_webmaster_code'];
		} else {
			$data['oct_analytics_google_webmaster_code'] = $this->model_setting_setting->getSettingValue('oct_analytics_google_webmaster_code', $this->request->get['store_id']);
		}

		if (isset($this->request->post['oct_analytics_google_ecommerce'])) {
			$data['oct_analytics_google_ecommerce'] = $this->request->post['oct_analytics_google_ecommerce'];
		} else {
			$data['oct_analytics_google_ecommerce'] = $this->model_setting_setting->getSettingValue('oct_analytics_google_ecommerce', $this->request->get['store_id']);
		}

		if (isset($this->request->post['oct_analytics_yandex_status'])) {
			$data['oct_analytics_yandex_status'] = $this->request->post['oct_analytics_yandex_status'];
		} else {
			$data['oct_analytics_yandex_status'] = $this->model_setting_setting->getSettingValue('oct_analytics_yandex_status', $this->request->get['store_id']);
		}

		if (isset($this->request->post['oct_analytics_yandex_code'])) {
			$data['oct_analytics_yandex_code'] = $this->request->post['oct_analytics_yandex_code'];
		} else {
			$data['oct_analytics_yandex_code'] = $this->model_setting_setting->getSettingValue('oct_analytics_yandex_code', $this->request->get['store_id']);
		}

		if (isset($this->request->post['oct_analytics_yandex_container'])) {
			$data['oct_analytics_yandex_container'] = $this->request->post['oct_analytics_yandex_container'];
		} else {
			$data['oct_analytics_yandex_container'] = $this->model_setting_setting->getSettingValue('oct_analytics_yandex_container', $this->request->get['store_id']);
		}

		if (isset($this->request->post['oct_analytics_yandex_webmaster_code'])) {
			$data['oct_analytics_yandex_webmaster_code'] = $this->request->post['oct_analytics_yandex_webmaster_code'];
		} else {
			$data['oct_analytics_yandex_webmaster_code'] = $this->model_setting_setting->getSettingValue('oct_analytics_yandex_webmaster_code', $this->request->get['store_id']);
		}

		if (isset($this->request->post['oct_analytics_yandex_ecommerce'])) {
			$data['oct_analytics_yandex_ecommerce'] = $this->request->post['oct_analytics_yandex_ecommerce'];
		} else {
			$data['oct_analytics_yandex_ecommerce'] = $this->model_setting_setting->getSettingValue('oct_analytics_yandex_ecommerce', $this->request->get['store_id']);
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/analytics/oct_analytics', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/analytics/oct_analytics')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (empty($this->request->post['oct_analytics_google_code']) && $this->request->post['oct_analytics_google_status']) {
			$this->error['google_code'] = $this->language->get('error_code');
		}

		if (empty($this->request->post['oct_analytics_yandex_code']) && $this->request->post['oct_analytics_yandex_status']) {
			$this->error['yandex_code'] = $this->language->get('error_code');
		}

		if (empty($this->request->post['oct_analytics_yandex_container']) && $this->request->post['oct_analytics_yandex_ecommerce']) {
			$this->error['yandex_container'] = $this->language->get('error_code');
		}

		return !$this->error;
	}
}
