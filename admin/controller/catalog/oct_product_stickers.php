<?php
/**************************************************************/
/*	@copyright	OCTemplates 2018.							  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */
/**************************************************************/

class ControllerCatalogOctProductStickers extends Controller {
    private $error = array();
    
    public function index() {
        $this->load->language('catalog/oct_product_stickers');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('catalog/oct_product_stickers');
        
        $this->getList();
    }
    
    public function add() {
        $this->load->language('catalog/oct_product_stickers');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('catalog/oct_product_stickers');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_oct_product_stickers->addProductSticker($this->request->post);
            
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
            
            $this->response->redirect($this->url->link('catalog/oct_product_stickers', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->getForm();
    }
    
    public function edit() {
        $this->load->language('catalog/oct_product_stickers');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('catalog/oct_product_stickers');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_oct_product_stickers->editProductSticker($this->request->get['product_sticker_id'], $this->request->post);
            
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
            
            $this->response->redirect($this->url->link('catalog/oct_product_stickers', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->getForm();
    }
    
    public function delete() {
        $this->load->language('catalog/oct_product_stickers');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('catalog/oct_product_stickers');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $product_sticker_id) {
                $this->model_catalog_oct_product_stickers->deleteProductSticker($product_sticker_id);
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
            
            $this->response->redirect($this->url->link('catalog/oct_product_stickers', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->getList();
    }
    
    protected function getList() {
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'id.title';
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
            'href' => $this->url->link('catalog/oct_product_stickers', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        
        $data['add']    = $this->url->link('catalog/oct_product_stickers/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('catalog/oct_product_stickers/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['oct_product_stickers'] = array();
        
        $filter_data = array(
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );
        
        $oct_product_stickers_total = $this->model_catalog_oct_product_stickers->getTotalProductStickers();
        
        $results = $this->model_catalog_oct_product_stickers->getProductStickers($filter_data);
        
        foreach ($results as $result) {
            $data['oct_product_stickers'][] = array(
                'product_sticker_id' => $result['product_sticker_id'],
                'title' => $result['title'],
                'sort_order' => $result['sort_order'],
                'edit' => $this->url->link('catalog/oct_product_stickers/edit', 'token=' . $this->session->data['token'] . '&product_sticker_id=' . $result['product_sticker_id'] . $url, 'SSL')
            );
        }
        
        $data['heading_title'] = $this->language->get('heading_title');
        
        $data['text_list']       = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm']    = $this->language->get('text_confirm');
        
        $data['column_title']      = $this->language->get('column_title');
        $data['column_sort_order'] = $this->language->get('column_sort_order');
        $data['column_action']     = $this->language->get('column_action');
        
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
        
        $data['sort_title']      = $this->url->link('catalog/oct_product_stickers', 'token=' . $this->session->data['token'] . '&sort=id.title' . $url, 'SSL');
        $data['sort_sort_order'] = $this->url->link('catalog/oct_product_stickers', 'token=' . $this->session->data['token'] . '&sort=b.sort_order' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }
        
        $pagination        = new Pagination();
        $pagination->total = $oct_product_stickers_total;
        $pagination->page  = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url   = $this->url->link('catalog/oct_product_stickers', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
        
        $data['pagination'] = $pagination->render();
        
        $data['results'] = sprintf($this->language->get('text_pagination'), ($oct_product_stickers_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($oct_product_stickers_total - $this->config->get('config_limit_admin'))) ? $oct_product_stickers_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $oct_product_stickers_total, ceil($oct_product_stickers_total / $this->config->get('config_limit_admin')));
        
        $data['sort']  = $sort;
        $data['order'] = $order;
        
        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');
        
        $this->response->setOutput($this->load->view('catalog/oct_product_stickers_list.tpl', $data));
    }
    
    protected function getForm() {
        
        $this->document->addScript('view/javascript/oct_product_stickers/jquery.minicolors.min.js');
        $this->document->addStyle('view/javascript/oct_product_stickers/jquery.minicolors.css');
		
		// Spectrum
		$this->document->addScript('view/javascript/spectrum/spectrum.js');
		$this->document->addStyle('view/javascript/spectrum/spectrum.css');
        
        $data['heading_title'] = $this->language->get('heading_title');
        
        $data['text_form']     = !isset($this->request->get['product_sticker_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['text_default']  = $this->language->get('text_default');
        $data['text_enabled']  = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        
        $data['entry_title']      = $this->language->get('entry_title');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_status']     = $this->language->get('entry_status');
        $data['entry_text']       = $this->language->get('entry_text');
        $data['entry_color']      = $this->language->get('entry_color');
        $data['entry_background'] = $this->language->get('entry_background');
        
        $data['button_save']   = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        
        $data['tab_general'] = $this->language->get('tab_general');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['title'])) {
            $data['error_title'] = $this->error['title'];
        } else {
            $data['error_title'] = array();
        }
        
        if (isset($this->error['text'])) {
            $data['error_text'] = $this->error['text'];
        } else {
            $data['error_text'] = array();
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
            'href' => $this->url->link('catalog/oct_product_stickers', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        
        if (!isset($this->request->get['product_sticker_id'])) {
            $data['action'] = $this->url->link('catalog/oct_product_stickers/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('catalog/oct_product_stickers/edit', 'token=' . $this->session->data['token'] . '&product_sticker_id=' . $this->request->get['product_sticker_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('catalog/oct_product_stickers', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['product_sticker_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $oct_product_stickers_info = $this->model_catalog_oct_product_stickers->getProductSticker($this->request->get['product_sticker_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        
        $this->load->model('localisation/language');
        
        $data['languages'] = $this->model_localisation_language->getLanguages();
        
        if (isset($this->request->post['oct_product_stickers_description'])) {
            $data['oct_product_stickers_description'] = $this->request->post['oct_product_stickers_description'];
        } elseif (isset($this->request->get['product_sticker_id'])) {
            $data['oct_product_stickers_description'] = $this->model_catalog_oct_product_stickers->getProductStickersDescriptions($this->request->get['product_sticker_id']);
        } else {
            $data['oct_product_stickers_description'] = array();
        }
        
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($oct_product_stickers_info)) {
            $data['status'] = $oct_product_stickers_info['status'];
        } else {
            $data['status'] = true;
        }
        
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($oct_product_stickers_info)) {
            $data['sort_order'] = $oct_product_stickers_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }
        
        if (isset($this->request->post['color'])) {
            $data['color'] = $this->request->post['color'];
        } elseif (!empty($oct_product_stickers_info)) {
            $data['color'] = $oct_product_stickers_info['color'];
        } else {
            $data['color'] = '';
        }
        
        if (isset($this->request->post['background'])) {
            $data['background'] = $this->request->post['background'];
        } elseif (!empty($oct_product_stickers_info)) {
            $data['background'] = $oct_product_stickers_info['background'];
        } else {
            $data['background'] = '';
        }
        
        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');
        
        $this->response->setOutput($this->load->view('catalog/oct_product_stickers_form.tpl', $data));
    }
    
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/oct_product_stickers')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        
        foreach ($this->request->post['oct_product_stickers_description'] as $language_id => $value) {
            if (empty($value['title'])) {
                $this->error['title'][$language_id] = $this->language->get('error_title');
            }
            
            if (empty($value['text'])) {
                $this->error['text'][$language_id] = $this->language->get('error_text');
            }
        }
        
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'catalog/oct_product_stickers')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        
        return !$this->error;
    }
}