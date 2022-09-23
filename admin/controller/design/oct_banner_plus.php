<?php
/**************************************************************/
/*	@copyright	OCTemplates 2018.							  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */
/**************************************************************/

class ControllerDesignOctBannerPlus extends Controller {
    private $error = array();
    
    public function index() {
        $this->load->language('design/oct_banner_plus');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('design/oct_banner_plus');
        
        $this->model_design_oct_banner_plus->createDBTables();
        
        $this->getList();
    }
    
    public function add() {
        $this->load->language('design/oct_banner_plus');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('design/oct_banner_plus');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_design_oct_banner_plus->addBanner($this->request->post);
            
            $this->session->data['success'] = $this->language->get('text_success');
            
            $url = '';
            
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            
            $this->response->redirect($this->url->link('design/oct_banner_plus', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->getForm();
    }
    
    public function edit() {
        $this->load->language('design/oct_banner_plus');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('design/oct_banner_plus');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_design_oct_banner_plus->editBanner($this->request->get['banner_id'], $this->request->post);
            
            $this->session->data['success'] = $this->language->get('text_success');
            
            $url = '';
            
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            
            $this->response->redirect($this->url->link('design/oct_banner_plus', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->getForm();
    }
    
    public function delete() {
        $this->load->language('design/oct_banner_plus');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('design/oct_banner_plus');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $banner_id) {
                $this->model_design_oct_banner_plus->deleteBanner($banner_id);
            }
            
            $this->session->data['success'] = $this->language->get('text_success');
            
            $url = '';
            
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            
            $this->response->redirect($this->url->link('design/oct_banner_plus', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->getList();
    }
    
    protected function getList() {
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
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
            'href' => $this->url->link('design/oct_banner_plus', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        
        $data['add']    = $this->url->link('design/oct_banner_plus/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('design/oct_banner_plus/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['oct_banner_pluss'] = array();
        
        $filter_data = array(
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );
        
        $oct_banner_plus_total = $this->model_design_oct_banner_plus->getTotalBanners();
        
        $results = $this->model_design_oct_banner_plus->getBanners($filter_data);
        
        foreach ($results as $result) {
            $data['oct_banner_pluss'][] = array(
                'banner_id' => $result['banner_id'],
                'name' => $result['name'],
                'status' => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
                'edit' => $this->url->link('design/oct_banner_plus/edit', 'token=' . $this->session->data['token'] . '&banner_id=' . $result['banner_id'] . $url, 'SSL')
            );
        }
        
        $data['heading_title'] = $this->language->get('heading_title');
        
        $data['text_list']       = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm']    = $this->language->get('text_confirm');
        
        $data['column_name']   = $this->language->get('column_name');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_action'] = $this->language->get('column_action');
        
        $data['button_add']    = $this->language->get('button_add');
        $data['button_edit']   = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');
        
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
        
        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }
        
        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        
        $data['sort_name']   = $this->url->link('design/oct_banner_plus', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        $data['sort_status'] = $this->url->link('design/oct_banner_plus', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }
        
        $pagination        = new Pagination();
        $pagination->total = $oct_banner_plus_total;
        $pagination->page  = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url   = $this->url->link('design/oct_banner_plus', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
        
        $data['pagination'] = $pagination->render();
        
        $data['results'] = sprintf($this->language->get('text_pagination'), ($oct_banner_plus_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($oct_banner_plus_total - $this->config->get('config_limit_admin'))) ? $oct_banner_plus_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $oct_banner_plus_total, ceil($oct_banner_plus_total / $this->config->get('config_limit_admin')));
        
        $data['sort']  = $sort;
        $data['order'] = $order;
        
        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');
        
        $this->response->setOutput($this->load->view('design/oct_banner_plus_list.tpl', $data));
    }
    
    protected function getForm() {
        $data['heading_title'] = $this->language->get('heading_title');
        
        $data['text_form']     = !isset($this->request->get['banner_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['text_enabled']  = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_default']  = $this->language->get('text_default');
        
        $data['entry_name']        = $this->language->get('entry_name');
        $data['entry_title']       = $this->language->get('entry_title');
        $data['entry_link']        = $this->language->get('entry_link');
        $data['entry_image']       = $this->language->get('entry_image');
        $data['entry_status']      = $this->language->get('entry_status');
        $data['entry_sort_order']  = $this->language->get('entry_sort_order');
        $data['entry_button']      = $this->language->get('entry_button');
        $data['entry_description'] = $this->language->get('entry_description');
        
        $data['button_save']                = $this->language->get('button_save');
        $data['button_cancel']              = $this->language->get('button_cancel');
        $data['button_oct_banner_plus_add'] = $this->language->get('button_banner_add');
        $data['button_remove']              = $this->language->get('button_remove');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }
        
        if (isset($this->error['oct_banner_plus_image'])) {
            $data['error_oct_banner_plus_image'] = $this->error['oct_banner_plus_image'];
        } else {
            $data['error_oct_banner_plus_image'] = array();
        }
        
        $url = '';
        
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
            'href' => $this->url->link('design/oct_banner_plus', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        
        if (!isset($this->request->get['banner_id'])) {
            $data['action'] = $this->url->link('design/oct_banner_plus/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('design/oct_banner_plus/edit', 'token=' . $this->session->data['token'] . '&banner_id=' . $this->request->get['banner_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('design/oct_banner_plus', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['banner_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $oct_banner_plus_info = $this->model_design_oct_banner_plus->getBanner($this->request->get['banner_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        
        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($oct_banner_plus_info)) {
            $data['name'] = $oct_banner_plus_info['name'];
        } else {
            $data['name'] = '';
        }
        
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($oct_banner_plus_info)) {
            $data['status'] = $oct_banner_plus_info['status'];
        } else {
            $data['status'] = true;
        }
        
        $this->load->model('localisation/language');
        
        $data['languages'] = $this->model_localisation_language->getLanguages();
        
        $this->load->model('tool/image');
        
        if (isset($this->request->post['oct_banner_plus_image'])) {
            $oct_banner_plus_images = $this->request->post['oct_banner_plus_image'];
        } elseif (isset($this->request->get['banner_id'])) {
            $oct_banner_plus_images = $this->model_design_oct_banner_plus->getBannerImages($this->request->get['banner_id']);
        } else {
            $oct_banner_plus_images = array();
        }
        
        $data['oct_banner_plus_images'] = array();
        
        foreach ($oct_banner_plus_images as $oct_banner_plus_image) {
            if (is_file(DIR_IMAGE . $oct_banner_plus_image['image'])) {
                $image = $oct_banner_plus_image['image'];
                $thumb = $oct_banner_plus_image['image'];
            } else {
                $image = '';
                $thumb = 'no_image.png';
            }
            
            $data['oct_banner_plus_images'][] = array(
                'oct_banner_plus_image_description' => $oct_banner_plus_image['oct_banner_plus_image_description'],
                'image' => $image,
                'thumb' => $this->model_tool_image->resize($thumb, 100, 100),
                'sort_order' => $oct_banner_plus_image['sort_order']
            );
        }
        
        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        
        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');
        
        $this->response->setOutput($this->load->view('design/oct_banner_plus_form.tpl', $data));
    }
    
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'design/oct_banner_plus')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        
        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }
        
        if (isset($this->request->post['oct_banner_plus_image'])) {
            foreach ($this->request->post['oct_banner_plus_image'] as $banner_image_id => $oct_banner_plus_image) {
                foreach ($oct_banner_plus_image['oct_banner_plus_image_description'] as $language_id => $oct_banner_plus_image_description) {
                    if ((utf8_strlen($oct_banner_plus_image_description['title']) < 2) || (utf8_strlen($oct_banner_plus_image_description['title']) > 64)) {
                        $this->error['oct_banner_plus_image'][$banner_image_id][$language_id] = $this->language->get('error_title');
                    }
                }
            }
        }
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'design/oct_banner_plus')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        
        return !$this->error;
    }
}