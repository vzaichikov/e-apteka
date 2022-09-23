<?php
/**************************************************************/
/*	@copyright	OCTemplates 2018.							  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */
/**************************************************************/

class ModelExtensionModuleOctProductStickers extends Model {
    public function makeDB() {
        $sql1 = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "oct_product_stickers` (";
        $sql1 .= "`product_sticker_id` int(11) NOT NULL AUTO_INCREMENT, ";
        $sql1 .= "`sort_order` int(3) NOT NULL DEFAULT '0', ";
        $sql1 .= "`status` tinyint(1) NOT NULL DEFAULT '1', ";
        $sql1 .= "`color` text NOT NULL, ";
        $sql1 .= "`background` text NOT NULL, ";
        $sql1 .= "PRIMARY KEY (`product_sticker_id`) ";
        $sql1 .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;";
        $this->db->query($sql1);
        
        $sql2 = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "oct_product_stickers_description` (";
        $sql2 .= "`product_sticker_id` int(11) NOT NULL, ";
        $sql2 .= "`language_id` int(11) NOT NULL, ";
        $sql2 .= "`title` text NOT NULL, ";
        $sql2 .= "`text` text NOT NULL, ";
        $sql2 .= "PRIMARY KEY (`product_sticker_id`,`language_id`) ";
        $sql2 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        $this->db->query($sql2);
        
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD `oct_product_stickers` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;");
    }
    
    public function removeDB() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "oct_product_stickers`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "oct_product_stickers_description`;");
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` DROP `oct_product_stickers` ;");
    }
    
    public function getCategories() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE cd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int) $this->config->get('config_store_id') . "'  ORDER BY c.parent_id, c.sort_order, cd.name");
        
        $category_data = array();
        
        foreach ($query->rows as $row) {
            $category_data[$row['parent_id']][$row['category_id']] = $row;
        }
        
        return $category_data;
    }
    
    public function updateStickers($module_categories, $module_stickers, $filters) {
        $filter_data = array(
            'filter_category' => $module_categories,
            'filter_date_added' => ($filters['date_status']) ? $filters['date'] : '',
            'filter_quantity' => ($filters['quantity_status']) ? $filters['quantity'] : 'stop',
            'filter_viewed' => ($filters['viewed_status']) ? $filters['viewed'] : 'stop',
            'filter_sell' => ($filters['sell_status']) ? $filters['sell'] : 'stop',
            'filter_special' => ($filters['special_status']) ? '1' : '',
            'filter_discount' => ($filters['discount_status']) ? '1' : ''
        );
        
        $results = $this->getProducts($filter_data);
        
        if ($results) {
            foreach ($results as $product_id) {
                $this->db->query("UPDATE " . DB_PREFIX . "product SET oct_product_stickers = '" . $this->db->escape(serialize($module_stickers)) . "' WHERE product_id = '" . (int) $product_id . "'");
            }
            return true;
        } else {
            return false;
        }
    }
    
    public function getProducts($data = array()) {
        $inner = '';
        
        if ($data['filter_discount']) {
            $inner .= ", (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id LIMIT 1) AS discount";
        }
        
        if ($data['filter_special']) {
            $inner .= ", (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id LIMIT 1) AS special";
        }
        
        $sql = "SELECT p.product_id" . $inner . " FROM " . DB_PREFIX . "product p";
        /*
        if ($data['filter_sell'] != 'stop') {
            $sql .= " LEFT JOIN `" . DB_PREFIX . "order_product` op ON (p.product_id = op.product_id) ";
        }
        */
        if ($data['filter_category']) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE p2c.category_id = '" . (int) $data['filter_category'] . "'";
        } else {
            $sql .= " WHERE p.product_id != '0'";
        }
        
        if ($data['filter_date_added']) {
            $sql .= " AND DATE(p.date_added) >= '" . $this->db->escape($data['filter_date_added']) . "'";
        }
        
        if ($data['filter_quantity'] != 'stop') {
            $sql .= " AND p.quantity >= '" . (int) $data['filter_quantity'] . "'";
        }
        
        if ($data['filter_viewed'] != 'stop') {
            $sql .= " AND p.viewed >= '" . (int) $data['filter_viewed'] . "'";
        }
        
        if ($data['filter_sell'] != 'stop') {
            //$sql .= " AND op.quantity >= '" . (int) $data['filter_sell'] . "'";
            $sql .= " AND (SELECT SUM(quantity) AS summa FROM " . DB_PREFIX . "order_product op WHERE op.product_id = p.product_id) >= '" . (int)$data['filter_sell'] . "'";
        }
        
        $sql .= " GROUP BY p.product_id";
        
        $product_data = array();
        
        $query = $this->db->query($sql);
        
        foreach ($query->rows as $result) {
            $product_data[$result['product_id']] = $result['product_id'];
            
            if ($data['filter_discount'] && $data['filter_special']) {
                if (!$result['special'] && !$result['discount']) {
                    unset($product_data[$result['product_id']]);
                }
            } else {
                if ($data['filter_discount'] && !$result['discount']) {
                    unset($product_data[$result['product_id']]);
                }
                
                if ($data['filter_special'] && !$result['special']) {
                    unset($product_data[$result['product_id']]);
                }
            }
        }
        
        return $product_data;
    }
}
