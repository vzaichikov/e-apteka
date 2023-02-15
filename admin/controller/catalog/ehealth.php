<?php
	class ControllerCatalogEhealth extends Controller {
		private $error = [];		
		private $filter = [];
		
		public function index() {
			$this->load->language('catalog/ehealth');
			
			$this->document->setTitle($this->language->get('heading_title'));			
			$this->load->model('catalog/ehealth');
			$this->load->model('catalog/product');
			
			$this->getList();
		}


		public function upload(){			
			$this->load->model('catalog/ehealth');

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				try {
					$file = $_FILES['file'];
					$this->model_catalog_ehealth->parseXLSX($file);
					$this->session->data['success'] =  'Загрузили файл ' . $file['name'];
				} catch (Exception $e) {
					$this->session->data['error'] = 'Error: ' . $e->getMessage();
				}
			}


			$this->response->redirect($this->url->link('catalog/ehealth', 'token=' . $this->session->data['token'], true));
		}


		protected function getList() {
			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
				} else {
				$sort = 'name';
			}
			
			if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
				} else {
				$order = 'ASC';
			}

			if (isset($this->request->get['filter'])) {
				$filter = $this->request->get['filter'];
				} else {
				$filter = null;
			}
			
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
				} else {
				$page = 1;
			}
			
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/ehealth', 'token=' . $this->session->data['token'] . $url, true)
			);


			$filter_data = array(
			'filter'		  => $filter,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
			);
			
			$this->load->model('tool/image');
			
			$ehealth_total 	= $this->model_catalog_ehealth->getTotalEhealth($filter_data);			
			$results 		= $this->model_catalog_ehealth->getEhealth($filter_data);

			$data['ehealths'] = [];

			foreach ($results as $result){
				$morion_exists 		= $result['morion_code']?$this->model_catalog_ehealth->checkMorionCodeExists($result['morion_code']):false;
				$regnumber_exists 	= $result['reg_number']?$this->model_catalog_ehealth->checkRegNumberExists($result['reg_number']):false;			

				$product 				= $result['product_id']?$this->model_catalog_product->getProduct($result['product_id']):false;
				if ($product){
					$product['pack_number'] = $this->model_catalog_ehealth->getNumberFromName($product['name']);
					$product['dosage'] 		= $this->model_catalog_ehealth->getMGFromNameAGP($product['name']);
					$product['dosage2'] 		= $this->model_catalog_ehealth->getMLFromNameAGP($product['name']);
				}

				$parse_info = json_decode($result['parse_info'], true);
				$possible_products = [];
				if (!empty($parse_info['possible'])){
					foreach ($parse_info['possible'] as $possible_product_id){
						$possible_product = $this->model_catalog_product->getProduct($possible_product_id);
						if ($possible_product){
							$possible_product['pack_number'] 	= $this->model_catalog_ehealth->getNumberFromName($possible_product['name']);
							$possible_product['dosage'] 		= $this->model_catalog_ehealth->getMGFromNameAGP($possible_product['name']);
							$possible_product['dosage2'] 		= $this->model_catalog_ehealth->getMLFromNameAGP($possible_product['name']);

							$possible_products[] = $possible_product;
						}

					}
				}


				$data['ehealths'][] = [
					'program_id' 				=> $result['program_id'],
					'program_name' 				=> $result['program_name'],
					'morion_code' 				=> $result['morion_code'],
					'trade_name' 				=> $result['trade_name'],
					'pack_number' 				=> $this->model_catalog_ehealth->getNumberFromName($result['trade_name']),
					'dosage'	 				=> $this->model_catalog_ehealth->getMGFromName($result['trade_name']),	
					'dosage2'	 				=> $this->model_catalog_ehealth->getMLFromName($result['trade_name']),	
					'ehealth_id' 				=> $result['ehealth_id'],
					'participant_id' 			=> $result['participant_id'],
					'manufacturer' 				=> $result['manufacturer'],
					'manufacturer_trade_name' 	=> $result['manufacturer_trade_name'],
					'pack' 						=> $result['pack'],
					'reg_number' 				=> $result['reg_number'],
					'package_min_qty' 			=> $result['package_min_qty'],
					'package_qty' 				=> $result['package_qty'],
					'parse_info' 				=> $parse_info,
					'possible' 					=> $possible_products, 	
					'product' 					=> $product,

					'morion_exists' 			=> $morion_exists,
					'regnumber_exists' 			=> $regnumber_exists
				];
			}

			$data['text_list'] = $this->language->get('text_list');
			$data['text_no_results'] = $this->language->get('text_no_results');
			$data['text_confirm'] = $this->language->get('text_confirm');
			
			$data['column_name'] = $this->language->get('column_name');
			$data['column_sort_order'] = $this->language->get('column_sort_order');
			$data['column_action'] = $this->language->get('column_action');

			$url = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}
			
			$pagination 		= new Pagination();
			$pagination->total 	= $ehealth_total;
			$pagination->page 	= $page;
			$pagination->limit 	= $this->config->get('config_limit_admin');
			$pagination->url 	= $this->url->link('catalog/ehealth', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
			
			$data['pagination'] = $pagination->render();
			
			$data['results'] = sprintf($this->language->get('text_pagination'), ($ehealth_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($ehealth_total - $this->config->get('config_limit_admin'))) ? $ehealth_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $ehealth_total, ceil($ehealth_total / $this->config->get('config_limit_admin')));
			
			$data['sort'] = $sort;
			$data['order'] = $order;

			$data['upload'] = $this->url->link('catalog/ehealth/upload', 'token=' . $this->session->data['token'], true);
			
			$data['canonical'] 					= $this->url->link('catalog/ehealth', 'token=' . $this->session->data['token'], true);
			$data['filter_morion_not_found'] 	= $this->url->link('catalog/ehealth', 'filter=morion_not_found&token=' . $this->session->data['token'], true);
			$data['filter_regnumber_not_found'] = $this->url->link('catalog/ehealth', 'filter=regnumber_not_found&token=' . $this->session->data['token'], true);

			$data['filter_many_products_found'] = $this->url->link('catalog/ehealth', 'filter=many_products_found&token=' . $this->session->data['token'], true);

			$data['parseehealth'] = $this->url->link('catalog/ehealth/parseehealth', 'token=' . $this->session->data['token'], true);

			$data['success'] 		= $this->session->data['success'];
			$data['error_warning'] = $this->session->data['error_warning'];
			
			unset($this->session->data['success']);
			unset($this->session->data['error_warning']);

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
			$this->response->setOutput($this->load->view('catalog/ehealth', $data));
		}


		public function parseehealth(){
			$this->load->model('catalog/ehealth');
			$this->load->model('catalog/product');

			$query = $this->db->query("SELECT * FROM oc_ehealth WHERE product_id = 0");

			foreach ($query->rows as $result){
				$parse_data = [
					'success' 	=> [],
					'possible' 	=> [],
					'info' 		=> [],
					'error' 	=> [],
				];

				echoLine('');
				echoLine('Попытка сопоставить ' . $result['trade_name']);

				if ($result['morion_code']){
					$products = $this->model_catalog_ehealth->checkMorionCodeExists($result['morion_code'], false);

					if (count($products) == 1){
						$product = $this->model_catalog_product->getProduct($products[0]['product_id']);
						$parse_data['success']['MORION_FOUND_ONE'] 	= true;
						$parse_data['possible'][] 					= $product['product_id'];

						echoLine('Один товар найден по коду Морион ' . $result['morion_code'] . ': ' . $product['name'], 's');
					} elseif (count($products) > 1) {
						foreach ($products as $product_id){
							$product = $this->model_catalog_product->getProduct($product_id['product_id']);
							$parse_data['error']['MORION_FOUND_X'] 	= true;
							$parse_data['possible'][] 				= $product['product_id'];

							echoLine('Несколько товаров найдено по коду Морион ' . $result['morion_code'] . ': ' . $product['name'], 'w');
						}
					} else {
						$parse_data['error']['MORION_NOT_FOUND'] 	= true;
						echoLine('Ничего не найдено по коду Морион ' . $result['morion_code'] . ': ' . $result['morion_code'], 'w');
					}
				} else {
					$parse_data['error']['MORION_NO_IN_EHEALTH'] 	= true;
					echoLine('В справочнике Ehealth нету кода Морион', 'e');
				}

				if ($result['reg_number']){
					$products = $this->model_catalog_ehealth->checkRegNumberExists($result['reg_number'], false);

					if (count($products) == 1){
						$product = $this->model_catalog_product->getProduct($products[0]['product_id']);
						$parse_data['success']['REGNUMBER_FOUND_ONE'] 	= true;
						$parse_data['success']['REGNUMBER_FOUND_ANY'] 	= true;
						$parse_data['possible'][] 	= $product['product_id'];

						echoLine('Найден по регкоду ' . $result['reg_number'] . ' ' . $product['name'], 's');
					} elseif (count($products) > 1) {
						foreach ($products as $product_id){
							$product = $this->model_catalog_product->getProduct($product_id['product_id']);
							
							$parse_data['error']['REGNUMBER_FOUND_X'] 		= true;
							$parse_data['success']['REGNUMBER_FOUND_ANY'] 	= true;

							$parse_data['possible'][] 	= $product['product_id'];

							echoLine('Несколько товаров найдено по регкоду ' . $result['reg_number'] . ' ' . $product['name'], 'w');
						}
					} else {
						$parse_data['error']['REGNUMBER_NOT_FOUND'] 		= true;

						echoLine('Ничего не найдено по регкоду ' . $result['reg_number'] . ' ' . $result['reg_number'], 'w');
					}
				} else {
					$parse_data['error']['NO_REGNUMBER_IN_EHEALTH'] 		= true;
					echoLine('В справочнике Ehealth нету кода регистрации', 'e');
				}

				//STAGE 2, comparing very good products, every FIVE is compatible
				if (!empty($parse_data['success'])){
					if (!empty($parse_data['success']['MORION_FOUND_ONE']) && (!empty($parse_data['success']['REGNUMBER_FOUND_ONE']) || !empty($parse_data['success']['REGNUMBER_FOUND_ANY']))){
						if (count($parse_data['possible'] = array_unique($parse_data['possible'])) >= 1){

							foreach ($parse_data['possible'] as $product_id){
								foreach (['PACK_NUMBER_EQUAL','PACK_DOSAGE_EQUAL','PACK_DOSAGE2_EQUAL'] as $equality_constant){
									if (!empty($parse_data['success'][$equality_constant])){
										unset($parse_data['success'][$equality_constant]);
									}
								}

								$product = $this->model_catalog_product->getProduct($product_id);

								echoLine('Проверяем далее товар ' . $product_id . ', ' . $product['name'], 'i');	

								$ehealth_number = $this->model_catalog_ehealth->getNumberFromName($result['trade_name']);
								$eapteka_number = $this->model_catalog_ehealth->getNumberFromName($product['name']);

								echoLine('Номер упаковки ' . $ehealth_number . ', ' . $eapteka_number, 'i');	

								if ($ehealth_number == $eapteka_number){
									$parse_data['success']['PACK_NUMBER_EQUAL'] = true;
									echoLine('Совпадение номера упаковки: ' . $ehealth_number, 's');
								} else {
									$parse_data['error']['PACK_NUMBER_NOT_EQUAL'] = true;
									echoLine('Несовпадение номера упаковки: ' . $ehealth_number . ' / ' . $eapteka_number, 'e');
								}

								$ehealth_dosage = $this->model_catalog_ehealth->getMGFromName($result['trade_name'], true);
								$eapteka_dosage = $this->model_catalog_ehealth->getMGFromNameAGP($product['name'], true);

								echoLine('Дозировки MG: ' . $ehealth_dosage . ', ' . $eapteka_dosage, 'i');

								if ((!$ehealth_dosage && !$eapteka_dosage) || $ehealth_dosage == $eapteka_dosage){
									$parse_data['success']['PACK_DOSAGE_EQUAL'] = true;
									echoLine('Совпадение дозировки MG: ' . $ehealth_dosage, 's');
								} else {
									$parse_data['error']['PACK_DOSAGE_NOT_EQUAL'] = true;
									echoLine('Несовпадение дозировки MG: ' . $ehealth_dosage . ' / ' . $eapteka_dosage, 'e');
								}

								$ehealth_dosage2 = $this->model_catalog_ehealth->getMLFromName($result['trade_name'], true);
								$eapteka_dosage2 = $this->model_catalog_ehealth->getMLFromNameAGP($product['name'], true);

								echoLine('Дозировки ML: ' . $ehealth_dosage2 . ', ' . $eapteka_dosage2, 'i');

								if ((!$ehealth_dosage2 && !$eapteka_dosage2) || $ehealth_dosage2 == $eapteka_dosage2){
									$parse_data['success']['PACK_DOSAGE2_EQUAL'] = true;
									echoLine('Совпадение дозировки ML: ' . $ehealth_dosage2, 's');
								} else {
									$parse_data['error']['PACK_DOSAGE2_NOT_EQUAL'] = true;
									echoLine('Несовпадение дозировки ML: ' . $ehealth_dosage2 . ' / ' . $eapteka_dosage2, 'e');
								}

								$linkProduct = true;							
								foreach (['MORION_FOUND_ONE', 'REGNUMBER_FOUND_ANY', 'PACK_NUMBER_EQUAL', 'PACK_DOSAGE_EQUAL', 'PACK_DOSAGE2_EQUAL'] as $success_constants){
									if (empty($parse_data['success'][$success_constants])){							
										$linkProduct = false;
									}
								}

								$parse_data['possible'] = array_unique($parse_data['possible']);

								if ($linkProduct && $product_id && $product){
									echoLine('Все факторы совпадают, связываем', 's');

									if (($key = array_search($product_id, $parse_data['possible'])) !== false) {
										unset($parse_data['possible'][$key]);
									}

									$this->model_catalog_ehealth->linkProduct($product_id, $result['ehealth_id']);
									break;
								}
							}
						}
					}
				}

				$this->db->query("UPDATE oc_ehealth SET parse_info = '" . $this->db->escape(json_encode($parse_data)) . "' WHERE ehealth_id = '" . $result['ehealth_id'] . "'");
			}
		}






}