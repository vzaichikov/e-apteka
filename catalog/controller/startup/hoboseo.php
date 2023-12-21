<?php

class ControllerStartupHoboSeo extends Controller {

	public function index(){		
		$this->load->controller('extension/module/ocfilter/initialise');

		$this->checkBadURIParams()->shortAliasImplementation()->redirectManagerImplementation();
		return false;
	}

	public function checkBadURIParams(){
		$new_page = '';
		
		if (isset($this->request->get['ealang']) && $this->request->get['ealang']){
			$val = $this->request->get['ealang'];
			$new_page = str_replace('&amp;ealang=' . $val, '', $_SERVER['REQUEST_URI']);
			$new_page = str_replace('&ealang=' . $val, '', $new_page);
			$new_page = str_replace('?ealang=' . $val, '', $new_page);
			
			$this->response->redirect($new_page, 301);			
		}

		if (isset($this->request->get['prlpn']) && $this->request->get['prlpn']){
			$val = $this->request->get['prlpn'];
			$new_page = str_replace('&amp;prlpn=' . $val, '', $_SERVER['REQUEST_URI']);
			$new_page = str_replace('&prlpn=' . $val, '', $new_page);
			$new_page = str_replace('?prlpn=' . $val, '', $new_page);
			
			$this->response->redirect($new_page, 301);			
		}
		
		if (isset($this->request->get['prpln']) && $this->request->get['prpln']){
			$val = $this->request->get['prpln'];
			$new_page = str_replace('&amp;prpln=' . $val, '', $_SERVER['REQUEST_URI']);
			$new_page = str_replace('&prpln=' . $val, '', $new_page);
			$new_page = str_replace('?prpln=' . $val, '', $new_page);
			
			$this->response->redirect($new_page, 301);			
		}

		if (isset($this->request->get['page']) && $this->request->get['page'] == 1){
			$new_page = str_replace('&amp;page=1', '', $_SERVER['REQUEST_URI']);
			$new_page = str_replace('&page=1', '', $new_page);
			$new_page = str_replace('?page=1', '', $new_page);			
		}
		
		if ($new_page){
			header('X-REDIRECT: checkBadURIParams');
			header('Location: ' . str_replace('&amp;', '&', $new_page), true, 301);
			exit();
		}	

		return $this;	
	}

	public function redirectManagerImplementation(){
		if ($this->config->get('redirect_manager_status')) {

			$request_query 	= $this->request->server['REQUEST_URI'];
			$http_server 	= $this->request->server['HTTP_HOST'];

			if (strpos($request_query, '?')){
				$query_string = substr($request_query, (strpos($request_query, '?')+1));						
			}

			if (isset($query_string) && strlen($query_string)>0){
				$request_query = substr($request_query, 0, -1*(strlen($query_string)+1));						
			}

			if (substr($request_query, -1) == '/') {
				$request_query = substr($request_query, 0, -1);
			}

			if (strlen($request_query)>0 && $request_query[0] == '/') {						
				$request_query = substr($request_query, 1);
			}

			if(isset($_GET['lang'])){
				$request_query = $_GET['lang'] . $request_query;
			}

			$replace_lang = '';
			$urllanguage = explode('/', trim(utf8_strtolower($request_query), '/'));
			$this->load->model('localisation/language');
			$languages = $this->model_localisation_language->getLanguages();

			$lang = array();
			foreach($languages as $language){
				$lang[] = $language['urlcode'];
			}

			if(isset($urllanguage[0]) && in_array($urllanguage[0], $lang)){
				if(count($urllanguage) > 1){
					$replace_lang = $urllanguage[0] . "/";
				}else{
					$replace_lang = $urllanguage[0];
				}

				$request_query = str_replace($replace_lang, '', $request_query);
			}

			$search_query = $this->db->query("SELECT * FROM `oc_redirect_manager` WHERE (from_url LIKE ('" . $this->db->escape(querynorm($request_query)) . "') OR from_url LIKE ('" . $this->db->escape(querynorm($request_query)) . "/') OR 
				from_url LIKE ('/" . $this->db->escape(querynorm($request_query)) ."') OR from_url LIKE ('/" . $this->db->escape(querynorm($request_query)) ."/')) AND (active = 1) LIMIT 1");									

			if ($search_query->num_rows) {

				$this->db->query("UPDATE `oc_redirect_manager` SET times_used = times_used+1 WHERE redirect_manager_id  = " . (int)$search_query->row['redirect_manager_id']);

				$to_url = $search_query->row['to_url'];

				if (strlen($to_url)>0 && $to_url[0] == '/') {
					$to_url = substr($to_url, 1);
				}

				if (isset($query_string) && strlen($query_string)>0){
					if (strpos($to_url, '?')){
						$to = '/' . $to_url . '&' . $query_string;							
					} else {
						$to = '/' . $to_url . '?' . $query_string;								
					}										
				} else {
					$to = '/' . $to_url;							
				}

				$replace_lang = trim($replace_lang, '/');

				if ($replace_lang){
					$to = '/' . $replace_lang . $to;
				}										

				header('X-REDIRECT: redirectManagerImplementation');
				header('Location: ' . str_replace('&amp;', '&', $to), true, $search_query->row['response_code']);
				exit();
			}	
		}					
	}		

