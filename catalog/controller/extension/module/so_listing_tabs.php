<?php
	class ControllerExtensionModuleSolistingtabs extends Controller {
		public function index($setting) {
			$module = 'so_listing_tabs';
			$this->load->language('extension/module/so_listing_tabs');
			$data['heading_title'] = $this->language->get('heading_title');
			$data['text_tax'] = $this->language->get('text_tax');
			
			$this->load->model('design/banner');
			$this->load->model('tool/image');
			$this->load->model('catalog/category');
			$this->load->model('catalog/product');
			$this->load->model('extension/module/so_listing_tabs');
			$this->document->addStyle('catalog/view/javascript/so_listing_tabs/css/so-listing-tabs.css');
			if (!defined ('OWL_CAROUSEL')){
				$this->document->addStyle('catalog/view/javascript/so_listing_tabs/css/animate.css');
				$this->document->addStyle('catalog/view/javascript/so_listing_tabs/css/owl.carousel.css');
				$this->document->addScript('catalog/view/javascript/so_listing_tabs/js/owl.carousel.js');
				define( 'OWL_CAROUSEL', 1 );
			}
			$setting['start'] = 0;
			$default = array(
			'objlang'				=> $this->language,
			'name'					=> '',
			'head_name' 			=> '',
			'action'				=> '',
			'type_layout'		=> '0',
			'module_description'	=> array(),
			'disp_title_module'		=> '1',
			'status'				=> '1',
			'class_suffix'			=> '',
			'item_link_target'		=> '_blank',
			'nb_column0'			=> '4',
			'nb_column1'			=> '4',
			'nb_column2'			=> '3',
			'nb_column3'			=> '2',
			'nb_column4'			=> '1',
			'type_show'				=> 'loadmore',
			'nb_row'				=> '1',
			
			'type_source'			=> '1',
			'categorys'				=> array(),
			'category'				=> array(),
			'child_category'		=> '1',
			'category_depth'		=> '1',
			'product_sort'			=> 'p.price',
			'product_ordering'		=> 'ASC',
			'source_limit'			=> '4',
			
			'field_product_tabs'			=> array(),
			'catid_preload'			=> '*',
			'field_product_tab'		=> '',
			'field_preload'			=> '',
			'tab_all_display'		=> '1',
			'tab_max_characters'	=> '25',
			'tab_icon_display'		=> '1',
			'cat_order_by'		=> 'name',
			'imgcfgcat_width'		=> '30',
			'imgcfgcat_height'		=> '30',
			
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
			'width'					=> '150',
			'height'				=> '200',
			'product_placeholder_path'=> 'nophoto.png',
			'display_banner_image'	=> '0',
			'banner_image'			=> 'no_image.png',
			'banner_image_url'		=> '',
			'banner_width'			=> '150',
			'banner_height'			=> '250',
			
			'margin'				=> '0',
			'autoplay'				=> '0',
			'autoplayTimeout'		=> '5000',
			'pausehover'			=> '0',
			'autoplaySpeed'			=> '1000',
			'mousedrag'				=> '1',
			'touchdrag'				=> '1',
			'display_loop'			=> '1',
			'loop'					=> '1',
			'display_nav'			=> '1',
			'navs'					=> '1',
			'navSpeed'				=> '500',
			'effect'				=> 'starwars',
			'duration'				=> '800',
			'delay'					=> '500',
			
			'post_text'				=> '',
			'pre_text'				=> '',
			'use_cache'				=> '0',
			'cache_time'			=> '3600',
			
			'direction'				=> ($this->language->get('direction') == 'rtl' ? 'true' : 'false'),
			'direction_class'		=> ($this->language->get('direction') == 'rtl' ? 'so-listing-tabs-rtl' : 'so-listing-tabs-ltr')
			);
			
			
			$data =  array_merge($default,$setting);//check data empty setting
			if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
				$data['head_name'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['head_name'], ENT_QUOTES, 'UTF-8');
				}else{
				$data['head_name']  = html_entity_decode($setting['head_name'], ENT_QUOTES, 'UTF-8');
			}
			$this->load->model('localisation/language');
			$data['languages'] = $this->model_localisation_language->getLanguages();
			$data['theme_dir']	= $this->config->get('theme_default_directory');
			// Source Option
			$_catids__ = (array)self::processCategory($setting['category']);
			$category_id_list = array();
			if (!empty($_catids__)){
				$category_id_list = self::getCategoryson($_catids__,$setting);
			}
			
			$data['setting'] 			= serialize($setting);
			$data['module_id'] 			= $setting['moduleid'];
			$data['start']				= $setting['start'];
			$data['category_id_list'] 	= implode(',',$category_id_list);
			$data['tag_id'] 			= 'so_listing_tabs_'.$data['moduleid'];
			$data['autoplay'] 			= (int)$setting['autoplay'] > 0 ? 'true' : 'false' ;
			$data['display_nav'] 		= (int)$setting['display_nav'] > 0 ? 'true' : 'false' ;
			$data['display_loop'] 		= (int)$setting['display_loop'] > 0 ? 'true' : 'false' ;
			$data['touchdrag'] 			= (int)$setting['touchdrag'] > 0 ? 'true' : 'false' ;
			$data['mousedrag'] 			= (int)$setting['mousedrag'] > 0 ? 'true' : 'false' ;
			$data['pausehover'] 		= (int)$setting['pausehover'] > 0 ? 'true' : 'false' ;
			$data['class_ltabs'] 		= 'ltabs00-' . $setting['nb_column0'] . ' ltabs01-' . $setting['nb_column1'] . ' ltabs02-' . $setting['nb_column2'] . ' ltabs03-' . $setting['nb_column3'] .' ltabs04-' . $setting['nb_column4'] ;
			$data['nb_rows'] 			= (int)$setting['nb_row'];
			if($data['display_banner_image'] != 0){
				$data['banner_image'] 		= $this->model_tool_image->resize($setting['banner_image'], $setting['banner_width'], $setting['banner_height']);
			}
			
			$text_config = array(
			'product_catalog_refine',
			'product_catalog_refine_col_lg',
			'product_catalog_refine_col_md',
			'product_catalog_refine_col_sm',
			'product_catalog_refine_col_xs',
			'deals_today',
			'lsttitle_cate_status',
			'lstimg_cate_status',
			'product_catalog_mode',
			'product_catalog_column_lg',
			'product_catalog_column_md',
			'product_catalog_column_sm',
			'product_catalog_column_xs',
			'secondimg',
			'rating_status',
			'lstdescription_status',
			'sale_status',
			'new_status',
			'days',
			'quick_status',
			'discount_status',
			'countdown_status',
			'sale_text',
			'new_text',
			'quick_view_text',
			'scroll_animation',
			
			);
			foreach ($text_config as $text ) {
				$data[$text] = $this->soconfig->get_settings($text);
			}
			
			$module_id 					= $setting['moduleid'];
			// caching
			$use_cache = (int)$setting['use_cache'];
			$cache_time = (int)$setting['cache_time'];
			$folder_cache = DIR_CACHE.'so/ListingTabs/';
			if(!file_exists($folder_cache))
			mkdir ($folder_cache, 0777, true);
			if (!class_exists('Cache_Lite'))
			require (DIR_SYSTEM . 'library/so/listing_tabs/Cache_Lite/Lite.php');
			$options = array(
			'cacheDir' => $folder_cache,
			'lifeTime' => $cache_time
			);
			$Cache_Lite = new Cache_Lite($options);
			// load ajax
			$is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
			if($is_ajax && isset($_POST['is_ajax_listing_tabs']) && $_POST['is_ajax_listing_tabs']){
				
				$setting 					= unserialize($_POST['setting']);
				$setting['start'] 			= $_POST['ajax_reslisting_start'];
				$start						= $setting['start'];
				$product_image 				= $setting['product_image'];
				$display_banner_image 		= (isset($setting['display_banner_image']) ? $setting['display_banner_image'] : 0);
				if($display_banner_image != 0){
					$banner_image 				= $this->model_tool_image->resize($setting['banner_image'], $setting['banner_width'], $setting['banner_height']);
					$banner_image_url 			= $setting['banner_image_url'];
				}
				$display_title				= $setting['display_title'];
				$display_description		= $setting['display_description'];
				$display_price 				= (int)$setting['display_price'] ;
				$display_add_to_cart 		= (int)$setting['display_add_to_cart'] ;
				$display_wishlist 			= (int)$setting['display_wishlist'] ;
				$display_compare 			= (int)$setting['display_compare'] ;
				$item_link_target 			= $setting['item_link_target'];
				$objlang 					= $this->language;
				$tag_id						= 'so_listing_tabs_'.$_POST['lbmoduleid'];
				$type_show					= $setting['type_show'];
				
				$nb_column0 				= $setting['nb_column0'];
				$nb_column1 				= $setting['nb_column1'];
				$nb_column2 				= $setting['nb_column2'];
				$nb_column3 				= $setting['nb_column3'];
				$nb_column4 				=  $setting['nb_column4'];
				$effect						= $setting['effect'];
				$nb_rows 					= (int)$setting['nb_row'];
				$autoplay 					= (int)$setting['nb_row'] > 0 ? 'true' : 'false' ;
				$display_nav 				= (int)$setting['display_nav'] > 0 ? 'true' : 'false' ;
				$display_loop 				= (int)$setting['display_loop'] > 0 ? 'true' : 'false' ;
				$touchdrag 					= (int)$setting['touchdrag'] > 0 ? 'true' : 'false' ;
				$mousedrag 					= (int)$setting['mousedrag'] > 0 ? 'true' : 'false' ;
				$pausehover 				= (int)$setting['pausehover'] > 0 ? 'true' : 'false' ;
				$autoplayTimeout 			= (int)$setting['autoplayTimeout'] ;
				$autoplaySpeed 				= (int)$setting['autoplaySpeed'] ;
				$class_ltabs 				= 'ltabs00-' . $setting['nb_column0'] . ' ltabs01-' . $setting['nb_column0'] . ' ltabs02-' . $setting['nb_column1'] . ' ltabs03-' . $setting['nb_column2'] .' ltabs04-' . $setting['nb_column4'] ;
				$direction 					=  $this->language->get('direction') == 'rtl' ?  'true' : 'false';
				if($setting['type_source'] == "0"){
					$categoryid 	= $_POST['categoryid']; 
					$category_id 	= self::getCategoryson($categoryid ,$setting);
					$child_items 	= self::getProducts( $category_id,$setting);
					}else{
					$catids 					= $setting['category'];
					$_catids 					= (array)self::processCategory($catids);
					$category_id_list 			= self::getCategoryson($_catids,$setting);
					$setting['product_sort'] 	= $_POST['categoryid'];
					$child_items 				= self::getProducts($category_id_list,$setting);
				}
				$rl_loaded = $start;
				$tab_id = $_POST['categoryid'];
				$tab_id = $tab_id == '*' ? 'all' : $tab_id;
				$display_rating			= (int)$setting['display_rating'] ;
				$display_sale			= $setting['display_sale'];
				$display_new 			= $setting['display_new'];
				$product_image_num 		= (int)$setting['product_image_num'];
				$result = new stdClass();
				ob_start();
				
				//=== Theme Custom Code====
				$nameLayout = $this->getNameLayout('so_listing_tabs',$data['type_layout']);
				$url_default_tdd = $this->config->get('theme_default_directory') . '/template/extension/module/so_listing_tabs/'.$nameLayout.'.tpl';
				$url_items_tdd = $this->config->get('theme_default_directory') . '/template/extension/module/so_listing_tabs/'.$nameLayout.'/'.'default_items.tpl';
				$url_tem = 'default/template/extension/module/so_listing_tabs/default_items.tpl';
				
				//=== Theme Custom Code====
				$nameLayout = $this->getNameLayout('so_listing_tabs',$setting['type_layout']);
				$theme_directory = DIR_TEMPLATE.$this->config->get('theme_default_directory');
				
				if (!file_exists($theme_directory))  $themes = 'default';
				else $themes = $this->config->get('theme_default_directory');
				
				$url_default_tdd = $themes . '/template/extension/module/so_listing_tabs/'.$nameLayout.'.tpl';
				$url_items_tdd = $themes. '/template/extension/module/so_listing_tabs/'.$nameLayout.'/'.'default_items.tpl';
				$url_tem = 'default/template/extension/module/so_listing_tabs/default_items.tpl';
				
				
				if ($use_cache){
					$cache_id = md5(serialize(array($module_id,$setting))).(int)$this->config->get('config_language_id');
					$data_ajax = $Cache_Lite->get($cache_id);
					if (!$data_ajax) {
						// Check Version
						if(file_exists(DIR_TEMPLATE . $url_default_tdd)){
							$data_ajax = DIR_TEMPLATE . $url_items_tdd ;
							}else{
							$data_ajax = DIR_TEMPLATE . $url_tem ;
						}
						$Cache_Lite->save($data_ajax);
						include  $data_ajax;
						} else {
						include  $data_ajax;
					}
					}else{
					if(file_exists($folder_cache))
					$Cache_Lite->_cleanDir($folder_cache);
					if(file_exists(DIR_TEMPLATE . $url_default_tdd)){
						include(DIR_TEMPLATE . $url_items_tdd) ;
						}else{
						include(DIR_TEMPLATE . $url_tem) ;
					}
				}
				$buffer = ob_get_contents();
				$result->items_markup = preg_replace(
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
				
				}else{
				if($setting['type_source'] == '0'){
					$data['list'] = self::getListCategoriesFilter($setting);
					}else{
					$data['list'] = self::getListArticlesFilter($setting);
				}
				// Check cache lite
				
				if ($use_cache){
					$cacheid = md5(serialize(array($module_id,$setting)));
					$_data = $Cache_Lite->get($cacheid);
					if (!$_data) {
						$_data = $this->getLayoutMod('so_listing_tabs',$data,$data['type_layout']);
						$Cache_Lite->save($_data);
						return  $_data;
						} else {
						return  $_data;
					}
					}else{
					if(file_exists($folder_cache))
					$Cache_Lite->_cleanDir($folder_cache);
					$_data = $this->getLayoutMod('so_listing_tabs',$data,$data['type_layout']);
					return  $_data;
				}
			}
		}
		//=== Theme Custom Code====
		public function getNameLayout($name=null,$type_layout){
			$theme_directory = DIR_TEMPLATE.$this->config->get('theme_default_directory');
			if (!file_exists($theme_directory))  $themes = 'default';
			else $themes = $this->config->get('theme_default_directory');
			$log_directory  = DIR_TEMPLATE.$themes.'/template/extension/module/'.$name;
			
			if (is_dir($log_directory)) {
				$files = scandir($log_directory);
				foreach ($files as  $value) {
					if (strpos($value, '.tpl') == true && strpos($value, '_') === false) {
						$fileNames[] = $value;
					}
				}
			} 
			$fileNames = isset($fileNames) ? $fileNames : '';
			foreach($fileNames as $option_id => $option_value){
				if($option_id == $type_layout){
					$type_morelayout = $option_value;
					list($fileName) = explode('.tpl',$option_value); 
				}
			}
			
			return $fileName;
		}
		public function getLayoutMod($name=null,$data,$type_layout){
			$type_morelayout ='';
			
			$theme_directory = DIR_TEMPLATE.$this->config->get('theme_default_directory');
			if (!file_exists($theme_directory))  $themes = 'default';
			else $themes = $this->config->get('theme_default_directory');
			$log_directory  = DIR_TEMPLATE.$themes.'/template/extension/module/'.$name;
			
			if (is_dir($log_directory)) {
				$files = scandir($log_directory);
				foreach ($files as  $value) {
					if (strpos($value, '.tpl') == true && strpos($value, '_') === false) {
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
		
		public function getListCategoriesFilter($setting){
			$catids = $setting['category'];
			settype($catids, 'array');
			$cat_order_by = $setting['cat_order_by'];
			
			$list = array();
			$cats = array();
			
			if (empty($catids)) return;
			$_catids = (array)self::processCategory($catids);
			if (empty($_catids)) return;
			foreach ($_catids as $cid) {
				$category = $this->model_catalog_category->getCategory($cid);
				$cats[] = $category;
				switch ($cat_order_by) {
					default:
					case 'name':
					usort($cats, create_function('$a, $b', 'return strnatcasecmp( $a["name"], $b["name"]);'));
					break;
					case 'lft':
					usort($cats, create_function('$a, $b', 'return $a->lft < $b->lft;'));
					break;
					case 'random':
					shuffle($cats);
					break;
				}
			}
			
			if ($setting['tab_all_display'] ==1) {
				$all['category_id'] = '*';
				$all['name'] = 'All Product';
				$all['image'] = '';
				array_unshift($cats, $all);
			}
			$catidpreload = $setting['catid_preload'];
			$selected = false;
			
			$_cats = array();
			foreach ($cats as $cat) {
				
				$category_id_list = self::getCategoryson($cat['category_id'],$setting);
				$filter_data = array(
				'filter_category_id'  	=> implode(',',$category_id_list),
				'sort'         			=> $setting['product_sort'],
				'order'        			=> $setting['product_ordering'],
				'limit'        			=> $setting['source_limit'],
				'start' 	   			=> $setting['start']
				);
				$cat['category_id_list'] = $category_id_list;
				$cat['count'] = $this->model_extension_module_so_listing_tabs->getTotalProducts_listing_tabs($filter_data);
				if($cat['count'] > 0){
					$_cats[] = $cat;
				}
				
			}
			
			if (empty($_cats))
			return;
			foreach($_cats as $cat) {	
				if(isset($cat['sel'])){
					unset($cat['sel']);
				}
				if ($cat['count'] > 0) {
					if ($cat['category_id'] == $catidpreload) {
						$cat['sel'] = 'sel';
						$cat['child'] = self::getProducts($cat['category_id_list'], $setting);
						$selected = true;
					}
					if($cat['image'] != null)
					{
						$cat['icon_image'] =$this->model_tool_image->resize($cat['image'], $setting['imgcfgcat_width'], $setting['imgcfgcat_height']);
						}else{
						$cat['icon_image'] =$this->model_tool_image->resize('placeholder.png', $setting['imgcfgcat_width'], $setting['imgcfgcat_height']);
					}
					$list[$cat['category_id']] = $cat;
				}
			}
			
			if (!$selected) {
				foreach ($_cats as $cat) {
					if ($cat['count'] > 0) {
						$cat['sel'] = 'sel';
						$cat['child'] = self::getProducts($cat['category_id_list'], $setting);
						if($cat['image'] != null)
						{
							$cat['icon_image'] =$this->model_tool_image->resize($cat['image'], $setting['imgcfgcat_width'], $setting['imgcfgcat_height']);
							}else{
							$cat['icon_image'] =$this->model_tool_image->resize('placeholder.png', $setting['imgcfgcat_width'], $setting['imgcfgcat_height']);
						}
						$list[$cat['category_id']] = $cat;
						break;
					}
				}
			}
			
			return $list;
		}
		
		public function getListArticlesFilter($setting){
			$catids = $setting['category'];
			$list = array();
			$cats = array();
			$_catids = (array)self::processCategory($catids);
			if(empty($_catids))
			{
				return;
			}
			
			$filters = $setting['field_product_tab'];
			$articles_filter = array();
			$filter_preload = $setting['field_preload'];
			if(empty($filters)) return;
			if(!in_array($filter_preload,$filters)) {
				foreach ($filters as $filter) {
					$filter_preload = $filter;
					break;
				}
			}
			
			$category_id_list = self::getCategoryson($_catids,$setting);
			
			foreach ($filters as $filter) {
				$filter_data = array(
				'filter_category_id'  	=> implode(',',$category_id_list),
				'sort'         			=> $setting['product_sort'],
				'order'        			=> $setting['product_ordering'],
				'limit'        			=> $setting['source_limit'],
				'start' 	   			=> $setting['start']
				);
				$aritles['count'] = $this->model_extension_module_so_listing_tabs->getTotalProducts_listing_tabs($filter_data);
				$aritles['category_id'] = $filter;
				$aritles['title'] = $this->getLabel($filter);
				array_unshift($articles_filter, $aritles);
			}
			
			foreach ($articles_filter as $filter) {
				if ($filter['count'] > 0) {
					if ($filter['category_id'] == $filter_preload) {
						$filter['sel'] = 'sel';
						$setting['product_sort'] = $filter_preload;
						$filter['child'] = self::getProducts($category_id_list, $setting);
					}
					$list[$filter['category_id']] = $filter;
				}
			}
			
			return $list;
		}
		
		public function getCategoryson($category_id, $setting){
			$category_arr = array();
			if(!is_array($category_id))
			{
				if($category_id=="*")
				{
					$category_id = $setting['category'];
					}else{
					$category_id = array($category_id);
				}
			}
			$category_arr = $category_id;
			if($setting['child_category'] ==1)
			{
				$category_arr =$category_id;
				for($i=1; $i<= (int)$setting['category_depth'];$i++)
				{
					$filter_data = array(
					'category_id'  => implode(',',$category_arr),
					'category_depth' => $setting['category_depth']
					);
					$categoryss = $this->model_extension_module_so_listing_tabs->getCategories_son_listing_tabs($filter_data);
					foreach ($categoryss as $category)
					{
						if(!in_array($category['category_id'],$category_arr))
						{
							$category_arr[] = $category['category_id'];
						}
					}
				}
			}
			
			return $category_arr;
		}
		
		public function getProducts($category_id_list,$setting){
			$list = array();
			if(is_array($category_id_list))
			{
				$filter_data = array(
				'filter_category_id'  => implode(',',$category_id_list),
				'sort'         => $setting['product_sort'],
				'order'        => $setting['product_ordering'],
				'limit'        => (int)$setting['source_limit'],
				'start' 	   => $setting['start']
				);
				}else{
				$filter_data = array(
				'filter_category_id'  => $category_id_list,
				'sort'         => $setting['product_sort'],
				'order'        => $setting['product_ordering'],
				'limit'        => (int)$setting['source_limit'],
				'start' 	   => $setting['start']
				);
			}
			
			$cat['count'] = $this->model_extension_module_so_listing_tabs->getTotalProducts_listing_tabs($filter_data);
			if ($cat['count'] > 0) 
			{
				$products_arr = $this->model_extension_module_so_listing_tabs->getProducts_listing_tabs($filter_data);
				foreach($products_arr as $product_info)
				{
					$product_image = $this->model_catalog_product->getProductImages($product_info['product_id']);
					$setting['width'] = ($setting['width'] == 0 ? "30px" : $setting['width']);
					$setting['height'] = ($setting['height'] == 0 ? "30px" : $setting['height']);
					$product_image_first = array_shift($product_image);
					$image2 = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					if($product_image_first != null)
					{
						$image2 = $this->model_tool_image->resize($product_image_first['image'], $setting['width'], $setting['height']);
					}
					if ($product_info['image'] && $setting['product_get_image_data']) {
						$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
						}elseif(isset($product_image_first['image']) && $setting['product_get_image_image']){
						$image = $this->model_tool_image->resize($product_image_first['image'], $setting['width'], $setting['height']);
						} else {
						$url = file_exists("image/so_listing_tabs/images/".$setting['product_placeholder_path']);
						if ($url) {
							$image_name = "so_listing_tabs/images/".$setting['product_placeholder_path'];
							} else {
							$image_name = "no_image.png";
						}
						$image = $this->model_tool_image->resize($image_name, $setting['width'], $setting['height']);
					}
					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						} else {
						$price = false;
					}
					
					if ((float)$product_info['special']) {
						$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						$discount = '-'.round((($product_info['price'] - $product_info['special'])/$product_info['price'])*100, 0).'%';
						} else {
						$special = false;
						$discount = false;
						
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
					$name = (($setting['title_maxlength'] != 0 && strlen($product_info['name']) > $setting['title_maxlength']) ? utf8_substr(strip_tags(html_entity_decode($product_info['name'], ENT_QUOTES, 'UTF-8')), 0, $setting['title_maxlength']) . '..' : $product_info['name']);
					$description = (($setting['description_maxlength'] != 0 && strlen($product_info['description']) > $setting['description_maxlength']) ? utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $setting['description_maxlength']) . '..' : $product_info['description']);
					
					$datetimeNow = new DateTime();
					$datetimeCreate = new DateTime($product_info['date_available']);
					$interval = $datetimeNow->diff($datetimeCreate);
					$dateDay = $interval->format('%a');
					$productNew = ($dateDay <= $setting['date_day'] ? 1 : 0);
					$cat['child'][] = array(
					'product_id'  => $product_info['product_id'],
					'thumb'       	=> $image,
					'thumb2'       	=> $image2,
					'name'        	=> $product_info['name'],
					'name_maxlength'=> $name,
					'description' 	=> $product_info['description'],
					'description_maxlength'=> $description,
					'price'       	=> $price,
					'special'     	=> $special,
					'discount'     	=> $discount,
					'productNew'	=> $productNew,	
					'tax'         	=> $tax,
					'rating'      	=> $rating,
					'date_added'  	=> $product_info['date_added'],
					'model'  	  	=> $product_info['model'],
					'quantity'    	=> $product_info['quantity'],
					'href'        	=> $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
					);
				}
				$list = $cat['child'];
			}
			return $list;
		}
		
		private  function getLabel($filter){
			switch ($filter) {
				case 'p_price' 			: return $this->language->get('value_price');
				case 'pd_name' 			: return $this->language->get('value_name');
				case 'p_model' 			: return $this->language->get('value_model');
				case 'p_quantity' 		: return $this->language->get('value_quantity');
				case 'rating' 			: return $this->language->get('value_rating');
				case 'p_sort_order' 	: return $this->language->get('value_sort_add');
				case 'p_date_added' 	: return $this->language->get('value_date_add');
				case 'sell' 			: return $this->language->get('value_sell');
			}
		}
		
		private function processCategory($catids){
			$catpubid = array();
			if (empty($catids)) return;
			foreach ($catids as $i => $cid) {
				$category = $this->model_catalog_category->getCategory($cid);
				
				$cats[$i] = $category;
				if (empty($category)) {
					unset($cats[$i]);
					} else {
					$catpubid[] = $category['category_id'];
				}
			}
			return $catpubid;
		}	
	}		