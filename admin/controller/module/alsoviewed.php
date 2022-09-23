<?php
class ControllerModulealsoViewed extends Controller { 
	private $error = array(); 
	public function index() {   	
		$this->language->load('module/alsoviewed');
        $this->load->model('module/alsoviewed');
		$this->load->model('setting/store');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
		$this->document->addStyle('view/stylesheet/alsoviewed.css'); 	
		
		if(!isset($this->request->get['store_id'])) {
           $this->request->get['store_id'] = 0; 
        }
		$store = $this->getCurrentStore($this->request->get['store_id']);

		if ($this->request->server['REQUEST_METHOD'] == 'POST') { 

			if (!$this->user->hasPermission('modify', 'module/alsoviewed')) {
				$this->validate();
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}
			if (!empty($_POST['OaXRyb1BhY2sgLSBDb21'])) {
				$this->request->post['alsoviewed']['LicensedOn'] = $_POST['OaXRyb1BhY2sgLSBDb21'];
			}
			if (!empty($_POST['cHRpbWl6YXRpb24ef4fe'])) {
				$this->request->post['alsoviewed']['License'] = json_decode(base64_decode($_POST['cHRpbWl6YXRpb24ef4fe']),true);
			}
		
			$this->model_module_alsoviewed->editSetting('alsoviewed', $this->request->post, $this->request->post['store_id']);

			$this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('module/alsoviewed', 'store_id='.$this->request->post['store_id'] . '&token=' . $this->session->data['token'], 'SSL'));
			
			if (!empty($_GET['activate'])) {
				$this->session->data['success'] = $this->language->get('text_success_activation');
			}
			
			$selectedTab = (empty($this->request->post['selectedTab'])) ? 0 : $this->request->post['selectedTab'];
			$this->response->redirect($this->url->link('module/alsoviewed', 'token=' . $this->session->data['token'] . '&tab='.$selectedTab, 'SSL'));
		}
		
		
		$alsoViewedStats = $this->db->query("SELECT * FROM `" . DB_PREFIX . "alsoviewed` ORDER BY `number` DESC LIMIT 100");
		
		$data['alsoViewedStats'] = $alsoViewedStats->rows;
		
		$this->load->model('catalog/product'); 
		$this->load->model('tool/image');
		foreach ($data['alsoViewedStats'] as $k=>$v) { 
		
		if (!empty($v['high']) && (!empty($v['low'])) ) {
		
			$data['alsoViewedStats'][$k]['highProduct'] = $this->model_catalog_product->getProduct($v['high']);	
			if(isset($data['alsoViewedStats'][$k]['highProduct']['image'])){
				$data['alsoViewedStats'][$k]['highProduct']['image'] = $this->model_tool_image->resize($data['alsoViewedStats'][$k]['highProduct']['image'], 80, 80);
			}
			$data['alsoViewedStats'][$k]['lowProduct'] = $this->model_catalog_product->getProduct($v['low']);	
			if(isset($data['alsoViewedStats'][$k]['lowProduct']['image'])){
				$data['alsoViewedStats'][$k]['lowProduct']['image'] = $this->model_tool_image->resize($data['alsoViewedStats'][$k]['lowProduct']['image'], 80, 80);
			}
		} else {
		 unset($data['alsoViewedStats'][$k]);
		}
		}
	
		
        $languageVariables = array(
			// Main
			'heading_title',
			'error_permission',
			'text_success',
			'text_load_in_selector',
			'text_enabled',
			'text_disabled',
			'button_cancel',
			'button_save',
			'save_changes',
			'text_default',
			'text_module',
			// Control panel
			'entry_code',
			'entry_code_help',
			'entry_enable_disable',
			'text_content_top', 
			'text_content_bottom',
			'text_column_left', 
			'text_column_right',
			'entry_layout',         
			'entry_position',       
			'entry_status',         
			'entry_sort_order',     
			'entry_layout_options',  
			'entry_position_options',
			'entry_action_options',
			'button_add_module',
			'button_remove',
			'entry_api',
			'entry_secret',
			'entry_preview',
			'entry_design',
			'entry_no_design',
			'entry_wrap_into_widget',
			'entry_yes',
			'entry_no',
			'entry_wrapper_title',
			'entry_button_name',
			'entry_use_oc_settings',
			'entry_assign_to_cg',
			'entry_new_user_details',
			'entry_custom_css',
			// Custom CSS
			'custom_css',
			'custom_css_help',
			'custom_css_placeholder',
			// Module depending
			'wrap_widget',
			'wrap_widget_help',
			'text_products',
			'text_products_help',
			'text_image_dimensions',
			'text_image_dimensions_help',
			'text_pixels',
			'text_panel_name',
			'text_panel_name_help',
			'text_products_small',
			'show_add_to_cart',
			'show_add_to_cart_help',
			'custom_positioning',
			'custom_positioning_below',
			'custom_positioning_no',
			'intelligent_sorting',
			'intelligent_sorting_help',	
			'purchases',
			'viewed_together',
        );
       
