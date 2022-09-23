<?php
class ControllerExtensionModuleSoBasicProducts extends Controller {
	protected $hash = null;
	public function index($setting) {
		$this->load->language('extension/module/so_basic_products');
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('extension/module/so_basic_products');
		$this->load->model('tool/image');
		$this->document->addStyle('catalog/view/javascript/so_basic_products/css/style.css');		
		// Config default 
		$default = array(
			'objlang'				=> $this->language,
			'name' 					=> '',
			'head_name' 			=> '',
			'action' 				=> '',
			'module_description'	=> array(),
			'disp_title_module'		=> '1',
			'status'				=> '1',
			'class_suffix'			=> '',
			'type_layout'		=> '0',
			'item_link_target'		=> '_blank',
			'nb_column0'			=> '4',
			'nb_column1'			=> '4',
			'nb_column2'			=> '3',
			'nb_column3'			=> '2',
			'nb_column4'			=> '1',
			'categorys'				=> array(),
			'child_category'		=> '1',
			'category_depth'		=> '1',
			'product_sort'			=> 'p.price',
			'product_ordering'		=> 'ASC',
			'limitation'			=> '6',
			'display_title'			=> '1',
			'title_maxlength'		=> '50',
			'display_description'	=> '1',
			'description_maxlength' => '100',
			'display_price'			=> '1',
			'display_add_to_cart'	=> '1',
			'display_wishlist' 		=> '1',
			'display_compare'		=> '1',
			'display_rating'		=> '1',
			'display_sale'			=> '1',
			'display_new'			=> '1',
			'date_day'				=> '7',
			'product_image_num' 	=> '1',
			
			'product_image'			=> '1',
			'product_get_image_data'=> '1',
			'product_get_image_image'=> '1',
			'width'					=> '200',
			'height'				=> '200',
			'product_placeholder_path'		=> 'nophoto.png',
			
			'post_text'				=> '',
			'pre_text'				=> '',
			'use_cache'				=> '0',
			'cache_time'			=> '3600'
		);
		
		$data =  array_merge($default,$setting);//check data empty setting
		if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
			$data['head_name'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['head_name'], ENT_QUOTES, 'UTF-8');
		}else{
			$data['head_name']  = html_entity_decode($setting['head_name'], ENT_QUOTES, 'UTF-8');
		}
		// Get Category list
		$str_categorys = self::getCategoryChild($setting);
		// Get Product
		if($str_categorys != ''){
			$data['products']= self::getProducts($setting, $str_categorys);
		}else{
			$data['products'] = array();
		}
		// caching
		$use_cache = (int)$setting['use_cache'];
		$cache_time = (int)$setting['cache_time'];
		$folder_cache = DIR_CACHE.'so/BasicProducts/';
		if(!file_exists($folder_cache))
			mkdir ($folder_cache, 0777, true);
		if (!class_exists('Cache_Lite'))
			require_once (DIR_SYSTEM . 'library/so/basic_products/Cache_Lite/Lite.php');

