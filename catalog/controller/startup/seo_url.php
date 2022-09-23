<?php

class ControllerStartupSeoUrl extends Controller {

	public function index() {

		$is_redir = true;

		// Add rewrite to url class

		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}

		if (strripos($_SERVER['REQUEST_URI'], '/amp')) {
			$url = str_replace('/amp', ' ', $_SERVER['REQUEST_URI']);
			$this->response->redirect($url);
		}


		$no_redirect = array();

		if(!isset($_GET['lang'])){

			$_SESSION["url_no_lang"] = $_SERVER['REQUEST_URI'];
			// Язык урл
			$lang_code = '';
			if(substr($_SERVER['REQUEST_URI'], 0, 3) == '/ua'){
				$_SESSION["url_no_lang"] = substr($_SESSION["url_no_lang"], 3, strlen($_SESSION["url_no_lang"]));
				$lang_code = 'ua/';
			}
			if(substr($_SERVER['REQUEST_URI'], 0, 3) == '/en'){
				$_SESSION["url_no_lang"] = substr($_SESSION["url_no_lang"], 3, strlen($_SESSION["url_no_lang"]));
				$lang_code = 'en/';
			}

			if(strpos($_SESSION["url_no_lang"], 'ws-feed') !== false){
				$_SESSION["url_no_lang"] = str_replace('ws-feed','news-feed',$_SESSION["url_no_lang"]);
				$_SESSION["url_no_lang"] = str_replace('nenews-feed','news-feed',$_SESSION["url_no_lang"]);

			}
			$_SESSION['lang_code'] = $lang_code;

			// Слеш в конец урл
			if(strlen($_SERVER['REQUEST_URI']) > 2 AND strpos($_SERVER['REQUEST_URI'], 'index.php') === false){

				$url = explode('?',$_SERVER['REQUEST_URI']);

				$parts = explode('/', trim($url[0],'/'));
				if (utf8_strlen(end($parts)) == 0) {
					array_pop($parts);
				}

				if(isset($parts[count($parts)-1])){
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `keyword` = '" . $this->db->escape($parts[count($parts)-1]) . "'  LIMIT 1");

					if($query->num_rows){
						$target = explode('=', $query->row['query']);
						if($target[0] == 'category_id'){
							$is_category = true;
						}if($target[0] == 'product_id'){
							$is_product = true;
						}
					}
				}


				$url = explode('?',$_SESSION["url_no_lang"]);
				$nolang_parts = explode('/', trim($url[0],'/'));
				if (utf8_strlen(end($nolang_parts)) == 0) {
					array_pop($nolang_parts);
				}

				if(false and isset($is_category) AND count($nolang_parts) > 2){
					while(count($nolang_parts) > 2){
						array_shift($nolang_parts);
					}
					$redirect = true;
				}elseif(false and count($nolang_parts) > 3){
					while(count($nolang_parts) > 3){
						array_shift($nolang_parts);
					}
					$redirect = true;
				}

				//Если это не продукт - слеш должен быть
				if(substr($url[0], -1) != '/' AND isset($is_category)){

					$param = '';
					if(isset($url[1])) $param = '?'.$url[1];

					$redirect = rtrim(HTTP_SERVER,'/').$url[0].'/'.$param;
					if($is_redir){
						//header("HTTP/1.1 301 Moved Permanently");
						//header("Location: ".$redirect);
					}else{
						//die('1++ '.$redirect);
					}
					//exit();

				//Если это продукт - то слеша быть не должно
				}elseif(substr($url[0], -1) == '/' AND !isset($is_category) AND isset($is_product) AND !in_array($url[0], $no_redirect)){

					$param = '';
					if(isset($url[1])) $param = '?'.$url[1];

					$redirect = rtrim(HTTP_SERVER,'/').rtrim($url[0],'/').''.$param;
					if($is_redir){
						//header("HTTP/1.1 301 Moved Permanently");
						//header("Location: ".$redirect);
					}else{
						//die('2++ '.$redirect);
					}
					//exit();
				}

				if(isset($redirect)){

					$param = '';
					if(isset($url[1])) $param = '?'.$url[1];

					$redirect = HTTP_SERVER . $lang_code . implode('/', $nolang_parts) . (isset($is_category) ? '/':'') . ''.$param;
					//die("Location: ".$redirect);
					if($is_redir){
						header("HTTP/1.1 301 Moved Permanently");
						header("Location: ".$redirect);
					}else{
						die('3++ '.$redirect);
					}
					exit();
				}
			}
		}

		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		$selected_language = $this->session->data["language"];//$this->config->get('config_language');
		$active_lang = $languages[$selected_language];

		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);
		}
		if(isset($parts[0])){


			foreach($languages as $lang){
				if($lang['urlcode'] == $parts[0]){
					$url_language_code = $lang['code'];
					unset($parts[0]);
					break;
				}
			}

		}

        ////////////////////////////////////////
