<?php
class ControllerExtensionModulesuperproductsadmin extends Controller {
	private $error = array();

	public function index() {

		$data['button_save'] = $this->language->get('button_save');
		
		$data += $this->load->language('extension/module/superproductsadmin');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (isset($this->request->get['deleteOldVersion']) && $this->validate()) {
			@unlink(DIR_APPLICATION . 'controller/module/superproducts.php');
			@unlink(DIR_APPLICATION . 'controller/module/superproductsadmin.php');
			@unlink(DIR_APPLICATION . 'language/english/module/superproducts.php');
			@unlink(DIR_APPLICATION . 'language/english/module/superproductsadmin.php');
			@unlink(DIR_APPLICATION . 'language/ru-ru/module/superproducts.php');
			@unlink(DIR_APPLICATION . 'language/ru-ru/module/superproductsadmin.php');
			@unlink(DIR_APPLICATION . 'view/template/module/superproducts.tpl');
			@unlink(DIR_APPLICATION . 'view/template/module/superproductsadmin.tpl');
			@unlink(DIR_CATALOG . 'controller/module/superproducts.php');
			$this->session->data['success'] = 'You succesfully deleted the old version of superproducts!';
			$this->response->redirect($this->url->link('extension/module/superproducts', 'token=' . $this->session->data['token'], 'SSL'));
		} elseif (isset($this->request->get['deleteOldVersion'])) {
			$this->response->redirect($this->url->link('extension/module/superproducts', 'nopermissiontodelete=1&token=' . $this->session->data['token'], 'SSL'));
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting('superproductsadmin', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->cache->delete('superproducts');

			$this->response->redirect($this->url->link('extension/extension', 'type=module&token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (is_file(DIR_APPLICATION . 'controller/module/superproductsadmin.php')) {
			$data['error_warning']  = 'An old version of the module has been detected. In module list you should see this module twice twice. In order to solve the issue click the following button to delete the old version of the module and keep just the new one.';
			$data['error_warning'] .= '<a href="' . $this->url->link('extension/module/superproductsadmin', 'deleteOldVersion=1&token=' . $this->session->data['token'], 'SSL') . '" class="btn btn-xs btn-danger">Delete Old Version</a>';
		}
		if (!$this->validate()) {
			$data['error_warning']  = 'You do not have permissions to modify this module. Please navigate in admin to system > Users > User groups, edit the group your account is in and at Modify Permissions make sure to check extension/module/superproductsadmin.';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'type=module&token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/superproductsadmin', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['action'] = $this->url->link('extension/module/superproductsadmin', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/extension', 'type=module&token=' . $this->session->data['token'], 'SSL');

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['superproductsadmin_singlemod_tpl'])) {
			$data['superproductsadmin_singlemod_tpl'] = $this->request->post['superproductsadmin_singlemod_tpl'];
		} elseif ($this->config->get('superproductsadmin_singlemod_tpl')) {
			$data['superproductsadmin_singlemod_tpl'] = $this->config->get('superproductsadmin_singlemod_tpl');
		} else {
			$data['superproductsadmin_singlemod_tpl'] = 'superproducts.tpl';
		}

		if (isset($this->request->post['superproductsadmin_tabsmodmod_tpl'])) {
			$data['superproductsadmin_tabsmodmod_tpl'] = $this->request->post['superproductsadmin_tabsmodmod_tpl'];
		} elseif ($this->config->get('superproductsadmin_tabsmodmod_tpl')) {
			$data['superproductsadmin_tabsmodmod_tpl'] = $this->config->get('superproductsadmin_tabsmodmod_tpl');
		} else {
			$data['superproductsadmin_tabsmodmod_tpl'] = 'superproducts.tpl';
		}

		if (isset($this->request->post['superproductsadmin_langvars'])) {
			$data['superproductsadmin_langvars'] = $this->request->post['superproductsadmin_langvars'];
		} elseif ($this->config->get('superproductsadmin_langvars')) {
			$data['superproductsadmin_langvars'] = $this->config->get('superproductsadmin_langvars');
		} else {
			$data['superproductsadmin_langvars'] = array();
		}

		if (isset($this->request->post['superproductsadmin_viewlink_pos'])) {
			$data['superproductsadmin_viewlink_pos'] = $this->request->post['superproductsadmin_viewlink_pos'];
		} elseif ($this->config->get('superproductsadmin_viewlink_pos')) {
			$data['superproductsadmin_viewlink_pos'] = $this->config->get('superproductsadmin_viewlink_pos');
		} else {
			$data['superproductsadmin_viewlink_pos'] = 0;
		}
		if (isset($this->request->post['superproductsadmin_title_regex'])) {
			$data['superproductsadmin_title_regex'] = $this->request->post['superproductsadmin_title_regex'];
		} elseif ($this->config->get('superproductsadmin_title_regex')) {
			$data['superproductsadmin_title_regex'] = $this->config->get('superproductsadmin_title_regex');
		} else {
			$data['superproductsadmin_title_regex'] = '/<h3>(.*?)<\/h3>/';
		}
		if (isset($this->request->post['superproductsadmin_enable_cache'])) {
			$data['superproductsadmin_enable_cache'] = $this->request->post['superproductsadmin_enable_cache'];
		} elseif ($this->config->get('superproductsadmin_enable_cache')) {
			$data['superproductsadmin_enable_cache'] = $this->config->get('superproductsadmin_enable_cache');
		} else {
			$data['superproductsadmin_enable_cache'] = 0;
		}
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
	  		$languages = $data['languages'];
	  		$data['languages'] = array();
	  		foreach ($languages as $language) {
	  			$data['languages'][] = array(
	  				'name' => $language['name'],
	  				'language_id' => $language['language_id'],
	  				'image' => "../../../language/$language[code]/$language[code].png",
	  				'code' => $language['code']
	  				);
	  		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/superproductsadmin', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/superproductsadmin')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
}