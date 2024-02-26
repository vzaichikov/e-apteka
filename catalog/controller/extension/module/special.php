<?php
class ControllerExtensionModuleSpecial extends Controller {
	public function index($setting) {		
		if ($setting['type'] == 'products'){
			$data = $this->load->language('extension/module/special');		
			$this->load->model('catalog/product');
			$this->load->model('tool/image');		

			$data['heading_title'] = $this->language->get('heading_title');
			$data['module'] = md5($setting['title']);

			$data['text_tax'] = $this->language->get('text_tax');

			$data['button_cart'] 		= $this->language->get('button_cart');
			$data['button_wishlist'] 	= $this->language->get('button_wishlist');
			$data['button_compare'] 	= $this->language->get('button_compare');
			$data['text_view_all'] 	= $this->language->get('text_view_all');

			$data['all_special_link'] = $this->url->link('product/special');


			$data['products'] = [];

			$filter_data = array(
				'sort'  				=> 'rand()',
				'filter_notnull_price' 	=> true,	
				'filter_in_stock' 		=> true,
				'start' 				=> 0,
				'limit' 				=> $setting['limit']
			);

			$results = $this->model_catalog_product->getProductSpecials($filter_data);
			if ($results) {
				$data['products'] = $this->model_catalog_product->prepareProductArray($results);

				return $this->load->view('extension/module/special', $data);
			}			
		} elseif ($setting['type'] == 'actions'){
			$this->load->model('catalog/ochelp_special');
			$data = $this->load->language('information/ochelp_special');

			$data['module'] = md5($setting['title']);
			$data['text_only_retail'] = sprintf($data['text_only_retail'], $this->url->link('information/contact/drugstores'));

			$data['specials'] = [];

			$filter_data = [
				'sort' 				=> 's.date_added',
				'order' 			=> 'DESC',
				'filter_homepage' 	=> true,
				'filter_image' 		=> true,
				'start' 			=> 0,
				'limit' 			=> $setting['limit'],
			];

			$results 			= $this->model_catalog_ochelp_special->getSpecials($filter_data);			

			foreach ($results as $result){
				$data['specials'][] = [
					'special_id' 	=> 'action_' . $result['special_id'],
					'title' 		=> $result['title'],
					'retail' 		=> $result['retail'],
					'image' 		=> $this->model_tool_image->resize($result['image'], 400, 300),
					'href' 			=> $this->url->link('information/ochelp_special/info', 'special_id=' . $result['special_id']),
				];
			}

			return $this->load->view('extension/module/special_actions', $data);
		}		
	}
}