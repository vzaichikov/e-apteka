<?php
	
	
	class ControllerEaptekaAjax extends Controller {
		
		public function index(){
			
			if (empty($this->request->get['modpath'])){
				$this->response->setOutput('');
				} else {
				$data = [];
				if (!empty($this->request->get['group'])){
					$exploded = explode(';', $this->request->get['modpath']);
					foreach ($exploded as $line){
						if (trim($line)){
							
							try{
								
								$data[] = [
								'path' 	=> $line,
								'html'	=> $this->load->controller($line)
								];
								
								} catch (Exception $e){
							}
							
						}
					}		
					
					return $this->load->view('structured/module', $data);
					
					} else {
					
					
					
					try{				
						$data['data'] = $this->load->controller($this->request->get['modpath']);
						} catch (Exception $e){
						$data['data'] = '';
					}
					
					return $this->load->view('structured/module', $data);	
					
				}
				
			}
		}
		
		
	}
