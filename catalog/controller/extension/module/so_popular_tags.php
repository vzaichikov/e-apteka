<?php
class ControllerExtensionModuleSopopulartags extends Controller {
	public function index($setting) {
		static $module = 1;
		$this->load->language('extension/module/so_popular_tags');
		$data['heading_title'] = $this->language->get('heading_title');
		$this->load->model('tool/image');
		$this->load->model('extension/module/so_popular_tags');
		
		$this->document->addStyle('catalog/view/javascript/so_popular_tags/css/style.css');
		//Config Default
		if(!isset($setting['pre_text']))
		{
			$setting['pre_text'] = '';
		}
		if(!isset($setting['post_text']))
		{
			 $setting['post_text'] = '';
		}
	// Get data
		$data['class_suffix'] 			= $setting['class_suffix'];
		$data['moduleid']  				= $setting['moduleid'];
		$data['disp_title_module'] 		= (int)$setting['disp_title_module'];
		
		if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
			$data['head_name'] 			= html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['head_name'], ENT_QUOTES, 'UTF-8');
		}else{
			$data['head_name']  = html_entity_decode($setting['head_name'], ENT_QUOTES, 'UTF-8');
		}
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
		 	$data['base'] = $this->config->get('config_ssl');
		} else {
			$data['base'] = $this->config->get('config_url');
		}
		$data['text_notags'] = $this->language->get('text_notags');
		$language = $this->config->get('config_language_id');
		//get data tagclound
		$limit = isset($setting['limit_tags'])?$setting['limit_tags']:20;
		$min_font_size = isset($setting['min_font_size'])?$setting['min_font_size']:9;
		$max_font_size = isset($setting['max_font_size'])?$setting['max_font_size']:20;
		$font_weight = isset($setting['font_weight'])?$setting['font_weight']:'bold';
		$item_link_target = isset($setting['item_link_target']) ? $setting['item_link_target'] : '_blank';
		$data['class_suffix'] = isset($setting['class_suffix'])?$setting['class_suffix']:'';
		//Tab Advanced
		$data['pre_text'] 				= $setting['pre_text'];
		$data['post_text'] 				= $setting['post_text'];
		
		$tags = $this->model_extension_module_so_popular_tags->getRandomTags($limit, $min_font_size, $max_font_size, $font_weight,$item_link_target);

		$data['data'] = $tags;

		$data['module'] = $module++;

		// caching
		$use_cache = (int)$setting['use_cache'];
		$cache_time = (int)$setting['cache_time'];
		$folder_cache = DIR_CACHE.'so/PopularTags/';
		if(!file_exists($folder_cache))
			mkdir ($folder_cache, 0777, true);
		if (!class_exists('Cache_Lite'))
			require_once (DIR_SYSTEM . 'library/so/popular_tags/Cache_Lite/Lite.php');

		$options = array(
			'cacheDir' => $folder_cache,
			'lifeTime' => $cache_time
		);
		$Cache_Lite = new Cache_Lite($options);
		if ($use_cache){
			$this->hash = md5( serialize($setting));
			$_data = $Cache_Lite->get($this->hash);
			if (!$_data) {
				// Check Version
				if(version_compare(VERSION, '2.1.0.2', '>')) {
					$_data = $this->load->view('extension/module/so_popular_tags/default.tpl', $data);
				}else{
					$tem_url = $this->config->get('config_template') . '/template/extension/module/so_popular_tags/default.tpl';
					$template_file = DIR_TEMPLATE . $tem_url ? DIR_TEMPLATE . $tem_url : '';
					$_data = '';
					if (file_exists($template_file)){
						$_data = $this->load->view($tem_url, $data);
					}
				}
				$Cache_Lite->save($_data);
				return  $_data;
			} else {
				return  $_data;
			}
		}else{
			if(file_exists($folder_cache))
				$Cache_Lite->_cleanDir($folder_cache);
			// Check Version
			if(version_compare(VERSION, '2.1.0.2', '>')) {
				return $this->load->view('extension/module/so_popular_tags/default.tpl', $data);
			}else{
				$tem_url = $this->config->get('config_template') . '/template/extension/module/so_popular_tags/default.tpl';
				$template_file = DIR_TEMPLATE . $tem_url ? DIR_TEMPLATE . $tem_url : '';
				if (file_exists($template_file)) {
					return $this->load->view($tem_url, $data);
				}
			}
		}
	}
	
}