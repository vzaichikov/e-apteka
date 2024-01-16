<?php
	namespace Cart;
	class Cart {
		private $data = [];
		private $openedStores = [];

		private $enableLogicDeliverFromAny 				= true;
		private $weCanDeliverEvenFromNonStockDrugstores = false;

		private $defaultCityRef 	= '8d5a980d-391c-11dd-90d9-001a92567626';
		private $defaultCityNames 	= ['киев','київ'];
		
		public function __construct($registry) {
			$this->config 	= $registry->get('config');
			$this->customer = $registry->get('customer');
			$this->session 	= $registry->get('session');
			$this->db 		= $registry->get('db');
			$this->log 		= $registry->get('log');
			$this->tax 		= $registry->get('tax');
			$this->weight 	= $registry->get('weight');	

			$query = $this->db->query("SELECT location_id FROM oc_location WHERE temprorary_closed = 0");			

			if ($query->num_rows){
				foreach ($query->rows as $row){
					$this->openedStores[] = $row['location_id'];
				}
			}
			
			if ($this->customer->getId()) {
				// We want to change the session ID on all the old items in the customers cart
				$this->db->query("UPDATE oc_cart SET session_id = '" . $this->db->escape($this->session->getId()) . "' WHERE api_id = '0' AND customer_id = '" . (int)$this->customer->getId() . "'");
				
				// Once the customer is logged in we want to update the customers cart
				$cart_query = $this->db->query("SELECT * FROM oc_cart WHERE api_id = '0' AND customer_id = '0' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
				
				foreach ($cart_query->rows as $cart) {
					$this->db->query("DELETE FROM oc_cart WHERE cart_id = '" . (int)$cart['cart_id'] . "'");
					$this->add($cart['product_id'], $cart['quantity'], json_decode($cart['option']), $cart['recurring_id']);
				}
			}
		}

		public function getOpenedStores(){		
			return $this->openedStores;		
		}
		
		public function getProductIDS() {			
			$data = [];
			foreach ($this->getProducts() as $product){
				$data[] = (int)$product['product_id'];
			}
			
			return $data;		
		}

		public function getIfEnableLogicDeliverFromAny(){
			return $this->enableLogicDeliverFromAny;
		}

		public function getIfWeCanDeliverEvenFromNonStockDrugstores(){
			return $this->weCanDeliverEvenFromNonStockDrugstores;
		}

		public function getDefaultCityRef(){
			return $this->defaultCityRef;
		}

		public function getDefaultCityNames(){
			return $this->defaultCityNames;
		}
		
		public function destroyCurrentLocationID(){
			if (isset($this->session->data['pickup_location_id'])){
				unset($this->session->data['pickup_location_id']);
			}
		}
		
		public function getCurrentLocationID(){			
			if (isset($this->session->data['pickup_location_id'])){
				return $this->session->data['pickup_location_id'];
				} else {
				return false;
			}			
		}
		
		public function getProducts() {
			$product_data = [];
			
			$cart_query = $this->db->query("SELECT * FROM oc_cart WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
			
			foreach ($cart_query->rows as $cart) {						
				
				$stock = true;
				
				$product_query = $this->db->query("SELECT * FROM oc_product_to_store p2s LEFT JOIN oc_product p ON (p2s.product_id = p.product_id) LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id) WHERE p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p2s.product_id = '" . (int)$cart['product_id'] . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");
				
				
				if ($product_query->num_rows && ($cart['quantity'] > 0)) {
					$option_price = 0;
					$option_price_retail = 0;
					$option_points = 0;
					$option_weight = 0;
					
					$option_data = [];
					
					foreach (json_decode($cart['option']) as $product_option_id => $value) {
						$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM oc_product_option po LEFT JOIN `oc_option` o ON (po.option_id = o.option_id) LEFT JOIN oc_option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$cart['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");
						
						if ($option_query->num_rows) {
							if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio') {
								$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_retail, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM oc_product_option_value pov LEFT JOIN oc_option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN oc_option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
								
								if ($option_value_query->num_rows) {
									if ($option_value_query->row['price_prefix'] == '+') {
										$option_price 			+= $option_value_query->row['price'];
										$option_price_retail 	+= $option_value_query->row['price_retail'];
										} elseif ($option_value_query->row['price_prefix'] == '=') {
										$option_price 			= $option_value_query->row['price'];
										$option_price_retail 	= $option_value_query->row['price_retail'];
										} elseif ($option_value_query->row['price_prefix'] == '-') {
										$option_price 			-= $option_value_query->row['price'];
										$option_price_retail 	-= $option_value_query->row['price_retail'];
									}
									
									if ($option_value_query->row['points_prefix'] == '+') {
										$option_points += $option_value_query->row['points'];
										} elseif ($option_value_query->row['points_prefix'] == '=') {
										$option_points = $option_value_query->row['points'];
										} elseif ($option_value_query->row['points_prefix'] == '-') {
										$option_points -= $option_value_query->row['points'];
									}
									
									if ($option_value_query->row['weight_prefix'] == '+') {
										$option_weight += $option_value_query->row['weight'];
										} elseif ($option_value_query->row['weight_prefix'] == '=') {
										$option_weight = $option_value_query->row['weight'];
										} elseif ($option_value_query->row['weight_prefix'] == '-') {
										$option_weight -= $option_value_query->row['weight'];
									}
									
									if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $cart['quantity']))) {
										$stock = false;
									}
									
									$option_data[] = array(
									'product_option_id'       => $product_option_id,
									'product_option_value_id' => $value,
									'option_id'               => $option_query->row['option_id'],
									'option_value_id'         => $option_value_query->row['option_value_id'],
									'name'                    => $option_query->row['name'],
									'value'                   => $option_value_query->row['name'],
									'type'                    => $option_query->row['type'],
									'quantity'                => $option_value_query->row['quantity'],
									'subtract'                => $option_value_query->row['subtract'],
									'price'                   => $option_value_query->row['price'],
									'price_retail'            => $option_value_query->row['price_retail'],
									'price_prefix'            => $option_value_query->row['price_prefix'],
									'points'                  => $option_value_query->row['points'],
									'points_prefix'           => $option_value_query->row['points_prefix'],
									'weight'                  => $option_value_query->row['weight'],
									'weight_prefix'           => $option_value_query->row['weight_prefix']
									);
								}
								} elseif ($option_query->row['type'] == 'checkbox' && is_array($value)) {
								foreach ($value as $product_option_value_id) {
									$option_value_query = $this->db->query("SELECT pov.option_value_id, pov.quantity, pov.subtract, pov.price, pov.price_retail, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix, ovd.name FROM oc_product_option_value pov LEFT JOIN oc_option_value_description ovd ON (pov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
									
										if ($option_value_query->num_rows) {
											if ($option_value_query->row['price_prefix'] == '+') {
											$option_price 			+= $option_value_query->row['price'];
											$option_price_retail 	+= $option_value_query->row['price_retail'];
											} elseif ($option_value_query->row['price_prefix'] == '=') {
											$option_price 			= $option_value_query->row['price'];
											$option_price_retail 	= $option_value_query->row['price_retail'];
											} elseif ($option_value_query->row['price_prefix'] == '-') {
											$option_price 			-= $option_value_query->row['price'];
											$option_price_retail 	-= $option_value_query->row['price_retail'];
										}
										
										if ($option_value_query->row['points_prefix'] == '+') {
											$option_points += $option_value_query->row['points'];
											} elseif ($option_value_query->row['points_prefix'] == '=') {
											$option_points = $option_value_query->row['points'];
											} elseif ($option_value_query->row['points_prefix'] == '-') {
											$option_points -= $option_value_query->row['points'];
										}
										
										if ($option_value_query->row['weight_prefix'] == '+') {
											$option_weight += $option_value_query->row['weight'];
											} elseif ($option_value_query->row['weight_prefix'] == '=') {
											$option_weight = $option_value_query->row['weight'];
											} elseif ($option_value_query->row['weight_prefix'] == '-') {
											$option_weight -= $option_value_query->row['weight'];
										}
										
										if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $cart['quantity']))) {
											$stock = false;
										}
										
										$option_data[] = array(
										'product_option_id'       => $product_option_id,
										'product_option_value_id' => $product_option_value_id,
										'option_id'               => $option_query->row['option_id'],
										'option_value_id'         => $option_value_query->row['option_value_id'],
										'name'                    => $option_query->row['name'],
										'value'                   => $option_value_query->row['name'],
										'type'                    => $option_query->row['type'],
										'quantity'                => $option_value_query->row['quantity'],
										'subtract'                => $option_value_query->row['subtract'],
										'price'                   => $option_value_query->row['price'],
										'price_retail'            => $option_value_query->row['price_retail'],
										'price_prefix'            => $option_value_query->row['price_prefix'],
										'points'                  => $option_value_query->row['points'],
										'points_prefix'           => $option_value_query->row['points_prefix'],
										'weight'                  => $option_value_query->row['weight'],
										'weight_prefix'           => $option_value_query->row['weight_prefix']
										);
									}
								}
								} elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time') {
								$option_data[] = array(
								'product_option_id'       => $product_option_id,
								'product_option_value_id' => '',
								'option_id'               => $option_query->row['option_id'],
								'option_value_id'         => '',
								'name'                    => $option_query->row['name'],
								'value'                   => $value,
								'type'                    => $option_query->row['type'],
								'quantity'                => '',
								'subtract'                => '',
								'price'                   => '',
								'price_prefix'            => '',
								'points'                  => '',
								'points_prefix'           => '',
								'weight'                  => '',
								'weight_prefix'           => ''
								);
							}
						}
					}
					
					$price 			= $product_query->row['price'];
					if ($product_query->row['price_retail'] > 0){
						$price_retail 	= $product_query->row['price_retail'];
					} else {
						$price_retail 	= $product_query->row['price'];
					}	

					$product_special_query = $this->db->query("SELECT price, type FROM oc_product_special WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

					if ($product_special_query->num_rows){
						if ($price_retail > 0){
							$price 			= $price_retail;
						}

						if ($option_price_retail > 0){
							$option_price 	= $option_price_retail;
						}												
					}
					
					if ($option_price){
						$price = $option_price;	
					}
					
					$general_price = false;

					if (isset($this->session->data['shipping_method']) && $this->session->data['shipping_method']['code'] == 'pickup.pickup' && ($cart['location_id'] || !empty($this->session->data['pickup_location_id']))){
						
						$_location_id = $cart['location_id'];
						if (!$_location_id){
							$_location_id = $this->session->data['pickup_location_id'];
						}
						
						$product_location_price_query = $this->db->query("SELECT price, price_retail, price_of_part, price_of_part_retail, quantity FROM oc_stocks WHERE product_id = '" . (int)$cart['product_id'] . "' AND location_id = '" . (int)$_location_id . "'");
						
						if (!empty($option_price)){
							if ((float)$product_location_price_query->row['price_of_part'] > 0){
								$price = $product_location_price_query->row['price_of_part'];	

								if ($product_special_query->num_rows && (float)$product_location_price_query->row['price_of_part_retail'] > 0){
									$price = $product_location_price_query->row['price_of_part_retail'];	
								}						
							}
						} else {
							if ((float)$product_location_price_query->row['price'] > 0){
								$price = $product_location_price_query->row['price'];

								if ($product_special_query->num_rows && (float)$product_location_price_query->row['price_retail'] > 0){
									$price = $product_location_price_query->row['price_retail'];	
								}
							}
						}
					}										
					
					
					// Product Discounts
					$discount_quantity = 0;					
					foreach ($cart_query->rows as $cart_2) {
						if ($cart_2['product_id'] == $cart['product_id']) {
							$discount_quantity += $cart_2['quantity'];
						}
					}
					
					$product_discount_query = $this->db->query("SELECT price FROM oc_product_discount WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
					
					if ($product_discount_query->num_rows) {
						$general_price = $price;
						$price = $product_discount_query->row['price'];						
					}
					
					// Product Specials													
					if ($product_special_query->num_rows) {
						$general_price = $price;
						if ($product_special_query->row['type'] == '%') {
							$price = $price - $price / 100 * $product_special_query->row['price'];
							} else {
							$price = $product_special_query->row['price'];
						}
					}					
					
					//PriceGroup Discounts
					$has_pricegroup_discount = 0;
					if (!$product_special_query->num_rows && $this->config->get('handling_status')) {						
						$pricegroup_query = $this->db->query("SELECT pgtcg.plus, pgtcg.percent FROM oc_product p LEFT JOIN oc_price_group_to_customer_group pgtcg ON pgtcg.pricegroup_id = p.pricegroup_id WHERE p.product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' LIMIT 1");
						
						if ($pricegroup_query->num_rows){
							$general_price = $price;
							if (isset($pricegroup_query->row['percent']) && $pricegroup_query->row['percent']){								
								
								if ($pricegroup_query->row['plus']){									
									$price = $price + ($price / 100 * $pricegroup_query->row['percent'] );									
									} else {
									$has_pricegroup_discount = $has_pricegroup_discount + ($price / 100 * $pricegroup_query->row['percent'] );
									$price = $price - ($price / 100 * $pricegroup_query->row['percent'] );
								}																
							}																					
						}
					}
					
				/*	// Reward Points
					$product_reward_query = $this->db->query("SELECT points FROM oc_product_reward WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");
					
					if ($product_reward_query->num_rows) {
						$reward = $product_reward_query->row['points'];
						} else {
						$reward = 0;
					}
				*/
					$reward = 0;
					
					// Stock
					if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $cart['quantity'])) {
						$stock = false;
					}

					$recurring = false;
					$download_data = [];
										
					$location_query = $this->db->query("SELECT s.location_id, s.price, ld.name as name, l.name as dname FROM oc_stocks s 
					JOIN oc_location l ON s.location_id = l.location_id
					LEFT JOIN oc_location_description ld ON l.location_id = ld.location_id AND language_id = '" . (int)$this->config->get('config_language_id') . "'
					WHERE l.is_stock = 1 AND product_id = '" . (int)$cart['product_id'] . "' AND quantity > 0");
					
					$available_locations = [];
					if ($location_query->num_rows){
						foreach ($location_query->rows as $location){
							$available_locations[] = $location;
						}
					}
					
					if ($cart['location_id']){						
						if ($location_query->num_rows && !$product_special_query->num_rows){							
						}						
					}
					
					//Невозможность доставки и оплаты
					if (!$product_query->row['no_shipping']){
						$query_ns = $this->db->query("SELECT * FROM oc_product_to_category WHERE product_id = '" . (int)$product_query->row['product_id']. "' AND category_id IN (SELECT category_id FROM oc_category WHERE no_shipping = 1)");
						
						if ($query_ns->num_rows){
							$product_query->row['no_shipping'] = true;
						}
					}
					
					if (!$product_query->row['no_payment']){
						$query_ns = $this->db->query("SELECT * FROM oc_product_to_category WHERE product_id = '" . (int)$product_query->row['product_id']. "' AND category_id IN (SELECT category_id FROM oc_category WHERE no_payment = 1)");
						
						if ($query_ns->num_rows){
							$product_query->row['no_payment'] = true;
						}
					}
					
					
					
					$product_data[] = array(
					'cart_id'         => $cart['cart_id'],
					'product_id'      => $product_query->row['product_id'],
					'no_shipping'     => $product_query->row['no_shipping'],
					'is_drug'     	  => $product_query->row['is_drug'],
					'no_payment'      => $product_query->row['no_payment'],
					'is_receipt'      => $product_query->row['is_receipt'],
					'is_thermolabel'  => $product_query->row['is_thermolabel'],
					'location_id'     => $cart['location_id'],
					'available_locations' => $available_locations,
					'name'            => $product_query->row['name'],
					'model'           => $product_query->row['model'],
					'shipping'        => $product_query->row['shipping'],
					'image'           => $product_query->row['image'],
					'option'          => $option_data,
					'download'        => $download_data,
					'quantity'        => $cart['quantity'],
					'is_preorder'     => $product_query->row['is_preorder'],
					'minimum'         => $product_query->row['minimum'],
					'maximum'         => $product_query->row['quantity'],
					'subtract'        => $product_query->row['subtract'],
					'stock'           => $stock,
					'price'           => $price,//($price + $option_price),
					'total'           => ($price) * $cart['quantity'],//($price + $option_price) * $cart['quantity'],
					'general_price'   => $general_price,
					'pricegroup_id'				=>	$product_query->row['pricegroup_id'],
					'has_pricegroup_discount' 	=> $has_pricegroup_discount,
					'reward'          => $reward * $cart['quantity'],
					'points'          => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $cart['quantity'] : 0),
					'tax_class_id'    => $product_query->row['tax_class_id'],
					'weight'          => ($product_query->row['weight'] + $option_weight) * $cart['quantity'],
					'weight_class_id' => $product_query->row['weight_class_id'],
					'length'          => $product_query->row['length'],
					'width'           => $product_query->row['width'],
					'height'          => $product_query->row['height'],
					'length_class_id' => $product_query->row['length_class_id'],
					'recurring'       => $recurring
					);				
					
					} else {
					$this->remove($cart['cart_id']);
				}
			}
			
			return $product_data;
		}
		
		public function add($product_id, $quantity = 1, $option = array(), $recurring_id = 0, $location_id = 0) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM oc_cart WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND product_id = '" . (int)$product_id . "' AND recurring_id = '" . (int)$recurring_id . "' AND `option` = '" . $this->db->escape(json_encode($option)) . "'");
			
			if (!$query->row['total']) {
				$this->db->query("INSERT oc_cart SET api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "', customer_id = '" . (int)$this->customer->getId() . "', session_id = '" . $this->db->escape($this->session->getId()) . "', product_id = '" . (int)$product_id . "', recurring_id = '" . (int)$recurring_id . "', location_id = '" . (int)$location_id . "', `option` = '" . $this->db->escape(json_encode($option)) . "', quantity = '" . (int)$quantity . "', date_added = NOW()");
				} else {
				$this->db->query("UPDATE oc_cart SET quantity = (quantity + " . (int)$quantity . "), location_id = '" . (int)$location_id . "' WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND product_id = '" . (int)$product_id . "' AND recurring_id = '" . (int)$recurring_id . "' AND `option` = '" . $this->db->escape(json_encode($option)) . "'");
			}
		}
		
		public function guessCurrentLocationsAvailableForPickup(){
			$location_data = []; 
			$available_locations = [];
			$maxprice = 0;
			$cart_id = 0;

			return $available_locations;
			
			foreach ($this->getProducts() as $value) {
				if ($value['price'] > $maxprice){
					$maxprice = $value['price'];
					$cart_id = $value['cart_id'];
				}
			}
			
			unset($value);
			foreach ($this->getProducts() as $value) {
				if ($value['cart_id'] == $cart_id){
					
					$location_query = $this->db->query("SELECT s.location_id, s.price 
					FROM oc_stocks s 
					JOIN oc_location l ON s.location_id = l.location_id						
					WHERE l.is_stock = 1 AND l.temprorary_closed = 0 AND product_id = '" . (int)$value['product_id'] . "' AND quantity > 0");
					
					if ($location_query->num_rows){
						foreach ($location_query->rows as $location){
							$available_locations[] = $location['location_id'];
						}
					}
					
					break;
				}
			}
			
			return $available_locations;		
		}

		public function getIfOneLocationIsCurrentlyAvailableForPickup($location_id, $overloadLogicToDeliverFromAny = false){
			if ($this->enableLogicDeliverFromAny && $overloadLogicToDeliverFromAny){
				return true;
			}

			$locations = $this->getCurrentLocationsAvailableForPickup([], true, false);

			return in_array($location_id, $locations);
		}

		public function getIfCartIsOnlyInStockInDrugstoresWhichCanNotSendNP(){		
			$products = $this->getProducts();
			
			foreach ($products as $value){
				if (!$this->getIfProductIsOnStockInDrugstoresWhichCanNotSendNP($value['product_id'], $value['quantity'])){
					return false;
				}
			}
			
			return true;
		}

		public function getIfCartIsOnStockInDrugstoresWhichCanSendNP(){		
			$products = $this->getProducts();
			
			foreach ($products as $value){
				if (!$this->getIfProductIsOnStockInDrugstoresWhichCanSendNP($value['product_id'], $value['quantity'])){
					return false;
				}
			}
			
			return true;
		}

		public function getIfProductIsOnStockInDrugstoresWhichCanSendNP($product_id, $quantity = 0){		
			$sql = "SELECT s.*, 
			l.location_id
			FROM oc_stocks s
			LEFT JOIN oc_location l ON s.location_id = l.location_id 			
			WHERE s.product_id = '" . (int)$product_id . "' AND s.quantity ";

			if ($quantity > 0) {
				$sql .= " >= "; 
			} else {
				$sql .= " > ";
			}

			$sql .= "'" . (int)$quantity . "' AND l.can_send_np = 1";


			$query = $this->db->ncquery($sql);

			return $query->num_rows;
		}

		public function getIfProductIsOnStockInDrugstoresWhichCanNotSendNP($product_id, $quantity = 0){		
			$sql = "SELECT s.*, 
			l.location_id
			FROM oc_stocks s
			LEFT JOIN oc_location l ON s.location_id = l.location_id 			
			WHERE s.product_id = '" . (int)$product_id . "' AND s.quantity ";

			if ($quantity > 0) {
				$sql .= " >= "; 
			} else {
				$sql .= " > ";
			}

			$sql .= "'" . (int)$quantity . "' AND l.can_send_np = 0";


			$query = $this->db->ncquery($sql);

			return $query->num_rows;
		}
		
		public function getCurrentLocationsAvailableForPickup($address = []){
			$location_data 			= []; 
			$available_locations 	= [];
			$first_time = true;
			
			foreach ($this->getProducts() as $value) {				
				$product_available_locations = [];

				$sql = "SELECT s.location_id, s.price, l.can_sell_drugs,  l.can_free_stocks, p.is_drug, p.is_pko
				FROM oc_stocks s 
				JOIN oc_location l ON s.location_id = l.location_id
				LEFT JOIN oc_product p ON s.product_id = p.product_id				
				WHERE 
				l.is_stock = 1";

				if (!empty($address) && (!empty($address['novaposhta_city_guid']) || !empty($address['city']))){
					if (!empty($address['novaposhta_city_guid']) && !empty($address['city'])){
						$sql .= " AND ( ";
						$sql .= " l.city_id = '" . $this->db->escape($address['novaposhta_city_guid']) . "' OR LOWER(l.city) = '" . $this->db->escape(mb_strtolower($address['city'])) . "'";

						if (in_array(mb_strtolower($address['city']), $this->defaultCityNames) || $address['novaposhta_city_guid'] == $this->defaultCityRef){
							$sql .= " OR LOWER(l.address) LIKE '%київська обл.%' ";
						}

						$sql .= " ) ";	
					} elseif (!empty($address['novaposhta_city_guid']) && empty($address['city'])){
						$sql .= " AND ( ";
						$sql .= " l.city_id = '" . $this->db->escape($address['novaposhta_city_guid']) . "'";

						if ($address['novaposhta_city_guid'] == $this->defaultCityRef){
							$sql .= " OR LOWER(l.address) LIKE '%київська обл.%' ";
						}

						$sql .= " ) ";	
					} elseif (empty($address['novaposhta_city_guid']) && !empty($address['city'])){
						$sql .= " AND ( ";
						$sql .= " LOWER(l.city) = '" . $this->db->escape(mb_strtolower($address['city'])) . "'";

						if (in_array(mb_strtolower($address['city']), $this->defaultCityNames)){
							$sql .= " OR LOWER(l.address) LIKE '%київська обл.%' ";
						}

						$sql .= " ) ";		
					}					
				}			

				$sql .= " AND l.temprorary_closed = 0 
				AND s.product_id = '" . (int)$value['product_id'] . "' 
				AND (s.quantity >= '" . $value['quantity'] . "')";	

				$location_query = $this->db->query($sql);	

				if ($location_query->num_rows){
					foreach ($location_query->rows as $location){
						if ($location['is_drug'] && !$location['can_sell_drugs']){
							continue;
						}
						$product_available_locations[] = $location['location_id'];
					}
				}									
				
				if ($first_time){
					$available_locations = $product_available_locations;
					} else {
					$available_locations = array_intersect($available_locations, $product_available_locations);
				}			
				
				$first_time = false;			
			}
									
			return $available_locations;
		}

		public function getIfCartHasNarcoticDrugs(){
			$products = $this->getProducts();
			
			foreach ($products as $value){
				if (!empty($value['is_drug'])){
					return true;
				}
			}
			
			return false;
		}
		
		public function getIfCartHasDrugs(){
			$products = $this->getProducts();
			
			foreach ($products as $value){
				$query = $this->db->query("SELECT * FROM oc_product_to_category WHERE product_id = '" . (int)$value['product_id']. "' AND category_id IN (SELECT category_id FROM oc_category_path WHERE path_id = 169)");
				
				if ($query->num_rows){
					return true;
				}
			}
			
			return false;
		}

		public function getIfCartHasPreorder(){
			$products = $this->getProducts();
			
			foreach ($products as $value){
				if (!empty($value['is_preorder'])){
					return true;
				}
			}
			
			return false;
		}
		
		public function getIfCartHasReceipt(){
			$products = $this->getProducts();
			
			unset($value);
			foreach ($products as $value) {
			
				//Check if is vaccine
			//	$query = $this->db->query("SELECT * FROM oc_product_to_category WHERE product_id = '" . (int)$value['product_id']. "' AND category_id = 62");								
			
				if ($value['is_receipt'] /* && !$query->num_rows */){
					return true;
				}
			}
			
			
			return false;			
		}
		
		public function getIfShippingIsPossible(){
			$products = $this->getProducts();
			
			foreach ($products as $value) {
				if ($value['no_shipping']){
					return false;
				}
			}
			
			foreach ($products as $value) {
				if ($value['is_receipt'] /*  && !$this->validateElectronicReceipt() */){
				//	return false;
				}
			}
			
			unset($value);
			foreach ($products as $value){
				$query = $this->db->query("SELECT * FROM oc_product_to_category WHERE product_id = '" . (int)$value['product_id']. "' AND category_id IN (SELECT category_id FROM oc_category WHERE no_shipping = 1)");
				
				if ($query->num_rows){
					return false;
				}
			}
			
			
			return true;			
		}
		
		
		//Проверка на наличие электронного рецепта, теперь эта птичка НИЧЕГО НЕ ЗНАЧИТ
		public function validateElectronicReceipt(){
			return true;				
			$data = $this->session->data;
		
			if (!empty($data['simple'])){
				
				if (!empty($data['simple']['customer'])){
					
					if (!empty($data['simple']['customer']['has_e_receipt'])){
						
						if (!empty($data['simple']['customer']['has_e_receipt'][1])){
							return true;
						}
					
					}
				
				}				
			}	
			return false;		
		}
		
		public function getIfPaymentIsPossible(){
			$products = $this->getProducts();
			
			foreach ($products as $value) {
				if ($value['no_payment']){
					return false;
				}
			}		
			
			if ($_SERVER['REMOTE_ADDR'] == '185.41.249.201'){
		//		print("<pre>".print_r($this->session->data,true)."</pre>");
			}
			
			foreach ($products as $value) {
				if ($value['is_receipt'] /* && !$this->validateElectronicReceipt() */){
					//return false;
				}
			}
			
			unset($value);
			foreach ($products as $value){
				$query = $this->db->query("SELECT * FROM oc_product_to_category WHERE product_id = '" . (int)$value['product_id']. "' AND category_id IN (SELECT category_id FROM oc_category WHERE no_payment = 1)");
				
				if ($query->num_rows){
					return false;
				}
			}
			
			return true;
			
			
		}
		
		public function update($cart_id, $quantity, $location_id = 0) {
			$this->db->query("UPDATE oc_cart SET quantity = '" . (int)$quantity . "', location_id = '" . (int)$location_id . "' WHERE cart_id = '" . (int)$cart_id . "' AND api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
		}
		
		public function remove($cart_id) {
			$this->db->query("DELETE FROM oc_cart WHERE cart_id = '" . (int)$cart_id . "' AND api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
		}
		
		public function clear() {
			$this->db->query("DELETE FROM oc_cart WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
		}
		
		public function getRecurringProducts() {
			$product_data = [];
			
			foreach ($this->getProducts() as $value) {
				if ($value['recurring']) {
					$product_data[] = $value;
				}
			}
			
			return $product_data;
		}
		
		public function getWeight() {
			$weight = 0;
			
			foreach ($this->getProducts() as $product) {
				if ($product['shipping']) {
					$weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('config_weight_class_id'));
				}
			}
			
			return $weight;
		}
		
		public function getSubTotal() {
			$total = 0;
			
			foreach ($this->getProducts() as $product) {
				$total += $product['total'];
			}
			
			return $total;
		}
		
		public function getTaxes() {
			$tax_data = [];
			
			foreach ($this->getProducts() as $product) {
				if ($product['tax_class_id']) {
					$tax_rates = $this->tax->getRates($product['price'], $product['tax_class_id']);
					
					foreach ($tax_rates as $tax_rate) {
						if (!isset($tax_data[$tax_rate['tax_rate_id']])) {
							$tax_data[$tax_rate['tax_rate_id']] = ($tax_rate['amount'] * $product['quantity']);
							} else {
							$tax_data[$tax_rate['tax_rate_id']] += ($tax_rate['amount'] * $product['quantity']);
						}
					}
				}
			}
			
			return $tax_data;
		}
		
		public function getTotal() {
			$total = 0;
			
			foreach ($this->getProducts() as $product) {
				$total += $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'];
			}
			
			return $total;
		}
		
		public function countProducts() {
			$product_total = 0;
			
			$products = $this->getProducts();
			
			foreach ($products as $product) {
				$product_total += $product['quantity'];
			}
			
			return $product_total;
		}
		
		public function hasProducts() {
			return count($this->getProducts());
		}
		
		public function hasRecurringProducts() {
			return count($this->getRecurringProducts());
		}
		
		public function hasStock() {
			foreach ($this->getProducts() as $product) {
				if (!$product['stock']) {
					return false;
				}
			}
			
			return true;
		}

		public function hasPriceGroups($pricegroups) {
			foreach ($this->getProducts() as $product) {
				if (in_array($product['pricegroup_id'], $pricegroups)) {
					return true;
				}
			}
			
			return false;
		}
		
		
		public function hasShipping() {
			foreach ($this->getProducts() as $product) {
				if ($product['shipping']) {
					return true;
				}
			}
			
			return false;
		}
		
		public function hasDownload() {
			foreach ($this->getProducts() as $product) {
				if ($product['download']) {
					return true;
				}
			}
			
			return false;
		}
	}
