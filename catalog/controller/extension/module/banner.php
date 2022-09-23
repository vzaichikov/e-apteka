<?php
	class ControllerExtensionModuleBanner extends Controller {
		public function index($setting) {
			static $module = 0;
			
            $this->load->model('design/banner');
            $this->load->model('tool/image');
			
            //$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
            //$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.transitions.css');
            //$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');
			
            $data['banners'] = array();
            if(isset($setting['category'])){
                $results = $this->model_design_banner->getBanner2($setting['banner_id']);
				}else{
                $results = $this->model_design_banner->getBanner($setting['banner_id']);
			}
			
			$data['background'] = $setting['background'];
			
			if ($setting['random']){
				
				$idx = mt_rand(1, count($results)) - 1;
				$results = array($results[$idx]);
			}
			
            foreach ($results as $result) {
				
                if (is_file(DIR_IMAGE . $result['image'])) {
                    $data['banners'][] = array(
					'title' 		=> $result['title'],					
					'banner_analytics_id' => $result['text1'],
					'text2' 		=> $result['text2'],
					'text3' 		=> $result['text3'],
					'background' 	=> $result['background']?$result['background']:$data['background'],
					'link'  		=> $result['link'],
					'image' 		=> $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']),
					'image_mobil' 	=> $this->model_tool_image->resize($result['image_mobil'], $setting['width_mobil'], $setting['height_mobil'])
                    );
					
					$data['background'] = $result['background']?$result['background']:$setting['background'];
				}
				
				
			}
			
            $data['module'] = $module++;
			
			if (!empty($setting['block_layout']) && $setting['block_layout'] == 'header'){
			return $this->load->view('extension/module/banner_header', $data);
			}
			
            if((int)$setting['banner_id'] == 11 || isset($setting['category'])){
                $return = $this->load->view('extension/module/banner2', $data);
				}else{
                $return = $this->load->view('extension/module/banner', $data);
			}
			
            return $return;
		}
	}
