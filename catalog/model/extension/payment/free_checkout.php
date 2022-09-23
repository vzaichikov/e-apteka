<?php
class ModelExtensionPaymentFreeCheckout extends Model {
	public function getMethod($address, $total) {
		$this->load->language('extension/payment/free_checkout');
	
		$status = true;
		
		if (!$this->cart->hasShipping()) {
			$status = false;
		}
		

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'free_checkout',
				'title'      => $this->language->get('text_title'),
			//	'terms'      => $this->language->get('text_terms'),				
				'sort_order' => $this->config->get('free_checkout_sort_order')
			);
		}

		return $method_data;
	}
}