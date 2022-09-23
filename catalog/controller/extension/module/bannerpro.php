<?php
	class ControllerExtensionModuleBannerpro extends Controller {
		public function index($setting) {
			static $module = 0;
			

			$this->load->model('tool/image');
			
			$data['bannerspro'] = array();
			$data['animation'] 	= $setting['animation'];
			$data['text'] 		= $setting['text'];
			$data['height'] 	= $setting['height'];
			$data['width'] 		= $setting['width'];
			$data['banner_bg'] = $setting['banner-bg'];
			$data['texthover'] = $setting['texthover'];
			$data['navigation'] = $setting['navigation'];
			$data['pagination'] = $setting['pagination'];
			$data['mobile_image'] = (isset($setting['mobile_image'])) ? $setting['mobile_image'] : '';
			$data['hide_text'] = (isset($setting['hide_text'])) ? $setting['hide_text'] : '';
			$data['css_class'] = (isset($setting['css_class'])) ? $setting['css_class'] : '';
			
			$results = array(); 
			
			
			if (isset($this->request->get['path']) && isset($setting['categories'])) {
				
				if (!empty($this->request->get['page']) && $this->request->get['page'] > 1){
					return '';
				}
																

				
				$parts = explode('_', (string)$this->request->get['path']);
				$category_id = (int)array_pop($parts);    
				if(!in_array($category_id, $setting['categories'])) {
					return '';
				} 
			}
			
			
			
			
			// Sort Order for banner
			if(isset($setting['banner_image'][$this->config->get('config_language_id')])){
				$results = $setting['banner_image'][$this->config->get('config_language_id')];
				usort($results, function($a, $b){
					if($a['sort_order'] === $b['sort_order'])
					return 0;  
					return $a['sort_order'] > $b['sort_order'] ? 1 : -1;
				});
				
				foreach ($results as $result) {
					
					if (is_file(DIR_IMAGE . $result['image'])) {
						$banner = array(
						'title' => strip_tags($result['banner_image_description']),
						'banner_analytics_id'  => $result['banner_analytics_id'],
						'link'  => $result['link'],
						'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
						);
					}
					
					if (is_file(DIR_IMAGE . $result['image_mobile'])) {
						$banner['image_mobile'] = $this->model_tool_image->resize($result['image_mobile'], $setting['width_mobile'], $setting['height_mobile']);
					}
					
					if ($banner){
						$data['bannerspro'][] = $banner;
					}
				}
				
				$data['module'] = $module++;
								
				
				return $this->load->view('extension/module/bannerpro', $data);
			}
		}
	}				