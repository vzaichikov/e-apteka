<?php
	namespace Cart;
	class User {
		private $user_id;
		private $username;
		private $pbx_extension;
		private $permission = array();
		
		private $ldap;
		private $ldap_host 				= "";
		private $ldap_host2 			= "";
		private $ldap_dn 				= "";
		private $ldap_domain 			= "";
		private $ldap_group_mapping 	= array(
		'site_admins' => 1,
		'site_content' => 2,
		'site_call-center' => 3,
		);
		
		public function __construct($registry) {
			$this->db = $registry->get('db');
			$this->request = $registry->get('request');
			$this->session = $registry->get('session');
			$this->config = $registry->get('config');
			
			$this->ldap_host 	= LDAP_HOST;
			$this->ldap_host2 	= LDAP_HOST2;
			$this->ldap_dn 		= LDAP_DN;
			$this->ldap_domain 	= LDAP_DOMAIN;

			
			if (isset($this->session->data['user_id'])) {
				$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE user_id = '" . (int)$this->session->data['user_id'] . "' AND status = '1'");
				
				if ($user_query->num_rows) {
					$this->user_id = $user_query->row['user_id'];
					$this->username = $user_query->row['username'];
					$this->pbx_extension = $user_query->row['pbx_extension'];
					$this->user_group_id = $user_query->row['user_group_id'];
					
					$this->db->query("UPDATE " . DB_PREFIX . "user SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE user_id = '" . (int)$this->session->data['user_id'] . "'");
					
					$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");
					
					$permissions = json_decode($user_group_query->row['permission'], true);
					
					if (is_array($permissions)) {
						foreach ($permissions as $key => $value) {
							$this->permission[$key] = $value;
						}
					}
					} else {
					$this->logout();
				}
			}
		}
		
		private function checkLDAPConnection(){
			
			$connection = @fsockopen($this->ldap_host, 389, $errn, $errstr, 5);
			
			if (!is_resource($connection)){				
				$connection = @fsockopen($this->ldap_host2, 389, $errn, $errstr, 5);	
				
				if (is_resource($connection)){
					$this->ldap_host = $this->ldap_host2;
				}
			}
			
			if (is_resource($connection)){
				fclose($connection);
				
				$this->ldap = @ldap_connect($this->ldap_host, 389);
				
				if (is_resource($this->ldap)){
					ldap_set_option($this->ldap, LDAP_OPT_REFERRALS, 0);
					ldap_set_option($this->ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
					
					return true;
				}
			}
			
			return false;
		}
		
		private function addUser($data){
			
			$this->db->query("INSERT INTO `" . DB_PREFIX . "user` SET 
			username = '" . $this->db->escape($data['username']) . "', 
			salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', 
			password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', 
			firstname = '" . $this->db->escape($data['firstname']) . "', 
			lastname = '" . $this->db->escape($data['lastname']) . "',
			pbx_extension = '" . $this->db->escape($data['pbx_extension']) . "',
			email = '" . $this->db->escape($data['email']) . "', 
			image = '" . $this->db->escape('catalog/icon/agp_bluelogo.png') . "',
			user_group_id = '" . $this->db->escape($data['user_group_id']) . "', 
			status = '0', 
			date_added = NOW()");
			
			return $this->db->getLastId();
		}
		
		private function editUser($user_id, $data){
			
			$this->db->query("UPDATE `" . DB_PREFIX . "user` SET 
			username = '" . $this->db->escape($data['username']) . "', 
			salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', 
			password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', 
			firstname = '" . $this->db->escape($data['firstname']) . "', 
			lastname = '" . $this->db->escape($data['lastname']) . "',
			pbx_extension = '" . $this->db->escape($data['pbx_extension']) . "',
			email = '" . $this->db->escape($data['email']) . "', 
			image = '" . $this->db->escape('catalog/icon/agp_bluelogo.png') . "',
			user_group_id = '" . $this->db->escape($data['user_group_id']) . "', 
			status = '0' 
			WHERE user_id = '" . (int)$user_id . "'
			");
			
		}
		
		private function parseLDAPData($ldap_user){
			
			$result = array();
			if (!empty($ldap_user['count']) && !empty($ldap_user[0])){
				
				$result['firstname'] 		= isset($ldap_user['0']['givenname'])?$ldap_user['0']['givenname']['0']:'';
				$result['lastname'] 		= isset($ldap_user['0']['sn'])?$ldap_user['0']['sn']['0']:'';			
				$result['pbx_extension'] 	= isset($ldap_user['0']['ipphone'])?$ldap_user['0']['ipphone']['0']:'';
				$result['email'] 			= isset($ldap_user['0']['mail'])?$ldap_user['0']['mail']['0']:'';
				
				$allowed = false;
				foreach ($ldap_user['0']['memberof'] as $memberof){	
					
					foreach ($this->ldap_group_mapping as $group => $group_id) {	
						if (stripos($memberof, $group) !== false){
							$result['user_group_id'] = $allowed = $group_id;
							break;
						}					
					}
					
					if ($allowed){
						break;
					}
				}
				
				if (!$allowed){
					return false;
				}
			}
			
			return $result;
			
		}
		
		private function switchUserOff($username){
			$this->db->query("UPDATE " . DB_PREFIX . "user SET status = 0 WHERE username = '" . $this->db->escape($username) . "'");			
		}
		
		private function switchUserOn($username){
			$this->db->query("UPDATE " . DB_PREFIX . "user SET status = 1 WHERE username = '" . $this->db->escape($username) . "'");			
		}
		
		private function checkIfUserExists($username){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE username = '" . $this->db->escape($username) . "'");		
			
			if ($query->num_rows){
				return $query->row['user_id'];
				} else {
				return false;
			}
		}
		
		private function ldapLogin($username, $password){
			
			$this->switchUserOff($username);
		
			if ($check = @ldap_bind($this->ldap, $username .'@' . $this->ldap_domain, $password)){
				$search 	= ldap_search($this->ldap, $this->ldap_dn, '(sAMAccountName=' . $username . ')', array('memberof', 'mail', 'givenname', 'sn', 'ipPhone'));
				$ldap_user 	= ldap_get_entries($this->ldap, $search);
				ldap_unbind($this->ldap);
				
				if ($user = $this->parseLDAPData($ldap_user)){
					
					$user['username'] = $username;
					$user['password'] = $password;
					
					if ($user_id = $this->checkIfUserExists($username)){
						$this->editUser($user_id, $user);
						} else {					
						$this->addUser($user);
					}
					
					$this->switchUserOn($username);			
					} else {
					$this->switchUserOff($username);
				}			
				
				} else {
				$this->switchUserOff($username);	
			}
			
			$this->login($username, $password, true);
		}
		
		public function login($username, $password, $default_login = false) {
			
			if (mb_strlen($username) < 3){
				return false;		
			}
			
			if (mb_strlen($password) < 3){
				return false;		
			}
			
			//TRY TO INIT LDAP
			if (!$default_login){
				if ($this->checkLDAPConnection()){							
					$this->ldapLogin($username, $password);
				}
			}
			
			$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE username = '" . $this->db->escape($username) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape(htmlspecialchars($password, ENT_QUOTES)) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");				
			
			if ($user_query->num_rows) {
				$this->session->data['user_id'] = $user_query->row['user_id'];
				
				$this->user_id = $user_query->row['user_id'];
				$this->username = $user_query->row['username'];
				$this->user_group_id = $user_query->row['user_group_id'];
				
				$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");
				
				$permissions = json_decode($user_group_query->row['permission'], true);
				
				if (is_array($permissions)) {
					foreach ($permissions as $key => $value) {
						$this->permission[$key] = $value;
					}
				}
				
				
				return true;
				} else {
				
				return false;
			}
		}
		
		public function logout() {
			
			if($this->config->get('adminlog_enable') && $this->config->get('adminlog_logout')){
				$this->db->query("INSERT INTO " . DB_PREFIX . "adminlog SET user_id = '" . (int)$this->user_id . "', `user_name` = '" . $this->username . "', `action` = 'logout', `allowed` = '1', `url` = '".$this->request->server['REQUEST_URI']."', `ip` = '" . $this->request->server['REMOTE_ADDR'] . "', date = NOW()");
			}
			
			unset($this->session->data['user_id']);
			
			$this->user_id = '';
			$this->username = '';
		}
		
		public function hasPermission($key, $value) {
			if (isset($this->permission[$key])) {
				
				if($this->config->get('adminlog_enable')){
					if( ( ($this->config->get('adminlog_allowed') == 1 || $this->config->get('adminlog_allowed') == 2) && (in_array($value, $this->permission[$key])) )  ||
					( ($this->config->get('adminlog_allowed') == 0 || $this->config->get('adminlog_allowed') == 2) && !(in_array($value, $this->permission[$key])) )  ){
						if(($this->config->get('adminlog_access') && $key == "access") || ($this->config->get('adminlog_modify') && $key == "modify") ){
							$this->db->query("INSERT INTO " . DB_PREFIX . "adminlog SET user_id = '" . (int)$this->user_id . "', `user_name` = '" . $this->username . "', `action` = '".$key."', `allowed` = '".in_array($value, $this->permission[$key])."', `url` = '".$this->request->server['REQUEST_URI']."', `ip` = '" . $this->request->server['REMOTE_ADDR'] . "', date = NOW()");
						}
					}
				}
				
				return in_array($value, $this->permission[$key]);
				} else {
				
				if($this->config->get('adminlog_enable') && ($this->config->get('adminlog_allowed') == 0 || $this->config->get('adminlog_allowed') == 2)){
					$this->db->query("INSERT INTO " . DB_PREFIX . "adminlog SET user_id = '" . (int)$this->user_id . "', `user_name` = '" . $this->username . "', `action` = '".$key."', `allowed` = '0', `url` = '".$this->request->server['REQUEST_URI']."', `ip` = '" . $this->request->server['REMOTE_ADDR'] . "', date = NOW()");
				}
				
				return false;
			}
		}
		
		public function isLogged() {
			return $this->user_id;
		}
		
		public function getId() {
			return $this->user_id;
		}
		
		public function getUserName() {
			return $this->username;
		}
		
		public function getIPBX() {
			return $this->pbx_extension;
		}
		
		public function getGroupId() {
			return $this->user_group_id;
		}
	}
