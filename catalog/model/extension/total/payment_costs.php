<?php
class ModelExtensionTotalPaymentCosts extends Model {
	public function getTotal($total) {
		$payment_costs_config = $this->config->get('payment_costs');
		if ($this->config->get('payment_costs_status') && $payment_costs_config && isset($this->session->data['payment_method']) && isset($payment_costs_config[$this->session->data['payment_method']['code']]) && $payment_costs_config[$this->session->data['payment_method']['code']]>0) {

			$comission = ($total['total'] * $payment_costs_config[$this->session->data['payment_method']['code']])/100;
			$total['totals'][] = array(
				'code'       => 'payment_costs',
				'title'      => $this->session->data['payment_method']['title_simple'].' (+'.$payment_costs_config[$this->session->data['payment_method']['code']].'%)',
				'value'      => $comission,
				'sort_order' => $this->config->get('payment_costs_sort_order')
			);

			$total['total'] += $comission;
		}
	}
}