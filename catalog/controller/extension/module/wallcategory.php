<?php
	class ControllerExtensionModuleWallCategory extends Controller {
		public function index() {
			
			if (isset($this->request->get['path'])) {
				$parts = explode('_', (string)$this->request->get['path']);
				} else {
				$parts = array();
			}
			
			$category_id = (int)array_pop($parts);
			
			$return = $this->cache->get('ControllerExtensionModuleWallCategory' . $category_id. '.' . (int)$this->config->get('config_language_id'));
			if ($return){
				return $return;
			}
			
			$this->load->language('extension/module/wallcategory');		
			$this->load->model('catalog/category');
			$this->load->model('catalog/product');
			$this->load->model('tool/image');
			
			$data['heading_title'] = $this->language->get('heading_title');
			
			$category_info = array();
			if ($category_id){
				$category_info = $this->model_catalog_category->getCategory($category_id);
			}
			
			$data['categories'] = array();
			
			$categories = array();
			if (!$category_id){
				$categories = $this->model_catalog_category->getCategories(0);
				} else {				
				if ($category_info['show_subcats']){
					$categories = $this->model_catalog_category->getCategories($category_id);
				}
			}
			
			foreach ($categories as $category) {
				$children_data = array();
				
				if ($category_id) {
					$children = $this->model_catalog_category->getCategories($category['category_id']);
					
					foreach($children as $child) {
						$children2 = $this->model_catalog_category->getCategories($child['category_id']);
						$children2_data = array();
						
						foreach($children2 as $child2) {							
							$children2_data[] = array(
							'category_id' 	=> $child2['category_id'],
							'name' 			=> $child2['name'],
							'image'		  	=> $child2['image'],
							'icon'		  	=> $child2['icon'],
							'href' 			=> $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'] .  '_' . $child2['category_id'])
							);
						}
						
						$children_data[] = array(
						'category_id' 	=> $child['category_id'],
						'name' 			=> $child['name'],
						'image'		  	=> $child['image'],
						'icon'		  	=> $child['icon'],
						'children' 		=> $children2_data,
						'href' 			=> $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
						);
					}
				}
				
				$data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'],
				'children'    => $children_data,
				'image'		  => $category['image'],
				'icon'		  => $category['icon'],
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
			
			if ($category_id){			
				$return = $this->load->view('extension/module/wallcategory_category', $data);
				} else {
				$return = $this->load->view('extension/module/wallcategory', $data);
			}
			
			
			$this->cache->set('ControllerExtensionModuleWallCategory' . $category_id. '.' . (int)$this->config->get('config_language_id'), $return);
			
			return $return;
		}
	}											