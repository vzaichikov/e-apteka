<?php
/**************************************************************/
/*	@copyright	OCTemplates 2018.							  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */
/**************************************************************/

class ModelOctemplatesSreviewSubject extends Model {
	public function addSubject($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "oct_sreview_subject SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");

		$oct_sreview_subject_id = $this->db->getLastId();

		foreach ($data['subject_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "oct_sreview_subject_description SET oct_sreview_subject_id = '" . (int)$oct_sreview_subject_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		if (isset($data['subject_store'])) {
			foreach ($data['subject_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "oct_sreview_subject_to_store SET oct_sreview_subject_id = '" . (int)$oct_sreview_subject_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->cache->delete('oct_sreview_subject');

		return $oct_sreview_subject_id;
	}

	public function editSubject($oct_sreview_subject_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "oct_sreview_subject SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE oct_sreview_subject_id = '" . (int)$oct_sreview_subject_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "oct_sreview_subject_description WHERE oct_sreview_subject_id = '" . (int)$oct_sreview_subject_id . "'");

		foreach ($data['subject_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "oct_sreview_subject_description SET oct_sreview_subject_id = '" . (int)$oct_sreview_subject_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "oct_sreview_subject_to_store WHERE oct_sreview_subject_id = '" . (int)$oct_sreview_subject_id . "'");

		if (isset($data['subject_store'])) {
			foreach ($data['subject_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "oct_sreview_subject_to_store SET oct_sreview_subject_id = '" . (int)$oct_sreview_subject_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->cache->delete('oct_sreview_subject');
	}

	public function copySubject($oct_sreview_subject_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "oct_sreview_subject s LEFT JOIN " . DB_PREFIX . "oct_sreview_subject_description sd ON (s.oct_sreview_subject_id = sd.oct_sreview_subject_id) WHERE s.oct_sreview_subject_id = '" . (int)$oct_sreview_subject_id . "' AND sd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($query->num_rows) {
			$data = $query->row;

			$data['status'] = '0';
			$data['subject_description'] = $this->getSubjectDescriptions($oct_sreview_subject_id);
			$data['subject_store'] = $this->getSubjectStores($oct_sreview_subject_id);

			$this->addSubject($data);
		}
	}

	public function deleteSubject($oct_sreview_subject_id) {
		$reviews = $this->getReviewVote($oct_sreview_subject_id);

		if ($reviews) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "oct_sreview_reviews_vote WHERE oct_sreview_subject_id = '" . (int)$oct_sreview_subject_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "oct_sreview_subject WHERE oct_sreview_subject_id = '" . (int)$oct_sreview_subject_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "oct_sreview_subject_description WHERE oct_sreview_subject_id = '" . (int)$oct_sreview_subject_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "oct_sreview_subject_to_store WHERE oct_sreview_subject_id = '" . (int)$oct_sreview_subject_id . "'");	

		$this->cache->delete('oct_sreview_subject');
	}

	public function getReviewVote($oct_sreview_subject_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "oct_sreview_reviews_vote WHERE oct_sreview_subject_id = '" . (int)$oct_sreview_subject_id . "'");

		return $query->rows;
	}

	public function getSubject($oct_sreview_subject_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "oct_sreview_subject s LEFT JOIN " . DB_PREFIX . "oct_sreview_subject_description sd ON (s.oct_sreview_subject_id = sd.oct_sreview_subject_id) WHERE s.oct_sreview_subject_id = '" . (int)$oct_sreview_subject_id . "' AND sd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getSubjects($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "oct_sreview_subject s LEFT JOIN " . DB_PREFIX . "oct_sreview_subject_description sd ON (s.oct_sreview_subject_id = sd.oct_sreview_subject_id) WHERE sd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND sd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND s.status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY s.oct_sreview_subject_id";

		$sort_data = array(
			'sd.name',
			's.status',
			's.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sd.name";
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

	public function getSubjectDescriptions($oct_sreview_subject_id) {
		$subject_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "oct_sreview_subject_description WHERE oct_sreview_subject_id = '" . (int)$oct_sreview_subject_id . "'");

		foreach ($query->rows as $result) {
			$subject_description_data[$result['language_id']] = array(
				'name'             => $result['name']
			);
		}

		return $subject_description_data;
	}

	public function getSubjectStores($oct_sreview_subject_id) {
		$subject_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "oct_sreview_subject_to_store WHERE oct_sreview_subject_id = '" . (int)$oct_sreview_subject_id . "'");

		foreach ($query->rows as $result) {
			$subject_store_data[] = $result['store_id'];
		}

		return $subject_store_data;
	}

	public function getTotalSubjects($data = array()) {
		$sql = "SELECT COUNT(DISTINCT s.oct_sreview_subject_id) AS total FROM " . DB_PREFIX . "oct_sreview_subject s LEFT JOIN " . DB_PREFIX . "oct_sreview_subject_description sd ON (s.oct_sreview_subject_id = sd.oct_sreview_subject_id)";

		$sql .= " WHERE sd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND sd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND s.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}