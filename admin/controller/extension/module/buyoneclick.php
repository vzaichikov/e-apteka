<?php
class ControllerExtensionModuleBuyOneClick extends Controller {
	private $error = array();
	public function index() {
		$this->load->language('extension/module/buyoneclick');
		$this->document->setTitle($this->language->get('heading_name'));
		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('buyoneclick', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}
		// Heading
		$data['heading_title'] = $this->language->get('heading_title');
		$data['heading_name'] = $this->language->get('heading_name');
		// Text
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		//Buttons
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		// Settings
		$data['settings_main'] = $this->language->get('settings_main');
		$data['settings_sms'] = $this->language->get('settings_sms');
		$data['settings_analytics'] = $this->language->get('settings_analytics');
		// Fields
		$data['field1_title'] = $this->language->get('field1_title');
		$data['field2_title'] = $this->language->get('field2_title');
		$data['field3_title'] = $this->language->get('field3_title');
		$data['field4_title'] = $this->language->get('field4_title');
		$data['agree_title'] = $this->language->get('agree_title');
		$data['field_required'] = $this->language->get('field_required');
		// Phone validation
		$data['entry_validation_type'] = $this->language->get('entry_validation_type');
		$data['value_validation_type1'] = $this->language->get('value_validation_type1');
		$data['value_validation_type2'] = $this->language->get('value_validation_type2');
		$data['text_validation_type1'] = $this->language->get('text_validation_type1');
		$data['text_validation_type2'] = $this->language->get('text_validation_type2');
		$data['entry_validation_status'] = $this->language->get('entry_validation_status');
		// Stock warning
		$data['text_stock_warning'] = $this->language->get('text_stock_warning');
		// Entry
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_success_field'] = $this->language->get('entry_success_field');
		$data['success_field_tooltip'] = htmlspecialchars($this->language->get('success_field_tooltip'));
		// Success
		$data['entry_success_type'] = $this->language->get('entry_success_type');
		$data['success_type0'] = $this->language->get('success_type0');
		$data['success_type1'] = $this->language->get('success_type1');
		$data['success_type_tooltip'] = $this->language->get('success_type_tooltip');

		$data['entry_status_product'] = $this->language->get('entry_status_product');
		$data['entry_status_category'] = $this->language->get('entry_status_category');
		$data['entry_status_module'] = $this->language->get('entry_status_module');
		$data['entry_style_status'] = $this->language->get('entry_style_status');
		$data['entry_option_status'] = $this->language->get('entry_option_status');
		// Extended analytics
		$data['exan_form_title'] = $this->language->get('exan_form_title');
		$data['exan_status_title'] = $this->language->get('exan_status_title');
		// Yandex
		$data['ya_form_title'] = $this->language->get('ya_form_title');
		$data['ya_counter_title'] = $this->language->get('ya_counter_title');
		$data['ya_identificator_title'] = $this->language->get('ya_identificator_title');
		$data['ya_identificator_send_title'] = $this->language->get('ya_identificator_send_title');
		$data['ya_identificator_success_title'] = $this->language->get('ya_identificator_success_title');
		$data['ya_target_status_title'] = $this->language->get('ya_target_status_title');
		// Google
		$data['google_form_title'] = $this->language->get('google_form_title');
		$data['google_category_btn_title'] = $this->language->get('google_category_btn_title');
		$data['google_action_btn_title'] = $this->language->get('google_action_btn_title');
		$data['google_category_send_title'] = $this->language->get('google_category_send_title');
		$data['google_action_send_title'] = $this->language->get('google_action_send_title');
		$data['google_category_success_title'] = $this->language->get('google_category_success_title');
		$data['google_action_success_title'] = $this->language->get('google_action_success_title');
		$data['google_target_status_title'] = $this->language->get('google_target_status_title');
		// SMSC.ua
		$data['smscua_form_title'] = $this->language->get('smscua_form_title');
		$data['smscua_form_subtitle'] = $this->language->get('smscua_form_subtitle');
		$data['smscua_login_title'] = $this->language->get('smscua_login_title');
		$data['smscua_password_title'] = $this->language->get('smscua_password_title');
		$data['smscua_number_title'] = $this->language->get('smscua_number_title');
		$data['smscua_number_tooltip'] = $this->language->get('smscua_number_tooltip');
		$data['smscua_name_title'] = $this->language->get('smscua_name_title');
		$data['smscua_name_tooltip'] = $this->language->get('smscua_name_tooltip');
		$data['smscua_admin_sms_title'] = $this->language->get('smscua_admin_sms_title');
		$data['smscua_admin_sms_tooltip'] = $this->language->get('smscua_admin_sms_tooltip');
		$data['smscua_client_sms_title'] = $this->language->get('smscua_client_sms_title');
		$data['smscua_client_sms_tooltip'] = $this->language->get('smscua_client_sms_tooltip');
		$data['smscua_client_status_title'] = $this->language->get('smscua_client_status_title');
		$data['smscua_client_status_tooltip'] = $this->language->get('smscua_client_status_tooltip');
		$data['smscua_admin_status_title'] = $this->language->get('smscua_admin_status_title');
		// SMS.ru
		$data['smsru_form_title'] = $this->language->get('smsru_form_title');
		$data['smsru_form_subtitle'] = $this->language->get('smsru_form_subtitle');
		$data['smsru_api_title'] = $this->language->get('smsru_api_title');
		$data['smsru_api_tooltip'] = $this->language->get('smsru_api_tooltip');
		$data['smsru_login_title'] = $this->language->get('smsru_login_title');
		$data['smsru_password_title'] = $this->language->get('smsru_password_title');
		$data['smsru_number_title'] = $this->language->get('smsru_number_title');
		$data['smsru_number_tooltip'] = $this->language->get('smsru_number_tooltip');
		$data['smsru_name_title'] = $this->language->get('smsru_name_title');
		$data['smsru_name_tooltip'] = $this->language->get('smsru_name_tooltip');
		$data['smsru_admin_sms_title'] = $this->language->get('smsru_admin_sms_title');
		$data['smsru_admin_sms_tooltip'] = $this->language->get('smsru_admin_sms_tooltip');
		$data['smsru_client_sms_title'] = $this->language->get('smsru_client_sms_title');
		$data['smsru_client_sms_tooltip'] = $this->language->get('smsru_client_sms_tooltip');
		$data['smsru_client_status_title'] = $this->language->get('smsru_client_status_title');
		$data['smsru_client_status_tooltip'] = $this->language->get('smsru_client_status_tooltip');
		$data['smsru_admin_status_title'] = $this->language->get('smsru_admin_status_title');
		// Help
		$data['text_tab_help'] = $this->language->get('text_tab_help');
		$data['text_tab_help_title'] = $this->language->get('text_tab_help_title');
		$data['text_help'] = $this->language->get('text_help');

		$this->load->model('catalog/information');
		$data['informations'] = $this->model_catalog_information->getInformations();
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
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_name'),
			'href' => $this->url->link('extension/module/buyoneclick', 'token=' . $this->session->data['token'], true)
		);
		$data['action'] = $this->url->link('extension/module/buyoneclick', 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$languages = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['buyoneclick'])) {
			$data['buyoneclick'] = $this->request->post['buyoneclick'];
		} else {
			$data['buyoneclick'] = $this->config->get('buyoneclick');
		}
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('extension/module/buyoneclick.tpl', $data));
	}
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/buyoneclick')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
}