<?php

class ModelExtensionModulePriceControl extends Model
{

    //Price types
    const PRICE_CONTROL_TYPE_BASE = 1;
    const PRICE_CONTROL_TYPE_OPTIONS = 2;
    const PRICE_CONTROL_TYPE_DISCOUNTS = 3;
    const PRICE_CONTROL_TYPE_ACTIONS = 4;

    //Units
    const PRICE_CONTROL_UNIT_PERCENT = 1;
    const PRICE_CONTROL_UNIT_NUMBER = 2;

    //Math actions
    const PRICE_CONTROL_ACTION_ADDICT = 1;
    const PRICE_CONTROL_ACTION_DEDUCT = 2;
    const PRICE_CONTROL_ACTION_MULTIPLY = 3;
    const PRICE_CONTROL_ACTION_DIVIDE = 4;

    public $version = '0.3.6';

    public function getCategories($parent_id = 0)
    {
        $query = $this->db->query("SELECT c.category_id,cd.name FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");

        return $query->rows;
    }

    public function hasChildren($parent_id)
    {
        $query = $this->db->query("SELECT c.category_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' LIMIT 1");
        return $query->num_rows;
    }

    public function getPriceTypes()
    {
        return array(
            self::PRICE_CONTROL_TYPE_BASE => 'text_main_price',
            self::PRICE_CONTROL_TYPE_OPTIONS => 'text_options_price',
            self::PRICE_CONTROL_TYPE_DISCOUNTS => 'text_discounts_price',
            self::PRICE_CONTROL_TYPE_ACTIONS => 'text_actions_price'
        );
    }

    public function getMathActions()
    {
        return array(
            self::PRICE_CONTROL_ACTION_ADDICT => 'text_addict',
            self::PRICE_CONTROL_ACTION_DEDUCT => 'text_deduct',
            self::PRICE_CONTROL_ACTION_MULTIPLY => 'text_multiply',
            self::PRICE_CONTROL_ACTION_DIVIDE => 'text_divide'
        );
    }

