<?php
	
	
	namespace hobotix;
	use Exception;
	
	class ExtCall{
		private $amiHost = '';
		private $amiUser = '';
		private $amiPass = '';		
		private $defaultQueue = '';
		private $extensionFormatLength = 3;
		private $maxRepeats = 3;
		private $socket;
		private $error;
		
		private function preparePhone($phone){
			$phone = preg_replace( "/\D/", "", $phone);
			if ($phone[0] == '+'){
				$phone = substr($phone, 1);			
			}
			
			if ($phone[0] == '3'){
				$phone = substr($phone, 1);			
			}
			
			if ($phone[0] == '8'){
				$phone = substr($phone, 1);			
			}
			
			return $phone;						
		}		
		
		private function preparePhonePBX($phone){
			return preg_replace( "/\D/", "", $phone);
		}
		
		private function openSocket(){		
			$this->socket = fsockopen(AMI_HOST, '5038', $errno, $errstr, 10);						
			
			if (!$this->socket || !is_resource($this->socket)){
				throw new \Exception('Can not create socket!');
				return false;
			}
			
			return true;
		}
		
		private function echoLine($command){
			echo $command . PHP_EOL;
		}
		
		private function closeSocket(){						
			if (is_resource($this->socket)){
				fclose($this->socket);
			}
		}
		
		private function doCommand($command){
			
			if (is_resource($this->socket)){
				$this->echoLine('[AMI >>]' . $command);
				fputs($this->socket, $command . "\r\n" );
				} else {
				throw new \Exception('No socket now!');
			}
			
		}
		
		private function readAnswer($length = 128){
			if (is_resource($this->socket)){
				$line = trim(fgets($this->socket, $length));
				$this->echoLine('[AMI <<]' . $line);
				
				return $line;
				}  else {
				throw new \Exception('No socket now!');
			}			
		}
		
		private function readFullAnswer(){
			if (is_resource($this->socket)){
				$status = '';
				
				$line = $this->readAnswer();
				
				$fallback_counter = 0;
				while (!strpos($line, 'END COMMAND') || $fallback_counter < 30) {										
					$line = $this->readAnswer();
					$status .= $line . PHP_EOL;					
					$fallback_counter ++;
				} 
				
				}  else {
				throw new Exception('No socket now!');
			}	
			
			return $status;
			
		}
		
		private function finishCommand(){
			if (is_resource($this->socket)){
				fputs($this->socket, "\r\n" );
			}			
		}
		
		private function doLogin(){
			
			if ($this->openSocket()){
				
				$this->doCommand("Action: Login");
				$this->doCommand("UserName: " . AMI_USER);
				$this->doCommand("Secret: " . AMI_PASSWORD);
				$this->finishCommand();
				
				$status = fgets($this->socket, 128);								
				
				if (!$status){
					throw new \Exception('Can not login!');
					return false;	
				}								
				
				$status = $this->readAnswer();
				
				if (!stripos($status, 'success')){
					throw new \Exception('Can not login! Responce: ' . $status);
					return false;
				}
			} 
			
			return $status;
		}
		
		private function doLogout(){
			if (is_resource($this->socket)){
				$this->doCommand("Action: Logout");
				$this->finishCommand();
				
				$this->closeSocket();
			}						
		}
		
		public function getStatus(){
			
			$status = $this->doLogin();								
			$this->closeSocket();
			
			return $status;
		}
		
		public function getPeers($sort = false){
			
			if ($this->doLogin()){
				
				$this->doCommand("Action: COMMAND");
				$this->doCommand("Command: queue show " . AMI_DEFAULT_QUEUE);
				$this->finishCommand();
				
				$peers = array();
				$peers_info = array();
				if ($list = $this->readFullAnswer()){
					$exploded = explode(PHP_EOL, $list);
					
					foreach ($exploded as $peers_line){
						if (stripos($peers_line, 'SIP') !== false){
							$peer = substr(str_replace('SIP/', '', $peers_line), 0, $this->extensionFormatLength);
							
							preg_match_all('/(?<=\()([\s\S]+?)(?=\))/', $peers_line, $matches, PREG_SET_ORDER);
							
							
							if (!empty($matches[0]) && !empty($matches[0][0]) && $status = $matches[0][0]){
								if (!isset($peers[$status])){
									$peers[$status] = array();
								}								
								$peers[$status][] = $peer;
								
								if (!empty($matches[1] && !empty($matches[1][0]))){
									$status = $matches[1][0];
								}
								
								$peers_info[] = array(
								'peer' => $peer,
								'status' => $status
								);
								
							}
						}						
					}				
				}
				
				if ($sort){
					return $peers_info;
				}
				
				return $peers;
			}
		}
		
		public function doCallback($phone){
			if ($peers = $this->getPeers()){							
				
				if (!empty($peers['Not in use']) && count($peers['Not in use'])){
					
					$peer = $peers['Not in use'][rand(0, count($peers['Not in use']) - 1)];
					
					$this->echoLine('GOT FREE PEER:' . $peer);
					
					if ($peer){
						$this->originateCall($peer, $phone);
					}
					
				}																
			}
		}
		
		public function checkPeerInUse($pbx){
			if ($peers = $this->getPeers(true)){										
				foreach ($peers as $peer){
					if ($peer['peer'] == $pbx){
						return $peer['status'];
					}
				}
			}
			
			return false;
		}
		
		public function pausePeerInQueue($pbx){
			$pbx = $this->preparePhonePBX($pbx);
			
			if ($this->doLogin()){
				
				$this->doCommand("Action: QueuePause" );
				$this->doCommand("Queue: AMI_DEFAULT_QUEUE" );
				$this->doCommand("Interface: SIP/$pbx" );
				$this->doCommand("Paused: true" );
				$this->finishCommand();
				
				$status = $this->readAnswer();
				
			}
		}
		
		public function unPausePeerInQueue($pbx){
			$pbx = $this->preparePhonePBX($pbx);
			
			if ($this->doLogin()){
				
				$this->doCommand("Action: QueuePause" );
				$this->doCommand("Queue: AMI_DEFAULT_QUEUE" );
				$this->doCommand("Interface: SIP/$pbx" );
				$this->doCommand("Paused: false" );
				$this->finishCommand();
				
				$status = $this->readAnswer();
				
			}
		}
		
		public function getPeerStatus($pbx){
			
			$pbx = $this->preparePhonePBX($pbx);
			
			if ($this->doLogin()){
				$this->doCommand("Action: SIPshowpeer" );
				$this->doCommand("Peer: $pbx" );
				$this->finishCommand();
				
				$status = $this->readFullAnswer();
			}			
		}
		
		public function originateCall($pbx, $phone, $retry_iterator = 0){
			
			if ($retry_iterator){
				$this->echoLine('[AMI INFO] Что-то пошло не так, попытка ' . $retry_iterator);
			}
			
			if ($retry_iterator >= $this->maxRepeats){
				$this->echoLine('[AMI INFO] Максимальное количество повторов ' . $retry_iterator);
				return false;
			}
			
			$pbx = $this->preparePhonePBX($pbx);
			$phone = $this->preparePhone($phone);
			
			if ($this->doLogin()){
				
				$this->echoLine('[!!!!!!!!]' . $this->checkPeerInUse($pbx));
				$this->pausePeerInQueue($pbx);
				
				$this->doCommand("Action: Originate" );
				$this->doCommand("Channel: SIP/$pbx" );
				$this->doCommand("Exten: $phone" );
				$this->doCommand("Context: internal" );
				$this->doCommand("Priority: 1" );
				$this->doCommand("Async: yes" );
				$this->doCommand("WaitTime: 5" );
				$this->doCommand("Callerid: $phone" );
				$this->finishCommand();
				
				$this->echoLine('[!!!!!!!!]' . $this->checkPeerInUse($pbx));
				
				if ($this->checkPeerInUse($pbx) != 'Ringing'){
					$retry_iterator++;
					$this->doLogout();
					$this->closeSocket();
					$this->originateCall($pbx, $phone, $retry_iterator);
				}
				
				$this->unPausePeerInQueue($pbx);
				
				$status = $this->readAnswer();	
				$this->doLogout();
				$this->closeSocket();
				
				return $status;
			}
			
		} 
		
	}												