	private function shortAliasImplementation(){
		$request_query = $this->request->server['REQUEST_URI'];
		if (strpos($request_query, '?')){
			$query_string = substr($request_query, (strpos($request_query, '?')+1));						
		}

		if (isset($query_string) && strlen($query_string)>0){
			$request_query = substr($request_query, 0, -1*(strlen($query_string)+1));						
		}

		if (substr($request_query, -1) == '/') {
			$request_query = substr($request_query, 0, -1);
		}

		if (strlen($request_query)>0 && $request_query[0] == '/') {						
			$request_query = substr($request_query, 1);
		}

		if (mb_strlen($request_query) > 3){								
				// if ($alias = $this->shortAlias->getURL($request_query, true)) {		
				// 	header('X-REDIRECT: shortAliasImplementation');																
				// 	header('Location: ' . str_replace('&amp;', '&', $alias), true, 301);
				// 	exit();
				// }
		}

		return $this;
	}

	private function longToShortUrlAliasImplementation(){
		$url = false;				

		if (thisIsAjax()){
			return $this;
		}

		if (thisIsUnroutedURI()){
			return $this;
		}

		if ($this->registry->get('short_uri_queries')){	
			$exploded = explode('/', rtrim($this->request->server['REQUEST_URI'], '/'));	
			$keywords = [];
			foreach ($exploded as $part){
				if (!empty($part)){
					$keywords[] = $part;
				}
			}

			$language_id = (int)$this->config->get('config_language_id');					
			if (count($keywords) == 1 && !empty($keywords[0])){
				if ($keywords[0] == 'ua'){
					$url = '/';
				}
			}

			$prefix_exists = false;
			foreach ($this->registry->get('languages') as $language){
				if (!empty($keywords[0]) && $keywords[0] == $language['urlcode']){
					$prefix_exists 	= true;
					$language_id 	= $language['language_id'];
					array_shift($keywords);	
					break;					
				}					
			}	

			if (!$url){				
				$url = '';
				$url_parts = [];
				foreach ($keywords as $keyword){
					$old_alias_query = $this->db->ncquery("SELECT * FROM oc_old_url_alias WHERE keyword LIKE '" . $this->db->escape($keyword) . "'");
					if ($old_alias_query->num_rows){
						if (!empty($old_alias_query->row['query'])){
							$exploded = explode('=', $old_alias_query->row['query']);

							if (count($exploded) == 2){
								if (!empty($this->registry->get('short_uri_queries')[$exploded[0]])){
									$url_parts[] = $this->registry->get('short_uri_queries')[$exploded[0]] . (int)$exploded[1];								
								}
							}
						}
					}
				}

				if (!empty($url_parts)){
					$url = '/';
					$url .= implode('/', $url_parts);
				}
			}

			if ($url){
				header('X-REDIRECT: longToShortUrlAliasImplementation');
				header('Location: ' . $url, true, 301);						
				exit();
			}		
		}

		return $this;
	}

	public function preSeoPro(){
		$this->checkBadURIParams()->shortAliasImplementation()->redirectManagerImplementation();
		return false;
	}

	public function postSeoPro(){
		$this->longToShortUrlAliasImplementation();
		return false;
	}

}