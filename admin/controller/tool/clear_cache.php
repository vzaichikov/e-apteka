<?php
	class ControllerToolClearCache extends Controller {
		public function index() {
			
			$status = array();
			
			if (!isset($_POST['push']) or !$this->user->hasPermission('modify', 'tool/clear_cache')) {
				$status = 'Permission error!';
			}else{
				
				if ($this->cache->flush()){				
					$status = 'Очистили кэш БД';
				} else {
					$error = 'Что-то пошло не так';
				}
			}
			
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($status));
			
		}
		
	}
