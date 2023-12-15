<?php

class ControllerStartupHoboSeo extends Controller {
	public function index() {
	
		$new_page = '';
		
		if (isset($this->request->get['ealang']) && $this->request->get['ealang']){
			$val = $this->request->get['ealang'];
			$new_page = str_replace('&amp;ealang=' . $val, '', $_SERVER['REQUEST_URI']);
			$new_page = str_replace('&ealang=' . $val, '', $new_page);
			$new_page = str_replace('?ealang=' . $val, '', $new_page);
			
			$this->response->redirect($new_page, 301);			
		}

		if (isset($this->request->get['prlpn']) && $this->request->get['prlpn']){
			$val = $this->request->get['prlpn'];
			$new_page = str_replace('&amp;prlpn=' . $val, '', $_SERVER['REQUEST_URI']);
			$new_page = str_replace('&prlpn=' . $val, '', $new_page);
			$new_page = str_replace('?prlpn=' . $val, '', $new_page);
			
			$this->response->redirect($new_page, 301);			
		}
		
		if (isset($this->request->get['prpln']) && $this->request->get['prpln']){
			$val = $this->request->get['prpln'];
			$new_page = str_replace('&amp;prpln=' . $val, '', $_SERVER['REQUEST_URI']);
			$new_page = str_replace('&prpln=' . $val, '', $new_page);
			$new_page = str_replace('?prpln=' . $val, '', $new_page);
			
			$this->response->redirect($new_page, 301);			
		}
	
		if (isset($this->request->get['page']) && $this->request->get['page'] == 1){
			$new_page = str_replace('&amp;page=1', '', $_SERVER['REQUEST_URI']);
			$new_page = str_replace('&page=1', '', $new_page);
			$new_page = str_replace('?page=1', '', $new_page);			
		}
		
		if ($new_page){
			$this->response->redirect($new_page, 301);
		}
		
	}	
}