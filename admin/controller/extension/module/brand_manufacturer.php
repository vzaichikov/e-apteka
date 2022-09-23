<?php
class ControllerExtensionModuleBrandManufacturer extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/brand_manufacturer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');


		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('brand_manufacturer', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_all_manufacturer'] = $this->language->get('text_all_manufacturer');
		$data['text_selected_manufacturer'] = $this->language->get('text_selected_manufacturer');
		$data['text_type1'] = $this->language->get('text_type1');
		$data['text_type2'] = $this->language->get('text_type2');
		$data['text_type3'] = $this->language->get('text_type3');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_thumb_width'] = $this->language->get('entry_thumb_width');
		$data['entry_thumb_height'] = $this->language->get('entry_thumb_height');
		$data['entry_thumb_size'] = $this->language->get('entry_thumb_size');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_auto_play'] = $this->language->get('entry_auto_play');
		$data['entry_pause_on_hover'] = $this->language->get('entry_pause_on_hover');
		$data['entry_show_pagination'] = $this->language->get('entry_show_pagination');
		$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$data['entry_type'] = $this->language->get('entry_type');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

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

		if (isset($this->error['thumb_width'])) {
			$data['error_thumb_width'] = $this->error['thumb_width'];
		} else {
			$data['error_thumb_width'] = '';
		}
		
		if (isset($this->error['thumb_height'])) {
			$data['error_thumb_height'] = $this->error['thumb_height'];
		} else {
			$data['error_thumb_height'] = '';
		}

		if (isset($this->error['quantity'])) {
			$data['error_quantity'] = $this->error['quantity'];
		} else {
			$data['error_quantity'] = '';
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
			'href' => $this->url->link('extension/module/brand_manufacturer', 'token=' . $this->session->data['token'], true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/brand_manufacturer', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/brand_manufacturer', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}

		$data['token'] = $this->session->data['token'];





		$this->load->model('catalog/manufacturer');

		if (isset($this->request->post['manufacturers'])) {
			$manufacturers = $this->request->post['manufacturers'];
		} elseif (!empty($module_info)&&isset($module_info['manufacturers'])) {
			$manufacturers = $module_info['manufacturers'];
		} else {
			$manufacturers = array();
		}

		$data['manufacturers'] = array();

		foreach ($manufacturers as $manufacturer_id) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);

			if ($manufacturer_info) {
				$data['manufacturers'][] = array(
					'manufacturer_id' => $manufacturer_info['manufacturer_id'],
					'name' => $manufacturer_info['name']
				);
			}
		}

		// thumb width		
		if (isset($this->request->post['thumb_width'])) {
			$data['thumb_width'] = $this->request->post['thumb_width'];
		} elseif (!empty($module_info)&&isset($module_info['thumb_width'])) {
			$data['thumb_width'] = $module_info['thumb_width'];
		} else {
			$data['thumb_width'] = 200;
		}
		
		// thumb height	
		if (isset($this->request->post['thumb_height'])) {
			$data['thumb_height'] = $this->request->post['thumb_height'];
		} elseif (!empty($module_info)&&isset($module_info['thumb_height'])) {
			$data['thumb_height'] = $module_info['thumb_height'];
		} else {
			$data['thumb_height'] = 200;
		}	

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['quantity'])) {
			$data['quantity'] = $this->request->post['quantity'];
		} elseif (!empty($module_info)&&isset($module_info['quantity'])) {
			$data['quantity'] = $module_info['quantity'];
		} else {
			$data['quantity'] = 4;
		}

		if (isset($this->request->post['all'])) {
			$data['all'] = $this->request->post['all'];
		} elseif (!empty($module_info)&&isset($module_info['all'])) {
			$data['all'] = $module_info['all'];
		} else {
			$data['all'] = 1;
		}

		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($module_info)&&isset($module_info['type'])) {
			$data['type'] = $module_info['type'];
		} else {
			$data['type'] = 1;
		}

		// auto play
		if (isset($this->request->post['auto_play'])) {
			$data['auto_play'] = $this->request->post['auto_play'];
		} elseif (!empty($module_info)&&isset($module_info['auto_play'])) {
			$data['auto_play'] = $module_info['auto_play'];
		} else {
			$data['auto_play'] = true;
		}	

		// pause on hover
		if (isset($this->request->post['pause_on_hover'])) {
			$data['pause_on_hover'] = $this->request->post['pause_on_hover'];
		} elseif (!empty($module_info)&&isset($module_info['pause_on_hover'])) {
			$data['pause_on_hover'] = $module_info['pause_on_hover'];
		} else {
			$data['pause_on_hover'] = true;
		}	

		// show pagination
		if (isset($this->request->post['show_pagination'])) {
			$data['show_pagination'] = $this->request->post['show_pagination'];
		} elseif (!empty($module_info)&&isset($module_info['show_pagination'])) {
			$data['show_pagination'] = $module_info['show_pagination'];
		} else {
			$data['show_pagination'] = true;
		}	

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/brand_manufacturer', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/brand_manufacturer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	protected function getManufacturersJson()
    {
        $output = array(
            'id' => 'manufacturer0',
            'text' => $this->language->get('entry_manufacturers'),
        );
        $this->load->model('catalog/manufacturer');
        $manufacturers = $this->model_catalog_manufacturer->getManufacturers();
        if (!empty($manufacturers)) {
            foreach ($manufacturers as $manufacturer) {
                $output['children'][] = array(
                    'id' => 'manufacturer' . $manufacturer['manufacturer_id'],
                    'text' => $manufacturer['name'],
                );
            }
        }
        return $output;
    }
}