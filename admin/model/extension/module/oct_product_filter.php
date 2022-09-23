<?php
/**************************************************************/
/*	@copyright	OCTemplates 2018.							  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */
/**************************************************************/

class ModelExtensionModuleOctProductFilter extends Model {
    public function makeDB() {
        $sql1 = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "oct_filter_product_attribute` ( ";
        $sql1 .= "`filter_attribute_id` int(11) NOT NULL AUTO_INCREMENT, ";
        $sql1 .= "`attribute_id` int(11) NOT NULL, ";
        $sql1 .= "`product_id` int(11) NOT NULL, ";
        $sql1 .= "`attribute_group_id` int(11) NOT NULL, ";
        $sql1 .= "`language_id` int(11) NOT NULL, ";
        $sql1 .= "`attribute_value` text NOT NULL, ";
        $sql1 .= "`attribute_value_mod` text NOT NULL, ";
        $sql1 .= "`attribute_name` text NOT NULL, ";
        $sql1 .= "`attribute_name_mod` text NOT NULL, ";
        $sql1 .= "`sort_order` int(3) NOT NULL DEFAULT '0', ";
        $sql1 .= "PRIMARY KEY (`filter_attribute_id`), ";
        $sql1 .= "KEY `product_id_attribute_id` (`product_id`,`attribute_id`) ";
        $sql1 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        $this->db->query($sql1);

        $sql2 = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "oct_filter_product_option` ( ";
        $sql2 .= "`filter_option_id` int(11) NOT NULL AUTO_INCREMENT, ";
        $sql2 .= "`option_id` int(11) NOT NULL, ";
        $sql2 .= "`product_id` int(11) NOT NULL, ";
        $sql2 .= "`language_id` int(11) NOT NULL, ";
        $sql2 .= "`option_name` varchar(128) NOT NULL, ";
        $sql2 .= "`option_name_mod` text NOT NULL, ";
        $sql2 .= "`option_value_id` int(11) NOT NULL, ";
        $sql2 .= "`option_value_name` varchar(128) NOT NULL, ";
        $sql2 .= "`option_value_name_mod` text NOT NULL, ";
        $sql2 .= "`option_value_image` varchar(255) NOT NULL, ";
        $sql2 .= "PRIMARY KEY (`filter_option_id`), ";
        $sql2 .= "KEY `product_id_option_id_option_value_id` (`product_id`,`option_id`,`option_value_id`) ";
        $sql2 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        $this->db->query($sql2);

        $sql3 = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "oct_filter_product_standard` ( ";
        $sql3 .= "`filter_filter_id` int(11) NOT NULL AUTO_INCREMENT, ";
        $sql3 .= "`filter_id` int(11) NOT NULL, ";
        $sql3 .= "`product_id` int(11) NOT NULL, ";
        $sql3 .= "`filter_group_id` int(11) NOT NULL, ";
        $sql3 .= "`language_id` int(11) NOT NULL, ";
        $sql3 .= "`filter_value` text NOT NULL, ";
        $sql3 .= "`filter_value_mod` text NOT NULL, ";
        $sql3 .= "`filter_name` text NOT NULL, ";
        $sql3 .= "`filter_name_mod` text NOT NULL, ";
        $sql3 .= "`sort_order` int(3) NOT NULL DEFAULT '0', ";
        $sql3 .= "PRIMARY KEY (`filter_filter_id`), ";
        $sql3 .= "KEY `product_id_filter_id` (`product_id`,`filter_id`) ";
        $sql3 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        $this->db->query($sql3);

        $sql4 = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "oct_filter_product_sticker` ( ";
        $sql4 .= "`filter_product_sticker_id` int(11) NOT NULL AUTO_INCREMENT, ";
        $sql4 .= "`product_id` int(11) NOT NULL, ";
        $sql4 .= "`language_id` int(11) NOT NULL, ";
        $sql4 .= "`product_sticker_id` int(11) NOT NULL, ";
        $sql4 .= "`product_sticker_value` text NOT NULL, ";
        $sql4 .= "`product_sticker_value_mod` text NOT NULL, ";
        $sql4 .= "PRIMARY KEY (`filter_product_sticker_id`), ";
        $sql4 .= "KEY `product_id_product_sticker_id` (`product_id`,`product_sticker_id`) ";
        $sql4 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        $this->db->query($sql4);

        $sql5 = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "oct_filter_product_manufacturer` ( ";
        $sql5 .= "`filter_manufacturer_id` int(11) NOT NULL AUTO_INCREMENT, ";
        $sql5 .= "`manufacturer_id` int(11) NOT NULL, ";
        $sql5 .= "`product_id` int(11) NOT NULL, ";
        $sql5 .= "`language_id` int(11) NOT NULL, ";
        $sql5 .= "`manufacturer_image` varchar(255) NOT NULL, ";
        $sql5 .= "`manufacturer_name` text NOT NULL, ";
        $sql5 .= "PRIMARY KEY (`filter_manufacturer_id`), ";
        $sql5 .= "KEY `product_id_manufacturer_id` (`product_id`,`manufacturer_id`) ";
        $sql5 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        $this->db->query($sql5);

        $sql6 = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "oct_filter_product_seo` (";
        $sql6 .= "`seo_id` int(11) NOT NULL AUTO_INCREMENT, ";
        $sql6 .= "`status` tinyint(1) NOT NULL DEFAULT '1', ";
        $sql6 .= "`date_added` datetime NOT NULL, ";
        $sql6 .= "`date_modified` datetime NOT NULL, ";
        $sql6 .= "PRIMARY KEY (`seo_id`) ";
        $sql6 .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ;";

        $this->db->query($sql6);

        $sql7 = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "oct_filter_product_seo_description` (";
        $sql7 .= "`seo_id` int(11) NOT NULL, ";
        $sql7 .= "`language_id` int(11) NOT NULL, ";
        $sql7 .= "`seo_url` text COLLATE utf8_general_ci NOT NULL, ";
        $sql7 .= "`seo_title` varchar(255) COLLATE utf8_general_ci NOT NULL, ";
        $sql7 .= "`seo_h1` varchar(255) COLLATE utf8_general_ci NOT NULL, ";
        $sql7 .= "`seo_meta_description` varchar(255) COLLATE utf8_general_ci NOT NULL, ";
        $sql7 .= "`seo_meta_keywords` varchar(255) COLLATE utf8_general_ci NOT NULL, ";
        $sql7 .= "`seo_description` text COLLATE utf8_general_ci NOT NULL ";
        $sql7 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci; ";

        $this->db->query($sql7);
    }

