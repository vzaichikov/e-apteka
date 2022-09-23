<?php
class ModelDesignTranslate extends Model {
	public function addTranslate($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "translate SET
						 translate_group_id = '" . $this->db->escape($data['translate_group_id']) . "',
						 sort_order = '" . (int)$data['sort_order'] . "',
						 status = '" . (int)$data['status'] . "',
						 lower = '" . (int)$data['lower'] . "',
						 layout_id = '" . (int)$data['layout_id'] . "'
						 ");

		$translate_id = $this->db->getLastId();

		foreach ($data['translate_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "translate_description SET translate_id = '" . (int)$translate_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		return $translate_id;
	}

	public function editTranslate($translate_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "translate SET
						 translate_group_id = '" . $this->db->escape($data['translate_group_id']) . "',
						 sort_order = '" . (int)$data['sort_order'] . "',
						 status = '" . (int)$data['status'] . "',
						 lower = '" . (int)$data['lower'] . "',
						 layout_id = '" . (int)$data['layout_id'] . "'
						 WHERE translate_id = '" . (int)$translate_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "translate_description WHERE translate_id = '" . (int)$translate_id . "'");

		foreach ($data['translate_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "translate_description SET translate_id = '" . (int)$translate_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
	}

	public function deleteTranslate($translate_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "translate WHERE translate_id = '" . (int)$translate_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "translate_description WHERE translate_id = '" . (int)$translate_id . "'");
	}

	public function getTranslate($translate_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "translate a LEFT JOIN " . DB_PREFIX . "translate_description ad ON (a.translate_id = ad.translate_id) WHERE a.translate_id = '" . (int)$translate_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	
	public function getTranslates($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "translate a LEFT JOIN " . DB_PREFIX . "translate_description ad ON (a.translate_id = ad.translate_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND ad.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}


		$sort_data = array(
			'ad.name',
			'translate_group',
			'a.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY translate_group, ad.name";
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

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTranslateDescriptions($translate_id) {
		$translate_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "translate_description WHERE translate_id = '" . (int)$translate_id . "'");

		foreach ($query->rows as $result) {
			$translate_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $translate_data;
	}

	public function getTotalTranslates() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "translate");

		return $query->row['total'];
	}

	public function getTotalTranslatesByTranslateGroupId($translate_group_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "translate WHERE translate_group_id = '" . (int)$translate_group_id . "'");

		return $query->row['total'];
	}
}
