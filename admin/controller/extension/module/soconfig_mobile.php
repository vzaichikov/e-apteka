<?php
/******************************************************
 * @package	SO Theme Framework for Opencart 2.3.x
 * @author	http://www.magentech.com
 * @license	GNU General Public License
 * @copyright(C) 2008-2015 Magentech.com. All rights reserved.
*******************************************************/
 

class ControllerExtensionModuleSoconfigMobile extends Controller {

    private $error = array();
	private $demos = array();
	private $typeheader = array();
	private $typefooter = array();
	private $typelayout = array();
	 
	public function  __construct($registry) {
		parent::__construct($registry);
		
		//Dev Custom Theme
		
		$this->listColor= array(
			'red'    =>'#ea3a3c',
			'orange' =>'#ff5c00',
			'blue'   =>'#3786c7',
			'cyan'   =>'#0f8db3',
			'green'  =>'#20bc5a',
		);
		
		
		/*id(0,1,2) ==> Store_id */
		$this->typeheader = array(
			'0'=>'Header 1 (used in Layout 1)',
			'1'=>'Header 2 (used in Layout 2)',
			'2'=>'Header 3 (used in Layout 2)',
		);
		
		$this->typelayouts = array(
			array(
			'key'=>'0',
			'typelayout'=>'<p>Mobile Layout 1</p> <p class="font-small">(Header - Type 1)</p>',
			'typeheader'=> array('key'=>'0', 'title'=>'Header 1 (used in Layout 1)'),
			),
			array(
			'key'=>'1',
			'typelayout'=>'<p>Mobile Layout 2</p> <p class="font-small">(Header - Type 2)</p>',
			'typeheader'=> array('key'=>'1', 'title'=>'Header 2 (used in Layout 2)'),
			),
			array(
			'key'=>'2',
			'typelayout'=>'<p>Mobile Layout 3 </p><p class="font-small">(Header - Type 3,Footer - Type 3)</p>',
			'typeheader'=> array('key'=>'2', 'title'=>'Header 3 (used in Layout 3)'),
			),
			
		);
		
		//End Dev Custom Theme
	}
	
