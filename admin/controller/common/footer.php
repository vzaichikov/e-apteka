<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

		$data['text_footer'] = $this->language->get('text_footer');

		if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
			$data['text_version'] = sprintf($this->language->get('text_version'), VERSION);
		} else {
			$data['text_version'] = '';
		}
		
		if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
			$data['text_ea_version'] = sprintf($this->language->get('text_ea_version'), EAPTEKA_VERSION);
		} else {
			$data['text_ea_version'] = '';
		}
		
		$data['token'] = $this->session->data['token'];
		$data['is_logged'] = $this->user->isLogged();
		$data['pbx_extension'] = $this->user->getIPBX();
		
		return $this->load->view('common/footer', $data);
	}
}
