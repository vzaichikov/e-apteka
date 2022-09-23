<?php
class ControllerExtensionModuleTltMultilang extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/tltmultilang');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('localisation/language');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('tltmultilang', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_summary'] = $this->language->get('text_summary');
		$data['text_large_image'] = $this->language->get('text_large_image');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_facebook_status'] = $this->language->get('entry_facebook_status');
		$data['entry_facebook_name'] = $this->language->get('entry_facebook_name');
		$data['entry_facebook_appid'] = $this->language->get('entry_facebook_appid');
		$data['entry_image'] = $this->language->get('entry_image');
		
		$data['entry_twitter_name'] = $this->language->get('entry_twitter_name');
		$data['entry_twitter_card'] = $this->language->get('entry_twitter_card');
		$data['entry_twitter_status'] = $this->language->get('entry_twitter_status');
		
		$data['placeholder_username'] = $this->language->get('placeholder_username');
		
		$data['help_twitter_status'] = $this->language->get('help_twitter_status');
		$data['help_facebook_status'] = $this->language->get('help_facebook_status');
		$data['help_image'] = $this->language->get('help_image');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (!property_exists('Document', 'tlt_metatags')) {
			$data['error_library'] = $this->language->get('error_library');
		} else {
			$data['error_library'] = '';
		}
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}

			if (isset($this->error['twitter_name'])) {
			$data['error_twitter_name'] = $this->error['twitter_name'];
		} else {
			$data['error_twitter_name'] = '';
		}

		if (isset($this->error['facebook_name'])) {
			$data['error_facebook_name'] = $this->error['facebook_name'];
		} else {
			$data['error_facebook_name'] = '';
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/tltmultilang', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/tltmultilang', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		$this->load->model('localisation/language');
		$results = $this->model_localisation_language->getLanguages();
		
		$data['tltmultilang_meta_title'] = array();
		$data['tltmultilang_meta_description'] = array();
		$data['tltmultilang_meta_keyword'] = array();
		$data['languages'] = array();
		
		foreach ($results as $result) {
			$data['languages'][] = array(
				'name'  => $result['name'],
				'code'  => $result['code'],
				'image' => $result['image']
			);
	
			if (isset($this->request->post['tltmultilang_meta_title_' . $result['code']])) {
				$data['tltmultilang_meta_title'][$result['code']] = $this->request->post['tltmultilang_meta_title_' . $result['code']];
			} else {
				$data['tltmultilang_meta_title'][$result['code']] = $this->config->get('tltmultilang_meta_title_' . $result['code']);
			}
	
			if (isset($this->request->post['tltmultilang_meta_description_' . $result['code']])) {
				$data['tltmultilang_meta_description'][$result['code']] = $this->request->post['tltmultilang_meta_description_' . $result['code']];
			} else {
				$data['tltmultilang_meta_description'][$result['code']] = $this->config->get('tltmultilang_meta_description_' . $result['code']);
			}
	
			if (isset($this->request->post['tltmultilang_meta_keyword_' . $result['code']])) {
				$data['tltmultilang_meta_keyword'][$result['code']] = $this->request->post['tltmultilang_meta_keyword_' . $result['code']];
			} else {
				$data['tltmultilang_meta_keyword'][$result['code']] = $this->config->get('tltmultilang_meta_keyword_' . $result['code']);
			}
		}

		if (isset($this->request->post['tltmultilang_twitter_status'])) {
			$data['tltmultilang_twitter_status'] = $this->request->post['tltmultilang_twitter_status'];
		} else {
			$data['tltmultilang_twitter_status'] = $this->config->get('tltmultilang_twitter_status');
		}
		
		if (isset($this->request->post['tltmultilang_twitter_card'])) {
			$data['tltmultilang_twitter_card'] = $this->request->post['tltmultilang_twitter_card'];
		} elseif ($this->config->has('tltmultilang_twitter_card')) {
			$data['tltmultilang_twitter_card'] = $this->config->get('tltmultilang_twitter_card');
		} else {
			$data['tltmultilang_twitter_card'] = 0;
		}
		
		if (isset($this->request->post['tltmultilang_twitter_name'])) {
			$data['tltmultilang_twitter_name'] = $this->request->post['tltmultilang_twitter_name'];
		} else {
			$data['tltmultilang_twitter_name'] = $this->config->get('tltmultilang_twitter_name');
		}
		
		if (isset($this->request->post['tltmultilang_facebook_status'])) {
			$data['tltmultilang_facebook_status'] = $this->request->post['tltmultilang_facebook_status'];
		} else {
			$data['tltmultilang_facebook_status'] = $this->config->get('tltmultilang_facebook_status');
		}
		
		if (isset($this->request->post['tltmultilang_facebook_name'])) {
			$data['tltmultilang_facebook_name'] = $this->request->post['tltmultilang_facebook_name'];
		} else {
			$data['tltmultilang_facebook_name'] = $this->config->get('tltmultilang_facebook_name');
		}
		
		if (isset($this->request->post['tltmultilang_facebook_appid'])) {
			$data['tltmultilang_facebook_appid'] = $this->request->post['tltmultilang_facebook_appid'];
		} else {
			$data['tltmultilang_facebook_appid'] = $this->config->get('tltmultilang_facebook_appid');
		}
		
		if (isset($this->request->post['tltmultilang_image'])) {
			$data['tltmultilang_image'] = $this->request->post['tltmultilang_image'];
		} elseif ($this->config->has('tltmultilang_image')) {
			$data['tltmultilang_image'] = $this->config->get('tltmultilang_image');
		} else {
			$data['tltmultilang_image'] = '';
		}
		
		$this->load->model('tool/image');
		
		if (isset($this->request->post['tltmultilang_image']) && is_file(DIR_IMAGE . $this->request->post['tltmultilang_image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['tltmultilang_image'], 100, 100);
		} elseif ($this->config->has('tltmultilang_image') && is_file(DIR_IMAGE . $this->config->get('tltmultilang_image'))) {
			$data['thumb'] = $this->model_tool_image->resize($this->config->get('tltmultilang_image'), 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tltmultilang', $data));
	}

	protected function validate() {
		$this->load->model('localisation/language');

		if (!$this->user->hasPermission('modify', 'extension/module/tltmultilang')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$results = $this->model_localisation_language->getLanguages();
		
		foreach ($results as $result) {
			if ((utf8_strlen($this->request->post['tltmultilang_meta_title_' . $result['code']]) < 3) || (utf8_strlen($this->request->post['tltmultilang_meta_title_' . $result['code']]) > 70)) {
				$this->error['meta_title'][$result['code']] = $this->language->get('error_meta_title');
			}
		}

		if ($this->request->post['tltmultilang_twitter_status']) {
			if ((utf8_strlen($this->request->post['tltmultilang_twitter_name']) < 3) || (utf8_strlen($this->request->post['tltmultilang_twitter_name']) > 64)) {
				$this->error['twitter_name'] = $this->language->get('error_twitter_name');
			}
			
			if (strncmp($this->request->post['tltmultilang_twitter_name'], '@', 1)) {
				$this->error['twitter_name'] = $this->language->get('error_twitter_name');
			}
		}
		
		if ($this->request->post['tltmultilang_facebook_status']) {
			if ((utf8_strlen($this->request->post['tltmultilang_facebook_name']) < 3) || (utf8_strlen($this->request->post['tltmultilang_facebook_name']) > 64)) {
				$this->error['facebook_name'] = $this->language->get('error_facebook_name');
			}
		}
		
		return !$this->error;
	}

    public function install() {
		$this->load->model('setting/setting');
		$this->load->model('localisation/language');
		
		$metas = array();
		$meta_title = $this->config->get('config_meta_title');
		$meta_description = $this->config->get('config_meta_description');
		$meta_keyword = $this->config->get('config_meta_keyword');
		
		$results = $this->model_localisation_language->getLanguages();

		foreach ($results as $result) {
			$metas['tltmultilang_meta_title_' . $result['code']] = $meta_title;
			$metas['tltmultilang_meta_description_' . $result['code']] = $meta_description;
			$metas['tltmultilang_meta_keyword_' . $result['code']] = $meta_keyword;
		}

		$this->model_setting_setting->editSetting('tltmultilang', $metas);
    }

    public function uninstall() {
		$this->load->model('setting/setting');
		$this->model_setting_setting->deleteSetting('tltmultilang');
    }
}