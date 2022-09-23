<?php
	
	
	class ControllerEaptekaPWA extends Controller {
		
		
		public function index(){
		}			
		
		public function sps(){
			
			if (!empty($this->request->get['pwaSessionKey'])){
				if ($this->validateKey($this->request->get['pwaSessionKey'], 'pwasession')){
					
					if (!$this->customer->getPWASession()){
						$this->customer->setPWASession();
						$this->updateCounter('pwasession');
					}
					
					$this->response->setOutput('ok');
					
					} else {
					$this->response->setOutput('fail, checksum');
				}
				} else {
				$this->response->setOutput('fail, no key');
			}
			
		}
		
		public function spi(){
			if (!empty($this->request->get['pwaInstallKey'])){
				if ($this->validateKey($this->request->get['pwaInstallKey'], 'pwainstall')){
					$this->response->setOutput('ok');
					
					$this->updateCounter('pwainstall');
					
					} else {
					$this->response->setOutput('fail, checksum');
				}
				} else {
				$this->response->setOutput('fail, no key');
			}		
		}
		
		
		private function validateKey($key, $type){
			return ($key == md5($type . $this->request->server['REMOTE_ADDR'] . date('d') . $this->config->get('config_encryption')));
		}
		
		private function updateCounter($counter){
		//	$this->db->query("UPDATE counters SET value = value+1 WHERE store_id = '" .(int)$this->config->get('config_store_id'). "' AND counter = '" . $this->db->escape($counter) . "'");
		}
	}			