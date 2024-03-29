<?php
	class ControllerCommonLogin extends Controller {
		private $error = array();
		
		public function index() {
			
			$this->load->language('common/login');

			$dbpass = $this->config->get('config_pass');
	        $snpass = null;
	if (!empty($dbpass['admin_pass']) && empty($dbpass['admin_key']))  {			
		if (!isset($_GET[$dbpass['admin_pass']]))   {
                $this->response->redirect('http://'.$_SERVER['HTTP_HOST']."/");
        }
        else{
            $snpass = '&'.$dbpass['admin_pass'];
        }			
	}		
    else if (!empty($dbpass['admin_pass']) && !empty($dbpass['admin_key']))  {
	
        if (!isset($_GET[$dbpass['admin_pass']]) || $_GET[$dbpass['admin_pass']] != $dbpass['admin_key'])  {
                $this->response->redirect('http://'.$_SERVER['HTTP_HOST']."/");
        }
        else{
            $snpass = '&'.$dbpass['admin_pass'].'='.$dbpass['admin_key'];
        }
	}
            
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
				$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true));
			}
			
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
				$this->session->data['token'] = token(32);
				
				if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], HTTP_SERVER) === 0 || strpos($this->request->post['redirect'], HTTPS_SERVER) === 0)) {
					$this->response->redirect($this->request->post['redirect'] . '&token=' . $this->session->data['token']);
					} else {
					$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true));
				}
			}
			
			$data['heading_title'] = $this->language->get('heading_title');
			
			$data['text_login'] = $this->language->get('text_login');
			$data['text_forgotten'] = $this->language->get('text_forgotten');
			
			$data['entry_username'] = $this->language->get('entry_username');
			$data['entry_password'] = $this->language->get('entry_password');
			
			$data['button_login'] = $this->language->get('button_login');
			
			if ((isset($this->session->data['token']) && !isset($this->request->get['token'])) || ((isset($this->request->get['token']) && (isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token']))))) {
				$this->error['warning'] = $this->language->get('error_token');
			}
			
			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
				} else {
				$data['error_warning'] = '';
			}
			
			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];
				
				unset($this->session->data['success']);
				} else {
				$data['success'] = '';
			}
			
			
			if (!empty($dbpass['admin_pass']))  {
             $data['action'] = $this->url->link('common/login', '', 'SSL').$snpass; 
			}
			else {
            $data['action'] = $this->url->link('common/login', '', 'SSL');
            }
            
			
			if (isset($this->request->post['username'])) {
				$data['username'] = $this->request->post['username'];
				} else {			
				if (!empty($this->request->cookie[AUTH_UNAME_COOKIE])){
					$data['username'] = base64_decode($this->request->cookie[AUTH_UNAME_COOKIE]);
					$data['username'] = str_replace(AUTH_PASSWDSALT_COOKIE, '', $data['username']);
					} else {
					$data['username'] = '';
				}
			}
			
			if (isset($this->request->post['password'])) {
				$data['password'] = $this->request->post['password'];
				} else {
				
				if (!empty($this->request->cookie[AUTH_PASSWD_COOKIE])){
					$data['password'] = base64_decode($this->request->cookie[AUTH_PASSWD_COOKIE]);
					$data['password'] = str_replace(AUTH_PASSWDSALT_COOKIE, '', $data['password']);
					} else {		
					$data['password'] = '';
				}
			}
			
			if (isset($this->request->get['route'])) {
				$route = $this->request->get['route'];
				
				unset($this->request->get['route']);
				unset($this->request->get['token']);
				
				$url = '';
				
				if ($this->request->get) {
					$url .= http_build_query($this->request->get);
				}
				
				$data['redirect'] = $this->url->link($route, $url, true);
				} else {
				$data['redirect'] = '';
			}
			
			if ($this->config->get('config_password')) {
				$data['forgotten'] = $this->url->link('common/forgotten', '', true);
				} else {
				$data['forgotten'] = '';
			}
			
			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');
			
			$this->response->setOutput($this->load->view('common/login', $data));
		}
		
		protected function validate() {
			if (!isset($this->request->post['username']) || !isset($this->request->post['password']) || !$this->user->login($this->request->post['username'], html_entity_decode($this->request->post['password'], ENT_QUOTES, 'UTF-8'))) {
				$this->error['warning'] = $this->language->get('error_login');
			}
			
			if (!$this->error) {
				setcookie(AUTH_UNAME_COOKIE, base64_encode($this->request->post['username'] . AUTH_PASSWDSALT_COOKIE), time() + (1000 * 60 * 60 * 24 * 90));
				setcookie(AUTH_PASSWD_COOKIE, base64_encode($this->request->post['password'] . AUTH_PASSWDSALT_COOKIE), time() + (1000 * 60 * 60 * 24 * 90));				
			}
			
			return !$this->error;
		}
	}
