<?php
/**************************************************************/
/*	@copyright	OCTemplates 2018.							  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */
/**************************************************************/

class ControllerOctemplatesSreviewSubject extends Controller {
    private $error = array();
    
    public function index() {
        $oct_sreview_setting = $this->config->get('oct_sreview_setting_data');
        
        if (!isset($oct_sreview_setting['status']) || $oct_sreview_setting['status'] != 1) {
            $this->response->redirect($this->url->link('octemplates/sreview_setting', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        $this->language->load('octemplates/sreview_subject');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('octemplates/sreview_subject');
        
        $this->getList();
    }
    
    public function add() {
        $this->language->load('octemplates/sreview_subject');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('octemplates/sreview_subject');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_octemplates_sreview_subject->addSubject($this->request->post);
            
            $this->session->data['success'] = $this->language->get('text_success');
            
            $url = '';
            
            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }
            
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            
            $this->response->redirect($this->url->link('octemplates/sreview_subject', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->getForm();
    }
    
    public function edit() {
        $this->language->load('octemplates/sreview_subject');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('octemplates/sreview_subject');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_octemplates_sreview_subject->editSubject($this->request->get['oct_sreview_subject_id'], $this->request->post);
            
            $this->session->data['success'] = $this->language->get('text_success');
            
            $url = '';
            
            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }
            
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            
            $this->response->redirect($this->url->link('octemplates/sreview_subject', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->getForm();
    }
    
    public function delete() {
        $this->language->load('octemplates/sreview_subject');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('octemplates/sreview_subject');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $oct_sreview_subject_id) {
                $this->model_octemplates_sreview_subject->deleteSubject($oct_sreview_subject_id);
            }
            
            $this->session->data['success'] = $this->language->get('text_success');
            
            $url = '';
            
            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }
            
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            
            $this->response->redirect($this->url->link('octemplates/sreview_subject', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->getList();
    }
    
    public function copy() {
        $this->language->load('octemplates/sreview_subject');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('octemplates/sreview_subject');
        
        if (isset($this->request->post['selected']) && $this->validateCopy()) {
            foreach ($this->request->post['selected'] as $oct_sreview_subject_id) {
                $this->model_octemplates_sreview_subject->copySubject($oct_sreview_subject_id);
            }
            
            $this->session->data['success'] = $this->language->get('text_success');
            
            $url = '';
            
            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }
            
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            
            $this->response->redirect($this->url->link('octemplates/sreview_subject', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->getList();
    }
    
    protected function getList() {
        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = null;
        }
        
        if (isset($this->request->get['filter_status'])) {
            $filter_status = $this->request->get['filter_status'];
        } else {
            $filter_status = null;
        }
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'sd.name';
        }
        
        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        $url = '';
        
        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        
        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('octemplates/sreview_subject', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        
        $data['add']    = $this->url->link('octemplates/sreview_subject/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['copy']   = $this->url->link('octemplates/sreview_subject/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('octemplates/sreview_subject/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['subjects'] = array();
        
        $filter_data = array(
            'filter_name' => $filter_name,
            'filter_status' => $filter_status,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );
        
        $this->load->model('tool/image');
        
        $subject_total = $this->model_octemplates_sreview_subject->getTotalSubjects($filter_data);
        
        $results = $this->model_octemplates_sreview_subject->getSubjects($filter_data);
        
        foreach ($results as $result) {
            $data['subjects'][] = array(
                'oct_sreview_subject_id' => $result['oct_sreview_subject_id'],
                'name' => $result['name'],
                'status' => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
                'edit' => $this->url->link('octemplates/sreview_subject/edit', 'token=' . $this->session->data['token'] . '&oct_sreview_subject_id=' . $result['oct_sreview_subject_id'] . $url, 'SSL')
            );
        }
        
        $data['heading_title'] = $this->language->get('heading_title');
        
        $data['text_list']       = $this->language->get('text_list');
        $data['text_enabled']    = $this->language->get('text_enabled');
        $data['text_disabled']   = $this->language->get('text_disabled');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm']    = $this->language->get('text_confirm');
        
        $data['column_name']   = $this->language->get('column_name');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_action'] = $this->language->get('column_action');
        
        $data['entry_name']   = $this->language->get('entry_name');
        $data['entry_status'] = $this->language->get('entry_status');
        
        $data['button_copy']   = $this->language->get('button_copy');
        $data['button_add']    = $this->language->get('button_add');
        $data['button_edit']   = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_filter'] = $this->language->get('button_filter');
        
        $data['token'] = $this->session->data['token'];
        
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
        
        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array) $this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }
        
        $url = '';
        
        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        
        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }
        
        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        
        $data['sort_name']   = $this->url->link('octemplates/sreview_subject', 'token=' . $this->session->data['token'] . '&sort=sd.name' . $url, 'SSL');
        $data['sort_status'] = $this->url->link('octemplates/sreview_subject', 'token=' . $this->session->data['token'] . '&sort=s.status' . $url, 'SSL');
        $data['sort_order']  = $this->url->link('octemplates/sreview_subject', 'token=' . $this->session->data['token'] . '&sort=s.sort_order' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        
        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }
        
        $pagination        = new Pagination();
        $pagination->total = $subject_total;
        $pagination->page  = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url   = $this->url->link('octemplates/sreview_subject', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
        
        $data['pagination'] = $pagination->render();
        
        $data['results'] = sprintf($this->language->get('text_pagination'), ($subject_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($subject_total - $this->config->get('config_limit_admin'))) ? $subject_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $subject_total, ceil($subject_total / $this->config->get('config_limit_admin')));
        
        $data['filter_name']   = $filter_name;
        $data['filter_status'] = $filter_status;
        
        $data['sort']  = $sort;
        $data['order'] = $order;
        
        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');
        
        $this->response->setOutput($this->load->view('octemplates/sreview_subject_list.tpl', $data));
    }
    
    protected function getForm() {
        $data['heading_title'] = $this->language->get('heading_title');
        
        $data['text_form']     = !isset($this->request->get['oct_sreview_subject_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['text_enabled']  = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_none']     = $this->language->get('text_none');
        $data['text_yes']      = $this->language->get('text_yes');
        $data['text_no']       = $this->language->get('text_no');
        $data['text_default']  = $this->language->get('text_default');
        $data['text_select']   = $this->language->get('text_select');
        
        $data['entry_name']       = $this->language->get('entry_name');
        $data['entry_store']      = $this->language->get('entry_store');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_status']     = $this->language->get('entry_status');
        
        $data['button_save']   = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        
        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_data']    = $this->language->get('tab_data');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = array();
        }
        
        $url = '';
        
        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        
        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('octemplates/sreview_subject', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        
        if (!isset($this->request->get['oct_sreview_subject_id'])) {
            $data['action'] = $this->url->link('octemplates/sreview_subject/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('octemplates/sreview_subject/edit', 'token=' . $this->session->data['token'] . '&oct_sreview_subject_id=' . $this->request->get['oct_sreview_subject_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('octemplates/sreview_subject', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['oct_sreview_subject_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $subject_info = $this->model_octemplates_sreview_subject->getSubject($this->request->get['oct_sreview_subject_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        
        $this->load->model('localisation/language');
        
        $data['languages'] = $this->model_localisation_language->getLanguages();
        
        if (isset($this->request->post['subject_description'])) {
            $data['subject_description'] = $this->request->post['subject_description'];
        } elseif (isset($this->request->get['oct_sreview_subject_id'])) {
            $data['subject_description'] = $this->model_octemplates_sreview_subject->getSubjectDescriptions($this->request->get['oct_sreview_subject_id']);
        } else {
            $data['subject_description'] = array();
        }
        
        $this->load->model('setting/store');
        
        $data['stores'] = $this->model_setting_store->getStores();
        
        if (isset($this->request->post['subject_store'])) {
            $data['subject_store'] = $this->request->post['subject_store'];
        } elseif (isset($this->request->get['oct_sreview_subject_id'])) {
            $data['subject_store'] = $this->model_octemplates_sreview_subject->getSubjectStores($this->request->get['oct_sreview_subject_id']);
        } else {
            $data['subject_store'] = array(
                0
            );
        }
        
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($subject_info)) {
            $data['sort_order'] = $subject_info['sort_order'];
        } else {
            $data['sort_order'] = 1;
        }
        
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($subject_info)) {
            $data['status'] = $subject_info['status'];
        } else {
            $data['status'] = true;
        }
        
        $this->load->model('customer/customer_group');
        
        $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
        
        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');
        
        $this->response->setOutput($this->load->view('octemplates/sreview_subject_form.tpl', $data));
    }
    
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'octemplates/sreview_subject')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        
        foreach ($this->request->post['subject_description'] as $language_id => $value) {
            if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
                $this->error['name'][$language_id] = $this->language->get('error_name');
            }
        }
        
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'octemplates/sreview_subject')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        
        return !$this->error;
    }
    
    protected function validateCopy() {
        if (!$this->user->hasPermission('modify', 'octemplates/sreview_subject')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        
        return !$this->error;
    }
    
    public function autocomplete() {
        $json = array();
        
        if (isset($this->request->get['filter_name'])) {
            $this->load->model('octemplates/sreview_subject');
            
            if (isset($this->request->get['filter_name'])) {
                $filter_name = $this->request->get['filter_name'];
            } else {
                $filter_name = '';
            }
            
            if (isset($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
            } else {
                $limit = 5;
            }
            
            $filter_data = array(
                'filter_name' => $filter_name,
                'start' => 0,
                'limit' => $limit
            );
            
            $results = $this->model_octemplates_sreview_subject->getSubjects($filter_data);
            
            foreach ($results as $result) {
                $json[] = array(
                    'oct_sreview_subject_id' => $result['oct_sreview_subject_id'],
                    'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
                );
            }
        }
        
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}