    public function index() {
		// Load language
		$this->load->language('extension/module/soconfig_mobile');
		$data['objlang'] = $this->language;
		
		// Load breadcrumbs
	
		$store_id = isset($this->request->get['store_id']) ? (int)$this->request->get['store_id'] : 0;
		
		// Load model
		$this->load->model('setting/store');
		$this->load->model('soconfig/setting');
		$this->load->model('design/layout');
		$this->load->model('localisation/language');
		$this->load->model('tool/image');
		$this->load->model('catalog/information');
		 
		// Load CSS & JS
		$this->document->setTitle($this->language->get('heading_title_normal'));
		$this->document->addScript('view/javascript/bs-colorpicker/js/colorpicker.js');
		$this->document->addScript('view/javascript/summernote/summernote.js');
		$this->document->addScript('view/javascript/theme/jquery.cookie.js');
		$this->document->addScript('view/javascript/theme/theme.js');
		
        $this->document->addStyle('view/javascript/bs-colorpicker/css/colorpicker.css');
        $this->document->addStyle('view/javascript/summernote/summernote.css');
        
		// Check RTL Css
		$data['direction'] = $this->language->get('direction');
        if ($data['direction'] != 'rtl') $this->document->addStyle('view/stylesheet/theme.css');
        $this->document->addStyle('view/stylesheet/banner-effect.css');
		
		
		/* stores adding */
        $stores = $this->model_setting_store->getStores();
		$store_data = array(
			'store_id' => '0',
			'name'     => $this->config->get('config_name'),
		);
		$data['store'] = $store_data;
		/* end stores adding */

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_soconfig_setting->editMobile('so_mobile', $this->request->post);	
			
			// buttonForm apply
			if($this->request->post['buttonForm'] == 'color' ){
				$data['scsscompile'] = $this->request->post['mobile_general']['scsscompile'];
				
				if(!$data['scsscompile']){
					$this->session->data['success'] = 'Success Compile Sass File To Css';
					$this->soconfig->scss_compassMobile($this->request->post['mobile_general']['colorHex'],$this->request->post['mobile_general']['nameColor'],$this->request->post['mobile_general']['compilemuticolor'],$this->listColor);
					unset($this->request->post['buttonForm']);
					$this->response->redirect($this->url->link('extension/module/soconfig_mobile', 'token=' . $this->session->data['token'], 'SSL'));
				}else{
					$this->session->data['success'] = 'Error: Compile Sass File To Css, Select Performace -> SCSS Compile = Off';
				}
				
			}elseif ($this->request->post['buttonForm'] == 'apply') {
				$this->session->data['success'] = $this->language->get('text_success');
                $this->response->redirect($this->url->link('extension/module/soconfig_mobile', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
                $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
            }
			
		}
		
		$default = array(
			'mobilelayout' 			=> '1',
			'nameColor' 			=> 'blue',
			'colorHex' 				=> '673199',
			'listcolor' 				=> 'blue',
			'platforms_mobile' 			=> '1',
			'logomobile'	=> 'nophoto.png',
			'backtop' 				=> '1',
			'barnav' 				=> '1',
			'copyright'		=> 'Copyright demo © 2017 by opencartworks.com',
			'mobileheader'	=> '1',
			'barmore_status'=> '1',
			'footermenus'		=> array(
				array('name'=>'Menu Demo', 'link'=>'#','sort'=>'1'),
			),
			'listmenus'		=> array(
				array('name'=>'Page Brands', 'link'=>'#','sort'=>'1'),
			),
			'body_status'	=> 'google',
			'normal_body'	=> 'inherit',
			'url_body'	=> 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,700',
			'family_body'	=> 'Open Sans, sans-serif;',
			'selector_body'	=> 'body',
			
			'category_more'	=> '1',
			'compare_status'	=> '0',
			'wishlist_status'	=> '0',
			'addcart_status'	=> '0',
			'scsscompile'	=> '0',
			'scssformat'	=> '0',
			'compilemuticolor'	=> '0',
			
		);
		if (($this->request->server['REQUEST_METHOD'] != 'POST') || $this->request->server['REQUEST_METHOD'] == 'POST' && !$this->validate() ) {
			$module_info = $this->model_soconfig_setting->getMobile('so_mobile');	
			
			$module_info =  array_merge($default,$module_info);//check data empty database
			
		}
		$data['module'] = $module_info;
		
		$data['listmenus'] = $this->sortArray($module_info['listmenus'], 'sort');
		$data['footermenus'] = $module_info['footermenus'];

		// ---------------------------Load module --------------------------------------------
		$data['clear_cache_href'] = $this->url->link('extension/module/soconfig/clearcache', 'token=' . $this->session->data['token'].'&store_id='.$store_id, 'SSL');
		$data['clear_css_href'] = $this->url->link('extension/module/soconfig/clearcss', 'token=' . $this->session->data['token'].'&store_id='.$store_id, 'SSL');
		$data['compiled_css'] = $this->url->link('extension/module/soconfig/compiled_css', 'token=' . $this->session->data['token'].'&store_id='.$store_id, 'SSL');
		
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['theme_version'] = $this->language->get('theme_version');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
        if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_description'] = $this->language->get('entry_description');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['entry_status'] = $this->language->get('entry_status');
		$data['help_code'] = $this->language->get('help_code');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		
		$data['oc_layouts'] = $this->model_design_layout->getLayouts();
		$data['do'] = isset($this->request->get['do']) ? $this->request->get['do'] : '';
		$data['layout'] = isset($this->request->get['layout']) ? $this->request->get['layout'] : ''; 
		$data['store_id']= isset($this->request->get['store_id']) ? $this->request->get['store_id'] : '';
		$data['typelayout'] = $this->typelayouts;
		
		$data['base_href'] = $this->url->link('extension/module/soconfig_mobile', 'token=' . $this->session->data['token'].'&store_id='.$store_id, 'SSL');
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token']. '&type=module', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/soconfig_mobile', 'token=' . $this->session->data['token'] . '&store_id='.$store_id, true)
		);

