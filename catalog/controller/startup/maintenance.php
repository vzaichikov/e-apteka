<?php
class ControllerStartupMaintenance extends Controller {
	public function index() {		
		$this->config->set('config_maintenance',0);

		if ($this->config->get('config_maintenance')) {
			if (isset($this->request->get['route']) && $this->request->get['route'] != 'startup/router') {
				$route = $this->request->get['route'];
			} else {
				$route = $this->config->get('action_default');
			}			
			
			$ignore = array(
				'common/language/language',
				'common/currency/currency'
			);

			$this->user = new Cart\User($this->registry);

			if ((substr($route, 0, 7) != 'payment' && substr($route, 0, 3) != 'api') && !in_array($route, $ignore) && !$this->user->isLogged()) {
				return new Action('common/maintenance');
			}
		}
	}
}
