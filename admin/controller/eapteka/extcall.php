<?php
	class ControllerEaptekaExtCall extends Controller {
		private $ExtCall;
		
		public function index(){
			
			
		}
		
		public function getStatus(){
			$this->load->library('hobotix/ExtCall');
			$this->ExtCall = new hobotix\ExtCall;
			
			$result = $this->ExtCall->getStatus();
			
			$this->response->setOutput($result);
		}
		
		public function originateCallAjax(){
			
			if ($this->user->getIPBX()){
				$this->load->library('hobotix/ExtCall');
				$this->ExtCall = new hobotix\ExtCall;
				
				$result = $this->ExtCall->originateCall($this->user->getIPBX(), $this->request->post['phone']);
			}
		}
		
		public function originateCall(){
			$this->load->library('hobotix/ExtCall');
			$this->ExtCall = new hobotix\ExtCall;
			
			//$this->ExtCall->getPeers();			
			//$result = $this->ExtCall->doCallback('');
			
			$result = $this->ExtCall->originateCall('538', '');
		}
		
	}								