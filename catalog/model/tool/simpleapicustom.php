<?php
	/*
		@author Dmitriy Kubarev
		@link   http://www.simpleopencart.com
	*/
		
		class ModelToolSimpleApiCustom extends Model {			
			private $leftShoreRegions = array('Дарницький','Деснянський','Дніпровський');

			public function example($filterFieldValue) {
				$values = array();
				
				$values[] = array(
					'id'   => 'my_id',
					'text' => 'my_text'
				);
				
				return $values;
			}

			private function isOpenNow($location){
				$open = '';
				$mcolor = 'red';
				$is_open_now = false;					
				if ($location['open_struct']){
					date_default_timezone_set('Europe/Kiev');

					$_r = trim($location['open_struct']);

					if ($_r == '∞'){
						$open = $this->language->get('text_open_alltime');
						$open_text = $this->language->get('text_open_alltime');
						$is_open_now = true;
					} else {
						$a = explode(PHP_EOL, $location['open_struct']);													
						$d = array();
						foreach ($a as $k => &$v){
							$v = trim($v);
							$c = explode('/', $v);
							$z = explode('-', $c[1]);
							$d[$c[0]] = array(
								's' => $z[0],
								'f' => $z[1]								
							);
						}

						$day = date('N');
						$nday = date('N', strtotime('+1 day'));

						if (!isset($d[$day])){
							$open .= $this->language->get('text_closed_today');
							$open_text .= $this->language->get('text_closed_today');
							$is_open_now = false;
						} else {

							$date_now = DateTime::createFromFormat('H:i', date('H:i'));
							$date_open = DateTime::createFromFormat('H:i', $d[$day]['s']);					
							$date_close = DateTime::createFromFormat('H:i', $d[$day]['f']);

							if ($date_now > $date_open && $date_now < $date_close){
								$is_open_now = true;
								$to_close_h = date_diff($date_now, $date_close)->format('%H');
								$to_close_m = date_diff($date_now, $date_close)->format('%i');
								$open_text = sprintf($this->language->get('text_opened_now'), $to_close_h, $to_close_m);
								$open = sprintf($this->language->get('text_opened_now'), $to_close_h, $to_close_m);
							}

							if ($date_now > $date_close || $date_now < $date_open){
								$is_open_now = false;
								$to_close = date_diff($date_now, $date_open)->format('%h');
								$open_text = $this->language->get('text_closed_now');
								$open = $this->language->get('text_closed_now');
							}
						}

					}									
				}

				return [ 'is_open_now' => $is_open_now, 'to_close_h' => $date_close->format('H:i')];
			}

			public function getIfStreetIsOnLeftSide($street){

				foreach ($this->leftShoreRegions as $leftShoreRegion){
					if (strpos($street['district'], $leftShoreRegion) !== false){
						return true;
					}
				}

				return false;
			}
			
			private function compareTime($time){
				return strtotime(date('Y-m-d')  .' '. $time) > time();
			}

			private function compareTimeLess($time){
				return strtotime(date('Y-m-d')  .' '. $time) < time();
			}
			
			public function checkCaptcha($value, $filter) {
				if (isset($this->session->data['captcha']) && $this->session->data['captcha'] != $value) {
					return false;
				}
				
				return true;
			}
			
			public function getKyivRiverSides(){
				
				$this->load->language('checkout/simplecheckout');
				
				$locations = $this->cart->getCurrentLocationsAvailableForPickup(true);								
				
				if (in_array(6, $locations)){
					$result[] = array(
						'id' => 1,
						'text' => $this->language->get('text_leftriverside')
					);	
				} else {
					$result[] = array(
						'id' => 3,
						'text' => $this->language->get('text_leftriverside_deferred')
					);
				}
				
				if (in_array(7, $locations)){
					$result[] = array(
						'id' => 2,
						'text' => $this->language->get('text_rightriverside')
					);		
				} else {
					$result[] = array(
						'id' => 4,
						'text' => $this->language->get('text_rightriverside_deferred')
					);	
				}
				
				return $result;
			}

			public function getIfExpressDeliveryIsAvailableByTime(){
				date_default_timezone_set('Europe/Kiev');

				if ($this->compareTime('19:00') && $this->compareTimeLess('09:00')){
					return true;
				}

				return false;
			}
			
			public function getDaysAvailableForDelivery($street = ''){
				date_default_timezone_set('Europe/Kiev');
				$this->load->language('checkout/simplecheckout');

				if ($this->compareTime('13:00')){
					$result[] = array(
						'id' => 7,
						'text' => $this->language->get('text_today')
					);		
				}
				
				$result[] = array(
					'id' => 8,
					'text' => $this->language->get('text_nextday')
				);	
				
				// $result[] = array(
				// 	'id' => 9,
				// 	'text' => $this->language->get('text_afternextday')
				// );	
				
				return $result;	
			}

			public function getTimesAvailableForDelivery($day){
				date_default_timezone_set('Europe/Kiev');
				$this->load->language('checkout/simplecheckout');
				$hour = date('G');
				$minute = date('i');

				if ((int)$day == 7){

					if ($this->compareTime('09:30')){
						$result[] = array(
							'id' => 2,
							'text' => $this->language->get('text_time_1')
						);	
					}

					if ($this->compareTime('13:30')){
						$result[] = array(
							'id' => 3,
							'text' => $this->language->get('text_time_2')
						);	
					}

					if ($this->compareTime('18:30')){
						$result[] = array(
							'id' => 4,
							'text' => $this->language->get('text_time_3')
						);	
					}


				} else {

					$result[] = array(
						'id' => 2,
						'text' => $this->language->get('text_time_1')
					);	

					$result[] = array(
						'id' => 3,
						'text' => $this->language->get('text_time_2')
					);	

					$result[] = array(
						'id' => 4,
						'text' => $this->language->get('text_time_3')
					);	

				}

				return $result;
			}

			public function getRiverSideAvailability(){
				$rightSide = $this->cart->getIfOneLocationIsCurrentlyAvailableForPickup(7);
				$leftSide =  $this->cart->getIfOneLocationIsCurrentlyAvailableForPickup(6);

				if ($rightSide && $leftSide){
					return 'both';
				}		

				if ($rightSide){
					return 'right';
				}

				if ($leftSide){
					return 'left';
				}
			}

			public function getKyivStreetsExpress($riverSideAvailability){
				$rightSide = $this->cart->getIfOneLocationIsCurrentlyAvailableForPickup(7);
				$leftSide =  $this->cart->getIfOneLocationIsCurrentlyAvailableForPickup(6);

				if ($rightSide && $leftSide){
					$riverSideAvailability = 'both';
				} elseif ($rightSide){
					$riverSideAvailability = 'right';
				} elseif ($leftSide){
					$riverSideAvailability = 'left';
				}


				if ($riverSideAvailability == 'right'){
					$sql = "SELECT * FROM kyiv_streets WHERE riverside = 'R'";
				} elseif ($riverSideAvailability == 'left'){
					$sql = "SELECT * FROM kyiv_streets WHERE riverside = 'L'";
				} else {
					$sql = "SELECT * FROM kyiv_streets WHERE 1";
				}

				$query = $this->db->query($sql);

				$values = [];
				foreach ($query->rows as $row){
					$name = $row['name'] . ', ' . $row['type'] . ' (' . $row['district'] . ')';

					$values[] = array(
						'id'   => $row['street_id'],
						'text' => $name
					);

				}

				return $values;
			}

			public function getKyivStreets($shipping_code){				
				$query = $this->db->query("SELECT * FROM kyiv_streets WHERE 1");

				$values = array();

				foreach ($query->rows as $row){
					$name = $row['name'] . ', ' . $row['type'] . ' (' . $row['district'] . ')';

					$values[] = array(
						'id'   => $row['street_id'],
						'text' => $name
					);
				}

				return $values;   
			}

			public function checkIfDrugstoreIsSelected($val){
				//var_dump($val);

				if (empty($val)){
					return false;
				}

				if ($val == 0){
					return false;
				}

				return true;

			}

			public function validateNovaPoshtaWareHouse($val){

				if ($val == 0){
					return false;
				}

				if ($val == $this->language->get('no_drugstores_one')){
					return false;
				}

				return true;
			}

			public function validateKyivStreet($val){

				if ($val == 0){
					return false;
				}

				if ($val == $this->language->get('please_select_street')){
					return false;
				}

				if ($val == $this->language->get('no_drugstores_one')){
					return false;
				}

				return true;
			}

			public function getCurrentLocationsAvailableForPickup(){
				$values = [];
				$this->load->model('localisation/location');
				
				$available_locations 		= $this->cart->getCurrentLocationsAvailableForPickup();
				$cart_has_narcotic_drugs 	= $this->cart->getIfCartHasNarcoticDrugs();
				$cart_has_preorder 			= $this->cart->getIfCartHasPreorder();

				if ($cart_has_narcotic_drugs){
					$all_locations 				= $this->model_localisation_location->getLocationsGood(['filter_can_sell_drugs' => true]);
				} else {
					$all_locations 				= $this->model_localisation_location->getLocationsGood();
				}				

				$stock_locations = $not_stock_locations = [];
				foreach ($all_locations as $location){
					if (in_array($location['location_id'], $available_locations)){
						$stock_locations[] = $location;
					} else {
						$not_stock_locations[] = $location;
					}
				}

				unset($location);
				foreach ($stock_locations as $location){
					$name = '<b class="drugstore-radio-head">';
					$name .= $location['name'];					
					$name .= '</b>';

				//	$name .= '<br /><small class="text-success"><b>' . $this->language->get('text_we_work_while_no_light') . '</b></small>';
					$name .= '<br />';

					$open_info = $this->isOpenNow($location);

					if ($open_info['is_open_now']){
						$name .= '<span class="text text-success "><i class="fa fa-check-circle" aria-hidden="true"></i> ';
						$name .= sprintf($this->language->get('products_available_now'), $open_info['to_close_h']); 
						$name .= '</span>';					
					} else {
						$name .= '<span class="text text-success "><i class="fa fa-check-circle" aria-hidden="true"></i> ' . $this->language->get('products_available_tomorrow') . '</span>';
					}

					$values[] = array(
						'id'   => $location['location_id'],
						'text' => $name,
					);
				}	

				unset($location);
				foreach ($not_stock_locations as $location){
					$name = '<b class="drugstore-radio-head grey">';

					$name .= $location['name'];
					$name .= '</b>';
					$name .= '<br /><small class="text-success"><b>' . $this->language->get('text_we_work_while_no_light') . '</b></small>';
					$name .= '<br />';

					if ($cart_has_preorder){
						$name .= '<span class="text text-warning "><i class="fa fa-clock-o" aria-hidden="true"></i> ' . sprintf($this->language->get('products_available_later'), date('d.m', strtotime('+4 days'))) . '</span>';	
					} else {
						$name .= '<span class="text text-warning "><i class="fa fa-clock-o" aria-hidden="true"></i> ' . sprintf($this->language->get('products_available_later'), date('d.m', strtotime('+2 days'))) . '</span>';
					}
									
					$values[] = array(
						'id'   => $location['location_id'],
						'text' => $name,
					);
				}						

				return $values;
			}

			public function getJustinWarehouses($CityName){
				$CityName = trim(mb_strtolower($CityName));

				$values = array();

				$query = $this->db->query("SELECT * FROM justin_warehouses WHERE LOWER(CityDescr) LIKE '" . $this->db->escape($CityName) . "' OR LOWER(CityDescrRU) LIKE '" . $this->db->escape($CityName) . "'");

				foreach ($query->rows as $row){

					$name = $row['DescrRU'];
					if ($this->config->get('config_language_id') == 3){
						$name = $row['Descr'];
					}

					$values[] = array(
						'id'   => $row['Uuid'],
						'text' => $name
					);
				}

				return $values;   
			}

			public function getUkrPoshtaWarehouses($CityName){
				$CityName = trim(mb_strtolower($CityName));

				$values = array();

				$query = $this->db->query("SELECT up.ADDRESS, uc.CITY_UA, uc.CITY_RU, up.POSTINDEX FROM oc_up_cities uc LEFT JOIN oc_up_postoffices up ON (uc.CITY_ID = up.CITY_ID) WHERE LOWER(CITY_RU) LIKE '" . $this->db->escape($CityName) . "' OR LOWER(CITY_UA) LIKE '" . $this->db->escape($CityName) . "' AND up.POSTINDEX <> '' AND up.ADDRESS <> '1'");

				foreach ($query->rows as $row){

					$name = $row['CITY_RU'];
					if ($this->config->get('config_language_id') == 3){
						$name = $row['CITY_UA'];
					}

					$name .= ( ', ' . $row['ADDRESS'] );

					$name .= (' (' . $row['POSTINDEX'] .  ')');

					$values[] = array(
						'id'   => $row['POSTINDEX'],
						'text' => $name
					);
				}

				return $values;   
			}

			public function getDefaultCityGuid($cityName){
				$cityName = trim($cityName);

				return '8d5a980d-391c-11dd-90d9-001a92567626';
			}

			public function getNovaPoshtaWarehouses($CityRef){
				$values = array();

				if (false && !$this->cart->getIfOneLocationIsCurrentlyAvailableForPickup(7)){

					$values[] = array(
						'id'   => 0,
						'text' => $this->language->get('no_drugstores_one')
					);

					return $values;

				}


				$query = $this->db->query("SELECT * FROM novaposhta_warehouses WHERE CityRef = '" . $this->db->escape($CityRef) . "' AND TypeOfWarehouse <> 'Поштомат'");

				foreach ($query->rows as $row){

					$name = $row['DescriptionRu'];
					if ($this->config->get('config_language_id') == 3){
						$name = $row['Description'];
					}

					$values[] = array(
						'id'   => $row['Ref'],
						'text' => $name
					);
				}

				return $values; 
			}

			public function getNovaPoshtaPostomats($CityRef){
				$values = array();

				$query = $this->db->query("SELECT * FROM novaposhta_warehouses WHERE CityRef = '" . $this->db->escape($CityRef) . "' AND TypeOfWarehouse = 'Поштомат'");

				foreach ($query->rows as $row){

					$name = $row['DescriptionRu'];
					if ($this->config->get('config_language_id') == 3){
						$name = $row['Description'];
					}

					$values[] = array(
						'id'   => $row['Ref'],
						'text' => $name
					);
				}

				return $values; 
			}

			public function getNovaPoshtaStreets($CityRef){
				$values = array();

				$query = $this->db->query("SELECT * FROM novaposhta_streets WHERE CityRef = '" . $this->db->escape($CityRef) . "'");

				if (!$query->num_rows){
					$this->load->library('hobotix/NovaPoshta');	
					$novaPoshta = new hobotix\NovaPoshta($this->registry);		
					$novaPoshta->getRealTimeStreets($CityRef);

					$query = $this->db->query("SELECT * FROM novaposhta_streets WHERE CityRef = '" . $this->db->escape($CityRef) . "'");
				}

				foreach ($query->rows as $row){
					$name = $row['Description'] . ', ' . $row['StreetsType'];

					$values[] = array(
						'id'   => $row['Ref'],
						'text' => $name
					);
				}

				return $values; 
			}

			public function cartHasDrugs(){
			}

			public function validateFourteenYears($value){

				if ($value == 1){
					return true;
				}

				if (empty($value) || !is_array($value) || $value[1] == 0){	
					return false;
				}

				return true;			
			}

			public function getYesNo($filter = '') {
				return array(
					array(
						'id'   => '1',
						'text' => $this->language->get('text_yes')
					),
					array(
						'id'   => '0',
						'text' => $this->language->get('text_no')
					)
				);
			}
		}													