    public function updatePrices($price_types, $action, $num, $unit, $filter = array('categories', 'manufacturers', 'customer_groups', 'priceControl_create_if_not_exists'))
    {
        if (!empty($price_types)) {
            $this->clearDbData();
            switch ($unit) {
                case self::PRICE_CONTROL_UNIT_PERCENT:
                    $formule = "%price% $action (($num*%price%)/100)";
                    break;
                case self::PRICE_CONTROL_UNIT_NUMBER:
                    $formule = "%price% $action $num";
                    break;
            }
            foreach ($price_types as $price_type) {
                $query = "";
                $join_filter = "";
                $where_filter = "";

                switch ($price_type) {

                    case self::PRICE_CONTROL_TYPE_BASE:
                        $baseQuery = "SELECT DISTINCT a.product_id as product_id,a.price as price FROM `" . DB_PREFIX . "product` a";
                        if (!empty($filter['categories'])) {
                            $join_filter .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` cat ON a.product_id=cat.product_id";
                            $where_filter .= "cat.category_id IN('" . implode($filter['categories'], "','") . "') AND ";
                        }
                        if (!empty($filter['manufacturers'])) {
                            $where_filter .= "a.manufacturer_id IN('" . implode($filter['manufacturers'], "','") . "') AND ";
                        }
                        $where_filter = chop($where_filter, ' AND ');
                        break;

                    case self::PRICE_CONTROL_TYPE_OPTIONS:
                        $baseQuery = "SELECT DISTINCT opt.product_id as product_id, opt.price as price, opt.product_option_value_id as type_id FROM `" . DB_PREFIX . "product_option_value` opt";
                        if (!empty($filter['categories'])) {
                            $join_filter .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` cat ON cat.product_id=opt.product_id";
                            $where_filter .= "cat.category_id IN('" . implode($filter['categories'], "','") . "') AND ";
                        }
                        if (!empty($filter['manufacturers'])) {
                            $join_filter .= " LEFT JOIN `" . DB_PREFIX . "product` a ON a.product_id=opt.product_id";
                            $where_filter .= "a.manufacturer_id IN('" . implode($filter['manufacturers'], "','") . "') AND ";
                        }
                        $where_filter = chop($where_filter, ' AND ');
                        break;

                    case self::PRICE_CONTROL_TYPE_DISCOUNTS:
                        $baseQuery = "SELECT DISTINCT disc.product_id as product_id,disc.price as price, disc.product_discount_id as type_id FROM `" . DB_PREFIX . "product_discount` disc";
                        if (!empty($filter['categories'])) {
                            $join_filter .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` cat ON cat.product_id=disc.product_id";
                            $where_filter .= "cat.category_id IN('" . implode($filter['categories'], "','") . "') AND ";
                        }
                        if (!empty($filter['manufacturers'])) {
                            $join_filter .= " LEFT JOIN `" . DB_PREFIX . "product` a ON a.product_id=disc.product_id";
                            $where_filter .= "a.manufacturer_id IN('" . implode($filter['manufacturers'], "','") . "') AND ";
                        }
                        if (!empty($filter['customer_groups']) && empty($filter['priceControl_create_if_not_exists'])) {
                            $where_filter .= "disc.customer_group_id IN('" . implode($filter['customer_groups'], "','") . "') AND ";
                        }
                        $where_filter = chop($where_filter, ' AND ');

                        $new_discounts = array();
                        if (!empty($filter['priceControl_create_if_not_exists'])) {
                            $discounts_not_exists_query="SELECT DISTINCT a.product_id as product_id,a.price as price, disc.customer_group_id as customer_group_id FROM `" . DB_PREFIX . "product` a LEFT JOIN `" . DB_PREFIX . "product_discount` disc ON disc.product_id=a.product_id " . (!empty($filter['categories']) ? " LEFT JOIN `" . DB_PREFIX . "product_to_category` cat ON cat.product_id=a.product_id" : "") . " WHERE " . ($where_filter ? $where_filter : '1') . " AND disc.product_id IS NULL";
                            $discounts_not_exists=$this->db->query($discounts_not_exists_query);
                            if ($discounts_not_exists->num_rows) {
                                $customer_groups = array();
                                if (empty($filter['customer_groups'])) {
                                    $c_groups = $this->getCustomerGroups();
                                    if (!empty($c_groups)) {
                                        foreach ($c_groups as $customer_group) {
                                            $customer_groups[] = (int)$customer_group['customer_group_id'];
                                        }
                                    }
                                } else {
                                    $customer_groups = $filter['customer_groups'];
                                }
                                foreach ($discounts_not_exists->rows as $disc_row) {
                                    foreach ($customer_groups as $id) {
                                        if ($disc_row['customer_group_id'] != $id) {
                                            $this->db->query("INSERT INTO `" . DB_PREFIX . "product_discount`(`product_id`,`quantity`,`customer_group_id`,`price`) VALUES('" . (int)$disc_row['product_id'] . "','" . (int)$filter['new_discount_quantity'] . "','" . (int)$id . "','" . $disc_row['price'] . "')");
                                            $new_discounts[] = $this->db->getLastId();
                                        }
                                    }
                                }
                            }
                        }


                        break;

                    case self::PRICE_CONTROL_TYPE_ACTIONS:
                        $baseQuery = "SELECT DISTINCT spec.product_id as product_id,spec.price as price, spec.product_special_id as type_id FROM `" . DB_PREFIX . "product_special` spec";
                        if (!empty($filter['categories'])) {
                            $join_filter .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` cat ON cat.product_id=spec.product_id";
                            $where_filter .= "cat.category_id IN('" . implode($filter['categories'], "','") . "') AND ";
                        }
                        if (!empty($filter['manufacturers'])) {
                            $join_filter .= " LEFT JOIN `" . DB_PREFIX . "product` a ON a.product_id=spec.product_id";
                            $where_filter .= "a.manufacturer_id IN('" . implode($filter['manufacturers'], "','") . "') AND ";
                        }
                        if (!empty($filter['customer_groups']) && empty($filter['priceControl_create_if_not_exists'])) {
                            $where_filter .= "spec.customer_group_id IN('" . implode($filter['customer_groups'], "','") . "') AND ";
                        }
                        $where_filter = chop($where_filter, ' AND ');
                        $new_specials = array();
                        if (!empty($filter['priceControl_create_if_not_exists'])) {
                            $specials_not_exists_query="SELECT DISTINCT a.product_id as product_id,a.price as price, spec.customer_group_id as customer_group_id FROM `" . DB_PREFIX . "product` a LEFT JOIN `" . DB_PREFIX . "product_special` spec ON spec.product_id=a.product_id " . (!empty($filter['categories']) ? " LEFT JOIN `" . DB_PREFIX . "product_to_category` cat ON cat.product_id=a.product_id" : "") . " WHERE " . ($where_filter ? $where_filter : '1') . " AND spec.product_id IS NULL";
                            $specials_not_exists=$this->db->query($specials_not_exists_query);
                            if ($specials_not_exists->num_rows) {
                                $customer_groups = array();
                                if (empty($filter['customer_groups'])) {
                                    $c_groups = $this->getCustomerGroups();
                                    if (!empty($c_groups)) {
                                        foreach ($c_groups as $customer_group) {
                                            $customer_groups[] = (int)$customer_group['customer_group_id'];
                                        }
                                    }
                                } else {
                                    $customer_groups = $filter['customer_groups'];
                                }

                                foreach ($specials_not_exists->rows as $spec_row) {
                                    foreach ($customer_groups as $id) {
                                        if ($spec_row['customer_group_id'] != $id) {
                                            $this->db->query("INSERT INTO `" . DB_PREFIX . "product_special`(`product_id`,`customer_group_id`,`price`) VALUES('" . (int)$spec_row['product_id'] . "','" . (int)$id . "','" . $spec_row['price'] . "')");
                                            $new_specials[] = $this->db->getLastId();
                                        }
                                    }
                                }
                            }
                        }
                        break;
                }
                if ($where_filter != "") {
                    $where_filter = " WHERE " . $where_filter;
                }
                $query = $baseQuery . $join_filter . $where_filter;
                $sql = $this->db->query($query);
                $rows = $sql->rows;
                $insertString = "";
                if (!empty($rows)) {
                    foreach ($rows as $row) {
                        $new_price = str_replace('%price%', $row['price'], $formule);
                        $type = $price_type;
                        $product_id = $row['product_id'];
                        $type_id = isset($row['type_id']) ? $row['type_id'] : '';
                        $price_old = $row['price'];
                        $price_edited = eval("return $new_price;");
                        $was_created = '0';
                        if (in_array($type, array(self::PRICE_CONTROL_TYPE_DISCOUNTS, self::PRICE_CONTROL_TYPE_ACTIONS))) {
                            if ($type == self::PRICE_CONTROL_TYPE_DISCOUNTS && !empty($new_discounts) && in_array($type_id, $new_discounts)) {
                                $was_created = '1';
                            } else if ($type == self::PRICE_CONTROL_TYPE_ACTIONS && !empty($new_specials) && in_array($type_id, $new_specials)) {
                                $was_created = '1';
                            }
                        }
                        $insertString .= "('" . $type_id . "','" . $type . "','" . $product_id . "','" . $price_old . "','" . $price_edited . "','" . $was_created . "'),";

                    }
                    $insertString = chop($insertString, ',');
                    $this->db->query("INSERT INTO " . DB_PREFIX . "pricecontrol_data(`type_id`,`type`,`product_id`,`price_old`,`price_edited`,`was_created`) VALUES " . $insertString);
                }
                switch ($price_type) {
                    case self::PRICE_CONTROL_TYPE_BASE:
                        $this->db->query("UPDATE `" . DB_PREFIX . "product` a, `" . DB_PREFIX . "pricecontrol_data` b SET a.price=b.price_edited WHERE a.product_id=b.product_id AND b.type='" . $price_type . "'");
                        break;
                    case self::PRICE_CONTROL_TYPE_OPTIONS:
                        $this->db->query("UPDATE `" . DB_PREFIX . "product_option_value` a, `" . DB_PREFIX . "pricecontrol_data` b SET a.price=b.price_edited WHERE a.product_id=b.product_id AND a.product_option_value_id=b.type_id AND b.type='" . $price_type . "'");
                        break;
                    case self::PRICE_CONTROL_TYPE_DISCOUNTS:
                        $this->db->query("UPDATE `" . DB_PREFIX . "product_discount` a, `" . DB_PREFIX . "pricecontrol_data` b SET a.price=b.price_edited WHERE a.product_id=b.product_id AND a.product_discount_id=b.type_id AND b.type='" . $price_type . "'");
                        break;
                    case self::PRICE_CONTROL_TYPE_ACTIONS:
                        $this->db->query("UPDATE `" . DB_PREFIX . "product_special` a, `" . DB_PREFIX . "pricecontrol_data` b SET a.price=b.price_edited WHERE a.product_id=b.product_id AND a.product_special_id=b.type_id AND b.type='" . $price_type . "'");
                        break;
                }
            }
            return true;
        }
        return false;
    }

