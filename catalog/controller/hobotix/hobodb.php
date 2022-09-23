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
			
			
			
			
			
		}
	}	