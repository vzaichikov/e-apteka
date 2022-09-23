<?php
class ControllerExtensionModuleSohtmlcontent extends Controller {
	public function index($setting) {
		if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
			$data['heading_title'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['title'], ENT_QUOTES, 'UTF-8');
			$data['html'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['description'], ENT_QUOTES, 'UTF-8');
			$data['class_suffix'] 			= $setting['class_suffix'];
			
			//=== Theme Custom Code====
			$data['type_layout'] 			= isset($setting['type_layout']) ? $setting['type_layout'] : '0';
			$data['theme_typelayout']  = $this->soconfig->get_settings('typelayout');
			// caching
			$use_cache = (int)$setting['use_cache'];
			$cache_time = (int)$setting['cache_time'];
			$folder_cache = DIR_CACHE.'so/HtmlContent/';
			if(!file_exists($folder_cache))
				mkdir ($folder_cache, 0777, true);
			if (!class_exists('Cache_Lite'))
				require_once (DIR_SYSTEM . 'library/so/html_content/Cache_Lite/Lite.php');

			$options = array(
				'cacheDir' => $folder_cache,
				'lifeTime' => $cache_time
			);
			$Cache_Lite = new Cache_Lite($options);
			if ($use_cache){
				$this->hash = md5( serialize($setting));
				$_data = $Cache_Lite->get($this->hash);
				if (!$_data) {
					$_data = $this->getLayoutMod('so_html_content',$data,$data['type_layout']);
					$Cache_Lite->save($_data);
					return  $_data;
				} else {
					return  $_data;
				}
			}else{
				if(file_exists($folder_cache))
					$Cache_Lite->_cleanDir($folder_cache);
				$_data = $this->getLayoutMod('so_html_content',$data,$data['type_layout']);
				return  $_data;
				
			}
			
		}
	}
	
	//=== Theme Custom Code====
	public function getLayoutMod($name=null,$data,$type_layout){
		
		$theme_directory = DIR_TEMPLATE.$this->config->get('theme_default_directory');
		if (!file_exists($theme_directory))  $themes = 'default';
		else $themes = $this->config->get('theme_default_directory');
		$log_directory  = DIR_TEMPLATE.$themes.'/template/extension/module/'.$name;

		
		if (is_dir($log_directory)) {
			$files = scandir($log_directory);
			foreach ($files as  $value) {
				if (strpos($value, '.tpl') == true) {
					$fileNames[] = $value;
				}
			}
		} 
		$fileNames = isset($fileNames) ? $fileNames : '';
		foreach($fileNames as $option_id => $option_value){
			if($option_id == $type_layout){
				$type_morelayout = $this->load->view('extension/module/'.$name.'/'.$option_value, $data);
			}
		}
		return $type_morelayout;
	}
}
