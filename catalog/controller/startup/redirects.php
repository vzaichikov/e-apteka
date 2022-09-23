<?php
	class ControllerStartupRedirects extends Controller {
		private $cache_data = null;
		
		private function norm($keyword){
			$search = array(
			'%E2%84%96',
			'№',				
			);
			
			$replace = array(
			'_',
			'_'
			);
			
			return str_replace($search, $replace, $keyword);		
		}
		
		public function index() {
			
			//REDIRECT MANAGER
			if ($this->config->get('redirect_manager_status')) {
				
				$request_query = $this->request->server['REQUEST_URI'];
				$http_server = $this->request->server['HTTP_HOST'];
				
				if (strpos($request_query, '?')){
					$query_string = substr($request_query, (strpos($request_query, '?')+1));						
				}
				
				//удаляем query_string
				if (isset($query_string) && strlen($query_string)>0){
					$request_query = substr($request_query, 0, -1*(strlen($query_string)+1));						
				}
				
				//удаляем первый и последний слэш, если он есть	
				if (substr($request_query, -1) == '/') {
					$request_query = substr($request_query, 0, -1);
				}
				
				if (strlen($request_query)>0 && $request_query[0] == '/') {						
					$request_query = substr($request_query, 1);
				}
				
				if(isset($_GET['lang'])){
					$request_query = $_GET['lang'].$request_query;
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
				
				$search_query = $this->db->query(
				"SELECT * FROM `" . DB_PREFIX . "redirect_manager` 
				WHERE (
				from_url LIKE ('" . $this->db->escape($this->norm($request_query)) . "') OR 
				from_url LIKE ('" . $this->db->escape($this->norm($request_query)) . "/') OR 
				from_url LIKE ('/" . $this->db->escape($this->norm($request_query)) ."') OR 
				from_url LIKE ('/" . $this->db->escape($this->norm($request_query)) ."/'))
				AND (active = 1) LIMIT 1"
				);									
				
				if ($search_query->num_rows) {
					
					$this->db->query("UPDATE `" . DB_PREFIX . "redirect_manager` SET times_used = times_used+1 WHERE redirect_manager_id  = " . (int)$search_query->row['redirect_manager_id']);
					
					$to_url = $search_query->row['to_url'];
					
					if (substr($to_url, -1) == '/') {
						//$to_url = substr($to_url, 0, -1);
					}
					
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
					
					header('Location: ' . str_replace('&amp;', '&', $to), true, $search_query->row['response_code']);
					exit();
				}						
			}		
			//REDIRECT MANAGER END
			
			
		}
		
		
		
	}				