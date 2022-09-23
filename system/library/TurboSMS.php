<?
	
	class TurboSms{
		private $token = 'f378ce9e54c9a095d1a5a8085d3cac8b5d82a581';
		private $server = 'https://api.turbosms.ua/message/send.json';
		private $sender = 'E-APTEKA';
		private $db;
		
		public function __construct($registry){
			
			$this->db = $registry->get('db');
			
		}
		
		
		public function addToQueue($telephone, $text){
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "sms_queue SET telephone = '" . $this->db->escape(normalizePhone($telephone)) . "', text = '" . $this->db->escape($text) . "'");
			
		}
		
		public function getQueue(){
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sms_queue WHERE sent = 0 ORDER BY RAND() LIMIT 5");
			
			return $query->rows;
			
		}
		
		public function updateStatus($sms_id, $sent, $uuid){
		
			$query = $this->db->query("UPDATE " . DB_PREFIX . "sms_queue SET sent = '" . (int)$sent . "', uuid = '" . $this->db->escape($uuid) . "' WHERE sms_id = '" . (int)$sms_id . "'");

		}
		
		public function sendSms($telephone, $text){
			
			$json = array (			
			'recipients' 	=> array(normalizePhone($telephone, false)),
			'sms' => array('sender' 		=> TURBOSMS_API_ALPHA,
			'text' 			=> $text
			)
			);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Content-Type: application/json",
			"Authorization: Bearer TURBOSMS_API_KEY"
			));
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_URL, $this->server);
			$result = curl_exec($ch);
			
			return $result;
			
		}
		
		
		
		
		
		
		
		
		}
				