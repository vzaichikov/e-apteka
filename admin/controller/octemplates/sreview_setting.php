<?php
/**************************************************************/
/*	@copyright	OCTemplates 2018.							  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */
/**************************************************************/

class ControllerOctemplatesSreviewSetting extends Controller {
    private $error = array();

    public function index() {
        $data = array();

        $data = array_merge($data, $this->load->language('octemplates/sreview_setting'));

        $this->load->model('setting/setting');
        $this->load->model('extension/extension');
        $this->load->model('user/user_group');
        $this->load->model('octemplates/sreview_setting');
        $this->load->model('localisation/language');

        $data['languages'] = array();

        foreach ($this->model_localisation_language->getLanguages() as $language) {
            $data['languages'][] = $languages[] = array(
                'language_id' => $language['language_id'],
                'code' => $language['code'],
                'name' => $language['name'],
                'image' => 'language/' . $language['code'] . '/' . $language['code'] . '.png'
            );
        }

        if (!in_array('oct_sreview_setting', $this->model_extension_extension->getInstalled('extension'))) {
            $this->model_octemplates_sreview_setting->installTables();

            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'octemplates/sreview_setting');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'octemplates/sreview_setting');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'octemplates/sreview_subject');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'octemplates/sreview_subject');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'octemplates/sreview_reviews');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'octemplates/sreview_reviews');

            foreach ($languages as $language) {
                $default_language_data[$language['language_id']] = array(
                    'seo_title' => '',
                    'seo_meta_description' => '',
                    'seo_meta_keywords' => '',
                    'seo_h1' => '',
                    'seo_description' => ''
                );
            }

            $this->model_setting_setting->editSetting('oct_sreview_setting', array(
                'oct_sreview_setting_data' => array(
                    'status' => '1',
                    'review_moderation' => '1',
                    'review_admin_email' => '1',
                    'review_email_to' => $this->config->get('config_email'),
                    'language' => $default_language_data
                )
            ));

            $this->model_extension_extension->install('extension', 'oct_sreview_setting');
        }

        //CKEditor
        if ($this->config->get('config_editor_default')) {
            $this->document->addScript('view/javascript/ckeditor/ckeditor.js');
            $this->document->addScript('view/javascript/ckeditor/ckeditor_init.js');
        } else {
            $this->document->addScript('view/javascript/summernote/summernote.js');
            $this->document->addScript('view/javascript/summernote/lang/summernote-' . $this->language->get('lang') . '.js');
            $this->document->addScript('view/javascript/summernote/opencart.js');
            $this->document->addStyle('view/javascript/summernote/summernote.css');
        }

        $data['token'] = $this->session->data['token'];
        $data['ckeditor'] = $this->config->get('config_editor_default');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('oct_sreview_setting', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('octemplates/sreview_setting', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['config_email'] = $this->config->get('config_email');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

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
            'href' => $this->url->link('octemplates/sreview_setting', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['action']    = $this->url->link('octemplates/sreview_setting', 'token=' . $this->session->data['token'], 'SSL');
        //$data['uninstall'] = $this->url->link('octemplates/sreview_setting/uninstall', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel']    = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['oct_sreview_setting_data'])) {
            $data['oct_sreview_setting_data'] = $this->request->post['oct_sreview_setting_data'];
        } else {
            $data['oct_sreview_setting_data'] = $this->config->get('oct_sreview_setting_data');
        }

        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('octemplates/sreview_setting.tpl', $data));
    }

    public function uninstall() {
        $this->load->language('octemplates/sreview_setting');

        $this->load->model('extension/extension');

        $this->model_extension_extension->uninstall('extension', 'oct_sreview_setting');

        $this->load->model('setting/setting');

        $this->model_setting_setting->deleteSetting('oct_sreview_setting');

        $this->load->model('octemplates/sreview_setting');

        $this->model_octemplates_sreview_setting->deleteTables();

        $this->session->data['success'] = $this->language->get('text_success_uninstall');

        $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'octemplates/sreview_setting')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}