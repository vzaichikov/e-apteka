<?php
class ControllerExtensionModuleCart extends Controller {

	private $error = array();

	public function index() {
		$this->load->language('extension/module/cart');
		$this->document->setTitle($this->language->get('text_extension'));
		$this->load->model('setting/setting');

		//если запрос пост 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('cart', $this->request->post);
	
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$select_status = array(
			"0" => $this->language->get('text_disabled'),
			"1" =>  $this->language->get('text_enabled'),
		);
		$data['select_status'] = $select_status;

		$select_units = array(
			"MINUTE" => $this->language->get('text_minute'),
			"HOUR" 	 =>  $this->language->get('text_hour'),
			"DAY" 	 =>  $this->language->get('text_day'),
			"WEEK" 	 =>  $this->language->get('text_week'),
			"MONTH"  =>  $this->language->get('text_mount'),
			"YEAR" 	 =>  $this->language->get('text_year'),
		);

		$data['select_units'] = $select_units;


		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_time'] = $this->language->get('entry_time');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		//заполняем языки для вьюшки

		// isset это проверка наличия переменной
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		// набираем массив хлебных крошек text - название крошки / href = ссылка крошки

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
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/cart', 'token=' . $this->session->data['token'], true)
		);

		// адрес куда форма отправит данные
		$data['action'] = $this->url->link('extension/module/cart', 'token=' . $this->session->data['token'], true);	

		//кнпока выйти из модуля
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);


		//isset - проверка на сущщществование

		if (isset($this->request->post['cart_status'])) {
			$data['cart_status'] = $this->request->post['cart_status'];
		} else {
			$data['cart_status'] =  $this->config->get('cart_status');
		}

		if (isset($this->request->post['cart_lifetime'])) {
			$data['cart_lifetime'] = $this->request->post['cart_lifetime'];
		} elseif ($this->config->get('cart_lifetime')) {
			$data['cart_lifetime'] =  $this->config->get('cart_lifetime');
		} else {
			$data['cart_lifetime'] = 60;
		}

		if (isset($this->request->post['cart_unit'])) {
			$data['cart_unit'] = $this->request->post['cart_unit'];
		} else {
			$data['cart_unit'] =  $this->config->get('cart_unit');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['qwe'] = $this->load->controller('extension/module/cart/danya');

		$this->response->setOutput($this->load->view('extension/module/cart', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/cart')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}