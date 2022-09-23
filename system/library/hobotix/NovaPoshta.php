<?php
	
	namespace hobotix;
	use Exception;
	
	class NovaPoshta {
		private $db;
		private $config;
		private $registry;
		
		private $apiKey = '';
		private $host = 'https://api.novaposhta.ua/v2.0/json/';
		
		
		public function __construct($registry) {			
			$this->registry = $registry;
			$this->config = $this->registry->get('config');
			$this->db = $this->registry->get('db');

			$this->apiKey = NOVAPOSHTA_API_KEY;
		}
		
		private function validateResult($result){
			$tmp = $result;
			
			$result = json_decode($result, true);
			
			if (!$result || !is_array($result)){
				print_r($tmp);
				throw new Exception('Нечитаемый JSON');
			}
			
			if ($result['success'] === 'false'){
				print_r($tmp);
				throw new Exception('Ошибка обработки ' . serialize($result));
			}
			
			return $result;
			
		}
		
		
		private function doRequest($data){
			
			$json = array(			
			'apiKey' 			=> $this->apiKey			
			);
			
			foreach ($data as $key => $value){
				$json[$key] = $value;
			}
			
			
			$json = json_encode($json);
			
			echoLine('[NP] Запрос ' . $data['modelName'] . '/' . $data['calledMethod']);
			
			$curl = curl_init($this->host);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Content-Length: '.strlen($json)));
			curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 50);	
			curl_setopt($curl, CURLOPT_TIMEOUT, 100);
			//	curl_setopt($curl, CURLOPT_VERBOSE, true);
			
			$result = curl_exec($curl);
			
			curl_close($curl);
			
			try{
				
				$result = $this->validateResult($result);
				return $result;
				
				} catch (Exception $e){
				
				echoLine($e->getMessage());
				die();
			}	
		}
		
		
		
		public function updateZones(){
			$data = array(
			'modelName' 		=> 'Address',
			'calledMethod' 		=> 'getAreas',		
			);
			
			
			$result = $this->doRequest($data);
			
			foreach ($result['data'] as $line){
				
				echoLine('[NP] Область ' . $line['Description']);
				
				$this->db->query("INSERT INTO novaposhta_zones SET 
				Ref = '" . $this->db->escape($line['Ref']) . "',
				Description = '" . $this->db->escape($line['Description']) . "',
				DescriptionRu = '" . $this->db->escape($line['DescriptionRu']) . "',
				AreasCenter = '" . $this->db->escape($line['AreasCenter']) . "'
				ON DUPLICATE KEY UPDATE
				Description = '" . $this->db->escape($line['Description']) . "',
				DescriptionRu = '" . $this->db->escape($line['DescriptionRu']) . "',
				AreasCenter = '" . $this->db->escape($line['AreasCenter']) . "'");
			}
			
			return $this;
		}
		
		public function updateCities(){
			$data = array(
			'modelName' 		=> 'AddressGeneral',
			'calledMethod' 		=> 'getSettlements',		
			);
			
			$result = $this->doRequest($data);

			var_dump($result);

			$totalCount = (int)$result['info']['totalCount'];
			$maxPage = ceil($totalCount / 150);
			
			for ($page = 1; $page <= ($maxPage + 1); $page++){
				
				echoLine('[NP] Страница ' . $page . '/' . $maxPage);
				
				$data['methodProperties']['Page'] = $page;
				
				$result = $this->doRequest($data);
				
				
				
				foreach ($result['data'] as $line){
					
					echoLine('[NP] Город ' . $line['Description']);
					
					$this->db->query("INSERT INTO novaposhta_cities SET 
					Ref = '" . $this->db->escape($line['Ref']) . "',
					Description = '" . $this->db->escape($line['Description']) . "',
					DescriptionRu = '" . $this->db->escape($line['DescriptionRu']) . "',
					Area = '" . $this->db->escape($line['Area']) . "',
					SettlementType = '" . $this->db->escape($line['SettlementType']) . "',
					SettlementTypeDescription = '" . $this->db->escape($line['SettlementTypeDescription']) . "',
					SettlementTypeDescriptionRu = '" . $this->db->escape($line['SettlementTypeDescriptionRu']) . "',
					RegionsDescription  = '" . $this->db->escape($line['RegionsDescription']) . "',
					RegionsDescriptionRu = '" . $this->db->escape($line['RegionsDescriptionRu']) . "',
					AreaDescription = '" . $this->db->escape($line['AreaDescription']) . "',
					AreaDescriptionRu = '" . $this->db->escape($line['AreaDescriptionRu']) . "',
					Index1 = '" . $this->db->escape($line['Index1']) . "',
					Index2 = '" . $this->db->escape($line['Index2']) . "',
					Delivery1 = '" . (int)$line['Delivery1'] . "',
					Delivery2 = '" . (int)$line['Delivery2'] . "',
					Delivery3 = '" . (int)$line['Delivery3'] . "',
					Delivery4 = '" . (int)$line['Delivery4'] . "',
					Delivery5 = '" . (int)$line['Delivery5'] . "',
					Delivery6 = '" . (int)$line['Delivery6'] . "',
					Delivery7 = '" . (int)$line['Delivery7'] . "',
					Latitude = '" . $this->db->escape($line['Latitude']) . "',
					Longitude = '" . $this->db->escape($line['Longitude']) . "',
					SpecialCashCheck = '" . (int)$line['SpecialCashCheck'] . "',
					Warehouse = '" . (int)$line['Warehouse'] . "'
					ON DUPLICATE KEY UPDATE
					Description = '" . $this->db->escape($line['Description']) . "',
					DescriptionRu = '" . $this->db->escape($line['DescriptionRu']) . "',
					Area = '" . $this->db->escape($line['Area']) . "',
					SettlementType = '" . $this->db->escape($line['SettlementType']) . "',
					SettlementTypeDescription = '" . $this->db->escape($line['SettlementTypeDescription']) . "',
					SettlementTypeDescriptionRu = '" . $this->db->escape($line['SettlementTypeDescriptionRu']) . "',
					RegionsDescription  = '" . $this->db->escape($line['RegionsDescription']) . "',
					RegionsDescriptionRu = '" . $this->db->escape($line['RegionsDescriptionRu']) . "',
					AreaDescription = '" . $this->db->escape($line['AreaDescription']) . "',
					AreaDescriptionRu = '" . $this->db->escape($line['AreaDescriptionRu']) . "',
					Index1 = '" . $this->db->escape($line['Index1']) . "',
					Index2 = '" . $this->db->escape($line['Index2']) . "',
					Delivery1 = '" . (int)$line['Delivery1'] . "',
					Delivery2 = '" . (int)$line['Delivery2'] . "',
					Delivery3 = '" . (int)$line['Delivery3'] . "',
					Delivery4 = '" . (int)$line['Delivery4'] . "',
					Delivery5 = '" . (int)$line['Delivery5'] . "',
					Delivery6 = '" . (int)$line['Delivery6'] . "',
					Delivery7 = '" . (int)$line['Delivery7'] . "',
					Latitude = '" . $this->db->escape($line['Latitude']) . "',
					Longitude = '" . $this->db->escape($line['Longitude']) . "',
					SpecialCashCheck = '" . (int)$line['SpecialCashCheck'] . "',
					Warehouse = '" . (int)$line['Warehouse'] . "'");
				}
				
				
			}
			return $this;
		}
		
		public function updateCitiesWW(){
			$data = array(
			'modelName' 		=> 'Address',
			'calledMethod' 		=> 'getCities',		
			);
			
			$result = $this->doRequest($data);
			$totalCount = (int)$result['info']['totalCount'];
			
			foreach ($result['data'] as $line){
				
				echoLine('[NP] Город ' . $line['Description']);
				
				$this->db->query("INSERT INTO novaposhta_cities_ww SET 
				Ref = '" . $this->db->escape($line['Ref']) . "',
				Description = '" . $this->db->escape($line['Description']) . "',
				DescriptionRu = '" . $this->db->escape($line['DescriptionRu']) . "',
				Area = '" . $this->db->escape($line['Area']) . "',									
				Delivery1 = '" . (int)$line['Delivery1'] . "',
				Delivery2 = '" . (int)$line['Delivery2'] . "',
				Delivery3 = '" . (int)$line['Delivery3'] . "',
				Delivery4 = '" . (int)$line['Delivery4'] . "',
				Delivery5 = '" . (int)$line['Delivery5'] . "',
				Delivery6 = '" . (int)$line['Delivery6'] . "',
				Delivery7 = '" . (int)$line['Delivery7'] . "',
				SettlementType = '" . $this->db->escape($line['SettlementType']) . "',
				SettlementTypeDescription = '" . $this->db->escape($line['SettlementTypeDescription']) . "',
				SettlementTypeDescriptionRu = '" . $this->db->escape($line['SettlementTypeDescriptionRu']) . "'
				ON DUPLICATE KEY UPDATE
				Description = '" . $this->db->escape($line['Description']) . "',
				DescriptionRu = '" . $this->db->escape($line['DescriptionRu']) . "',
				Area = '" . $this->db->escape($line['Area']) . "',										
				Delivery1 = '" . (int)$line['Delivery1'] . "',
				Delivery2 = '" . (int)$line['Delivery2'] . "',
				Delivery3 = '" . (int)$line['Delivery3'] . "',
				Delivery4 = '" . (int)$line['Delivery4'] . "',
				Delivery5 = '" . (int)$line['Delivery5'] . "',
				Delivery6 = '" . (int)$line['Delivery6'] . "',
				Delivery7 = '" . (int)$line['Delivery7'] . "',
				SettlementType = '" . $this->db->escape($line['SettlementType']) . "',
				SettlementTypeDescription = '" . $this->db->escape($line['SettlementTypeDescription']) . "',
				SettlementTypeDescriptionRu = '" . $this->db->escape($line['SettlementTypeDescriptionRu']) . "'");			
			}
			
			return $this;
		}
		
		
		public function updateWareHouses(){
			
			$data = array(
			'modelName' 		=> 'Address',
			'calledMethod' 		=> 'getWarehouseTypes',		
			);
			
			$result = $this->doRequest($data);
			
			$typeOfWarehouse = array();
			foreach ($result['data'] as $line){
				$typeOfWarehouse[$line['Ref']] = array(
				'TypeOfWarehouse' => $line['Description'],
				'TypeOfWarehouseRu' => $line['DescriptionRu']
				);
			}
			
			$data = array(
			'modelName' 		=> 'Address',
			'calledMethod' 		=> 'getWarehouses',		
			);
			
			$result = $this->doRequest($data);
			$totalCount = (int)$result['info']['totalCount'];
			$maxPage = ceil($totalCount / 400);
			
			for ($page = 1; $page <= ($maxPage + 1); $page++){
				
				echoLine('[NP] Страница ' . $page . '/' . $maxPage);
				$data['methodProperties']['Page'] = $page;
				
				$result = $this->doRequest($data);
				
				foreach ($result['data'] as $line){
					
					
					echoLine('[NP] 	Отделение ' . $line['Description']);
					
					$this->db->query("INSERT INTO novaposhta_warehouses SET 
					Ref = '" . $this->db->escape($line['Ref']) . "',
					SiteKey = '" . (int)$line['SiteKey'] . "',
					Number = '" . (int)$line['Number'] . "',
					TotalMaxWeightAllowed = '" . (int)$line['TotalMaxWeightAllowed'] . "',
					PlaceMaxWeightAllowed = '" . (int)$line['PlaceMaxWeightAllowed'] . "',
					Description = '" . $this->db->escape($line['Description']) . "',
					DescriptionRu = '" . $this->db->escape($line['DescriptionRu']) . "',
					TypeOfWarehouseRef = '" . $this->db->escape($line['TypeOfWarehouse']) . "',
					TypeOfWarehouse = '" . $this->db->escape($typeOfWarehouse[$line['TypeOfWarehouse']]['TypeOfWarehouse']) . "',
					TypeOfWarehouseRu = '" . $this->db->escape($typeOfWarehouse[$line['TypeOfWarehouse']]['TypeOfWarehouseRu']) . "',
					CityRef = '" . $this->db->escape($line['CityRef']) . "',
					CityDescription = '" . $this->db->escape($line['CityDescription']) . "',
					CityDescriptionRu = '" . $this->db->escape($line['CityDescriptionRu']) . "',
					Longitude = '" . $this->db->escape($line['Longitude']) . "',
					Latitude = '" . $this->db->escape($line['Latitude']) . "',
					PostFinance = '" . (int)$line['PostFinance'] . "',
					POSTerminal = '" . (int)$line['POSTerminal'] . "',
					Reception = '" . json_encode($line['Reception']) . "',
					Delivery = '" . json_encode($line['Delivery']) . "',
					Schedule = '" . json_encode($line['Schedule']) . "'
					ON DUPLICATE KEY UPDATE
					SiteKey = '" . (int)$line['SiteKey'] . "',
					Number = '" . (int)$line['Number'] . "',
					TotalMaxWeightAllowed = '" . (int)$line['TotalMaxWeightAllowed'] . "',
					PlaceMaxWeightAllowed = '" . (int)$line['PlaceMaxWeightAllowed'] . "',
					Description = '" . $this->db->escape($line['Description']) . "',
					DescriptionRu = '" . $this->db->escape($line['DescriptionRu']) . "',
					TypeOfWarehouseRef = '" . $this->db->escape($line['TypeOfWarehouse']) . "',
					TypeOfWarehouse = '" . $this->db->escape($typeOfWarehouse[$line['TypeOfWarehouse']]['TypeOfWarehouse']) . "',
					TypeOfWarehouseRu = '" . $this->db->escape($typeOfWarehouse[$line['TypeOfWarehouse']]['TypeOfWarehouseRu']) . "',
					CityRef = '" . $this->db->escape($line['CityRef']) . "',
					CityDescription = '" . $this->db->escape($line['CityDescription']) . "',
					CityDescriptionRu = '" . $this->db->escape($line['CityDescriptionRu']) . "',
					Longitude = '" . $this->db->escape($line['Longitude']) . "',
					Latitude = '" . $this->db->escape($line['Latitude']) . "',
					PostFinance = '" . (int)$line['PostFinance'] . "',
					POSTerminal = '" . (int)$line['POSTerminal'] . "',
					Reception = '" . json_encode($line['Reception']) . "',
					Delivery = '" . json_encode($line['Delivery']) . "',
					Schedule = '" . json_encode($line['Schedule']) . "'");		
					
				}
			}
			
			//Обновление количества отделений
			$this->db->query("UPDATE novaposhta_cities_ww SET WarehouseCount = (SELECT COUNT(Ref) FROM novaposhta_warehouses WHERE CityRef = novaposhta_cities_ww.Ref)");
			
			return $this;
			
		}
		
		public function getRealTimeStreets($CityRef){
			$data = array(
			'modelName' 		=> 'Address',
			'calledMethod' 		=> 'getStreet',		
			);
			
			$data['methodProperties']['CityRef'] = $CityRef;
			
			$result = $this->doRequest($data);
			$totalCount = $result['info']['totalCount'];
			
			if ($totalCount <= 500){
				foreach ($result['data'] as $line){
					
					$this->db->query("INSERT INTO novaposhta_streets SET 
					Ref = '" . $this->db->escape($line['Ref']) . "',
					CityRef = '" . $this->db->escape($row['Ref']) . "',
					Description = '" . $this->db->escape($line['Description']) . "',				
					StreetsTypeRef  = '" . $this->db->escape($line['StreetsTypeRef']) . "',
					StreetsType = '" . $this->db->escape($line['StreetsType']) . "'
					ON DUPLICATE KEY UPDATE
					CityRef = '" . $this->db->escape($row['Ref']) . "',
					Description = '" . $this->db->escape($line['Description']) . "',				
					StreetsTypeRef  = '" . $this->db->escape($line['StreetsTypeRef']) . "',
					StreetsType = '" . $this->db->escape($line['StreetsType']) . "'");
				}
			}
			
		}
		
		public function updateStreets(){
			
			$data = array(
			'modelName' 		=> 'Address',
			'calledMethod' 		=> 'getStreet',		
			);
			
			
			$query = $this->db->query("SELECT Ref, Description FROM novaposhta_cities_ww WHERE 1 ORDER BY WarehouseCount DESC");
			
			foreach ($query->rows as $row){
				
				$data['methodProperties']['CityRef'] = $row['Ref'];
				
				$result = $this->doRequest($data);
				$totalCount = $result['info']['totalCount'];
				echoLine('[NP] Город ' . $row['Description'] .': '. $totalCount);
				
				$maxPage = ceil($totalCount / 490);
				
				for ($page = 1; $page <= ($maxPage + 1); $page++){
					
					echoLine('[NP] Страница ' . $page . '/' . $maxPage);
					$data['methodProperties']['Page'] = $page;
					
					$result = $this->doRequest($data);
					
					foreach ($result['data'] as $line){
						
						echoLine('[NP] 	Улица ' . $line['Description']);
						
						$this->db->query("INSERT INTO novaposhta_streets SET 
						Ref = '" . $this->db->escape($line['Ref']) . "',
						CityRef = '" . $this->db->escape($row['Ref']) . "',
						Description = '" . $this->db->escape($line['Description']) . "',				
						StreetsTypeRef  = '" . $this->db->escape($line['StreetsTypeRef']) . "',
						StreetsType = '" . $this->db->escape($line['StreetsType']) . "'
						ON DUPLICATE KEY UPDATE
						CityRef = '" . $this->db->escape($row['Ref']) . "',
						Description = '" . $this->db->escape($line['Description']) . "',				
						StreetsTypeRef  = '" . $this->db->escape($line['StreetsTypeRef']) . "',
						StreetsType = '" . $this->db->escape($line['StreetsType']) . "'");		
						
					}
				}
			}
		}
	}																						