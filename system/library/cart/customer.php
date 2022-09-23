<?php
	namespace Cart;
	class Customer {
		private $customer_id;
		private $firstname;
		private $lastname;
		private $customer_group_id;
		private $email;
		private $card;
		private $telephone;
		private $fax;
		private $newsletter;
		private $address_id;
		
		public function __construct($registry) {
			$this->config = $registry->get('config');
			$this->db = $registry->get('db');
			$this->request = $registry->get('request');
			$this->session = $registry->get('session');
			
			if (isset($this->session->data['customer_id'])) {
				$customer_query = $this->db->ncquery("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND status = '1'");
				
				if ($customer_query->num_rows) {
					$this->customer_id = $customer_query->row['customer_id'];
					$this->firstname = $customer_query->row['firstname'];
					$this->lastname = $customer_query->row['lastname'];
					$this->customer_group_id = $customer_query->row['customer_group_id'];
					$this->email = $customer_query->row['email'];
					$this->telephone = $customer_query->row['telephone'];
					$this->fax = $customer_query->row['fax'];
					$this->card = $customer_query->row['card'];
					$this->newsletter = $customer_query->row['newsletter'];
					$this->address_id = $customer_query->row['address_id'];
					
					$this->db->ncquery("UPDATE " . DB_PREFIX . "customer SET language_id = '" . (int)$this->config->get('config_language_id') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");
					
					$query = $this->db->ncquery("SELECT * FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");
					
					if (!$query->num_rows) {
						$this->db->ncquery("INSERT INTO " . DB_PREFIX . "customer_ip SET customer_id = '" . (int)$this->session->data['customer_id'] . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
					}
					} else {
					$this->logout();
				}
			}
		}
		
		public function login($email, $password, $override = false, $customer_id_explicit = false) {
			
			if (!$override){
				if ($email == '' || $password == ''){
					return false;
				}
			}
			
			if ($override) {
				
				if ($customer_id_explicit){
					$customer_query = $this->db->ncquery("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id_explicit . "' AND status = '1'");
					
					} else {					
					$customer_query = $this->db->ncquery("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND status = '1'");					
				}
				
				} else {
				
				
				if (checkIfStringIsEmail($email)){
					$sql = "SELECT * FROM " . DB_PREFIX . "customer WHERE 
					LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'
					AND (
					password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) 
					OR password = '" . $this->db->escape(md5($password)) . "' 
					OR (LENGTH(card) > 0 AND (LOWER(card) = '" . $this->db->escape(utf8_strtolower($password)) . "'
					OR LOWER(SUBSTRING(card, 2, LENGTH(card)-2)) = '" . $this->db->escape(utf8_strtolower($password)) . "'))
					)				
					AND status = '1'
					AND approved = '1'";					
					} else {
					
					$sql = "SELECT * FROM " . DB_PREFIX . "customer WHERE 
					(
					LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' OR 
					(TRIM(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(telephone,' ',''), '+', ''), '-', ''), '(', ''), ')', '')) LIKE '" . $this->db->escape(preparePhone($email)) . "')
					) 
					AND (
					password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) 
					OR password = '" . $this->db->escape(md5($password)) . "' 
					OR (LENGTH(card) > 0 AND (LOWER(card) = '" . $this->db->escape(utf8_strtolower($password)) . "'
					OR LOWER(SUBSTRING(card, 2, LENGTH(card)-2)) = '" . $this->db->escape(utf8_strtolower($password)) . "'))
					)				
					AND status = '1'
					AND approved = '1'";
					
				}
				
				$customer_query = $this->db->ncquery($sql);
			}
			
			if ($customer_query->num_rows) {
				$this->session->data['customer_id'] = $customer_query->row['customer_id'];
				setcookie(AUTH_TOKEN_COOKIE, md5($customer_query->row['customer_id'] . $this->config->get('config_encryption')), time() + (1000 * 60 * 60 * 24), '/');
				
				$this->customer_id = $customer_query->row['customer_id'];
				$this->firstname = $customer_query->row['firstname'];
				$this->lastname = $customer_query->row['lastname'];
				$this->customer_group_id = $customer_query->row['customer_group_id'];
				$this->email = $customer_query->row['email'];
				$this->card = $customer_query->row['card'];
				$this->telephone = $customer_query->row['telephone'];
				$this->fax = $customer_query->row['fax'];
				$this->newsletter = $customer_query->row['newsletter'];
				$this->address_id = $customer_query->row['address_id'];
				
				$this->db->ncquery("UPDATE " . DB_PREFIX . "customer SET language_id = '" . (int)$this->config->get('config_language_id') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");
				
				return true;
				} else {
				return false;
			}
		}
		
		public function logout() {
			unset($this->session->data['customer_id']);
			setcookie(AUTH_TOKEN_COOKIE, null, time() - 3600, '/');
			//	unset($this->request->cookie[AUTH_TOKEN_COOKIE]);
			
			$this->customer_id = '';
			$this->firstname = '';
			$this->lastname = '';
			$this->customer_group_id = '';
			$this->email = '';
			$this->telephone = '';
			$this->fax = '';
			$this->newsletter = '';
			$this->address_id = '';
		}
		
		public function isLogged() {
			return $this->customer_id;
		}
		
		public function getId() {
			return $this->customer_id;
		}
		
		public function getFirstName() {
			return $this->firstname;
		}
		
		public function getLastName() {
			return $this->lastname;
		}
		
		public function getCard() {
			return $this->card;
		}
		
		public function getGroupId() {
			return $this->customer_group_id;
		}
		
		public function getEmail() {
			return $this->email;
		}
		
		public function getTelephone() {
			return $this->telephone;
		}
		
		public function getFax() {
			return $this->fax;
		}
		
		public function getNewsletter() {
			return $this->newsletter;
		}
		
		public function getAddressId() {
			return $this->address_id;
		}
		
		public function setPWASession(){
			$this->session->data['pwasession'] = true;
		}
		
		public function dropPWASession(){
			unset($this->session->data['pwasession']);
		}
		
		public function getPWASession(){
			if (!empty($this->session->data['pwasession'])){
				return $this->session->data['pwasession'];
			}
			
			return false;
		}
		
		public function getBalance() {
			$query = $this->db->ncquery("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$this->customer_id . "'");
			
			return $query->row['total'];
		}
		
		public function getRewardPoints() {
			$query = $this->db->ncquery("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$this->customer_id . "'");
			
			return $query->row['total'];
		}
	}
