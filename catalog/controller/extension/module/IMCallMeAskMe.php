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

        $randToken = generateRandomString(10);
        $this->session->data['callback_random_token'] = $randToken;
        $data['token'] = md5($this->request->server['REMOTE_ADDR'] . $randToken);        
        
        $template = 'extension/module/IMCallMeAskMe';
        $this->response->setOutput($this->load->view($template, $data));
    }   

    protected function sendEmailAndSetStat($settings, $post, &$json, $lang_id)
    {

    }

    private function getPostValue($name, $default = '') {
        return (isset($this->request->post[$name]) ? $this->request->post[$name] : $default);
    }

    public function sendMessage(){

        $json = array(
            'error' => false,
            'messages' => array(),
            'complete' => 'Ваша заявка была удачно отправлена!'
        );
        
        if (in_array($this->getPostValue('tel'), $this->blackList)){
            die(json_encode($json));
        }

        if (!$this->getPostValue('token') 
            || empty($this->session->data['callback_random_token']) 
            || ($this->getPostValue('token') != md5($this->request->server['REMOTE_ADDR'] . $this->session->data['callback_random_token']))){
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

        $post = array(
            'url'           => $this->getPostValue('url'),
            'name'          => $this->getPostValue('name'),
            'email'         => $this->getPostValue('email'),
            'tel'           => $this->getPostValue('tel'),
            'text'          => $this->getPostValue('text'),
            'utm_source'    => $this->getPostValue('utm_source'),
            'utm_medium'    => $this->getPostValue('utm_medium'),
            'utm_campaign'  => $this->getPostValue('utm_campaign'),
            'utm_content'   => $this->getPostValue('utm_content'),
            'utm_term'      => $this->getPostValue('utm_term')
        );

        if (('' . $settings['name_req']) == '1' && ('' . $settings['name_inc']) == '1')
        {
            if (trim($post['name']) == '')
            {
                $json['error'] = true;
                $json['messages']['name'] = true;
            }
        }

        if (('' . $settings['text_req']) == '1' && ('' . $settings['text_inc']) == '1')
        {
            if (trim($post['text']) == '')
            {
                $json['error'] = true;
                $json['messages']['text'] = true;
            }
        }

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

        if (!$json['error']) {
           
        }

        $this->response->setOutput(json_encode($json));
    }


}
