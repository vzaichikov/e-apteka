<?php
class ControllerExtensionModuleSosearchpro extends Controller {

	private $data = array();

	public function index( $setting ) {

		if(isset($setting)){
			$setting = array(
				'disp_title_module' => '',
				'head_name' => '',
				'module_description' => '',
				'use_cache' => '0',
				'cache_time' => '100000',
			);
		}

		static $module = 0;
		$this->load->language('extension/module/so_searchpro');
		$this->load->model('tool/image');
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('extension/module/so_searchpro');
	//	$this->document->addStyle('catalog/view/javascript/so_searchpro/css/so_searchpro.css');

		/*Entry */
		$this->data['text_search'] 			= $this->language->get('text_search');
		$this->data['text_category_all'] 	= $this->language->get('text_category_all');
		$this->data['text_tax'] 			= $this->language->get('text_tax');
		$this->data['text_price'] 			= $this->language->get('text_price');
		$this->data['button_cart'] 			= $this->language->get('button_cart');
		$this->data['button_wishlist'] 		= $this->language->get('button_wishlist');
		$this->data['button_compare'] 		= $this->language->get('button_compare');
		/*End Entry */

		/*Data */
		$this->data['disp_title_module'] = (int)$setting['disp_title_module'] ;
		$this->data['additional_class'] = isset($setting['class']) ? $setting['class']:'';
		$this->data['limit'] = isset($setting['limit']) ? $setting['limit'] : 5 ;
		$this->data['height'] = isset($setting['height']) ? $setting['height'] : 50 ;
		$this->data['width'] = isset($setting['width']) ? $setting['width'] : 50 ;
		$this->data['character'] = isset($setting['character']) ? $setting['character'] : 2 ;
		$this->data['showimage'] = isset($setting['showimage']) ? $setting['showimage'] : '1';
		$this->data['showprice'] = isset($setting['showprice']) ? $setting['showprice'] : '1';
		$this->data['showcategory'] = isset($setting['showcategory']) ? $setting['showcategory']:'1';

		//=== Theme Custom Code====
		$this->data['type_layout'] = isset($setting['type_layout']) ? $setting['type_layout']:'0';
		$this->data['typeheader']  = '';//$this->soconfig->get_settings('typeheader');
		
		$this->data['search_link'] = $this->url->link('product/search');

		if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
			$this->data['head_name'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['head_name'], ENT_QUOTES, 'UTF-8');
		}else{
			$data['head_name']  = html_entity_decode($setting['head_name'], ENT_QUOTES, 'UTF-8');
		}

