<?php
class ControllerExtensionModulePopUpCart extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('extension/module/popupcart');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));
		
		$this->load->model('setting/setting');
		
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if ($this->request->post['apply']) {
				$url = $this->url->link('extension/module/popupcart', 'token=' . $this->session->data['token'], true);
			} else {
				$url = $this->url->link('extension/extension', 'token='.$this->session->data['token'].'&type=module', true);
			}
			
			unset($this->request->post['apply']);
			$this->model_setting_setting->editSetting('popupcart', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($url);
		}
				
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_module'] = $this->language->get('text_module');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['text_head'] = $this->language->get('text_head');
		$data['text_button_name_shopping'] = $this->language->get('text_button_name_shopping');
		$data['text_button_name_shopping_show'] = $this->language->get('text_button_name_shopping_show');
		$data['text_button_name_checkout'] = $this->language->get('text_button_name_checkout');
		$data['text_button_name_cart'] = $this->language->get('text_button_name_cart');
		$data['text_button_name_cart_show'] = $this->language->get('text_button_name_cart_show');
		$data['text_manufacturer_show'] = $this->language->get('text_manufacturer_show');
		$data['text_addtocart_logic'] = $this->language->get('text_addtocart_logic');
		$data['text_button_name_default'] = $this->language->get('text_button_name_default');
		$data['text_click_on_cart'] = $this->language->get('text_click_on_cart');
		$data['text_related_show'] = $this->language->get('text_related_show');
		$data['text_related_heading'] = $this->language->get('text_related_heading');
		$data['text_related_product'] = $this->language->get('text_related_product');
		$data['text_related_product0'] = $this->language->get('text_related_product0');
		$data['text_related_product1'] = $this->language->get('text_related_product1');
		$data['text_related_product2'] = $this->language->get('text_related_product2');
		$data['text_button_name_incart_logic'] = $this->language->get('text_button_name_incart_logic');
		$data['text_button_name_incart_logic_label0'] = $this->language->get('text_button_name_incart_logic_label0');
		$data['text_button_name_incart_logic_label1'] = $this->language->get('text_button_name_incart_logic_label1');
		$data['text_button_name_incart'] = $this->language->get('text_button_name_incart');
		$data['text_button_name_incart_with_options'] = $this->language->get('text_button_name_incart_with_options');
		
		$data['entry_head'] = $this->language->get('entry_head');
		$data['entry_related_heading'] = $this->language->get('entry_related_heading');
		$data['entry_button_name_shopping'] = $this->language->get('entry_button_name_shopping');
		$data['entry_button_name_cart_show'] = $this->language->get('entry_button_name_cart_show');
		$data['entry_button_name_cart'] = $this->language->get('entry_button_name_cart');
		
		$data['entry_button_name_checkout'] = $this->language->get('entry_button_name_checkout');
		$data['entry_button_name_default'] = $this->language->get('entry_button_name_default');
		$data['entry_button_name_incart'] = $this->language->get('entry_button_name_incart');
		$data['entry_button_name_incart_with_options'] = $this->language->get('entry_button_name_incart_with_options');
		
		$data['text_copyright'] = $this->language->get('text_copyright');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_apply'] = $this->language->get('button_apply');
		$data['button_remove'] = $this->language->get('button_remove');
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';		

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'		=> $this->url->link('extension/extension', 'token='.$this->session->data['token'].'&type=module', true),
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/popupcart', 'token=' . $this->session->data['token'], true),
   		);
		
		$data['action'] = $this->url->link('extension/module/popupcart', 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link('extension/extension', 'token='.$this->session->data['token'].'&type=module', true);
	
		$data['settings'] = $this->config->get('popupcart') ? $this->config->get('popupcart') : array();
	
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/popupcart.tpl', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/popupcart')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>