    public function removeDB() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "oct_filter_product_attribute`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "oct_filter_product_option`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "oct_filter_product_standard`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "oct_filter_product_sticker`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "oct_filter_product_manufacturer`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "oct_filter_product_seo`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "oct_filter_product_seo_description`;");
    }

    public function getFilterGroups($data = array()) {
        $sql = "
          SELECT
            DISTINCT *
          FROM `" . DB_PREFIX . "oct_filter_product_standard` fpsd
          WHERE
            fpsd.language_id = '" . (int) $this->config->get('config_language_id') . "'
        ";

        $sql .= " GROUP BY fpsd.filter_group_id";

        $sort_data = array(
            'fpsd.filter_name'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY fpsd.filter_name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getAttributes($data = array()) {
        $sql = "
          SELECT
            DISTINCT *
          FROM " . DB_PREFIX . "oct_filter_product_attribute fpa
          WHERE
            fpa.language_id = '" . (int) $this->config->get('config_language_id') . "'
        ";

        $sql .= " GROUP BY fpa.attribute_id";

        $sort_data = array(
            'fpa.attribute_name'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY fpa.attribute_name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getOptions($data = array()) {
        $sql = "
          SELECT
            DISTINCT *
          FROM `" . DB_PREFIX . "oct_filter_product_option` fpo
          WHERE
            fpo.language_id = '" . (int) $this->config->get('config_language_id') . "'
        ";

        $sql .= " GROUP BY fpo.option_id";

        $sort_data = array(
            'fpo.option_name'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY fpo.option_name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function addSeo($data) {
        $this->db->query("
          INSERT INTO " . DB_PREFIX . "oct_filter_product_seo
          SET
            status = '" . (int) $data['status'] . "',
            date_added = NOW()
        ");

        $seo_id = $this->db->getLastId();

        foreach ($data['form_description'] as $language_id => $value) {
            $protocol      = strtolower(substr($this->request->server["SERVER_PROTOCOL"], 0, 5)) == 'https' ? HTTPS_CATALOG : HTTP_CATALOG;
            $value_seo_url = str_replace(":", "\:", $protocol);
            $value_seo_url = str_replace("/", "\/", $value_seo_url);
            $value_seo_url = preg_replace('/' . $value_seo_url . '/', '', $value['seo_url']);
            $value_seo_url = preg_replace('/\?sort=.{1,}/', '', $value_seo_url);

            $this->db->query("
                INSERT INTO " . DB_PREFIX . "oct_filter_product_seo_description
                SET
                  seo_id = '" . (int) $seo_id . "',
                  language_id = '" . (int) $language_id . "',
                  seo_url = '" . $this->db->escape($value_seo_url) . "',
                  seo_title = '" . $this->db->escape($value['seo_title']) . "',
                  seo_h1 = '" . $this->db->escape($value['seo_h1']) . "',
                  seo_meta_description = '" . $this->db->escape($value['seo_meta_description']) . "',
                  seo_meta_keywords = '" . $this->db->escape($value['seo_meta_keywords']) . "',
                  seo_description = '" . $this->db->escape($value['seo_description']) . "'
            ");
        }

        return $seo_id;
    }

    public function editSeo($seo_id, $data) {
        $this->db->query("
          UPDATE " . DB_PREFIX . "oct_filter_product_seo
          SET
            status = '" . (int) $data['status'] . "',
            date_modified = NOW()
          WHERE
            seo_id = '" . (int) $seo_id . "'
        ");

        $this->db->query("DELETE FROM " . DB_PREFIX . "oct_filter_product_seo_description WHERE seo_id = '" . (int) $seo_id . "'");

        foreach ($data['form_description'] as $language_id => $value) {
            $protocol      = strtolower(substr($this->request->server["SERVER_PROTOCOL"], 0, 5)) == 'https' ? HTTPS_CATALOG : HTTP_CATALOG;
            $value_seo_url = str_replace(":", "\:", $protocol);
            $value_seo_url = str_replace("/", "\/", $value_seo_url);
            $value_seo_url = preg_replace('/' . $value_seo_url . '/', '', $value['seo_url']);
            $value_seo_url = preg_replace('/\?sort=.{1,}/', '', $value_seo_url);

            $this->db->query("
                INSERT INTO " . DB_PREFIX . "oct_filter_product_seo_description
                SET
                  seo_id = '" . (int) $seo_id . "',
                  language_id = '" . (int) $language_id . "',
                  seo_url = '" . $this->db->escape($value_seo_url) . "',
                  seo_title = '" . $this->db->escape($value['seo_title']) . "',
                  seo_h1 = '" . $this->db->escape($value['seo_h1']) . "',
                  seo_meta_description = '" . $this->db->escape($value['seo_meta_description']) . "',
                  seo_meta_keywords = '" . $this->db->escape($value['seo_meta_keywords']) . "',
                  seo_description = '" . $this->db->escape($value['seo_description']) . "'
            ");
        }
    }

    public function getSeo($seo_id) {
        return $this->db->query("SELECT * FROM " . DB_PREFIX . "oct_filter_product_seo WHERE seo_id = '" . (int) $seo_id . "'")->row;
    }

    public function getSeos($data = array()) {
        $sql = "
          SELECT
            DISTINCT *
          FROM " . DB_PREFIX . "oct_filter_product_seo fps
          LEFT JOIN " . DB_PREFIX . "oct_filter_product_seo_description fpsd ON (fps.seo_id = fpsd.seo_id)
          WHERE
            fpsd.language_id = '" . (int) $this->config->get('config_language_id') . "'
        ";

        if (isset($data['filter_seo_url']) && !empty($data['filter_seo_url'])) {
            $sql .= " AND fpsd.seo_url LIKE '%" . $this->db->escape($data['filter_seo_url']) . "%'";
        }

        if (isset($data['filter_group_form']) && !empty($data['filter_group_form'])) {
            $sql .= " GROUP BY fpsd.seo_url";
        }

        $sort_data = array(
            'fpsd.seo_url',
            'fps.date_added',
            'fps.date_modified'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY fps.date_added";
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

        return $this->db->query($sql)->rows;
    }

    public function getTotalSeos($data = array()) {
        $sql = "
          SELECT
            COUNT(*) AS total
          FROM " . DB_PREFIX . "oct_filter_product_seo fps
          LEFT JOIN " . DB_PREFIX . "oct_filter_product_seo_description fpsd ON (fps.seo_id = fpsd.seo_id)
          WHERE
            fpsd.language_id = '" . (int) $this->config->get('config_language_id') . "'
        ";

        if (isset($data['filter_seo_url']) && !empty($data['filter_seo_url'])) {
            $sql .= " AND fpsd.seo_url LIKE '" . $this->db->escape($data['filter_seo_url']) . "%'";
        }

        return $this->db->query($sql)->row['total'];
    }

    public function deleteSeo($seo_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "oct_filter_product_seo WHERE seo_id = '" . (int) $seo_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "oct_filter_product_seo_description WHERE seo_id = '" . (int) $seo_id . "'");

        return true;
    }

    public function deleteSeos() {
        $query = $this->db->query("SELECT seo_id FROM " . DB_PREFIX . "oct_filter_product_seo")->rows;

        if ($query) {
            foreach ($query as $form) {
                $this->db->query("DELETE FROM " . DB_PREFIX . "oct_filter_product_seo WHERE seo_id = '" . (int) $form['seo_id'] . "'");
                $this->db->query("DELETE FROM " . DB_PREFIX . "oct_filter_product_seo_description WHERE seo_id = '" . (int) $form['seo_id'] . "'");
            }

            return true;
        } else {
            return false;
        }
    }

    public function copySeo($seo_id) {
        $query = $this->db->query("
          SELECT
            DISTINCT *
          FROM " . DB_PREFIX . "oct_filter_product_seo fps
          LEFT JOIN " . DB_PREFIX . "oct_filter_product_seo_description fpsd ON (fps.seo_id = fpsd.seo_id)
          WHERE
            fps.seo_id = '" . (int) $seo_id . "'
          AND
            fpsd.language_id = '" . (int) $this->config->get('config_language_id') . "'
        ");

        if ($query->num_rows) {
            $data = array();

            $data = $query->row;

            $data['status'] = '0';

            $data = array_merge($data, array(
                'form_description' => $this->getSeoDescription($seo_id)
            ));

            $this->addSeo($data);

            return true;
        } else {
            return false;
        }
    }

    public function getSeoDescription($seo_id) {
        $description_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "oct_filter_product_seo_description WHERE seo_id = '" . (int) $seo_id . "'")->rows;

        if ($query) {
            foreach ($query as $result) {
                $description_data[$result['language_id']] = array(
                    'seo_url' => $result['seo_url'],
                    'seo_title' => $result['seo_title'],
                    'seo_h1' => $result['seo_h1'],
                    'seo_meta_description' => $result['seo_meta_description'],
                    'seo_meta_keywords' => $result['seo_meta_keywords'],
                    'seo_description' => $result['seo_description']
                );
            }
        }

        return $description_data;
    }
}
