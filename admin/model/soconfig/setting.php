<?php
class ModelSoconfigSetting extends Model {
	public function createTableSoconfig(){
		$this->db->query('CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'soconfig` (
          id int(11) auto_increment,
          `store_id` int(11) NOT NULL DEFAULT 0,
          `key` varchar(255) NOT NULL,
          `value` mediumtext NOT NULL,
          `serialized` tinyint(1) NOT NULL,
		   PRIMARY KEY(id)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;');
	}
	public function getSetting($stores) {
		$setting_data = array();
		if (is_array($stores)) {

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "soconfig WHERE store_id = '" . (int)$stores['store_id'] . "'");
			foreach ($query->rows as $result) {
			
				$setting_data[$result['key']][$result['store_id']] = json_decode($result['value'], true);
			}
			
		}
		
		return $setting_data;
	}

	
	public function editSetting($data, $store_id = 0) {
		//$this->db->query("DELETE FROM `" . DB_PREFIX . "soconfig`");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "soconfig` WHERE store_id = '" . (int)$store_id . "'");
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				foreach($value as $storeId=>$val){	
					$this->db->query("INSERT INTO " . DB_PREFIX . "soconfig SET store_id = '" . (int)$store_id . "' ,`key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(json_encode($val, true)) . "', serialized = '1'");
				}
			}
		}
	}
	
	
	public function deleteSetting() {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "soconfig`");
	}
	
	public function getSettingValue($key, $store_id = 0) {
		$query = $this->db->query("SELECT value FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `key` = '" . $this->db->escape($key) . "'");

		if ($query->num_rows) {
			return $query->row['value'];
		} else {
			return null;	
		}
	}
	
	public function editSettingValue($code = '', $key = '', $value = '', $store_id = 0) {
		if (!is_array($value)) {
			$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape($value) . "', serialized = '0'  WHERE `code` = '" . $this->db->escape($code) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "'");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape(json_encode($value)) . "', serialized = '1' WHERE `code` = '" . $this->db->escape($code) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "'");
		}
	}
	
	public function getMobile($code, $store_id = 0) {
		$setting_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($code) . "'");
		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$setting_data[] = $result['value'];
			} else {
				$setting_data[] = json_decode($result['value'], true);
			}
		}
		return $setting_data[0];
	}
	
	public function editMobile($code, $data, $store_id = 0) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($code) . "'");
		
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				if (!is_array($value)) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(json_encode($value, true)) . "', serialized = '1'");
				}
			}
		}
	}

	public function deleteMobile($module_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "module` WHERE `module_id` = '" . (int)$module_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "layout_module` WHERE `code` LIKE '%." . (int)$module_id . "'");
	}
		
	
}
