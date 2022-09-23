<?php
	
	
	namespace hobotix;
	
	
	class QwantImageSearch{
		
		private function getRandomUserAgent(){
			require_once(DIR_SYSTEM . 'library/hobotix/UserAgentList.php');	
			
			$uaLIST = _userAgents();
			
			return $uaLIST[rand(0, _userAgents(true) - 1)];
		}
		
		private function getRandomProxy(){
			$Proxies = array(
			);
			
			return $Proxies[rand(0, count($Proxies) - 1)];
		}
		
		private function getJSON($url){
			
			$constants = get_defined_constants(true);
			$json_errors = array();
			foreach ($constants["json"] as $name => $value) {
				if (!strncmp($name, "JSON_ERROR_", 11)) {
					$json_errors[$value] = $name;
				}
			}
			
			$_headers = [
			'Accept: */*',
			'Accept-Encoding: gzip, deflate, br',
			'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
			'Cache-Control: max-age=0',
			'Content-Type: application/x-www-form-urlencoded',
			'Connection: keep-alive',
			'Upgrade-Insecure-Requests: 1',
			'Origin: https://www.qwant.com',
			'Referer: https://www.qwant.com/',
			'Host: api.qwant.com'
			];
			
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $_headers);
			curl_setopt($ch, CURLOPT_TIMEOUT, 2000);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2000);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
			curl_setopt($ch, CURLOPT_USERAGENT, $this->getRandomUserAgent());
			curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate, br");
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);	
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			
			$data = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
	
			if ($json = json_decode($data, true)){										
				return $json;
				} else {
				return array(
					'data'=> $json,
					'err' => $json_errors[json_last_error()]
					);
			}
			
		}
		
		public function prepareQwantQuery($data){
			
			$url = 'https://api.qwant.com/api/search/images?';			
			
			if (empty($data['count']) || (int)$data['count']){
				$data['count'] = 50;
			}
			
			return $url . http_build_query($data);
			
		}
		
		public function parseQwantJSON($json){
		
			if (!isset($json['status'])){
				print_r($json['data']);
				throw new \Exception('Ошибка поиска, ограничения поисковика. Попробуй еще раз.');
			}
			
			if ($json['status'] == 'error'){
				throw new \Exception('Ошибка поиска, ограничения поисковика. Попробуй еще раз.');
			}
			
			if (!isset($json['data']['result']['total']) || $json['data']['result']['total'] == 0){
				throw new \Exception('Ничего не найдено. Это не ошибка, просто нет картинок по такому запросу.');
			}
			
			$result = array(
			'result' => array(),
			'total'  => $json['data']['result']['total']
			);
			foreach ($json['data']['result']['items'] as $item){
				
				$result['result'][] = array(
				'domain' 			=> parse_url($item['url'], PHP_URL_HOST),
				'title' 			=> $item['title'],
				'url' 				=> $item['url'],	
				'media' 			=> $item['media'],				
				'media_fullsize' 	=> $item['media_fullsize'],
				'media_preview' 	=> $item['media_preview'],
				'width'  			=> $item['width'],
				'height' 			=> $item['height'],
				'thumb_width' 		=> $item['thumb_width'],
				'thumb_height' 		=> $item['thumb_height'],
				
				);
			}
			
			
			return $result;
		}
		
		
		
		public function searchForImage($data){
			
			if (mb_strlen($data['query']) < 3) {			
				throw new \Exception('Error: Too small query: ' . $data['query'] . '!');
			}
			
			if (!isset($data['locale'])){
				$data['locale'] = 'ru_Ru';
			}
			
			if (!isset($data['count'])){
				$data['count'] = 10;
			}
			
			$data = array(
			'q' => $data['query'],
			'count' => $data['count'],
			'locale' => $data['locale'],
			't'  => 'images',				
			'uiv' => '4'
			);
			
			$url = $this->prepareQwantQuery($data);											
			$json = $this->getJSON($url);
			$parsed_json = $this->parseQwantJSON($json);
			
			return $parsed_json;
			
		}
		
		
	}
