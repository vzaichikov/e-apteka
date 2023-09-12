<?php
	class ControllerExtensionPaymentipay extends Controller {
		private $api = 'https://api.ipay.ua/';
		
		private function getCurrentLanguage(){
			$this->load->model('localisation/language');
			$languages = $this->model_localisation_language->getLanguages();
			
			foreach($languages as $language){
				if ($this->config->get('config_language_id') == $language['language_id']){
					return $language['urlcode'];
				}
			}
			
			return 'ua';
		}
		
		public function addOrderToQueue($order_id){
			$this->load->model('checkout/order');
			$this->load->model('account/order');
			
			if (!$order_id) {
				die();
			}						
			
			$order_info = $this->model_checkout_order->getOrder($order_id);
			$order_products = $this->model_checkout_order->getOrderProducts($order_id);
			
			if ($order_info && $order_products) {
				$this->db->query("INSERT INTO  `" . DB_PREFIX . "order_queue` SET order_id = '" . (int)$order_id . "', date_added = NOW()");
			}
		}
		
		private function decodeiPayCallbackXML($xml){
			
			$this->load->library('XML2Array');
			$xml2Array = new \XML2Array();
			
			try {
				$decoded = $xml2Array->createArray($xml);				
				} catch (Exception $e){
				echo $e->getMessage();
				die();
				//	$decoded = false;		
			}	
			
			return $decoded;
			
		}
		
		private function decodeiPayRequestXML($xml){
			
			$this->load->library('XML2Array');
			$xml2Array = new \XML2Array();
			
			try {
				$decoded = $xml2Array->createArray($xml);				
				} catch (Exception $e){
				$decoded = false;		
			}						
			
			return $this->parseiPayAnswer($decoded);
		}
		
		private function parseiPayAnswer($result){
			
			if (!empty($result['payment'])){
				if (!empty($result['payment']['url']) && !empty($result['payment']['status'])){
					return $result['payment']['url'];
				}				
			}
			
			return false;
		}
		
		private function makeRequest($data){
			
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $this->api);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, ['data' => $data]);
			$result = curl_exec($curl);
			curl_close($curl);
			
			return $result;
		}
		
		private function generateSuccessKey($order_id){
			return md5(sha1($order_id . $this->config->get('ipay_signature')));			
		}
		
		private function validateSuccessKey($key){
			return $key == md5(sha1($this->session->data['order_id'] . $this->config->get('ipay_signature')));
		}
		
		private function validateiPay($data){
			$iPayData = array();
			
			if (!isset($data['payment'])){
				echo 'no_payment';
				return false;
			}
			
			if (!isset($data['payment']['salt']) || !isset($data['payment']['sign'])){
				echo 'no_salt_sign';
				return false;
			}
			
			if (!isset($data['payment']['amount']) || !(int)$data['payment']['amount']){
				echo 'no_amount';
				return false;
			}
			
			$iPayData['amount'] = (int)$data['payment']['amount'];
			
			if (!isset($data['payment']['@attributes']) || !isset($data['payment']['@attributes']['id'])){
				echo 'no_payment_id';
				return false;
			}
			
			$iPayData['payment_id'] = $data['payment']['@attributes']['id'];
			
			if (!isset($data['payment']['status'])){
				echo 'no_status';
				return false;
			}
			
			$iPayData['status'] = $data['payment']['status'];
			
			if (!isset($data['payment']['transactions']) || !isset($data['payment']['transactions']['transaction'])){
				echo 'no_transaction';
				return false;
			}
			
			if (!isset($data['payment']['transactions']['transaction'][0]['info'])){
				if (!isset($data['payment']['transactions']['transaction']['info'])){
					echo 'no_transaction_info';
					return false;
				}
			}
			
			if (!isset($data['payment']['transactions']['transaction'][0]['info'])){
				$iPayData['order_id'] = $data['payment']['transactions']['transaction']['info'];
				} else {
				$iPayData['order_id'] = $data['payment']['transactions']['transaction'][0]['info'];
			}
			
			if (!$info = json_decode($iPayData['order_id'], true)){
				echo 'no_info_order_id';
				return false;
			}
			
			$iPayData['order_id'] = $info['order_id'];
			
			
			
			/*
				var_dump($data['payment']['sign']);
				var_dump('TS ' . $data['payment']['timestamp']);
				var_dump('SIGN ' . sha1($data['payment']['timestamp']));
				var_dump(hash_hmac('sha512', $data['payment']['salt'], $this->config->get('ipay_signature')));
				
				if ($data['payment']['sign'] != hash_hmac('sha512', $data['payment']['salt'], $this->config->get('ipay_signature'))){
				return false;
				}
			*/
			
			
			
			return $iPayData;
			
		}
		
		public function index() {
			$data['button_confirm'] = $this->language->get('button_confirm');
			
			$this->load->model('checkout/order');
			
			//	$this->session->data['order_id'] = 114419;

		//	var_dump($this->session->data);
		//	die();
			
			$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
			
			if (!$order_info){
				$this->response->redirect($this->url->link('common/home'), 301);
			}
			
			$salt = sha1(microtime(true));
			$sign = hash_hmac('sha512', $salt, $this->config->get('ipay_signature'));
			
			$xml  = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>';
			$xml .= '	<payment>';
			$xml .= '		<auth>';
			$xml .= '			<mch_id>' . $this->config->get('ipay_merchant') . '</mch_id>';
			$xml .= '			<salt>' . $salt  . '</salt>';
			$xml .= '	 		<sign>' . $sign  . '</sign>';
			$xml .= '		</auth>';
			$xml .= '		<urls>';
			$xml .= '	 		<good>' . $this->url->link('extension/payment/ipay/success_45ceb56eb17feeb038', 'key=' . $this->generateSuccessKey($order_info['order_id']), true)  . '</good>';
			$xml .= '	 		<bad>' .  $this->url->link('extension/payment/ipay/fail', '', true)  . '</bad>';
			$xml .= '		</urls>';
			$xml .= '		<transactions>';
			$xml .= '			<transaction>';
			$xml .= '				<amount>' . $this->currency->format($order_info['total'] * 100, $order_info['currency_code'], $order_info['currency_value'], false) . '</amount>';
			$xml .= '				<currency>' . $order_info['currency_code'] . '</currency>';
			$xml .= '				<desc>' . 'Оплата замовлення №' . $order_info['order_id'] . '</desc>';
			$xml .= '				<info>{"order_id":'. $order_info['order_id'] .'}</info>';
			$xml .= '				<smch_id>' . $this->config->get('ipay_smch_id') . '</smch_id>';
			$xml .= '			</transaction>';	
			$xml .= '		</transactions>';
			$xml .= '		<lifetime>24</lifetime>';
			$xml .= '		<lang>' . $this->getCurrentLanguage() . '</lang>';	
			$xml .= '	</payment>';
			
			//	var_dump($xml);
			
			$result = $this->makeRequest($xml);		
			
			
			if (!$paymentURI = $this->decodeiPayRequestXML($result)){
				return $this->load->view('extension/payment/free_checkout', $data);
				//$this->response->redirect($this->url->link('payment/ipay/fail'), 301);
				} else {
				$data['action'] = $paymentURI;
			}
			
			//	echo  $this->load->view('extension/payment/ipay', $data);
			
			return $this->load->view('extension/payment/ipay', $data);
		}
		
		
		public function success_45ceb56eb17feeb038(){
			
			if (empty($this->session->data['order_id'])){
				echo '!order_id';
				$this->response->redirect($this->url->link('common/home'), 301);
				return false;
			}
			
			if (empty($this->request->get['key'])){
				echo '!key';
				$this->response->redirect($this->url->link('common/home'), 301);
				return false;
			}
			
			if (!$this->validateSuccessKey($this->request->get['key'])){
				echo '!validateSuccessKey';
				$this->response->redirect($this->url->link('common/home'), 301);
				return false;
				
				} else {
				$this->load->model('checkout/order');				
				$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('ipay_order_status_id'));
				$this->response->redirect($this->url->link('checkout/success'));
			}
			
		}
		
		public function fail(){
			
			if (empty($this->session->data['order_id'])){
				$this->response->redirect($this->url->link('common/home'), 301);
				return false;
			}
			
			$this->load->model('checkout/order');				
			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], 10);
			$this->response->redirect($this->url->link('checkout/success'));
			
		}
		
		public function callback() {
			$this->load->model('checkout/order');
			$ipay_log = new Log('ipay_callback.txt');
			$ipay_log->write($this->request);
			
			if (empty($this->request->post['xml'])){
			//	echo '!emptyXML';
				$this->response->redirect($this->url->link('common/home'), 301);
				return false;
			}
			
			if (!$data = $this->decodeiPayCallbackXML(html_entity_decode($this->request->post['xml']))){
			//	echo '!decodeiPayCallbackXML';
				$this->response->redirect($this->url->link('common/home'), 301);
				return false;
			}
			
			if (!$iPayData = $this->validateiPay($data)){
			//	echo '!validateiPay';
				$this->response->redirect($this->url->link('common/home'), 301);
				return false;
			}
			
			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET 
			ipay_id = '" . $this->db->escape($iPayData['payment_id']) . "',
			ipay_amount = '" . $this->db->escape($iPayData['amount']) . "', 
			ipay_xml = '" . $this->db->escape($this->request->post['xml']) . "' WHERE order_id = '" . (int)$iPayData['order_id'] . "'");
						
			if ((int)$iPayData['status'] == 5){
				$order_info = $this->model_checkout_order->getOrder($iPayData['order_id']);

				$this->db->query("UPDATE `oc_order` SET paid = 1 WHERE order_id = '" . (int)$iPayData['order_id'] . "'");
				
				if ($order_info['order_status_id'] != $this->config->get('ipay_order_status_id')){
					$this->model_checkout_order->addOrderHistory($iPayData['order_id'], $this->config->get('ipay_order_status_id'));					
				}
				
				$this->addOrderToQueue($iPayData['order_id']);
			}
		}
		
	}								