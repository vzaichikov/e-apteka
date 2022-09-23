<?php
class ControllerCatalogOCFilter extends Controller {
  private $error = array();
  private $get = array(
    'filter_name' => null,
    'filter_type' => null,
    'filter_status' => null,
    'filter_category_id' => null,
    'page' => 1,
    'sort' => 'ood.name',
    'order' => 'ASC'
  );

  public function index() {
    $this->load->language('catalog/ocfilter');

    $this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('catalog/ocfilter');

    $data['language_id'] = $this->config->get('config_language_id');

    $this->getList();
  }

  public function add() {
    $this->load->language('catalog/ocfilter');

    $this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('catalog/ocfilter');

    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
      $this->model_catalog_ocfilter->addOption($this->request->post);

      $this->session->data['success'] = $this->language->get('text_success');

      $url = '';

      foreach ($this->get as $key => $value) {
        if (isset($this->request->get[$key])) {
          $url .= '&' . $key . '=' . $this->request->get[$key];
        }
      }

      $this->response->redirect($this->url->link('catalog/ocfilter', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    }

    $this->getForm();
  }

  public function edit() {
    $this->load->language('catalog/ocfilter');

    $this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('catalog/ocfilter');

    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
      $this->model_catalog_ocfilter->editOption($this->request->get['option_id'], $this->request->post);

      $this->session->data['success'] = $this->language->get('text_success');

      $url = '';

      foreach ($this->get as $key => $value) {
        if (isset($this->request->get[$key])) {
          $url .= '&' . $key . '=' . $this->request->get[$key];
        }
      }

      $this->response->redirect($this->url->link('catalog/ocfilter', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    }

    $this->getForm();
  }

  public function delete() {
    $this->load->language('catalog/ocfilter');
    $this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('catalog/ocfilter');

    if (isset($this->request->post['selected'])) {
      foreach ($this->request->post['selected'] as $option_id) {
        $this->model_catalog_ocfilter->deleteOption($option_id);
      }

      $this->session->data['success'] = $this->language->get('text_success');

      $url = '';

      foreach ($this->get as $key => $value) {
        if (isset($this->request->get[$key])) {
          $url .= '&' . $key . '=' . $this->request->get[$key];
        }
      }

      $this->response->redirect($this->url->link('catalog/ocfilter', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    }

    $this->getList();
  }

  private function getList() {
    $data = $this->load->language('catalog/ocfilter');

    $this->document->addStyle('view/stylesheet/ocfilter/ocfilter.css');
    $this->document->addScript('view/javascript/ocfilter/ocfilter.js');

    foreach ($this->get as $key => $value) {
      if (isset($this->request->get[$key])) {
        $$key = $this->request->get[$key];
      } else {
        $$key = null;
      }
    }

    $data['breadcrumbs']   = array();

    $data['breadcrumbs'][] = array(
      'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      'text' => $this->language->get('text_home')
    );

    $data['breadcrumbs'][] = array(
      'href' => $this->url->link('catalog/ocfilter', 'token=' . $this->session->data['token'], 'SSL'),
      'text' => $this->language->get('heading_title')
    );

    $url = '';

    foreach ($this->get as $key => $value) {
      if (isset($this->request->get[$key])) {
        $url .= '&' . $key . '=' . $this->request->get[$key];
      }
    }

    $data['add']  = $this->url->link('catalog/ocfilter/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
    $data['delete']  = $this->url->link('catalog/ocfilter/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

    $data['options'] = array();

    $filter_data = array();

    foreach ($this->get as $key => $value) {
      $filter_data[$key] = $$key;
    }

    $filter_data['start'] = ($page - 1) * $this->config->get('config_limit_admin');
    $filter_data['limit'] = $this->config->get('config_limit_admin');
    $option_total         = $this->model_catalog_ocfilter->getTotalOptions($filter_data);
    $results              = $this->model_catalog_ocfilter->getOptions($filter_data);
    $visible              = 5;

    foreach ($results as $result) {
      $values = array();

      foreach ($result['values'] as $value) {
        $values[] = $value['name'];
      }

      if ($values) {
        if (count($values) > $visible) {
          $values = array_slice($values, 0, $visible);
          $values[$visible - 1] .= $result['postfix'] . sprintf($this->language->get('text_and_more'), (count($result['values']) - $visible));
        } else {
          $values[count($values) - 1] .= $result['postfix'];
        }
      }

      $categories = array();

      foreach ($result['categories'] as $category) {
        $categories[] = $category['name'];
      }

      if (count($categories) > $visible) {
        $categories = array_slice($categories, 0, $visible);

        $categories[$visible - 1] .= sprintf($this->language->get('text_and_more'), (count($result['categories']) - $visible));
      }

      $data['options'][] = array(
        'option_id' => $result['option_id'],
        'name' => $result['name'],
        'type' => $result['type'],
        'sort_order' => $result['sort_order'],
        'selected' => isset($this->request->post['selected']) && in_array($result['option_id'], $this->request->post['selected']),
        'values' => html_entity_decode(implode(' &bull; ', $values), ENT_QUOTES, 'UTF-8'),
        'categories' => implode(' &bull; ', $categories),
        'status' => $result['status'],
        'selectbox' => $result['selectbox'],
        'edit' => $this->url->link('catalog/ocfilter/edit', 'token=' . $this->session->data['token'] . '&option_id=' . $result['option_id'] . $url, 'SSL')
      );
    }

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

    $url = '';

    foreach ($this->get as $key => $value) {
      if (isset($this->request->get[$key]) && $key != 'sort' && $key != 'order') {
        $url .= '&' . $key . '=' . $this->request->get[$key];
      }
    }

    if ($order == 'ASC') {
      $url .= '&order=DESC';
    } else {
      $url .= '&order=ASC';
    }

    $data['sort_name']        = $this->url->link('catalog/ocfilter', 'token=' . $this->session->data['token'] . '&sort=ood.name' . $url, 'SSL');
    $data['sort_type']        = $this->url->link('catalog/ocfilter', 'token=' . $this->session->data['token'] . '&sort=oo.type' . $url, 'SSL');
    $data['sort_category_id'] = $this->url->link('catalog/ocfilter', 'token=' . $this->session->data['token'] . '&sort=oo2c.category_id' . $url, 'SSL');
    $data['sort_status']      = $this->url->link('catalog/ocfilter', 'token=' . $this->session->data['token'] . '&sort=oo.status' . $url, 'SSL');
    $data['sort_order']       = $this->url->link('catalog/ocfilter', 'token=' . $this->session->data['token'] . '&sort=oo.sort_order' . $url, 'SSL');

    $url = '';

    foreach ($this->get as $key => $value) {
      if (isset($this->request->get[$key]) && $key != 'page') {
        $url .= '&' . $key . '=' . $this->request->get[$key];
      }
    }

    $pagination         = new Pagination();
    $pagination->total  = $option_total;
    $pagination->page   = $page;
    $pagination->limit  = $this->config->get('config_limit_admin');
    $pagination->text   = $this->language->get('text_pagination');
    $pagination->url    = $this->url->link('catalog/ocfilter', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

    $data['pagination'] = $pagination->render();

    $data['results'] = sprintf($this->language->get('text_pagination'), ($option_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($option_total - $this->config->get('config_limit_admin'))) ? $option_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $option_total, ceil($option_total / $this->config->get('config_limit_admin')));

    foreach ($this->get as $key => $value) {
      $data[$key] = $$key;
    }

    $data['types'] = array(
      'checkbox' => $this->language->get('text_checkbox'),
      'radio' => $this->language->get('text_radio'),
      'slide' => $this->language->get('text_slide'),
      'slide_dual' => $this->language->get('text_slide_dual'),
    );

    $data['filter_get'] = array();

    foreach ($this->get as $key => $value) {
      if ($key != 'sort' && $key != 'order' && $key != 'page') {
        $data['filter_get'][] = $key;
      }
    }

    $data['categories']  = $this->model_catalog_ocfilter->getCategories(0);

    $data['header']      = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer']      = $this->load->controller('common/footer');

    $this->response->setOutput($this->load->view('catalog/ocfilter_list.tpl', $data));
  }

  private function getForm() {
    $data = $this->load->language('catalog/ocfilter');

    $this->document->addStyle('view/stylesheet/ocfilter/ocfilter.css');
    $this->document->addScript('view/javascript/ocfilter/ocfilter.js');

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

    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
      'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      'text' => $this->language->get('text_home')
    );

    $data['breadcrumbs'][] = array(
      'href' => $this->url->link('catalog/ocfilter', 'token=' . $this->session->data['token'], 'SSL'),
      'text' => $this->language->get('heading_title')
    );

    $url = '';

    foreach ($this->get as $key => $value) {
      if (isset($this->request->get[$key])) {
        $url .= '&' . $key . '=' . $this->request->get[$key];
      }
    }

    if (!isset($this->request->get['option_id'])) {
      $data['action'] = $this->url->link('catalog/ocfilter/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
    } else {
      $data['action'] = $this->url->link('catalog/ocfilter/edit', 'token=' . $this->session->data['token'] . '&option_id=' . $this->request->get['option_id'] . $url, 'SSL');
    }

    $data['cancel'] = $this->url->link('catalog/ocfilter', 'token=' . $this->session->data['token'] . $url, 'SSL');

    $data['token'] = $this->session->data['token'];

    $this->load->model('localisation/language');

    $data['languages'] = $this->model_localisation_language->getLanguages();

    if (isset($this->request->get['option_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      $option_info = $this->model_catalog_ocfilter->getOption($this->request->get['option_id']);
    }

    if (isset($this->request->post['name'])) {
      $data['name'] = $this->request->post['name'];
    } elseif (isset($this->request->get['option_id'])) {
      $option_description = $this->model_catalog_ocfilter->getOptionDescriptions($this->request->get['option_id']);

      $data['name'] = $option_description;

      $data['breadcrumbs'][] = array(
        'href' => $this->url->link('catalog/ocfilter/edit', 'token=' . $this->session->data['token'] . '&option_id=' . $this->request->get['option_id'], 'SSL'),
        'text' => $option_description[$this->config->get('config_language_id')]['name']
      );
    } else {
      $data['name'] = array();
    }

    if (isset($this->request->post['option_values'])) {
      $data['ocfilter_option_values'] = $this->request->post['option_values'];
    } elseif (isset($this->request->get['option_id'])) {
      $data['ocfilter_option_values'] = $this->model_catalog_ocfilter->getOptionValues($this->request->get['option_id']);
    } else {
      $data['ocfilter_option_values'] = array();
    }

    $this->load->model('tool/image');

    $data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 22, 22);

    foreach ($data['ocfilter_option_values'] as $key => $value) {
      if ($value['image'] && file_exists(DIR_IMAGE . $value['image'])) {
        $data['ocfilter_option_values'][$key]['thumb'] = $this->model_tool_image->resize($value['image'], 22, 22);
      } else {
        $data['ocfilter_option_values'][$key]['thumb'] = $this->model_tool_image->resize('placeholder.png', 22, 22);
      }
    }

    if (isset($this->request->post['sort_order'])) {
      $data['sort_order'] = $this->request->post['sort_order'];
    } elseif (isset($option_info)) {
      $data['sort_order'] = $option_info['sort_order'];
    } else {
      $data['sort_order'] = 0;
    }

    if (isset($this->request->post['status'])) {
      $data['status'] = $this->request->post['status'];
    } elseif (isset($option_info)) {
      $data['status'] = $option_info['status'];
    } else {
      $data['status'] = 1;
    }

    $data['types'] = array(
      'checkbox' => $this->language->get('text_checkbox'),
      'radio' => $this->language->get('text_radio'),
      'slide' => $this->language->get('text_slide'),
      'slide_dual' => $this->language->get('text_slide_dual'),
    );

    if (isset($this->request->post['type'])) {
      $data['type'] = $this->request->post['type'];
    } elseif (isset($option_info)) {
      $data['type'] = $option_info['type'];
    } else {
      $data['type'] = '';
    }

    if (isset($this->request->post['keyword'])) {
      $data['keyword'] = $this->request->post['keyword'];
    } elseif (isset($option_info)) {
      $data['keyword'] = $option_info['keyword'];
    } else {
      $data['keyword'] = '';
    }

    if (isset($this->request->post['selectbox'])) {
      $data['selectbox'] = $this->request->post['selectbox'];
    } elseif (isset($option_info)) {
      $data['selectbox'] = $option_info['selectbox'];
    } else {
      $data['selectbox'] = 0;
    }

    if (isset($this->request->post['color'])) {
      $data['color'] = $this->request->post['color'];
    } elseif (isset($option_info)) {
      $data['color'] = $option_info['color'];
    } else {
      $data['color'] = 0;
    }

    if (isset($this->request->post['image'])) {
      $data['image'] = $this->request->post['image'];
    } elseif (isset($option_info)) {
      $data['image'] = $option_info['image'];
    } else {
      $data['image'] = 0;
    }

    if (isset($this->request->post['option_categories'])) {
      $data['option_categories'] = $this->request->post['option_categories'];
    } elseif (isset($option_info)) {
      $data['option_categories'] = $this->model_catalog_ocfilter->getOptionCategories($this->request->get['option_id']);
    } else {
      $data['option_categories'] = array();
    }

    $this->load->model('setting/store');

    $data['stores'] = $this->model_setting_store->getStores();

    if (isset($this->request->post['option_store'])) {
      $data['option_store'] = $this->request->post['option_store'];
    } elseif (isset($this->request->get['option_id'])) {
      $data['option_store'] = $this->model_catalog_ocfilter->getOptionStores($this->request->get['option_id']);
    } else {
      $data['option_store'] = array(0);
    }

    $data['header']      = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer']      = $this->load->controller('common/footer');

    $this->response->setOutput($this->load->view('catalog/ocfilter_form.tpl', $data));
  }

  public function callback() {
    $json = array();

    $this->load->language('catalog/ocfilter');
    $this->load->model('catalog/ocfilter');
    $this->load->model('localisation/language');

    $languages = $this->model_localisation_language->getLanguages();

    $json['message'] = '';
    $json['options'] = array();

    if (isset($this->request->get['category_id'])) {

      if (isset($this->request->get['product_id'])) {
        $product_values = $this->model_catalog_ocfilter->getProductValues($this->request->get['product_id']);
      } else {
        $product_values = array();
      }

      if ($results = $this->model_catalog_ocfilter->getOptionsByCategoryId($this->request->get['category_id'])) {
        foreach (array_values($results) as $key => $option) {
          if (!$option['status']) {
          	continue;
          }

          $values      = array();
          $description = array();

          foreach ($languages as $language) {
            $description[$language['language_id']] = array(
              'description' => ''
            );
          }

          if ($option['type'] != 'slide' && $option['type'] != 'slide_dual' && $option['type'] != 'text') {
            foreach ($option['values'] as $_key => $value) {
              $values[$_key] = array(
                'value_id' => (string)$value['value_id'],
                'name' => $value['name'],
                'description' => $description,
                'selected' => (bool)false
              );

              if (isset($product_values[$option['option_id']][$value['value_id']])) {
                $values[$_key]['selected']    = (bool)true;
                $values[$_key]['description'] = $product_values[$option['option_id']][$value['value_id']]['description'];
              }
            }
          }

          $json['options'][$key] = array(
            'option_id' => (string)$option['option_id'],
            'name' => $option['name'],
            'postfix' => $option['postfix'],
            'status' => (int) $option['status'],
            'type' => $option['type'],
            'slide_value_min' => '',
            'slide_value_max' => '',
            'description' => $description,
            'values' => $values
          );

          if (isset($product_values[$option['option_id']][0])) {
            $product_value                            = array_shift($product_values[$option['option_id']]);
            $json['options'][$key]['description']     = $product_value['description'];
            $json['options'][$key]['slide_value_min'] = ((float) $product_value['slide_value_min'] ? preg_replace('!(0+?$)|(\.0+?$)!', '', $product_value['slide_value_min']) : '');
            $json['options'][$key]['slide_value_max'] = ((float) $product_value['slide_value_max'] ? preg_replace('!(0+?$)|(\.0+?$)!', '', $product_value['slide_value_max']) : '');
          }
        }
      } else {
        $json['message'] = $this->language->get('text_no_options');
      }
    } else {
      $json['message'] = $this->language->get('text_select_category');
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function editImmediately() {
    $json = array();

    if (isset($this->request->post['option_id']) && isset($this->request->post['field']) && isset($this->request->post['value'])) {
      if ($this->request->post['field'] == 'name') {
        $this->db->query("UPDATE " . DB_PREFIX . "ocfilter_option_description SET name = '" . $this->db->escape(urldecode($this->request->post['value'])) . "' WHERE option_id = '" . (int) $this->request->post['option_id'] . "' AND language_id = '" . (int) $this->config->get('config_language_id') . "'");
      } else {
        $this->db->query("UPDATE " . DB_PREFIX . "ocfilter_option SET `" . $this->db->escape($this->request->post['field']) . "` = '" . $this->db->escape($this->request->post['value']) . "' WHERE option_id = '" . (int) $this->request->post['option_id'] . "'");
      }

      if ($this->request->post['field'] == 'type' && ($this->request->post['value'] == 'slide' || $this->request->post['value'] == 'slide_dual')) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ocfilter_option_value_description WHERE option_id = '" . (int)$this->request->post['option_id'] . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

        foreach ($query->rows as $result) {
          $slide_value = str_replace(',', '.', $result['name']);
          $slide_value = trim(preg_replace('/[^0-9\.\-]+/s', '', $slide_value));

          if (is_numeric($slide_value)) {
    		    $this->db->query("UPDATE IGNORE " . DB_PREFIX . "ocfilter_option_value_to_product SET value_id = '0', slide_value_min = '" . (float)$slide_value . "', slide_value_max = '" . (float)$slide_value . "' WHERE option_id = '" . (int)$result['option_id'] . "' AND value_id = '" . (string)$result['value_id'] . "'");
          }
        }
      }

      $this->cache->delete('ocfilter');
      $this->cache->delete('product');

      $json['status'] = true;
    } else {
      $json['status'] = false;
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  private function validateForm() {
    if (!$this->user->hasPermission('modify', 'catalog/ocfilter')) {
      $this->error['warning'] = $this->language->get('error_permission');
    }

    if (!$this->error) {
      return true;
    } else {
      if (!isset($this->error['warning'])) {
        $this->error['warning'] = $this->language->get('error_required_data');
      }

      return false;
    }
  }
}
?>