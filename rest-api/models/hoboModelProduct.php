<?

namespace hobotix;

class hoboModelProduct extends hoboModel{	

	public function getProductIdsByUUID($uuids){
		$result = [];

		foreach ($uuids as $uuid){
			$result[$uuid] = false;
		}


		$uuids = array_map(array($this, 'escape'), $uuids);		

		$query = $this->db->query("SELECT uuid, product_id FROM oc_product WHERE uuid IN (" . implode(',', $uuids) . ")");		
		if ($query->num_rows){
			foreach ($query->rows as $row){
				$result[$row['uuid']] = $row['product_id'];
			}

			return $result;
		}

		return false;
	}

	public function getProductIdByUUID($uuid){
		$query = $this->db->query("SELECT product_id, uuid FROM oc_product WHERE uuid = '" . $this->db->escape($uuid) . "'");		

		if ($query->num_rows){
			return $query->row['product_id'];
		}

		return false;
	}

	public function getProductByID($id, $language_id){
		$query = $this->db->query("SELECT * FROM oc_product p LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$id . "' AND pd.language_id = '" . (int)$language_id . "' LIMIT 1");		

		if ($query->num_rows){
			return $query->row;
		}

		return false;
	}



}