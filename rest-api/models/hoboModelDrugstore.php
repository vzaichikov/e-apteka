<?

namespace hobotix;

class hoboModelDrugstore extends hoboModel{	

	public function getDrugStores(){
		$result = [];
		$query = $this->db->query("SELECT * FROM oc_location ol");		

		if ($query->num_rows){
			foreach ($query->rows as $row){
				$description_query_RU = $this->db->query("SELECT * FROM oc_location_description WHERE location_id = '" . $row['location_id'] . "' AND language_id = '2'");
				$description_query_UA = $this->db->query("SELECT * FROM oc_location_description WHERE location_id = '" . $row['location_id'] . "' AND language_id = '3'");
				$city_query    		  = $this->db->query("SELECT * FROM oc_novaposhta_cities WHERE Ref = '" . $row['city_id'] . "'");

				$result[] = [
					'drugstoreID' 				=> $row['location_id'],
					'drugstoreUUID' 			=> $row['uuid'],
					'drugstoreName_RU' 			=> $description_query_RU->row['name'],
					'drugstoreName_UA' 			=> $description_query_UA->row['name'],
					'drugstoreAddress_RU' 		=> $description_query_RU->row['address'],
					'drugstoreAddress_UA' 		=> $description_query_UA->row['address'],
					'drugstoreCityUUID' 		=> $row['city_id'],
					'drugstoreCity' 			=> $query->row['city'],
					'drugstoreNPCityName_RU' 	=> $city_query->num_rows?$city_query->row['DescriptionRu']:'',
					'drugstoreNPCityName_UA' 	=> $city_query->num_rows?$city_query->row['Description']:'',
					'drugstoreBrand' 			=> $row['brand'],
					'drugstoreTelephone' 		=> $row['telephone'],
					'drugstoreFax' 				=> $row['fax'],
					'drugstoreGeoCode' 			=> $row['geocode'],
					'drugstoreGmapsLink' 		=> $row['gmaps_link'],
					'drugstoreImage' 			=> $row['image'],
					'drugstoreOpen' 			=> $row['open'],
					'drugstoreOpenStruct' 		=> $row['open_struct'],
					'drugstoreDeliveryTimes' 	=> $row['delivery_times'],
					'drugstoreComment' 			=> $row['comment'],
					'drugstoreNodeID' 			=> $row['node_id'],
					'drugstoreIsStock' 			=> $row['is_stock'],
					'drugstoreCanSellDrugs'		=> $row['can_sell_drugs'],
					'drugstoreUUID' 			=> $row['uuid'],
					'drugstoreLastSync'			=> $row['last_sync'],
					'drugstoreDefaultPrice'		=> $row['default_price'],
					'drugstoreSortOrder'		=> $row['sort_order'],
					'drugstoreInformationID'	=> $row['information_id'],
					'drugstoreClosed' 			=> $row['temprorary_closed']
				];
			}

			return $result;
		}

		return false;
	}


