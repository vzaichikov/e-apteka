<?php

class ControllerExtensionModulePriceControl extends Controller
{
    private $error = array();


    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->language('extension/module/price_control');
        $this->load->model('extension/module/price_control');
        $this->load->model('catalog/category');

    }

    public function reinstall()
    {
        $this->db->query("DROP TABLE IF EXISTS `pricecontrol_data`;");
        $this->uninstall();
        $this->install();
        $this->session->data['success'] = $this->language->get('text_success');
        $this->response->redirect($this->url->link('extension/module/price_control', 'token=' . $this->session->data['token'], 'SSL'));
    }

    public function install()
    {
        $this->model_extension_module_price_control->createTable();
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('price_control', array('price_control_status' => 1, 'price_control_version' => $this->model_extension_module_price_control->getVersion(), 'price_control_filter_category_newmode' => 1, 'price_control_filter_manufacturer_newmode' => 1));
    }

    public function backup()
    {
        $this->model_extension_module_price_control->restore();
        $this->session->data['success'] = $this->language->get('text_success');
        $this->response->redirect($this->url->link('extension/module/price_control', 'token=' . $this->session->data['token'], 'SSL'));
    }

    public function uninstall()
    {
        $this->model_extension_module_price_control->deleteTable();

    }

    public function index()
    {
        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->addStyle('view/stylesheet/pricecontrol.css');
        $this->document->addStyle('view/javascript/jstree/themes/default/style.min.css');
        $this->document->addScript('view/javascript/jstree/jstree.min.js');
        $data['allow_backup'] = $this->model_extension_module_price_control->checkData();
        $data['categories'] = $this->getCategoriesJson(0);
        $data['manufacturers'] = $this->getManufacturersJson();
        $data['customer_groups'] = $this->getCustomerGroups();
        $data['price_types'] = $this->getPriceTypes();
        $data['math_actions'] = $this->getMathActions();
        $data['version'] = '';
        $data['backup_link'] = $this->url->link('extension/module/price_control/backup', 'token=' . $this->session->data['token'], 'SSL');

        if (!$this->config->get('price_control_status') || (!$this->config->get('price_control_version') || $this->config->get('price_control_version') != $this->model_extension_module_price_control->getVersion())) {
            $this->error['warning'] = $this->language->get('text_not_installed') . " <a href=\"" . $this->url->link('extension/module/price_control/reinstall', 'token=' . $this->session->data['token'], 'SSL') . "\">Переустановить</a>";
        } else {
            $data['version'] = $this->config->get('price_control_version');
        }
        $data['price_control_filter_category_newmode'] = $this->config->get('price_control_filter_category_newmode');
        $data['price_control_filter_manufacturer_newmode'] = $this->config->get('price_control_filter_manufacturer_newmode');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (!isset($this->request->post['priceControl_delete_special']) && !isset($this->request->post['priceControl_delete_discount'])) {
                $this->processChanges();
            } else {
                $this->processDelete(isset($this->request->post['priceControl_delete_special']) ? 'special' : 'discount');
            }
        }
        $data['heading_title'] = $this->language->get('heading_title');
        $data['button_close'] = $this->language->get('button_close');
        $data['text_confirm'] = $this->language->get('text_confirm');
        $data['text_restore_changes_question'] = $this->language->get('text_restore_changes_question');
        $data['text_confirm_action'] = $this->language->get('text_confirm_action');
        $data['text_undo_last_changes'] = $this->language->get('text_undo_last_changes');
        $data['text_author'] = $this->language->get('text_author');
        $data['text_copyright'] = $this->language->get('text_copyright');
        $data['error_action'] = $this->language->get('error_action');
        $data['text_filter'] = $this->language->get('text_filter');
        $data['text_prices'] = $this->language->get('text_prices');
        $data['text_delete_special'] = $this->language->get('text_delete_special');
        $data['text_delete_discount'] = $this->language->get('text_delete_discount');
        $data['text_add_settings'] = $this->language->get('text_add_settings');
        $data['text_create_if_not_exists'] = $this->language->get('text_create_if_not_exists');
        $data['text_discount_qty'] = $this->language->get('text_discount_qty');
        $data['text_special_discount_actions'] = $this->language->get('text_special_discount_actions');
        $data['text_formula_and_actions'] = $this->language->get('text_formula_and_actions');
        $data['help_filter'] = $this->language->get('help_filter');
        $data['help_prices'] = $this->language->get('help_prices');
        $data['help_create_if_not_exists'] = $this->language->get('help_create_if_not_exists');
        $data['help_delete_special_discount'] = $this->language->get('help_delete_special_discount');
        $data['text_categories'] = $this->language->get('text_categories');
        $data['text_include_subcategories'] = $this->language->get('text_include_subcategories');
        $data['text_manufacturers'] = $this->language->get('text_manufacturers');
        $data['text_customer_groups'] = $this->language->get('text_customer_groups');
        $data['entry_value'] = $this->language->get('entry_value');
        $data['text_percent'] = $this->language->get('text_percent');
        $data['text_number'] = $this->language->get('text_number');
        $data['button_run'] = $this->language->get('button_run');
        $data['button_rollback'] = $this->language->get('button_rollback');
        $data['token'] = $this->session->data['token'];

        // Categories
        $this->load->model('catalog/category');

        if (isset($this->request->post['product_category'])) {
            $categories = $this->request->post['product_category'];
        } elseif (isset($this->request->get['product_id'])) {
            $categories = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
        } else {
            $categories = array();
        }

        $data['product_categories'] = array();

        foreach ($categories as $category_id) {
            $category_info = $this->model_catalog_category->getCategory($category_id);

            if ($category_info) {
                $data['product_categories'][] = array(
                    'category_id' => $category_info['category_id'],
                    'name' => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
                );
            }
        }

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
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/price_control', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link('extension/module/price_control', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');
        $this->load->model('design/layout');

        $data['layouts'] = $this->model_design_layout->getLayouts();
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');


        $this->response->setOutput($this->load->view('extension/module/price_control.tpl', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/price_control')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!empty($this->request->post)) {

            if (!isset($this->request->post['priceControl_categories'])) {
                $this->request->post['priceControl_categories'] = array();
            }
            if (!isset($this->request->post['priceControl_manufacturers'])) {
                $this->request->post['priceControl_manufacturers'] = array();
            }
            if (!isset($this->request->post['priceControl_customer_groups'])) {
                $this->request->post['priceControl_customer_groups'] = array();
            }

            if (!isset($this->request->post['priceControl_delete_special']) && !isset($this->request->post['priceControl_delete_discount'])) {
                if (!isset($this->request->post['priceControl_create_if_not_exists'])) {
                    $this->request->post['priceControl_create_if_not_exists'] = 0;
                }
                if (!isset($this->request->post['new_discount_quantity'])) {
                    $this->request->post['new_discount_quantity'] = 10;
                }
                if (!isset($this->request->post['priceControl_price_types'])) {
                    $this->request->post['priceControl_price_types'][] = ModelExtensionModulePriceControl::PRICE_CONTROL_TYPE_BASE;
                } else if (!empty($this->request->post['priceControl_price_types'])) {
                    foreach ($this->request->post['priceControl_price_types'] as $priceType) {
                        if (!in_array($priceType, array_keys($this->model_extension_module_price_control->getPriceTypes()))) {
                            $this->error['warning'] = $this->language->get('error_data');
                            break;
                        }
                    }
                }

                if (!isset($this->request->post['action']) || !$this->request->post['action']) {
                    $this->error['warning'] = $this->language->get('error_data');
                } else {
                    if (!in_array($this->request->post['action'], array_keys($this->model_extension_module_price_control->getMathActions()))) {
                        $this->error['warning'] = $this->language->get('error_data');
                    } else {
                        switch ($this->request->post['action']) {
                            case ModelExtensionModulePriceControl::PRICE_CONTROL_ACTION_ADDICT:
                                $this->request->post['action'] = '+';
                                break;
                            case ModelExtensionModulePriceControl::PRICE_CONTROL_ACTION_DEDUCT:
                                $this->request->post['action'] = '-';
                                break;
                            case ModelExtensionModulePriceControl::PRICE_CONTROL_ACTION_MULTIPLY:
                                $this->request->post['action'] = '*';
                                break;
                            case ModelExtensionModulePriceControl::PRICE_CONTROL_ACTION_DIVIDE:
                                $this->request->post['action'] = '/';
                                break;
                            default:
                                $this->error['warning'] = $this->language->get('error_data');
                        }
                    }
                }

                if (!isset($this->request->post['num']) || empty($this->request->post['num'])) {
                    $this->error['warning'] = $this->language->get('error_data');
                } else {
                    $this->request->post['num'] = str_replace(",", ".", $this->request->post['num']);
                    if (!is_numeric(floatval($this->request->post['num'])) || floatval($this->request->post['num']) == 0) {
                        $this->error['warning'] = $this->language->get('error_data');
                    }
                }
                if (!isset($this->request->post['unit']) || !$this->request->post['unit']) {
                    $this->error['warning'] = $this->language->get('error_data');
                }
            }
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    protected function processDelete($type)
    {
        if (in_array($type, array('special', 'discount'))) {
            $post_categories = $this->request->post['priceControl_categories'];
            $post_manufacturers = $this->request->post['priceControl_manufacturers'];
            $post_customer_groups = isset($this->request->post['priceControl_customer_groups']) ? $this->request->post['priceControl_customer_groups'] : array();
            $price_control_filter_category_newmode = isset($this->request->post['price_control_filter_category_newmode']) ? $this->request->post['price_control_filter_category_newmode'] : '';
            $price_control_filter_manufacturer_newmode = isset($this->request->post['price_control_filter_manufacturer_newmode']) ? $this->request->post['price_control_filter_manufacturer_newmode'] : '';

            if ($price_control_filter_category_newmode) {
                $filter_category_include_subcategories = isset($this->request->post['filter-category_include_subcategories']) ? $this->request->post['filter-category_include_subcategories'] : '';
                if ($filter_category_include_subcategories && !empty($post_categories)) {
                    $post_subcategories = array();
                    foreach ($post_categories as $post_category) {
                        $post_subcategories = array_merge($post_subcategories, $this->getChildCategories($post_category));
                    }
                    if (!empty($post_subcategories)) {
                        $post_categories = array_merge($post_categories, $post_subcategories);
                    }
                }
                $this->load->model('setting/setting');
                $this->model_setting_setting->editSettingValue('price_control', 'price_control_filter_category_newmode', $price_control_filter_category_newmode ? 1 : 0);
            }
            $post_categories = array_unique($post_categories);

            if ($price_control_filter_manufacturer_newmode) {
                $this->load->model('setting/setting');
                $this->model_setting_setting->editSettingValue('price_control', 'price_control_filter_manufacturer_newmode', $price_control_filter_manufacturer_newmode ? 1 : 0);
            }
            if ($this->deleteData($type, array(
                'categories' => $post_categories,
                'manufacturers' => $post_manufacturers,
                'customer_groups' => $post_customer_groups))
            ) {
                $this->session->data['success'] = $this->language->get('text_success');
                $this->response->redirect($this->url->link('extension/module/price_control', 'token=' . $this->session->data['token'], 'SSL'));
            }
        }
    }

    protected function processChanges()
    {

        //filter data
        $post_create_if_not_exists = $this->request->post['priceControl_create_if_not_exists'];
        $post_new_discount_quantity = $this->request->post['new_discount_quantity'];
        $post_categories = $this->request->post['priceControl_categories'];
        $post_manufacturers = $this->request->post['priceControl_manufacturers'];
        $post_customer_groups = isset($this->request->post['priceControl_customer_groups']) ? $this->request->post['priceControl_customer_groups'] : array();
        $price_control_filter_category_newmode = isset($this->request->post['price_control_filter_category_newmode']) ? $this->request->post['price_control_filter_category_newmode'] : 0;
        $price_control_filter_manufacturer_newmode = isset($this->request->post['price_control_filter_manufacturer_newmode']) ? $this->request->post['price_control_filter_manufacturer_newmode'] : 0;
        $post_price_types = isset($this->request->post['priceControl_price_types']) ? $this->request->post['priceControl_price_types'] : array();
        $post_action = $this->request->post['action'];
        $post_num = $this->request->post['num'];
        $post_unit = $this->request->post['unit'];

        if ($price_control_filter_category_newmode) {
            $filter_category_include_subcategories = isset($this->request->post['filter-category_include_subcategories']) ? $this->request->post['filter-category_include_subcategories'] : '';
            if ($filter_category_include_subcategories && !empty($post_categories)) {
                $post_subcategories = array();
                foreach ($post_categories as $post_category) {
                    $post_subcategories = array_merge($post_subcategories, $this->getChildCategories($post_category));
                }
                if (!empty($post_subcategories)) {
                    $post_categories = array_merge($post_categories, $post_subcategories);
                }
            }
        }
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSettingValue('price_control', 'price_control_filter_category_newmode', $price_control_filter_category_newmode ? 1 : 0);
        $this->model_setting_setting->editSettingValue('price_control', 'price_control_filter_manufacturer_newmode', $price_control_filter_manufacturer_newmode ? 1 : 0);

        $post_categories = array_unique($post_categories);


        if ($this->updatePrices($post_price_types, $post_action, $post_num, $post_unit, array(
            'categories' => $post_categories,
            'manufacturers' => $post_manufacturers,
            'customer_groups' => $post_customer_groups,
            'priceControl_create_if_not_exists' => $post_create_if_not_exists,
            'new_discount_quantity' => $post_new_discount_quantity,
        ))
        ) {
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/module/price_control', 'token=' . $this->session->data['token'], 'SSL'));
        }

    }

    protected function getChildCategories($parent_id)
    {
        $results = $this->model_extension_module_price_control->getCategories($parent_id);
        $output = array($parent_id);
        if ($results) {
            foreach ($results as $result) {
                $output = array_merge($output, $this->getChildCategories($result['category_id']));
            }
        }
        return $output;
    }

    protected function getCategoriesJson($parent_id)
    {
        $this_cat = $this->model_catalog_category->getCategory($parent_id);
        if (!$this_cat) {
            $this_cat['category_id'] = $parent_id;
            $this_cat['name'] = $this->language->get('text_all_categories');
        }
        $output = array(
            'id' => 'category' . $this_cat['category_id'],
            'text' => $this_cat['name'],
        );
        $results = $this->model_extension_module_price_control->getCategories($parent_id);
        if ($results) {
            $output['text'] = $this_cat['name'];
            foreach ($results as $result) {
                $output['children'][] = $this->getCategoriesJson($result['category_id']);
            }
        }
        return $output;
    }

    protected function getManufacturersJson()
    {
        $output = array(
            'id' => 'manufacturer0',
            'text' => $this->language->get('text_manufacturers'),
        );
        $this->load->model('catalog/manufacturer');
        $manufacturers = $this->model_catalog_manufacturer->getManufacturers();
        if (!empty($manufacturers)) {
            foreach ($manufacturers as $manufacturer) {
                $output['children'][] = array(
                    'id' => 'manufacturer' . $manufacturer['manufacturer_id'],
                    'text' => $manufacturer['name'],
                );
            }
        }
        return $output;
    }

    protected function getManufacturers()
    {
        $output = '';
        $this->load->model('catalog/manufacturer');
        $manufacturers = $this->model_catalog_manufacturer->getManufacturers();
        if (!empty($manufacturers)) {
            $output .= '<ul style="list-style:none;">';
            foreach ($manufacturers as $manufacturer) {
                $output .= '<li><input type="checkbox" name="priceControl_manufacturers[]" value="' . $manufacturer['manufacturer_id'] . '" />' . $manufacturer['name'] . '</li>';
            }
            $output .= '</ul>';
        }
        return $output;
    }

    protected function getCustomerGroups()
    {
        $output = '';

        $sql = "SELECT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        $sort_data = array(
            'cgd.name',
            'cg.sort_order'
        );
        $sql .= " ORDER BY cgd.name";

        $sql .= " ASC";

        $query = $this->db->query($sql);

        $customer_groups = $query->rows;
        if (!empty($customer_groups)) {
            $output .= '<ul style="list-style:none;">';
            foreach ($customer_groups as $customer_group) {
                $output .= '<li><input type="checkbox" name="priceControl_customer_groups[]" value="' . $customer_group['customer_group_id'] . '" /> ' . $customer_group['name'] . ' <small>(' . $customer_group['description'] . ')</small></li>';
            }
            $output .= '</ul>';
        }
        return $output;
    }

    protected function getPriceTypes()
    {
        $output = '';
        $priceTypes = $this->model_extension_module_price_control->getPriceTypes();
        if (!empty($priceTypes)) {
            $output .= '<ul style="list-style:none;">';
            foreach ($priceTypes as $priceType => $priceTitle) {
                $output .= '<li><input type="checkbox" name="priceControl_price_types[]" value="' . $priceType . '" /> ' . $this->language->get("{$priceTitle}") . '</li>';
            }
            $output .= '</ul>';

        }
        return $output;
    }

    protected function getMathActions()
    {
        $output = '';
        $mathActions = $this->model_extension_module_price_control->getMathActions();
        if (!empty($mathActions)) {
            $count = 1;
            $button_styles = array(
                'success',
                'warning',
                'info',
                'danger'
            );
            foreach ($mathActions as $mathAction => $mathTitle) {
                if ($count != 1) {
                    $checked = '';
                    $active = "";
                } else {
                    $checked = 'checked';
                    $active = "active";
                }
                $count++;
                $output .= '<button class="btn btn-' . $button_styles[$count - 2] . ' ' . $active . '"><input type="radio" ' . $checked . ' name="action" value="' . $mathAction . '" />' . $this->language->get("{$mathTitle}") . '</button>';
            }

        }
        return $output;
    }

    protected function updatePrices($price_types, $action, $num, $unit, $filter)
    {
        $this->load->model('extension/module/price_control');
        return $this->model_extension_module_price_control->updatePrices($price_types, $action, $num, $unit, $filter);
    }

    protected function deleteData($type, $filter)
    {
        $this->load->model('extension/module/price_control');
        return $this->model_extension_module_price_control->deleteData($type, $filter);
    }
}

?>