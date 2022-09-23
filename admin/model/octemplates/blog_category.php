<?php
/**************************************************************/
/*	@copyright	OCTemplates 2018.							  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */
/**************************************************************/

class ModelOctemplatesBlogCategory extends Model {
    public function addCategory($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "oct_blog_category SET oct_blog_category_parent_id = '" . (int) $data['oct_blog_category_parent_id'] . "', sort_order = '" . (int) $data['sort_order'] . "', status = '" . (int) $data['status'] . "', date_modified = NOW(), date_added = NOW()");
        
        $oct_blog_category_id = $this->db->getLastId();
        
        if (isset($data['image'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "oct_blog_category SET image = '" . $this->db->escape($data['image']) . "' WHERE oct_blog_category_id = '" . (int) $oct_blog_category_id . "'");
        }
        
        foreach ($data['category_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "oct_blog_category_description SET oct_blog_category_id = '" . (int) $oct_blog_category_id . "', language_id = '" . (int) $language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
        }
        
        // MySQL Hierarchical Data Closure Table Pattern
        $level = 0;
        
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "oct_blog_category_path` WHERE oct_blog_category_id = '" . (int) $data['oct_blog_category_parent_id'] . "' ORDER BY `level` ASC");
        
        foreach ($query->rows as $result) {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "oct_blog_category_path` SET `oct_blog_category_id` = '" . (int) $oct_blog_category_id . "', `oct_blog_category_path_id` = '" . (int) $result['oct_blog_category_path_id'] . "', `level` = '" . (int) $level . "'");
            
            $level++;
        }
        
        $this->db->query("INSERT INTO `" . DB_PREFIX . "oct_blog_category_path` SET `oct_blog_category_id` = '" . (int) $oct_blog_category_id . "', `oct_blog_category_path_id` = '" . (int) $oct_blog_category_id . "', `level` = '" . (int) $level . "'");
        
