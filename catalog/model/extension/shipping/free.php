<?php
class ModelExtensionShippingFree extends Model {
	function getQuote($address) {
		$this->load->language('extension/shipping/free');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('free_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if (!$this->config->get('free_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		if ($this->cart->getSubTotal() < $this->config->get('free_total')) {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$quote_data = array();

			$text_terms = $this->language->get('text_terms');
			$text_terms = str_replace('config_free_shipping', $this->config->get('config_free_shipping'), $text_terms);
			
			$quote_data['free'] = array(
				'code'         => 'free.free',
				'title'        => $this->language->get('text_description'),
			//	'terms'        => $text_terms,
				'cost'         => 0.00,
				'tax_class_id' => 0,
				'text'         => $text_terms, //$this->language->get('free_price')//$this->currency->format(0.00, $this->session->data['currency'])
			);

			$method_data = array(
				'code'       => 'free',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('free_sort_order'),
				'error'      => false
			);
		}

		return $method_data;
	}
}