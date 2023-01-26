<?php
	class ControllerStartupSeoPro extends Controller {
		private $cache_data = null;
		private $lang_prefix = null;
		
		
		public function __construct($registry) {

			parent::__construct($registry);
			$this->cache_data = $this->cache->get('seo_pro');					
			if (!$this->cache_data) {
				$query = $this->db->query("SELECT LOWER(`keyword`) as 'keyword', `query` FROM " . DB_PREFIX . "url_alias ORDER BY url_alias_id");
				$this->cache_data = array();
				foreach ($query->rows as $row) {
					if (isset($this->cache_data['keywords'][$row['keyword']])){
						$this->cache_data['keywords'][$row['query']] = $this->cache_data['keywords'][$row['keyword']];
						continue;
					}
					$this->cache_data['keywords'][$row['keyword']] = $row['query'];
					$this->cache_data['queries'][$row['query']] = $row['keyword'];
				}
				$this->cache->set('seo_pro', $this->cache_data);
			}

			
			$this->load->model('localisation/language');					
			if(isset($this->session->data['language']) && $this->session->data['language'] != $this->config->get('config_language')){
				$language = $this->model_localisation_language->getLanguageByCode($this->session->data['language']);
				if ($language && isset($language['urlcode']) && $language['urlcode']) {
					$this->lang_prefix = $language['urlcode'];
				}
				} elseif ($code = $this->config->get('config_language_code_explicit')){
				if ($code != $this->config->get('config_language')) {
					$language = $this->model_localisation_language->getLanguageByCode($code);
					if ($language && isset($language['urlcode']) && $language['urlcode']) {
						$this->lang_prefix = $language['urlcode'];
					}				
				}
			}
		}
		
		public function index() {
			
			// Add rewrite to url class
			if ($this->config->get('config_seo_url')) {
				$this->url->addRewrite($this);
				} else {
				return;
			}
			
			
			if(isset($this->request->get['_route_'])){				
				$urllanguage = explode('/', trim(utf8_strtolower($this->request->get['_route_']), '/'));
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
					
					$this->request->get['_route_'] = str_replace($replace_lang, '', $this->request->get['_route_']);					
					if($this->request->get['_route_'] == '' || $this->request->get['_route_'] == '/'){
						unset($this->request->get['_route_']);
					}
				}
			}						
			
			// Decode URL
			if (!isset($this->request->get['_route_'])) {
				$this->validate();
				} else {
				$route_ = $route = $this->request->get['_route_'];
				
				$ampDir = 'amp';
				$route_ = str_replace('amp/', '', $route_);
				$route = str_replace('amp/', '', $route);
				$ampRoute = $this->request->get['_route_'];			
				
				$this->request->get['_route_'] = str_replace('amp/', '', $this->request->get['_route_']);
				
				unset($this->request->get['_route_']);
				
				$parts = explode('/', trim(utf8_strtolower($route), '/'));						
				
				list($last_part) = explode('.', array_pop($parts));
				array_push($parts, $last_part);
				
				$rows = array();
				
				$mfp_parts = array();
				$mfp_key = 0;
				
				foreach ($parts as $keyword) {
					if (isset($this->cache_data['keywords'][$keyword])) {
						$rows[] = array('keyword' => $keyword, 'query' => $this->cache_data['keywords'][$keyword]);
					}
				}
				
				if (isset($this->cache_data['keywords'][$route])){
					$keyword = $route;
					$parts = array($keyword);
					$rows = array(array('keyword' => $keyword, 'query' => $this->cache_data['keywords'][$keyword]));
				}
				
				if (count($rows) == sizeof($parts)) {
					$queries = array();
					foreach ($rows as $row) {
						$queries[utf8_strtolower($row['keyword'])] = $row['query'];
					}
					
					reset($parts);
					foreach ($parts as $part) {
						if(!isset($queries[$part])) return false;
						$url = explode('=', $queries[$part], 2);
						
						if ($url[0] == 'newsblog_category_id') {
							if (!isset($this->request->get['newsblog_path'])) {
								$this->request->get['newsblog_path'] = $url[1];
								} else {
								$this->request->get['newsblog_path'] .= '_' . $url[1];
							}
							} elseif ($url[0] == 'category_id') {
							if (!isset($this->request->get['path'])) {
								$this->request->get['path'] = $url[1];
								} else {
								$this->request->get['path'] .= '_' . $url[1];
							}
							}elseif ($url[0] == 'collection_id') {
							if (!isset($this->request->get['colpath'])) {
								$this->request->get['colpath'] = $url[1];
								} else {
								$this->request->get['colpath'] .= '_' . $url[1];
							}
							} elseif (count($url) > 1) {
							$this->request->get[$url[0]] = $url[1];
						}
					}
					} else {
					$this->request->get['route'] = 'error/not_found';
				}
				
				if (isset($this->request->get['newsblog_article_id'])) {
					$this->request->get['route'] = 'newsblog/article';
					if (!isset($this->request->get['newsblog_path'])) {
						$path = $this->getPathByNewsBlogArticle($this->request->get['newsblog_article_id']);
						if ($path) $this->request->get['newsblog_path'] = $path;
					}
					} elseif (isset($this->request->get['newsblog_path'])) {
					$this->request->get['route'] = 'newsblog/category';
					} elseif (isset($this->request->get['product_id'])) {
					$this->request->get['route'] = 'product/product';
					
					if (strpos($ampRoute, "amp/") !== FALSE ) {
						$this->request->get['route'] = 'product/amp_product';						
					}
					
					if (!isset($this->request->get['path'])) {
						$path = $this->getPathByProduct($this->request->get['product_id']);
						if ($path) $this->request->get['path'] = $path;
					}
					} elseif (isset($this->request->get['path'])) {				
					$this->request->get['route'] = 'product/category';
					} elseif (isset($this->request->get['colpath'])) {
					$this->request->get['route'] = 'product/collection';
					} elseif (isset($this->request->get['manufacturer_id'])) {
					$this->request->get['route'] = 'product/manufacturer/info';
					} elseif (isset($this->request->get['information_id'])) {
					$this->request->get['route'] = 'information/information';	
					} elseif (isset($this->request->get['special_id'])) {
					$this->request->get['route'] = 'information/ochelp_special/info';
					} elseif (isset($this->request->get['simple_blog_article_id'])) {
					$this->request->get['route'] = 'simple_blog/article/view';
					} elseif (isset($this->request->get['simple_blog_author_id'])) {
					$this->request->get['route'] = 'simple_blog/author';
					} elseif (isset($this->request->get['simple_blog_category_id'])) {
					$this->request->get['route'] = 'simple_blog/category';
					} elseif(isset($this->cache_data['queries'][$route_]) && isset($this->request->server['SERVER_PROTOCOL'])) {
					header($this->request->server['SERVER_PROTOCOL'] . ' 301 Moved Permanently');
					$this->response->redirect($this->cache_data['queries'][$route_], 301);
					} else {
					if (isset($queries[$parts[0]])) {
						$this->request->get['route'] = $queries[$parts[0]];
					}
				}
				
				$this->validate();
				
				if (isset($this->request->get['route'])) {
					return new Action($this->request->get['route']);
				}
			}
		}
		
		public function rewrite($link) {
			
			$ampDir = 'amp';
			
			if (!$this->config->get('config_seo_url')) return $link;
			
			$seo_url = '';
			
			$component = parse_url(str_replace('&amp;', '&', $link));
			
			$data = array();
			parse_str($component['query'], $data);
			
			$route = $data['route'];
			unset($data['route']);
			
			switch ($route) {
				case 'product/amp_product':
				if (isset($data['product_id'])) {
					$tmp = $data;
					$data = array();
					if ($this->config->get('config_seo_url_include_path')) {
						$data['path'] = $this->getPathByProduct($tmp['product_id']);
						if (!$data['path']) return $link  ;
					}
					$data['product_id'] = $tmp['product_id'];
					
					$isAmpURL = 1;
					
					if (isset($tmp['tracking'])) {
						$data['tracking'] = $tmp['tracking'];
					}
				}
				break;
				case 'newsblog/article':
				if (isset($data['newsblog_article_id'])) {
					$tmp = $data;
					$data = array();
					$data['newsblog_path'] = $this->getPathByNewsBlogArticle($tmp['newsblog_article_id']);
					if (!$data['newsblog_path']) return $link;
					$data['newsblog_article_id'] = $tmp['newsblog_article_id'];
				}
				break;
				
				case 'newsblog/category':
				if (isset($data['newsblog_path'])) {
					$category = explode('_', $data['newsblog_path']);
					$category = end($category);
					$data['newsblog_path'] = $this->getPathByNewsBlogCategory($category);
					if (!$data['newsblog_path']) return $link;
				}
				break;
				
				case 'product/product':
				if (isset($data['product_id'])) {
					$tmp = $data;
					$data = array();
					if ($this->config->get('config_seo_url_include_path')) {
						$data['path'] = $this->getPathByProduct($tmp['product_id']);
						if (!$data['path']) return $link;
					}
					$data['product_id'] = $tmp['product_id'];
					if (isset($tmp['tracking'])) {
						$data['tracking'] = $tmp['tracking'];
					}
					if (isset($tmp['hello'])) {
						$data['hello'] = $tmp['hello'];
					}
					if (isset($tmp['search'])) {
						$data['search'] = $tmp['search'];
					}
					if (isset($tmp['gclid'])) {
						$data['gclid'] = $tmp['gclid'];
					}
					
				}
				break;
				
				case 'product/category':
				if (isset($data['path'])) {
					$category = explode('_', $data['path']);
					$category = end($category);
					$data['path'] = $this->getPathByCategory($category);
					if (!$data['path']) return $link;
				}
				break;
				
				case 'product/collection':
				if (isset($data['colpath'])) {
					$collection = explode('_', $data['colpath']);
					$collection = end($collection);		
					/*	
						if ($manufacturer_id = $this->getManufacturerPathByCollection($collection)){
						$data['manufacturer_id'] = $this->getManufacturerPathByCollection($collection);	
						}
					*/
					$data['colpath'] = $this->getPathByCollection($collection);									
					if (!$data['colpath']) return $link;									
					} elseif (isset($data['collection_id'])){
					
					/*	
						if ($manufacturer_id = $this->getManufacturerPathByCollection($data['collection_id'])){
						$data['manufacturer_id'] = $manufacturer_id;
						}
					*/
					$data['colpath'] = $this->getPathByCollection($data['collection_id']);
				}
				break;
				
				case 'product/product/review':
				case 'product/product/instruction':
				case 'product/product/likreestr':
				case 'extension/soconfig/quickview':
				case 'information/information/info':			
				return $link;
				break;
				
				default:
				break;
			}
			
			if ($component['scheme'] == 'https') {
				$link = $this->config->get('config_ssl');
				} else {
				$link = $this->config->get('config_url');
			}
			
			$link .= 'index.php?route=' . $route;
			
			if (count($data)) {
				$link .= '&amp;' . urldecode(http_build_query($data, '', '&amp;'));
			}
			
			$queries = array();
			
			//
			if (count($data) == 2 && !empty($data['colpath']) && !empty($data['manufacturer_id'])){
				krsort($data);
			}
			
			if(!in_array($route, array('product/search'))) {
				foreach($data as $key => $value) {				
					switch($key) {
						case 'newsblog_path':
						$categories = explode('_', $value);
						foreach($categories as $category) {
							$queries[] = 'newsblog_category_id=' . $category;
						}
						unset($data[$key]);
						break;
						
						case 'newsblog_article_id':
						case 'newsblog_category_id':
						case 'product_id':												
						case 'category_id':
						case 'information_id':
						case 'order_id':
						$queries[] = $key . '=' . $value;
						unset($data[$key]);
						$postfix = 1;
						break;
						
						case 'manufacturer_id':
						$queries[] = 'product/manufacturer';
						$queries[] = $key . '=' . $value;
						unset($data[$key]);						
						break;
						
						case 'colpath':
						$queries[] = 'product/collection/listing';
						$collections = explode('_', $value);
						foreach ($collections as $collection) {
							$queries[] = 'collection_id=' . $collection;
						}
						unset($data[$key]);
					//	$postfix = 1;
						break;
						
						case 'collection_id':
						$queries[] = 'product/collection/listing';
						/*	if ($manufacturer_id = $this->getManufacturerPathByCollection($value)){
							$queries[] = 'manufacturer_id=' . $manufacturer_id;
							}
						*/
						$collections = explode('_', $this->getPathByCollection($value));
						foreach ($collections as $collection) {
							$queries[] = 'collection_id=' . $collection;
						}					
						//$queries[] = $key . '=' . $value;
						unset($data[$key]);
					//	$postfix = 1;
						break;														
						
						case 'special_id':
						$queries[] = 'information/ochelp_special';
						$queries[] = $key . '=' . $value;
						unset($data[$key]);
						break;
						
						case 'simple_blog_article_id':
						case 'simple_blog_author_id':
						case 'simple_blog_category_id':
						$queries[] = 'simple_blog/article';
						$queries[] = $key . '=' . $value;
						unset($data[$key]);
						$postfix = 1;
						break;
						
						case 'path':
						$categories = explode('_', $value);
						foreach($categories as $category) {
							$queries[] = 'category_id=' . $category;
						}
						unset($data[$key]);
						break;												
						
						default:
						break;
					}
				}
			}					
			
			if(empty($queries)) {
				$queries[] = $route;
			}
			
			$rows = array();
			foreach($queries as $query) {										
				if(isset($this->cache_data['queries'][$query])) {
					$rows[] = array('query' => $query, 'keyword' => $this->cache_data['queries'][$query]);
				}
			}
			
			if (isset($isAmpURL)) {
				$seo_url .=  $ampDir;
			}
			
			
			if(count($rows) == count($queries)) {
				$aliases = array();
				foreach($rows as $row) {
					$aliases[$row['query']] = $row['keyword'];
				}
				foreach($queries as $query) {
					$seo_url .= '/' . rawurlencode($aliases[$query]);
				}
			}
			
			if ($seo_url == '') return $link;
			
			$seo_url = trim($seo_url, '/');

			if ($this->lang_prefix){
				$seo_url = $this->lang_prefix . '/' . $seo_url;
			}					
			
			if ($component['scheme'] == 'https') {
				$seo_url = $this->config->get('config_ssl') . $seo_url;
				} else {
				$seo_url = $this->config->get('config_url') . $seo_url;
			}
			
			if (isset($postfix)) {
				$seo_url .= trim($this->config->get('config_seo_url_postfix'));
				} else {
				$seo_url .= '/';
			}
			
			if(substr($seo_url, -2) == '//') {
				$seo_url = substr($seo_url, 0, -1);
			}
			
			if (count($data)) {
				$seo_url .= '?' . urldecode(http_build_query($data, '', '&amp;'));
			}
			
			
			
			return $seo_url;
		}
		
		private function getPathByNewsBlogArticle($article_id) {
			$article_id = (int)$article_id;
			if ($article_id < 1) return false;
			
			static $path = null;
			if (!isset($path)) {
				$path = $this->cache->get('newsblog.article.seopath');
				if (!isset($path)) $path = array();
			}
			
			if (!isset($path[$article_id])) {
				$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "newsblog_article_to_category WHERE article_id = '" . $article_id . "' ORDER BY main_category DESC LIMIT 1");
				
				$path[$article_id] = $this->getPathByNewsBlogCategory($query->num_rows ? (int)$query->row['category_id'] : 0);
				
				$this->cache->set('newsblog.article.seopath', $path);
			}
			
			return $path[$article_id];
		}
		
		private function getPathByNewsBlogCategory($category_id) {
			$category_id = (int)$category_id;
			if ($category_id < 1) return false;
			
			static $path = null;
			if (!isset($path)) {
				$path = $this->cache->get('newsblog.category.seopath');
				if (!isset($path)) $path = array();
			}
			
			if (!isset($path[$category_id])) {
				$max_level = 10;
				
				$sql = "SELECT CONCAT_WS('_'";
				for ($i = $max_level-1; $i >= 0; --$i) {
					$sql .= ",t$i.category_id";
				}
				$sql .= ") AS path FROM " . DB_PREFIX . "newsblog_category t0";
				for ($i = 1; $i < $max_level; ++$i) {
					$sql .= " LEFT JOIN " . DB_PREFIX . "newsblog_category t$i ON (t$i.category_id = t" . ($i-1) . ".parent_id)";
				}
				$sql .= " WHERE t0.category_id = '" . $category_id . "'";
				
				$query = $this->db->query($sql);
				
				$path[$category_id] = $query->num_rows ? $query->row['path'] : false;
				
				$this->cache->set('newsblog.category.seopath', $path);
			}
			
			return $path[$category_id];
		}
		
		private function getPathByProduct($product_id) {
			$product_id = (int)$product_id;
			if ($product_id < 1) return false;
			
			static $path = null;
			if (!isset($path)) {
				$path = $this->cache->get('product.seopath');
				if (!isset($path)) $path = array();
			}
			
			if (!isset($path[$product_id])) {
				$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . $product_id . "' ORDER BY main_category DESC LIMIT 1");
				
				$path[$product_id] = $this->getPathByCategory($query->num_rows ? (int)$query->row['category_id'] : 0);
				
				$this->cache->set('product.seopath', $path);
			}
			
			return $path[$product_id];
		}
		
		private function getManufacturerPathByCollection($collection_id){
			$collection_id = (int)$collection_id;
			if ($collection_id < 1) return false;
			
			static $path = null;
			if (!isset($path)) {
				$path = $this->cache->get('collection.manufacturer.seopath');
				if (!isset($path)) $path = array();
			}
			
			if (!isset($path[$collection_id])) {
				$query = $this->db->query("SELECT manufacturer_id FROM " . DB_PREFIX . "collection WHERE collection_id = '" . $collection_id . "' LIMIT 1");
				
				$path[$collection_id] = $query->num_rows ? (int)$query->row['manufacturer_id'] : false;
				
				$this->cache->set('collection.manufacturer.seopath', $path);
			}
			
			return $path[$collection_id];
			
		}
		
		private function getPathByCollection($collection_id) {
			$collection_id = (int)$collection_id;
			if ($collection_id < 1) return false;
			
			static $colpath = null;
			if (!isset($colpath)) {
				$colpath = $this->cache->get('collection.seopath');
				if (!isset($colpath)) $colpath = array();
			}
			
			if (!isset($colpath[$collection_id])) {
				$max_level = 2;
				
				$sql = "SELECT CONCAT_WS('_'";
				for ($i = $max_level-1; $i >= 0; --$i) {
					$sql .= ",t$i.collection_id";
				}
				$sql .= ") AS colpath FROM " . DB_PREFIX . "collection t0";
				for ($i = 1; $i < $max_level; ++$i) {
					$sql .= " LEFT JOIN " . DB_PREFIX . "collection t$i ON (t$i.collection_id = t" . ($i-1) . ".parent_id)";
				}
				$sql .= " WHERE t0.collection_id = '" . $collection_id . "'";
				
				$query = $this->db->query($sql);
				
				$colpath[$collection_id] = $query->num_rows ? $query->row['colpath'] : false;
				
				$this->cache->set('collection.seopath', $colpath);
			}
			
			return $colpath[$collection_id];
		}
		
		private function getPathByCategory($category_id) {
			$category_id = (int)$category_id;
			if ($category_id < 1) return false;
			
			static $path = null;
			if (!isset($path)) {
				$path = $this->cache->get('category.seopath');
				if (!isset($path)) $path = array();
			}
			
			if (!isset($path[$category_id])) {
				$max_level = 2;
				
				$sql = "SELECT CONCAT_WS('_'";
				for ($i = $max_level-1; $i >= 0; --$i) {
					$sql .= ",t$i.category_id";
				}
				$sql .= ") AS path FROM " . DB_PREFIX . "category t0";
				for ($i = 1; $i < $max_level; ++$i) {
					$sql .= " LEFT JOIN " . DB_PREFIX . "category t$i ON (t$i.category_id = t" . ($i-1) . ".parent_id)";
				}
				$sql .= " WHERE t0.category_id = '" . $category_id . "'";
				
				$query = $this->db->query($sql);
				
				$path[$category_id] = $query->num_rows ? $query->row['path'] : false;
				
				$this->cache->set('category.seopath', $path);
			}
			
			return $path[$category_id];
		}
		
		private function validate() {
			
			$ampDir = 'amp';
			if( isset( $this->request->get['add'] ) ) {
				return;
			}
			
			if( isset( $this->request->get['route'] ) && strpos( $this->request->get['route'], 'module/mega_filter' ) !== false ) {
				return;
			}
			
			if( isset( $this->request->get['route'] ) && strpos( $this->request->get['route'], 'extension/module/social_auth' ) !== false ) {
				return;
			}
			
			if( isset( $this->request->get['mfp'] ) ) {
				return;
			}
			
			if (isset($this->request->get['route']) && $this->request->get['route'] == 'error/not_found') {
				return;
			}			
			
			if(empty($this->request->get['route'])) {
				$this->request->get['route'] = 'common/home';
			}
			
			if (isset($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				return;
			}
			
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$config_ssl = substr($this->config->get('config_ssl'), 0, $this->strpos_offset('/', $this->config->get('config_ssl'), 3) + 1);
				
				//check for manyslashes
				if (strpos($this->request->server['REQUEST_URI'], '//') !== false){
					$url = str_replace('&amp;', '&', $config_ssl . $this->request->server['REQUEST_URI']);
					} else {
					$url = str_replace('&amp;', '&', $config_ssl . ltrim($this->request->server['REQUEST_URI'], '/'));
				}
				
				$seo = str_replace('&amp;', '&', $this->url->link($this->request->get['route'], $this->getQueryString(array('route')), true));
				} else {
				$config_url = substr($this->config->get('config_url'), 0, $this->strpos_offset('/', $this->config->get('config_url'), 3) + 1);
				$url = str_replace('&amp;', '&', $config_url . ltrim($this->request->server['REQUEST_URI'], '/'));
				$seo = str_replace('&amp;', '&', $this->url->link($this->request->get['route'], $this->getQueryString(array('route')), false));
			}
			
			if (rawurldecode($url) != rawurldecode($seo) && isset($this->request->server['SERVER_PROTOCOL']) && rawurldecode($seo) != $ampDir) {				
				header($this->request->server['SERVER_PROTOCOL'] . ' 301 Moved Permanently');				
				$this->response->redirect($seo);
			}
		}
		
		private function strpos_offset($needle, $haystack, $occurrence) {
			// explode the haystack
			$arr = explode($needle, $haystack);
			// check the needle is not out of bounds
			switch($occurrence) {
				case $occurrence == 0:
				return false;
				case $occurrence > max(array_keys($arr)):
				return false;
				default:
				return strlen(implode($needle, array_slice($arr, 0, $occurrence)));
			}
		}
		
		private function getQueryString($exclude = array()) {
			if (!is_array($exclude)) {
				$exclude = array();
			}
			
			foreach ($this->request->get as $key => $value){
				if (empty($value) && $value !== '0'){
					unset($this->request->get[$key]);
				}
			}
			
			return urldecode(http_build_query(array_diff_key($this->request->get, array_flip($exclude))));
		}
	}																																							