	public function getDrugStore($location_id){
		if (is_numeric($location_id)){
			$query = $this->db->query("SELECT * FROM oc_location ol WHERE ol.location_id = '" . (int)$location_id . "' LIMIT 1");
		} else {
			$query = $this->db->query("SELECT * FROM oc_location ol WHERE ol.uuid = '" . $this->db->escape($location_id) . "' LIMIT 1");
		}

		if ($query->num_rows){			
			$description_query_RU = $this->db->query("SELECT * FROM oc_location_description WHERE location_id = '" . $query->row['location_id'] . "' AND language_id = '2'");
			$description_query_UA = $this->db->query("SELECT * FROM oc_location_description WHERE location_id = '" . $query->row['location_id'] . "' AND language_id = '3'");
			$city_query    		  = $this->db->query("SELECT * FROM oc_novaposhta_cities WHERE Ref = '" . $query->row['city_id'] . "'");

			return [
				'drugstoreID' 				=> $query->row['location_id'],
				'drugstoreUUID' 			=> $query->row['uuid'],
				'drugstoreName_RU' 			=> $description_query_RU->row['name'],
				'drugstoreName_UA' 			=> $description_query_UA->row['name'],
				'drugstoreAddress_RU' 		=> $description_query_RU->row['address'],
				'drugstoreAddress_UA' 		=> $description_query_UA->row['address'],
				'drugstoreCityUUID' 		=> $query->row['city_id'],
				'drugstoreCity' 			=> $query->row['city'],
				'drugstoreNPCityName_RU' 	=> $city_query->num_rows?$city_query->row['DescriptionRu']:'',
				'drugstoreNPCityName_UA' 	=> $city_query->num_rows?$city_query->row['Description']:'',
				'drugstoreBrand' 			=> $query->row['brand'],
				'drugstoreTelephone' 		=> $query->row['telephone'],
				'drugstoreFax' 				=> $query->row['fax'],
				'drugstoreGeoCode' 			=> $query->row['geocode'],
				'drugstoreGmapsLink' 		=> $query->row['gmaps_link'],
				'drugstoreImage' 			=> $query->row['image'],
				'drugstoreOpen' 			=> $query->row['open'],
				'drugstoreOpenStruct' 		=> $query->row['open_struct'],
				'drugstoreDeliveryTimes' 	=> $query->row['delivery_times'],
				'drugstoreComment' 			=> $query->row['comment'],
				'drugstoreNodeID' 			=> $query->row['node_id'],
				'drugstoreIsStock' 			=> $query->row['is_stock'],
				'drugstoreCanSellDrugs'		=> $query->row['can_sell_drugs'],
				'drugstoreUUID' 			=> $query->row['uuid'],
				'drugstoreLastSync'			=> $query->row['last_sync'],
				'drugstoreDefaultPrice'		=> $query->row['default_price'],
				'drugstoreSortOrder'		=> $query->row['sort_order'],
				'drugstoreInformationID'	=> $query->row['information_id'],
				'drugstoreClosed' 			=> $query->row['temprorary_closed'],
			];
		}

		return false;
	}


	public function deleteDrugstore($location_id){
		$drugstore = $this->getDrugStore($location_id);
		if (!$drugstore){
			return false;
		}

		$this->db->query("DELETE FROM oc_location WHERE location_id = " . (int)$drugstore['drugstoreID']);
		$this->db->query("DELETE FROM oc_location_description WHERE location_id = " . (int)$drugstore['drugstoreID']);		
		$this->db->query("DELETE FROM oc_stocks WHERE location_id = " . (int)$drugstore['drugstoreID']);

		return [
			'drugstoreUUID' 	=> $drugstore['drugstoreUUID'],
			'drugstoreID' 		=> $drugstore['drugstoreID'],
			'drugstoreInfo'		=> 'DELETED SUCCESSFULLY',
		];
	}

