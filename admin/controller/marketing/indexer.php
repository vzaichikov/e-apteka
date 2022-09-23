<?php
	class ControllerMarketingIndexer extends Controller {
		private $error = array();
		private $jsonKey = 'eapteka-293311-6370a8c3c2df.json';	
		
		public function getURLStatusAjax(){
			$url = $this->request->get['url'];
		
			$client = new Google_Client();		
			$client->setAuthConfig(DIR_SYSTEM . $this->jsonKey);
			$client->addScope('https://www.googleapis.com/auth/indexing');
			
			
			// Get a Guzzle HTTP Client
			$httpClient = $client->authorize();
			$endpoint = 'https://indexing.googleapis.com/v3/urlNotifications/metadata?url='.$this->request->get['url'];

			$response = $httpClient->get($endpoint);
			$status_code = $response->getStatusCode();
			$body = $response->getBody();

			$this->response->setOutput('<pre>' . $body . '</pre>');
		}
		
		public function index() {
			$this->load->model('eapteka/indexer');
			
			$this->document->setTitle('Статистика отправки урлов в Google');
			
			$data['heading_title'] = $this->language->get('Статистика отправки урлов в Google');
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('Статистика отправки урлов в Google'),
			'href' => $this->url->link('marketing/indexer', 'token=' . $this->session->data['token'], true)
			);
			
			
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
				} else {
				$page = 1;
			}
			
			$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
			);
			
			$data['indexes'] = array();
			
			$indexer_total = $this->model_eapteka_indexer->getTotalIndexes();
			$results = $this->model_eapteka_indexer->getIndexes($filter_data);
			
			foreach ($results as $result) {
				$data['indexes'][] = array(
				'indexer_id'  	=> $result['indexer_id'],
				'indexer_url'  			=> $result['indexer_url'],
				'date_added'  	=> date('Y-m-d', strtotime($result['date_added'])),
				'time_added'  	=> date('H:i:s', strtotime($result['date_added'])),
				'action'		=> $this->url->link('marketing/indexer/getURLStatusAjax', 'token=' . $this->session->data['token'] . '&url=' . urlencode($result['indexer_url']), true)
				);
			}
			
			$url = '';
			
			
			$pagination = new Pagination();
			$pagination->total = $indexer_total;
			$pagination->page = $page;
			$pagination->limit = $this->config->get('config_limit_admin');
			$pagination->url = $this->url->link('marketing/indexer', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
			
			$data['pagination'] = $pagination->render();
			
			$data['results'] = sprintf($this->language->get('text_pagination'), ($indexer_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($indexer_total - $this->config->get('config_limit_admin'))) ? $indexer_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $indexer_total, ceil($indexer_total / $this->config->get('config_limit_admin')));
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
			$this->response->setOutput($this->load->view('marketing/indexer', $data));
		}		
		
		
	}				