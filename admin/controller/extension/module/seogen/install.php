<?php

class ControllerExtensionModuleSeogenInstall extends Controller {
    public function index() {
        $this->install();
    }
    private function install() {
        $this->load->language('module/seogen');
        $this->load->model('setting/setting');

        $query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "manufacturer_description'");
        if(!$query->num_rows){
            $this->db->query("CREATE TABLE `" . DB_PREFIX . "manufacturer_description` (
			 `manufacturer_id` int(11) NOT NULL DEFAULT '0',
			 `language_id` int(11) NOT NULL DEFAULT '0',
			 `description` text NOT NULL,
			 `meta_description` varchar(255) NOT NULL,
			 `meta_keyword` varchar(255) NOT NULL,
			 `meta_title` varchar(255) NOT NULL,
			 `meta_h1` varchar(255) NOT NULL,
			 PRIMARY KEY (`manufacturer_id`,`language_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
        }

        $query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "seogen_profile'");
        if(!$query->num_rows) {
            $this->db->query("CREATE TABLE `" . DB_PREFIX . "seogen_profile` (" .
                " `profile_id` int(11) NOT NULL AUTO_INCREMENT," .
                " `name` varchar(255) NOT NULL," .
                " `data` text NOT NULL," .
                " PRIMARY KEY (`profile_id`)" .
                " ) ENGINE=MyISAM DEFAULT CHARSET=utf8");
        }

        foreach($this->getTables() as $table => $val) {
            $query = $this->db->query("DESC `" . DB_PREFIX . $table . "`");
            $fields = array();
            foreach($query->rows as $row) {
                $fields[] = $row['Field'];
            }
            foreach($this->getFields() as $field_name => $tmpl) {
                if(!in_array($field_name, $fields)) {
                    $this->db->query("ALTER TABLE `" . DB_PREFIX . $table . "` ADD `" . $field_name . "` varchar(255) NOT NULL");
                }
            }
        }

        $query = $this->db->query("DESC `" . DB_PREFIX . "product_to_category`");
        $fields = array();
        foreach($query->rows as $row) {
            $fields[] = $row['Field'];
        }
        if(!in_array("main_category", $fields)) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_to_category` ADD `main_category` tinyint(1) NOT NULL DEFAULT '0'");
        }

        $seogen = $this->getDefaultTags();
        $this->model_setting_setting->editSetting('seogen', $seogen);

        $this->load->model('extension/event');
        $this->model_extension_event->addEvent('seogen', 'admin/model/catalog/product/addProduct/after', 'module/seogen/eventGenProductAdd_23');
        $this->model_extension_event->addEvent('seogen', 'admin/model/catalog/product/editProduct/after', 'module/seogen/eventGenProductEdit_23');

        $this->model_extension_event->addEvent('seogen', 'admin/model/catalog/category/addCategory/after', 'module/seogen/eventGenCategoryAdd_23');
        $this->model_extension_event->addEvent('seogen', 'admin/model/catalog/category/editCategory/after', 'module/seogen/eventGenCategoryEdit_23');

        $this->model_extension_event->addEvent('seogen', 'admin/model/catalog/manufacturer/addManufacturer/after', 'module/seogen/eventGenManufacturerAdd_23');
        $this->model_extension_event->addEvent('seogen', 'admin/model/catalog/manufacturer/editManufacturer/after', 'module/seogen/eventGenManufacturerEdit_23');

        $this->model_extension_event->addEvent('seogen', 'admin/model/catalog/information/addInformation/after', 'module/seogen/eventGenInformationAdd_23');
        $this->model_extension_event->addEvent('seogen', 'admin/model/catalog/information/editInformation/after', 'module/seogen/eventGenInformationEdit_23');

        $this->load->model('user/user_group');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'module/seogen');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'module/seogen');

        $this->session->data['success'] = $this->language->get('text_install_success');

    }

    private function getTables() {
        return array(
            "category_description" => "categories",
            "product_description" => "products",
            "manufacturer_description" => "manufacturers",
            "information_description" => "informations",
        );
    }

    private function getFields() {
        return array(
            "meta_title" => "meta_title",
            "meta_h1" => "meta_h1",
            "meta_description" => "meta_description",
            "meta_keyword" => "meta_keyword");
    }

    private function getDefaultTags() {
        $seogen = array('seogen_status' => 1,
            'seogen' => array(
                'seogen_overwrite' => 1,
                'categories_template' => $this->language->get('text_categories_tags'),
                'categories_description_template' => $this->language->get('text_categories_description_tags'),
                'categories_meta_description_limit' => 160,
                'products_template' => $this->language->get('text_products_tags'),
                'products_model_template' => $this->language->get('text_products_model_tags'),
                'products_description_template' => $this->language->get('text_products_description_tags'),
                'products_meta_description_limit' => 160,
                'products_img_alt_template' => $this->language->get('text_products_img_alt'),
                'products_img_title_template' => $this->language->get('text_products_img_title'),
                'manufacturers_template' => $this->language->get('text_manufacturers_tags'),
                'manufacturers_description_template' => $this->language->get('text_manufacturers_description_tags'),
                'informations_template' => $this->language->get('text_informations_tags'),
            ));
        foreach($this->getTables() as $table => $val) {
            foreach($this->getFields() as $field_name => $tmpl) {
                $seogen['seogen'][$val . '_' . $tmpl . '_template'] = $this->language->get('text_' . $val . '_' . $tmpl . '_tags');
            }
        }
        $seogen['seogen']['products_tag_template'] = $this->language->get('text_products_tag_tags');
        return $seogen;
    }

}