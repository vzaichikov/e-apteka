<?

namespace hobotix;

class hoboModelDrugstore extends hoboModel{	

	public function getDrugStores($language_id){
		$query = $this->db->query("SELECT * FROM oc_location ol LEFT JOIN oc_location_description old ON ol.location_id = old.location_id WHERE language_id = '" . (int)$language_id . "'");		

		if ($query->num_rows){
			return $query->rows;
		}

		return false;
	}



}