<?php
	class ControllerStartupPreauth extends Controller {
	
	public function index(){
		if (!$this->customer->isLogged()){			
			if (isset($this->request->cookie[AUTH_TOKEN_COOKIE])){
				
				$query = $this->db->query("SELECT customer_id FROM " . DB_PREFIX . "customer WHERE retoken = '" . $this->db->escape($this->request->cookie[AUTH_TOKEN_COOKIE]) . "' LIMIT 1");
			
				if (!$query->num_rows){
					$query = $this->db->query("SELECT customer_id FROM " . DB_PREFIX . "customer WHERE MD5(CONCAT(customer_id, '" . $this->config->get('config_encryption') . "')) LIKE '" . $this->db->escape($this->request->cookie[AUTH_TOKEN_COOKIE]) . "' LIMIT 1");
				}
				
				if ($query->rows && $query->row['customer_id']){
					$this->customer->login($email = '', $password = '', $override = true, $customer_id_explicit = (int)$query->row['customer_id']);
				}
			}						
		}
	}
	}