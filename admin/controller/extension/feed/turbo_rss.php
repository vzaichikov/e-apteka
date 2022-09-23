<?php

class ControllerExtensionFeedTurboRSS extends Controller {

    private $error = array();

    public function index() {

	$this->load->language('extension/feed/turbo_rss');
	$this->load->model('catalog/product');
	$this->load->model('setting/setting');

	if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
	    $this->load->model('setting/setting');
	    $this->model_setting_setting->editSetting('turbo_rss', $this->request->post);
	    $this->session->data['success'] = $this->language->get('text_success');
	    $this->response->redirect($this->url->link('extension/feed/turbo_rss', 'token=' . $this->session->data['token'], true));
	}

	if (isset($this->error['warning'])) {
		$data['error_warning'] = $this->error['warning'];
	} else {
		$data['error_warning'] = '';
	}

	$this->document->setTitle($this->language->get('heading_title'));

	$data['heading_title'] = $this->language->get('heading_title');
	$data['button_save'] = $this->language->get('button_save');
	$data['button_cancel'] = $this->language->get('button_cancel');
	$data['text_enabled'] = $this->language->get('text_enabled');
	$data['text_disabled'] = $this->language->get('text_disabled');

	$data['entry_status'] = $this->language->get('entry_status');
	$data['entry_data_feed'] = $this->language->get('entry_data_feed');
	$data['entry_limit'] = $this->language->get('entry_limit');
	$data['entry_show_image'] = $this->language->get('entry_show_image');
	$data['entry_show_price'] = $this->language->get('entry_show_price');
	$data['entry_include_tax'] = $this->language->get('entry_include_tax');

	$data['entry_image_size'] = $this->language->get('entry_image_size');
	
	$data['action'] = $this->url->link('extension/feed/turbo_rss', 'token=' . $this->session->data['token'], true);
	$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'].'&type=feed', true);

	if (isset($this->request->post['turbo_rss_status'])) {
	    $data['turbo_rss_status'] = $this->request->post['turbo_rss_status'];
	} else {
	    $data['turbo_rss_status'] = $this->config->get('turbo_rss_status');
	}

	if (isset($this->request->post['turbo_rss_limit'])) {
	    $data['turbo_rss_limit'] = $this->request->post['turbo_rss_limit'];
	} elseif ($this->config->get('turbo_rss_limit')) {
	    $data['turbo_rss_limit'] = $this->config->get('turbo_rss_limit');
	} else {
		$data['turbo_rss_limit'] = 500;
	}

	$total =  $this->model_catalog_product->getTotalProducts();
	$limit = $data['turbo_rss_limit'];
	$parts = ceil($total / $limit) - 1;

	$data['data_feed'] = array();
	$data['data_feed'][0] = HTTP_CATALOG . 'index.php?route=extension/feed/turbo_rss&part=0';
	for ($i = 1; $i <= $parts; $i++) {
	    $data['data_feed'][$i] = HTTP_CATALOG . 'index.php?route=extension/feed/turbo_rss&part='.$i;
	}

	if (isset($this->request->post['turbo_rss_show_image'])) {
	    $data['turbo_rss_show_image'] = $this->request->post['turbo_rss_show_image'];
	} else {
	    $data['turbo_rss_show_image'] = $this->config->get('turbo_rss_show_image');
	}

	if (isset($this->request->post['turbo_rss_show_price'])) {
	    $data['turbo_rss_show_price'] = $this->request->post['turbo_rss_show_price'];
	} else {
	    $data['turbo_rss_show_price'] = $this->config->get('turbo_rss_show_price');
	}

	if (isset($this->request->post['turbo_rss_include_tax'])) {
	    $data['turbo_rss_include_tax'] = $this->request->post['turbo_rss_include_tax'];
	} else {
	    $data['turbo_rss_include_tax'] = $this->config->get('turbo_rss_include_tax');
	}

	if (isset($this->request->post['turbo_rss_image_width'])) {
	    $data['turbo_rss_image_width'] = $this->request->post['turbo_rss_image_width'];
	} else {
	    $data['turbo_rss_image_width'] = $this->config->get('turbo_rss_image_width') ? $this->config->get('turbo_rss_image_width') : 100;
	}

	if (isset($this->request->post['turbo_rss_image_height'])) {
	    $data['turbo_rss_image_height'] = $this->request->post['turbo_rss_image_height'];
	} else {
	    $data['turbo_rss_image_height'] = $this->config->get('turbo_rss_image_height') ? $this->config->get('turbo_rss_image_height') : 100;
	}

	if (isset($this->error['limit'])) {
	    $data['error_limit'] = $this->error['limit'];
	} else {
	    $data['error_limit'] = '';
	}

	if (isset($this->error['image_dimensions'])) {
	    $data['error_image_dimensions'] = $this->error['image_dimensions'];
	} else {
	    $data['error_image_dimensions'] = '';
	}

	$data['breadcrumbs'] = array();

	$data['breadcrumbs'][] = array(
		'text'      => $this->language->get('text_home'),
		'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
		'separator' => false
	);

	$data['breadcrumbs'][] = array(
		'text'      => $this->language->get('text_feed'),
		'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'].'&type=feed', true),
		'separator' => ' :: '
	);

	$data['breadcrumbs'][] = array(
		'text'      => $this->language->get('heading_title'),
		'href'      => $this->url->link('extension/feed/turbo_rss', 'token=' . $this->session->data['token'], true),
		'separator' => ' :: '
	);

	$data['header'] = $this->load->controller('common/header');
	$data['column_left'] = $this->load->controller('common/column_left');
	$data['footer'] = $this->load->controller('common/footer');
	$this->response->setOutput($this->load->view('extension/feed/turbo_rss', $data));
    }

    private function validate() {
	
	if ((!$this->request->post['turbo_rss_limit']) || (!is_numeric($this->request->post['turbo_rss_limit']))) {
	    $this->error['limit'] = $this->language->get('error_integer');
	}

	if ((!$this->request->post['turbo_rss_image_width']) || (!is_numeric($this->request->post['turbo_rss_image_width'])) || (!$this->request->post['turbo_rss_image_height']) || (!is_numeric($this->request->post['turbo_rss_image_height']))) {
	    $this->error['image_dimensions'] = $this->language->get('error_integer');
	}

	if (!$this->error) {
	    return TRUE;
	} else {
	    return FALSE;
	}

	return TRUE;
    }

}