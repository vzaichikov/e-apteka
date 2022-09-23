<?php
class ControllerExtensionModuleNewsBlogArticles extends Controller {

	private $error = array();

	public function index(){
	//CKEditor
    if ($this->config->get('config_editor_default')) {
        $this->document->addScript('view/javascript/ckeditor/ckeditor.js');
        $this->document->addScript('view/javascript/ckeditor/ckeditor_init.js');
    } else {
        $this->document->addScript('view/javascript/summernote/summernote.js');
        $this->document->addScript('view/javascript/summernote/lang/summernote-' . $this->language->get('lang') . '.js');
        $this->document->addScript('view/javascript/summernote/opencart.js');
        $this->document->addStyle('view/javascript/summernote/summernote.css');
    }
		$this->load->language('module/newsblog_articles');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('newsblog_articles', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_module_name'] = $this->language->get('entry_module_name');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_show_categories'] = $this->language->get('entry_show_categories');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$data['entry_module_name'] = $this->language->get('entry_module_name');
		$data['entry_image_size'] = $this->language->get('entry_image_size');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_desc_limit'] = $this->language->get('entry_desc_limit');
		$data['entry_show_title'] = $this->language->get('entry_show_title');
		$data['entry_template'] = $this->language->get('entry_template');
		$data['entry_date_format'] = $this->language->get('entry_date_format');
		$data['entry_sort_by'] = $this->language->get('entry_sort_by');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['help_template'] = $this->language->get('help_template');
		$data['placeholder_template'] = $this->language->get('placeholder_template');
		$data['help_date_format'] = $this->language->get('help_date_format');

		$data['placeholder_date_format'] = $this->language->get('placeholder_date_format');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

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

		if (isset($this->error['show_categories'])) {
			$data['error_show_categories'] = $this->error['show_categories'];
		} else {
			$data['error_show_categories'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL')
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/newsblog_articles', 'token=' . $this->session->data['token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/newsblog_articles', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/newsblog_articles', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('extension/module/newsblog_articles', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['module_description'])) {
			$data['module_description'] = $this->request->post['module_description'];
		} elseif (!empty($module_info)) {
			$data['module_description'] = $module_info['module_description'];
		} else {
			$data['module_description'] = array();
		}

		$this->load->model('newsblog/category');

		$filter_data = array(
			'sort'        => 'name',
			'order'       => 'ASC'
		);

		$data['categories'] = $this->model_newsblog_category->getCategories($filter_data);

		if (isset($this->request->post['show_categories'])) {
			$data['show_categories'] = $this->request->post['show_categories'];
		} elseif (!empty($module_info) && isset($module_info['show_categories'])) {
			$data['show_categories'] = $module_info['show_categories'];
		} else {
			$data['show_categories'] = array();
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

		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info)) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = 3;
		}

		if (isset($this->request->post['desc_limit'])) {
			$data['desc_limit'] = $this->request->post['desc_limit'];
		} elseif (!empty($module_info)) {
			$data['desc_limit'] = $module_info['desc_limit'];
		} else {
			$data['desc_limit'] = 300;
		}

		if (isset($this->request->post['template'])) {
			$data['template'] = $this->request->post['template'];
		} elseif (!empty($module_info)) {
			$data['template'] = $module_info['template'];
		} else {
			$data['template'] = '';
		}

		if (isset($this->request->post['date_format'])) {
			$data['date_format'] = $this->request->post['date_format'];
		} elseif (!empty($module_info)) {
			$data['date_format'] = $module_info['date_format'];
		} else {
			$data['date_format'] = 'd.m.Y H:i';
		}

		$data['sort_by_array'] = array (
			'a.date_available'	=> $this->language->get('sort_by_date_available'),
			'a.sort_order'		=> $this->language->get('sort_by_sort_order'),
			'ad.name'			=> $this->language->get('sort_by_name'),
			'a.viewed'			=> $this->language->get('sort_by_viewed'),
			'rand()'			=> $this->language->get('sort_by_rand'),
		);

		if (isset($this->request->post['sort_by'])) {
			$data['sort_by'] = $this->request->post['sort_by'];
		} elseif (!empty($module_info)) {
			$data['sort_by'] = $module_info['sort_by'];
		} else {
			$data['sort_by'] = 'a.date_available';
		}

		$data['sort_direction_array'] = array (
			'desc'		=> $this->language->get('sort_direction_desc'),
			'asc'		=> $this->language->get('sort_direction_asc')
		);

		if (isset($this->request->post['sort_direction'])) {
			$data['sort_direction'] = $this->request->post['sort_direction'];
		} elseif (!empty($module_info)) {
			$data['sort_direction'] = $module_info['sort_direction'];
		} else {
			$data['sort_direction'] = 'desc';
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

		$this->response->setOutput($this->load->view('extension/module/newsblog_articles.tpl', $data));
	}

	protected function validate(){
		if (!$this->user->hasPermission('modify', 'extension/module/newsblog_articles')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (empty($this->request->post['show_categories'])) {
			$this->error['show_categories'] = $this->language->get('error_show_categories');
		}


		if (!$this->request->post['limit']) {
			$this->error['limit'] = $this->language->get('error_limit');
		}

		return !$this->error;
	}
}