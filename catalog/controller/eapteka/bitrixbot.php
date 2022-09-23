<?php
	class ControllerEaptekaBitrixBot extends Controller {
		private $bitrixBot = false;
		
		public function __construct($registry){
			parent::__construct($registry);
			
			$this->load->library('hobotix/BitrixBot');
			$this->bitrixBot = new hobotix\BitrixBot($registry);
			
		}
		
		private function index(){}
		
		
		
		
		public function install(){					
			
			if ($this->bitrixBot->checkEvent('ONAPPINSTALL')){
				$result = $this->bitrixBot->logRequest()->restCommand('imbot.register', array(
				'CODE'                  => 'ProvizorBot',              
				'TYPE'                  => 'B',
				'EVENT_MESSAGE_ADD'     => $this->url->link('eapteka/bitrixbot/webhook'),
				'EVENT_WELCOME_MESSAGE' => $this->url->link('eapteka/bitrixbot/webhook'),
				'EVENT_BOT_DELETE'      => $this->url->link('eapteka/bitrixbot/webhook'),
				'PROPERTIES'            => array(
				'NAME'              => 'Провизорчик',
				'LAST_NAME'         => '',
				'COLOR'             => 'AQUA',               
				'EMAIL'             => 'bot@e-apteka.com.ua',
				'PERSONAL_BIRTHDAY' => '2021-03-23',
				'WORK_POSITION'     => 'Сообщаю о новых заказах',
				'PERSONAL_WWW'      => '',
				'PERSONAL_GENDER'   => 'M',
				'PERSONAL_PHOTO'    => base64_encode(file_get_contents( DIR_IMAGE .'/provizorchik.png'))
				)
				), $this->request->request["auth"]
				);
				
				$appsConfig[$this->request->request['auth']['application_token']] = array(
				'BOT_ID'      => $result['result'],
				'LANGUAGE_ID' => $this->request->request['data']['LANGUAGE_ID'],
				);
				$this->bitrixBot->saveBotParams($appsConfig);				
				
				$appsConfig[$this->request->request['auth']['application_token']] = array(
				'AUTH'      => $this->request->request['auth']
				);
				$this->bitrixBot->saveParams($appsConfig);	
			}
		}
		
		public function testmessage(){
			
			if (!$this->bitrixBot->logRequest()->loadConfigFile()->validateAppsConfig()){
				return;
			}
			
			$this->bitrixBot->sendMessageToGroup('chat5636', array('message' => 'Тест прямого сообщения, 123'));
			
		}
		
		
		public function webhook(){
			
			if (!$this->bitrixBot->logRequest()->loadConfigFile()->validateAppsConfig()){
				return;
			}
			
			if ($this->bitrixBot->checkEvent('ONIMBOTMESSAGEADD')){	
				$this->bitrixBot->sendAnswer('Я еще не умею разговаривать и отвечать на вопросы:) Пока что я могу только отправлять уведомления о заказах и звонках. Хорошего дня!');
			}
			
			if ($this->bitrixBot->checkEvent('ONIMBOTJOINCHAT')){
				$this->bitrixBot->sendMessageInGroup('Всем привет! Я буду присылать разные уведомления!');
			}
			
			
		}
		
	}								