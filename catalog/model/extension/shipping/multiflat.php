<?php
	class ModelExtensionShippingMultiFlat extends Model {
		private $weCanDeliverEvenFromNonStockDrugstores = true;

		function getQuote($address) {
			$status = false;
			$multiflats = $this->config->get('multiflat');
			$this->load->language('extension/shipping/multiflat');
			$this->load->model('tool/simpleapicustom');
			
			foreach ($multiflats as $i => $flat) {
				if (!$flat['status']) {
					continue;
				}
				
				if (!$flat['geo_zone_id']) {
					$status = true;
					} else {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$flat['geo_zone_id'] . "'" . " AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
					if ($query->num_rows) {
						$status = true;
						} else {
						$multiflats[$i]['status'] = false;
					}
				}
				
				if ($multiflats[$i]['status']== true && (!empty($address['novaposhta_city_guid'] || !empty($address['city'])))){
					
					if (!empty($address['novaposhta_city_guid'])){
						if ($address['novaposhta_city_guid'] != $this->cart->getDefaultCityRef()){
							$multiflats[$i]['status'] = false;
						}			
						} elseif (!empty($address['city'])){
						if (!in_array(trim(mb_strtolower($address['city'])), $this->cart->getDefaultCityNames())){
							$multiflats[$i]['status'] = false;
						}
					}
				}
				
			}
			
			$method_data = array();
			
			//$cart_weight = $this->cart->getWeight();
			$cart_total = $this->cart->getTotal();		
			
			if ($status) {
				$quote_data = array();
				$sort_order = array();
				
				foreach ($multiflats as $i => $flat) {
					if (!$flat['status']) {
						continue;
					}
					
					if (!empty($flat['is_delivery'])) {
						if (!$this->cart->getIfShippingIsPossible()){
							continue;
						}
					}

					$dummy = false;
													
					$cost = $flat['cost'];
					$text = $this->currency->format($cost, $this->session->data['currency']);
					$text_free_info = '';
					$text_warning = '';
					
					if (!empty($flat['free_from'])) {
						$text_free_info = sprintf($this->language->get('text_free_info_from'), $this->currency->format($flat['free_from'], $this->session->data['currency']));
					}									
					
					if (!empty($flat['free_from']) && $cart_total > $flat['free_from']){
						$cost = 0;
						$text_free_info = '';
						$text = $this->language->get('free_price');						
					}
					
					$excluded_cat = false;				
					if ($flat['category_id']){
						
						$product_sql = '(product_id = 1 ';
						foreach ($this->cart->getProductIDS() as $product_id){
							$product_sql .= " OR product_id = '" . (int)$product_id . "'";
						}
						$product_sql .= ')';
						
						$check_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$flat['category_id'] . "' AND " . $product_sql);
						
						$excluded_cat = $check_query->num_rows;
					}
					
					if ($excluded_cat){
						
						if (!$cost){
							$this->load->model('catalog/category');
							$text_warning = sprintf($this->language->get('text_shipping_overprice_alert'), $this->model_catalog_category->getCategory($flat['category_id'])['name'], $this->currency->format($flat['category_cost'], $this->session->data['currency']));
						}
						
						$cost = $flat['category_cost'];
						$text = $this->currency->format($cost, $this->session->data['currency']);
						
						
						$text_free_info = '';
					}

					$text_danger 	= false;
					$text_danger2 	= false;
					$text_info 		= $this->language->get('text_info_' . $i);
					
					if ($i == 0){
						$locations = $this->cart->getCurrentLocationsAvailableForPickup($address);
						$rightSide = in_array(7, $locations);
						$leftSide =  in_array(6, $locations);
					} 

					if ($i == 1) {
						$rightSide = $this->cart->getIfOneLocationIsCurrentlyAvailableForPickup(7);
						$leftSide =  $this->cart->getIfOneLocationIsCurrentlyAvailableForPickup(6);	
					}

					/*
					Если мы можем доставлять даже при отсутствии в любой аптеке
					*/
					if ($this->weCanDeliverEvenFromNonStockDrugstores){
					
						//	Первый способ - обычная курьерская доставка						
						if ($i == 0){

						//	Нет ни в 4, ни в 5 аптеках, нам нужно время чтоб собрать
							if (!$rightSide && !$leftSide){
								$text_info   = '';
								$text_info = $this->language->get('text_defer_both');
							}

						//Нету в 5, но есть в 4
							if (!$rightSide && $leftSide){
								$text_info = $this->language->get('text_defer_right_riverside');
							}

						//Нету в 4, но есть в 5
							if ($rightSide && !$leftSide) {
								$text_info = $this->language->get('text_defer_left_riverside');
							}
						}

						 
						//Экспресс-доставка, мы можем доставлять ВСЕ ТОВАРЫ только по конкретному берегу, либо вообще не доставлять, если нет в наличии в 4 и 5 всех вместе						
						if ($i == 1){							
							//	Нет ни в 4, ни в 5 аптеках, отключаем
							if (!$rightSide && !$leftSide){
							//	$text_danger2 = $this->language->get('text_danger_nosides');
								$dummy = true;
							}

							if ($rightSide && !$leftSide){
								$text_danger2 = $this->language->get('text_danger_rightSide');
							}

							if (!$rightSide && $leftSide){
								$text_danger2 = $this->language->get('text_danger_leftSide');
							}
						}
					}

					if (!empty($flat['min']) && $cart_total <= $flat['min']) {
						$dummy = true;
						$text_danger2 = ($this->language->get('text_danger_min_price') . $this->currency->format($flat['min'], $this->session->data['currency']));
					};

					if (!empty($flat['max']) && $cart_total > $flat['max']) continue;

					if ($i == 1){
						if (!$this->model_tool_simpleapicustom->getIfExpressDeliveryIsAvailableByTime()){
							$dummy = true;

							if ($text_danger2){
								$text_danger2 .= '<br />';
							}
							$text_danger2 .= $this->language->get('text_danger_express_bytime');
						}
					}				

					if ($dummy){
						$text_info = false;
					}
					
					$quote_data['multiflat' . $i] = array(
					'code'         		=> 'multiflat.multiflat' . $i,
					'title'        		=> $flat['name'],
					'cost'         		=> $cost,
					'dummy'         	=> $dummy,
					'tax_class_id' 		=> $flat['tax_class_id'],
					'text'         		=> $text,				
					'text_free_info' 	=> $text_free_info,
					'text_info' 		=> $text_info,
					'text_warning' 		=> $text_warning,
					'text_danger' 		=> $text_danger,
					'text_danger2'		=> $text_danger2,
                    'category_id'  => (isset($flat['category_id']) && !empty($flat['category_id'])) ? $flat['category_id'] : null,
					);
					
					$sort_order[$i] = $flat['sort_order'];
				}
				
				array_multisort($sort_order, SORT_ASC, $quote_data);

				$text_danger 	= false;
				$text_info 		= false;

				if (!$this->weCanDeliverEvenFromNonStockDrugstores) {					
					$text_info 		= $this->language->get('text_info_all');

					if ($rightSide && !$leftSide){
						$text_danger = $this->language->get('text_danger_rightSide');
					}

					if (!$rightSide && $leftSide){
						$text_danger = $this->language->get('text_danger_leftSide');
					}

					if (!$rightSide && !$leftSide){
						$text_danger = $this->language->get('text_danger_nosides');
					}
				}
				
				$method_data = array(
				'code'       		=> 'multiflat',
				'title'      		=> $this->language->get('multiflat_title'),
				'text_info'	 		=> $text_info,
				'text_danger' 		=> $text_danger,
				'quote'      		=> $quote_data,
				'sort_order' 		=> $this->config->get('multiflat_sort_order'),
				'error'      		=> false
				);
				
			}
			
			return $method_data;
		}
	}				