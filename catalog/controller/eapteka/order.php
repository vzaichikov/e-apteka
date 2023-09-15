<?php
class ControllerEaptekaOrder extends Controller
{		
	public function index()
	{ }

	public function test(){			
		error_reporting(true);
		ini_set('display_errors', true);

		require_once(DIR_SYSTEM . '../rest-api/models/hoboModel.php');
		require_once(DIR_SYSTEM . '../rest-api/models/hoboModelOrder.php');

		$hoboModelOrder = new \hobotix\hoboModelOrder($this->db);
		$json = $hoboModelOrder->getOrderJSON(172553, 'return');

		$this->log->debug($json);
	}

	public function addOrderToQueue(&$route = '', &$input_data = array(), &$output = null){
		$this->load->model('checkout/order');
		$this->load->model('account/order');
		$this->load->model('catalog/product');
		$this->load->model('localisation/location');
		$this->load->model('tool/simplecustom');  

		$order_id = (isset($input_data[0]) && is_int($input_data[0]) && $input_data[0]) ? $input_data[0] : false;

		$redirect = true;
		if (isset($input_data[5]) && $input_data[5] == false){
			$redirect = false;	
		}

		if ($order_id) {
			require_once(DIR_SYSTEM . '../rest-api/models/hoboModel.php');
			require_once(DIR_SYSTEM . '../rest-api/models/hoboModelOrder.php');

			$hoboModelOrder = new \hobotix\hoboModelOrder($this->db);
			$json = $hoboModelOrder->getOrderJSON($order_id, 'queue');

			if ($redirect){
				$this->response->redirect($this->url->link('checkout/success'));
			}
		}
	}
}
