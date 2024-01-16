<?php
class ModelExtensionPaymentiPay extends Model {
	public function getMethod($address, $total) {
		$this->load->language('extension/payment/ipay');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('ipay_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('ipay_total') > 0 && $this->config->get('ipay_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('ipay_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}			

		$description = $this->language->get('text_description');
		$text_danger = '';
		$dummy		 = false;
		
		if (!$this->cart->getIfPaymentIsPossible()){
			$status 		= true;
			$dummy  		= true;
			$description    = '';
			$text_danger 	= $this->language->get('ipay_text_danger');
		}

		if (!empty($this->session->data['shipping_method']) && !empty($this->session->data['shipping_method']['code']) && $this->session->data['shipping_method']['code'] == 'pickup.pickup'){
			if (!$this->cart->getCurrentLocationsAvailableForPickup($address)){
				$status = false;
				$dummy  = true;
			}			
		}		

		if (!$this->cart->getIfCartIsOnStockInDrugstoresWhichCanSendNP()){	
			if (!$this->cart->getIfCartIsOnlyInStockInDrugstoresWhichCanNotSendNP()){
				$status = false;
				$dummy  = true;
			}		
		}		

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       	=> 'ipay',
				'title'      	=> $this->language->get('text_title'),
				'description'	=> $description,
				'text_danger' 	=> $text_danger,
				'dummy'			=> $dummy,
				'terms'      	=> '',
				'sort_order' 	=> $dummy?499:$this->config->get('ipay_sort_order')
			);
		}

		return $method_data;
	}
}