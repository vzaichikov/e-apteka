<?php
	class ControllerAccountForgotten extends Controller {
		private $error = array();
		
		public function index() {

			$data['tmdaccount_customcss'] = $this->config->get('tmdaccount_custom_css');
			$data['tmdaccount_status'] = $this->config->get('tmdaccount_status');
			if ($this->customer->isLogged()) {
				$this->response->redirect($this->url->link('account/account', '', true));
			}
			
			$this->load->language('account/forgotten');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->load->model('account/customer');
			
			if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
				
				if (!empty($this->request->post['email']) && $this->validate()){
					
					$this->load->language('mail/forgotten');
					
					$code = token(40);
					
					$this->model_account_customer->editCode($this->request->post['email'], $code);
					
					$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
					
					$message  = sprintf($this->language->get('text_greeting'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";
					$message .= $this->language->get('text_change') . "\n\n";
					$message .= $this->url->link('account/reset', 'code=' . $code, true) . "\n\n";
					$message .= sprintf($this->language->get('text_ip'), $this->request->server['REMOTE_ADDR']) . "\n\n";
					
					$mail = new Mail();
					$mail->protocol = $this->config->get('config_mail_protocol');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
					$mail->smtp_username = $this->config->get('config_mail_smtp_username');
					$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
					$mail->smtp_port = $this->config->get('config_mail_smtp_port');
					$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
					
					$mail->setTo($this->request->post['email']);
					$mail->setFrom($this->config->get('config_email'));
					$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
					$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
					$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
					$mail->send();
					
					$this->session->data['success'] = $this->language->get('text_success_email');
					
					// Add to activity log
					if ($this->config->get('config_customer_activity')) {
						$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);
						
						if ($customer_info) {
							$this->load->model('account/activity');
							
							$activity_data = array(
							'customer_id' => $customer_info['customer_id'],
							'name'        => $customer_info['firstname'] . ' ' . $customer_info['lastname']
							);
							
							$this->model_account_activity->addActivity('forgotten', $activity_data);
						}
					}
					
					} elseif (!empty($this->request->post['telephone']) && $this->validatePhone()){
					
					$pin = pin(4);
					
					$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['telephone']);					
					$this->model_account_customer->editPasswordByCustomerID($customer_info['customer_id'], $pin);
					
					$smsText = sprintf($this->language->get('sms_new_pincode'), $pin);
					$this->TurboSMS->addToQueue($customer_info['telephone'], $smsText);
					
					$this->session->data['success'] = $this->language->get('text_success_phone');
					
					// Add to activity log
					if ($this->config->get('config_customer_activity')) {
						$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['telephone']);
						
						if ($customer_info) {
							$this->load->model('account/activity');
							
							$activity_data = array(
							'customer_id' => $customer_info['customer_id'],
							'name'        => $customer_info['firstname'] . ' ' . $customer_info['lastname']
							);
							
							$this->model_account_activity->addActivity('forgotten', $activity_data);
						}
					}
				}
				
				if (!$this->error['warning']){
					$this->response->redirect($this->url->link('account/login', '', true));
				}
			}
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrumb_home'),
			'href' => $this->url->link('common/home')
			);
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', true)
			);
			
			$this->document->addScript('catalog/view/javascript/jquery/jquery.inputmask.bundle.min.js');
			
			$data['heading_title'] = $this->language->get('heading_title');
			
			$data['text_your_phone'] = $this->language->get('text_your_phone');
			$data['tab_phone'] = $this->language->get('tab_phone');
			$data['button_continue_phone'] = $this->language->get('button_continue_phone');
			$data['text_if_you_remember_telephone'] = $this->language->get('text_if_you_remember_telephone');
			
			$data['text_email'] = $this->language->get('text_email');
			$data['tab_email'] = $this->language->get('tab_email');
			$data['text_your_email'] = $this->language->get('text_your_email');
			$data['text_email'] = $this->language->get('text_email');
			$data['button_continue_email'] = $this->language->get('button_continue_email');
			$data['text_if_you_remember_email'] = $this->language->get('text_if_you_remember_email');
			
			$data['entry_email'] = $this->language->get('entry_email');
			
			$data['button_continue'] = $this->language->get('button_continue');
			$data['button_back'] = $this->language->get('button_back');
			
			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
				} else {
				$data['error_warning'] = '';
			}
			
			$data['action'] = $this->url->link('account/forgotten', '', true);
			
			$data['back'] = $this->url->link('account/login', '', true);
			
			if (isset($this->request->post['email'])) {
				$data['email'] = $this->request->post['email'];
				} else {
				$data['email'] = '';
			}
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			
			$this->response->setOutput($this->load->view('account/forgotten', $data));
		}
		
		protected function validatePhone() {
			
			if (empty($this->request->post['telephone']) || !mb_strlen($this->request->post['telephone'])) {
				$this->error['warning'] = $this->language->get('error_telephone');
			}
			
			if (!$this->error){
				if (!$this->model_account_customer->getTotalCustomersByEmail($this->request->post['telephone'])) {
					$this->error['warning'] = $this->language->get('error_telephone');
				}
			}	
			
			if (!$this->error){
				$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['telephone']);
				
				if ($customer_info && !$customer_info['approved']) {
					$this->error['warning'] = $this->language->get('error_approved');
				}
			}	
			
			return !$this->error;
		}
		
		protected function validate() {
			
			if (empty($this->request->post['email']) || !mb_strlen($this->request->post['email']) || !checkIfStringIsEmail($this->request->post['email'])) {
				$this->error['warning'] = $this->language->get('error_email');
			}
			
			if (!$this->error){
				if (!$this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
					$this->error['warning'] = $this->language->get('error_email');
				}
			}	
			
			if (!$this->error){
				$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);
				
				if ($customer_info && !$customer_info['approved']) {
					$this->error['warning'] = $this->language->get('error_approved');
				}
			}	
			
			return !$this->error;
		}
	}
