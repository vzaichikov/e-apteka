<?php
require_once (DIR_TEMPLATE.'extension'.DIRECTORY_SEPARATOR.'module'.DIRECTORY_SEPARATOR.'so_page_builder'.DIRECTORY_SEPARATOR.'data.php');
require_once (DIR_TEMPLATE.'extension'.DIRECTORY_SEPARATOR.'module'.DIRECTORY_SEPARATOR.'so_page_builder'.DIRECTORY_SEPARATOR.'addElement.php');
require_once (DIR_TEMPLATE.'extension'.DIRECTORY_SEPARATOR.'module'.DIRECTORY_SEPARATOR.'so_page_builder'.DIRECTORY_SEPARATOR.'formField.php');
require_once (DIR_TEMPLATE.'extension'.DIRECTORY_SEPARATOR.'module'.DIRECTORY_SEPARATOR.'so_page_builder'.DIRECTORY_SEPARATOR.'shortcodes-func.php');

class ControllerExtensionModuleSopagebuilder extends Controller {
	private $error = array();
	private $data = array();
	public function index() {
		// Load language
		$this->load->language('extension/module/so_page_builder');
		$data['objlang'] = $this->language;
		// Load breadcrumbs
		$data['breadcrumbs'] = $this->_breadcrumbs();
		// Load model
		$this->load->model('setting/setting');
		$this->load->model('catalog/category');
		$this->load->model('extension/module');
		$this->load->model('extension/module/so_page_builder');
		$this->document->setTitle($this->language->get('heading_title'));
		
		//add js + css
		$this->document->addStyle('view/javascript/so_page_builder/js/ui/jquery-ui.min.css');
		$this->document->addStyle('view/javascript/so_page_builder/css/farbtastic.css');
		$this->document->addStyle('view/javascript/so_page_builder/css/simpleslider.css');
		$this->document->addStyle('view/javascript/so_page_builder/css/style.css');
		$this->document->addScript('view/javascript/summernote/summernote.js');
		$this->document->addStyle('view/javascript/summernote/summernote.css');
		$this->document->addScript('view/javascript/so_page_builder/js/ui/jquery-ui.min.js');
		$this->document->addScript('view/javascript/so_page_builder/js/farbtastic.js');
		$this->document->addScript('view/javascript/so_page_builder/js/simpleslider.js');
		$this->document->addScript('view/javascript/so_page_builder/js/so_page_builder.js');
		// Delete Module
		if( isset($this->request->get['module_id']) && isset($this->request->get['delete']) && $this->checkPermission()){
			$this->model_extension_module->deleteModule( $this->request->get['module_id'] );
			/*Delete file css for Module Id*/
			$file = '../catalog/view/javascript/so_page_builder/css/style_render_'. $this->request->get['module_id'].'.css';
			unlink($file);
			$this->response->redirect($this->url->link('extension/module/so_page_builder', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		// Get module id new 
		$moduleid_new= $this->model_extension_module_so_page_builder->getModuleId(); // Get module id
		$module_id = '';
		$action = isset($this->request->post["action"]) ? $this->request->post["action"] : "";
		unset($this->request->post['action']);
		/* Import Simple Data */
		if($action == 'import_data'){
			$import_theme = $this->request->post["import_theme"];
			if($import_theme != 0){ /*Check not select theme*/
				if($this->checkPermission()){
					$module_id = $moduleid_new[0]['Auto_increment'];
					$config_url = $this->config->get('config_url') ;
					$dataExtensions = array(
						'module_id' => $module_id,
						'config_url' => $config_url
					); 
					$setting = $this->model_extension_module_so_page_builder->importSimpleData($import_theme,$dataExtensions); //Import theme
					$setting_json = json_decode($setting);
					$this->session->data['success'] = $this->language->get('text_success_import_data');
					//Write file 
					$file = '../catalog/view/javascript/so_page_builder/css/style_render_'.$module_id.'.css';
					// Open the file to get existing content
					$openFile = fopen($file, 'w');
					$current = file_get_contents($file);
					/*Css default*/
					$css = '.container-fluid{padding:0; overflow:hidden;}';
					$current = $css."\n";
					// Write the contents back to the file
					file_put_contents($file, $current);
					$this->writeCss(json_decode($setting_json->page_builder),$module_id); // write file css
					fclose($openFile); // close file
				}else{
					$this->session->data['warning'] = $this->language->get('error_permission');
					if(isset($this->request->get['module_id'])){
						$module_id = $this->request->get['module_id'];
					}
				}
			}else{
				$this->session->data['warning'] = $this->language->get('error_import_data');
				if(isset($this->request->get['module_id'])){
					$module_id = $this->request->get['module_id'];
				}
			}
			if($module_id != ''){
				$this->response->redirect($this->url->link('extension/module/so_page_builder', 'module_id='.$module_id.'&token=' . $this->session->data['token'], 'SSL'));
			}else{
				$this->response->redirect($this->url->link('extension/module/so_page_builder', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}else{
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($this->request->post['get_form_shortcodes']) && $this->validate() ) {
				$data = $this->request->post;
				// change config column - row
				foreach ($this->request->post['page_builder'] as $key => $value) {
					$this->request->post['page_builder'] = (htmlspecialchars_decode($value['config']));
					break;
				}
				/*Css default*/
				$css = '.container-fluid{padding:0; overflow:hidden;}';
				if (!isset($this->request->get['module_id'])) {
					$module_id = $moduleid_new[0]['Auto_increment'];
					$this->request->post['moduleid'] = $module_id;
					//Write file 
					$file = '../catalog/view/javascript/so_page_builder/css/style_render_'.$module_id.'.css';
					// Open the file to get existing content
					$openFile = fopen($file, 'w');
					$current = file_get_contents($file);
					$current = $css."\n";
					// Write the contents back to the file
					file_put_contents($file, $current);
					$this->writeCss(json_decode($this->request->post['page_builder']),$module_id); // write file css
					fclose($openFile); // close file
					$this->model_extension_module->addModule('so_page_builder', $this->request->post);
				} else {
					$module_id = $this->request->get['module_id'];
					$this->request->post['moduleid'] = $module_id;
					//Write file 
					$file = '../catalog/view/javascript/so_page_builder/css/style_render_'.$module_id.'.css';
					$openFile = fopen($file, 'w');
					// Open the file to get existing content
					$current = file_get_contents($file);
					$current = $css."\n";
					// Write the contents back to the file
					file_put_contents($file, $current);
					$this->writeCss(json_decode($this->request->post['page_builder']),$module_id);// write file css
					fclose($openFile); // close file
					
					$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
				}
				$this->session->data['success'] = $this->language->get('text_success');
				if($action == "save_edit") {
					$this->response->redirect($this->url->link('extension/module/so_page_builder', 'module_id='.$module_id.'&token=' . $this->session->data['token'], 'SSL'));
				}elseif($action == "save_new"){
					$this->response->redirect($this->url->link('extension/module/so_page_builder', 'token=' . $this->session->data['token'], 'SSL'));
				}else{
					$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
				}
			}
		}
		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/so_page_builder', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('extension/module/so_page_builder', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');
		$default = array(
			'name' 					=> '',
			'action' 				=> '',
			'status'				=> '1',
			'page_builder' 			=> ''
		);
		//Get form Shortcode
		if($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->post['get_form_shortcodes']) && $this->request->post['get_form_shortcodes'] == 1){
			$shortcode = $this->request->post['shortcode'];
			$desc = $this->request->post['desc'];
			$name = $this->request->post['name'];
			$content = '';
			if(isset ($this->request->post['content']) && $this->request->post['content'] != ''){
				$content = json_decode(htmlspecialchars_decode($this->request->post['content']),true);
			}
			$database['category'] = $this->model_catalog_category->getCategories(0);
			$database['language'] = $this->language;
			$this->load->model('localisation/language');
			$database['languages'] = $this->model_localisation_language->getLanguages();
			$database['language_id'] = $this->config->get('config_language_id') ;
			if (defined("HTTPS_CATALOG")) {
				$database['url'] = defined(HTTPS_CATALOG) ? HTTPS_CATALOG : HTTP_CATALOG;
			} else {
				$database['url'] = HTTPS_SERVER;
			}
			$database['dem'] = 0;
			$return = array();
			$return['html'] = AddElementShortcodes::yt_shortcodes_FormElement($shortcode,$name,$desc,$content,$this->language,$database);
			echo json_encode($return);die();
		}elseif($action != 'import_data'){
			if ((isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST') && !isset($this->request->get['get_form_shortcodes'])) || ($this->request->server['REQUEST_METHOD'] == 'POST' && !$this->validate() && isset($this->request->get['module_id']) && !isset($this->request->get['get_form_shortcodes']))) {
				$module_info = $default;
				$module_info = array_merge($module_info,$this->model_extension_module->getModule($this->request->get['module_id']));
				$data['action'] = $this->url->link('extension/module/so_page_builder', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
				
				$data['subheading'] = $this->language->get('text_edit_module') . $module_info['name'];
				$data['selectedid'] = $this->request->get['module_id'];
			} else {
				$module_info = $default;
				if($this->request->post != null){
					foreach ($this->request->post['page_builder'] as $key => $value) {
						$this->request->post['page_builder'] = ( htmlspecialchars_decode($value['config']) );
						break;
					}
					$module_info = array_merge($module_info,$this->request->post);
					
				}
				
				$data['selectedid'] = 0;
				$data['action'] = $this->url->link('extension/module/so_page_builder', 'token=' . $this->session->data['token'], 'SSL');
				$data['subheading'] = $this->language->get('text_create_new_module');
			}
		}
		$data['token'] 			= $this->session->data['token'];
		$this->load->model('localisation/language');
		$data['languages'] 		= $this->model_localisation_language->getLanguages();
		$data['languagesDefault'] = $this->config->get('config_language_id') ;
		$data['extensions'] 	= $this->_getModuleInstall();
		$data['shortcoders'] 	= $this->_getShortcoders();
		$data['groupsYT'] 		= YT_Data::groups($this->language);
		
		
		
		// Save and Stay --------------------------------------------------------------
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		$data['error']			= $this->error;
		
		if (isset($this->session->data['warning'])) {
			$data['error']['warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		}
		$data['text_layout'] = sprintf($this->language->get('text_layout'), $this->url->link('design/layout', 'token=' . $this->session->data['token'], 'SSL'));

		// ---------------------------Load module --------------------------------------------
		
		$data['modules'] = array( 0=> $module_info );
		
		$data['moduletabs'] = $this->model_extension_module->getModulesByCode( 'so_page_builder' );
		$data['link'] = $this->url->link('extension/module/so_page_builder', 'token=' . $this->session->data['token'] . '', 'SSL');

		
		//Get Data Default
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
				
		//Data 
		
		$data['olang'] = $this->language;
		$data['ourl'] = $this->url;
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		//----------------------------------
		$this->response->setOutput($this->load->view('extension/module/so_page_builder.tpl', $data));
	}
	
	/* List module Install */
	public function _getModuleInstall(){
		$this->load->model('extension/module/so_page_builder');
		$this->load->model('extension/module');
		$data['extensions'] = array();
		
		// Get a list of installed modules
		$extensions = $this->model_extension_module_so_page_builder->getInstalled('module');
		
		// Add all the modules which have multiple settings for each module
		foreach ($extensions as $code) {
			if( $code=="so_page_builder"){
				continue;
			}
			$this->load->language('extension/module/' . $code);
		
			$module_data = array();
			
			$modules = $this->model_extension_module->getModulesByCode($code);
			
			foreach ($modules as $module) {
				$module_data[] = array(
					//'name' => strip_tags( $this->language->get('heading_title') ) . ' &gt; ' . $module['name'],
					'name' 	=> $module['name'],
					'code' 	=> $code . '.' .  $module['module_id'],
					'id' 	=>  $module['module_id']
				);
			}
			
			if( $modules  ){
				if ($this->config->has($code . '_status') || $module_data) {
					$data['extensions'][$code] = array(
						'name'   => strip_tags( $this->language->get('heading_title') ),
						'code'   => $code,
						'module' => $module_data

					);
				}
			}	
		}
		return $data['extensions'];
	}
	
	/* List shortcode*/
	public function _getShortcoders(){
		$shortcoders = array(
			'accordion'  		=> array(
				'name'			=> $this->language->get('shortcode_accordion'),
				'desc'			=> $this->language->get('shortcode_accordion_desc'),
				'group'     	=> 'box',
				'icon'			=> "list-ul"
			),
			'box'				=>array(
				'name'     		=> $this->language->get('shortcode_box'),
				'desc'     		=> $this->language->get('shortcode_box_desc'),
				'group'     	=> 'box',
				'icon'     		=> "list-alt"
			),
			// 'buttons'			=>array(
				// 'name'     		=> $this->language->get('shortcode_buttons'),
				// 'desc'     		=> $this->language->get('shortcode_buttons_desc'),
				// 'group'     	=> 'content',
				// 'icon'     		=> "square"
			// ),
			'contact_form'		=> array(
				'name'   		=> $this->language->get('shortcode_contact_form'),
				'desc'   		=> $this->language->get('shortcode_contact_form_desc'),
				'group'     	=> 'content',
				'icon'   		=> "envelope"
			),
			'content_slider'	=> array(
				'name'   		=> $this->language->get('shortcode_content_slider'),
				'desc'   		=> $this->language->get('shortcode_content_slider_desc'),
				'group'     	=> 'extra gallery',
				'icon'   		=> "desktop"
			),
			'countdown'			=> array(
				'name'   		=> $this->language->get('shortcode_countdown'),
				'desc'   		=> $this->language->get('shortcode_countdown_desc'),
				'group'     	=> 'box',
				'icon'   		=> "sort-numeric-desc"
			),
			'counter'			=> array(
				'name'   		=> $this->language->get('shortcode_counter'),
				'desc'   		=> $this->language->get('shortcode_counter_desc'),
				'group'     	=> 'box',
				'icon'   		=> "sort-numeric-asc"
			),
			'feature_box'		=> array(
				'name'   		=> $this->language->get('shortcode_feature_box'),
				'desc'   		=> $this->language->get('shortcode_feature_box_desc'),
				'group'  		=> 'box',
				'icon'   		=> "list-ol"
			),
			'flickr'			=> array(
				'name'   		=> $this->language->get('shortcode_flickr'),
				'desc'   		=> $this->language->get('shortcode_flickr_desc'),
				'group'  		=> 'extra content',
				'icon'   		=> "flickr"
			),
			'gallery' 			=> array(
				'name'			=> $this->language->get('shortcode_gallery'),
				'desc'			=> $this->language->get('shortcode_gallery_desc'),
				'group'     	=> 'box',
				'icon'			=> "photo"
			),
			'google_map' 		=> array(
				'name'			=> $this->language->get('shortcode_google_map'),
				'desc'			=> $this->language->get('shortcode_google_map_desc'),
				'group'     	=> 'box',
				'icon'			=> "map-marker"
			),
			'html' 		=> array(
				'name'			=> $this->language->get('shortcode_html'),
				'desc'			=> $this->language->get('shortcode_html_desc'),
				'group'     	=> 'box',
				'icon'			=> "html5"
			),
			'image_carousel'	=> array(
				'name'			=> $this->language->get('shortcode_image_carousel'),
				'desc'			=> $this->language->get('shortcode_image_carousel_desc'),
				'group'     	=> 'gallery',
				'icon'			=> "newspaper-o"
			),
			'lightbox' 			=> array(
				'name'			=> $this->language->get('shortcode_lightbox'),
				'desc'			=> $this->language->get('shortcode_lightbox_desc'),
				'group'     	=> 'gallery',
				'icon'			=> "arrows-alt"
			),
			'pricing_tables' 	=> array(
				'name'			=> $this->language->get('shortcode_pricing_table'),
				'desc'			=> $this->language->get('shortcode_pricing_table_desc'),
				'group'     	=> 'extra box',
				'icon'			=> "table"
			),
			'product_carousel'	=> array(
				'name'			=> $this->language->get('shortcode_product_carousel'),
				'desc'			=> $this->language->get('shortcode_product_carousel_desc'),
				'group'     	=> 'gallery',
				'icon'			=> "shopping-cart"
			),
			'skills' => array(
				'name'		=> $this->language->get('shortcode_our_skills'),
				'desc'		=> $this->language->get('shortcode_our_skills_desc'),
				'group'     => 'box',
				'icon'		=> "align-left"
			),
			'social_icon' => array(
				'name'		=> $this->language->get('shortcode_social_icons'),
				'desc'		=> $this->language->get('shortcode_social_icons_desc'),
				'group'     => 'content',
				'icon'		=> "twitter"
			),
			'tabs' => array(
				'name'		=> $this->language->get('shortcode_tabs'),
				'desc'		=> $this->language->get('shortcode_tabs_desc'),
				'group'     => 'box',
				'icon'		=> "folder"
			),
			'testimonial' => array(
				'name'		=> $this->language->get('shortcode_testimonial'),
				'desc'		=> $this->language->get('shortcode_testimonial_desc'),
				'group'     => 'content',
				'icon'		=> "comment"
			),
		);
		return $shortcoders;
	}

	/* Write file css*/
	public function writeCss($rows,$module_id){ 
        foreach( $rows as $rkey =>  $row ){
			$this->styleRow($row,$module_id);
            foreach( $row->cols as $ckey => $col ){
				foreach( $col->widgets as  $wkey => $w ){
                   if( isset($w->module) ){
	               		if( isset($w->type) && $w->type == "shortcode" && isset($w->content)){
							$this->callShortcode($w,$module_id);
	               		}
                   }
                }
				$this->styleColumn($col,$module_id);
                if( isset($col->rows) ){
					$this->writeCss( $col->rows,$module_id);     
                }
            }
        }
        return true;
    }
	
	/* Get style in Column*/
	protected function styleColumn($col,$module_id){
        $col = $this->getStyles( $col );
		$css = "";
		if(isset($col->style) && $col->style != ''){
			$css = ".".$col->text_class_id."{".$col->style."; overflow:hidden;}";
		}
		if( isset($col->text_color) && $col->text_color != '#000000'){
			$css .= ".".$col->text_class_id." .so-desc,.".$col->text_class_id." p,.".$col->text_class_id." span,.".$col->text_class_id." div{color:".$col->text_color."}";
		}
		if( isset($col->link_color) && $col->link_color != '#000000'){
			$css .= ".".$col->text_class_id." .so-link,.".$col->text_class_id." h1 a,.".$col->text_class_id." h2 a,.".$col->text_class_id." h3 a,.".$col->text_class_id." h4 a,.".$col->text_class_id." h5 a,.".$col->text_class_id." h6 a,.".$col->text_class_id." a{color:".$col->link_color."}";
		}else{
			if( isset($col->text_color) && $col->text_color != '#000000' ){
				$css .= ".".$col->text_class_id." .so-link,.".$col->text_class_id." a{color:".$col->text_color."}\n";
			}
		}
		if( isset($col->link_hover_color) && $col->link_hover_color != '#000000'){
			$css .= ".".$col->text_class_id." .so-link:hover,.".$col->text_class_id." h1 a:hover,.".$col->text_class_id." h2 a:hover,.".$col->text_class_id." h3 a:hover,.".$col->text_class_id." h4 a:hover,.".$col->text_class_id." h5 a:hover,.".$col->text_class_id." h6 a:hover,.".$col->text_class_id." a:hover{color:".$col->link_hover_color."}\n";
		}
		if( isset($col->heading_color) && $col->heading_color != '#000000' ){
			$css .= ".".$col->text_class_id." .so-heading,.".$col->text_class_id." h1,.".$col->text_class_id." h2,.".$col->text_class_id." h3,.".$col->text_class_id." h4,.".$col->text_class_id." h5,.".$col->text_class_id." h6{color:".$col->heading_color."}\n";
		}else{
			if( isset($col->text_color) && $col->text_color != '#000000' ){
				$css .= ".".$col->text_class_id." .so-heading,.".$col->text_class_id." h1,.".$col->text_class_id." h2,.".$col->text_class_id." h3,.".$col->text_class_id." h4,.".$col->text_class_id." h5,.".$col->text_class_id." h6{color:".$col->text_color."}\n";
			}
		}
		if($css != ""){
			$file = '../catalog/view/javascript/so_page_builder/css/style_render_'.$module_id.'.css';
			// Open the file to get existing content
			$current = file_get_contents($file);
			// Append a new person to the file
			$current .= $css."\n";
			// Write the contents back to the file
			file_put_contents($file, $current);
		}
        return $col;
	}

	/* Get style in Row*/
	public function styleRow($row,$module_id){
		$row = $this->getStyles( $row );
		$css = "";
		
		if(isset($row->row_section) && ($row->row_section_class != '' || $row->row_section_id != '') && $row->section_background_type != 0){
			if( isset($row->section_bg_color) && $row->section_bg_color && $row->section_background_type == 1){
				$section_style = 'background-color:'.yt_get_plugin_color($row->section_bg_color,$row->section_bg_opacity);
			}
			if( isset($row->section_bg_image) && $row->section_bg_image && $row->section_background_type == 2){
				$background_size = ($row->section_bg_scale != '' ? ';background-size:'.$row->section_bg_scale.'' : '');
				$section_style = 'background-image:url(\'../../../../../image/'.$row->section_bg_image.'\');background-repeat:'.$row->section_bg_repeat.'; background-position:'.$row->section_bg_position.'; background-attachment:'.$row->section_bg_attachment.' '.$background_size.'';
			}
			if($row->row_section_class != ''){
				$css .= ".".$row->row_section_class."{".$section_style.";}\n";
			}else{
				$css .= "#".$row->row_section_id."{".$section_style.";}\n";
			}
			
		}
		if(isset($row->style) && $row->style != ''){
			$css .= ".".$row->text_class_id."{".$row->style."; overflow:hidden;}\n";
		}
		if( isset($row->text_color) && $row->text_color != '#000000' ){
			$css .= ".".$row->text_class_id." .so-desc,.".$row->text_class_id." p,.".$row->text_class_id." span,.".$row->text_class_id." div{color:".$row->text_color."}\n";
		}
		if( isset($row->link_color) && $row->link_color != '#000000' ){
			$css .= ".".$row->text_class_id." .so-link,.".$row->text_class_id." h1 a,.".$row->text_class_id." h2 a,.".$row->text_class_id." h3 a,.".$row->text_class_id." h4 a,.".$row->text_class_id." h5 a,.".$row->text_class_id." h6 a,.".$row->text_class_id." a{color:".$row->link_color."}\n";
		}else{
			if( isset($row->text_color) && $row->text_color != '#000000' ){
				$css .= ".".$row->text_class_id." .so-link,.".$row->text_class_id." a{color:".$row->text_color."}\n";
			}
		}
		if( isset($row->link_hover_color) && $row->link_hover_color != '#000000' ){
			$css .= ".".$row->text_class_id." .so-link:hover,.".$row->text_class_id." h1 a:hover,.".$row->text_class_id." h2 a:hover,.".$row->text_class_id." h3 a:hover,.".$row->text_class_id." h4 a:hover,.".$row->text_class_id." h5 a:hover,.".$row->text_class_id." h6 a:hover,.".$row->text_class_id." a:hover{color:".$row->link_hover_color."}\n";
		}
		if( isset($row->heading_color) && $row->heading_color != '#000000' ){
			$css .= ".".$row->text_class_id." .so-heading,.".$row->text_class_id." h1,.".$row->text_class_id." h2,.".$row->text_class_id." h3,.".$row->text_class_id." h4,.".$row->text_class_id." h5,.".$row->text_class_id." h6{color:".$row->heading_color."}\n";
		}else{
			if( isset($row->text_color) && $row->text_color != '#000000' ){
				$css .= ".".$row->text_class_id." .so-heading,.".$row->text_class_id." h1,.".$row->text_class_id." h2,.".$row->text_class_id." h3,.".$row->text_class_id." h4,.".$row->text_class_id." h5,.".$row->text_class_id." h6{color:".$row->text_color."}\n";
			}
		}
		if($css != ""){
			$file = '../catalog/view/javascript/so_page_builder/css/style_render_'.$module_id.'.css';
			// Open the file to get existing content
			$current = file_get_contents($file);
			// Append a new person to the file
			$current .= $css."\n";
			// Write the contents back to the file
			file_put_contents($file, $current);
		}
		return $row;
	}
	
	/* Get style for Column & Row*/
	protected function getStyles( $data ){
		$styles = array();
		if( isset($data->padding) && $data->padding != ''){
			$styles[]= 'padding:'.$data->padding;
		}
		if( isset($data->margin) && $data->margin != ''){
			$styles[]= 'margin:'.$data->margin;
		}
		
		if($data->background_type != 0)
		{
			if( isset($data->bg_color) && $data->bg_color && $data->background_type == 1){
				$styles[] = 'background-color:'.yt_get_plugin_color($data->bg_color,$data->bg_opacity);
			}
			if( isset($data->bg_image) && $data->bg_image && $data->background_type == 2){
				$background_size = ($data->bg_scale != '' ? ';background-size:'.$data->bg_scale.'' : '');
				$styles[] = 'background-image:url(\'../../../../../image/'.$data->bg_image.'\');background-repeat:'.$data->bg_repeat.'; background-position:'.$data->bg_position.'; background-attachment:'.$data->bg_attachment.' '.$background_size.'';
			}
		}
		
		if( !empty($styles) ){
			$data->style = implode(";", $styles);
		}
		return $data; 
	}
	
	/*--------------------------------------------------------------------------------------------------*/
	/* Shortcode Attr*/
	function ytshortcode_atts($pairs, $atts) {
		$atts =(array)$atts;
		$out  = array();
		
		foreach($pairs as $name => $default) {
			if(array_key_exists($name, $atts))
				$out[$name] = $atts[$name];
			else
				$out[$name] = $default;
		}
		return $out;
	}
	
	/* Call Shortcode */
	protected function callShortcode($shortcode,$module_id){
		$nameShortcode = $shortcode->shortcode;
		$content =  json_decode(html_entity_decode($shortcode->content));
		$contentP = $content->cparent;
		$contentC = $content->cchild;
		$func_shortcode = $nameShortcode.'YTShortcode';
		add_ytshortcode($nameShortcode);
		$database = array();
		$database['language'] = $this->language;
		$this->load->model('localisation/language');
		$database['languages'] 	= $this->model_localisation_language->getLanguages();
		$database['language_id'] = $this->config->get('config_language_id') ;
		if (defined("HTTPS_CATALOG")) {
			$database['url'] = defined(HTTPS_CATALOG) ? HTTPS_CATALOG : HTTP_CATALOG;
		} else {
			$database['url'] = HTTPS_SERVER;
		}
		$func_shortcode($contentP[0],$contentC,$module_id,$shortcode->module,$database);
		return ;
	}
	/*--------------------------------------------------------------------------------------------------*/
	
	protected function validate(){
		if (!$this->user->hasPermission('modify', 'extension/module/so_page_builder')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		return !$this->error;
	}

	public function _breadcrumbs(){
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL')
		);

		if (!isset($this->request->get['module_id'])) {
			$this->data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/so_page_builder', 'token=' . $this->session->data['token'], 'SSL')
			);
		} else {
			$this->data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/so_page_builder', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);
		}
		return $this->data['breadcrumbs'];
	}
	
	public function checkPermission(){
		if (!$this->user->hasPermission('modify', 'extension/module/so_page_builder')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	
	public function updateData($inp) { 
		if(is_array($inp)) 
			return array_map(__METHOD__, $inp); 

		if(!empty($inp) && is_string($inp)) { 
			return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp); 
		} 

		return $inp; 
	}
}
