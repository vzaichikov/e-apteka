<?php
class ControllerCommonAfterLoad extends Controller {
	public function catalog() {
		
			// Menu			
		$main_header_menu = $this->cache->get('main.header.menu.'.'.'.(int)$this->config->get('config_language_id'));
		$data['text_catalog'] = $this->language->get('text_catalog');

		if($main_header_menu){	
			return $main_header_menu;
		} else {
			$this->load->model('catalog/category');
			
			$this->load->model('catalog/product');
			
			$data['categories'] = array();
			
			$categories = $this->model_catalog_category->getCategories(0);
			
			foreach ($categories as $category) {
				if ($category['top']) {						
					$children_data = array();
					if ($category['category_id'] != CATEGORY_SUBSTANCES){						
						
						$children = $this->model_catalog_category->getCategories($category['category_id']);
						
						foreach ($children as $child) {
							$filter_data = array(
								'filter_category_id'  => $child['category_id'],
								'filter_sub_category' => true
							);
							
							$children2 = $this->model_catalog_category->getCategories($child['category_id']);
							$children_data2 = array();
							foreach ($children2 as $child2) {
								
								$children_data2[] = array(
									'icon'  => $child2['icon'],
									'name'  => $child2['name'],
									'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'] . '_' . $child2['category_id'])
								);
								
							}
							
							$children_data[] = array(
								'icon'  => $child['icon'],
								'children' => $children_data2,
								'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
								'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
							);
						}
					}
					
						// Level 1
					$data['categories'][] = array(
						'name'     => $category['name'],
						'icon'     => $category['icon'],
						'children' => $children_data,
						'column'   => $category['column'] ? $category['column'] : 1,
						'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
					);
				}
			}
			
			$return = $this->load->view('afterload/catalog2', $data);									
			$this->cache->set('main.header.menu.'.'.'.(int)$this->config->get('config_language_id'), $return);
			
			return $return;
		}
	}
}


