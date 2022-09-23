<?php
	class ControllerExtensionModuleBannerpro extends Controller {
		private $error = array();
		
		public function index() {
			$this->load->language('extension/module/bannerpro');
			
			$this->document->setTitle($this->language->get('heading_title'));
			$this->document->addScript('view/javascript/jquery/colorpicker/js/bootstrap-colorpicker.min.js');
			$this->document->addStyle('view/javascript/jquery/colorpicker/css/bootstrap-colorpicker.min.css');
			
			//CKEditor
			$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
			$this->document->addScript('view/javascript/ckeditor/ckeditor_init.js');
			
			$this->load->model('extension/module');
			
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
				if (!isset($this->request->get['module_id'])) {
					$this->model_extension_module->addModule('bannerpro', $this->request->post);
					} else {
					$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
				}
				
				$this->session->data['success'] = $this->language->get('text_success');
				
				$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
			}
			
			$data['heading_title'] = $this->language->get('heading_title');
			
			$data['text_edit'] = $this->language->get('text_edit');
			$data['text_enabled'] = $this->language->get('text_enabled');
			$data['text_disabled'] = $this->language->get('text_disabled');
			$data['text_fade'] = $this->language->get('text_fade');
			$data['text_backslide'] = $this->language->get('text_backslide');
			$data['text_godown'] = $this->language->get('text_godown');
			$data['text_fadeup'] = $this->language->get('text_fadeup');
			$data['text_mobile_image'] = $this->language->get('text_mobile_image');
			$data['text_mobile_text'] = $this->language->get('text_mobile_text');
			$data['help_category'] = $this->language->get('help_category');
			
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_banner'] = $this->language->get('entry_banner');
			$data['entry_width'] = $this->language->get('entry_width');
			$data['entry_height'] = $this->language->get('entry_height');
			$data['entry_texthover'] = $this->language->get('entry_texthover');
			$data['entry_navigation'] = $this->language->get('entry_navigation');
			$data['entry_pagination'] = $this->language->get('entry_pagination');
			$data['entry_status'] = $this->language->get('entry_status');
			$data['entry_category'] = $this->language->get('entry_category');
			$data['entry_animation'] = $this->language->get('entry_animation');
			$data['entry_text'] = $this->language->get('entry_text');
			$data['entry_banner_bg'] = $this->language->get('entry_banner_bg');
			$data['entry_title'] = $this->language->get('entry_title');
			$data['entry_mobile'] = $this->language->get('entry_mobile');
			$data['entry_hide_text'] = $this->language->get('entry_hide_text');
			$data['entry_css_class'] = $this->language->get('entry_css_class');
			$data['entry_css'] = $this->language->get('entry_css');
			$data['entry_link'] = $this->language->get('entry_link');
			$data['entry_image'] = $this->language->get('entry_image');
			$data['entry_sort_order'] = $this->language->get('entry_sort_order');
			
			$data['button_save'] = $this->language->get('button_save');
			$data['button_cancel'] = $this->language->get('button_cancel');
			$data['button_banner_add'] = $this->language->get('button_banner_add');
			$data['button_remove'] = $this->language->get('button_remove');
			
			$data['ckeditor'] = $this->config->get('config_editor_default');
			
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
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
			);
			
			if (!isset($this->request->get['module_id'])) {
				$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/bannerpro', 'token=' . $this->session->data['token'], true)
				);
				} else {
				$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/bannerpro', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
				);
			}
			
			if (!isset($this->request->get['module_id'])) {
				$data['action'] = $this->url->link('extension/module/bannerpro', 'token=' . $this->session->data['token'], true);
				} else {
				$data['action'] = $this->url->link('extension/module/bannerpro', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
			}
			
			$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);
			
			if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
				$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
			}
			
			if (isset($this->request->post['name'])) {
				$data['name'] = $this->request->post['name'];
				} elseif (!empty($module_info)) {
				$data['name'] = $module_info['name'];
				} else {
				$data['name'] = '';
			}
			
			if (isset($this->request->post['width'])) {
				$data['width'] = $this->request->post['width'];
				} elseif (!empty($module_info)) {
				$data['width'] = $module_info['width'];
				} else {
				$data['width'] = '';
			}
			
			if (isset($this->request->post['height'])) {
				$data['height'] = $this->request->post['height'];
				} elseif (!empty($module_info)) {
				$data['height'] = $module_info['height'];
				} else {
				$data['height'] = '';
			}
			
			if (isset($this->request->post['width_mobile'])) {
				$data['width_mobile'] = $this->request->post['width_mobile'];
				} elseif (!empty($module_info)) {
				$data['width_mobile'] = $module_info['width_mobile'];
				} else {
				$data['width_mobile'] = '';
			}
			
			if (isset($this->request->post['height_mobile'])) {
				$data['height_mobile'] = $this->request->post['height_mobile'];
				} elseif (!empty($module_info)) {
				$data['height_mobile'] = $module_info['height_mobile'];
				} else {
				$data['height_mobile'] = '';
			}
			
			if (isset($this->request->post['css_class'])) {
				$data['css_class'] = $this->request->post['css_class'];
				} elseif (!empty($module_info['css_class'])) {
				$data['css_class'] = $module_info['css_class'];
				} else {
				$data['css_class'] = '';
			}
			
			$data['token'] = $this->session->data['token'];
			
			$this->load->model('catalog/category');
			
			if (isset($this->request->post['categories'])) {
				$data['categories'] = $this->request->post['categories'];
				} elseif (!empty($module_info['categories'])) {
				$data['categories'] = $module_info['categories'];
				} else {
				$data['categories'] = array();
			}
			$data['banner_categories'] = array();
			
			foreach ($data['categories'] as $category_id) {
				$category_info = $this->model_catalog_category->getCategory($category_id);
				
				if ($category_info) {
					$data['banner_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
					);
				}
			}
			
			if (isset($this->request->post['animation'])) {
				$data['animation'] = $this->request->post['animation'];
				} elseif (!empty($module_info)) {
				$data['animation'] = $module_info['animation'];
				} else {
				$data['animation'] = 'fade';
			} 
			
			if (isset($this->request->post['text'])) {
				$data['text'] = $this->request->post['text'];
				} elseif (!empty($module_info)) {
				$data['text'] = $module_info['text'];
				} else {
				$data['text'] = '0';
			}    
			
			if (isset($this->request->post['banner-bg'])) {
				$data['banner_bg'] = $this->request->post['banner-bg'];
				} elseif (!empty($module_info['banner-bg'])) {
				$data['banner_bg'] = $module_info['banner-bg'];
				} else {
				$data['banner_bg'] = 'rgba(0,0,0,.5)';
			}
			
			if (isset($this->request->post['texthover'])) {
				$data['texthover'] = $this->request->post['texthover'];
				} elseif (!empty($module_info)) {
				$data['texthover'] = $module_info['texthover'];
				} else {
				$data['texthover'] = '';
			}
			
			if (isset($this->request->post['navigation'])) {
				$data['navigation'] = $this->request->post['navigation'];
				} elseif (!empty($module_info)) {
				$data['navigation'] = $module_info['navigation'];
				} else {
				$data['navigation'] = false;
			}
			
			if (isset($this->request->post['pagination'])) {
				$data['pagination'] = $this->request->post['pagination'];
				} elseif (!empty($module_info)) {
				$data['pagination'] = $module_info['pagination'];
				} else {
				$data['pagination'] = false;
			}
			
			if (isset($this->request->post['mobile_image'])) {
				$data['mobile_image'] = $this->request->post['mobile_image'];
				} elseif (!empty($module_info['mobile_image'])) {
				$data['mobile_image'] = $module_info['mobile_image'];
				} else {
				$data['mobile_image'] = false;
			}
			
			if (isset($this->request->post['hide_text'])) {
				$data['hide_text'] = $this->request->post['hide_text'];
				} elseif (!empty($module_info['hide_text'])) {
				$data['hide_text'] = $module_info['hide_text'];
				} else {
				$data['hide_text'] = false;
			}
			// Banner image start
			
			$this->load->model('localisation/language');
			
			$data['languages'] = $this->model_localisation_language->getLanguages();
			$data['lang'] = $this->language->get('lang');
			
			$this->load->model('tool/image');
			
			if (isset($this->request->post['banner_image'])) {
				$banner_images = $this->request->post['banner_image'];
				} elseif (!empty($module_info['banner_image'])) {
				$banner_images = $module_info['banner_image'];
				} else {
				$banner_images = array();
			}
			
			$data['banner_images'] = array();
			
			foreach ($banner_images as $key => $value) {
				foreach ($value as $banner_image) {
					if (is_file(DIR_IMAGE . $banner_image['image'])) {
						$image = $banner_image['image'];
						$thumb = $banner_image['image'];
						} else {
						$image = '';
						$thumb = 'no_image.png';
					}
					
					if (is_file(DIR_IMAGE . $banner_image['image_mobile'])) {
						$image_mobile = $banner_image['image_mobile'];
						$thumb_mobile = $banner_image['image_mobile'];
						} else {
						$image_mobile = '';
						$thumb_mobile = 'no_image.png';
					}
					
					$data['banner_images'][$key][] = array(
					'banner_image_description' => $banner_image['banner_image_description'],
					'banner_analytics_id' 	   => $banner_image['banner_analytics_id'],
					'link'                     => $banner_image['link'],
					'image'                    => $image,
					'thumb'                    => $this->model_tool_image->resize($thumb, 100, 100),
					'image_mobile'             => $image_mobile,
					'thumb_mobile'             => $this->model_tool_image->resize($thumb_mobile, 100, 100),
					'sort_order'               => $banner_image['sort_order']
					);
				}
			}
			
			$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
			
			// Banner Image END
			
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
			
			$this->response->setOutput($this->load->view('extension/module/bannerpro', $data));
		}
		
		protected function validate() {
			if (!$this->user->hasPermission('modify', 'extension/module/bannerpro')) {
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
	}	