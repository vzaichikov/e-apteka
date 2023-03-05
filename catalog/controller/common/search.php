<?php
class ControllerCommonSearch extends Controller {
	public function index() {
		$this->load->language('product/search');

		$data['search_link'] 				= $this->url->link('product/search');
			
		if (!$this->mobileDetect->isMobile()){
			$data['text_search_field'] 			= $this->language->get('text_search_field');		
		} else {
			$data['text_search_field'] = '';
		}

		$data['search_show_all_results'] 	= $this->language->get('search_show_all_results');					
		$data['text_empty'] 				= $this->language->get('text_empty');

		$data['text_not_in_stock'] 				= $this->language->get('text_not_in_stock');
		$data['text_is_analog'] 				= $this->language->get('text_is_analog');

		$data['text_popular_histories'] =  $this->language->get('text_popular_histories');
		$data['text_my_search_history'] =  $this->language->get('text_my_search_history');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		$data['search_href'] = $this->url->link('eapteka/smartsearch');
		$data['search_clear_href'] = $this->url->link('eapteka/smartsearch/clear');
		
		return $this->load->view('common/search', $data);	
	}
}