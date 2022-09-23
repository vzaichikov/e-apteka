<?php
class ControllerExtensionModuleCarousel extends Controller {
	public function index($setting) {
		static $module = 0;

		$main_banner = false; //$this->cache->get('main.carusel.'.(int)$setting['banner_id'].'.'.(int)$this->config->get('config_language_id'));

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
						'link'  => $_SESSION['lang_code'].$result['link'],
						'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']),
						'image_mobil' => $this->model_tool_image->resize($result['image_mobil'], $setting['width_mobil'], $setting['height_mobil'])
					);
				}
			}
	
			$data['module'] = $module++;
	
			$return = $this->load->view('extension/module/carousel', $data);
			
			$this->cache->set('main.carusel.'.(int)$setting['banner_id'].'.'.(int)$this->config->get('config_language_id'), $return);
			return $return;
		}
	}
}
