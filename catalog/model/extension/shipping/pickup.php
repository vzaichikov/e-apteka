<?php
class ModelExtensionShippingPickup extends Model {
	function getQuote($address) {
		$this->load->language('extension/shipping/pickup');
		$this->load->model('localisation/location');
		$this->load->model('tool/simpleapicustom');
		
		$query = $this->db->query("SELECT * FROM oc_zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('pickup_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		
		if (!$this->config->get('pickup_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$status = false;
		
		$method_data = array();				

		if (!$status && !empty($address['novaposhta_city_guid'])){
			if ($this->model_tool_simpleapicustom->getCurrentLocationsAvailableForPickup($address['novaposhta_city_guid'])){
				$status = true;
			}
		}
		
		if (!$this->cart->getIfEnableLogicDeliverFromAny()){			
			$text_danger = '';
			if (!$locations){
				$text_danger = $this->language->get('text_alert_no_locations_1');
				$dummy = true;
			} else {
				$text_danger = $this->language->get('text_pickup_danger');
			}
		} else {
			$dummy = false;
		}
		
		if ($status) {
			$quote_data = array();
			
			$quote_data['pickup'] = array(
				'code'         => 'pickup.pickup',
				'title'        => $this->language->get('text_description'),
				'terms'        => $this->language->get('text_terms'),
				'dummy'		   => $dummy,
				'cost'         => 0.00,
				'tax_class_id' => 0,
				'text_danger'  => $text_danger,
				'text'         => $this->language->get('free_price')
			);
			
			$method_data = array(
				'code'       => 'pickup',
				'title'      => '',
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('pickup_sort_order'),
				'error'      => false
			);
		}
		
		return $method_data;
	}
}		