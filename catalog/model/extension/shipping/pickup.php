<?php
	class ModelExtensionShippingPickup extends Model {
		function getQuote($address) {
			$this->load->language('extension/shipping/pickup');
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('pickup_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
			
			if (!$this->config->get('pickup_geo_zone_id')) {
				$status = true;
				} elseif ($query->num_rows) {
				$status = true;
				} else {
				$status = false;
			}
			
			$method_data = array();
			
			if ($status == true && (!empty($address['novaposhta_city_guid'] || !empty($address['city'])))){
				
				if (!empty($address['novaposhta_city_guid'])){
					if ($address['novaposhta_city_guid'] != '8d5a980d-391c-11dd-90d9-001a92567626'){
						$status = false;
					}			
				} elseif (!empty($address['city'])){
					if (!in_array(trim(mb_strtolower($address['city'])), array('киев','київ'))){
						$status = false;
					}
				}
			}
			
			// $locations = $this->cart->getCurrentLocationsAvailableForPickup();			
			 $dummy = false;

			// $text_danger = '';
			// if (!$locations){
			// 	$text_danger = $this->language->get('text_alert_no_locations_1');
			// 	$dummy = true;
			// } else {
			// 	$text_danger = $this->language->get('text_pickup_danger');
			// }
			
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
				'text'         => $this->language->get('free_price')//$this->currency->format(0.00, $this->session->data['currency'])
			);
			
			$method_data = array(
			'code'       => 'pickup',
			'title'      => '', //$this->language->get('text_title'),
			'quote'      => $quote_data,
			'sort_order' => $this->config->get('pickup_sort_order'),
			'error'      => false
			);
			}
			
			return $method_data;
			}
		}		