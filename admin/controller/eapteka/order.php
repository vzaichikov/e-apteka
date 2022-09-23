<?php
	class ControllerEaptekaOrder extends Controller {		
		
		public function index(){
		}
		
		public function validate($data){
			
			$params = array(
				'order_id',
				'order_status_id',
				'key'
			);
			
			foreach ($params as $param){
				if(!isset($data[$param])){
					header($_SERVER['SERVER_PROTOCOL'] . ' 500 Input Data Bug', true, 500);
					die("Error: not all params present $param");
				}
			}
		
			$string = $data['order_id']	. $data['order_status_id'] . EAPTEKA_API_ORDER_SALT;
			
			if ($data['key'] != md5($string)){
				header($_SERVER['SERVER_PROTOCOL'] . ' 403 Validation Fail', true, 403);
				die('Error: validation error');
			}
			
			return true;
			
		}

		
		public function updateStatus(){
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
			
			if ($this->validate($json)){
				//validate order_id
				$this->load->model('sale/order');
				$order = $this->model_sale_order->getOrder($json['order_id']);
				
				if (!$order){
					header($_SERVER['SERVER_PROTOCOL'] . ' 500 Order Not Exist', true, 500);
					die ('Error: order does not exist in database');
				}
				
				//validate order_status_id
				$this->load->model('localisation/order_status');
				$order_status = $this->model_localisation_order_status->getOrderStatus($json['order_status_id']);
				
				if (!$order_status){
					header($_SERVER['SERVER_PROTOCOL'] . ' 500 Order Status Not Exist', true, 500);
					die ('Error: order status does not exist in database');
				}
				
				//validate current status
				if ($order['order_status_id'] == $json['order_status_id']){
					header($_SERVER['SERVER_PROTOCOL'] . ' 500 Order Status Equal', true, 500);
					die ('Error: order is in this status');
				}
				
				$comment = 'Установлено из 1С ' . date('Y.m.d H:i:s');
				
				//all ok
				$this->db->query("UPDATE `oc_order` SET order_status_id = '" . (int)$json['order_status_id'] . "' WHERE order_id = '" . (int)$json['order_id'] . "'");
				$this->db->query("INSERT INTO oc_order_history SET order_id = '" . (int)$json['order_id'] . "', order_status_id = '" . (int)$json['order_status_id'] . "', notify = '" . (int)false . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");
				
				die($json['order_id']);
			}
			
			
			
			
		}
		
		
	}