	public function addDrugstore($data){
		if ($this->getDrugStore($data['drugstoreUUID'])){
			return false;
		}

		$this->db->query("INSERT INTO oc_location SET 
			name 				= '" . $this->db->escape($data['drugstoreName_UA']) . "', 
			address 			= '" . $this->db->escape($data['drugstoreAddress_UA']) . "', 
			geocode 			= '" . $this->db->escape($data['drugstoreGeoCode']) . "', 
			gmaps_link 			= '" . (!empty($data['drugstoreGmapsLink'])?$this->db->escape($data['drugstoreGmapsLink']):'') . "', 
			telephone 			= '" . $this->db->escape($data['drugstoreTelephone']) . "', 
			fax 				= '" . (!empty($data['drugstoreFax'])?$this->db->escape($data['drugstoreFax']):'') . "', 			
			open 				= '" . $this->db->escape($data['drugstoreOpen']) . "', 
			open_struct 		= '" . (!empty($data['drugstoreFax'])?$this->db->escape($data['drugstoreOpenStruct']):'') . "', 
			brand 				= '" . $this->db->escape($data['drugstoreBrand']) . "',
			city 				= '" . (!empty($data['drugstoreCity'])?$this->db->escape($data['drugstoreCity']):'') . "',
			city_id 			= '" . (!empty($data['drugstoreCityUUID'])?$this->db->escape($data['drugstoreCityUUID']):'') . "',
			can_sell_drugs 		= '" . (int)$data['drugstoreCanSellDrugs'] . "', 
			temprorary_closed 	= '" . (int)$data['drugstoreClosed'] . "', 
			sort_order 			= '" . (!empty($data['drugstoreSortOrder'])?(int)$data['drugstoreSortOrder']:'') . "',  
			uuid 				= '" . $this->db->escape($data['drugstoreUUID']) . "'");
			
			$location_id = $this->db->getLastId();

			$data['location_description'] = [
				'2' => [
					'name' 		=> $data['drugstoreName_RU'],
					'address' 	=> $data['drugstoreAddress_RU'],
					'open' 		=> $data['drugstoreOpen'],
				],

				'3' => [
					'name' 		=> $data['drugstoreName_UA'],
					'address' 	=> $data['drugstoreAddress_UA'],
					'open' 		=> $data['drugstoreOpen'],
				] 
			];
			
			foreach ($data['location_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO oc_location_description SET 
					location_id 	= '" . (int)$location_id . "', 
					language_id 	= '" . (int)$language_id . "', 
					name 			= '" . $this->db->escape($value['name']) . "', 
					open 			= '" . $this->db->escape($value['open']) . "', 
					address 		= '" . $this->db->escape($value['address']) . "'");
			}

		return $this->getDrugStore($data['drugstoreUUID']);
	}


	public function editDrugstore($drugstore_id, $data){
		$drugstore = $this->getDrugStore($data['drugstoreUUID']);

		if (!$drugstore){
			return false;
		}

		$this->db->query("UPDATE oc_location SET 
			name 				= '" . $this->db->escape($data['drugstoreName_UA']) . "', 
			address 			= '" . $this->db->escape($data['drugstoreAddress_UA']) . "', 
			geocode 			= '" . $this->db->escape($data['drugstoreGeoCode']) . "', 
			gmaps_link 			= '" . (!empty($data['drugstoreGmapsLink'])?$this->db->escape($data['drugstoreGmapsLink']):'') . "', 
			telephone 			= '" . $this->db->escape($data['drugstoreTelephone']) . "', 
			fax 				= '" . (!empty($data['drugstoreFax'])?$this->db->escape($data['drugstoreFax']):'') . "', 			
			open 				= '" . $this->db->escape($data['drugstoreOpen']) . "', 
			open_struct 		= '" . (!empty($data['drugstoreFax'])?$this->db->escape($data['drugstoreOpenStruct']):'') . "', 
			brand 				= '" . $this->db->escape($data['drugstoreBrand']) . "',
			city 				= '" . (!empty($data['drugstoreCity'])?$this->db->escape($data['drugstoreCity']):'') . "',
			city_id 			= '" . (!empty($data['drugstoreCityUUID'])?$this->db->escape($data['drugstoreCityUUID']):'') . "',
			can_sell_drugs 		= '" . (int)$data['drugstoreCanSellDrugs'] . "', 
			temprorary_closed 	= '" . (int)$data['drugstoreClosed'] . "', 
			sort_order 			= '" . (!empty($data['drugstoreSortOrder'])?(int)$data['drugstoreSortOrder']:'') . "'
			WHERE  			
			location_id      = '" . (int)$drugstore['drugstoreID'] . "'
			");			

			$this->db->query("DELETE FROM oc_location_description WHERE location_id = '" . (int)$drugstore['drugstoreID'] . "'");			

			$data['location_description'] = [
				'2' => [
					'name' 		=> $data['drugstoreName_RU'],
					'address' 	=> $data['drugstoreAddress_RU'],
					'open' 		=> $data['drugstoreOpen'],
				],

				'3' => [
					'name' 		=> $data['drugstoreName_UA'],
					'address' 	=> $data['drugstoreAddress_UA'],
					'open' 		=> $data['drugstoreOpen'],
				] 
			];
			
			foreach ($data['location_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO oc_location_description SET 
					location_id 	= '" . (int)$drugstore['drugstoreID'] . "', 
					language_id 	= '" . (int)$language_id . "', 
					name 			= '" . $this->db->escape($value['name']) . "', 
					open 			= '" . $this->db->escape($value['open']) . "', 
					address 		= '" . $this->db->escape($value['address']) . "'");
			}

		return $this->getDrugStore($data['drugstoreUUID']);
	}

}