        if (isset($data['category_store'])) {
            foreach ($data['category_store'] as $store_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "oct_blog_category_to_store SET oct_blog_category_id = '" . (int) $oct_blog_category_id . "', store_id = '" . (int) $store_id . "'");
            }
        }
        
        // Set which layout to use with this category
        if (isset($data['category_layout'])) {
            foreach ($data['category_layout'] as $store_id => $layout_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "oct_blog_category_to_layout SET oct_blog_category_id = '" . (int) $oct_blog_category_id . "', store_id = '" . (int) $store_id . "', layout_id = '" . (int) $layout_id . "'");
            }
        }
        
        if (isset($data['keyword'])) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'oct_blog_category_id=" . (int) $oct_blog_category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
        }
        
        $this->cache->delete('oct_blog_category');
        
        return $oct_blog_category_id;
    }
    
    public function editCategory($oct_blog_category_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "oct_blog_category SET oct_blog_category_parent_id = '" . (int) $data['oct_blog_category_parent_id'] . "', sort_order = '" . (int) $data['sort_order'] . "', status = '" . (int) $data['status'] . "', date_modified = NOW() WHERE oct_blog_category_id = '" . (int) $oct_blog_category_id . "'");
        
        if (isset($data['image'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "oct_blog_category SET image = '" . $this->db->escape($data['image']) . "' WHERE oct_blog_category_id = '" . (int) $oct_blog_category_id . "'");
        }
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "oct_blog_category_description WHERE oct_blog_category_id = '" . (int) $oct_blog_category_id . "'");
        
        foreach ($data['category_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "oct_blog_category_description SET oct_blog_category_id = '" . (int) $oct_blog_category_id . "', language_id = '" . (int) $language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
        }
        
        // MySQL Hierarchical Data Closure Table Pattern
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "oct_blog_category_path` WHERE oct_blog_category_path_id = '" . (int) $oct_blog_category_id . "' ORDER BY level ASC");
        
        if ($query->rows) {
            foreach ($query->rows as $oct_blog_category_path) {
                // Delete the path below the current one
                $this->db->query("DELETE FROM `" . DB_PREFIX . "oct_blog_category_path` WHERE oct_blog_category_id = '" . (int) $oct_blog_category_path['oct_blog_category_id'] . "' AND level < '" . (int) $oct_blog_category_path['level'] . "'");
                
                $path = array();
                
                // Get the nodes new parents
                $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "oct_blog_category_path` WHERE oct_blog_category_id = '" . (int) $data['oct_blog_category_parent_id'] . "' ORDER BY level ASC");
                
                foreach ($query->rows as $result) {
                    $path[] = $result['oct_blog_category_path_id'];
                }
                
                // Get whats left of the nodes current path
                $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "oct_blog_category_path` WHERE oct_blog_category_id = '" . (int) $oct_blog_category_path['oct_blog_category_id'] . "' ORDER BY level ASC");
                
                foreach ($query->rows as $result) {
                    $path[] = $result['oct_blog_category_path_id'];
                }
                
                // Combine the paths with a new level
                $level = 0;
                
                foreach ($path as $oct_blog_category_path_id) {
                    $this->db->query("REPLACE INTO `" . DB_PREFIX . "oct_blog_category_path` SET oct_blog_category_id = '" . (int) $oct_blog_category_path['oct_blog_category_id'] . "', `oct_blog_category_path_id` = '" . (int) $oct_blog_category_path_id . "', level = '" . (int) $level . "'");
                    
                    $level++;
                }
            }
        } else {
            // Delete the path below the current one
            $this->db->query("DELETE FROM `" . DB_PREFIX . "oct_blog_category_path` WHERE oct_blog_category_id = '" . (int) $oct_blog_category_id . "'");
            
            // Fix for records with no paths
            $level = 0;
            
            $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "oct_blog_category_path` WHERE oct_blog_category_id = '" . (int) $data['oct_blog_category_parent_id'] . "' ORDER BY level ASC");
            
            foreach ($query->rows as $result) {
                $this->db->query("INSERT INTO `" . DB_PREFIX . "oct_blog_category_path` SET oct_blog_category_id = '" . (int) $oct_blog_category_id . "', `oct_blog_category_path_id` = '" . (int) $result['oct_blog_category_path_id'] . "', level = '" . (int) $level . "'");
                
                $level++;
            }
            
            $this->db->query("REPLACE INTO `" . DB_PREFIX . "oct_blog_category_path` SET oct_blog_category_id = '" . (int) $oct_blog_category_id . "', `oct_blog_category_path_id` = '" . (int) $oct_blog_category_id . "', level = '" . (int) $level . "'");
        }
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "oct_blog_category_to_store WHERE oct_blog_category_id = '" . (int) $oct_blog_category_id . "'");
        
        if (isset($data['category_store'])) {
            foreach ($data['category_store'] as $store_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "oct_blog_category_to_store SET oct_blog_category_id = '" . (int) $oct_blog_category_id . "', store_id = '" . (int) $store_id . "'");
            }
        }
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "oct_blog_category_to_layout WHERE oct_blog_category_id = '" . (int) $oct_blog_category_id . "'");
        
        if (isset($data['category_layout'])) {
            foreach ($data['category_layout'] as $store_id => $layout_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "oct_blog_category_to_layout SET oct_blog_category_id = '" . (int) $oct_blog_category_id . "', store_id = '" . (int) $store_id . "', layout_id = '" . (int) $layout_id . "'");
            }
        }
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'oct_blog_category_id=" . (int) $oct_blog_category_id . "'");
        
        if ($data['keyword']) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'oct_blog_category_id=" . (int) $oct_blog_category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
        }
        
        $this->cache->delete('oct_blog_category');
    }
    
    public function deleteCategory($oct_blog_category_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "oct_blog_category WHERE oct_blog_category_id = '" . (int) $oct_blog_category_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "oct_blog_category_description WHERE oct_blog_category_id = '" . (int) $oct_blog_category_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "oct_blog_category_to_store WHERE oct_blog_category_id = '" . (int) $oct_blog_category_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "oct_blog_category_to_layout WHERE oct_blog_category_id = '" . (int) $oct_blog_category_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "oct_blog_article_to_category WHERE oct_blog_category_id = '" . (int) $oct_blog_category_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'oct_blog_category_id=" . (int) $oct_blog_category_id . "'");
        
        $this->cache->delete('oct_blog_category');
    }
    
    public function repairCategories($oct_blog_category_parent_id = 0) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "oct_blog_category WHERE oct_blog_category_parent_id = '" . (int) $oct_blog_category_parent_id . "'");
        
        foreach ($query->rows as $oct_blog_category) {
            // Delete the path below the current one
            $this->db->query("DELETE FROM `" . DB_PREFIX . "oct_blog_category_path` WHERE oct_blog_category_id = '" . (int) $oct_blog_category['oct_blog_category_id'] . "'");
            
            // Fix for records with no paths
            $level = 0;
            
            $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "oct_blog_category_path` WHERE oct_blog_category_id = '" . (int) $oct_blog_category_parent_id . "' ORDER BY level ASC");
            
            foreach ($query->rows as $result) {
                $this->db->query("INSERT INTO `" . DB_PREFIX . "oct_blog_category_path` SET oct_blog_category_id = '" . (int) $oct_blog_category['oct_blog_category_id'] . "', `oct_blog_category_path_id` = '" . (int) $result['oct_blog_category_path_id'] . "', level = '" . (int) $level . "'");
                
                $level++;
            }
            
            $this->db->query("REPLACE INTO `" . DB_PREFIX . "oct_blog_category_path` SET oct_blog_category_id = '" . (int) $oct_blog_category['oct_blog_category_id'] . "', `oct_blog_category_path_id` = '" . (int) $oct_blog_category['oct_blog_category_id'] . "', level = '" . (int) $level . "'");
            
            $this->repairCategories($oct_blog_category['oct_blog_category_id']);
        }
    }
    
    public function getCategory($oct_blog_category_id) {
        $query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "oct_blog_category_path cp LEFT JOIN " . DB_PREFIX . "oct_blog_category_description cd1 ON (cp.oct_blog_category_path_id = cd1.oct_blog_category_id AND cp.oct_blog_category_id != cp.oct_blog_category_path_id) WHERE cp.oct_blog_category_id = c.oct_blog_category_id AND cd1.language_id = '" . (int) $this->config->get('config_language_id') . "' GROUP BY cp.oct_blog_category_id) AS cpath, (SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'oct_blog_category_id=" . (int) $oct_blog_category_id . "') AS keyword FROM " . DB_PREFIX . "oct_blog_category c LEFT JOIN " . DB_PREFIX . "oct_blog_category_description cd2 ON (c.oct_blog_category_id = cd2.oct_blog_category_id) WHERE c.oct_blog_category_id = '" . (int) $oct_blog_category_id . "' AND cd2.language_id = '" . (int) $this->config->get('config_language_id') . "'");
        
        return $query->row;
    }
    
    // public function getCategoriesByParentId($oct_blog_category_parent_id = 0) {
    // 	$query = $this->db->query("SELECT *, (SELECT COUNT(oct_blog_category_parent_id) FROM " . DB_PREFIX . "oct_blog_category WHERE oct_blog_category_parent_id = c.oct_blog_category_id) AS children FROM " . DB_PREFIX . "oct_blog_category c LEFT JOIN " . DB_PREFIX . "oct_blog_category_description cd ON (c.oct_blog_category_id = cd.oct_blog_category_id) WHERE c.oct_blog_category_parent_id = '" . (int)$oct_blog_category_parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name");
    
    // 	return $query->rows;
    // }
    
    public function getCategories($data = array()) {
        $sql = "SELECT cp.oct_blog_category_id AS oct_blog_category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.oct_blog_category_parent_id, c1.sort_order, c1.status,(select count(oct_blog_article_id) as article_count from " . DB_PREFIX . "oct_blog_article_to_category a2c where a2c.oct_blog_category_id = c1.oct_blog_category_id) as article_count FROM " . DB_PREFIX . "oct_blog_category_path cp LEFT JOIN " . DB_PREFIX . "oct_blog_category c1 ON (cp.oct_blog_category_id = c1.oct_blog_category_id) LEFT JOIN " . DB_PREFIX . "oct_blog_category c2 ON (cp.oct_blog_category_path_id = c2.oct_blog_category_id) LEFT JOIN " . DB_PREFIX . "oct_blog_category_description cd1 ON (cp.oct_blog_category_path_id = cd1.oct_blog_category_id) LEFT JOIN " . DB_PREFIX . "oct_blog_category_description cd2 ON (cp.oct_blog_category_id = cd2.oct_blog_category_id) WHERE cd1.language_id = '" . (int) $this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int) $this->config->get('config_language_id') . "'";
        
        if (!empty($data['filter_name'])) {
            $sql .= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }
        
        $sql .= " GROUP BY cp.oct_blog_category_id";
        
        $sort_data = array(
            'article_count',
            'name',
            'sort_order'
        );
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY sort_order";
        }
        
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }
        
        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            
            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }
        
        $query = $this->db->query($sql);
        
        return $query->rows;
    }
    
    public function getCategoryDescriptions($oct_blog_category_id) {
        $category_description_data = array();
        
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "oct_blog_category_description WHERE oct_blog_category_id = '" . (int) $oct_blog_category_id . "'");
        
        foreach ($query->rows as $result) {
            $category_description_data[$result['language_id']] = array(
                'name' => $result['name'],
                'meta_title' => $result['meta_title'],
                'meta_description' => $result['meta_description'],
                'meta_keyword' => $result['meta_keyword'],
                'description' => $result['description']
            );
        }
        
        return $category_description_data;
    }
    
    public function getCategoryStores($oct_blog_category_id) {
        $category_store_data = array();
        
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "oct_blog_category_to_store WHERE oct_blog_category_id = '" . (int) $oct_blog_category_id . "'");
        
        foreach ($query->rows as $result) {
            $category_store_data[] = $result['store_id'];
        }
        
        return $category_store_data;
    }
    
    public function getCategoryLayouts($oct_blog_category_id) {
        $category_layout_data = array();
        
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "oct_blog_category_to_layout WHERE oct_blog_category_id = '" . (int) $oct_blog_category_id . "'");
        
        foreach ($query->rows as $result) {
            $category_layout_data[$result['store_id']] = $result['layout_id'];
        }
        
        return $category_layout_data;
    }
    
    // public function getCategoriesByParentId($oct_blog_category_parent_id = 0) {
    // 	$query = $this->db->query("SELECT *, (SELECT COUNT(oct_blog_category_parent_id) FROM " . DB_PREFIX . "oct_blog_category WHERE oct_blog_category_parent_id = c.oct_blog_category_id) AS children FROM " . DB_PREFIX . "oct_blog_category c LEFT JOIN " . DB_PREFIX . "oct_blog_category_description cd ON (c.oct_blog_category_id = cd.oct_blog_category_id) LEFT JOIN " . DB_PREFIX . "oct_blog_category_to_store c2s ON (c.oct_blog_category_id = c2s.oct_blog_category_id) WHERE c.oct_blog_category_parent_id = '" . (int)$oct_blog_category_parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY c.sort_order, cd.name");
    
    // 	return $query->rows;
    // }
    
    public function getCategoriesByParentId($oct_blog_category_parent_id = 0) {
        $query = $this->db->query("SELECT *, (SELECT COUNT(oct_blog_category_parent_id) FROM " . DB_PREFIX . "oct_blog_category WHERE oct_blog_category_parent_id = c.oct_blog_category_id) AS children FROM " . DB_PREFIX . "oct_blog_category c LEFT JOIN " . DB_PREFIX . "oct_blog_category_description cd ON (c.oct_blog_category_id = cd.oct_blog_category_id) WHERE c.oct_blog_category_parent_id = '" . (int) $oct_blog_category_parent_id . "' AND cd.language_id = '" . (int) $this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name");
        
        return $query->rows;
    }
    
    public function getAllCategories() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "oct_blog_category c LEFT JOIN " . DB_PREFIX . "oct_blog_category_description cd ON (c.oct_blog_category_id = cd.oct_blog_category_id) LEFT JOIN " . DB_PREFIX . "oct_blog_category_to_store c2s ON (c.oct_blog_category_id = c2s.oct_blog_category_id) WHERE cd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int) $this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.oct_blog_category_parent_id, c.sort_order, cd.name");
        
        $category_data = array();
        foreach ($query->rows as $row) {
            $category_data[$row['oct_blog_category_parent_id']][$row['oct_blog_category_id']] = $row;
        }
        
        return $category_data;
    }
    
    public function getTotalCategories() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "oct_blog_category");
        
        return $query->row['total'];
    }
    
    public function getTotalCategoriesByLayoutId($layout_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "oct_blog_category_to_layout WHERE layout_id = '" . (int) $layout_id . "'");
        
        return $query->row['total'];
    }
}