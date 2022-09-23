<?php
/**************************************************************/
/*	@copyright	OCTemplates 2018.							  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */
/**************************************************************/

class ControllerOctemplatesBlogArticle extends Controller {
    private $error = array();

    public function index() {
        $oct_blog_setting = $this->config->get('oct_blog_setting_data');

        if (!isset($oct_blog_setting['status']) || $oct_blog_setting['status'] != 1) {
            $this->response->redirect($this->url->link('octemplates/blog_setting', 'token=' . $this->session->data['token'], 'SSL'));
        }
        $this->language->load('octemplates/blog_article');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('octemplates/blog_article');

        $this->getList();
    }

    public function add() {
        $this->language->load('octemplates/blog_article');

        $this->document->addScript('view/javascript/luxury/seo-blog.js');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('octemplates/blog_article');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_octemplates_blog_article->addArticle($this->request->post);

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

            $this->response->redirect($this->url->link('octemplates/blog_article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function edit() {
        $this->language->load('octemplates/blog_article');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('octemplates/blog_article');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_octemplates_blog_article->editArticle($this->request->get['oct_blog_article_id'], $this->request->post);

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

            $this->response->redirect($this->url->link('octemplates/blog_article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete() {
        $this->language->load('octemplates/blog_article');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('octemplates/blog_article');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $oct_blog_article_id) {
                $this->model_octemplates_blog_article->deleteArticle($oct_blog_article_id);
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

            $this->response->redirect($this->url->link('octemplates/blog_article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getList();
    }

    public function copy() {
        $this->language->load('octemplates/blog_article');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('octemplates/blog_article');

        if (isset($this->request->post['selected']) && $this->validateCopy()) {
            foreach ($this->request->post['selected'] as $oct_blog_article_id) {
                $this->model_octemplates_blog_article->copyArticle($oct_blog_article_id);
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

            $this->response->redirect($this->url->link('octemplates/blog_article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getList();
    }

    protected function getList() {
        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = null;
        }

        if (isset($this->request->get['filter_category'])) {
            $filter_category = $this->request->get['filter_category'];
        } else {
            $filter_category = NULL;
        }

        if (isset($this->request->get['filter_status'])) {
            $filter_status = $this->request->get['filter_status'];
        } else {
            $filter_status = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'pd.name';
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

        if (isset($this->request->get['filter_category'])) {
            $url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
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
            'href' => $this->url->link('octemplates/blog_article', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        $data['add']    = $this->url->link('octemplates/blog_article/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['copy']   = $this->url->link('octemplates/blog_article/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('octemplates/blog_article/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $data['products'] = array();

        $filter_data = array(
            'filter_name' => $filter_name,
            'filter_status' => $filter_status,
            'filter_category' => $filter_category,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $this->load->model('tool/image');

        $product_total = $this->model_octemplates_blog_article->getTotalArticles($filter_data);

        $results = $this->model_octemplates_blog_article->getArticles($filter_data);

        foreach ($results as $result) {
            if (is_file(DIR_IMAGE . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.png', 40, 40);
            }

            $data['products'][] = array(
                'oct_blog_article_id' => $result['oct_blog_article_id'],
                'image' => $image,
                'name' => $result['name'],
                'status' => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
                'edit' => $this->url->link('octemplates/blog_article/edit', 'token=' . $this->session->data['token'] . '&oct_blog_article_id=' . $result['oct_blog_article_id'] . $url, 'SSL')
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list']       = $this->language->get('text_list');
        $data['text_enabled']    = $this->language->get('text_enabled');
        $data['text_disabled']   = $this->language->get('text_disabled');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm']    = $this->language->get('text_confirm');

        $data['column_image']  = $this->language->get('column_image');
        $data['column_name']   = $this->language->get('column_name');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_action'] = $this->language->get('column_action');

        $data['entry_name']   = $this->language->get('entry_name');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_categoty_filter'] = $this->language->get('entry_categoty_filter');

        $data['button_copy']   = $this->language->get('button_copy');
        $data['button_add']    = $this->language->get('button_add');
        $data['button_edit']   = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_filter'] = $this->language->get('button_filter');

        // Categories
        $this->load->model('octemplates/blog_category');

        $categories = $this->model_octemplates_blog_category->getAllCategories();

        $data['blog_categories'] = $this->getAllCategories($categories);

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

        if (isset($this->request->get['filter_category'])) {
            $url .= '&filter_category=' . $this->request->get['filter_category'];
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

        $data['sort_name']   = $this->url->link('octemplates/blog_article', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
        $data['sort_status'] = $this->url->link('octemplates/blog_article', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, 'SSL');
        $data['sort_order']  = $this->url->link('octemplates/blog_article', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, 'SSL');

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_category'])) {
            $url .= '&filter_category=' . $this->request->get['filter_category'];
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
        $pagination->total = $product_total;
        $pagination->page  = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url   = $this->url->link('octemplates/blog_article', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));

        $data['filter_name']   = $filter_name;
        $data['filter_category'] = $filter_category;
        $data['filter_status'] = $filter_status;

        $data['sort']  = $sort;
        $data['order'] = $order;

        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('octemplates/blog_article_list.tpl', $data));
    }

    protected function getForm() {
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

        $data['ckeditor'] = $this->config->get('config_editor_default');

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form']         = !isset($this->request->get['oct_blog_article_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['text_enabled']      = $this->language->get('text_enabled');
        $data['text_disabled']     = $this->language->get('text_disabled');
        $data['text_none']         = $this->language->get('text_none');
        $data['text_yes']          = $this->language->get('text_yes');
        $data['text_no']           = $this->language->get('text_no');
        $data['text_plus']         = $this->language->get('text_plus');
        $data['text_minus']        = $this->language->get('text_minus');
        $data['text_default']      = $this->language->get('text_default');
        $data['text_select']       = $this->language->get('text_select');
        $data['text_amount']       = $this->language->get('text_amount');
        $data['text_select_all']   = $this->language->get('text_select_all');
        $data['text_unselect_all'] = $this->language->get('text_unselect_all');
        $data['text_separator']    = $this->language->get('text_separator');

        $data['entry_name']             = $this->language->get('entry_name');
        $data['entry_description']      = $this->language->get('entry_description');
        $data['entry_meta_title']       = $this->language->get('entry_meta_title');
        $data['entry_meta_description'] = $this->language->get('entry_meta_description');
        $data['entry_meta_keyword']     = $this->language->get('entry_meta_keyword');
        $data['entry_keyword']          = $this->language->get('entry_keyword');
        $data['entry_image']            = $this->language->get('entry_image');
        $data['entry_store']            = $this->language->get('entry_store');
        $data['entry_category']         = $this->language->get('entry_category');
        $data['entry_main_category_id'] = $this->language->get('entry_main_category_id');
        $data['entry_related_p']        = $this->language->get('entry_related_p');
        $data['entry_related_a']        = $this->language->get('entry_related_a');
        $data['entry_text']             = $this->language->get('entry_text');
        $data['entry_required']         = $this->language->get('entry_required');
        $data['entry_sort_order']       = $this->language->get('entry_sort_order');
        $data['entry_status']           = $this->language->get('entry_status');
        $data['entry_tag']              = $this->language->get('entry_tag');
        $data['entry_customer_group']   = $this->language->get('entry_customer_group');
        $data['entry_layout']           = $this->language->get('entry_layout');

        $data['help_keyword']  = $this->language->get('help_keyword');
        $data['help_category'] = $this->language->get('help_category');
        $data['help_related']  = $this->language->get('help_related');
        $data['help_tag']      = $this->language->get('help_tag');

        $data['button_save']      = $this->language->get('button_save');
        $data['button_cancel']    = $this->language->get('button_cancel');
        $data['button_image_add'] = $this->language->get('button_image_add');
        $data['button_remove']    = $this->language->get('button_remove');

        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_data']    = $this->language->get('tab_data');
        $data['tab_links']   = $this->language->get('tab_links');
        $data['tab_image']   = $this->language->get('tab_image');
        $data['tab_design']  = $this->language->get('tab_design');

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

        if (isset($this->error['meta_title'])) {
            $data['error_meta_title'] = $this->error['meta_title'];
        } else {
            $data['error_meta_title'] = array();
        }

        if (isset($this->error['keyword'])) {
            $data['error_keyword'] = $this->error['keyword'];
        } else {
            $data['error_keyword'] = '';
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
            'href' => $this->url->link('octemplates/blog_article', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        if (!isset($this->request->get['oct_blog_article_id'])) {
            $data['action'] = $this->url->link('octemplates/blog_article/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('octemplates/blog_article/edit', 'token=' . $this->session->data['token'] . '&oct_blog_article_id=' . $this->request->get['oct_blog_article_id'] . $url, 'SSL');

            $data['article_page'] = HTTP_CATALOG.'index.php?route=octemplates/blog_article&oct_blog_article_id='.$this->request->get['oct_blog_article_id'];
        }

        $data['cancel'] = $this->url->link('octemplates/blog_article', 'token=' . $this->session->data['token'] . $url, 'SSL');

        if (isset($this->request->get['oct_blog_article_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $article_info = $this->model_octemplates_blog_article->getArticle($this->request->get['oct_blog_article_id']);
        }

        $data['token'] = $this->session->data['token'];

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['lang'] = $this->language->get('lang');

        if (isset($this->request->post['article_description'])) {
            $data['article_description'] = $this->request->post['article_description'];
        } elseif (isset($this->request->get['oct_blog_article_id'])) {
            $data['article_description'] = $this->model_octemplates_blog_article->getArticleDescriptions($this->request->get['oct_blog_article_id']);
        } else {
            $data['article_description'] = array();
        }

        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } elseif (!empty($article_info)) {
            $data['image'] = $article_info['image'];
        } else {
            $data['image'] = '';
        }

        $this->load->model('tool/image');

        if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($article_info) && is_file(DIR_IMAGE . $article_info['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($article_info['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);


        $this->load->model('setting/store');

        $data['stores'] = $this->model_setting_store->getStores();

        if (isset($this->request->post['article_store'])) {
            $data['article_store'] = $this->request->post['article_store'];
        } elseif (isset($this->request->get['oct_blog_article_id'])) {
            $data['article_store'] = $this->model_octemplates_blog_article->getArticleStores($this->request->get['oct_blog_article_id']);
        } else {
            $data['article_store'] = array(
                0
            );
        }

        if (isset($this->request->post['keyword'])) {
            $data['keyword'] = $this->request->post['keyword'];
        } elseif (!empty($article_info)) {
            $data['keyword'] = $article_info['keyword'];
        } else {
            $data['keyword'] = '';
        }

        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($article_info)) {
            $data['sort_order'] = $article_info['sort_order'];
        } else {
            $data['sort_order'] = 1;
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($article_info)) {
            $data['status'] = $article_info['status'];
        } else {
            $data['status'] = true;
        }

        // Categories
        $this->load->model('octemplates/blog_category');

        $categories = $this->model_octemplates_blog_category->getAllCategories();

        $data['blog_categories'] = $this->getAllCategories($categories);

        if (isset($this->request->post['main_oct_blog_category_id'])) {
            $data['main_oct_blog_category_id'] = $this->request->post['main_oct_blog_category_id'];
        } elseif (isset($article_info)) {
            $data['main_oct_blog_category_id'] = $this->model_octemplates_blog_article->getArticleMainCategoryId($this->request->get['oct_blog_article_id']);
        } else {
            $data['main_oct_blog_category_id'] = 0;
        }

        if (isset($this->request->post['article_category'])) {
            $data['article_categories'] = $this->request->post['article_categories'];
        } elseif (isset($this->request->get['oct_blog_article_id'])) {
            $data['article_categories'] = $this->model_octemplates_blog_article->getArticleCategories($this->request->get['oct_blog_article_id']);
        } else {
            $data['article_categories'] = array();
        }

        $this->load->model('customer/customer_group');

        $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

        // Images
        if (isset($this->request->post['product_image'])) {
            $article_images = $this->request->post['product_image'];
        } elseif (isset($this->request->get['oct_blog_article_id'])) {
            $article_images = $this->model_octemplates_blog_article->getArticleImages($this->request->get['oct_blog_article_id']);
        } else {
            $article_images = array();
        }

        $data['article_images'] = array();

        foreach ($article_images as $product_image) {
            if (is_file(DIR_IMAGE . $product_image['image'])) {
                $image = $product_image['image'];
                $thumb = $product_image['image'];
            } else {
                $image = '';
                $thumb = 'no_image.png';
            }

            $data['article_images'][] = array(
                'image' => $image,
                'thumb' => $this->model_tool_image->resize($thumb, 100, 100),
                'sort_order' => $product_image['sort_order']
            );
        }

        $this->load->model('catalog/product');

        if (isset($this->request->post['product_related'])) {
            $products = $this->request->post['product_related'];
        } elseif (isset($this->request->get['oct_blog_article_id'])) {
            $products = $this->model_octemplates_blog_article->getArticleProductsRelated($this->request->get['oct_blog_article_id']);
        } else {
            $products = array();
        }

        $data['product_relateds'] = array();

        foreach ($products as $product_id) {
            $product_info = $this->model_catalog_product->getProduct($product_id);

            if ($product_info) {
                $data['product_relateds'][] = array(
                    'product_id' => $product_info['product_id'],
                    'name' => $product_info['name']
                );
            }
        }

        if (isset($this->request->post['article_related'])) {
            $articles = $this->request->post['article_related'];
        } elseif (isset($this->request->get['oct_blog_article_id'])) {
            $articles = $this->model_octemplates_blog_article->getArticleArticlesRelated($this->request->get['oct_blog_article_id']);
        } else {
            $articles = array();
        }

        $data['article_relateds'] = array();

        foreach ($articles as $article_id) {
            $result_article_info = $this->model_octemplates_blog_article->getArticle($article_id);

            if ($result_article_info) {
                $data['article_relateds'][] = array(
                    'oct_blog_article_id' => $result_article_info['oct_blog_article_id'],
                    'name' => $result_article_info['name']
                );
            }
        }

        if (isset($this->request->post['article_layout'])) {
            $data['article_layout'] = $this->request->post['article_layout'];
        } elseif (isset($this->request->get['oct_blog_article_id'])) {
            $data['article_layout'] = $this->model_octemplates_blog_article->getArticleLayouts($this->request->get['oct_blog_article_id']);
        } else {
            $data['article_layout'] = array();
        }

        $this->load->model('design/layout');

        $data['layouts'] = $this->model_design_layout->getLayouts();

        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('octemplates/blog_article_form.tpl', $data));
    }

    private function getAllCategories($categories, $oct_blog_category_parent_id = 0, $parent_name = '') {
        $output = array();

        if (array_key_exists($oct_blog_category_parent_id, $categories)) {
            if ($parent_name != '') {
                $parent_name .= $this->language->get('text_separator');
            }

            foreach ($categories[$oct_blog_category_parent_id] as $category) {
                $output[$category['oct_blog_category_id']] = array(
                    'oct_blog_category_id' => $category['oct_blog_category_id'],
                    'name' => $parent_name . $category['name']
                );

                $output += $this->getAllCategories($categories, $category['oct_blog_category_id'], $parent_name . $category['name']);
            }
        }

        return $output;
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'octemplates/blog_article')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        foreach ($this->request->post['article_description'] as $language_id => $value) {
            if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
                $this->error['name'][$language_id] = $this->language->get('error_name');
            }

            if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
                $this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
            }
        }

        if (utf8_strlen($this->request->post['keyword']) > 0) {
            $this->load->model('catalog/url_alias');

            $url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);

            if ($url_alias_info && isset($this->request->get['oct_blog_article_id']) && $url_alias_info['query'] != 'oct_blog_article_id=' . $this->request->get['oct_blog_article_id']) {
                $this->error['keyword'] = sprintf($this->language->get('error_keyword'));
            }

            if ($url_alias_info && !isset($this->request->get['oct_blog_article_id'])) {
                $this->error['keyword'] = sprintf($this->language->get('error_keyword'));
            }
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'octemplates/blog_article')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    protected function validateCopy() {
        if (!$this->user->hasPermission('modify', 'octemplates/blog_article')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function autocompleteArticle() {
        $json = array();

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('octemplates/blog_article');

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

            $results = $this->model_octemplates_blog_article->getArticles($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'oct_blog_article_id' => $result['oct_blog_article_id'],
                    'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function autocompleteProduct() {
        $json = array();

        if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
            $this->load->model('catalog/product');

            if (isset($this->request->get['filter_name'])) {
                $filter_name = $this->request->get['filter_name'];
            } else {
                $filter_name = '';
            }

            if (isset($this->request->get['filter_model'])) {
                $filter_model = $this->request->get['filter_model'];
            } else {
                $filter_model = '';
            }

            if (isset($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
            } else {
                $limit = 5;
            }

            $filter_data = array(
                'filter_name' => $filter_name,
                'filter_model' => $filter_model,
                'start' => 0,
                'limit' => $limit
            );

            $results = $this->model_catalog_product->getProducts($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'product_id' => $result['product_id'],
                    'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
