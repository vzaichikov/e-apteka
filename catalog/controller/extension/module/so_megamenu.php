<?php
class ControllerExtensionModuleSomegamenu extends Controller {
    public function index($setting) {
		
        $this->load->model('extension/module/so_megamenu');
        $this->document->addStyle('catalog/view/javascript/so_megamenu/so_megamenu.css');
        $this->document->addStyle('catalog/view/javascript/so_megamenu/wide-grid.css');
        $this->document->addScript('catalog/view/javascript/so_megamenu/so_megamenu.js');
		$module_id = (isset($setting['moduleid']) && $setting['moduleid']) ? $setting['moduleid'] : 0;
        $data['menu'] = $this->model_extension_module_so_megamenu->getMenu($module_id);
		foreach($data['menu'] as &$menu){
			if(isset($menu['link']) && $menu['link']){
				$menu['link'] = trim($menu['link']);
				$link = (isset($menu['link']) && ($menu['link'])) ? unserialize($menu['link']) : array();
				$menu['route'] = '';
				$menu['path'] = '';
				if($link){
					if(isset($menu['type_link']) && $menu['type_link'] == 1){
						$menu['link'] = $this->url->link('product/category', 'path=' . $link['category']);
						$menu['route'] = 'product/category';
						$menu['path']	= $link['category'];
					}else
						$menu['link'] = $link['url'];
				}
				else
					$menu['link'] = '';
			}	
		}
        $lang_id = $this->config->get('config_language_id');
		if($setting['show_itemver'] == ""){
			$setting['show_itemver'] = 5;
		}
        $data['ustawienia'] = array(
            'orientation' => $setting['orientation'],
            'search_bar' => $setting['search_bar'],
            'navigation_text' => $setting['navigation_text'],
            'full_width' => $setting['full_width'],
            'home_item' => $setting['home_item'],
            'home_text' => $setting['home_text'],
            'animation' => $setting['animation'],
            'show_itemver' => $setting['show_itemver'],
            'animation_time' => $setting['animation_time'],
            'suffix_class' => isset($setting['suffix_class']) ? $setting['suffix_class'] : '',
			'disp_title_module' => isset($setting['disp_title_module']) ? $setting['disp_title_module'] : ''
        );
        $data['navigation_text'] = 'Navigation';
        if(isset($setting['navigation_text'][$lang_id])) {
            if(!empty($setting['navigation_text'][$lang_id])) {
                $data['navigation_text'] = $setting['navigation_text'][$lang_id];
            }
        }
        if(isset($setting['head_name'][$lang_id])) {
            if(!empty($setting['head_name'][$lang_id])) {
                $data['head_name'] = $setting['head_name'][$lang_id];
            }
        }		
        $data['home_text'] = 'Home';
        if(isset($setting['home_text'][$lang_id])) {
            if(!empty($setting['home_text'][$lang_id])) {
                $data['home_text'] = $setting['home_text'][$lang_id];
            }
        }
        $data['home'] = $this->url->link('common/home');
        $data['lang_id'] = $this->config->get('config_language_id');
		//=== Theme Custom Code====
		$data['theme_typelayout']  = $this->soconfig->get_settings('typelayout');
		
        // Search
        $this->language->load('common/header');
		
		$data['is_homepage'] = ($_SERVER['REQUEST_URI'] == '/'  || !isset($this->request->get['route']) || $this->request->get['route'] == 'common/home');

        // caching
        $use_cache = (int)$setting['use_cache'];
        $cache_time = (int)$setting['cache_time'];
        $folder_cache = DIR_CACHE.'so/Megamenu/';
        if(!file_exists($folder_cache))
            mkdir ($folder_cache, 0777, true);
        if (!class_exists('Cache_Lite'))
            require_once (DIR_SYSTEM . 'library/so/megamenu/Cache_Lite/Lite.php');

        $options = array(
            'cacheDir' => $folder_cache,
            'lifeTime' => $cache_time
        );
        $Cache_Lite = new Cache_Lite($options);
        if ($use_cache){
            $this->hash = md5( serialize($setting) . (int)$this->config->get('config_language_id') . $data['is_homepage']);
            $_data = $Cache_Lite->get($this->hash);
            if (!$_data) {
                // Check Version
                if(version_compare(VERSION, '2.1.0.2', '>')) {
                    $_data = $this->load->view('extension/module/so_megamenu/default.tpl', $data);
                }else{
                    $tem_url = $this->config->get('config_template') . '/template/extension/module/so_megamenu/default.tpl';
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
                return $this->load->view('extension/module/so_megamenu/default.tpl', $data);
            }else{
                $tem_url = $this->config->get('config_template') . '/template/extension/module/so_megamenu/default.tpl';
                $template_file = DIR_TEMPLATE . $tem_url ? DIR_TEMPLATE . $tem_url : '';
                if (file_exists($template_file)) {
                    return $this->load->view($tem_url, $data);
                }
            }
        }
        

    }
}
?>