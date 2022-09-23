<?php
	
	class ControllerEaptekaCheckout extends Controller {
		
		public function index(){
			
		}
		
		
		public function getDefaultCities($limit = 24){
			$results = array('results' => array());
			
			
			$query = $this->db->query("SELECT nc.* FROM novaposhta_cities_ww nc ORDER BY WarehouseCount DESC LIMIT $limit");
			
			if ($query->num_rows){
				
				foreach ($query->rows as $row){
					
					$name = $row['DescriptionRu'];
					if ($this->config->get('config_language_id') == 3){
						$name = $row['Description'];
					}
					
					
					$results['results'][] = array(
					'id' => $row['Ref'],
					'text' => $name						
					);						
				}
				
			}
			
			return $results;	
		}
		
		
		public function guessCitiesIDWhenNOTSET(){
			
			$query = !empty($this->request->get['query'])?$this->request->get['query']:'';
			$query = trim(mb_strtolower($query));
			$result = array('city' => '');
			
			//Украина - справочник городов Новой Почты
			
			$query = $this->db->query("SELECT nc.* FROM novaposhta_cities_ww nc WHERE LOWER(nc.Description) LIKE '" . $this->db->escape($query) . "' OR LOWER(nc.DescriptionRu) LIKE '" . $this->db->escape($query) . "' LIMIT 1");
			
			if ($query->num_rows){
				$result = array(
				'city' => $query->row['Ref']
				);
			}		
			
			$this->response->setOutput(json_encode($result));
		}
		
		public function suggestPostCode(){
			$query = !empty($this->request->get['query'])?$this->request->get['query']:'';
			$query = trim($query);
			$result = array();
			
			if (!$query){
				$this->response->setOutput(json_encode($result));
				} else {
				
				$dbQuery = $this->db->query("SELECT nc.* FROM novaposhta_cities nc WHERE Ref = '" . $this->db->escape($query) . "' LIMIT 1");
				
				if ($dbQuery->num_rows){
					$row = $dbQuery->row;
					
					$name = $row['Index1'] . ', ' . $row['AreaDescriptionRu'] . ', ' . $row['SettlementTypeDescriptionRu'] .' '. $row['DescriptionRu'];
					if ($this->config->get('config_language_id') == 3){
						$name = $row['Index1'] . ', ' . $row['AreaDescription'] . ', ' . $row['SettlementTypeDescription'] .' '. $row['Description'];
					}
					
					$result = array(
					'postcode' 		=> $row['Index1'],
					'fulladdress'	=> $name,
					);
					
				}
			}
			
			$this->response->setOutput(json_encode($result));
		}
		
		public function suggestCities(){
			$query = !empty($this->request->get['query'])?$this->request->get['query']:'';
			$json = !empty($this->request->get['json'])?true:false;
			$limit = !empty($this->request->get['limit'])?(int)$this->request->get['limit']:20;
			$query = trim(mb_strtolower($query));
			$results = array('results' => array());
			
			if ($limit < 0){
				$limit = 10;
			}
			
			if ($limit >= 20){
				$limit = 20;
			}
			
			if (mb_strlen($query) < 2){
				$results = $this->getDefaultCities();
				$this->response->setOutput(json_encode($results, true));
				} else {
				
				
				//Украина - справочник городов Новой Почты
				$dbQuery = $this->db->query("SELECT nc.Ref, nc.DescriptionRu, nc.Description FROM novaposhta_cities_ww nc WHERE LOWER(nc.Description) LIKE '" . $this->db->escape($query) . "%' OR LOWER(nc.DescriptionRu) LIKE '" . $this->db->escape($query) . "%' ORDER BY WarehouseCount DESC LIMIT $limit");
				
				if ($dbQuery->num_rows){
					
					foreach ($dbQuery->rows as $row){
						
						$name = $row['DescriptionRu'];
						if ($this->config->get('config_language_id') == 3){
							$name = $row['Description'];
						}
						
						
						$results['results'][] = array(
						'id' => $row['Ref'],
						'text' => $name,
						'text_short' => $name
						);						
					}
					
					} else {
					//Фоллбек на полную базу городов, отправка УкрПочтой
					
					$dbQuery = $this->db->query("SELECT nc.Ref, nc.DescriptionRu, nc.AreaDescriptionRu, nc.Description, nc.AreaDescription FROM novaposhta_cities nc WHERE LOWER(nc.Description) LIKE '" . $this->db->escape($query) . "%' OR LOWER(nc.DescriptionRu) LIKE '" . $this->db->escape($query) . "%' LIMIT $limit");
					
					if ($dbQuery->num_rows){
						
						foreach ($dbQuery->rows as $row){
							
							$name = $row['DescriptionRu'] . ' (' . $row['AreaDescriptionRu'] . ')';
							if ($this->config->get('config_language_id') == 3){
								$name = $row['Description'] . ' (' . $row['AreaDescription'] . ')';
							}
							
							
							$results['results'][] = array(
							'id' => $row['Ref'],
							'text' => $name,
							'text_short' => $name
							);						
						}
						
					}
					
				}
				
				if (!$results['results']){
					$results['results'][] = array(                   
					'id'                 => false,
					'text' 				 => 'Ничего не найдено',
					'text_short'         => 'Ничего не найдено',
					);
				}
				
				if ($json){
					$results = $results['results'];
				}
				
				$this->response->setOutput(json_encode($results));
			}
			
		}
		
	
		public function getCurrentCity(){
			$this->load->model('tool/simpleapicustom');
			$json = array();
			
			$query = !empty($this->request->get['city'])?$this->request->get['city']:'';
			
			if ($city = $this->model_tool_simpleapicustom->getCityIdByName($query)){
				if ($city['id']){
					
					$json = array(
					'city' 		=> $city['city'],
					'id'   		=> $city['id'],
					'guessed' 	=> true,						
					'found'		=> true,
					);
					
					} else {
					
					$this->load->model('localisation/country');
					if ($result['countryCode'] && $result['countryCode'] == $this->model_localisation_country->getCountryISO2($this->config->get('config_country_id'))){								
						$json = array(
						'city' 		=> $city['city'],
						'id'   		=> $city['id'],
						'guessed' 	=> true,						
						'found'		=> false,
						);
					}
					
				}
			}
			
			$this->session->data['customer_location_city'] = $json;
			
			$this->response->setOutput(json_encode($json));
		}
		
		public function suggestCurrentCity(){
			$this->load->model('tool/simpleapicustom');	
			$this->load->library('ipApi');
			
			$json = array(
			'city' 		=> $this->config->get('config_default_city'),
			'id'   		=> $this->model_tool_simpleapicustom->getDefaultCityGuid($this->config->get('config_default_city')),
			'guessed' 	=> false,
			'found'		=> false,
			);
			
			$ipApi = new ipApi;
			$ipResult = $ipApi->search($this->request->server['REMOTE_ADDR']);
			
			if ($result = json_decode($ipResult, true)){
				if (!empty($result['status']) && $result['status'] == 'success' && !empty($result['city'])){													
					if ($city = $this->model_tool_simpleapicustom->getCityIdByName($result['city'])){
						
						if ($city['id']){
							
							$json = array(
							'city' 		=> $city['city'],
							'id'   		=> $city['id'],
							'guessed' 	=> true,						
							'found'		=> true,
							);
							
							} else {
							
							$this->load->model('localisation/country');
							if ($result['countryCode'] && $result['countryCode'] == $this->model_localisation_country->getCountryISO2($this->config->get('config_country_id'))){								
								$json = array(
								'city' 		=> $city['city'],
								'id'   		=> $city['id'],
								'guessed' 	=> true,						
								'found'		=> false,
								);
							}
							
						}
					}
				}
			}
			
			
			$this->model_tool_simpleapicustom->setCustomerCityToSession($json['city'], $json['id']);	
			
			$this->response->setOutput(json_encode($json));
		}
		
		
	}																														