    public function deleteData($type, $filter)
    {
        $join_filter = "";
        $where_filter = "";
        $baseQuery = "DELETE `" . $type . "` FROM `" . DB_PREFIX . "product_" . $type . "` " . $type;
        if (!empty($filter['categories'])) {
            $join_filter .= " LEFT JOIN `" . DB_PREFIX . "product_to_category` cat ON cat.product_id=" . $type . ".product_id";
            $where_filter .= "cat.category_id IN('" . implode($filter['categories'], "','") . "') AND ";
        }
        if (!empty($filter['manufacturers'])) {
            $join_filter .= " LEFT JOIN `" . DB_PREFIX . "product` a ON a.product_id=" . $type . ".product_id";
            $where_filter .= "a.manufacturer_id IN('" . implode($filter['manufacturers'], "','") . "') AND ";
        }
        if (!empty($filter['customer_groups'])) {
            $where_filter .= $type . ".customer_group_id IN('" . implode($filter['customer_groups'], "','") . "') AND ";
        }
        $where_filter = chop($where_filter, ' AND ');
        if ($where_filter != "") {
            $where_filter = " WHERE " . $where_filter;
        }
        $query = $baseQuery . $join_filter . $where_filter;
        $this->db->query($query);
        return true;
    }

    public function getCustomerGroups()
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        $sort_data = array(
            'cgd.name',
            'cg.sort_order'
        );
        $sql .= " ORDER BY cgd.name";

