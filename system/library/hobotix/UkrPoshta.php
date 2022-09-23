<?php
	
	namespace hobotix;
	use Exception;
	
	class UkrPoshta {


		private $db;
		private $config;
		private $registry;
		
		public function __construct($registry) {			
			$this->registry = $registry;
			$this->config = $this->registry->get('config');
			$this->db = $this->registry->get('db');
		}
		

		public function updateAll(){
			$config = new \Ukrposhta\Data\Configuration();
			$config->setBearer('c9bf7734-3599-3548-9038-8c4d1e8bec96'); 
			$config->setToken('8d63722c-97a5-41fa-a5f7-8e9354a63590');
						
			$regionsObject = new \Ukrposhta\Directory\Region($config);
			$regions = $regionsObject->getList();
			
			foreach ($regions['Entry'] as $region){

				echoLine($region['REGION_UA']);
				
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE name LIKE '%".$region['REGION_UA']." область%'");
				if($query->row){
					$this->db->query("UPDATE `" . DB_PREFIX . "zone` SET up_ref='" . $region['REGION_ID'] . "' WHERE zone_id='".$query->row['zone_id']."'");
				}
				
			}
			
			
			
			$districtsObject = new \Ukrposhta\Directory\District($config);
			$districts = $districtsObject->getList();
			
			foreach ($districts['Entry'] as $district){
				$query = $this->db->query("INSERT INTO oc_up_districts SET 
				DISTRICT_ID = '" . (int)$district['DISTRICT_ID'] . "',
				REGION_ID = '" . (int)$district['REGION_ID'] . "',
				DISTRICT_UA = '" . $this->db->escape($district['DISTRICT_UA']) . "',
				DISTRICT_RU = '" . $this->db->escape(($district['DISTRICT_RU']?$district['DISTRICT_RU']:$district['DISTRICT_UA'])) . "'
				ON DUPLICATE KEY UPDATE
				REGION_ID = '" . (int)$district['REGION_ID'] . "',
				DISTRICT_UA = '" . $this->db->escape($district['DISTRICT_UA']) . "',
				DISTRICT_RU = '" . $this->db->escape(($district['DISTRICT_RU']?$district['DISTRICT_RU']:$district['DISTRICT_UA'])) . "'");
				
				echoLine($district['DISTRICT_UA'] . ' -> ' . $district['DISTRICT_ID']);
			}
			
			unset($district);
			
			$paramsObject = new \Ukrposhta\Data\Storage();
			$citiesObject = new \Ukrposhta\Directory\City($config);
			foreach ($districts['Entry'] as $district){
				
				$paramsObject->district_id = $district['DISTRICT_ID'];				
				$cities = $citiesObject->getList($paramsObject);	
				
				if (!empty($cities['Entry']['REGION_ID'])){
					$cities['Entry'] = array($cities['Entry']);
				}
				
				
				foreach ($cities['Entry'] as $city){
					
					$query = $this->db->query("INSERT INTO oc_up_cities SET 
					CITY_ID 	= '" . (int)$city['CITY_ID'] . "',
					DISTRICT_ID = '" . (int)$city['DISTRICT_ID'] . "',
					REGION_ID 	= '" . (int)$city['REGION_ID'] . "',					
					CITYTYPE_UA = '" . $this->db->escape($city['CITYTYPE_UA']) . "',
					CITYTYPE_RU = '" . $this->db->escape(($city['CITYTYPE_RU']?$city['CITYTYPE_RU']:$city['CITYTYPE_UA'])) . "',
					CITY_UA = '" . $this->db->escape($city['CITY_UA']) . "',
					CITY_RU = '" . $this->db->escape(($city['CITY_RU']?$city['CITY_RU']:$city['CITY_UA'])) . "',					
					POPULATION 	= '" . (int)$city['POPULATION'] . "',
					LONGITUDE 	= '" . $this->db->escape($city['LONGITUDE']) . "',
					LATTITUDE 	= '" . $this->db->escape($city['LATTITUDE']) . "'
					ON DUPLICATE KEY UPDATE
					DISTRICT_ID = '" . (int)$city['DISTRICT_ID'] . "',
					REGION_ID 	= '" . (int)$city['REGION_ID'] . "',
					CITYTYPE_UA = '" . $this->db->escape($city['CITYTYPE_UA']) . "',
					CITYTYPE_RU = '" . $this->db->escape(($city['CITYTYPE_RU']?$city['CITYTYPE_RU']:$city['CITYTYPE_UA'])) . "',
					CITY_UA = '" . $this->db->escape($city['CITY_UA']) . "',
					CITY_RU = '" . $this->db->escape(($city['CITY_RU']?$city['CITY_RU']:$city['CITY_UA'])) . "',
					
					POPULATION 	= '" . (int)$city['POPULATION'] . "',
					LONGITUDE 	= '" . $this->db->escape($city['LONGITUDE']) . "',
					LATTITUDE 	= '" . $this->db->escape($city['LATTITUDE']) . "'");
					
					echoLine($city['DISTRICT_UA'] . ' -> ' . $city['CITY_UA']);	
					
					
					//КИЕВ ПЕРЕМЕСТИТЬ В КИЕВСКУЮ ОБЛАСТЬ
					$this->db->query("UPDATE oc_up_cities SET REGION_ID = 11 WHERE REGION_ID = 10");
					
					
					$districtParamsObject = new \Ukrposhta\Data\Storage();
					$postOfficeObject = new \Ukrposhta\Directory\Postoffice($config);
					$postoffices = $postOfficeObject->getByCityId($city['CITY_ID']);
					
					if (!empty($postoffices['Entry']['REGION_ID'])){
						$postoffices['Entry'] = array($postoffices['Entry']);
					}
					
					foreach ($postoffices['Entry'] as $postoffice){
						$query = $this->db->query("INSERT INTO oc_up_postoffices SET 
						ID 				= '" . (int)$postoffice['ID'] . "',
						CITY_ID 		= '" . (int)$postoffice['CITY_ID'] . "',
						DISTRICT_ID 	= '" . (int)$postoffice['DISTRICT_ID'] . "',		
						REGION_ID 		= '" . (int)$postoffice['REGION_ID'] . "',
						PARENT_ID 		= '" . (int)$postoffice['PARENT_ID'] . "',
						TYPE_LONG 		= '" . $this->db->escape($postoffice['TYPE_LONG']) . "',
						TYPE_ACRONYM 	= '" . $this->db->escape($postoffice['TYPE_ACRONYM']) . "',
						MEREZA_NUMBER 	= '" . $this->db->escape($postoffice['MEREZA_NUMBER']) . "',
						ADDRESS 		= '" . $this->db->escape($postoffice['ADDRESS']) . "',
						STREET_UA 		= '" . $this->db->escape($postoffice['STREET_UA']) . "',
						STREETTYPE_UA 	= '" . $this->db->escape($postoffice['STREETTYPE_UA']) . "',					
						HOUSENUMBER 	= '" . $this->db->escape($postoffice['HOUSENUMBER']) . "',	
						POSTINDEX 		= '" . $this->db->escape($postoffice['POSTINDEX']) . "',
						PO_SHORT 		= '" . $this->db->escape($postoffice['PO_SHORT']) . "',
						LONGITUDE 		= '" . $this->db->escape($postoffice['LONGITUDE']) . "',
						LATTITUDE 		= '" . $this->db->escape($postoffice['LATTITUDE']) . "'
						ON DUPLICATE KEY UPDATE
						CITY_ID 		= '" . (int)$postoffice['CITY_ID'] . "',
						DISTRICT_ID 	= '" . (int)$postoffice['DISTRICT_ID'] . "',		
						REGION_ID 		= '" . (int)$postoffice['REGION_ID'] . "',
						PARENT_ID 		= '" . (int)$postoffice['PARENT_ID'] . "',
						TYPE_LONG 		= '" . $this->db->escape($postoffice['TYPE_LONG']) . "',
						TYPE_ACRONYM 	= '" . $this->db->escape($postoffice['TYPE_ACRONYM']) . "',
						MEREZA_NUMBER 	= '" . $this->db->escape($postoffice['MEREZA_NUMBER']) . "',
						ADDRESS 		= '" . $this->db->escape($postoffice['ADDRESS']) . "',
						STREET_UA 		= '" . $this->db->escape($postoffice['STREET_UA']) . "',
						STREETTYPE_UA 	= '" . $this->db->escape($postoffice['STREETTYPE_UA']) . "',					
						HOUSENUMBER 	= '" . $this->db->escape($postoffice['HOUSENUMBER']) . "',	
						POSTINDEX 		= '" . $this->db->escape($postoffice['POSTINDEX']) . "',
						PO_SHORT 		= '" . $this->db->escape($postoffice['PO_SHORT']) . "',
						LONGITUDE 		= '" . $this->db->escape($postoffice['LONGITUDE']) . "',
						LATTITUDE 		= '" . $this->db->escape($postoffice['LATTITUDE']) . "'");
						
						echoLine($city['CITY_UA'] . ' -> ' . $postoffice['ADDRESS']);	
					}
				}			
			}	
			
			
			$this->db->query("UPDATE oc_up_cities SET HAS_POSTOFFICES = 0");
			$this->db->query("UPDATE oc_up_cities SET HAS_POSTOFFICES = 1 WHERE CITY_ID IN (SELECT DISTINCT CITY_ID FROM oc_up_postoffices)");
		}













	}