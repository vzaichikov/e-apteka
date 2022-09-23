<?php
    class ControllerExtensionModuleIMCallMeAskMe extends Controller {
        private $error = array();
        
        private $blackList = ['+38(068)802-42-60','+38(097)067-15-31'];
        
        public function getPopup()
        {
            $this->load->model('extension/module/IMCallMeAskMe');
            
            $data['lang_settings'] = $this->model_extension_module_IMCallMeAskMe->getSettings();
            
            $this->load->model('localisation/language');
            $langs = $this->model_localisation_language->getLanguages();
            
            $data['language_id'] = $langs[$this->session->data['language']]['language_id'];
            
            $this->load->model('setting/setting');
            
            $template = 'extension/module/IMCallMeAskMe';
            $this->response->setOutput($this->load->view($template, $data));
        }
        
        protected function sendToBitrix($settings, $post, &$json, $lang_id){
            
            $this->load->library('hobotix/BitrixBot');
			$this->bitrixBot = new hobotix\BitrixBot($this->registry);
            
            $this->load->model('extension/module/IMCallMeAskMe');
            $this->model_extension_module_IMCallMeAskMe->insertStat($lang_id, $post, '');
            
            $customer_name = '';
            if ($this->customer->isLogged()){
                $customer_name = ' ' . $this->customer->getFirstName();
            }
            
            $message = array(
            'message' => ':!: Зворотній дзвінок!',
            'attach' => array(
            "ID" => 1,
            "COLOR" => "#29619b",
            "BLOCKS" => Array(
            Array("USER" => Array(
            "NAME"      => "Клієнт$customer_name замовив зворотній дзвінок!",
            "AVATAR"    => "http://e-apteka.com.ua/bitrix/images/bitrixavatar.jpg",
            )),
            Array("MESSAGE" => "[B]Телефон клієнта:[/B] " . $post['tel']),
            Array("MESSAGE" => "[B]Повідомлення:[/B] " . strip_tags($post['text'])),
            Array("DELIMITER" => Array(
            'SIZE' => 200,
            'COLOR' => "#c6c6c6"
            )),
            Array("MESSAGE" => "[B]Сторінка на якій був клієнт[/B]"),
            Array("LINK" => Array(
            "NAME"      => urldecode($post['url']),
            "LINK"      => urldecode($post['url']),
            )), 
            )                
            )
            );
            
            try{
                
                if (!$this->bitrixBot->logRequest()->loadConfigFile()->validateAppsConfig()){
                    return;
                }
                
                $this->bitrixBot->sendMessageToGroup('chat5644', $message);
                
            } catch(Exception $e)
            {
                
            }
            
        }
        
        // Отсылка почты, если необходимо
        protected function sendEmailAndSetStat($settings, $post, &$json, $lang_id)
        {

        }
        
        // Получение значения из поста
        private function getPostValue($name, $default = '') {
            return (isset($this->request->post[$name]) ? $this->request->post[$name] : $default);
        }
        
        // Отправка сообщения
        public function sendMessage(){
            
            $json = array(
            'error' => false,
            'messages' => array(),
            'complete' => 'Ваша заявка была удачно отправлена!'
            );
        
            if (in_array($this->getPostValue('tel'), $this->blackList)){
                die(json_encode($json));
            }
            
            $this->load->model('extension/module/IMCallMeAskMe');
            $this->load->model('localisation/language');
            $langs = $this->model_localisation_language->getLanguages();
            $lang_id = $langs[$this->session->data['language']]['language_id'];
            $settings = $this->model_extension_module_IMCallMeAskMe->getEffSettings($lang_id);
            
            
             $json = array(
            'error' => false,
            'messages' => array(),
            'complete' => $settings['complete_send']
            );
            
            
            // Проверяем данные из поста
            $post = array(
            'url' => $this->getPostValue('url'),
            'name' => $this->getPostValue('name'),
            'email' => $this->getPostValue('email'),
            'tel' => $this->getPostValue('tel'),
            'text' => $this->getPostValue('text'),
            'utm_source' => $this->getPostValue('utm_source'),
            'utm_medium' => $this->getPostValue('utm_medium'),
            'utm_campaign' => $this->getPostValue('utm_campaign'),
            'utm_content' => $this->getPostValue('utm_content'),
            'utm_term' => $this->getPostValue('utm_term')
            );
            
            
            
            // Требуется ввод имени
            if (('' . $settings['name_req']) == '1' && ('' . $settings['name_inc']) == '1')
            {
                if (trim($post['name']) == '')
                {
                    $json['error'] = true;
                    $json['messages']['name'] = true;
                }
            }
            
            // Требуется ввод сообщения
            if (('' . $settings['text_req']) == '1' && ('' . $settings['text_inc']) == '1')
            {
                if (trim($post['text']) == '')
                {
                    $json['error'] = true;
                    $json['messages']['text'] = true;
                }
            }
            
            // Требуется ввод почты
            if (('' . $settings['email_req']) == '1' && ('' . $settings['email_inc']) == '1')
            {
                if (trim($post['email']) == '')
                {
                    $json['error'] = true;
                    $json['messages']['email'] = true;
                }
                else if (isset($post['email']) && !empty($post['email']))
                {
                    if (!preg_match("/.+@.+\..+/i", $post['email'])) {
                        $json['error'] = true;
                        $json['messages']['email'] = true;
                    }
                }
            }
            
            if (('' . $settings['tel_req']) == '1' && ('' . $settings['tel_inc']) == '1')
            {
                if (trim($post['tel']) == '')
                {
                    $json['error'] = true;
                    $json['messages']['tel'] = true;
                }
                else if (isset($post['tel']) && !empty($post['tel']))
                {
                    if (!preg_match("/^((8|\+7|\+38)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/", $post['tel'])) {
                        $json['error'] = true;
                        $json['messages']['tel'] = true;
                    }
                }
            }
            
            
            // Отсылка почты
            if (!$json['error']) {
                $this->sendToBitrix($settings, $post, $json, $lang_id);
            }
            
            $this->response->setOutput(json_encode($json));
        }
        
        
    }
