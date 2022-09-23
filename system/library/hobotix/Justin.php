<?php
	
	
	
	class Justin {
		private $db;
		private $config;
		private $registry;
		private $client;
		private $descriptionField = 'Descr';
		
		private $apiLogin = 'Vest';
		private $apiKey = 'hzOP1EhB';
		
		private $countryMapping = array(
		'RU' => 176,
		'KZ' => 109,
		'BY' => 20,
		);
		
		
		public function __construct($registry, $langCode = 'RU') {			
			$this->registry = $registry;
			$this->config = $this->registry->get('config');
			$this->db = $this->registry->get('db');
			
			$this->client = new \Justin\Justin($langCode, true);
			$this->client->setLogin($this->apiLogin)->setPassword($this->apiKey);
			
			if ($langCode == 'UA'){
				$this->descriptionField = 'Descr';
			}
			
			if ($langCode == 'RU'){
				$this->descriptionField = 'DescrRu';
			}
		}		
		
		
		public function updateZones(){
			
			$response = $this->client->listRegions()->getData();
			
			
			foreach ($response as $region){
				$region = $region['fields'];
				
				echoLine('[JS] Регион ' . $region['descr']);
				
				$this->db->query("INSERT INTO justin_zones SET 
				Uuid = '" . $this->db->escape($region['uuid']) . "',
				Code = '" . $this->db->escape($region['code']) . "',
				`" . $this->descriptionField . "` = '" . $this->db->escape($region['descr']) . "',
				SCOATOU = '" . $this->db->escape($region['SCOATOU']) . "'
				ON DUPLICATE KEY UPDATE
				Code = '" . $this->db->escape($region['code']) . "',
				`" . $this->descriptionField . "` = '" . $this->db->escape($region['descr']) . "',
				SCOATOU = '" . $this->db->escape($region['SCOATOU']) . "'");
				
			}
			
			return $this;
			
		}
		
		
		public function updateZonesRegions(){
			
			$response = $this->client->listAreasRegion()->getData();
			
			
			foreach ($response as $area){
				$area = $area['fields'];
				
				echoLine('[JS] Зона ' . $area['descr']);
				
				$this->db->query("INSERT INTO justin_zone_regions SET 
				Uuid = '" . $this->db->escape($area['uuid']) . "',
				Code = '" . $this->db->escape($area['code']) . "',
				`" . $this->descriptionField . "` = '" . $this->db->escape($area['descr']) . "',
				ZoneUuid = '" . $this->db->escape($area['objectOwner']['uuid']) . "',
				`Zone" . $this->descriptionField . "` = '" . $this->db->escape($area['objectOwner']['descr']) . "'
				ON DUPLICATE KEY UPDATE
				Code = '" . $this->db->escape($area['code']) . "',
				`" . $this->descriptionField . "` = '" . $this->db->escape($area['descr']) . "',
				ZoneUuid = '" . $this->db->escape($area['objectOwner']['uuid']) . "',
				`Zone" . $this->descriptionField . "` = '" . $this->db->escape($area['objectOwner']['descr']) . "'");
				
			}
			
			return $this;
			
		}
		
		public function updateCities(){
			
			$response = $this->client->listCities()->getData();
			
			
			foreach ($response as $city){
				$city = $city['fields'];
				
				echoLine('[JS] Город ' . $city['descr']);
				
				$this->db->query("INSERT INTO justin_cities SET 
				Uuid = '" . $this->db->escape($city['uuid']) . "',
				Code = '" . $this->db->escape($city['code']) . "',
				`" . $this->descriptionField . "` = '" . $this->db->escape($city['descr']) . "',
				RegionUuid = '" . $this->db->escape($city['objectOwner']['uuid']) . "',
				`Region" . $this->descriptionField . "` = '" . $this->db->escape($city['objectOwner']['descr']) . "',
				SCOATOU = '" . $this->db->escape($city['SCOATOU']) . "'
				ON DUPLICATE KEY UPDATE
				Code = '" . $this->db->escape($city['code']) . "',
				`" . $this->descriptionField . "` = '" . $this->db->escape($city['descr']) . "',
				RegionUuid = '" . $this->db->escape($city['objectOwner']['uuid']) . "',
				`Region" . $this->descriptionField . "` = '" . $this->db->escape($city['objectOwner']['descr']) . "',
				SCOATOU = '" . $this->db->escape($city['SCOATOU']) . "'");
				
			}
			
			return $this;
			
		}
		
		public function updateCitiesRegions(){
			
			$response = $this->client->listCityRegion()->getData();
			foreach ($response as $region){
				$region = $region['fields'];
				
				echoLine('[JS] Район ' . $region['descr']);
				
				$this->db->query("INSERT INTO justin_city_regions SET 
				Uuid = '" . $this->db->escape($region['uuid']) . "',
				Code = '" . $this->db->escape($region['code']) . "',
				`" . $this->descriptionField . "` = '" . $this->db->escape($region['descr']) . "',
				CityUuid = '" . $this->db->escape($region['objectOwner']['uuid']) . "',
				`City" . $this->descriptionField . "` = '" . $this->db->escape($region['objectOwner']['descr']) . "'				
				ON DUPLICATE KEY UPDATE
				Code = '" . $this->db->escape($region['code']) . "',
				`" . $this->descriptionField . "` = '" . $this->db->escape($region['descr']) . "',
				CityUuid = '" . $this->db->escape($region['objectOwner']['uuid']) . "',
				`City" . $this->descriptionField . "` = '" . $this->db->escape($region['objectOwner']['descr']) . "'");
				
			}
			
			return $this;
		}
		
		public function updateStreets(){
			
			$query = $this->db->query("SELECT * FROM justin_cities WHERE 1");
			
			foreach ($query->rows as $city){
				
				echoLine('[JS] Город ' . $city['Descr']);
				
				$filter_data = [
				'name'			=> 'objectOwner', 
				'comparison' 	=> 'equal',
				'leftValue'  	=> $city['Uuid']			
				];
				
				
				$response = $this->client->listStreetsCity($filter_data)->getData();
				
				if (isset($response['totalCountRecords']) && $response['totalCountRecords'] == 0){
					continue;
				}
				
				foreach ($response as $street){			
					$street = $street['fields'];
					echoLine('[JS] Улица ' . $street['descr']);
					
					$this->db->query("INSERT INTO justin_streets SET 
					Uuid = '" . $this->db->escape($street['uuid']) . "',
					Code = '" . $this->db->escape($street['code']) . "',
					`" . $this->descriptionField . "` = '" . $this->db->escape($street['descr']) . "',
					CityUuid = '" . $this->db->escape($street['objectOwner']['uuid']) . "',
					`City" . $this->descriptionField . "` = '" . $this->db->escape($street['objectOwner']['descr']) . "'				
					ON DUPLICATE KEY UPDATE
					Code = '" . $this->db->escape($street['code']) . "',
					`" . $this->descriptionField . "` = '" . $this->db->escape($street['descr']) . "',
					CityUuid = '" . $this->db->escape($street['objectOwner']['uuid']) . "',
					`City" . $this->descriptionField . "` = '" . $this->db->escape($street['objectOwner']['descr']) . "'");
					
				}
			}
			
			return $this;
		}
		
		
		public function updateWarehouses(){
			
			$response = $this->client->listDepartmentsLang()->getData();
			
			foreach ($response as $warehouse){
			
				$shedule = $warehouse['Schedule'];				
				$warehouse = $warehouse['fields'];
				
				echoLine('[JS] Отделение ' . $warehouse['descr']);
				
				$sql = "INSERT INTO justin_warehouses SET 
				Uuid = '" . $this->db->escape($warehouse['Depart']['uuid']) . "',
				Code = '" . $this->db->escape($warehouse['code']) . "',
				Address = '" . $this->db->escape($warehouse['address']) . "',
				Lat = '" . $this->db->escape($warehouse['lat']) . "',
				Lng = '" . $this->db->escape($warehouse['lng']) . "',
				departNumber = '" . $this->db->escape($warehouse['departNumber']) . "',
				Monday = '" . $this->db->escape($shedule['Monday']) . "',
				Tuesday = '" . $this->db->escape($shedule['Tuesday']) . "',
				Wednesday = '" . $this->db->escape($shedule['Wednesday']) . "',
				Thursday = '" . $this->db->escape($shedule['Thursday']) . "',
				Friday = '" . $this->db->escape($shedule['Friday']) . "',
				Saturday = '" . $this->db->escape($shedule['Saturday']) . "',
				Sunday = '" . $this->db->escape($shedule['Sunday']) . "',
				`" . $this->descriptionField . "` = '" . $this->db->escape($warehouse['descr']) . "',
				CityUuid = '" . $this->db->escape($warehouse['city']['uuid']) . "',
				`City" . $this->descriptionField . "` = '" . $this->db->escape($warehouse['city']['descr']) . "',
				`City" . $this->descriptionField . "` = '" . $this->db->escape($warehouse['city']['descr']) . "',
				StatusDepart = '" . (int)$warehouse['StatusDepart'] . "'				
				ON DUPLICATE KEY UPDATE
				Code = '" . $this->db->escape($warehouse['code']) . "',
				Address = '" . $this->db->escape($warehouse['address']) . "',
				Lat = '" . $this->db->escape($warehouse['lat']) . "',
				Lng = '" . $this->db->escape($warehouse['lng']) . "',
				departNumber = '" . $this->db->escape($warehouse['departNumber']) . "',
				Monday = '" . $this->db->escape($shedule['Monday']) . "',
				Tuesday = '" . $this->db->escape($shedule['Tuesday']) . "',
				Wednesday = '" . $this->db->escape($shedule['Wednesday']) . "',
				Thursday = '" . $this->db->escape($shedule['Thursday']) . "',
				Friday = '" . $this->db->escape($shedule['Friday']) . "',
				Saturday = '" . $this->db->escape($shedule['Saturday']) . "',
				Sunday = '" . $this->db->escape($shedule['Sunday']) . "',
				`" . $this->descriptionField . "` = '" . $this->db->escape($warehouse['descr']) . "',
				CityUuid = '" . $this->db->escape($warehouse['city']['uuid']) . "',
				`City" . $this->descriptionField . "` = '" . $this->db->escape($warehouse['city']['descr']) . "',
				StatusDepart = '" . (int)$warehouse['StatusDepart'] . "'";
				
				$this->db->query($sql);
				
			}
			
			$this->db->query("UPDATE  justin_cities SET WarehouseCount = (SELECT COUNT(justin_warehouses.warehouse_id) FROM justin_warehouses WHERE justin_warehouses.CityUuid = justin_cities.Uuid)");
			
			return $this;
		}
		
	}				