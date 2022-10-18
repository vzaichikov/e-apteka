<?php
	
	
	namespace hobotix;
	
	
	class TelegramSender {
		private $group_id = '';
		
		public function setGroupID($group_id){
			$this->group_id = $group_id;
		}
		
		public function SendMessage($message) { 

            if (!$this->group_id){
                $this->group_id = TELEGRAM_BOT_GROUP;
            }

            $telegram_url = "https://api.telegram.org/bot" . TELEGRAM_BOT_KEY . '/sendMessage';
			
			$chat_id_array = array($this->group_id); 
            
            $mh = curl_multi_init();
            
            $ch = array();
            
            foreach ($chat_id_array as $chat_id) {
                $chat_id = trim($chat_id);
                $params = array(
                    'chat_id' => $chat_id,
                    'text' => $message,
                    'parse_mode' => 'html'
                );
                $ch[$chat_id] = curl_init($telegram_url);
                curl_setopt($ch[$chat_id], CURLOPT_HEADER, false);
                curl_setopt($ch[$chat_id], CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch[$chat_id], CURLOPT_POST, 1);
                curl_setopt($ch[$chat_id], CURLOPT_POSTFIELDS, ($params));
                curl_setopt($ch[$chat_id], CURLOPT_SSL_VERIFYPEER, false);
                curl_multi_add_handle($mh, $ch[$chat_id]);
            }

            do {
                curl_multi_exec($mh, $running);
                curl_multi_select($mh);
            } while ($running > 0);

            foreach ($ch as $value) {
                if (curl_errno($value)) {
                    echo ('telegram_notification module error: CURL: ' . curl_error($value) . PHP_EOL);
                } elseif (curl_getinfo($value, CURLINFO_HTTP_CODE) != 200) {
                    echo ('telegram_notification module error at SendMessage: CURL: HTTP CODE: ' . curl_getinfo($value, CURLINFO_HTTP_CODE) . PHP_EOL);
                }
                curl_multi_remove_handle($mh, $value);
            }

            curl_multi_close($mh);
        }

	}