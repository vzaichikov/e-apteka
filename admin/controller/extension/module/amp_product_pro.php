<?php
class ControllerExtensionModuleampproductpro extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/amp_product_pro');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addStyle('view/javascript/colpick/colpick.css');
        $this->document->addScript('view/javascript/colpick/colpick.js');
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('amp_product_pro', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_related'] = $this->language->get('entry_related');
		$data['entry_rating'] = $this->language->get('entry_rating');
		$data['entry_carousel'] = $this->language->get('entry_carousel');
		$data['entry_carousel_rel'] = $this->language->get('entry_carousel_rel');
		$data['entry_background'] = $this->language->get('entry_background');
		$data['entry_links'] = $this->language->get('entry_links');
		$data['entry_cart'] = $this->language->get('entry_cart');
		$data['entry_search'] = $this->language->get('entry_search');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_logo_width'] = $this->language->get('entry_logo_width');
		$data['entry_logo_height'] = $this->language->get('entry_logo_height');

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
		if (isset($this->error['logo_width'])) {
			$data['error_logo_width'] = $this->error['logo_width'];
		} else {
			$data['error_logo_width'] = '';
		}

		if (isset($this->error['logo_height'])) {
			$data['error_logo_height'] = $this->error['logo_height'];
		} else {
			$data['error_logo_height'] = '';
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
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/amp_product_pro', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/amp_product_pro', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		if (isset($this->request->post['amp_product_pro_enable_related'])) {
			$data['amp_product_pro_enable_related'] = $this->request->post['amp_product_pro_enable_related'];
		} else {
			$data['amp_product_pro_enable_related'] = $this->config->get('amp_product_pro_enable_related');
		}
		if (isset($this->request->post['amp_product_pro_enable_rating'])) {
			$data['amp_product_pro_enable_rating'] = $this->request->post['amp_product_pro_enable_rating'];
		} else {
			$data['amp_product_pro_enable_rating'] = $this->config->get('amp_product_pro_enable_rating');
		}
		if (isset($this->request->post['amp_product_pro_status'])) {
			$data['amp_product_pro_status'] = $this->request->post['amp_product_pro_status'];
		} else {
			$data['amp_product_pro_status'] = $this->config->get('amp_product_pro_status');
		}
		if (isset($this->request->post['amp_product_pro_enable_carousel'])) {
			$data['amp_product_pro_enable_carousel'] = $this->request->post['amp_product_pro_enable_carousel'];
		} else {
			$data['amp_product_pro_enable_carousel'] = $this->config->get('amp_product_pro_enable_carousel');
		}
		if (isset($this->request->post['amp_product_pro_enable_carousel_rel'])) {
			$data['amp_product_pro_enable_carousel_rel'] = $this->request->post['amp_product_pro_enable_carousel_rel'];
		} else {
			$data['amp_product_pro_enable_carousel_rel'] = $this->config->get('amp_product_pro_enable_carousel_rel');
		}
		if (isset($this->request->post['amp_product_pro_back_color'])) {
			$data['amp_product_pro_back_color'] = $this->request->post['amp_product_pro_back_color'];
		} elseif ($this->config->get('amp_product_pro_back_color')){
			$data['amp_product_pro_back_color'] = $this->config->get('amp_product_pro_back_color');
		}			
		else {
			$data['amp_product_pro_back_color'] = '#ffffff';
		}
		if (isset($this->request->post['amp_product_pro_link_color'])) {
			$data['amp_product_pro_link_color'] = $this->request->post['amp_product_pro_link_color'];
		} elseif ($this->config->get('amp_product_pro_link_color')){
			$data['amp_product_pro_link_color'] = $this->config->get('amp_product_pro_link_color');
		}			
		else {
			$data['amp_product_pro_link_color'] = '#00e';
		}
		if (isset($this->request->post['amp_product_pro_cart_color'])) {
			$data['amp_product_pro_cart_color'] = $this->request->post['amp_product_pro_cart_color'];
		} elseif ($this->config->get('amp_product_pro_cart_color')){
			$data['amp_product_pro_cart_color'] = $this->config->get('amp_product_pro_cart_color');
		} else {
			$data['amp_product_pro_cart_color'] = '#da4f49';
		}
		if (isset($this->request->post['amp_product_pro_search_color'])) {
			$data['amp_product_pro_search_color'] = $this->request->post['amp_product_pro_search_color'];
		} elseif ($this->config->get('amp_product_pro_search_color')){
			$data['amp_product_pro_search_color'] = $this->config->get('amp_product_pro_search_color');
		}			
		else {
			$data['amp_product_pro_search_color'] = '#da4f49';
		}
		if (isset($this->request->post['amp_product_pro_image_height'])) {
			$data['amp_product_pro_image_height'] = $this->request->post['amp_product_pro_image_height'];
		} elseif ($this->config->get('amp_product_pro_image_height')){
			$data['amp_product_pro_image_height'] = $this->config->get('amp_product_pro_image_height');
		}			
		else {
			$data['amp_product_pro_image_height'] = '500';
		}
		if (isset($this->request->post['amp_product_pro_image_width'])) {
			$data['amp_product_pro_image_width'] = $this->request->post['amp_product_pro_image_width'];
		} elseif ($this->config->get('amp_product_pro_image_width')){
			$data['amp_product_pro_image_width'] = $this->config->get('amp_product_pro_image_width');
		}			
		else {
			$data['amp_product_pro_image_width'] = '500';
		}
		if (isset($this->request->post['amp_product_pro_logo_height'])) {
			$data['amp_product_pro_logo_height'] = $this->request->post['amp_product_pro_logo_height'];
		} elseif ($this->config->get('amp_product_pro_logo_height')){
			$data['amp_product_pro_logo_height'] = $this->config->get('amp_product_pro_logo_height');
		}			
		else {
			$data['amp_product_pro_logo_height'] = '42';
		}
		if (isset($this->request->post['amp_product_pro_logo_width'])) {
			$data['amp_product_pro_logo_width'] = $this->request->post['amp_product_pro_logo_width'];
		} elseif ($this->config->get('amp_product_pro_logo_width')){
			$data['amp_product_pro_logo_width'] = $this->config->get('amp_product_pro_logo_width');
		}			
		else {
			$data['amp_product_pro_logo_width'] = '228';
		}
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/amp_product_pro', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/amp_product_pro')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->request->post['amp_product_pro_image_width']) {
			$this->error['width'] = $this->language->get('error_width');
		}

		if (!$this->request->post['amp_product_pro_image_height']) {
			$this->error['height'] = $this->language->get('error_height');
		}
		if (!$this->request->post['amp_product_pro_logo_width']) {
			$this->error['logo_width'] = $this->language->get('error_logo_width');
		}

		if (!$this->request->post['amp_product_pro_logo_height']) {
			$this->error['logo_height'] = $this->language->get('error_logo_height');
		}
		return !$this->error;
	}
}