<?php
	class ControllerEaptekaReferences extends Controller
	{
		
		
		public function cron(){
			$this->load->library('hobotix/NovaPoshta');
			$this->load->library('hobotix/UkrPoshta');
			ini_set('memory_limit', '2G');

			$novaPoshta = new hobotix\NovaPoshta($this->registry);		
			$novaPoshta->updateZones()->updateCities()->updateCitiesWW()->updateWareHouses()->updateStreets();

			$UkrPoshta = new hobotix\UkrPoshta($this->registry);		
			$UkrPoshta->updateAll();
		
						
			// $justin = new Justin($this->registry, 'RU');
			// $justin->updateZones()->updateZonesRegions()->updateCities()->updateCitiesRegions()->updateStreets()->updateWarehouses();
			
			// $justin = new Justin($this->registry, 'UA');
			// $justin->updateZones()->updateZonesRegions()->updateCities()->updateCitiesRegions()->updateStreets()->updateWarehouses();
			
			
		}		
	}