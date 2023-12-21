<?php
	class ControllerEaptekaStats extends Controller {

	
		public function index(){
			$json = [];

			if ($this->config->get('config_customer_online')) {
				$this->load->model('tool/online');
				
				if (isset($this->request->server['REMOTE_ADDR'])) {
					$ip = $this->request->server['REMOTE_ADDR'];
					} else {
					$ip = '';
				}
				
				if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
					$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
					} else {
					$url = '';
				}
				
				if (isset($this->request->server['HTTP_REFERER'])) {
					$referer = $this->request->server['HTTP_REFERER'];
					} else {
					$referer = '';
				}
				
				if (isset($this->request->server['HTTP_USER_AGENT'])) {
					$useragent = $this->request->server['HTTP_USER_AGENT'];	
					} else {
					$useragent = '';
				}
				
				$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer, $useragent, $this->crawlerDetect->isCrawler());
			}

			if (!empty($referer)){
				$parsed = parse_url($referer);

				if ($parsed['host'] == HTTPS_HOST){
					$exploded_path = explode('/', trim($parsed['path'], '/'));
					if ($this->registry->has('short_uri_queries')){
						foreach ($exploded_path as $keyword){
							$path = trim($path);
							 if (preg_match('/^[' . $this->registry->get('short_uri_queries')['category_id'] . '][0-9]+$/', $keyword, $matches) == 1){
							 	$category_id = (int)trim(str_ireplace($this->registry->get('short_uri_queries')['category_id'], '', $keyword));
							 	$this->db->query("UPDATE oc_category SET viewed = viewed + 1 WHERE category_id = '" . (int)$category_id . "'");

							 	$json[] = ['c' => $category_id];

							 } elseif (preg_match('/^[' . $this->registry->get('short_uri_queries')['product_id'] . '][0-9]+$/', $keyword, $matches) == 1){
							 	$product_id = (int)(int)trim(str_ireplace($this->registry->get('short_uri_queries')['product_id'], '', $keyword));
							 	$this->db->query("UPDATE oc_product SET viewed = viewed + 1 WHERE product_id = '" . (int)$product_id . "'");

							 	$json[] = ['p' => $product_id];

							 } elseif (preg_match('/^[' . $this->registry->get('short_uri_queries')['manufacturer_id'] . '][0-9]+$/', $keyword, $matches) == 1){
							 	$manufacturer_id = (int)(int)trim(str_ireplace($this->registry->get('short_uri_queries')['manufacturer_id'], '', $keyword));
							 	$this->db->query("UPDATE oc_manufacturer SET viewed = viewed + 1 WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

							 	$json[] = ['m' => $manufacturer_id];
							 }
						}
					}
				}
			}

			$this->response->setOutput(json_encode($json));
		}
}