//            if (!isset($this->request->get['_route_'])) {
//                $url_language_code = $this->session->data["language"];
//            } else {
//                if(!isset($url_language_code)) $url_language_code = 'ru-ru';
////            }
//        if (isset($_COOKIE['vvedensky'])){
//            var_dump($this->request->get['_route_']);
//            var_dump($this->request->get['route']);
//        }
        ////////////////////////////////////////
        if(!isset($url_language_code)) $url_language_code = 'ru-ru';

		//Иной язык в урл - смена языка
		if(!isset($_GET['lang']) AND $url_language_code != $selected_language){
			$this->session->data["language"] = $url_language_code;
			$_SESSION["language"] = $url_language_code;

			$redirect = rtrim(HTTP_SERVER,'/').$_SERVER['REQUEST_URI'];

			header("Location: ".$redirect);
			exit();

		}


		// Для аяксов языки
		/*
		if(strpos($_SERVER["HTTP_REFERER"], HTTPS_SERVER.'ua/') !== false){
			$this->config->set('config_language_id', 3);
			$this->session->data["language"] = 'uk-ua';
			$_SESSION["language"] = 'uk-ua';
		}elseif(strpos($_SERVER["HTTP_REFERER"], HTTPS_SERVER.'en/') !== false){
			$this->config->set('config_language_id', 4);
			$this->session->data["language"] = 'en-gb';
			$_SESSION["language"] = 'en-gb';
		}
		*/

		if (isset($this->request->get['_route_'])) {

			// remove any empty arrays from trailing
			if (utf8_strlen(end($parts)) == 0) {
				array_pop($parts);
			}

			foreach ($parts as $part) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");

				//echo "<pre>";print_r(var_dump($query));echo "</pre>";
				//die();

				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);

					if ($url[0] == 'product_id') {
						$this->request->get['product_id'] = $url[1];
					}

					if ($url[0] == 'category_id') {
						if (!isset($this->request->get['path'])) {
							$this->request->get['path'] = $url[1];
						} else {
							$this->request->get['path'] .= '_' . $url[1];
						}
					}

					if ($url[0] == 'simple_blog_article_id') {
						$this->request->get['simple_blog_article_id'] = $url[1];
						$this->request->get['route'] = 'simple_blog/article/view';
						break;
					}

					if ($url[0] == 'simple_blog_author_id') {
						$this->request->get['simple_blog_author_id'] = $url[1];
						$this->request->get['route'] = 'simple_blog/article/view';
						break;
					}

					if ($url[0] == 'manufacturer_id') {
						$this->request->get['manufacturer_id'] = $url[1];
					}

					if ($url[0] == 'information_id') {
						$this->request->get['information_id'] = $url[1];
					}

					if ($query->row['query'] && $url[0] != 'information_id' && $url[0] != 'manufacturer_id' && $url[0] != 'category_id' && $url[0] != 'product_id') {
						$this->request->get['route'] = $query->row['query'];
					}
				} else {
					$this->request->get['route'] = 'error/not_found';

					break;
				}
			}


			if (!isset($this->request->get['route'])) {
				if (isset($this->request->get['product_id'])) {
					$this->request->get['route'] = 'product/product';

					$get_url = explode('?', $_SERVER['REQUEST_URI']);

					$origin_url = $this->url->link('product/product', 'product_id=' . (int)$this->request->get['product_id']);
					//echo $origin_url.'<br>'.HTTPS_SERVER.$this->request->get['_route_'];
					if(HTTPS_SERVER.ltrim($get_url[0],'/') != $origin_url){
						if($is_redir){
							//header("HTTP/1.1 301 Moved Permanently");
							//header("Location: ".$origin_url);
						}else{
							//die('11++ '.$origin_url);
						}
						//exit;
					}


				} elseif (isset($this->request->get['simple_blog_article_id'])) {
					$this->request->get['route'] = 'simple_blog/article/view';

				} elseif (isset($this->request->get['simple_blog_author_id'])) {
					$this->request->get['route'] = 'simple_blog/article/view';

				} elseif (isset($this->request->get['path'])) {
					$this->request->get['route'] = 'product/category';

					$get_url = explode('?', $_SERVER['REQUEST_URI']);

					$origin_url = $this->url->link('product/category', 'path=' . $this->request->get['path'], true);
					//echo $origin_url.'<br>'.HTTPS_SERVER.ltrim($get_url[0],'/').' == '.$this->request->get['path'];
					if(HTTPS_SERVER.ltrim($get_url[0],'/') != $origin_url){
						if($is_redir){
							header("HTTP/1.1 301 Moved Permanently");
							header("Location: ".$origin_url);
						}else{
							die('11++ '.$origin_url);
						}
						exit;
					}

				} elseif (isset($this->request->get['manufacturer_id'])) {
					$this->request->get['route'] = 'product/manufacturer/info';

				} elseif (isset($this->request->get['information_id'])) {
					$this->request->get['route'] = 'information/information';
				}
			}

		}
	}

	public function rewrite($link) {
		$url_info = parse_url(str_replace('&amp;', '&', $link));

		$url = '';

		$data = array();


		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		$default_language = $this->session->data["language"];//$this->config->get('config_language');
		$active_lang = $languages[$default_language];

		$lang_code = '';
		if($default_language != 'ru-ru'){
			$lang_code = '/'.$active_lang['urlcode'];
		}

		$no_path = true;
		$path = '';

		parse_str($url_info['query'], $data);

		$separator = '';

		foreach ($data as $key => $value) {
			if (isset($data['route'])) {
				if (($data['route'] == 'product/product' && $key == 'product_id') || (($data['route'] == 'product/manufacturer/info' || $data['route'] == 'product/product') && $key == 'manufacturer_id') || ($data['route'] == 'information/information' && $key == 'information_id')) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");

					$is_product = true;
					//Отдельно найдем путь
                    if($key == 'product_id'){
                        $url = '';
                        $path = '';
                        $no_path = true;
                        $is_product = true;
                        $product_id = $value;

                        $r = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id='" . (int)$product_id . "' ORDER BY main_category DESC LIMIT 1");
                        if($r->num_rows){

                            $category_id = (int)$r->row['category_id'];

                            $query3 = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias ua LEFT JOIN " . DB_PREFIX . "category c ON (c.category_id = " . (int)$category_id . ")
												WHERE `query` = 'category_id=" . (int)$category_id . "' LIMIT 1");

                            if ($query3->num_rows && $query3->row['keyword']) {

                                if((int)$query3->row['parent_id'] > 0){
                                    $query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias ua
													WHERE `query` = 'category_id=" . (int)$query3->row['parent_id'] . "' LIMIT 1");

                                    if ($query2->num_rows && $query2->row['keyword']) {
                                        $path .= '/' . $query2->row['keyword'];
                                    }
                                }
                                $path .= '/' . $query3->row['keyword'].$url;
                            }
                            else {
                                $path .='';
                            }

                        }
                    }


					if ($query->num_rows && $query->row['keyword']) {
						$url .= '/' . $query->row['keyword'];

						unset($data[$key]);
					}
				} elseif ($key == 'path' AND !isset($is_product)) {

					$categories = explode('_', $value);

					//die($categories);
					/*
					while(count($categories) > 2){
						array_shift($categories);
					}
					*/

					$separator = '/';
					$no_path = false;
					$category_id = array_pop($categories);

					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias ua
												LEFT JOIN " . DB_PREFIX . "category c ON (c.category_id = " . (int)$category_id . ")
												WHERE `query` = 'category_id=" . (int)$category_id . "' LIMIT 1");


					if ($query->num_rows && $query->row['keyword']) {
						$url = '/' . $query->row['keyword'];

						if((int)$query->row['parent_id'] > 0){
							$query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias ua
													WHERE `query` = 'category_id=" . (int)$query->row['parent_id'] . "' LIMIT 1");

							if ($query2->num_rows && $query2->row['keyword']) {
								$url = '/' . $query2->row['keyword'].$url;
							}
						}
					} else {
						$url = '';
						break;
					}


					unset($data[$key]);


				} elseif ($key == 'simple_blog_article_id' OR $key == 'simple_blog_author_id') {
					$url = '/news-feed';

					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '".$key."=" . (int)$value . "'");

					if ($query->num_rows) {
						if ($query->num_rows && $query->row['keyword']) {
							$url .= '/news-feed/' . $query->row['keyword'];
						} else {
							$url = '';

							break;
						}
					}

					unset($data[$key]);

				}else{
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($data['route']) . "' LIMIT 1");
					if ($query->num_rows) {
						$url .= '/' . $query->row['keyword'];
						$url = rtrim($url, '/').'/';
						break;
					}
				}

			}
		}

		$url = str_replace('/news-feed/news-feed', '/news-feed', $url);

		if($no_path){
			$url = $path.$url;
		}

		if(isset($is_product)){
			$separator = '';
		}
	//echo '<br>'.$url.' === '.$path;
		if ($url) {
			unset($data['route']);

			$query = '';

			if ($data) {
				foreach ($data as $key => $value) {
					$query .= '&' . rawurlencode((string)$key) . '=' . rawurlencode((is_array($value) ? http_build_query($value) : (string)$value));
				}

				if ($query) {
					$query = '?' . str_replace('&', '&amp;', trim($query, '&'));
				}
			}


			//die($url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query);
			$link = $url_info['scheme'] . '://' . $url_info['host'] . $lang_code .  str_replace('/index.php', '', $url_info['path']) . rtrim($url,'/'). $separator . $query;
			//$link = rtrim($link, '/');
			return $link;
		} else {

			$link = rtrim($link, '/').'';
			return $link;
		}
	}
}


