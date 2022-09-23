<?php
class ControllerExtensionModuleSofiltershopby extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/so_filter_shop_by');
		$data['heading_title'] = $this->language->get('heading_title');
		$obj_lang = $this->language;
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('extension/module/so_filter_shop_by');
		$this->load->model('tool/image');
		if($setting['disp_pro_price'])
		{
			$this->document->addStyle('catalog/view/javascript/so_filter_shop_by/css/nouislider.css');
			$this->document->addScript('catalog/view/javascript/so_filter_shop_by/js/nouislider.js');
		}
		$this->document->addStyle('catalog/view/javascript/so_filter_shop_by/css/style.css');
	
	// Get data
		$default = array(
			'disp_title_module'		=> '1',
			'class_suffix'			=> '',
			'disp_pro_price'		=> '1',
			'disp_search_text'		=> '1',
			'character_search'		=> '3',
			'disp_rating'			=> '1',
			'disp_reset_all'		=> '1',
			'disp_manu_all'			=> '1',
			'disp_subcategory'		=> '1'
		);
		// Get all attribute
		$disp_attributes = array();
		$disp_attributes_group = array();
		$attributes =  $this->model_extension_module_so_filter_shop_by->getAttributes(array('sort'=>'a.sort_order'));
		if(!empty($attributes)){
			foreach($attributes as $item)
			{
				$disp_attributes["disp_att_id_".$item['attribute_id']] = 1;
				$disp_attributes_group["disp_att_group_id_".$item['attribute_group_id']] = 1;
			}
			$default = array_merge($default,$disp_attributes); // Array config display attribute
			$default = array_merge($default,$disp_attributes_group); // Array config display attribute group
		}
		// Get all options
		$disp_options = array();
		$options_arr = $this->model_extension_module_so_filter_shop_by->getOptions();
		if(!empty($options_arr)){
			foreach($options_arr as $item)
			{
				$disp_options["disp_opt_id_".$item['option_id']] = 1;
			}
			$default = array_merge($default,$disp_options); // Array config display option
		}
		// Get all manufacturer
		$disp_manu = array();
		$manufacturers =  $this->model_extension_module_so_filter_shop_by->getManufacturers(array('sort'=>'sort_order'));
		if(!empty($manufacturers)){
			foreach($manufacturers as $item)
			{
				$disp_manu["disp_manu_id_".$item['manufacturer_id']] = 1;
			}
			$default = array_merge($default,$disp_manu); // Array config display manufacturer
		}
		
		// Set data in database => $data
		$data = array_merge($default,$setting);
		
		if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
			$data['head_name'] 			= html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['head_name'], ENT_QUOTES, 'UTF-8');
		}else{
			$data['head_name']  		= $setting['head_name'];
		}
		$data['disp_attributes_group']	= array_merge($disp_attributes_group,$setting);
		$data['disp_attributes']		= array_merge($disp_attributes,$setting);
		$data['disp_options']			= array_merge($disp_options,$setting);
		$data['disp_manu']				= array_merge($disp_manu,$setting);
		
		// Get Category list
		$products_arr_id		= array();
		$option_all 			= "";
		$attribute_all 			= "";
		$manufacturer_all 		= "";
		$subcategory_all 		= "";
		$category_id			= "";
		if (isset($this->request->get['route']) && isset($this->request->get['path']) && $this->request->get['route'] == 'product/category') {
            $cate_path = $this->request->get['path'];   
			$cate_id_arr = explode("_",$cate_path);
			$category_id = $cate_id_arr[count($cate_id_arr)-1];
			if(isset($this->request->get['subcate_id'])){
				$category_id = $this->request->get['subcate_id'];
			}
			$filter_data = array(
				'filter_category_id'  => $category_id
			);
			$products_arr_info = $this->model_catalog_product->getProducts($filter_data);
			if(count($products_arr_info) > 0 )
			{
				foreach($products_arr_info as $item)
				{
					$products_arr_id[] = $item['product_id'];
				}
				$option_all 		= $this->model_extension_module_so_filter_shop_by->getAllOptions($products_arr_id);
				$attribute_all 		= $this->model_extension_module_so_filter_shop_by->getAllAttributes($products_arr_id);
				$manufacturer_all 	= $this->model_extension_module_so_filter_shop_by->getAllManufacturerId($products_arr_id);
			}
			$subcategory_all = $this->model_extension_module_so_filter_shop_by->getAllSubCategory($category_id);
		}
		$data['opt_id'] = $data['att_id'] = $data['manu_id']  = $data['subcate_id'] =  array();
		$data['text_search'] 		= "";
		if(isset($this->request->get['opt_id'])){
			$data['opt_id'] = $this->request->get['opt_id'];
		}
		if(isset($this->request->get['att_id'])){
			$data['att_id'] = $this->request->get['att_id'];
		}
		if(isset($this->request->get['manu_id'])){
			$data['manu_id'] = $this->request->get['manu_id'];
		}
		if(isset($this->request->get['subcate_id'])){
			$data['subcate_id'] = $this->request->get['subcate_id'];
		}
		if(isset($this->request->get['search'])){
			$data['text_search'] = $this->request->get['search'];
		}
		
		$data['options_all'] 		= $option_all;
		$data['attribute_all'] 		= $attribute_all;
		$data['manufacturer_all'] 	= $manufacturer_all;
		$data['subcategory_all'] 	= $subcategory_all;
		if (isset($this->request->get['path']))
			$data['category_id_path'] 	= $this->request->get['path'];
		else
			$data['category_id_path'] 	= '';
		
		// Get Price Product
		$minPrice = $maxPrice = 0;
		
		if(count($products_arr_id) > 0)
		{
			$product_data = $this->model_extension_module_so_filter_shop_by->getAllProducts($category_id);
			$minPrice = $product_data[0]['price_soFilter'];
			foreach($product_data as $item)
			{
				if($item['price_soFilter'] < $minPrice)
				{
					$minPrice = $item['price_soFilter'];
				}
				if($item['price_soFilter'] > $maxPrice)
				{
					$maxPrice = $item['price_soFilter'];
				}
			}
		}
		
		$data['products_arr_id'] = implode(',',$products_arr_id);
		$data['minPrice'] = $data['minPrice_new'] = round($minPrice);
		$data['maxPrice'] = $data['maxPrice_new'] = round($maxPrice);
		
		if(isset($this->request->get['minPrice'])){
			if (!filter_var($this->request->get['minPrice'],FILTER_VALIDATE_FLOAT) || $this->request->get['minPrice'] < 0){
				$data['minPrice_new'] = $data['minPrice'];
			}else{
				$data['minPrice_new'] = $this->request->get['minPrice'];
			}
		}
		if(isset($this->request->get['maxPrice'])){
			if (!filter_var($this->request->get['maxPrice'],FILTER_VALIDATE_FLOAT) || $this->request->get['maxPrice'] < 0){
				$data['maxPrice_new'] = $data['maxPrice'];
			}else{
				$data['maxPrice_new'] = $this->request->get['maxPrice'];
			}
		}
		
		$data['obj_lang'] =  $this->language;
		
		// Get Currency 
		$this->load->model('localisation/currency');
		$data['currencies'] = "$";
		$results_currencies = $this->model_localisation_currency->getCurrencies();
		if(!empty($results_currencies)){
			foreach ($results_currencies as $result) {
				if(isset($this->session->data['currency']) && ($this->session->data['currency'] == $result['code']))
				{
					if($result['symbol_left'] != "")
					{
						$data['currencies'] = $result['symbol_left'];
					}else{
						$data['currencies'] = $result['symbol_right'];
					}
					
				}
			}
		}

		// caching
		$use_cache = (int)$setting['use_cache'];
		$cache_time = (int)$setting['cache_time'];
		$folder_cache = DIR_CACHE.'so/Filter_shop_by/';
		if(!file_exists($folder_cache))
			mkdir ($folder_cache, 0777, true);
		if (!class_exists('Cache_Lite'))
			require_once (DIR_SYSTEM . 'library/so/filter_shop_by/Cache_Lite/Lite.php');

		$options = array(
			'cacheDir' => $folder_cache,
			'lifeTime' => $cache_time
		);
		$Cache_Lite = new Cache_Lite($options);
		if ($use_cache){
			$this->hash = md5( serialize($setting));
			$_data = $Cache_Lite->get($this->hash);
			if (!$_data) {
				// Check Version
				if(version_compare(VERSION, '2.1.0.2', '>')) {
					$_data = $this->load->view('extension/module/so_filter_shop_by/default.tpl', $data);
				}else{
					$tem_url = $this->config->get('config_template') . '/template/extension/module/so_filter_shop_by/default.tpl';
					$template_file = DIR_TEMPLATE . $tem_url ? DIR_TEMPLATE . $tem_url : '';
					$_data = '';
					if (file_exists($template_file)){
						$_data = $this->load->view($tem_url, $data);
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
				return $this->load->view('extension/module/so_filter_shop_by/default.tpl', $data);
			}else{
				$tem_url = $this->config->get('config_template') . '/template/extension/module/so_filter_shop_by/default.tpl';
				$template_file = DIR_TEMPLATE . $tem_url ? DIR_TEMPLATE . $tem_url : '';
				if (file_exists($template_file)) {
					return $this->load->view($tem_url, $data);
				}
			}
		}
	}
	
	public function filter_data(){
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$this->load->model('catalog/review');
		$this->load->model('extension/module/so_filter_shop_by');
		$opt_value_id = $att_value_id = $manu_value_id = $minPrice = $maxPrice = $text_search = $subcate_value_id = "";
		if(isset($this->request->post['opt_value_id']) && $this->request->post['opt_value_id'] != ''){
			$opt_value_id = $this->request->post['opt_value_id'];
		}
		if(isset($this->request->post['att_value_id']) && $this->request->post['att_value_id'] != ''){
			$att_value_id = $this->request->post['att_value_id'];
		}
	
		if(isset($this->request->post['product_arr_all'])){
			$product_arr_all = $this->request->post['product_arr_all'];
		}
		if(isset($this->request->post['manu_value_id']) && $this->request->post['manu_value_id'] != ''){
			$manu_value_id = $this->request->post['manu_value_id'];
		}
		
		if(isset($this->request->post['minPrice'])){
			$minPrice = $this->request->post['minPrice'];
		}
		
		if(isset($this->request->post['maxPrice'])){
			$maxPrice = $this->request->post['maxPrice'];
		}
		
		if(isset($this->request->post['text_search']) && $this->request->post['text_search'] != ''){
			$text_search = $this->request->post['text_search'];
		}
		
		if(isset($this->request->post['subcate_value_id']) && $this->request->post['subcate_value_id'] != ''){
			$subcate_value_id = $this->request->post['subcate_value_id'];
		}
		
		// if(isset($this->request->post['path']) && $this->request->post['path'] != ''){
			// $cate_path = $this->request->post['path'];   
			// $cate_id_arr = explode("_",$cate_path);
			// $category_id = $cate_id_arr[count($cate_id_arr)-1];
		// }
		if (isset($this->request->post['category_id_path'])) {
			$path = '';
			$parts = explode('_', (string)$this->request->post['category_id_path']);
			$category_id = (int)array_pop($parts);
		} else {
			$category_id = 0;
		}
		
		$product_arr 		= $_POST['product_arr_all'];
		$product_data		= array();
		$data['products'] 	= array();
		$products_arr_id 	= array();
		$minPrice_new = $maxPrice_new = 0;
		$product_data = $this->model_extension_module_so_filter_shop_by->getProducts($opt_value_id,$att_value_id,$manu_value_id,$text_search,$minPrice,$maxPrice,$subcate_value_id,$category_id);
		if($product_data != "" && count($product_data) > 0){
			$minPrice_new = $maxPrice_new = $product_data[0]['price_soFilter'];
			foreach ($product_data as $result) {
				// Check Version
				if(version_compare(VERSION, '2.1.0.2', '>')) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
					}
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
					$description = utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..';
				} else {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
					}
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
					$description = utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..';
				}
								
				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => $description,
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
				$products_arr_id[] = $result['product_id'];
				if($result['price_soFilter'] < $minPrice_new)
				{
					$minPrice_new = $result['price_soFilter'];
				}
				if($result['price_soFilter'] > $maxPrice_new)
				{
					$maxPrice_new = $result['price_soFilter'];
				}
			}
		}
		
		$product_total = count($products_arr_id);
		$page = 1;
		$limit = $product_total;
		$url = '';
		
		$results 			= '';
		if($product_total > 0)
		{
			$results 			= sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));	
		}
		

		$this->load->language('extension/module/so_filter_shop_by');
		$pagination 		= '';
		$header 			= '';
		$breadcrumbs 		= array();
		$column_left 		= '';
		$column_right 		= '';
		$content_top 		= '';
		$heading_title 		= '';
		$thumb 				= '';
		$description 		= '';
		$categories 		= '';
		$compare 			= '';
		$text_compare 		= '';
		$button_list 		= '';
		$button_grid 		= '';
		$text_sort 			= '';
		$text_limit 		= '';
		$text_tax 			= '';
		$text_empty 		= $this->language->get('text_empty');
		$button_wishlist 	= '';
		$button_cart 		= $this->language->get('button_cart');
		$button_compare 	= '';
		$content_bottom 	= '';
		$footer 			= '';
		$sorts 				= array();
		$limits 			= array();
		$products 			= $data['products'];
		$continue 			= $this->url->link('common/home');
		$button_continue 	= $this->language->get('button_continue');
		$result 				= new stdClass();
		$result->product_arr 	= implode(",",$products_arr_id);
		$result->minPrice_new 	= round($minPrice_new);
		$result->maxPrice_new 	= round($maxPrice_new);
		ob_start();
		if(version_compare(VERSION, '2.1.0.2', '>')) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('theme_default_directory') . '/template/product/category.tpl')) {
				include(DIR_TEMPLATE .$this->config->get('theme_default_directory') . '/template/product/category.tpl');
			} else {
				include(DIR_TEMPLATE .'default/template/product/category.tpl');
			}
		}else{
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
				include(DIR_TEMPLATE .$this->config->get('config_template') . '/template/product/category.tpl');
			} else {
				include(DIR_TEMPLATE .'default/template/product/category.tpl');
			}
		}
		
		$buffer = ob_get_contents();
		$result->html = preg_replace(
			array(
					'/ {2,}/',
					'/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'
			),
			array(
					' ',
					''
			),
			$buffer
		);
		ob_end_clean();
		die (json_encode($result));
	}
	
	public function convertNameToParam($string) {
		//Lower case everything
		$string = strtolower($string);
		//Make alphanumeric (removes all other characters)
		$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
		//Clean up multiple dashes or whitespaces
		$string = preg_replace("/[\s-]+/", " ", $string);
		//Convert whitespaces and underscore to dash
		$string = preg_replace("/[\s_]/", "-", $string);
		return $string;
	}
	
	
}
?>