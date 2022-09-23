<?php
class ControllerExtensionModuleSlideshow extends Controller {
	public function index($setting) {
		static $module = 0;		
		
		$main_banner = $this->cache->get('main.slideshow.'.(int)$setting['banner_id'].'.'.(int)$this->config->get('config_language_id'));

		if($main_banner){
			return $main_banner;
		}else{
	
			$this->load->model('design/banner');
			$this->load->model('tool/image');
	
			//$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
			//$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');
	
			$data['banners'] = array();
	
			$results = $this->model_design_banner->getBanner($setting['banner_id']);
	
			foreach ($results as $result) {
				if (is_file(DIR_IMAGE . $result['image'])) {
					$data['banners'][] = array(
						'title' => $result['title'],
						// Category banners * * * Start
						'text1' => $result['text1'],
						'text2' => $result['text2'],
						'text3' => $result['text3'],
						// Category banners * * * End
						'link'  => $result['link'],
						'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
					);
				}
			}
	
			$data['module'] = $module++;
	
			$return = $this->load->view('extension/module/slideshow', $data);
				
			$this->cache->set('main.slideshow.'.(int)$setting['banner_id'].'.'.(int)$this->config->get('config_language_id'), $return);
			return $return;
		}
	}
}