		$options = array(
			'cacheDir' => $folder_cache,
			'lifeTime' => $cache_time
		);
		$Cache_Lite = new Cache_Lite($options);
		if ($use_cache){
			$this->hash = md5( serialize($setting));
			$data_view = $Cache_Lite->get($this->hash);
			if (!$data_view) {
				$data_view = $this->getLayoutMod('so_basic_products',$data,$data['type_layout']);
				$Cache_Lite->save($data_view);
				return  $data_view;
			} else {
				return  $data_view;
			}
		}else{
			if(file_exists($folder_cache))
			$Cache_Lite->_cleanDir($folder_cache);
			return $this->getLayoutMod('so_basic_products',$data,$data['type_layout']);
		}
	}
	//=== Theme Custom Code====
	public function getLayoutMod($name=null,$data,$type_layout){
		
		$log_directory  = DIR_TEMPLATE.$this->config->get('theme_default_directory').'/template/extension/module/'.$name;
		if (is_dir($log_directory)) {
			$files = scandir($log_directory);
			foreach ($files as  $value) {
				if (strpos($value, '.tpl') == true) {
					$fileNames[] = $value;
				}
			}
		} 
		$fileNames = isset($fileNames) ? $fileNames : '';
		foreach($fileNames as $option_id => $option_value){
			if($option_id == $type_layout){
				$type_morelayout = $this->load->view('extension/module/'.$name.'/'.$option_value, $data);
			}
		}
		return $type_morelayout;
	}
	public function getCategoryChild($setting){
		// check lại category nếu người dùng unpublic category sau khi cấu hình
		$category_list = array();
		
		foreach($setting['category'] as $category_item){
			$checkCategory = $this->model_extension_module_so_basic_products->checkCategory($category_item);
			if(isset($checkCategory) && $checkCategory != null &&  $checkCategory[0]['status'] == 1 ){
				$category_list[] =  $category_item;
			}
		}
		if($category_list != null){
			if($setting['child_category']){
				for($i=1; $i<=$setting['category_depth'];$i++){
					foreach ($category_list as $categorys){
						$filter_data = array(
							'category_id'  => $categorys,
						);
						$categoryss = $this->model_extension_module_so_basic_products->getCategories_son($filter_data);
						foreach ($categoryss as $category){
							$category_list[]  = $category['category_id'];
						}
					}
				}
			}
			$category_list = array_unique($category_list);
		}
		$str_categorys = implode(",",$category_list);
		return $str_categorys;
	}
	
	public function getProducts($setting, $str_categorys){
		$filter_data = array(
			'filter_category_id'  => $str_categorys,
			'sort'         => $setting['product_sort'],
			'order'        => $setting['product_ordering'],
			'limit'        => $setting['limitation'] ,
			'start'        => '0' 
		);
		$data['products'] = array();
		$products_arr = $this->model_extension_module_so_basic_products->getProducts_basic_products($filter_data);
		
		foreach($products_arr as $product_info){
			// get image
			$product_image = $this->model_extension_module_so_basic_products->getImageProduct_basic_products($product_info['product_id']);
			$product_image_first = array_shift($product_image);
			$image2 = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
			if($product_image_first != null){
				$image2 = $this->model_tool_image->resize($product_image_first['image'], $setting['width'], $setting['height']);
			}
			if ($product_info['image'] && $setting['product_get_image_data'] == 1) {
				$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
			}elseif($product_image_first['image'] && $setting['product_get_image_image'] == 1){
				$image = $this->model_tool_image->resize($product_image_first['image'], $setting['width'], $setting['height']);
			} else {
				$url = file_exists("image/so_basic_products/images/".$setting['product_placeholder_path']);
				if ($url) {
					$image_name = "so_basic_products/images/".$setting['product_placeholder_path'];
				} else {
					$image_name = "no_image.png";
				}
				$image = $this->model_tool_image->resize($image_name, $setting['width'], $setting['height']);
			}
			// Name
			$name = $product_info['name'];
			$name_maxlength = ((strlen($product_info['name']) > $setting['title_maxlength'] && $setting['title_maxlength'] !=0)  ? utf8_substr(strip_tags(html_entity_decode($product_info['name'], ENT_QUOTES, 'UTF-8')), 0, $setting['title_maxlength']) . '..' : $product_info['name']);
			// Description
			$description = ((strlen($product_info['description']) > $setting['description_maxlength'] && $setting['description_maxlength'] != 0) ? utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $setting['description_maxlength']) . '..' : $product_info['description']);
			
			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$price = false;
			}

			if ((float)$product_info['special']) {
				$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$special = false;
			}

			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
			} else {
				$tax = false;
			}

			if ($this->config->get('config_review_status')) {
				$rating = $product_info['rating'];
			} else {
				$rating = false;
			}
			// Product New
			$datetimeNow = new DateTime();
			$datetimeCreate = new DateTime($product_info['date_available']);
			$interval = $datetimeNow->diff($datetimeCreate);
			$dateDay = $interval->format('%a');
			$productNew = ($dateDay <= $setting['date_day'] ? 1 : 0);
				
			$data['products'][] = array(
				'product_id'  		=> $product_info['product_id'],
				'thumb'       		=> $image,
				'thumb2'       		=> $image2,
				'name'        		=> $product_info['name'],
				'name_maxlength'	=> $name_maxlength,
				'description' 		=> $product_info['description'],
				'description_maxlength'=> $description,
				'price'       		=> $price,
				'special'     		=> $special,
				'productNew'		=> $productNew,
				'tax'         		=> $tax,
				'rating'      		=> $rating,
				'href'        		=> $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
			);
		}
		return $data['products'];
	}
}