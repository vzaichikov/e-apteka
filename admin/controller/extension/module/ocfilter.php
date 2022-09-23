<?php
class ControllerExtensionModuleOCFilter extends Controller {
	private $error = array();

	public function index() {
    // Set language data
		$data = $this->load->language('extension/module/ocfilter');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
      $ocfilter_data = array();

      foreach ($this->request->post as $key => $value) {
      	$ocfilter_data['ocfilter_' . $key] = $value;
      }

      $this->model_setting_setting->editSetting('ocfilter', $ocfilter_data);

      $this->cache->delete('ocfilter');

			$this->session->data['success'] = $this->language->get('text_success');

      if (isset($this->request->get['apply'])) {
			  $this->response->redirect($this->url->link('extension/module/ocfilter', 'token=' . $this->session->data['token'], true));
      } else {
        $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], true));
      }
		}

		$this->document->setTitle($this->language->get('heading_title'));

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
			'href' => $this->url->link('extension/module/ocfilter', 'token=' . $this->session->data['token'], true)
		);

		$data['save'] = $this->url->link('extension/module/ocfilter', 'token=' . $this->session->data['token'], true);
    $data['apply'] = $this->url->link('extension/module/ocfilter', 'token=' . $this->session->data['token'] . '&apply', true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true);

    $data['filter_list'] = $this->url->link('catalog/ocfilter', 'token=' . $this->session->data['token'], true);
    $data['filter_page_list'] = $this->url->link('catalog/ocfilter_page', 'token=' . $this->session->data['token'], true);

    $data['token'] = $this->session->data['token'];

		$data['status'] = $this->getData('status');
    $data['sub_category'] = $this->getData('sub_category');
    $data['sitemap_status'] = $this->getData('sitemap_status', 1);

    $data['sitemap_link'] = HTTP_CATALOG . 'index.php?route=extension/feed/ocfilter_sitemap';

    $data['search_button'] = $this->getData('search_button', 1);
    $data['show_selected'] = $this->getData('show_selected', 1);
    $data['show_price'] = $this->getData('show_price', 1);
    $data['show_counter'] = $this->getData('show_counter', 1);
    $data['manufacturer'] = $this->getData('manufacturer', 1);
    $data['manufacturer_type'] = $this->getData('manufacturer_type', 'checkbox');
    $data['stock_status'] = $this->getData('stock_status');
    $data['stock_status_type'] = $this->getData('stock_status_type', 'checkbox');
    $data['stock_status_method'] = $this->getData('stock_status_method', 'quantity');
    $data['stock_out_value'] = $this->getData('stock_out_value');
    $data['manual_price'] = $this->getData('manual_price');
    $data['consider_discount'] = $this->getData('consider_discount');
    $data['consider_special'] = $this->getData('consider_special');
    $data['consider_option'] = $this->getData('consider_option');
    $data['show_options_limit'] = $this->getData('show_options_limit');
    $data['show_values_limit'] = $this->getData('show_values_limit');
    $data['hide_empty_values'] = $this->getData('hide_empty_values', 1);

    $data['copy_attribute_separator'] = $this->getData('copy_attribute_separator', '');
    $data['copy_type'] = $this->getData('copy_type', 'checkbox');
    $data['copy_status'] = $this->getData('copy_status', -1);
    $data['copy_attribute'] = $this->getData('copy_attribute', 1);
    $data['copy_filter'] = $this->getData('copy_filter');
    $data['copy_option'] = $this->getData('copy_option');

    $data['types'] = array(
      'checkbox',
      'radio'
    );

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

    $this->response->setOutput($this->load->view('extension/module/ocfilter', $data));
	}

  protected function getData($key, $default = 0) {
		if (isset($this->request->post[$key])) {
			return $this->request->post[$key];
    } else if ($this->config->has('ocfilter_' . $key)) {
			return $this->config->get('ocfilter_' . $key);
		} else {
			return $default;
		}
  }

  public function copyFilters() {
    $json = array();

    $this->load->language('extension/module/ocfilter');

    if ($this->request->server['REQUEST_METHOD'] == 'POST') {
      $this->load->model('catalog/ocfilter');

      $this->model_catalog_ocfilter->copyFilters($this->request->post);

      $json['success'] = $this->language->get('text_complete');
    }

		$this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/ocfilter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}