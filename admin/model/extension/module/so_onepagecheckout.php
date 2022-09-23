<?php

class ModelExtensionModuleSoOnepageCheckout extends Model {
	
	public function getModuleId() {
		$sql = " SHOW TABLE STATUS LIKE '" . DB_PREFIX . "module'" ;
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getPaymentMethods(){
		if(VERSION >= '2.3.0.0'){
			$payment_methods = glob(DIR_APPLICATION . 'controller/extension/payment/*.php');
		} else {
			$payment_methods = glob(DIR_APPLICATION . 'controller/payment/*.php');
		}
		$result = array();
		foreach ($payment_methods as $payment){
			$payment = basename($payment, '.php');
			if(VERSION >= '2.3.0.0'){
				$this->load->language('extension/payment/' . $payment);
			} else {
				$this->load->language('payment/' . $payment);
			}
			$payment_status = $this->config->get($payment.'_status');
			if(isset($payment_status)){
				$result[] = array(
					'status' => $this->config->get($payment . '_status'),
					'code' => $payment,
					'title' => $this->language->get('heading_title')
				);
			}
		}
		return $result;
	}

	public function getShippingMethods() {
		if(VERSION >= '2.3.0.0'){
			$shipping_methods = glob(DIR_APPLICATION . 'controller/extension/shipping/*.php');
		} else {
			$shipping_methods = glob(DIR_APPLICATION . 'controller/shipping/*.php');
		}
		$result = array();
		foreach ($shipping_methods as $shipping){
			$shipping = basename($shipping, '.php');
			if(VERSION >= '2.3.0.0'){
				$this->load->language('extension/shipping/' . $shipping);
			} else {
				$this->load->language('shipping/' . $shipping);
			}
			$shipping_status = $this->config->get($shipping.'_status');
			if(isset($shipping_status)){
				$result[] = array(
					'status' => $this->config->get($shipping . '_status'),
					'code' => $shipping,
					'title' => $this->language->get('heading_title')
				);
			}
		}
		return $result;
	}
}
?>