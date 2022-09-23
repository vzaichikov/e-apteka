<?php
	class ControllerHobotixHoboQR extends Controller {
		
		public function index(){		
			
			$log = new Log('qr.usage.txt');
			$log->write($this->request->server['REMOTE_ADDR'] . ' ' . $this->request->server['HTTP_USER_AGENT']);
			
			$this->response->redirect($this->url->link('common/home'));
			
		}
		
	}