		$data['action'] = $this->url->link('extension/module/soconfig_mobile', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

        /*Variables for theme */
        $data['mproduct'] = $this->url->link('catalog/mproduct', 'token=' . $this->session->data['token'], 'SSL');
        $data['mcategory'] = $this->url->link('catalog/mcategory', 'token=' . $this->session->data['token'], 'SSL');
		
        /* Edit so config images */
      
        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		
		//Get Variables Theme Config
		if ($this->config->get('theme_default_directory')) $data['theme'] = $this->config->get('theme_default_directory');
		else $data['theme'] = 'default';
		
		$imgmobile 	= isset($module_info['logomobile']) ? $module_info['logomobile']: '';
		if (is_file(DIR_IMAGE.$imgmobile)) {
			$data['imgmobile'] = $this->model_tool_image->resize($imgmobile, 100, 100);
		} else {
			$data['imgmobile'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		$imgpayment 	= isset($module_info['imgpayment']) ? $module_info['imgpayment']: '';
		if (is_file(DIR_IMAGE.$imgpayment)) {
			$data['imgpayment'] = $this->model_tool_image->resize($imgpayment, 100, 100);
		} else {
			$data['imgpayment'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		$data['allThemeColor'] =  $this->soconfig->getColorMobile();
		
		
        /* information pages */
        foreach ($this->model_catalog_information->getInformations() as $result) {
            $data['information_pages'][] = array(
                'title' => $result['title'],
                'information_id' => $result['information_id'],
                'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
            );
        }
        /* end information pages */
        $data['token'] = $this->session->data['token'];
        
        $data['languages'] = $this->model_localisation_language->getLanguages();
        /*end variables for theme */

        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('extension/soconfig/soconfig_mobile', $data));
	}
	
	public function sortArray( $data, $field ) {
		$field = (array) $field;
		uasort( $data, function($a, $b) use($field) {
			$retval = 0;
			foreach( $field as $fieldname ) {
				if( $retval == 0 ) $retval = strnatcmp( $a[$fieldname], $b[$fieldname] );
			}
			return $retval;
		} );
		return $data;
	}
	
	public function uninstall() {
       
    }
	
    public function install(){
		$this->load->model('setting/setting');
		$this->load->model('soconfig/setting');
		
		//Import sample data current theme
		$install_layout='mobile'; $store_id = 0;$home_layout =1; 
		$main_sql = DIR_SYSTEM.'soconfig/demo/'.$install_layout.'/install.php';
		if (!file_exists($main_sql)) return false;   
		include($main_sql);
		$this->session->data['success'] = $this->language->get('text_success');
    }
	
	


	public function clearcache(){
      $this->soconfig->cache->clear();
      $this->session->data['success'] = 'Cache cleared';
      $this->response->redirect($this->url->link('extension/module/soconfig_mobile', 'token=' . $this->session->data['token'], 'SSL'));
    }
	
	public function clearcss(){
      $this->soconfig->cache->clear_css();
      $this->session->data['success'] = 'Cache cleared';
      $this->response->redirect($this->url->link('extension/module/soconfig_mobile', 'token=' . $this->session->data['token'], 'SSL'));
	 
    }
	
	public function install_demo_data($stores, $store_id,$install_layout,$home_layout){
		if ($home_layout == 0) return false;
		
		$install_layout_exists = false;
		foreach($this->demos as $demo){
		if ($demo['key'] == $install_layout)
		  $install_layout_exists = true;
		}

		if (!$install_layout_exists) return false;
		$main_sql = DIR_SYSTEM.'soconfig/demo/'.$install_layout.'/install.php';
		if (!file_exists($main_sql)) return false;   
		
		include($main_sql);
		return true;  
    }
	
	public function getColorScheme() {
		$json = array();
		if (isset($this->request->get['filter_name'])) {
			$filter_data = $this->request->get['filter_name'];
			$results = $this->soconfig->getColorScheme($filter_data);
			
			if(!empty($results)){
				foreach ($results as $result) {
					$json[] = array(
						'name'        => html_entity_decode($result, ENT_QUOTES, 'UTF-8')
					);
				}
			}else{
				$json[] = array(
					'name'        => 'No Value'
				);
			}
			
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
    protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/soconfig')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
}