		if(!isset($setting['str_keyword'])){
			$setting['str_keyword']= "Keywords";
		}
		if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
			$this->data['head_name'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['head_name'], ENT_QUOTES, 'UTF-8');
			if(!isset($setting['module_description'][$this->config->get('config_language_id')]['head_name'])){
				$setting['module_description'][$this->config->get('config_language_id')]['head_name'] = "Keywords";
			}
			$this->data['str_keyword'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['str_keyword'], ENT_QUOTES, 'UTF-8');
		}else{
			$this->data['head_name']  = $setting['head_name'];
			$this->data['str_keyword']  = $setting['str_keyword'];
		}
		$this->data['categories'] = array();

		/*End Data //Code by tunghv */
		$this->data['categories'] = array();
		$this->data['module'] = $module++;


		if(!isset($setting['show_keyword'])){
			$setting['show_keyword'] = 1;
		}
		if(!isset($setting['limit_keyword'])){
			$setting['limit_keyword'] = 5;
		}
		$this->data['list_products'] = self::getProducts($setting);
		$this->data['show_keyword'] = $setting['show_keyword'];

		// caching
		$use_cache = (int)$setting['use_cache'];

		$cache_time = (int)$setting['cache_time'];
		$folder_cache = DIR_CACHE.'so/Searchpro/';
		if(!file_exists($folder_cache))
			mkdir ($folder_cache, 0777, true);
		if (!class_exists('Cache_Lite'))
			require_once (DIR_SYSTEM . 'library/so/searchpro/Cache_Lite/Lite.php');

		$options = array(
			'cacheDir' => $folder_cache,
			'lifeTime' => $cache_time
		);

		//=== Theme Custom Code====
		$Cache_Lite = new Cache_Lite($options);
		if ($use_cache){
			$this->hash = md5( serialize($setting));
			$_data = $Cache_Lite->get($this->hash);
			if (!$_data) {
				// Check Version
				if(version_compare(VERSION, '2.1.0.2', '>')) {
					$_data = $this->getLayoutMod('so_searchpro',$setting,$this->data,$this->data['type_layout'],$this->data['typeheader'],$this->getHeader());

				}else{
					$tem_url = $this->config->get('config_template') . '/template/extension/module/so_searchpro/default.tpl';
					$template_file = DIR_TEMPLATE . $tem_url ? DIR_TEMPLATE . $tem_url : '';
					$_data = '';
					if (file_exists($template_file)){
						$_data = $this->load->view($tem_url, $this->data);
					}
				}
				$Cache_Lite->save($_data);
				return  $_data;
			} else {
				return  $_data;
			}
		}else{
			if(file_exists($folder_cache))
				$Cache_Lite->_cleanDir($folder_cache);
			// Check Version
			if(version_compare(VERSION, '2.1.0.2', '>')) {
				$_data = $this->getLayoutMod('so_searchpro',$setting,$this->data,$this->data['type_layout'],$this->data['typeheader'],$this->getHeader());
				return  $_data;

			}else{
				$tem_url = $this->config->get('config_template') . '/template/extension/module/so_searchpro/default.tpl';
				$template_file = DIR_TEMPLATE . $tem_url ? DIR_TEMPLATE . $tem_url : '';
				if (file_exists($template_file)) {
					return $this->load->view($tem_url, $this->data);
				}
			}
		}

	}

	//=== Theme Custom Code====
	public function getHeader(){
		$fileNames_header=array();
		$header_directory  = DIR_TEMPLATE.$this->config->get('theme_default_directory').'/template/header';
		if (is_dir($header_directory)) {
			$file_header = scandir($header_directory);

			foreach ($file_header as  $item_header) {
				if (strpos($item_header, '.tpl') == true) {

					list($fileName_header) = explode('.tpl',$item_header);
					$fileNames_header[] = ucfirst($fileName_header);

				}
			}
		}
		return  isset($fileNames_header) ? $fileNames_header : '' ;
	}

	public function getLayoutMod($name=null,$setting,$data,$type_layout=1,$typeheader='',$getHeader=true){

		$log_directory  = DIR_TEMPLATE.$this->config->get('theme_default_directory').'/template/extension/module/'.$name;
		$type_morelayout = '';
		$header_display='';
		if (is_dir($log_directory)) {
			$files = scandir($log_directory);
			foreach ($files as  $value) {
				if (strpos($value, '.tpl') == true) {
					$fileNames[] = $value;
				}
			}
		}

		if(!empty($getHeader)){
			$fileNames = isset($fileNames) ? $fileNames : '';

			foreach($getHeader as $header_id => $header_value){
				$header_id++;
				if($header_id == $typeheader){

					if (isset($setting['header_display'.$header_id])) $header_display = $setting['header_display'.$header_id];

				}

			}

			if($header_display){
				foreach($fileNames as $option_id => $option_value){

					if($option_id == $type_layout){

						$type_morelayout = $this->load->view('extension/module/'.$name.'/'.$option_value, $data);
					}
				}
			}
		}else{
			foreach($fileNames as $option_id => $option_value){

				if($option_id == $type_layout){

					$type_morelayout = $this->load->view('extension/module/'.$name.'/'.$option_value, $data);
				}
			}
		}
		return $type_morelayout;
	}
	//=== End Theme Custom Code====
	public function getProducts($setting)
	{
		$filter_data = array(
			'sort'			=> 'p.viewed',
			'order'			=> 'DESC',
			'limit'        	=> $setting['limit_keyword'] ,
			'start'        	=> '0'
		);
		$data['products'] = array();
		$data['list_products']= array();


		$products_arr = $this->model_extension_module_so_searchpro->getProducts($filter_data);

		foreach($products_arr as $product_info){
			// Name
			$name = $product_info['name'];
			$name_maxlength = ((strlen($product_info['name']) > 25)  ? utf8_substr(strip_tags(html_entity_decode($product_info['name'], ENT_QUOTES, 'UTF-8')), 0, 25) . '..' : $product_info['name']);
			$data['list_products'][] = array(
				'product_id'  		=> $product_info['product_id'],
				'name'        		=> $name,
				'nameFull'			=> $product_info['name'],
				'name_maxlength'	=> $name_maxlength,
				'href'        		=> $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
			);
		}


		return $data['list_products'];
	}

	public function autocomplete() {
		$json = array();

		$this->load->language('product/category');
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_category_id'])) {
			$this->load->model('tool/image');
			$this->load->model('catalog/product');
			$this->load->model('catalog/category');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_category_id'])) {
				$filter_category_id = $this->request->get['filter_category_id'];
				$filter_sub_category_id = true;
			} else {
				$filter_category_id = '';
				$filter_sub_category_id = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 20;
			}

			if (isset($this->request->get['width'])) {
				$width = $this->request->get['width'];
			} else {
				$width = 64;
			}

			if (isset($this->request->get['height'])) {
				$height = $this->request->get['height'];
			} else {
				$height = 64;
			}

			$data = array(
				'filter_name'  => $filter_name,
				'filter_tag'   => $filter_name,
				'filter_category_id' => $filter_category_id,
				'start'        => 0,
				'limit'        => 5
			);

			$this->load->model('extension/module/so_searchpro');

			$keyword = mb_strtolower(($filter_name), 'UTF-8');
			$keyword = $this->orfFilter($keyword, 1);
			$test = $this->load->controller('extension/module/autosearch/elasticSearch', ['keyword' => $keyword, 'description' => false]);

			$products_id = [];
			foreach ($test as $item) {
				if(in_array($item['tag'], array('product','description', 'instruction'))){
					$products_id[] = $item['id'];
				}
			}

			$data = array(
				'filter_category_id' => $filter_category_id,
				'filter_sub_category' => $filter_sub_category_id,
				'elastic'   => $products_id,
				'start'        => 0,
				'limit'        => 5
			);

			$results = $this->model_extension_module_so_searchpro->getProducts($data);

			if(count($results) == 0){
				$data['name'] = '%'.$keyword;
				$results = $this->model_extension_module_so_searchpro->getProducts($data);
			}
			$results = $this->model_extension_module_so_searchpro->getProducts($data);

			$total = count($results); //$this->model_extension_module_so_searchpro->getTotalProducts($data);
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $width, $height);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $width, $height);
				}
				// Check Version
				if(version_compare(VERSION, '2.1.0.2', '>')) {
					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$price = false;
					}

					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $result['rating'];
					} else {
						$rating = false;
					}
				} else {
					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = false;
					}

					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $result['rating'];
					} else {
						$rating = false;
					}
				}
				$path = 0;
				$category_name = '';
				$categories = $this->model_catalog_product->getCategories($result['product_id']);
				if ($categories){
					$categories_info = $this->model_catalog_category->getCategory($categories[0]['category_id']);
					$path=	$this->getCategoryPath($categories[0]['category_id']);
					$category_name = (isset($categories_info['name']) && $categories_info['name']) ? $categories_info['name'] : '';
				}


				$json[] = array(
					'total' => $total,
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'category_name' => strip_tags(html_entity_decode($category_name, ENT_QUOTES, 'UTF-8')),
					'manufacturer'      => $result['manufacturer'],
					'model'      => $result['model'],
					'image'		 => $image,
					'link'		 => $this->url->link('product/product','product_id='.$result['product_id']),
					'special'	 => $special,
					'tax'		 => $tax,
					'price'      => $price,
					'minimum'    =>  $result['minimum'],
					'sale_quantity'    =>  $result['sale_quantity']
				);
			}

		}

		$this->response->setOutput(json_encode($json));
	}

	public function getCategoryPath($category_id){
		$path = '';
		$category = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c WHERE c.category_id = " .(int)($category_id));

		if($category->row['parent_id'] != 0){
			$path .= $this->getCategoryPath($category->row['parent_id']) . '_';
		}

		$path .= $category->row['category_id'];

		return $path;
	}
	public  function orfFilter($keywords, $arrow = 0)
	{
		$str[0] = array('й' => 'q', 'ц' => 'w', 'у' => 'e', 'к' => 'r', 'е' => 't', 'н' => 'y', 'г' => 'u', 'ш' => 'i', 'щ' => 'o', 'з' => 'p', 'х' => '[', 'ъ' => ']', 'ф' => 'a', 'ы' => 's', 'в' => 'd', 'а' => 'f', 'п' => 'g', 'р' => 'h', 'о' => 'j', 'л' => 'k', 'д' => 'l', 'ж' => ';', 'э' => '\'', 'я' => 'z', 'ч' => 'x', 'с' => 'c', 'м' => 'v', 'и' => 'b', 'т' => 'n', 'ь' => 'm', 'б' => ',', 'ю' => '.', 'Й' => 'Q', 'Ц' => 'W', 'У' => 'E', 'К' => 'R', 'Е' => 'T', 'Н' => 'Y', 'Г' => 'U', 'Ш' => 'I', 'Щ' => 'O', 'З' => 'P', 'Х' => '[', 'Ъ' => ']', 'Ф' => 'A', 'Ы' => 'S', 'В' => 'D', 'А' => 'F', 'П' => 'G', 'Р' => 'H', 'О' => 'J', 'Л' => 'K', 'Д' => 'L', 'Ж' => ';', 'Э' => '\'', '?' => 'Z', 'ч' => 'X', 'С' => 'C', 'М' => 'V', 'И' => 'B', 'Т' => 'N', 'Ь' => 'M', 'Б' => ',', 'Ю' => '.');

		$str[1] = array('q' => 'й', 'w' => 'ц', 'e' => 'у', 'r' => 'к', 't' => 'е', 'y' => 'н', 'u' => 'г', 'i' => 'ш', 'o' => 'щ', 'p' => 'з', '[' => 'х', ']' => 'ъ', 'a' => 'ф', 's' => 'ы', 'd' => 'в', 'f' => 'а', 'g' => 'п', 'h' => 'р', 'j' => 'о', 'k' => 'л', 'l' => 'д', ';' => 'ж', '\'' => 'э', 'z' => 'я', 'x' => 'ч', 'c' => 'с', 'v' => 'м', 'b' => 'и', 'n' => 'т', 'm' => 'ь', ',' => 'б', '.' => 'ю', 'Q' => 'Й', 'W' => 'Ц', 'E' => 'У', 'R' => 'К', 'T' => 'Е', 'Y' => 'Н', 'U' => 'Г', 'I' => 'Ш', 'O' => 'Щ', 'P' => 'З', '[' => 'Х', ']' => 'Ъ', 'A' => 'Ф', 'S' => 'Ы', 'D' => 'В', 'F' => 'А', 'G' => 'П', 'H' => 'Р', 'J' => 'О', 'K' => 'Л', 'L' => 'Д', ';' => 'Ж', '\'' => 'Э', 'Z' => '?', 'X' => 'ч', 'C' => 'С', 'V' => 'М', 'B' => 'И', 'N' => 'Т', 'M' => 'Ь', ',' => 'Б', '.' => 'Ю');

		$str[2] = array("'" => "", "`" => "", "а" => "a", "А" => "a", "б" => "b", "Б" => "b", "в" => "v", "В" => "v", "г" => "g", "Г" => "g", "д" => "d", "Д" => "d", "е" => "e", "Е" => "e", "ж" => "zh", "Ж" => "zh", "з" => "z", "З" => "z", "и" => "i", "И" => "i", "й" => "y", "Й" => "y", "к" => "k", "К" => "k", "л" => "l", "Л" => "l", "м" => "m", "М" => "m", "н" => "n", "Н" => "n", "о" => "o", "О" => "o", "п" => "p", "П" => "p", "р" => "r", "Р" => "r", "с" => "s", "С" => "s", "т" => "t", "Т" => "t", "у" => "u", "У" => "u", "ф" => "f", "Ф" => "f", "х" => "h", "Х" => "h", "ц" => "c", "Ц" => "c", "ч" => "ch", "Ч" => "ch", "ш" => "sh", "Ш" => "sh", "щ" => "sch", "Щ" => "sch", "ъ" => "", "Ъ" => "", "ы" => "y", "Ы" => "y", "ь" => "", "Ь" => "", "э" => "e", "Э" => "e", "ю" => "yu", "Ю" => "yu", "я" => "ya", "Я" => "ya", "і" => "i", "І" => "i", "ї" => "yi", "Ї" => "yi", "є" => "e", "Є" => "e");

		$str[3] = array("a" => "а", "b" => "б", "v" => "в", "g" => "г", "d" => "д", "e" => "е", "yo" => "ё", "j" => "ж", "z" => "з", "i" => "и", "i" => "й", "k" => "к", "l" => "л", "m" => "м", "n" => "н", "o" => "о", "p" => "п", "r" => "р", "s" => "с", "t" => "т", "y" => "у", "f" => "ф", "h" => "х", "c" => "ц", "ch" => "ч", "sh" => "ш", "sh" => "щ", "i" => "ы", "e" => "е", "u" => "у", "ya" => "я", "A" => "А", "B" => "Б", "V" => "В", "G" => "Г", "D" => "Д", "E" => "Е", "Yo" => "Ё", "J" => "Ж", "Z" => "З", "I" => "И", "I" => "Й", "K" => "К", "L" => "Л", "M" => "М", "N" => "Н", "O" => "О", "P" => "П", "R" => "Р", "S" => "С", "T" => "Т", "Y" => "Ю", "F" => "Ф", "H" => "Х", "C" => "Ц", "Ch" => "Ч", "Sh" => "Ш", "Sh" => "Щ", "I" => "Ы", "E" => "Е", "U" => "У", "Ya" => "Я", "'" => "ь", "'" => "Ь", "''" => "ъ", "''" => "Ъ", "j" => "ї", "i" => "и", "g" => "ґ", "ye" => "є", "J" => "Ї", "I" => "І", "G" => "Ґ", "YE" => "Є");

		return strtr($keywords, isset($str[$arrow]) ? $str[$arrow] : array_search($str[0], $str[1]));
	}
}
?>

