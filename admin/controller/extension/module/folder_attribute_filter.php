<?php
class ControllerExtensionModuleFolderAttributeFilter extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/folder_attribute_filter');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            
            $this->model_setting_setting->editSetting('folder_attribute_filter', $this->request->post);

            $r = $this->db->query("SELECT * FROM `" . DB_PREFIX . "module` WHERE `code` = 'folder_attribute_filter'");
            
            if($r->num_rows == 0){
                
                $data = array('name' => 'Folder attribute filter',
                              'status' => '1'
                              );
                
                $this->db->query("INSERT INTO `" . DB_PREFIX . "module` SET `name` = 'Folder attribute filter',
						 `code` = 'folder_attribute_filter',
						 `setting` = '" . $this->db->escape(json_encode($data)) . "'");
            }
        	
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

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
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/folder_attribute_filter', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/folder_attribute_filter', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		if (isset($this->request->post['folder_attribute_filter'])) {
			$data['folder_attribute_filter'] = $this->request->post['folder_attribute_filter'];
		} else {
			$data['folder_attribute_filter'] = $this->config->get('folder_attribute_filter');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/folder_attribute_filter', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/folder_attribute_filter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}