<?php
	class ControllerHobotixHoboDB extends Controller {
	
		public function index(){
			if (!defined('OPENCART_CLI_MODE')){
				die('CLI ONLY');
			}
		}
	
		public function cron(){
		
			if (!defined('OPENCART_CLI_MODE')){
				die('CLI ONLY');
			}
			
			$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE (api_id > '0' OR customer_id = '0') AND date_added < DATE_SUB(NOW(), INTERVAL 30 DAY)");
			
			
			$this->db->query("INSERT INTO oc_stocks (product_id, product_uuid, location_id)
				SELECT p.product_id, p.uuid, l.location_id
				FROM oc_product p 
				CROSS JOIN oc_location l
				WHERE l.temprorary_closed = 0
				AND p.status = 1
				ON DUPLICATE KEY UPDATE 
				product_uuid = p.uuid");
						
		}
	}	