        $sql .= " ASC";

        $query = $this->db->query($sql);

        $customer_groups = $query->rows;
        return $customer_groups;
    }

    public function createTable()
    {
        $query = "
          CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "pricecontrol_data (
  id int(11) NOT NULL AUTO_INCREMENT,
  was_created tinyint(4) DEFAULT '0',
  type_id int(11) DEFAULT NULL,
  type tinyint(4) NOT NULL,
  product_id int(11) NOT NULL,
  price_old decimal(15,4) NOT NULL DEFAULT '0.0000',
  price_edited decimal(15,4) NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (id));";
        return $this->db->query($query);
    }

    public function clearDbData()
    {
        return $this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "pricecontrol_data`");
    }

    public function deleteTable()
    {
        $query = "DROP TABLE IF EXISTS `" . DB_PREFIX . "pricecontrol_data`;";
        return $this->db->query($query);
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function checkData()
    {
        $sql = $this->db->query("SELECT * FROM " . DB_PREFIX . "pricecontrol_data LIMIT 1");
        if ($sql->num_rows)
            return true;
        return false;
    }

    public function restore()
    {
        $this->db->query("UPDATE `" . DB_PREFIX . "product` a, `" . DB_PREFIX . "pricecontrol_data` b SET a.price=b.price_old, b.price_old=b.price_edited,b.price_edited=b.price_old WHERE a.product_id=b.product_id AND b.type='" . self::PRICE_CONTROL_TYPE_BASE . "'");
        $this->db->query("UPDATE `" . DB_PREFIX . "product_option_value` a, `" . DB_PREFIX . "pricecontrol_data` b SET a.price=b.price_old, b.price_old=b.price_edited,b.price_edited=b.price_old WHERE a.product_id=b.product_id AND a.product_option_value_id=b.type_id AND b.type='" . self::PRICE_CONTROL_TYPE_OPTIONS . "'");
        $this->db->query("UPDATE `" . DB_PREFIX . "product_discount` a, `" . DB_PREFIX . "pricecontrol_data` b SET a.price=b.price_old, b.price_old=b.price_edited,b.price_edited=b.price_old WHERE a.product_id=b.product_id AND a.product_discount_id=b.type_id AND b.type='" . self::PRICE_CONTROL_TYPE_DISCOUNTS . "'");
        $this->db->query("UPDATE `" . DB_PREFIX . "product_special` a, `" . DB_PREFIX . "pricecontrol_data` b SET a.price=b.price_old, b.price_old=b.price_edited,b.price_edited=b.price_old WHERE a.product_id=b.product_id AND a.product_special_id=b.type_id AND b.type='" . self::PRICE_CONTROL_TYPE_ACTIONS . "'");

        $this->db->query("DELETE `a` FROM `" . DB_PREFIX . "pricecontrol_data` b LEFT JOIN `" . DB_PREFIX . "product_discount` a ON a.product_discount_id=b.type_id WHERE b.was_created='1' AND a.product_id=b.product_id  AND b.type='" . self::PRICE_CONTROL_TYPE_DISCOUNTS . "'");
        $this->db->query("DELETE `a` FROM `" . DB_PREFIX . "pricecontrol_data` b LEFT JOIN `" . DB_PREFIX . "product_special` a ON a.product_special_id=b.type_id WHERE b.was_created='1' AND a.product_id=b.product_id AND b.type='" . self::PRICE_CONTROL_TYPE_ACTIONS . "'");

        $this->clearDbData();
    }

}

?>