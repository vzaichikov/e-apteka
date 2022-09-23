<?php
class ControllerExtensionModuleSuperproducts extends Controller {
	private $error = array();

	public function index() {
		$this->load->model('extension/module');

		$data['button_save'] = $this->language->get('button_save');
		
		$data += $this->load->language('extension/module/superproducts');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['deleteOldVersion']) && $this->validatesetting()) {
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
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('superproducts', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}

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

		if (is_file(DIR_APPLICATION . 'controller/module/superproducts.php')) {
			$data['error_warning']  = 'An old version of the module has been detected. In module list you should see this module twice twice. In order to solve the issue click the following button to delete the old version of the module and keep just the new one.';
			$data['error_warning'] .= '<a href="' . $this->url->link('extension/module/superproducts', 'deleteOldVersion=1&token=' . $this->session->data['token'], 'SSL') . '" class="btn btn-xs btn-danger">Delete Old Version</a>';
		}
		if (!$this->validatesetting()) {
			$data['error_warning']  = 'You do not have permissions to modify this module. Please navigate in admin to system > Users > User groups, edit the group your account is in and at Modify Permissions make sure to check extension/module/superproducts.';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'type=module&token=' . $this->session->data['token'], 'SSL')
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/superproducts', 'token=' . $this->session->data['token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/superproducts', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/superproducts', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('extension/module/superproducts', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}

		$data['cancel'] = $this->url->link('extension/extension', 'type=module&token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}

		$data['token'] = $this->session->data['token'];
		$data['s'] = ' selected="selected"';

		if (isset($this->request->post['fname'])) {
			$data['fname'] = $this->request->post['fname'];
		} elseif (!empty($module_info)) {
			$data['fname'] = $module_info['fname'];
		} else {
			$data['fname'] = array();
		}
		if (isset($this->request->post['category'])) {
			$data['category'] = $this->request->post['category'];
		} elseif (!empty($module_info)) {
			$data['category'] = isset($module_info['category']) ? $module_info['category'] : 0;
		} else {
			$data['category'] = 0;
		}
		if (isset($this->request->post['brand'])) {
			$data['brand'] = $this->request->post['brand'];
		} elseif (!empty($module_info)) {
			$data['brand'] = isset($module_info['brand']) ? $module_info['brand'] : 0;
		} else {
			$data['brand'] = 0;
		}
		if (isset($this->request->post['tag'])) {
			$data['tag'] = $this->request->post['tag'];
		} elseif (!empty($module_info)) {
			$data['tag'] = $module_info['tag'];
		} else {
			$data['tag'] = '';
		}
		if (isset($this->request->post['product_group'])) {
			$data['product_group'] = $this->request->post['product_group'];
		} elseif (!empty($module_info)) {
			$data['product_group'] = $module_info['product_group'];
		} else {
			$data['product_group'] = '';
		}
		if (isset($this->request->post['product_group_b'])) {
			$data['product_group_b'] = $this->request->post['product_group_b'];
		} elseif (!empty($module_info)) {
			$data['product_group_b'] = $module_info['product_group_b'];
		} else {
			$data['product_group_b'] = '';
		}
		if (isset($this->request->post['active_cat'])) {
			$data['active_cat'] = $this->request->post['active_cat'];
		} elseif (!empty($module_info)) {
			$data['active_cat'] = $module_info['active_cat'];
		} else {
			$data['active_cat'] = 0;
		}
		if (isset($this->request->post['active_brand'])) {
			$data['active_brand'] = $this->request->post['active_brand'];
		} elseif (!empty($module_info)) {
			$data['active_brand'] = $module_info['active_brand'];
		} else {
			$data['active_brand'] = 0;
		}
		if (isset($this->request->post['viewall_link_c'])) {
			$data['viewall_link_c'] = $this->request->post['viewall_link_c'];
		} elseif (!empty($module_info) && isset($module_info['viewall_link_c'])) {
			$data['viewall_link_c'] = $module_info['viewall_link_c'];
		} else {
			$data['viewall_link_c'] = 0;
		}
		if (isset($this->request->post['viewall_link_m'])) {
			$data['viewall_link_m'] = $this->request->post['viewall_link_m'];
		} elseif (!empty($module_info) && isset($module_info['viewall_link_m'])) {
			$data['viewall_link_m'] = $module_info['viewall_link_m'];
		} else {
			$data['viewall_link_m'] = 0;
		}
		if (isset($this->request->post['viewall_link_t'])) {
			$data['viewall_link_t'] = $this->request->post['viewall_link_t'];
		} elseif (!empty($module_info) && isset($module_info['viewall_link_t'])) {
			$data['viewall_link_t'] = $module_info['viewall_link_t'];
		} else {
			$data['viewall_link_t'] = 0;
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info)) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = 5;
		}

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($module_info)) {
			$data['width'] = $module_info['width'];
		} else {
			$data['width'] = 200;
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($module_info)) {
			$data['height'] = $module_info['height'];
		} else {
			$data['height'] = 200;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		if (isset($this->request->post['module_type'])) {
			$data['module_type'] = $this->request->post['module_type'];
		} elseif (!empty($module_info)) {
			$data['module_type'] = $module_info['module_type'];
		} else {
			$data['module_type'] = 0;
		}

		$data['supertabs'] = array();

		if (isset($this->request->post['supertabs'])) {
			$supertabs = $this->request->post['supertabs'];
		} elseif (!empty($module_info) && isset($module_info['supertabs'])) {
			$supertabs = $module_info['supertabs'];
		} else {
			$supertabs = array();
		}
		foreach ($supertabs as $tab) {
			$data['supertabs'][] = array(
				'fname' => isset($tab['fname']) ? $tab['fname'] : array(),
				'product_group' => isset($tab['product_group']) ? $tab['product_group'] : '',
				'product_group_b' => isset($tab['product_group_b']) ? $tab['product_group_b'] : '',
				'category' => isset($tab['category']) ? $tab['category'] : '',
				'active_cat' => isset($tab['active_cat']) ? $tab['active_cat'] : 0,
				'viewall_link_c' => isset($tab['viewall_link_c']) ? $tab['viewall_link_c'] : 0,
				'brand' => isset($tab['brand']) ? $tab['brand'] : '',
				'active_brand' => isset($tab['active_brand']) ? $tab['active_brand'] : 0,
				'viewall_link_m' => isset($tab['viewall_link_m']) ? $tab['viewall_link_m'] : 0,
				'tag' => isset($tab['tag']) ? $tab['tag'] : '',
				'viewall_link_t' => isset($tab['viewall_link_t']) ? $tab['viewall_link_t'] : 0,
				'order' => isset($tab['order']) ? $tab['order'] : 0
			);
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

	  	
		$this->load->model('catalog/category');
		$filter_data = array(
			'sort'  => 'name',
			'order' => 'ASC'
		);
		$data['categories'] = $this->model_catalog_category->getCategories($filter_data);
		$this->load->model('catalog/manufacturer');
		$data['brands'] = $this->model_catalog_manufacturer->getManufacturers();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/superproducts', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/superproducts')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!$this->request->post['width']) {
			$this->error['width'] = $this->language->get('error_width');
		}

		if (!$this->request->post['height']) {
			$this->error['height'] = $this->language->get('error_height');
		}

		return !$this->error;
	}

	protected function validatesetting() {
		if (!$this->user->hasPermission('modify', 'extension/module/superproducts')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}