<?php
	
	namespace hobotix;
	use Exception;
	
	class BitrixBot{
		private $clientID = '';
		private $clientSecret = '';
		private $bitrixDomain = '';
		private $configFileName = DIR_SYSTEM . 'config/config_bitrixbot_{domain}.php';
		private $botConfigFileName = DIR_SYSTEM . 'config/config_bitrixbot.php';
		private $appsConfig = array();
		private $botConfig = array();
		private $log;
		private $request;
		
		public function __construct($registry){
			$this->log = new \Log('bitrixbot.log');
			$this->request = $registry->get('request');
			$this->db = $registry->get('db');

			$this->clientID = BITRIX_24_CLIENT_ID;
			$this->clientSecret = BITRIX_24_CLIENT_SECRET;
			$this->bitrixDomain = BITRIX_24_CLIENT_DOMAIN;
			
			//при вызове от бота
			if (isset($this->request->request['auth'])){
				$this->loadConfigFile($this->request->request['auth']['domain']);				
				} else {
				$this->loadConfigFile();
			}
		}
		
		private function getConfigFile($domain = ''){
			
			if (!$domain){
				$domain = $this->bitrixDomain;
			}
			
			return str_replace('{domain}', $domain, $this->configFileName);
			
		}
		
		public function loadConfigFile($domain = ''){
			
			if (file_exists($this->getConfigFile($domain))){
				include($this->getConfigFile($domain));
				
				$this->appsConfig = $appsConfig;				
			}
			
			if (file_exists($this->botConfigFileName)){
				include($this->botConfigFileName);
				
				$this->botConfig = $botConfig;				
			}
			
			return $this;
		}
		
		public function logRequest(){
			
			$this->log->write(serialize($this->request->request));
			
			return $this;
		}
		
		public function logResult($result){
			
			$this->log->write(serialize($result));
			
			return $this;
		}
		
		public function logLine($line){
			
			$this->log->write(serialize($line));
			
			return $this;
		}
		
		
		public function validateAppsConfig(){
			
			if (isset($this->request->request['auth'])){
				$appToken = $this->request->request['auth']['application_token'];
				} else {
				$this->appsConfig = array_values($this->appsConfig);
				$appToken = 0;
			}
			
			if (!isset($this->appsConfig[$appToken])) {
				return false;
			}
			
			return $this;
		}
		
		public function checkEvent($event){
			
			return (!empty($this->request->request['event']) && $this->request->request['event'] == $event);
			
		}
		
		public function saveBotParams($params) {
			
			$config = "<?php\n";
			$config .= "\$botConfig = " . var_export($params, true) . ";\n";
			$config .= "?>";
			
			$this->logLine('Записываем конфиг бота в ' . $this->botConfigFileName);
			
			file_put_contents($this->botConfigFileName, $config);
			return $this;
			
		}
		
		public function saveParams($params, $domain = '') {
			if (isset($this->request->request['auth'])){
				$domain = $this->request->request['auth']['domain'];
			}						
			
			$config = "<?php\n";
			$config .= "\$appsConfig = " . var_export($params, true) . ";\n";
			$config .= "?>";
			file_put_contents($this->getConfigFile($domain), $config);
			return true;
		}
		
		public function restCommand($method, array $params = Array(), array $auth = Array(), $authRefresh = true)
		{
			
			if (!$auth){
				$auth = array_values($this->appsConfig);
				$auth = $auth[0]['AUTH'];
			}
			
			$queryUrl = $auth["client_endpoint"] . $method;
			$queryData = http_build_query(array_merge($params, array("auth" => $auth["access_token"])));						
			
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
			CURLOPT_POST => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_SSL_VERIFYPEER => 1,
			CURLOPT_URL => $queryUrl,
			CURLOPT_POSTFIELDS => $queryData,
			));
			
			$result = curl_exec($curl);
			curl_close($curl);
			
			$result = json_decode($result, 1);
			
			if ($authRefresh && isset($result['error']) && in_array($result['error'], array('expired_token', 'invalid_token')))
			{
				$auth = $this->restAuth($auth);
				if ($auth)
				{
					$result = $this->restCommand($method, $params, $auth, false);
				}
			}
			
			return $result;
		}
		
		private function restAuth($auth)
		{
			if (!$this->clientID || !$this->clientSecret)
			return false;
			
			if(!isset($auth['refresh_token']))
			return false;
			
			$queryUrl = 'https://oauth.bitrix.info/oauth/token/';
			$queryData = http_build_query($queryParams = array(
			'grant_type' => 'refresh_token',
			'client_id' => $this->clientID,
			'client_secret' => $this->clientSecret,
			'refresh_token' => $auth['refresh_token'],
			));						
			
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $queryUrl.'?'.$queryData,
			));
			
			$result = curl_exec($curl);
			curl_close($curl);
			
			$result = json_decode($result, 1);
			
			if (!isset($result['error']))
			{
				$appsConfig = Array();
				$this->loadConfigFile();
				
				$result['application_token'] = $auth['application_token'];
				$appsConfig[$auth['application_token']]['AUTH'] = $result;
				$this->saveParams($appsConfig);
			}
			else
			{
				$result = false;
			}
			
			return $result;
		}
		
		public function sendMessageToGroup($group, $message){
		
			$result = $this->restCommand('imbot.message.add', 
			array(
			"DIALOG_ID" => $group,
			"MESSAGE"   => $message['message'], 
			"ATTACH"	=> !empty($message['attach'])?$message['attach']:array()
			), 
			array());
			
			$this->logResult($result);
			
		}
		
		
		public function sendMessageInGroup($message){
			
			$result = $this->restCommand('imbot.message.add', 
			array(
			"DIALOG_ID" => $this->request->request['data']['PARAMS']['DIALOG_ID'],
			"MESSAGE"   => $message,         
			), 
			$this->request->request["auth"]);
			
			$this->logResult($result);
			
		}
		
		
		public function sendAnswer($message){
			
			if ($this->botConfig[$this->request->request["auth"]['application_token']]['BOT_ID'] == $this->request->request['data']['PARAMS']['TO_USER_ID']){
				$result = $this->restCommand('imbot.message.add', 
				array(
				"DIALOG_ID" => $this->request->request['data']['PARAMS']['DIALOG_ID'],
				"MESSAGE"   => $message,         
				), 
				$this->request->request["auth"]);
				
				$this->logResult($result);
			}
		}
		
		
		
		
		
	}								