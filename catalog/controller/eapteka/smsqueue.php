<?php
	class ControllerEaptekaSmsQueue extends Controller
	{
		
		public function queue(){
		
			foreach ($this->TurboSMS->getQueue() as $sms){
				
				echoLine('Отправляем SMS на номер ' . $sms['telephone'] . ': ' . $sms['text']);
				$result = $this->TurboSMS->sendSMS($sms['telephone'], $sms['text']);
				
				if ($result = json_decode($result, true)){
					if ($result['response_status'] == 'SUCCESS_MESSAGE_SENT'){
					
						$this->TurboSMS->updateStatus($sms['sms_id'], 1, $result['response_result'][0]['message_id']);
						
					}
					
				}
			
			}
		}

	}