<?php
/**************************************************************/
/*	@copyright	OCTemplates 2018.							  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */

/**************************************************************/

class ControllerOctemplatesBlogSetting extends Controller {
    private $error = array();
    
    public function index() {
        $data = array();
        
        $data = array_merge($data, $this->load->language('octemplates/blog_setting'));
        
        $this->load->model('setting/setting');
        $this->load->model('extension/extension');
        $this->load->model('user/user_group');
        $this->load->model('octemplates/blog_setting');
        $this->load->model('localisation/language');
        
        $scripts = array();
        
        if (version_compare(VERSION, '2.3.0.2', '<')) {
            $scripts[] = 'http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js';
        }
        
        if (version_compare(VERSION, '2.3.0.2', '>=')) {
            $scripts[] = 'view/javascript/summernote/summernote.js';
            $scripts[] = 'view/javascript/summernote/opencart.js';
        }
        
        foreach ($scripts as $script) {
            if ($script) {
                $this->document->addScript($script);
            }
        }
        
        $styles = array();
        
        if (version_compare(VERSION, '2.3.0.2', '<')) {
            $styles[] = 'http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css';
        }
        
        if (version_compare(VERSION, '2.3.0.2', '>=')) {
            $styles[] = 'view/javascript/summernote/summernote.css';
        }
        
        foreach ($styles as $style) {
            if ($style) {
                $this->document->addStyle($style);
            }
        }
        
        $data['languages'] = array();
        
        foreach ($this->model_localisation_language->getLanguages() as $language) {
            if (version_compare(VERSION, '2.1.0.2', '<=')) {
                $data['languages'][] = $languages[] = array(
                    'language_id' => $language['language_id'],
                    'code' => $language['code'],
                    'name' => $language['name'],
                    'image' => 'view/image/flags/' . $language['image']
                );
            } else {
                $data['languages'][] = $languages[] = array(
                    'language_id' => $language['language_id'],
                    'code' => $language['code'],
                    'name' => $language['name'],
                    'image' => 'language/' . $language['code'] . '/' . $language['code'] . '.png'
                );
            }
        }
        
        if (!in_array('oct_blog_setting', $this->model_extension_extension->getInstalled('octemplates'))) {
            
            $this->model_octemplates_blog_setting->installTables();
            
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'octemplates/blog_setting');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'octemplates/blog_setting');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'octemplates/blog_category');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'octemplates/blog_category');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'octemplates/blog_article');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'octemplates/blog_article');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'octemplates/blog_comments');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'octemplates/blog_comments');
            
            foreach ($languages as $language) {
                $default_language_data[$language['language_id']] = array(
                    'seo_title' => '',
                    'seo_meta_description' => '',
                    'seo_meta_keywords' => '',
                    'seo_h1' => '',
                    'seo_description' => ''
                );
            }
            
            $this->model_setting_setting->editSetting('oct_blog_setting', array(
                'oct_blog_setting_data' => array(
                    'status' => '1',
                    'comment_moderation' => '1',
                    'desc_limit' => '280',
                    'main_image_width' => '1000',
                    'main_image_height' => '760',
                    'main_image_popup_width' => '500',
                    'main_image_popup_height' => '500',
                    'sub_image_width' => '228',
                    'sub_image_height' => '228',
                    'r_p_image_width' => '228',
                    'r_p_image_height' => '228',
                    'r_a_image_width' => '258',
                    'r_a_image_height' => '220',
                    'a_image_width_in_category' => '400',
                    'a_image_height_in_category' => '300',
                    'comment_write' => '1',
                    'comment_show' => '1',
                    'c_image_width' => '80',
                    'c_image_height' => '80',
                    'language' => $default_language_data
                )
            ));
            
            $this->model_extension_extension->install('octemplates', 'oct_blog_setting');
            
            $this->response->redirect($this->url->link('octemplates/blog_setting', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('oct_blog_setting', $this->request->post);
            
            $this->session->data['success'] = $this->language->get('text_success');
            
            $this->response->redirect($this->url->link('octemplates/blog_setting', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->session->data['warning'])) {
            $data['warning'] = $this->session->data['warning'];
            
            unset($this->session->data['warning']);
        } else {
            $data['warning'] = '';
        }
        
        $data['error_warning']                    = (isset($this->error['warning'])) ? $this->error['warning'] : '';
        $data['error_seo_title']                  = (isset($this->error['seo_title'])) ? $this->error['seo_title'] : '';
        $data['error_seo_meta_description']       = (isset($this->error['seo_meta_description'])) ? $this->error['seo_meta_description'] : '';
        $data['error_seo_meta_keywords']          = (isset($this->error['seo_meta_keywords'])) ? $this->error['seo_meta_keywords'] : '';
        $data['error_seo_h1']                     = (isset($this->error['seo_h1'])) ? $this->error['seo_h1'] : '';
        $data['error_seo_description']            = (isset($this->error['seo_description'])) ? $this->error['seo_description'] : '';
        $data['error_desc_limit']                 = (isset($this->error['desc_limit'])) ? $this->error['desc_limit'] : '';
        $data['error_main_image_width']           = (isset($this->error['main_image_width'])) ? $this->error['main_image_width'] : '';
        $data['error_main_image_height']          = (isset($this->error['main_image_height'])) ? $this->error['main_image_height'] : '';
        $data['error_main_image_popup_width']     = (isset($this->error['main_image_popup_width'])) ? $this->error['main_image_popup_width'] : '';
        $data['error_main_image_popup_height']    = (isset($this->error['main_image_popup_height'])) ? $this->error['main_image_popup_height'] : '';
        $data['error_sub_image_width']            = (isset($this->error['sub_image_width'])) ? $this->error['sub_image_width'] : '';
        $data['error_sub_image_height']           = (isset($this->error['sub_image_height'])) ? $this->error['sub_image_height'] : '';
        $data['error_r_p_image_width']            = (isset($this->error['r_p_image_width'])) ? $this->error['r_p_image_width'] : '';
        $data['error_r_p_image_height']           = (isset($this->error['r_p_image_height'])) ? $this->error['r_p_image_height'] : '';
        $data['error_r_a_image_width']            = (isset($this->error['r_a_image_width'])) ? $this->error['r_a_image_width'] : '';
        $data['error_r_a_image_height']           = (isset($this->error['r_a_image_height'])) ? $this->error['r_a_image_height'] : '';
        $data['error_a_image_width_in_category']  = (isset($this->error['a_image_width_in_category'])) ? $this->error['a_image_width_in_category'] : '';
        $data['error_a_image_height_in_category'] = (isset($this->error['a_image_height_in_category'])) ? $this->error['a_image_height_in_category'] : '';
        $data['error_c_image_width']              = (isset($this->error['c_image_width'])) ? $this->error['c_image_width'] : '';
        $data['error_c_image_height']             = (isset($this->error['c_image_height'])) ? $this->error['c_image_height'] : '';
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('octemplates/blog_setting', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['action']    = $this->url->link('octemplates/blog_setting', 'token=' . $this->session->data['token'], 'SSL');
        $data['uninstall'] = $this->url->link('octemplates/blog_setting/uninstall', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel']    = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['oct_blog_setting_data'])) {
            $data['oct_blog_setting_data'] = $this->request->post['oct_blog_setting_data'];
        } else {
            $data['oct_blog_setting_data'] = $this->config->get('oct_blog_setting_data');
        }
        
        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');
        
        $data['data_feed'] = HTTP_CATALOG . 'index.php?route=octemplates/blog_category/sitemap';
        
        $this->response->setOutput($this->load->view('octemplates/blog_setting.tpl', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'octemplates/blog_setting')) {
            $this->error['warning']         = $this->language->get('error_permission');
            $this->session->data['warning'] = $this->language->get('error_permission');
        }
        
        if (isset($this->request->post['oct_blog_setting_data']['language'])) {
            foreach ($this->request->post['oct_blog_setting_data']['language'] as $language_id => $value) {
                if ((utf8_strlen($value['seo_title']) < 1) || (utf8_strlen($value['seo_title']) > 255)) {
                    $this->error['seo_title'][$language_id] = $this->language->get('error_for_all_field');
                }
                
                if ((utf8_strlen($value['seo_h1']) < 1) || (utf8_strlen($value['seo_h1']) > 255)) {
                    $this->error['seo_h1'][$language_id] = $this->language->get('error_for_all_field');
                }
            }
        }
        
        foreach ($this->request->post['oct_blog_setting_data'] as $main_key => $field) {
            if (empty($field) && $main_key == "desc_limit") {
                $this->error['desc_limit'] = $this->language->get('error_for_all_field');
            }
            
            if (empty($field) && $main_key == "main_image_width") {
                $this->error['main_image_width'] = $this->language->get('error_for_all_field');
            }
            
            if (empty($field) && $main_key == "main_image_height") {
                $this->error['main_image_height'] = $this->language->get('error_for_all_field');
            }
            
            if (empty($field) && $main_key == "main_image_popup_width") {
                $this->error['main_image_popup_width'] = $this->language->get('error_for_all_field');
            }
            
            if (empty($field) && $main_key == "main_image_popup_height") {
                $this->error['main_image_popup_height'] = $this->language->get('error_for_all_field');
            }
            
            if (empty($field) && $main_key == "sub_image_width") {
                $this->error['sub_image_width'] = $this->language->get('error_for_all_field');
            }
            
            if (empty($field) && $main_key == "sub_image_height") {
                $this->error['sub_image_height'] = $this->language->get('error_for_all_field');
            }
            
            if (empty($field) && $main_key == "r_p_image_width") {
                $this->error['r_p_image_width'] = $this->language->get('error_for_all_field');
            }
            
            if (empty($field) && $main_key == "r_p_image_height") {
                $this->error['r_p_image_height'] = $this->language->get('error_for_all_field');
            }
            
            if (empty($field) && $main_key == "r_a_image_width") {
                $this->error['r_a_image_width'] = $this->language->get('error_for_all_field');
            }
            
            if (empty($field) && $main_key == "r_a_image_height") {
                $this->error['r_a_image_height'] = $this->language->get('error_for_all_field');
            }
            
            if (empty($field) && $main_key == "a_image_width_in_category") {
                $this->error['a_image_width_in_category'] = $this->language->get('error_for_all_field');
            }
            
            if (empty($field) && $main_key == "a_image_height_in_category") {
                $this->error['a_image_height_in_category'] = $this->language->get('error_for_all_field');
            }
            
            if (empty($field) && $main_key == "c_image_width") {
                $this->error['c_image_width'] = $this->language->get('error_for_all_field');
            }
            
            if (empty($field) && $main_key == "c_image_height") {
                $this->error['c_image_height'] = $this->language->get('error_for_all_field');
            }
        }
        
        if (isset($this->error) && $this->error) {
            $this->session->data['warning'] = $this->language->get('error_check_from');
        }
        
        return (!$this->error) ? true : false;
    }
    
    public function uninstall() {
        $this->load->language('octemplates/blog_setting');
        
        $this->load->model('extension/extension');
        
        $this->model_extension_extension->uninstall('octemplates', 'oct_blog_setting');
        
        $this->load->model('octemplates/blog_setting');
        
        $this->model_octemplates_blog_setting->deleteTables();
        
        $this->session->data['success'] = $this->language->get('text_success_uninstall');
        
        $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
    }
}