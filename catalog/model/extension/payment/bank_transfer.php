<?php
class ModelExtensionPaymentBankTransfer extends Model {
	public function getMethod($address, $total) {
		$this->load->language('extension/payment/bank_transfer');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('bank_transfer_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('bank_transfer_total') > 0 && $this->config->get('bank_transfer_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('bank_transfer_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();
		
		$description = $this->language->get('text_description');
		$text_danger = '';
		$dummy		 = false;
		
		if (!$this->cart->getIfPaymentIsPossible()){
			$status 		= true;
			$dummy  		= true;
			$description    = '';
			$text_danger 	= $this->language->get('bank_transfer_text_danger');
		}

		if ($status) {
			$method_data = array(
				'code'       => 'bank_transfer',
				'title'      => $this->language->get('text_title'),
				'description'	=> $description,
				'text_danger' 	=> $text_danger,
				'dummy'			=> $dummy,
				'terms'      => '',
				'sort_order' => $dummy?500:$this->config->get('bank_transfer_sort_order')
			);
		}

		return $method_data;
	}
}