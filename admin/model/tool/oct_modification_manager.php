<?php
/**************************************************************/
/*	@copyright	OCTemplates 2018.							  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */
/**************************************************************/

class ModelToolOctModificationManager extends Model {

  public function addModification($data) {
    $this->db->query("
      INSERT INTO " . DB_PREFIX . "modification 
      SET 
        code = '" . $this->db->escape($data['code']) . "', 
        name = '" . $this->db->escape($data['name']) . "', 
        author = '" . $this->db->escape($data['author']) . "', 
        version = '" . $this->db->escape($data['version']) . "', 
        link = '" . $this->db->escape($data['link']) . "', 
        xml = '" . $this->db->escape($data['xml']) . "', 
        status = '" . (int)$data['status'] . "', 
        date_added = NOW()
    ");
  }

  public function editModification($modification_id, $data) {
    $this->db->query("
      UPDATE " . DB_PREFIX . "modification 
      SET 
        name = '" . $this->db->escape($data['name']) . "', 
        author = '" . $this->db->escape($data['author']) . "', 
        version = '" . $this->db->escape($data['version']) . "', 
        link = '" . $this->db->escape($data['link']) . "', 
        xml = '" . $this->db->escape($data['xml']) . "' 
      WHERE 
        modification_id = '" . (int)$modification_id . "'
    ");
  }

  public function getModification($modification_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "modification WHERE modification_id = '" . (int)$modification_id . "'");

		return $query->row;
	}

  public function getModifications($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "modification WHERE modification_id > '0'";

		if (isset($data['filter_author']) && $data['filter_author']) {
		  $sql .= " AND LCASE(author) = '" . $this->db->escape(strtolower($data['filter_author'])) . "'";
    }

    if (isset($data['filter_name']) && $data['filter_name']) {
		  $sql .= " AND LCASE(name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
    }

    if (isset($data['filter_author_group']) && $data['filter_author_group']) {
      $sql .= " GROUP BY LCASE(author)";
    }

		$sort_data = array(
			'name',
			'author',
			'version',
			'status',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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

	public function getTotalModifications($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "modification WHERE modification_id > '0'";

		if (isset($data['filter_author']) && $data['filter_author']) {
		  $sql .= " AND LCASE(author) = '" . $this->db->escape(strtolower($data['filter_author'])) . "'";
    }

    if (isset($data['filter_name']) && $data['filter_name']) {
		  $sql .= " AND LCASE(name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
    }

    $query = $this->db->query($sql);

		return $query->row['total'];
	}

  public function getTotalModificationByCode($code) {
		return $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "modification WHERE code = '" . $this->db->escape($code) . "'")->row['total'];
	}
}