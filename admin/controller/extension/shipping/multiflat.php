<?php
class ControllerExtensionShippingMultiflat extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/shipping/multiflat');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('multiflat', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_multiflat_sort_order'] = $this->language->get('text_multiflat_sort_order');
		$data['text_multiflat_name'] = $this->language->get('text_multiflat_name');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_min'] = $this->language->get('entry_min');
		$data['entry_max'] = $this->language->get('entry_max');
		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_remove'] = $this->language->get('button_remove');

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
            'text' => $this->language->get('text_shipping'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true)
   		);

   		$data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/shipping/multiflat', 'token=' . $this->session->data['token'], true)
        );

		$data['action'] = $this->url->link('extension/shipping/multiflat', 'token=' . $this->session->data['token'], true);
		
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true);

		$data['modules'] = array();

		if (isset($this->request->post['multiflat'])) {
			$data['modules'] = $this->request->post['multiflat'];
		} elseif ($this->config->get('multiflat')) {
			$data['modules'] = $this->config->get('multiflat');
		}

		$data['multiflat_sort_order'] = '';

		if (isset($this->request->post['multiflat_sort_order'])) {
			$data['multiflat_sort_order'] = $this->request->post['multiflat_sort_order'];
		} elseif ($this->config->get('multiflat_sort_order')) {
			$data['multiflat_sort_order'] = $this->config->get('multiflat_sort_order');
		}

		$data['multiflat_name'] = '';

		if (isset($this->request->post['multiflat_name'])) {
			$data['multiflat_name'] = $this->request->post['multiflat_name'];
		} elseif ($this->config->get('multiflat_name')) {
			$data['multiflat_name'] = $this->config->get('multiflat_name');
		}

		$this->load->model('catalog/category');

		$data['categories'] = $this->model_catalog_category->getCategories();

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/multiflat', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/shipping/multiflat')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}