<?php
class ControllerModuleAutoTranslator extends Controller {
    private $error = array();
    private $status;
    private $log = array();
    private $moduleName 			= 'auto_translator';
    private $moduleModel 			= 'model_module_auto_translator';
    private $modulePath 			= 'module/auto_translator';
    private $moduleVersion 			= '1.3.2';

    public function index() {
        $lang_ar = $this->load->language($this->modulePath);
        foreach($lang_ar as $key => $item){
            $data[$key] = $item;
        }
        $this->load->model($this->modulePath);
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if(isset($this->request->post['auto_translator_api_key'])){
                $this->request->post['auto_translator_api_key'] = trim($this->request->post['auto_translator_api_key']);
            }
            if(isset($this->request->post['auto_translator_microsoft_key'])){
                $this->request->post['auto_translator_microsoft_key'] = trim($this->request->post['auto_translator_microsoft_key']);
            }
            $this->model_setting_setting->editSetting('auto_translator', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            if(!$this->request->post['apply']) {
                $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'] . '&type=module', 'SSL'));
            }
        }
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'] . '&type=module', true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title') . ' v' . $this->moduleVersion,
            'href' => $this->url->link($this->modulePath, 'token=' . $this->session->data['token'], true)
        );
        $data['action'] = $this->url->link($this->modulePath, 'token=' . $this->session->data['token'], true);
        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'] . '&type=module', true);
        $data['install'] =$this->url->link('extension/module/install', 'token=' . $this->session->data['token'] . '&extension=auto_translator', true);
        $data['categories'] = $this->url->link($this->modulePath . '/getCategories', 'token=' . $this->session->data['token'], 'SSL');
        $data['items'] = $this->url->link($this->modulePath . '/getItems', 'token=' . $this->session->data['token'], 'SSL');
        $data['translate'] = $this->url->link($this->modulePath . '/startTranslate', 'token=' . $this->session->data['token'], 'SSL');
        $data['get_log'] = $this->url->link($this->modulePath . '/getLog', 'token=' . $this->session->data['token'], 'SSL');
        $data['clear_log'] = $this->url->link($this->modulePath . '/clearLog', 'token=' . $this->session->data['token'], 'SSL');
        $data['notification'] = $this->url->link($this->modulePath . '/getNotification', 'token=' . $this->session->data['token'], 'SSL');
        $data['token'] = $this->session->data['token'];
        $data['auto_translator_status'] = $this->config->get('auto_translator_status');
        $data['auto_translator_source'] = $this->config->get('auto_translator_source');
        $data['auto_translator_send_interval'] = $this->config->get('auto_translator_send_interval')?$this->config->get('auto_translator_send_interval'):1000;
        $data['auto_translator_limit_item'] = $this->config->get('auto_translator_limit_item')?$this->config->get('auto_translator_limit_item'):10000;
        $data['product_fields'] = array( 
            array('id' => 'name', 'name' => $this->language->get('text_name'), 'checked' => 1),
            array('id' => 'description', 'name' => $this->language->get('text_description'), 'checked' => 1),
            array('id' => 'meta_title', 'name' => $this->language->get('text_meta_title'), 'checked' => 1),
            array('id' => 'meta_description', 'name' => $this->language->get('text_meta_description'), 'checked' => 1),
            array('id' => 'meta_keyword', 'name' => $this->language->get('text_meta_keyword'), 'checked' => 1),
            array('id' => 'tag', 'name' => $this->language->get('text_tag'), 'checked' => 1)
        );
        $data['product_attribute_fields'] = array(
            array('id' => 'text', 'name' => $this->language->get('text_product_attribute_text'), 'checked' => 1)
        );
        $data['category_fields'] = array(
            array('id' => 'name', 'name' => $this->language->get('text_name'), 'checked' => 1),
            array('id' => 'description', 'name' => $this->language->get('text_description'), 'checked' => 1),
            array('id' => 'meta_title', 'name' => $this->language->get('text_meta_title'), 'checked' => 1),
            array('id' => 'meta_description', 'name' => $this->language->get('text_meta_description'), 'checked' => 1),
            array('id' => 'meta_keyword', 'name' => $this->language->get('text_meta_keyword'), 'checked' => 1)
        );
        $data['filter_fields'] = array(
            array('id' => 'name', 'name' => $this->language->get('text_filter_name'), 'checked' => 1)
        );
        $data['filter_group_fields'] = array(
            array('id' => 'name', 'name' => $this->language->get('text_filter_group_name'), 'checked' => 1)
        );
        $data['attribute_fields'] = array(
            array('id' => 'name', 'name' => $this->language->get('text_attribute_name'), 'checked' => 1)
        );
        $data['attribute_group_fields'] = array(
            array('id' => 'name', 'name' => $this->language->get('text_attribute_group_name'), 'checked' => 1)
        );
        $data['option_fields'] = array(
            array('id' => 'name', 'name' => $this->language->get('text_option_name'), 'checked' => 1)
        );
        $data['option_value_fields'] = array(
            array('id' => 'name', 'name' => $this->language->get('text_option_value_name'), 'checked' => 1)
        );
        $data['download_fields'] = array(
            array('id' => 'name', 'name' => $this->language->get('text_download_name'), 'checked' => 1)
        );
        $data['information_fields'] = array(
            array('id' => 'title', 'name' => $this->language->get('text_title'), 'checked' => 1),
            array('id' => 'description', 'name' => $this->language->get('text_description'), 'checked' => 1),
            array('id' => 'meta_title', 'name' => $this->language->get('text_meta_title'), 'checked' => 1),
            array('id' => 'meta_description', 'name' => $this->language->get('text_meta_description'), 'checked' => 1),
            array('id' => 'meta_keyword', 'name' => $this->language->get('text_meta_keyword'), 'checked' => 1)
        );
        $data['banner_fields'] = array(
            array('id' => 'title', 'name' => $this->language->get('text_banner_title'), 'checked' => 1)
        );
        $data['recurring_fields'] = array(
            array('id' => 'name', 'name' => $this->language->get('text_recurring_name'), 'checked' => 1)
        );
        $data['customer_group_fields'] = array(
            array('id' => 'name', 'name' => $this->language->get('text_customer_group_name'), 'checked' => 1),
            array('id' => 'description', 'name' => $this->language->get('text_description'), 'checked' => 1),
        );
        $data['custom_field_fields'] = array(
            array('id' => 'name', 'name' => $this->language->get('text_custom_field_name'), 'checked' => 1)
        );
        $data['custom_field_value_fields'] = array(
            array('id' => 'name', 'name' => $this->language->get('text_custom_field_value_name'), 'checked' => 1)
        );
        $data['voucher_theme_fields'] = array(
            array('id' => 'name', 'name' => $this->language->get('text_voucher_theme_name'), 'checked' => 1)
        );
        $data['length_class_fields'] = array(
            array('id' => 'title', 'name' => $this->language->get('text_length_title'), 'checked' => 1),
            array('id' => 'unit', 'name' => $this->language->get('text_length_unit'), 'checked' => 1)
        );
        $data['weight_class_fields'] = array(
            array('id' => 'title', 'name' => $this->language->get('text_weight_title'), 'checked' => 1),
            array('id' => 'unit', 'name' => $this->language->get('text_weight_unit'), 'checked' => 1)
        );
        if ($this->request->server['REQUEST_METHOD'] != 'POST') {
            $this->load->model('setting/setting');
            $auto_translator_info = $this->model_setting_setting->getSetting('auto_translator');
            foreach ($auto_translator_info as $key => $item){
                if (isset($auto_translator_info[$key])) {
                    $data[$key] = $auto_translator_info[$key];
                } else {
                    $data[$key] = '';
                }
            }
        }
        $this->load->model('localisation/language');
        $data['languages'] = $this->model_localisation_language->getLanguages();
        $data['google_languages'] = $this->{$this->moduleModel}->getGoogleLanguages();
        $data['microsoft_languages'] = $this->{$this->moduleModel}->getMicrosoftLanguages();
        foreach ($this->request->post as $key => $item){
            if (isset($item)) {
                $data[$key] = $item;
            }
        }
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        $file = DIR_LOGS . 'auto_translator.log';
        if (file_exists($file)) {
            $data['log'] = htmlentities(file_get_contents($file, FILE_USE_INCLUDE_PATH, null));
        } else {
            $data['log'] = '';
        }
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        if(substr(VERSION, 0, 7) > '2.1.0.2'){
            $this->response->setOutput($this->load->view($this->modulePath, $data));
        } else {
            $this->response->setOutput($this->load->view($this->modulePath . '.tpl', $data));
        }
    }

    public function getLog() {
        $this->load->language($this->modulePath);
        $json = array();
        $file = DIR_LOGS . 'auto_translator.log';
        if (file_exists($file)) {
            $json['log'] = htmlentities(file_get_contents($file, FILE_USE_INCLUDE_PATH, null));
        } else {
            $json['log'] = '';
        }
        $this->response->setOutput(json_encode($json));
    }
    
    public function clearLog() {
        $this->load->language($this->modulePath);
        $json = array();
        if ($this->validate()) {
            $handle = fopen(DIR_LOGS . 'auto_translator.log', 'w+');
            fclose($handle);
            $json['success'] = $this->language->get('text_success_clear_log');
        } else {
            $json['error'] = $this->language->get('error_permission');
        }
        $this->response->setOutput(json_encode($json));
    }

    public function getCategories() {
        $this->load->model('catalog/category');
        $json = $this->model_catalog_category->getCategories();
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function getItems() {
        $data = array();
        $json = array();
        $this->load->model($this->modulePath);
        if (isset($this->request->post['category_id']) && $this->request->post['category_id'] != 'undefined' && $this->request->post['category_id'] != '') {
            $data['category_id'] = $this->request->post['category_id'];
        }
        if (isset($this->request->post['status_id']) && $this->request->post['status_id'] != 'undefined' && $this->request->post['status_id'] != '') {
            $data['status_id'] = $this->request->post['status_id'];
        }
        if (isset($this->request->post['section_id']) && $this->request->post['section_id']) {
            $section_id = $this->request->post['section_id'];
            $section = $this->getSection($section_id);
            $query = $this->{$this->moduleModel}->{$section['getFunction']}($data);
            if($query->rows){
                foreach ($query->rows as $item){
                    $json[] = array(
                        'id' => $item[$section['item_id']],
                        'name' => $item[$section['item_name']],
                        'link' => $section['item_link'] . $item[$section['item_link_id']],
                    );
                }
            }
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function getMicrosoftToken() {
        $this->load->model($this->modulePath);
        $_COOKIE['cm_token'] = '';
        if ($this->config->get('auto_translator_microsoft_key')) {
            $token = $this->{$this->moduleModel}->getСognitiveMicrosoftToken();
        } else {
            $token = $this->{$this->moduleModel}->getMicrosoftToken();
        }
        if(is_object($token)){
            if(isset($token->message)){
                $json['error'] = $this->language->get('text_error') . ': ' . $token->message;
            } else if(isset($token->error->message)){
                $json['error'] = $this->language->get('text_error') . ': ' . $token->error->message;
            } else if(isset($token->error_description)){
                $json['error'] = $this->language->get('text_error') . ': ' . $token->error_description;
            } else {
                $json['error'] = $this->language->get('error_token');
            }
        } else {
            $json['token'] = $token;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function startTranslate() {
        $this->status = true;
        $this->load->language($this->modulePath);
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateTranslate()) {
            $language_id = $this->request->post['language_id'];
            $field_list = $this->request->post['field_list'];
            $json['item_id'] = $data['item_id'] = $this->request->post['item_id'];
            if (isset($this->request->post['category_id'])) {
                $data['category_id'] = $this->request->post['category_id'];
            }
            if (isset($this->request->post['status_id']) && $this->request->post['status_id'] != '') {
                $data['status_id'] = $this->request->post['status_id'];
            }
            if (isset($this->request->post['item_list'])) {
                $data['item_list'] = $this->request->post['item_list'];
            }
            $this->load->model('localisation/language');
            $data['languages'] = $this->model_localisation_language->getLanguages();
            $data['auto_translator_source'] = $this->config->get('auto_translator_source');
            $data['auto_translator_g_language'] = $this->config->get('auto_translator_g_language');
            $data['auto_translator_m_language'] = $this->config->get('auto_translator_m_language');
            $this->load->model($this->modulePath);
            $section = $this->getSection($this->request->post['section_id']);
            $to_languages = '';
            if ($language_id) {
                $to_language = $this->model_localisation_language->getLanguage($language_id);
                $to_languages = $to_language['name'];
            } else {
                foreach ($data['languages'] as $language) {
                    if ($language['language_id'] != $data['auto_translator_source']) {
                        if ($to_languages) {
                            $to_languages .= ', ' . $language['name'];
                        } else {
                            $to_languages = $language['name'];
                        }
                    }
                }
            }
            if(!$this->request->post['iteration_id']) {
                $source_language = $this->model_localisation_language->getLanguage($data['auto_translator_source']);
                $this->log[] = $this->language->get('heading_title') . " v." . $this->moduleVersion;
                $this->log[] = $this->language->get('text_line_2') . $this->language->get('text_start');
                if ($this->config->get('auto_translator_status') == 1) {
                    $this->log[] = $this->language->get('text_translator') . ': ' . $this->language->get('text_google');
                } elseif ($this->config->get('auto_translator_status') == 2) {
                    $this->log[] = $this->language->get('text_translator') . ': ' . $this->language->get('text_microsoft');
                }

                $this->log[] = $this->language->get('text_translate_from') . ': ' . $source_language['name'];
                $this->log[] = $this->language->get('text_translate_to') . ': ' . $to_languages;
                $this->log[] = $this->language->get('text_field') . ': ' . implode(', ', $field_list);
                $this->log[] = $this->language->get('entry_section') . ': ' . $section['item_section'];
                $this->log[] = $this->language->get('text_line_1');
            }
            $query = $this->{$this->moduleModel}->{$section['getFunction']}($data);
            if($query->row){
                $item = $query->row;
                $input_arr = array();
                foreach ($field_list as $field){
                    $input_arr[] = $item[$field];
                }
                if($language_id != 0){
                    $output_arr = $this->getTranslate($language_id, $input_arr, $field_list);
                    if($output_arr){
                        $update = $this->{$this->moduleModel}->{$section['updateFunction']}($output_arr, $language_id, $item[$section['item_id']], $item[$section['item_id2']]);
                        if(!$update){
                            $this->log[] = $this->language->get('error_save_data');
                            $this->status = false;
                        }
                    }
                } else {
                    foreach ($data['languages'] as $language) {
                        if ($language['language_id'] != $data['auto_translator_source']) {
                            $output_arr = $this->getTranslate($language['language_id'], $input_arr, $field_list);
                            if ($output_arr) {
                                $update = $this->{$this->moduleModel}->{$section['updateFunction']}($output_arr, $language['language_id'], $item[$section['item_id']], $item[$section['item_id2']]);
                                if (!$update) {
                                    $this->log[] = $this->language->get('error_save_data');
                                    $this->status = false;
                                }
                            }
                        }
                    }
                }
                $this->log[] = $section['item_section'] . sprintf($this->language->get('text_item_info'), isset($item[$section['item_name']])?$item[$section['item_name']]:'', $item[$section['item_id']]);
            } else {
                $this->log[] = sprintf($this->language->get('error_item'), $data['item_id']);
                $this->status = false;
            }
            $this->log[] = $this->language->get('text_line_1') . $data['item_id'] . ($this->status?$this->language->get('text_succ'):$this->language->get('text_fail'));
            if($this->request->post['item_count'] == $this->request->post['iteration_id']+1) {
                $this->log[] = $this->language->get('text_line_2') . $this->language->get('text_stop') . "\n";
            }
            $auto_translator = new Log('auto_translator.log');
            $auto_translator->write(implode("\n", $this->log));
        }
        if (isset($this->error['error'])) {
            $json['error'] = $this->error['error'];
            $this->status = false;
        }
        $json['status'] = $this->status;
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    protected function validateTranslate(){
        if (!$this->user->hasPermission('modify', $this->modulePath)) {
            $this->error['error'] = $this->language->get('error_permission');
        }
        if (!isset($this->request->post['language_id']) || !isset($this->request->post['item_id']) || !isset($this->request->post['iteration_id']) || !isset($this->request->post['item_count'])) {
            $this->error['error'] = $this->language->get('error_operation');
        }
        if (!isset($this->request->post['section_id']) || !$this->request->post['section_id']) {
            $this->error['error'] = $this->language->get('error_section');
        }
        if (!isset($this->request->post['field_list']) || !$this->request->post['field_list']) {
            $this->error['error'] = $this->language->get('error_field_list');
        }
        if (isset($this->request->post['filter_id']) && $this->request->post['filter_id'] == 2 && !$this->request->post['item_id']) {
            $this->error['error'] = $this->language->get('error_item_id');
        }
        if (isset($this->request->post['filter_id']) &&$this->request->post['filter_id'] == 3 && !$this->request->post['item_list']) {
            $this->error['error'] = $this->language->get('error_item_list');
        }
        return !$this->error;
    }

    protected function getTranslate($language_id, $input_arr, $field_list){
        $auto_translator_status = $this->config->get('auto_translator_status');
        $google_api_key = $this->config->get('auto_translator_api_key');
        $data['auto_translator_source'] = $this->config->get('auto_translator_source');
        $data['auto_translator_g_language'] = $this->config->get('auto_translator_g_language');
        $data['auto_translator_m_language'] = $this->config->get('auto_translator_m_language');
        $from_g_lang = $data['auto_translator_g_language'][$this->config->get('auto_translator_source')];
        $from_m_lang = $data['auto_translator_m_language'][$this->config->get('auto_translator_source')];
        $output_arr = array();
        if($auto_translator_status == '1'){
            $to_g_lang = $data['auto_translator_g_language'][$language_id];
            $text = '';
            foreach ($input_arr as $input){
                if(!$text){
                    $text = urlencode(html_entity_decode($input, ENT_QUOTES, 'UTF-8'));
                } else {
                    $text .= '&q=' . urlencode(html_entity_decode($input, ENT_QUOTES, 'UTF-8'));
                }
            }
            $curlResponse = $this->curlGoogleRequest($google_api_key, $text, $from_g_lang, $to_g_lang, 'html');
            $i = 0;
            foreach ($field_list as $field){
                if(isset($curlResponse[$i]['translatedText'])){
                    $output_arr[$field] = $curlResponse[$i]['translatedText'];
                }
                $i++;
            }
        } else if($auto_translator_status == '2'){
            $to_m_lang   = $data['auto_translator_m_language'][$language_id];
            $full_length = implode(" ",$input_arr);
            if(strlen($full_length) > 9000) {
                foreach ($input_arr as $key => $item) {
                    if(strlen($item) > 9000) {
                        preg_match_all("/[\S\s]{1,5000}(?=[^>]*(<\s*\/?\s*(\w+\b)|$))(?=\s+\S*|<.+?>|$)/", html_entity_decode($item, ENT_QUOTES, 'UTF-8'), $parts);
                        foreach ($parts[0] as $part) {
                            $translateArray = $this->curlMicrosoftRequest($from_m_lang, $to_m_lang, $part);
                            if(isset($translateArray[0]['TranslatedText'])){
                                if(isset($output_arr[$field_list[$key]])) {
                                    $output_arr[$field_list[$key]] .= $translateArray[0]['TranslatedText'];
                                } else {
                                    $output_arr[$field_list[$key]] = $translateArray[0]['TranslatedText'];
                                }
                            }
                        }
                    } else {
                        $translateArray = $this->curlMicrosoftRequest($from_m_lang, $to_m_lang, $item);
                        if(isset($translateArray[0]['TranslatedText'])){
                            $output_arr[$field_list[$key]] = $translateArray[0]['TranslatedText'];
                        }
                    }
                }
            } else {
                $translateArray = $this->curlMicrosoftRequest($from_m_lang, $to_m_lang, $input_arr);
                if($translateArray){
                    $i = 0;
                    foreach ($field_list as $field){
                        if(isset($translateArray[$i]['TranslatedText'])){
                            $output_arr[$field] = $translateArray[$i]['TranslatedText'];
                        }
                        $i++;
                    }
                }
            }
        }
        return $output_arr;
    }

    protected function curlGoogleRequest($key, $text, $from, $to, $format){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,'https://translation.googleapis.com/language/translate/v2');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'key=' . $key . '&source=' . $from . '&target=' . $to . '&format=' . $format . '&q=' . $text);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: GET'));
        $curlResponse = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($curlResponse, true);
        if(isset($json['data']['translations'])){
            return $json['data']['translations'];
        } elseif ($json['error']){
            $error = $json['error']['message'] . ' ' . $json['error']['code'];
            if(isset($json['error']['errors'][0]['reason'])){
                $error .= ' / Reason: ' . $json['error']['errors'][0]['reason'];
            }
            $this->log[] = $this->language->get('text_error') . ': ' . $error;
            $this->status = false;
        } else {
            $this->log[] = $this->language->get('error_unknown_problem');
            $this->status = false;
        }
        return 0;
    }

    protected function curlMicrosoftRequest($from_m_lang, $to_m_lang, $input_arr){
        $this->load->model($this->modulePath);
        if ($this->config->get('auto_translator_microsoft_key')) {
            $token = $this->{$this->moduleModel}->getСognitiveMicrosoftToken();
        } else {
            $token = $this->{$this->moduleModel}->getMicrosoftToken();
        }
        if(is_object($token)){
            if(isset($token->message)){
                $this->log[] = $this->language->get('text_error') . ': ' . $token->message;
                $this->status = false;
            } else if(isset($token->error->message)){
                $this->log[] = $this->language->get('text_error') . ': ' . $token->error->message;
                $this->status = false;
            } else if(isset($token->error_description)){
                $this->log[] = $this->language->get('text_error') . ': ' . $token->error_description;
                $this->status = false;
            } else {
                $this->log[] = $this->language->get('error_token');
                $this->status = false;
            }
        } else {
            $text = array();
            if(is_array($input_arr)){
                foreach ($input_arr as $input) {
                    $text[] = html_entity_decode($input, ENT_QUOTES, 'UTF-8');
                }
            } else {
                $text[] = html_entity_decode($input_arr, ENT_QUOTES, 'UTF-8');
            }
            $params = array(
                'appid' => 'Bearer ' . $token,
                'options' => '{"ContentType":"text/html"}',
                'from' => $from_m_lang,
                'to' => $to_m_lang,
                'texts' => json_encode($text)
            );
            $params_string = http_build_query($params);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,'https://api.microsofttranslator.com/v2/Ajax.svc/TranslateArray?' . $params_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $curlResponse = curl_exec($ch);
            curl_close($ch);
            $curlResponse = preg_replace('/^[^\[]*\[\s*/', '[', $curlResponse);
            $objResponse = json_decode($curlResponse,true);
            if(isset($objResponse[0]['TranslatedText'])){
                return $objResponse;
            } else if(is_string($curlResponse)) {
                $this->log[] = $this->language->get('text_error') . ': ' . substr($curlResponse, 0, 140);
                $this->status = false;
            } else {
                $this->log[] = $this->language->get('error_unknown_problem');
                $this->status = false;
            }
        }
        return 0;
    }

    protected function getSection($section_id){
        $this->load->language($this->modulePath);
        $data = array();
        switch ($section_id){
            case '1':{
                $data['getFunction'] = 'getProducts';
                $data['updateFunction'] = 'updateProduct';
                $data['item_id'] = 'product_id';
                $data['item_id2'] = 'language_id';
                $data['item_name'] = 'name';
                $data['item_link'] = $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=', true);
                $data['item_link_id'] = 'product_id';
                $data['item_section'] = $this->language->get('text_product');
                break;
            }
            case '19':{
                $data['getFunction'] = 'getProductAttributes';
                $data['updateFunction'] = 'updateProductAttribute';
                $data['item_id'] = 'product_id';
                $data['item_id2'] = 'attribute_id';
                $data['item_name'] = 'text';
                $data['item_link'] = $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=', true);
                $data['item_link_id'] = 'product_id';
                $data['item_section'] = $this->language->get('text_product_attribute');
                break;
            }
            case '2':{
                $data['getFunction'] = 'getCategories';
                $data['updateFunction'] = 'updateCategory';
                $data['item_id'] = 'category_id';
                $data['item_id2'] = 'language_id';
                $data['item_name'] = 'name';
                $data['item_link'] = $this->url->link('catalog/category/edit', 'token=' . $this->session->data['token'] . '&category_id=', true);
                $data['item_link_id'] = 'category_id';
                $data['item_section'] = $this->language->get('text_category');
                break;
            }
            case '3':{
                $data['getFunction'] = 'getFilters';
                $data['updateFunction'] = 'updateFilter';
                $data['item_id'] = 'filter_id';
                $data['item_id2'] = 'filter_group_id';
                $data['item_name'] = 'name';
                $data['item_link'] = $this->url->link('catalog/filter/edit', 'token=' . $this->session->data['token'] . '&filter_group_id=', true);
                $data['item_link_id'] = 'filter_group_id';
                $data['item_section'] = $this->language->get('text_filter');
                break;
            }
            case '4':{
                $data['getFunction'] = 'getFilterGroups';
                $data['updateFunction'] = 'updateFilterGroup';
                $data['item_id'] = 'filter_group_id';
                $data['item_id2'] = 'language_id';
                $data['item_name'] = 'name';
                $data['item_link'] = $this->url->link('catalog/filter/edit', 'token=' . $this->session->data['token'] . '&filter_group_id=', true);
                $data['item_link_id'] = 'filter_group_id';
                $data['item_section'] = $this->language->get('text_filter_group');
                break;
            }
            case '5':{
                $data['getFunction'] = 'getAttributes';
                $data['updateFunction'] = 'updateAttribute';
                $data['item_id'] = 'attribute_id';
                $data['item_id2'] = 'language_id';
                $data['item_name'] = 'name';
                $data['item_link'] = $this->url->link('catalog/attribute/edit', 'token=' . $this->session->data['token'] . '&attribute_id=', true);
                $data['item_link_id'] = 'attribute_id';
                $data['item_section'] = $this->language->get('text_attribute');
                break;
            }
            case '6':{
                $data['getFunction'] = 'getAttributeGroups';
                $data['updateFunction'] = 'updateAttributeGroup';
                $data['item_id'] = 'attribute_group_id';
                $data['item_id2'] = 'language_id';
                $data['item_name'] = 'name';
                $data['item_link'] = $this->url->link('catalog/attribute_group/edit', 'token=' . $this->session->data['token'] . '&attribute_group_id=', true);
                $data['item_link_id'] = 'attribute_group_id';
                $data['item_section'] = $this->language->get('text_attribute_group');
                break;
            }
            case '7':{
                $data['getFunction'] = 'getOptions';
                $data['updateFunction'] = 'updateOption';
                $data['item_id'] = 'option_id';
                $data['item_id2'] = 'language_id';
                $data['item_name'] = 'name';
                $data['item_link'] = $this->url->link('catalog/option/edit', 'token=' . $this->session->data['token'] . '&option_id=', true);
                $data['item_link_id'] = 'option_id';
                $data['item_section'] = $this->language->get('text_option');
                break;
            }
            case '8':{
                $data['getFunction'] = 'getOptionValues';
                $data['updateFunction'] = 'updateOptionValue';
                $data['item_id'] = 'option_value_id';
                $data['item_id2'] = 'option_id';
                $data['item_name'] = 'name';
                $data['item_link'] = $this->url->link('catalog/option/edit', 'token=' . $this->session->data['token'] . '&option_id=', true);
                $data['item_link_id'] = 'option_id';
                $data['item_section'] = $this->language->get('text_option_value');
                break;
            }
            case '9':{
                $data['getFunction'] = 'getDownloads';
                $data['updateFunction'] = 'updateDownload';
                $data['item_id'] = 'download_id';
                $data['item_id2'] = 'language_id';
                $data['item_name'] = 'name';
                $data['item_link'] = $this->url->link('catalog/download/edit', 'token=' . $this->session->data['token'] . '&download_id=', true);
                $data['item_link_id'] = 'download_id';
                $data['item_section'] = $this->language->get('text_download');
                break;
            }
            case '10':{
                $data['getFunction'] = 'getInformation';
                $data['updateFunction'] = 'updateInformation';
                $data['item_id'] = 'information_id';
                $data['item_id2'] = 'language_id';
                $data['item_name'] = 'title';
                $data['item_link'] = $this->url->link('catalog/information/edit', 'token=' . $this->session->data['token'] . '&information_id=', true);
                $data['item_link_id'] = 'information_id';
                $data['item_section'] = $this->language->get('text_information');
                break;
            }
            case '11':{
                $data['getFunction'] = 'getBanners';
                $data['updateFunction'] = 'updateBanner';
                $data['item_id'] = 'banner_image_id';
                $data['item_id2'] = 'banner_id';
                $data['item_name'] = 'title';
                $data['item_link'] = $this->url->link('design/banner/edit', 'token=' . $this->session->data['token'] . '&banner_id=', true);
                $data['item_link_id'] = 'banner_id';
                $data['item_section'] = $this->language->get('text_banner');
                break;
            }
            case '12':{
                $data['getFunction'] = 'getRecurring';
                $data['updateFunction'] = 'updateRecurring';
                $data['item_id'] = 'recurring_id';
                $data['item_id2'] = 'language_id';
                $data['item_name'] = 'name';
                $data['item_link'] = $this->url->link('catalog/recurring/edit', 'token=' . $this->session->data['token'] . '&recurring_id=', true);
                $data['item_link_id'] = 'recurring_id';
                $data['item_section'] = $this->language->get('text_recurring');
                break;
            }
            case '13':{
                $data['getFunction'] = 'getCustomerGroups';
                $data['updateFunction'] = 'updateCustomerGroup';
                $data['item_id'] = 'customer_group_id';
                $data['item_id2'] = 'language_id';
                $data['item_name'] = 'name';
                if(substr(VERSION, 0, 7) > '2.0.3.1'){
                    $data['item_link'] = $this->url->link('customer/customer_group/edit', 'token=' . $this->session->data['token'] . '&customer_group_id=', true);
                }else{
                    $data['item_link'] = $this->url->link('sale/customer_group/edit', 'token=' . $this->session->data['token'] . '&customer_group_id=', true);
                }
                $data['item_link_id'] = 'customer_group_id';
                $data['item_section'] = $this->language->get('text_customer_group');
                break;
            }
            case '14':{
                $data['getFunction'] = 'getCustomFields';
                $data['updateFunction'] = 'updateCustomField';
                $data['item_id'] = 'custom_field_id';
                $data['item_id2'] = 'language_id';
                $data['item_name'] = 'name';
                if(substr(VERSION, 0, 7) > '2.0.3.1'){
                    $data['item_link'] = $this->url->link('customer/custom_field/edit', 'token=' . $this->session->data['token'] . '&custom_field_id=', true);
                }else{
                    $data['item_link'] = $this->url->link('sale/custom_field/edit', 'token=' . $this->session->data['token'] . '&custom_field_id=', true);
                }
                $data['item_link_id'] = 'custom_field_id';
                $data['item_section'] = $this->language->get('text_custom_field');
                break;
            }
            case '15':{
                $data['getFunction'] = 'getCustomFieldValues';
                $data['updateFunction'] = 'updateCustomFieldValue';
                $data['item_id'] = 'custom_field_value_id';
                $data['item_id2'] = 'custom_field_id';
                $data['item_name'] = 'name';
                if(substr(VERSION, 0, 7) > '2.0.3.1'){
                    $data['item_link'] = $this->url->link('customer/custom_field/edit', 'token=' . $this->session->data['token'] . '&custom_field_id=', true);
                }else{
                    $data['item_link'] = $this->url->link('sale/custom_field/edit', 'token=' . $this->session->data['token'] . '&custom_field_id=', true);
                }
                $data['item_link_id'] = 'custom_field_id';
                $data['item_section'] = $this->language->get('text_custom_field_value');
                break;
            }
            case '16':{
                $data['getFunction'] = 'getVoucherThemes';
                $data['updateFunction'] = 'updateVoucherTheme';
                $data['item_id'] = 'voucher_theme_id';
                $data['item_id2'] = 'language_id';
                $data['item_name'] = 'name';
                $data['item_link'] = $this->url->link('sale/voucher_theme/edit', 'token=' . $this->session->data['token'] . '&voucher_theme_id=', true);
                $data['item_link_id'] = 'voucher_theme_id';
                $data['item_section'] = $this->language->get('text_voucher_theme');
                break;
            }
            case '17':{
                $data['getFunction'] = 'getLengthClasses';
                $data['updateFunction'] = 'updateLengthClass';
                $data['item_id'] = 'length_class_id';
                $data['item_id2'] = 'language_id';
                $data['item_name'] = 'title';
                $data['item_link'] = $this->url->link('localisation/length_class/edit', 'token=' . $this->session->data['token'] . '&length_class_id=', true);
                $data['item_link_id'] = 'length_class_id';
                $data['item_section'] = $this->language->get('text_length_classes');
                break;
            }
            case '18':{
                $data['getFunction'] = 'getWeightClasses';
                $data['updateFunction'] = 'updateWeightClass';
                $data['item_id'] = 'weight_class_id';
                $data['item_id2'] = 'language_id';
                $data['item_name'] = 'title';
                $data['item_link'] = $this->url->link('localisation/weight_class/edit', 'token=' . $this->session->data['token'] . '&weight_class_id=', true);
                $data['item_link_id'] = 'weight_class_id';
                $data['item_section'] = $this->language->get('text_weight_classes');
                break;
            }
        }
        return $data;
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', $this->modulePath)) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }

    public function install() {
        $this->load->model('setting/store');
        $this->load->model('setting/setting');
        $this->load->model('localisation/language');
        $this->load->model($this->modulePath);
        $languages = $this->model_localisation_language->getLanguages();
        $google_languages = $this->{$this->moduleModel}->getGoogleLanguages();
        $microsoft_languages = $this->{$this->moduleModel}->getMicrosoftLanguages();
        $auto_translator_g_language = array();
        $auto_translator_m_language = array();
        foreach ($languages as $language){
            foreach ($google_languages as $key => $name){
                $find = strpos($language['code'], $key);
                if($find !== false){
                    $auto_translator_g_language[$language['language_id']] = $key;
                }
            }
            foreach ($microsoft_languages as $key => $name){
                $find = strpos($language['code'], $key);
                if($find !== false){
                    $auto_translator_m_language[$language['language_id']] = $key;
                }
            }
        }
        $default_language = $this->{$this->moduleModel}->getLanguageByCode($this->config->get('config_language'));
        $settings = array(
            'auto_translator_status' => 0,
            'auto_translator_source' => $default_language['language_id'],
            'auto_translator_send_interval' => 1000,
            'auto_translator_limit_item' => 10000,
            'auto_translator_api_key' => '',
            'auto_translator_g_language' => $auto_translator_g_language,
            'auto_translator_client_id' => '',
            'auto_translator_client_secret' => '',
            'auto_translator_microsoft_key' => '',
            'auto_translator_m_language' => $auto_translator_m_language,
            'auto_translator_microsoft_token' => 0
        );
        $this->model_setting_setting->editSetting($this->moduleName,$settings, 0);
        $result = $this->{$this->moduleModel}->install();
        if($result->num_rows){
            $modifications = $this->load->controller('extension/modification/refresh');
        }
    }

    public function uninstall() {
        $this->load->model('setting/setting');
        $this->load->model($this->modulePath);
        $this->model_setting_setting->deleteSetting($this->moduleName,0);
        $result = $this->{$this->moduleModel}->uninstall();
        if($result->num_rows){
            $modifications = $this->load->controller('extension/modification/refresh');
        }
    }
	
	public function changeMainTranslatorLanguageAjax(){
		$language_id = (int)$this->request->post['language_id'];
		
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSettingValue('auto_translator', 'auto_translator_source', $language_id);		
		
		$this->response->setOutput($this->model_setting_setting->getSettingValue('auto_translator_source'));	
	}

    public function getNotification() {
	/*
        sleep(1);
        $this->load->language($this->modulePath);
        $site = $this->config->get('config_secure')?HTTPS_CATALOG:HTTP_CATALOG;
        $url = "http://vanstudio.co.ua/index.php?route=module/activation/info&extension_id=27454&site=" . $site . "&order_id=".$this->config->get('auto_translator_order_id')."&url=".$this->config->get('auto_translator_url')."&version=$this->moduleVersion&language_code=" . $this->config->get('config_admin_language');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 6);
        $output = curl_exec($ch);
        curl_close($ch);
        if (stripos($output,'<html') !== false || $output == false) {
            $json['message'] = '';
            $json['error'] = $this->language->get('error_notification');
        } else {
            $json['message'] = $output;
            $json['error'] = '';
        }
        $this->response->setOutput(json_encode($json));
	*/
    }
}