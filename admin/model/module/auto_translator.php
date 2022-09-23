<?php
class ModelModuleAutoTranslator extends Model {
    
    public function install() {
        $this->db->query("UPDATE `" . DB_PREFIX . "modification` SET status=1 WHERE `name` LIKE'%Auto Translator%'");
        return $this->db->query("SELECT * FROM `" . DB_PREFIX . "modification` WHERE `name` LIKE'%Auto Translator%'");
    }

    public function uninstall() {
        $this->db->query("UPDATE `" . DB_PREFIX . "modification` SET status=0 WHERE `name` LIKE'%Auto Translator%'");
        return $this->db->query("SELECT * FROM `" . DB_PREFIX . "modification` WHERE `name` LIKE'%Auto Translator%'");
    }

    public function updateProduct($data, $language_id, $product_id){
        $sql = '';
        foreach ($data as $key => $field){
            $sql .= " " . $key . " = '" . $this->db->escape($field) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "product_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "product_description SET";
            $end = " product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateProductAttribute($data, $language_id, $product_id, $attribute_id){
        $sql = '';
        if(isset($data['text'])){
            $sql .= " text = '" . $this->db->escape($data['text']) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "product_attribute WHERE attribute_id = '" . (int)$attribute_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "product_attribute SET";
            $sql = trim($sql, ",");
            $end = " WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$attribute_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "product_attribute SET";
            $end = " product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateCategory($data, $language_id, $category_id){
        $sql = '';
        foreach ($data as $key => $field){
            $sql .= " " . $key . " = '" . $this->db->escape($field) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "category_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE category_id = '" . (int)$category_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "category_description SET";
            $end = " category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateFilter($data, $language_id, $filter_id, $filter_group_id) {
        $sql = '';
        if(isset($data['name'])){
            $sql .= " name = '" . $this->db->escape($data['name']) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "filter_description WHERE filter_id = '" . (int)$filter_id . "' AND filter_group_id = '" . (int)$filter_group_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "filter_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE filter_id = '" . (int)$filter_id . "' AND filter_group_id = '" . (int)$filter_group_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "filter_description SET";
            $end = " filter_id = '" . (int)$filter_id . "', filter_group_id = '" . (int)$filter_group_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateFilterGroup($data, $language_id, $filter_group_id) {
        $sql = '';
        if(isset($data['name'])){
            $sql .= " name = '" . $this->db->escape($data['name']) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "filter_group_description WHERE  filter_group_id = '" . (int)$filter_group_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "filter_group_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE filter_group_id = '" . (int)$filter_group_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "filter_group_description SET";
            $end = " filter_group_id = '" . (int)$filter_group_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateAttribute($data, $language_id, $attribute_id) {
        $sql = '';
        if(isset($data['name'])){
            $sql .= " name = '" . $this->db->escape($data['name']) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "attribute_description WHERE  attribute_id = '" . (int)$attribute_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "attribute_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE attribute_id = '" . (int)$attribute_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "attribute_description SET";
            $end = " attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateAttributeGroup($data, $language_id, $attribute_group_id) {
        $sql = '';
        if(isset($data['name'])){
            $sql .= " name = '" . $this->db->escape($data['name']) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "attribute_group_description WHERE  attribute_group_id = '" . (int)$attribute_group_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "attribute_group_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE attribute_group_id = '" . (int)$attribute_group_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "attribute_group_description SET";
            $end = " attribute_group_id = '" . (int)$attribute_group_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateOption($data, $language_id, $option_id) {
        $sql = '';
        if(isset($data['name'])){
            $sql .= " name = '" . $this->db->escape($data['name']) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "option_description WHERE  option_id = '" . (int)$option_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "option_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE option_id = '" . (int)$option_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "option_description SET";
            $end = " option_id = '" . (int)$option_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateOptionValue($data, $language_id, $option_value_id, $option_id) {
        $sql = '';
        if(isset($data['name'])){
            $sql .= " name = '" . $this->db->escape($data['name']) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "option_value_description WHERE option_value_id = '" . (int)$option_value_id . "' AND option_id = '" . (int)$option_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "option_value_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE option_value_id = '" . (int)$option_value_id . "' AND option_id = '" . (int)$option_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "option_value_description SET";
            $end = " option_value_id = '" . (int)$option_value_id . "', option_id = '" . (int)$option_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateDownload($data, $language_id, $download_id) {
        $sql = '';
        if(isset($data['name'])){
            $sql .= " name = '" . $this->db->escape($data['name']) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "download_description WHERE  download_id = '" . (int)$download_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "download_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE download_id = '" . (int)$download_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "download_description SET";
            $end = " download_id = '" . (int)$download_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateBanner($data, $language_id, $banner_image_id, $banner_id) {
        $sql = '';
        if(isset($data['title'])){
            $sql .= " title = '" . $this->db->escape($data['title']) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "banner_image_description WHERE banner_image_id = '" . (int)$banner_image_id . "' AND banner_id = '" . (int)$banner_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "banner_image_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE banner_image_id = '" . (int)$banner_image_id . "' AND banner_id = '" . (int)$banner_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "banner_image_description SET";
            $end = " banner_image_id = '" . (int)$banner_image_id . "', banner_id = '" . (int)$banner_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateRecurring($data, $language_id, $recurring_id) {
        $sql = '';
        if(isset($data['name'])){
            $sql .= " name = '" . $this->db->escape($data['name']) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "recurring_description WHERE  recurring_id = '" . (int)$recurring_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "recurring_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE recurring_id = '" . (int)$recurring_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "recurring_description SET";
            $end = " recurring_id = '" . (int)$recurring_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateInformation($data, $language_id, $information_id){
        $sql = '';
        foreach ($data as $key => $field){
            $sql .= " " . $key . " = '" . $this->db->escape($field) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "information_description WHERE information_id = '" . (int)$information_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "information_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE information_id = '" . (int)$information_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "information_description SET";
            $end = " information_id = '" . (int)$information_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateCustomerGroup($data, $language_id, $customer_group_id){
        $sql = '';
        foreach ($data as $key => $field){
            $sql .= " " . $key . " = '" . $this->db->escape($field) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "customer_group_description WHERE customer_group_id = '" . (int)$customer_group_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "customer_group_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE customer_group_id = '" . (int)$customer_group_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "customer_group_description SET";
            $end = " customer_group_id = '" . (int)$customer_group_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateCustomField($data, $language_id, $custom_field_id) {
        $sql = '';
        if(isset($data['name'])){
            $sql .= " name = '" . $this->db->escape($data['name']) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "custom_field_description WHERE  custom_field_id = '" . (int)$custom_field_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "custom_field_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE custom_field_id = '" . (int)$custom_field_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "custom_field_description SET";
            $end = " custom_field_id = '" . (int)$custom_field_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateCustomFieldValue($data, $language_id, $custom_field_value_id, $custom_field_id) {
        $sql = '';
        if(isset($data['name'])){
            $sql .= " name = '" . $this->db->escape($data['name']) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "custom_field_value_description WHERE custom_field_value_id = '" . (int)$custom_field_value_id . "' AND custom_field_id = '" . (int)$custom_field_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "custom_field_value_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE custom_field_value_id = '" . (int)$custom_field_value_id . "' AND custom_field_id = '" . (int)$custom_field_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "custom_field_value_description SET";
            $end = " custom_field_value_id = '" . (int)$custom_field_value_id . "', custom_field_id = '" . (int)$custom_field_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateVoucherTheme($data, $language_id, $voucher_theme_id) {
        $sql = '';
        if(isset($data['name'])){
            $sql .= " name = '" . $this->db->escape($data['name']) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "voucher_theme_description WHERE  voucher_theme_id = '" . (int)$voucher_theme_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "voucher_theme_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE voucher_theme_id = '" . (int)$voucher_theme_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "voucher_theme_description SET";
            $end = " voucher_theme_id = '" . (int)$voucher_theme_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateLengthClass($data, $language_id, $length_class_id){
        $sql = '';
        foreach ($data as $key => $field){
            $sql .= " " . $key . " = '" . $this->db->escape($field) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "length_class_description WHERE length_class_id = '" . (int)$length_class_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "length_class_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE length_class_id = '" . (int)$length_class_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "length_class_description SET";
            $end = " length_class_id = '" . (int)$length_class_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function updateWeightClass($data, $language_id, $weight_class_id){
        $sql = '';
        foreach ($data as $key => $field){
            $sql .= " " . $key . " = '" . $this->db->escape($field) . "',";
        }
        $count = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "weight_class_description WHERE weight_class_id = '" . (int)$weight_class_id . "' AND language_id = '" . (int)$language_id . "'");
        if($count->row['total']){
            $start = "UPDATE " . DB_PREFIX . "weight_class_description SET";
            $sql = trim($sql, ",");
            $end = " WHERE weight_class_id = '" . (int)$weight_class_id . "' AND language_id = '" . (int)$language_id . "'";
        } else {
            $start = "INSERT INTO " . DB_PREFIX . "weight_class_description SET";
            $end = " weight_class_id = '" . (int)$weight_class_id . "', language_id = '" . (int)$language_id . "'";
        }
        return $this->db->query($start . $sql . $end);
    }

    public function getProducts($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "product p ";
        if (!empty($data['category_id']) && $data['category_id']) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) ";
        }
        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
        WHERE pd.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (!empty($data['category_id']) && $data['category_id']) {
            $sql .= " AND p2c.category_id = '" . (int)$data['category_id'] . "'";
        }
        if (isset($data['status_id'])) {
            $sql .= " AND p.status = '" . (int)$data['status_id'] . "'";
        }
        if (isset($data['item_id'])) {
            $sql .= " AND p.product_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND p.product_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        $sql .= " GROUP BY p.product_id ORDER BY p.product_id ASC";
        return $this->db->query($sql);
    }

    public function getProductAttributes($data = array()) {
        $sql = "SELECT pa.product_id, pa.attribute_id, pa.language_id, pa.text FROM " . DB_PREFIX . "product_attribute pa ";
        if (!empty($data['category_id']) && $data['category_id']) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (pa.product_id = p2c.product_id) ";
        }
        $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (pa.product_id = p.product_id) 
        WHERE pa.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (!empty($data['category_id']) && $data['category_id']) {
            $sql .= " AND p2c.category_id = '" . (int)$data['category_id'] . "'";
        }
        if (isset($data['status_id'])) {
            $sql .= " AND p.status = '" . (int)$data['status_id'] . "'";
        }
        if (isset($data['item_id'])) {
            $sql .= " AND p.product_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND p.product_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        $sql .= " GROUP BY p.product_id ORDER BY p.product_id ASC";
        return $this->db->query($sql);
    }

    public function getCategories($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE cd.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (isset($data['status_id'])) {
            $sql .= " AND c.status = '" . (int)$data['status_id'] . "'";
        }
        if (isset($data['item_id'])) {
            $sql .= " AND c.category_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND c.category_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        $sql .= " GROUP BY c.category_id ORDER BY c.category_id ASC";
        return $this->db->query($sql);
    }

    public function getFilters($data = array()) {
        $sql = "SELECT f.filter_id, f.filter_group_id, fd.language_id , fd.name FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE fd.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (isset($data['item_id'])) {
            $sql .= " AND f.filter_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND f.filter_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        $sql .= " ORDER BY f.filter_id ASC";
        return $this->db->query($sql);
    }

    public function getFilterGroups($data = array()) {
        $sql = "SELECT fg.filter_group_id, fgd.language_id , fgd.name FROM " . DB_PREFIX . "filter_group fg LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id) WHERE fgd.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (isset($data['item_id'])) {
            $sql .= " AND fg.filter_group_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND fg.filter_group_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        $sql .= " ORDER BY fg.filter_group_id ASC";
        return $this->db->query($sql);
    }

    public function getAttributes($data = array()) {
        $sql = "SELECT a.attribute_id, ad.language_id, ad.name FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE ad.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (isset($data['item_id'])) {
            $sql .= " AND a.attribute_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND a.attribute_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        $sql .= " ORDER BY a.attribute_id ASC";
        return $this->db->query($sql);
    }

    public function getAttributeGroups($data = array()) {
        $sql = "SELECT ag.attribute_group_id, agd.language_id, agd.name FROM " . DB_PREFIX . "attribute_group ag LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE agd.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (isset($data['item_id'])) {
            $sql .= " AND ag.attribute_group_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND ag.attribute_group_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        $sql .= " ORDER BY ag.attribute_group_id ASC";
        return $this->db->query($sql);
    }

    public function getOptions($data = array()) {
        $sql = "SELECT o.option_id, od.language_id, od.name FROM `" . DB_PREFIX . "option` o LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE od.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (isset($data['item_id'])) {
            $sql .= " AND o.option_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND o.option_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        $sql .= " ORDER BY o.option_id ASC";
        return $this->db->query($sql);
    }

    public function getOptionValues($data = array()) {
        $sql = "SELECT ov.option_value_id, ov.option_id, ovd.language_id, ovd.name FROM `" . DB_PREFIX . "option_value` ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE ovd.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (isset($data['item_id'])) {
            $sql .= " AND ov.option_value_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND ov.option_value_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        $sql .= " ORDER BY ov.option_value_id ASC";
        return $this->db->query($sql);
    }

    public function getDownloads($data = array()) {
        $sql = "SELECT d.download_id, dd.language_id, dd.name FROM `" . DB_PREFIX . "download` d LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE dd.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (isset($data['item_id'])) {
            $sql .= " AND d.download_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND d.download_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        $sql .= " ORDER BY d.download_id ASC";
        return $this->db->query($sql);
    }

    public function getInformation($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) WHERE id.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (isset($data['item_id'])) {
            $sql .= " AND i.information_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND i.information_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        if (isset($data['status_id'])) {
            $sql .= " AND i.status = '" . (int)$data['status_id'] . "'";
        }
        $sql .= " ORDER BY i.information_id ASC";
        return $this->db->query($sql);
    }

    public function getBanners($data = array()) {
        $sql = "SELECT bi.banner_image_id, bi.banner_id, bid.language_id, bid.title FROM " . DB_PREFIX . "banner_image bi 
        LEFT JOIN " . DB_PREFIX . "banner b ON (b.banner_id = bi.banner_id)
        LEFT JOIN " . DB_PREFIX . "banner_image_description bid ON (bi.banner_image_id = bid.banner_image_id) 
        WHERE bid.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (isset($data['item_id'])) {
            $sql .= " AND bi.banner_image_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND bi.banner_image_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        if (isset($data['status_id'])) {
            $sql .= " AND b.status = '" . (int)$data['status_id'] . "'";
        }
        $sql .= " ORDER BY bi.banner_image_id ASC";
        return $this->db->query($sql);
    }

    public function getRecurring($data = array()) {
        $sql = "SELECT r.recurring_id, rd.language_id, rd.name FROM " . DB_PREFIX . "recurring r 
        LEFT JOIN " . DB_PREFIX . "recurring_description rd ON (r.recurring_id = rd.recurring_id) 
        WHERE rd.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (isset($data['item_id'])) {
            $sql .= " AND r.recurring_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND r.recurring_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        if (isset($data['status_id'])) {
            $sql .= " AND r.status = '" . (int)$data['status_id'] . "'";
        }
        $sql .= " ORDER BY r.recurring_id ASC";
        return $this->db->query($sql);
    }

    public function getCustomerGroups($data = array()) {
        $sql = "SELECT cg.customer_group_id, cgd.language_id, cgd.name, cgd.description FROM " . DB_PREFIX . "customer_group cg 
        LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) 
        WHERE cgd.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (isset($data['item_id'])) {
            $sql .= " AND cg.customer_group_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND cg.customer_group_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        $sql .= " ORDER BY cg.customer_group_id ASC";
        return $this->db->query($sql);
    }

    public function getCustomFields($data = array()) {
        $sql = "SELECT cf.custom_field_id, cfd.language_id, cfd.name FROM " . DB_PREFIX . "custom_field cf 
        LEFT JOIN " . DB_PREFIX . "custom_field_description cfd ON (cf.custom_field_id = cfd.custom_field_id) 
        WHERE cfd.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (isset($data['item_id'])) {
            $sql .= " AND cf.custom_field_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND cf.custom_field_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        if (isset($data['status_id'])) {
            $sql .= " AND cf.status = '" . (int)$data['status_id'] . "'";
        }
        $sql .= " ORDER BY cf.custom_field_id ASC";
        return $this->db->query($sql);
    }

    public function getCustomFieldValues($data = array()) {
        $sql = "SELECT cfv.custom_field_value_id, cfv.custom_field_id, cfvd.language_id, cfvd.name FROM " . DB_PREFIX . "custom_field_value cfv
        LEFT JOIN " . DB_PREFIX . "custom_field cf ON (cfv.custom_field_id = cf.custom_field_id) 
        LEFT JOIN " . DB_PREFIX . "custom_field_value_description cfvd ON (cfv.custom_field_value_id = cfvd.custom_field_value_id) 
        WHERE cfvd.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (isset($data['item_id'])) {
            $sql .= " AND cfv.custom_field_value_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND cfv.custom_field_value_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        if (isset($data['status_id'])) {
            $sql .= " AND cf.status = '" . (int)$data['status_id'] . "'";
        }
        $sql .= " ORDER BY cfv.custom_field_value_id ASC";
        return $this->db->query($sql);
    }

    public function getVoucherThemes($data = array()) {
        $sql = "SELECT vt.voucher_theme_id, vtd.language_id, vtd.name FROM `" . DB_PREFIX . "voucher_theme` vt LEFT JOIN " . DB_PREFIX . "voucher_theme_description vtd ON (vt.voucher_theme_id = vtd.voucher_theme_id) WHERE vtd.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (isset($data['item_id'])) {
            $sql .= " AND vt.voucher_theme_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND vt.voucher_theme_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        $sql .= " ORDER BY vt.voucher_theme_id ASC";
        return $this->db->query($sql);
    }

    public function getLengthClasses($data = array()) {
        $sql = "SELECT lc.length_class_id, lcd.language_id, lcd.title, lcd.unit FROM `" . DB_PREFIX . "length_class` lc LEFT JOIN " . DB_PREFIX . "length_class_description lcd ON (lc.length_class_id = lcd.length_class_id) WHERE lcd.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (isset($data['item_id'])) {
            $sql .= " AND lc.length_class_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND lc.length_class_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        $sql .= " ORDER BY lc.length_class_id ASC";
        return $this->db->query($sql);
    }

    public function getWeightClasses($data = array()) {
        $sql = "SELECT wc.weight_class_id, wcd.language_id, wcd.title, wcd.unit FROM `" . DB_PREFIX . "weight_class` wc LEFT JOIN " . DB_PREFIX . "weight_class_description wcd ON (wc.weight_class_id = wcd.weight_class_id) WHERE wcd.language_id = '" . (int)$this->config->get('auto_translator_source') . "'";
        if (isset($data['item_id'])) {
            $sql .= " AND wc.weight_class_id = '" . (int)$data['item_id'] . "'";
        }
        if (isset($data['item_list'])) {
            $sql .= " AND wc.weight_class_id IN ('" . implode("','",$data['item_list']) . "')";
        }
        $sql .= " ORDER BY wc.weight_class_id ASC";
        return $this->db->query($sql);
    }

    public function getProductsByCategoryId($category_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p 
        LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
        LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)
         WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
         AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");

        return $query->rows;
    }

    public function getGoogleLanguages() {
       return array(
            'af' => 'Afrikaans',
            'sq' => 'Albanian',
            'am' => 'Amharic',
            'ar' => 'Arabic',
            'hy' => 'Armenian',
            'az' => 'Azerbaijani',
            'eu' => 'Basque',
            'be' => 'Belarusian',
            'bn' => 'Bengali',
            'bs' => 'Bosnian',
            'bg' => 'Bulgarian',
            'ca' => 'Catalan',
            'ceb' => 'Cebuano',
            'ny' => 'Chichewa',
            'zh-CN' => 'Chinese Simplified',
            'zh-TW' => 'Chinese Traditional',
            'co' => 'Corsican',
            'hr' => 'Croatian',
            'cs' => 'Czech',
            'da' => 'Danish',
            'nl' => 'Dutch',
            'en' => 'English',
            'eo' => 'Esperanto',
            'et' => 'Estonian',
            'tl' => 'Filipino',
            'fi' => 'Finnish',
            'fr' => 'French',
            'fy' => 'Frisian',
            'gl' => 'Galician',
            'ka' => 'Georgian',
            'de' => 'German',
            'el' => 'Greek',
            'gu' => 'Gujarati',
            'ht' => 'Haitian Creole',
            'ha' => 'Hausa',
            'haw' => 'Hawaiian',
            'iw' => 'Hebrew',
            'hi' => 'Hindi',
            'hmn' => 'Hmong',
            'hu' => 'Hungarian',
            'is' => 'Icelandic',
            'ig' => 'Igbo',
            'id' => 'Indonesian',
            'ga' => 'Irish',
            'it' => 'Italian',
            'ja' => 'Japanese',
            'jw' => 'Javanese',
            'kn' => 'Kannada',
            'kk' => 'Kazakh',
            'km' => 'Khmer',
            'ko' => 'Korean',
            'ku' => 'Kurdish',
            'ky' => 'Kyrgyz',
            'lo' => 'Lao',
            'la' => 'Latin',
            'lv' => 'Latvian',
            'lt' => 'Lithuanian',
            'lb' => 'Luxembourgish',
            'mk' => 'Macedonian',
            'mg' => 'Malagasy',
            'ms' => 'Malay',
            'ml' => 'Malayalam',
            'mt' => 'Maltese',
            'mi' => 'Maori',
            'mr' => 'Marathi',
            'mn' => 'Mongolian',
            'my' => 'Myanmar (Burmese)',
            'ne' => 'Nepali',
            'no' => 'Norwegian',
            'ps' => 'Pashto',
            'fa' => 'Persian',
            'pl' => 'Polish',
            'pt' => 'Portuguese',
            'ma' => 'Punjabi',
            'ro' => 'Romanian',
            'ru' => 'Russian',
            'sm' => 'Samoan',
            'gd' => 'Scots Gaelic',
            'sr' => 'Serbian',
            'st' => 'Sesotho',
            'sn' => 'Shona',
            'sd' => 'Sindhi',
            'si' => 'Sinhala',
            'sk' => 'Slovak',
            'sl' => 'Slovenian',
            'so' => 'Somali',
            'es' => 'Spanish',
            'su' => 'Sudanese',
            'sw' => 'Swahili',
            'sv' => 'Swedish',
            'tg' => 'Tajik',
            'ta' => 'Tamil',
            'te' => 'Telugu',
            'th' => 'Thai',
            'tr' => 'Turkish',
            'uk' => 'Ukrainian',
            'ur' => 'Urdu',
            'uz' => 'Uzbek',
            'vi' => 'Vietnamese',
            'cy' => 'Welsh',
            'xh' => 'Xhosa',
            'yi' => 'Yiddish',
            'yo' => 'Yoruba',
            'zu' => 'Zulu'
        );
    }
    public function getMicrosoftLanguages() {
        return array(
            'af' => 'Afrikaans',
            'ar' => 'Arabic',
            'bs-Latn' => 'Bosnian (Latin)',
            'bg' => 'Bulgarian',
            'ca' => 'Catalan',
            'zh-CHS' => 'Chinese Simplified',
            'zh-CHT' => 'Chinese Traditional',
            'hr' => 'Croatian',
            'cs' => 'Czech',
            'da' => 'Danish',
            'nl' => 'Dutch',
            'en' => 'English',
            'et' => 'Estonian',
            'fi' => 'Finnish',
            'fr' => 'French',
            'de' => 'German',
            'el' => 'Greek',
            'ht' => 'Haitian Creole',
            'he' => 'Hebrew',
            'hi' => 'Hindi',
            'mww' => 'Hmong Daw',
            'hu' => 'Hungarian',
            'id' => 'Indonesian',
            'it' => 'Italian',
            'ja' => 'Japanese',
            'sw' => 'Kiswahili',
            'tlh' => 'Klingon',
            'tlh-Qaak' => 'Klingon (pIqaD)',
            'ko' => 'Korean',
            'lv' => 'Latvian',
            'lt' => 'Lithuanian',
            'ms' => 'Malay',
            'mt' => 'Maltese',
            'no' => 'Norwegian',
            'fa' => 'Persian',
            'pl' => 'Polish',
            'pt' => 'Portuguese',
            'otq' => 'Querétaro Otomi',
            'ro' => 'Romanian',
            'ru' => 'Russian',
            'sr-Cyrl' => 'Serbian (Cyrillic)',
            'sr-Latn' => 'Serbian (Latin)',
            'sk' => 'Slovak',
            'sl' => 'Slovenian',
            'es' => 'Spanish',
            'sv' => 'Swedish',
            'th' => 'Thai',
            'tr' => 'Turkish',
            'uk' => 'Ukrainian',
            'ur' => 'Urdu',
            'vi' => 'Vietnamese',
            'cy' => 'Welsh',
            'yua' => 'Yucatec Maya'
            );
    }

    public function getMicrosoftToken() {
        if($this->config->get('auto_translator_microsoft_token')){
            if(!isset($_COOKIE['cm_token']) || $_COOKIE['cm_token'] == ''){
                $ch = curl_init();
                $paramArr = array (
                    'grant_type'    => 'client_credentials',
                    'scope'         => 'http://api.microsofttranslator.com',
                    'client_id'     => $this->config->get('auto_translator_client_id'),
                    'client_secret' => $this->config->get('auto_translator_client_secret')
                );
                $paramArr = http_build_query($paramArr);
                curl_setopt($ch, CURLOPT_URL, 'https://datamarket.accesscontrol.windows.net/v2/OAuth2-13/');
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $paramArr);
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $strResponse = curl_exec($ch);
                curl_close($ch);
                $objResponse = json_decode($strResponse);
                if (isset($objResponse->access_token)) {
                    setcookie("cm_token",$objResponse->access_token,time()+480);
                    return $objResponse->access_token;
                } else {
                    return $objResponse;
                }
            } else {
                return $_COOKIE['cm_token'];
            }
        } else {
            $ch = curl_init();
            $paramArr = array (
                'grant_type'    => 'client_credentials',
                'scope'         => 'http://api.microsofttranslator.com',
                'client_id'     => $this->config->get('auto_translator_client_id'),
                'client_secret' => $this->config->get('auto_translator_client_secret')
            );
            $paramArr = http_build_query($paramArr);
            curl_setopt($ch, CURLOPT_URL, 'https://datamarket.accesscontrol.windows.net/v2/OAuth2-13/');
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $paramArr);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $strResponse = curl_exec($ch);
            curl_close($ch);
            $objResponse = json_decode($strResponse);
            if (isset($objResponse->access_token)) {
                return $objResponse->access_token;
            } else {
                return $objResponse;
            }
        }
    }

    public function getСognitiveMicrosoftToken() {
        if($this->config->get('auto_translator_microsoft_token')){
            if(!isset($_COOKIE['cm_token']) || $_COOKIE['cm_token'] == ''){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.cognitive.microsoft.com/sts/v1.0/issueToken?Subscription-Key=' . $this->config->get('auto_translator_microsoft_key'));
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS,  '');
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $strResponse = curl_exec($ch);
                curl_close($ch);
                $objResponse = json_decode($strResponse);
                if(is_object($objResponse)) {
                    return $objResponse;
                } else {
                    setcookie("cm_token",$strResponse,time()+480);
                    return $strResponse;
                }
            } else {
                return $_COOKIE['cm_token'];
            }
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.cognitive.microsoft.com/sts/v1.0/issueToken?Subscription-Key=' . $this->config->get('auto_translator_microsoft_key'));
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS,  '');
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $strResponse = curl_exec($ch);
            curl_close($ch);
            $objResponse = json_decode($strResponse);
            if(is_object($objResponse)) {
                return $objResponse;
            } else {
                return $strResponse;
            }
        }
    }

    public function getLanguageByCode($code) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "language` WHERE code = '" . $this->db->escape($code) . "'");
        return $query->row;
    }
}