        foreach ($languageVariables as $languageVariable) {
            $data[$languageVariable] = $this->language->get($languageVariable);
        }
		
		
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		$data['languages'] = $languages;
		$firstLanguage = array_shift($languages);
		$data['firstLanguageCode'] = $firstLanguage['code'];
	
 		if (isset($this->session->data['success'])) { 	
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        if (isset($this->error['warning'])) { 
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

		$data['breadcrumbs'] = array();
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/alsoviewed', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
	
		$data['action'] = $this->url->link('module/alsoviewed', 'token=' . $this->session->data['token'], 'SSL'); 	
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		if (isset($this->request->post['alsoviewed'])) {
			foreach ($this->request->post['alsoviewed'] as $key => $value) {
				$data['data']['alsoviewed'][$key] = $this->request->post['alsoviewed'][$key];
			}
		} else {
			$configValue = $this->config->get('alsoviewed');
			$data['data']['alsoviewed'] = $configValue;		
		} 
		
        $data['token']                  = $this->session->data['token'];
		$data['moduleSettings']	= $this->model_module_alsoviewed->getSetting('alsoviewed', $store['store_id']);
		$data['data']['alsoviewed']	= isset($data['moduleSettings']['alsoviewed']) ? $data['moduleSettings']['alsoviewed'] : array ();

        $data['stores'] = array_merge(array(0 => array('store_id' => '0', 'name' => $this->config->get('config_name') . ' (' . $data['text_default'].')', 'url' => HTTP_SERVER, 'ssl' => HTTPS_SERVER)), $this->model_setting_store->getStores());
        $data['store']                  = $store;
		
		
		$data['currenttemplate'] =  $this->config->get('config_template');
     		

		$this->load->model('design/layout'); 	
		$data['layouts'] = $this->model_design_layout->getLayouts();


         if ($this->config->get('alsoviewed_status')) { 
            $data['alsoviewed_status'] = $this->config->get('alsoviewed_status'); 
        } else {
            $data['alsoviewed_status'] = '0';
        }

        $data['header']                 = $this->load->controller('common/header');
        $data['column_left']            = $this->load->controller('common/column_left');
        $data['footer']                 = $this->load->controller('common/footer');
        
		$this->response->setOutput($this->load->view('module/alsoviewed.tpl', $data)); 
    }
	
	
 	public function install()
    {
        $this->load->model('module/alsoviewed');
        $this->model_module_alsoviewed->install();
    }
    public function uninstall()
    {
		$this->load->model('setting/setting');
		
		$this->load->model('setting/store');
		$this->model_setting_setting->deleteSetting('alsoviewed_module',0);
		$stores=$this->model_setting_store->getStores();
		foreach ($stores as $store) {
			$this->model_setting_setting->deleteSetting('alsoviewed_module', $store['store_id']);
		}
        $this->load->model('module/alsoviewed');
        $this->model_module_alsoviewed->uninstall();
    }
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/alsoviewed')) {
			$this->error = true;
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	    private function getCatalogURL() {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTPS_CATALOG;
        } else {
            $storeURL = HTTP_CATALOG;
        } 
        return $storeURL;
    }

    private function getServerURL() {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTPS_SERVER;
        } else {
            $storeURL = HTTP_SERVER;
        } 
        return $storeURL;
    }

    private function getCurrentStore($store_id) {    
        if($store_id && $store_id != 0) {
            $store = $this->model_setting_store->getStore($store_id);
        } else {
            $store['store_id'] = 0;
            $store['name'] = $this->config->get('config_name');
            $store['url'] = $this->getCatalogURL(); 
        }
        return $store;
    }
	
}
?>