<?php
class ModelCatalogSocialprogram extends Model {
	public function getSocialprogram($socialprogram_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "socialprogram c LEFT JOIN " . DB_PREFIX . "socialprogram_description cd ON (c.socialprogram_id = cd.socialprogram_id) LEFT JOIN " . DB_PREFIX . "socialprogram_to_store c2s ON (c.socialprogram_id = c2s.socialprogram_id) WHERE c.socialprogram_id = '" . (int)$socialprogram_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");

		return $query->row;
	}

	public function getSocialprograms($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "socialprogram c LEFT JOIN " . DB_PREFIX . "socialprogram_description cd ON (c.socialprogram_id = cd.socialprogram_id) LEFT JOIN " . DB_PREFIX . "socialprogram_to_store c2s ON (c.socialprogram_id = c2s.socialprogram_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");

		return $query->rows;
	}
	
	public function getAllSocialprograms() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "socialprogram c LEFT JOIN " . DB_PREFIX . "socialprogram_description cd ON (c.socialprogram_id = cd.socialprogram_id) LEFT JOIN " . DB_PREFIX . "socialprogram_to_store c2s ON (c.socialprogram_id = c2s.socialprogram_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");

		return $query->rows;
	}
	
	public function getSocialprogramsByManufacturer($manufacturer_id, $parent_id = 'first-level' ) {
		$sql = "SELECT * FROM " . DB_PREFIX . "socialprogram c 
			LEFT JOIN " . DB_PREFIX . "socialprogram_description cd ON (c.socialprogram_id = cd.socialprogram_id) 
			LEFT JOIN " . DB_PREFIX . "socialprogram_to_store c2s ON (c.socialprogram_id = c2s.socialprogram_id) 
			WHERE c.status = '1'";
		
		if ($parent_id == 'second-level'){
			$sql .= " AND c.parent_id <> 0";
		}  elseif ($parent_id == 'first-level'){
			$sql .= " AND c.parent_id = 0";
		}
		
		$sql .=	" AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  
			AND c.manufacturer_id = '" . (int)$manufacturer_id . "'
			ORDER BY c.sort_order, LCASE(cd.name)";
	
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getSocialprogramFilters($socialprogram_id) {
		$implode = array();

		$query = $this->db->query("SELECT filter_id FROM " . DB_PREFIX . "socialprogram_filter WHERE socialprogram_id = '" . (int)$socialprogram_id . "'");

		foreach ($query->rows as $result) {
			$implode[] = (int)$result['filter_id'];
		}

		$filter_group_data = array();

		if ($implode) {
			$filter_group_query = $this->db->query("SELECT DISTINCT f.filter_group_id, fgd.name, fg.sort_order FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_group fg ON (f.filter_group_id = fg.filter_group_id) LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY f.filter_group_id ORDER BY fg.sort_order, LCASE(fgd.name)");

			foreach ($filter_group_query->rows as $filter_group) {
				$filter_data = array();

				$filter_query = $this->db->query("SELECT DISTINCT f.filter_id, fd.name FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND f.filter_group_id = '" . (int)$filter_group['filter_group_id'] . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY f.sort_order, LCASE(fd.name)");

				foreach ($filter_query->rows as $filter) {
					$filter_data[] = array(
						'filter_id' => $filter['filter_id'],
						'name'      => $filter['name']
					);
				}

				if ($filter_data) {
					$filter_group_data[] = array(
						'filter_group_id' => $filter_group['filter_group_id'],
						'name'            => $filter_group['name'],
						'filter'          => $filter_data
					);
				}
			}
		}

		return $filter_group_data;
	}

	public function getSocialprogramLayoutId($socialprogram_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "socialprogram_to_layout WHERE socialprogram_id = '" . (int)$socialprogram_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getTotalSocialprogramsBySocialprogramId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "socialprogram c LEFT JOIN " . DB_PREFIX . "socialprogram_to_store c2s ON (c.socialprogram_id = c2s.socialprogram_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");

		return $query->row['total'];
	}
}