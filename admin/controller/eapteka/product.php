<?php
	class ControllerEaptekaProduct extends Controller {		
		public function index(){
		}
		
		public function validate($data, $params){
			
			foreach ($params as $param){
				if(!isset($data[$param])){
					header($_SERVER['SERVER_PROTOCOL'] . ' 500 Input Data Bug', true, 500);
					die("Error: not all params present $param");
				}
			}
			
			unset($param);
			
			$string = '';
			foreach ($params as $param){
				if ($param != 'key'){
					$string .= $data[$param];				
				}
			}
			
			$string .= EAPTEKA_API_ORDER_SALT;					
			
			if ($data['key'] != md5($string)){
				header($_SERVER['SERVER_PROTOCOL'] . ' 403 Validation Fail', true, 403);
				die('Error: validation error');
			}
			
			return true;
		}		
		
		
		public function getImages(){
			$this->load->model('tool/image');
			
			$data = file_get_contents('php://input');
			
			$constants = get_defined_constants(true);
			$json_errors = array();
			foreach ($constants["json"] as $name => $value) {
				if (!strncmp($name, "JSON_ERROR_", 11)) {
					$json_errors[$value] = $name;
				}
			}
			
			$data = trim($data);
			$bom = pack('H*','EFBBBF');
			$data = preg_replace('/[\x00-\x1F]/', '', $data);
			$data = preg_replace("/^$bom/", '', $data);
			
			if (!$data){				
				header($_SERVER['SERVER_PROTOCOL'] . ' 500 Input Data Bug', true, 500);
				die('Error: no data');
			}
			
			if ($json = json_decode($data, true)){				
				} else {
				header($_SERVER['SERVER_PROTOCOL'] . ' 500 Input Data Bug', true, 500);
				die ('Error: JSON decode error: ' . $json_errors[json_last_error()]);
			}
			
			if (!isset($json['mode'])){
				header($_SERVER['SERVER_PROTOCOL'] . ' 500 Input Data Bug, no mode param', true, 500);
				die ('Error: JSON decode error: ' . $json_errors[json_last_error()]);
			}
			
			if ($json['mode'] == 'getTotalProductsWithImages'){
				
				$params = array(
				'mode',
				'key'
				);
				
				if ($this->validate($json, $params)){
					$query = $this->db->query("SELECT COUNT(*) as total FROM oc_product WHERE LENGTH(image) > 4");	
					
					$responce = array(
					'total' => (int)$query->row['total']
					);
					
					die(json_encode($responce));
				}
				
			}
			
			if ($json['mode'] == 'getAllImages'){
				
				$params = array(
				'mode',
				'key',
				'original',
				'start',
				'limit',
				'width',
				'height'
				);
				
				if ($this->validate($json, $params)){
					
					$start = $json['start'];
					if ($json['start'] < 0){
						$start = 0;
					}
					
					$limit = $json['limit'];
					if ($json['limit'] < 0){
						$limit = 0;
					}	
					
					if ($json['limit'] > 100){
						$limit = 100;
					}
					
					//WIDTH
					$width = $json['width'];
					if ($json['width'] < 0){
						$width = 600;
					}	
					
					if ($json['width'] > 2048){
						$width = 2048;
					}
					
					//HEIGHT	
					$height = $json['height'];
					if ($json['height'] < 0){
						$height = 600;
					}	
					
					if ($json['height'] > 2048){
						$height = 2048;
					}
					
					if ($json['original']){
						$query = $this->db->query("SELECT product_id, uuid, image FROM oc_product WHERE LENGTH(image) > 4 LIMIT ". (int)$start .", " . (int)$limit . "");	
						
						$responce = array();
						foreach ($query->rows as &$row){
							
							$row['image'] = HTTPS_CATALOG . 'image/' . $row['image'];
							
							$responce[] = $row;							
						}
						
						die(json_encode($responce));
						
						} else {
						$query = $this->db->query("SELECT product_id, uuid, image FROM oc_product WHERE LENGTH(image) > 4 LIMIT ". (int)$start .", " . (int)$limit . "");
						
						$responce = array();
						foreach ($query->rows as &$row){
							
							$row['image'] = $this->model_tool_image->resize($row['image'], (int)$width, (int)$height);
							
							$responce[] = $row;							
						}
						
						die(json_encode($responce));
						
					}					
					
				}
				
			}
			
			if ($json['mode'] == 'getImageByUUID'){
				
				$params = array(
				'mode',
				'key',
				'uuid',
				'original',
				'width',
				'height'
				);
				
				
				if ($this->validate($json, $params)){
					//WIDTH
					$width = $json['width'];
					if ($json['width'] < 0){
						$width = 600;
					}	
					
					if ($json['width'] > 2048){
						$width = 2048;
					}
					
					//HEIGHT	
					$height = $json['height'];
					if ($json['height'] < 0){
						$height = 600;
					}	
					
					if ($json['height'] > 2048){
						$height = 2048;
					}
					
					if ($json['original']){
						$query = $this->db->query("SELECT product_id, uuid, image FROM oc_product WHERE uuid = '" . $this->db->escape($json['uuid']) . "' LIMIT 1");
						
						if (!$query->num_rows){
							header($_SERVER['SERVER_PROTOCOL'] . ' 404 UUID not found', true, 404);
							die ('Error: UUID ' . $this->db->escape($json['uuid']) . ' not found in database');
						}
						
						$responce = array();
						foreach ($query->rows as &$row){
							
							$row['image'] = HTTPS_CATALOG . 'image/' . $row['image'];
							
							$responce[] = $row;							
						}
						
						die(json_encode($responce));
						
					} else {
						
						$query = $this->db->query("SELECT product_id, uuid, image FROM oc_product WHERE uuid = '" . $this->db->escape($json['uuid']) . "' LIMIT 1");
						
						if (!$query->num_rows){
							header($_SERVER['SERVER_PROTOCOL'] . ' 404 UUID not found', true, 404);
							die ('Error: UUID ' . $this->db->escape($json['uuid']) . ' not found in database');
						}
						
						$responce = array();
						foreach ($query->rows as &$row){
							
							$row['image'] = $this->model_tool_image->resize($row['image'], (int)$width, (int)$height);
							
							$responce[] = $row;							
						}
						
						die(json_encode($responce));
						
						
						
					}
					
				}
				
				
			}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		}
	}				