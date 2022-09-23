<?php
	class ModelExtensionTotalHandling extends Model {
		public function getTotal($total) {
			if ($this->cart->getProducts()) {
				$this->load->language('extension/total/handling');
				
				$_total = 0;
				foreach ($this->cart->getProducts() as $product){
				
					if ($product['has_pricegroup_discount']){
						$_total += $product['has_pricegroup_discount'] * $product['quantity'];
					}							
				}
				
			
				
				if ($_total) {
					
					$total['totals'][] = array(
					'code'       => 'handling',
					'title'      => $this->language->get('text_handling'),
					'value'      => $_total,
					'sort_order' => $this->config->get('handling_sort_order')
					);
					
				}
				
			}
		}
	}	