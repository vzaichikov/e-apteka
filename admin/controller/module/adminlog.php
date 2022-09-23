<?php
class ControllerModuleAdminLog extends Controller {
	private $error = array();

	public function install(){
		$this->load->model('module/adminlog');

	}

	public function uninstall(){
		$this->load->model('module/adminlog');
		$this->model_module_adminlog->uninstall();
	}

	public function index() {
		$this->load->language('module/adminlog');
		$this->load->model('module/adminlog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if(!empty($this->request->post['clear'])){
				if (isset($this->request->post['selected'])) {
					foreach ($this->request->post['selected'] as $entry) {
						$this->model_module_adminlog->deleteEntry($entry);
	  				}
	  				$this->model_module_adminlog->deleteEntryLog($this->user->getId(), $this->user->getUserName(), count($this->request->post['selected']));
	  			}else{
					$this->model_module_adminlog->clearDataBaseLog($this->user->getId(), $this->user->getUserName());
				}
			}else{
				$this->model_setting_setting->editSetting('adminlog', $this->request->post);
            }
			$this->session->data['success'] = $this->language->get('text_success');

			if( !empty($this->request->post['stay']) ){
				$this->redirect($this->url->link('module/adminlog', 'token=' . $this->session->data['token'], 'SSL'));
			}else{
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		if(isset($this->session->data['success'])){
			$data['success'] =  $this->session->data['success'];
			unset($this->session->data['success']);
		}
		$data['heading_title'] = $this->language->get('heading_title');

		$data['tab_log'] = $this->language->get('tab_log');
		$data['tab_settings'] = $this->language->get('tab_settings');
		$data['tab_help'] = $this->language->get('tab_help');

		$data['text_description'] = $this->language->get('text_description');
		$data['text_help'] = $this->language->get('text_help');

		$data['button_save_go'] = $this->language->get('button_save_go');
		$data['button_save_stay'] = $this->language->get('button_save_stay');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['text_no_results'] = $this->language->get('text_no_results');


		// DataBase Log Tab
		$this->document->addStyle('view/stylesheet/adminlog.css');
		$data['button_clear_go'] = $this->language->get('button_clear_go');
		$data['button_clear_stay'] = $this->language->get('button_clear_stay');

		$data['column_user'] = $this->language->get('column_user');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_allowed'] = $this->language->get('column_allowed');
		$data['column_url'] = $this->language->get('column_url');
		$data['column_ip'] = $this->language->get('column_ip');
		$data['column_date'] = $this->language->get('column_date');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['entries'] = array();

		$filter = array(
			'start'           => ($page - 1) * $this->config->get('adminlog_display'),
			'limit'           => $this->config->get('adminlog_display')
		);

		$entries_total = $this->model_module_adminlog->getTotalDataBaseLog($filter);
  		$entries = $this->model_module_adminlog->getDataBaseLog($filter);

		foreach ($entries as $entry) {
			$entryUrl = preg_replace("/&token=[a-z0-9]+/", "", htmlspecialchars_decode($entry['url']));

      		$data['entries'][] = array(
      			'log_id'	=> $entry['log_id'],
      			'user'		=> $this->url->link('user/user/update', 'token=' . $this->session->data['token'] . '&user_id=' . $entry['user_id'], 'SSL'),
      			'user_name'	=> $entry['user_name'],
				'action'	=> $entry['action'],
				'allowed'	=> $entry['allowed'],
				'url_link'	=> $entryUrl.'&token=' . $this->session->data['token'],
				'url'		=> $entryUrl,
				'ip'		=> $entry['ip'],
				'date'		=> $entry['date'],
			);
    	}

		$pagination = new Pagination();
		$pagination->total = $entries_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('adminlog_display');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/adminlog', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();


		// Settings tab
		$data['entry_adminlog_enable'] = $this->language->get('entry_adminlog_enable');
		$data['entry_adminlog_login'] = $this->language->get('entry_adminlog_login');
		$data['entry_adminlog_logout'] = $this->language->get('entry_adminlog_logout');
		$data['entry_adminlog_hacklog'] = $this->language->get('entry_adminlog_hacklog');
		$data['entry_adminlog_access'] = $this->language->get('entry_adminlog_access');
		$data['entry_adminlog_modify'] = $this->language->get('entry_adminlog_modify');
		$data['entry_adminlog_allowed'] = $this->language->get('entry_adminlog_allowed');
		$data['entry_adminlog_display'] = $this->language->get('entry_adminlog_display');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['text_denied'] = $this->language->get('text_denied');
		$data['text_allowed'] = $this->language->get('text_allowed');
		$data['text_all'] = $this->language->get('text_all');

		// Variables
		if (isset($this->request->post['adminlog_enable'])) {
			$data['adminlog_enable'] = $this->request->post['adminlog_enable'];
		} elseif ($this->config->get('adminlog_enable')) {
			$data['adminlog_enable'] = $this->config->get('adminlog_enable');
		} else {
			$data['adminlog_enable'] = 0;
		}

		if (isset($this->request->post['adminlog_login'])) {
			$data['adminlog_login'] = $this->request->post['adminlog_login'];
		} elseif ($this->config->get('adminlog_login')) {
			$data['adminlog_login'] = $this->config->get('adminlog_login');
		} else {
			$data['adminlog_login'] = 0;
		}

		if (isset($this->request->post['adminlog_logout'])) {
			$data['adminlog_logout'] = $this->request->post['adminlog_logout'];
		} elseif ($this->config->get('adminlog_logout')) {
			$data['adminlog_logout'] = $this->config->get('adminlog_logout');
		} else {
			$data['adminlog_logout'] = 0;
		}

		if (isset($this->request->post['adminlog_hacklog'])) {
			$data['adminlog_hacklog'] = $this->request->post['adminlog_hacklog'];
		} elseif ($this->config->get('adminlog_hacklog')) {
			$data['adminlog_hacklog'] = $this->config->get('adminlog_hacklog');
		} else {
			$data['adminlog_hacklog'] = 0;
		}

		if (isset($this->request->post['adminlog_access'])) {
			$data['adminlog_access'] = $this->request->post['adminlog_access'];
		} elseif ($this->config->get('adminlog_access')) {
			$data['adminlog_access'] = $this->config->get('adminlog_access');
		} else {
			$data['adminlog_access'] = 0;
		}

		if (isset($this->request->post['adminlog_modify'])) {
			$data['adminlog_modify'] = $this->request->post['adminlog_modify'];
		} elseif ($this->config->get('adminlog_modify')) {
			$data['adminlog_modify'] = $this->config->get('adminlog_modify');
		} else {
			$data['adminlog_modify'] = 0;
		}

		if (isset($this->request->post['adminlog_allowed'])) {
			$data['adminlog_allowed'] = $this->request->post['adminlog_allowed'];
		} elseif ($this->config->get('adminlog_allowed')) {
			$data['adminlog_allowed'] = $this->config->get('adminlog_allowed');
		} else {
			$data['adminlog_allowed'] = 2;
		}

		if (isset($this->request->post['adminlog_display'])) {
			$data['adminlog_display'] = $this->request->post['adminlog_display'];
		} elseif ($this->config->get('adminlog_display')) {
			$data['adminlog_display'] = $this->config->get('adminlog_display');
		} else {
			$data['adminlog_display'] = 50;
		}


		//============================================

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/adminlog', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$data['action'] = $this->url->link('module/adminlog', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('module/adminlog.tpl', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/adminlog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>