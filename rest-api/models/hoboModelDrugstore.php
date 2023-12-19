<?

namespace hobotix;

class hoboModelDrugstore extends hoboModel{	
	private $translations_ru_ua = [
		'Аптекарь' 				=> 'Аптекар',
		'Мед-сервис' 			=> 'Мед-сервіс',
		'Мед-сервис Beauty' 	=> 'Мед-сервіс Beauty',
		'Городская семейная аптека' => 'Міська сімейна аптека'
	];	

	private $naming_prefix = 'Аптека №АГП';

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

	public function getDrugStoreId($location_id){
		if (is_numeric($location_id)){
			$query = $this->db->query("SELECT * FROM oc_location ol WHERE ol.location_id = '" . (int)$location_id . "' LIMIT 1");
		} else {
			$query = $this->db->query("SELECT * FROM oc_location ol WHERE ol.uuid = '" . $this->db->escape($location_id) . "' LIMIT 1");
		}

		if ($query->num_rows){
			return $query->row['location_id'];
		} else {
			return false;
		}
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

		if (!empty($data['drugstoreName_UA'])){
			if (stripos($data['drugstoreName_UA'], 'Склад') !== false || stripos($data['drugstoreName_UA'], 'склад') !== false){
				return false;
			}
		}

		$this->db->query("INSERT INTO oc_location SET 
			name 				= '" . $this->db->escape($data['drugstoreName_UA']) . "', 
			address 			= '" . $this->db->escape($data['drugstoreAddress_UA']) . "', 
			geocode 			= '" . $this->db->escape($data['drugstoreGeoCode']) . "', 
			gmaps_link 			= '" . (!empty($data['drugstoreGmapsLink'])?$this->db->escape($data['drugstoreGmapsLink']):'') . "', 
			telephone 			= '" . (!empty($data['drugstoreTelephone'])?$this->db->escape($data['drugstoreTelephone']):'+38(044)520-03-33') . "', 
			fax 				= '" . (!empty($data['drugstoreFax'])?$this->db->escape($data['drugstoreFax']):'') . "', 			
			open 				= '" . $this->db->escape($data['drugstoreOpen']) . "', 
			open_struct 		= '" . (!empty($data['drugstoreOpenStruct'])?$this->db->escape($data['drugstoreOpenStruct']):'') . "', 
			brand 				= '" . $this->db->escape($data['drugstoreBrand']) . "',
			is_stock 			= '" . (isset($data['drugstoreIsStock'])?$this->db->escape($data['drugstoreIsStock']):'1') . "',
			city 				= '" . (!empty($data['drugstoreCity'])?$this->db->escape($data['drugstoreCity']):'') . "',
			city_id 			= '" . (!empty($data['drugstoreCityUUID'])?$this->db->escape($data['drugstoreCityUUID']):'') . "',
			can_sell_drugs 		= '" . (isset($data['drugstoreCanSellDrugs'])?(int)$data['drugstoreCanSellDrugs']:'0') . "',  
			temprorary_closed 	= '" . (isset($data['drugstoreClosed'])?(int)$data['drugstoreClosed']:'0') . "', 
			sort_order 			= '" . (!empty($data['drugstoreSortOrder'])?(int)$data['drugstoreSortOrder']:'0') . "',  
			uuid 				= '" . $this->db->escape($data['drugstoreUUID']) . "'");
			
			$location_id = $this->db->getLastId();

			$data['location_description'] = [
				'2' => [
					'name' 		=> $data['drugstoreName_RU'],
					'address' 	=> $data['drugstoreAddress_RU'],
					'open' 		=> $data['drugstoreOpen'],
					'brand' 	=> $data['drugstoreBrand']
				],

				'3' => [
					'name' 		=> $data['drugstoreName_UA'],
					'address' 	=> $data['drugstoreAddress_UA'],
					'open' 		=> $data['drugstoreOpen'],
					'brand' 	=> $data['drugstoreBrand']
				] 
			];
			
			foreach ($data['location_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO oc_location_description SET 
					location_id 	= '" . (int)$location_id . "', 
					language_id 	= '" . (int)$language_id . "', 
					name 			= '" . $this->db->escape($value['name']) . "', 
					open 			= '" . $this->db->escape($value['open']) . "',
					brand 			= '" . $this->db->escape($value['brand']) . "',
					address 		= '" . $this->db->escape($value['address']) . "'");
			}

		$this->postProcess($location_id, $data);

		return $this->getDrugStore($data['drugstoreUUID']);
	}

	public function editDrugstore($drugstore_id, $data){	
		if (is_numeric($drugstore_id)){
			$drugstore = $this->getDrugStore($drugstore_id);
		} else {
			$drugstore = $this->getDrugStore($data['drugstoreUUID']);
		}
		
		if (!$drugstore){
			return false;
		}

		if (empty($data['drugstoreGmapsLink'])){
			$data['drugstoreGmapsLink'] = $drugstore['drugstoreGmapsLink'];
		}

		if (empty($data['drugstoreTelephone'])){
			$data['drugstoreTelephone'] = $drugstore['drugstoreTelephone'];
		}

		if (empty($data['drugstoreCanSellDrugs'])){
			$data['drugstoreCanSellDrugs'] = $drugstore['drugstoreCanSellDrugs'];
		}

		if (empty($data['drugstoreSortOrder'])){
			$data['drugstoreSortOrder'] = $drugstore['drugstoreSortOrder'];
		}

		if (!isset($data['drugstoreIsStock'])){
			$data['drugstoreIsStock'] = $drugstore['drugstoreIsStock'];
		}

		$this->db->query("UPDATE oc_location SET 
			name 				= '" . $this->db->escape($data['drugstoreName_UA']) . "', 
			address 			= '" . $this->db->escape($data['drugstoreAddress_UA']) . "', 
			geocode 			= '" . $this->db->escape($data['drugstoreGeoCode']) . "', 
			gmaps_link 			= '" . (!empty($data['drugstoreGmapsLink'])?$this->db->escape($data['drugstoreGmapsLink']):'') . "', 
			telephone 			= '" . (!empty($data['drugstoreTelephone'])?$this->db->escape($data['drugstoreTelephone']):'+38(044)520-03-33') . "', 
			fax 				= '" . (!empty($data['drugstoreFax'])?$this->db->escape($data['drugstoreFax']):'') . "', 			
			open 				= '" . $this->db->escape($data['drugstoreOpen']) . "', 
			open_struct 		= '" . (!empty($data['drugstoreOpenStruct'])?$this->db->escape($data['drugstoreOpenStruct']):'') . "', 
			brand 				= '" . $this->db->escape($data['drugstoreBrand']) . "',
			is_stock 			= '" . (isset($data['drugstoreIsStock'])?$this->db->escape($data['drugstoreIsStock']):'1') . "',
			city 				= '" . (!empty($data['drugstoreCity'])?$this->db->escape($data['drugstoreCity']):'') . "',
			city_id 			= '" . (!empty($data['drugstoreCityUUID'])?$this->db->escape($data['drugstoreCityUUID']):'') . "',
			can_sell_drugs 		= '" . (isset($data['drugstoreCanSellDrugs'])?(int)$data['drugstoreCanSellDrugs']:'0') . "',  
			temprorary_closed 	= '" . (isset($data['drugstoreClosed'])?(int)$data['drugstoreClosed']:'0') . "', 
			sort_order 			= '" . (!empty($data['drugstoreSortOrder'])?(int)$data['drugstoreSortOrder']:'0') . "'
			WHERE  			
			location_id      = '" . (int)$drugstore['drugstoreID'] . "'
			");			

			$this->db->query("DELETE FROM oc_location_description WHERE location_id = '" . (int)$drugstore['drugstoreID'] . "'");			

			$data['location_description'] = [
				'2' => [
					'name' 		=> $data['drugstoreName_RU'],
					'address' 	=> $data['drugstoreAddress_RU'],
					'open' 		=> $data['drugstoreOpen'],
					'brand' 	=> $data['drugstoreBrand']
				],

				'3' => [
					'name' 		=> $data['drugstoreName_UA'],
					'address' 	=> $data['drugstoreAddress_UA'],
					'open' 		=> $data['drugstoreOpen'],
					'brand' 	=> $data['drugstoreBrand']
				] 
			];
			
			foreach ($data['location_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO oc_location_description SET 
					location_id 	= '" . (int)$drugstore['drugstoreID'] . "', 
					language_id 	= '" . (int)$language_id . "', 
					name 			= '" . $this->db->escape($value['name']) . "', 
					open 			= '" . $this->db->escape($value['open']) . "',
					brand 			= '" . $this->db->escape($value['brand']) . "',
					address 		= '" . $this->db->escape($value['address']) . "'");
			}

		$this->postProcess($drugstore['drugstoreID'], $data);

		return $this->getDrugStore($data['drugstoreUUID']);
	}

	private function postProcess($drugstore_id, $data){
		if (!empty($data['drugstoreCity'])){
			$sql = "SELECT * FROM `oc_novaposhta_cities` 
			WHERE LOWER(Description) LIKE '" . $this->db->escape(mb_strtolower($data['drugstoreCity'])) . "' 
			OR LOWER(DescriptionRu) LIKE '" . $this->db->escape(mb_strtolower($data['drugstoreCity'])) . "' LIMIT 1";

			$query = $this->db->query($sql);

			if ($query->num_rows && !empty($query->row['Ref'])){
				$this->db->query("UPDATE oc_location SET city_id = '" .  $this->db->escape($query->row['Ref']) . "' WHERE location_id = '" . (int)$drugstore_id . "'");
			}
		}

		if (!empty($data['drugstoreOpenStruct'])){
			$drugstoreOpenStructExploded = explodeByEOL($data['drugstoreOpenStruct']);

			$drugstoreOpenStruct = '';
			for ($i=1; $i<=7; $i++){	
				$drugstoreOpenStruct .= $i . '/' . $drugstoreOpenStructExploded[$i-1] . PHP_EOL;
			}

			$this->db->query("UPDATE oc_location SET open_struct = '" .  $this->db->escape($drugstoreOpenStruct) . "' WHERE location_id = '" . (int)$drugstore_id . "'");
		} elseif (!empty($data['drugstoreOpen'])){
			$drugstoreOpenStruct = '';
			for ($i=1; $i<=7; $i++){	
				$drugstoreOpenStruct .= $i . '/' . $data['drugstoreOpen'] . PHP_EOL;
			}
			$drugstoreOpenStruct = trim($drugstoreOpenStruct);

			$this->db->query("UPDATE oc_location SET open_struct = '" .  $this->db->escape($drugstoreOpenStruct) . "' WHERE location_id = '" . (int)$drugstore_id . "'");
		}


		$drugstoreBrand = $data['drugstoreBrand'];
		if (!empty($this->translations_ru_ua[$data['drugstoreBrand']])){
			$drugstoreBrand = $this->translations_ru_ua[$data['drugstoreBrand']];
			$this->db->query("UPDATE oc_location SET brand = '" .  $this->db->escape($drugstoreBrand) . "' WHERE location_id = '" . (int)$drugstore_id . "'");
			$this->db->query("UPDATE oc_location_description SET brand = '" .  $this->db->escape($drugstoreBrand) . "' WHERE location_id = '" . (int)$drugstore_id . "' AND language_id = 3");
		}

		if (!empty($data['drugstoreName_RU'])){
			$drugstoreName_RU = str_replace($this->naming_prefix, '', $data['drugstoreName_RU']);
			$drugstoreName_RU = trim($drugstoreName_RU);

			$drugstoreName_RU = 'Аптека ' . $data['drugstoreBrand'] . ' №' . $drugstoreName_RU;
			$this->db->query("UPDATE oc_location_description SET name = '" .  $this->db->escape($drugstoreName_RU) . "' WHERE location_id = '" . (int)$drugstore_id . "' AND language_id = 2");
		}

		if (!empty($data['drugstoreName_UA'])){
			$drugstoreName_UA = str_replace($this->naming_prefix, '', $data['drugstoreName_UA']);
			$drugstoreName_UA = trim($drugstoreName_UA);

			$drugstoreName_UA = 'Аптека ' . $drugstoreBrand . ' №' . $drugstoreName_UA;
			$this->db->query("UPDATE oc_location SET name = '" .  $this->db->escape($drugstoreName_UA) . "' WHERE location_id = '" . (int)$drugstore_id . "'");
			$this->db->query("UPDATE oc_location_description SET name = '" .  $this->db->escape($drugstoreName_UA) . "' WHERE location_id = '" . (int)$drugstore_id . "' AND language_id = 3");
		}

		$this->db->query("UPDATE oc_location_description SET name = REPLACE(name, 'Київська обл., м.Київ', 'м.Київ') WHERE location_id = '" . (int)$drugstore_id . "'");
		$this->db->query("UPDATE oc_location_description SET address = REPLACE(address, 'Київська обл., м.Київ', 'м.Київ') WHERE location_id = '" . (int)$drugstore_id . "'");
		$this->db->query("UPDATE oc_location SET name = REPLACE(name, 'Київська обл., м.Київ', 'м.Київ') WHERE location_id = '" . (int)$drugstore_id . "'");
		$this->db->query("UPDATE oc_location SET address = REPLACE(address, 'Київська обл., м.Київ', 'м.Київ') WHERE location_id = '" . (int)$drugstore_id . "'");

	}

}