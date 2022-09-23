<?php
class ControllerExtensionModuleRecentlyViewed extends Controller {

	public function viewed(){

		$this->load->language('extension/module/recently_viewed');
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_not_in_stock'] = $this->language->get('text_not_in_stock');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$current_product_id = false;
		if(isset($this->request->get['product_id'])) {
			$current_product_id = (int)$this->request->get['product_id'];
		}
		
		$setting['limit'] = 4;
		if (!empty($this->request->get['x'])) {
			$setting['limit'] = (int)$this->request->get['x'];
		}

		$results  = array();
		$setting['products'] = array();
		if ($this->customer->isLogged()) {
			$this->load->model('extension/module/recently_viewed');

			/* if user is logged in then save all recently_viewed products to database if available in cookie and then clear the cookie */
			if(isset($this->request->cookie['recently_viewed']) && !empty($this->request->cookie['recently_viewed'])) {
				$recently_viewed = json_decode(base64_decode($this->request->cookie['recently_viewed']), true);
				uasort($recently_viewed, function($a, $b){ return strtotime($a) < strtotime($b); });
				foreach($recently_viewed as $k=>$v){
					$this->model_extension_module_recently_viewed->setRecentlyViewedProducts($this->customer->getId(), $k, $v);
				}
				unset($this->request->cookie['recently_viewed']);
				setcookie('recently_viewed', '', 0, '/', $this->request->server['HTTP_HOST']);
			}

			if($product_ids = $this->model_extension_module_recently_viewed->getRecentlyViewedProducts($this->customer->getId(), $setting['limit'], $current_product_id)){

				foreach($product_ids as $p){
					$results[] = $p['product_id'];
				}
			}

		} else { 

			if(isset($this->request->cookie['recently_viewed']) && !empty($this->request->cookie['recently_viewed'])) {
				
				$recently_viewed = json_decode(base64_decode($this->request->cookie['recently_viewed']), true);
				// sort by in recent viewed order
				uasort($recently_viewed, function($a, $b){ return strtotime($a) < strtotime($b); });
				
				// if user is on product detail page then do not show current product in recently_viewed list
				if($current_product_id) {
					unset($recently_viewed[$current_product_id]);
				}
				
				$setting['products'] = array_keys($recently_viewed);
				
				if (!empty($setting['products'])) {
					$results = array_slice($setting['products'], 0, (int)$setting['limit']);
				}

			} else {


			}
		}

		$data['products'] = [];
		$products = [];

		if ($results) {
			foreach ($results as $product_id) {
				$products[] = $this->model_catalog_product->getProduct($product_id);
			}

			$data['products'] = $this->model_catalog_product->prepareProductArray($products);
		}

		$this->response->setOutput($this->load->view('extension/module/recently_viewed', $data));
	}


	public function index($setting) {
		static $module = 0;

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}

		$data['limit'] = $setting['limit'];

		return $this->load->view('extension/module/recently_viewed_afterload', $data);
	}
}		