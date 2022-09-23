<?php
	class ControllerHobotixHoboFAQ extends Controller {
		
		private function makeHref($href, $anchor){			
			return "<a href='$href' title='$anchor'>$anchor</a>";
		}
		
		private function makeProductTableLine($title, $product){
			return array(
			'title' => $title,
			'name' 	=> $this->makeHref($this->url->link('product/product', 'product_id=' . $product['product_id']), $product['name']),
			'price' => $product['special']?$this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']):$this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'])
			);
		}

		private function makeStocksList($stocks){
			$html = '';

			if ($stocks){
				$html = '<ul>';
				foreach ($stocks as $stock){
					$html .= '<li>';
					$html .= $this->makeHref($this->url->link('catalog/information', 'information_id=' . $stock['information_id']), $stock['address']);
					$html .= '</li>';
				}
				$html .= '</ul>';
			}

			return $html;

		}

		private function makeStockAnswer($answer, $stocks){

			return $answer . '<br />' . $this->makeStocksList($stocks);

		}
		
		private function makeProductFaqQA($question, $answer, $products){
			
			$html = '<br />';			
			$html .= '<ul>';
			foreach ($products as $product){
				$html .= '<li>';
				$html .= $this->makeHref($this->url->link('product/product', 'product_id=' . $product['product_id']), $product['name']);
				$html .= '</li>';
			}
			$html .= '</ul>';
			
			return array(
			'question' 	=> $question,
			'answer'	=> $answer . $html
			);
		}
		
		private function ocfilter($category_info){			
			if (isset($this->request->get['filter_ocfilter'])){
				
				if ($ocfilter_page_info = $this->load->controller('extension/module/ocfilter/getPageInfo')){
					
					$data['heading_title'] = $ocfilter_page_info['title'];
					
					} else {
					
					$filter_title = $this->load->controller('extension/module/ocfilter/getSelectedsFilterTitle');
					
					$heading_title = $data['heading_title'];
					
					if (false !== strpos($heading_title, '{filter}')) {
						$heading_title = trim(str_replace('{filter}', $filter_title, $heading_title));
						} else {
						if (false !== strpos($heading_title, $category_info['name'])){
							$heading_title = str_replace($category_info['name'], $category_info['name'] . ' ' . $filter_title, $heading_title);									
							} else {
							$heading_title .= ' ' . $filter_title;
						}
					}
					
					$category_info['name'] = $heading_title;
					
				}
				
			}
		}
		
		private function validateOCFilter(){
			
			
			//Задана страница
			if ($ocfilter_page_info = $this->load->controller('extension/module/ocfilter/getPageInfo')){
				return true;
			}
			
			//Фильтр первого уровня
			if (count(explode(';', $this->request->get['filter_ocfilter'])) == 1 && count(explode(':', $this->request->get['filter_ocfilter'])) == 1){
				return true;
			}
			
			
			return false;
		}
		
		public function index(){		
			$this->load->model('hobotix/hobofaq');
			$this->load->model('localisation/location');
			$data = $this->load->language('hobotix/hobofaq');
			
			if (isset($this->request->get['route'])){	
				
				if (isset($this->request->get['page']) && $this->request->get['page'] > 1) {
					return '';
				}
				
				if ($this->request->get['route'] == 'product/category'){
					
					if (isset($this->request->get['filter_ocfilter']) && !$this->validateOCFilter()) {					
						return '';
					}										
					
					$path = '';
					$parts = explode('_', (string)$this->request->get['path']);				
					$category_id = (int)array_pop($parts);
					
					$category_info = $this->model_catalog_category->getCategory($category_id);
					
					if ($category_info && $category_info['seo_name']){
						
						$category_info['name'] = $category_info['seo_name'];
						
						$data['text_seo_price_table_header'] = sprintf($data['text_seo_price_table_header'], $category_info['name']);
						
						//Табличка с ценами
						$data['seo_table'] = array();
						
						//Самый дешевый
						if ($product = $this->model_hobotix_hobofaq->getCheapestProductsForCategory($category_id)){
							$data['seo_table'][] = $this->makeProductTableLine($data['text_seo_price_table_cheapest'], $product);
						}
						
						//Самый дорогой
						if ($product = $this->model_hobotix_hobofaq->getExpensiveProductsForCategory($category_id)){
							$data['seo_table'][] = $this->makeProductTableLine($data['text_seo_price_table_expensive'], $product);							
						}
						
						//Самый просматриваемый
						if ($product = $this->model_hobotix_hobofaq->getMostPopularProductsForCategory($category_id)){
							$data['seo_table'][] = $this->makeProductTableLine($data['text_seo_price_table_popular'], $product);					
						}
						
						//Самый обсуждаемый
						if ($product = $this->model_hobotix_hobofaq->getMostReviewsProductsForCategory($category_id)){
							$data['seo_table'][] = $this->makeProductTableLine($data['text_seo_price_table_reviewed'], $product);						
						}
						
						//Самый новый
						if ($product = $this->model_hobotix_hobofaq->getNewestProductsForCategory($category_id)){
							$data['seo_table'][] = $this->makeProductTableLine($data['text_seo_price_table_newest'], $product);						
						}
						
						/************************ FAQ *******************************/	
						
						//Собственно FAQ
						if ($category_info['faq_name']){
							$data['faq_header'] = $category_info['faq_name'];						
							} else {
							$data['faq_header'] = sprintf($data['text_faq_header'], $category_info['name']);
						}
						
						$data['faq'] = array();
						
						//Самые просматриваемые
						if ($products = $this->model_hobotix_hobofaq->getMostPopularProductsForCategory($category_id, 3)){							
							$question = sprintf($data['text_faq_question_most_popular'], $category_info['name']);
							$answer = sprintf($data['text_faq_answer_most_popular'], $category_info['name'], $this->config->get('config_name'));
							$data['faq'][] = $this->makeProductFaqQA($question, $answer, $products);						
						}
						
						//Новинки
						if ($products = $this->model_hobotix_hobofaq->getNewestProductsForCategory($category_id, 3)){							
							$question = sprintf($data['text_faq_question_newest'], $category_info['name']);
							$answer = sprintf($data['text_faq_answer_newest'], $category_info['name'], $this->config->get('config_name')) ;
							$data['faq'][] = $this->makeProductFaqQA($question, $answer, $products);						
						}
						
						//Дешевые
						if ($products = $this->model_hobotix_hobofaq->getCheapestProductsForCategory($category_id, 3)){
							$question = sprintf($data['text_faq_question_cheapest'], $category_info['name']);
							$answer = sprintf($data['text_faq_answer_cheapest'], $category_info['name'], $this->config->get('config_name'));
							$data['faq'][] = $this->makeProductFaqQA($question, $answer, $products);
						}
						
						//Бестселлеры
						if ($products = $this->model_hobotix_hobofaq->getBestSellerProductsForCategory($category_id, 3)){
							$question = sprintf($data['text_faq_question_bestseller'], $category_info['name']);
							$answer = sprintf($data['text_faq_answer_bestseller'], $category_info['name'], $this->config->get('config_name'));
							$data['faq'][] = $this->makeProductFaqQA($question, $answer, $products);
						}

						if ($locations = $this->model_localisation_location->getLocationsGood()){
							$question = sprintf($data['text_faq_question_stocks'], $category_info['name']);							
							$answer = $this->makeStockAnswer(sprintf($data['text_faq_answer_stocks'], $category_info['name']), $locations);
							$data['faq'][] = array(
								'question' 	=> $question,
								'answer'	=> $answer
							);			
						}
						
						//Как не платить за доставку
						/*
							$question = sprintf($data['text_faq_delivery_header'], $category_info['name']);
							$answer = sprintf($data['text_faq_delivery_text'], $this->url->link('information/information', 'information_id=6'));
							$data['faq'][] = array(
							'question' 	=> $question,
							'answer'	=> $answer					
							);
						*/
						
						
						//Ручной FAQ
						if ($handmade_faq = $this->model_hobotix_hobofaq->getCategoryFaq($category_id)){
							foreach ($handmade_faq as $handmade_qa){
								
								if (!empty($handmade_qa['icon'])){
									$question = $handmade_qa['icon'] . ' ' . $handmade_qa['question'];
									} else {
									$question = $handmade_qa['question'];
								}
								
								$data['faq'][] = array(
								'question' 	=> $question,
								'answer'	=> $handmade_qa['answer']
								);								
							}							
						}						
					}
					
					
					} elseif ($this->request->get['route'] == 'product/manufacturer/info'){
					
					return '';
					
					$manufacturer_id = $this->request->get['manufacturer_id'];
					if ($manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id)){
						$data['text_seo_price_table_header'] = sprintf($data['text_seo_price_manufacturer_table_header'], $manufacturer_info['name']);
						
						//Табличка с ценами
						$data['seo_table'] = array();
						
						//Самый дешевый
						if ($product = $this->model_hobotix_hobofaq->getCheapestProductsForManufacturer($manufacturer_id)){
							$data['seo_table'][] = $this->makeProductTableLine($data['text_seo_price_table_cheapest'], $product);
						}
						
						//Самый дорогой
						if ($product = $this->model_hobotix_hobofaq->getExpensiveProductsForManufacturer($manufacturer_id)){
							$data['seo_table'][] = $this->makeProductTableLine($data['text_seo_price_table_expensive'], $product);							
						}
						
						//Самый просматриваемый
						if ($product = $this->model_hobotix_hobofaq->getMostPopularProductsForManufacturer($manufacturer_id)){
							$data['seo_table'][] = $this->makeProductTableLine($data['text_seo_price_table_popular'], $product);					
						}
						
						//Самый обсуждаемый
						if ($product = $this->model_hobotix_hobofaq->getMostReviewsProductsForManufacturer($manufacturer_id)){
							$data['seo_table'][] = $this->makeProductTableLine($data['text_seo_price_table_reviewed'], $product);						
						}
						
						//Самый новый
						if ($product = $this->model_hobotix_hobofaq->getNewestProductsForManufacturer($manufacturer_id)){
							$data['seo_table'][] = $this->makeProductTableLine($data['text_seo_price_table_newest'], $product);						
						}
						
						//Собственно FAQ
						if ($manufacturer_info['faq_name']){
							$data['faq_header'] = $manufacturer_info['faq_name'];						
							} else {
							$data['faq_header'] = sprintf($data['text_faq_manufacturer_header'], $manufacturer_info['name']);
						}
						
						$data['faq'] = array();
						
						//Самые просматриваемые
						if ($products = $this->model_hobotix_hobofaq->getMostPopularProductsForManufacturer($manufacturer_id, 3)){							
							$question = sprintf($data['text_faq_manufacturer_question_most_popular'], $manufacturer_info['name']);
							$answer = sprintf($data['text_faq_manufacturer_answer_most_popular'], $manufacturer_info['name'], $this->config->get('config_name'));
							$data['faq'][] = $this->makeProductFaqQA($question, $answer, $products);						
						}
						
						//Новинки
						if ($products = $this->model_hobotix_hobofaq->getNewestProductsForManufacturer($manufacturer_id, 3)){							
							$question = sprintf($data['text_faq_manufacturer_question_newest'], $manufacturer_info['name']);
							$answer = sprintf($data['text_faq_manufacturer_answer_newest'], $manufacturer_info['name'], $this->config->get('config_name')) ;
							$data['faq'][] = $this->makeProductFaqQA($question, $answer, $products);						
						}
						
						//Дешевые
						if ($products = $this->model_hobotix_hobofaq->getNewestProductsForManufacturer($manufacturer_id, 3)){
							$question = sprintf($data['text_faq_manufacturer_question_cheapest'], $manufacturer_info['name']);
							$answer = sprintf($data['text_faq_manufacturer_answer_cheapest'], $manufacturer_info['name'], $this->config->get('config_name'));
							$data['faq'][] = $this->makeProductFaqQA($question, $answer, $products);
						}
						
						//Бестселлеры
						if ($products = $this->model_hobotix_hobofaq->getBestSellerProductsForManufacturer($manufacturer_id, 3)){
							$question = sprintf($data['text_faq_manufacturer_question_bestseller'], $manufacturer_info['name']);
							$answer = sprintf($data['text_faq_manufacturer_answer_bestseller'], $manufacturer_info['name'], $this->config->get('config_name'));
							$data['faq'][] = $this->makeProductFaqQA($question, $answer, $products);
						}
						
						//Как не платить за доставку
						/*
							$question = sprintf($data['text_faq_delivery_manufacturer_header'], $manufacturer_info['name']);
							$answer = sprintf($data['text_faq_delivery_manufacturer_text'], $this->url->link('information/information', 'information_id=6'));
							$data['faq'][] = array(
							'question' 	=> $question,
							'answer'	=> $answer					
							);
						*/
						
						//Ручной FAQ
						if ($handmade_faq = $this->model_hobotix_hobofaq->getManufacturerFaq($manufacturer_id)){
							foreach ($handmade_faq as $handmade_qa){
								
								if (!empty($handmade_qa['icon'])){
									$question = $handmade_qa['icon'] . ' ' . $handmade_qa['question'];
									} else {
									$question = $handmade_qa['question'];
								}
								
								$data['faq'][] = array(
								'question' 	=> $question,
								'answer'	=> $handmade_qa['answer']
								);								
							}							
						}
						
						return $this->load->view('hobotix/hobofaq', $data); 
						
					}															
					} elseif ($this->request->get['route'] == 'product/product'){
					$product_id = $this->request->get['product_id'];
					if ($product_info = $this->model_catalog_product->getProduct($product_id)){
						$this->load->model('catalog/product');
						
						//Аналоги
						if ($products = $this->model_catalog_product->getProductAnalog($product_id)){
							$question = sprintf($data['text_faq_product_question_analogs'], $product_info['name']);
							$answer = sprintf($data['text_faq_product_answer_analogs'], $product_info['name']);
							$data['faq'][] = $this->makeProductFaqQA($question, $answer, $products);						
						}
						
						//Формы выпуска											
						if ($products = $this->model_catalog_product->getProductSame($product_id)){
							$question = sprintf($data['text_faq_product_question_same'], $product_info['name']);
							$answer = sprintf($data['text_faq_product_answer_same'], $product_info['name']);
							$data['faq'][] = $this->makeProductFaqQA($question, $answer, $products);						
						}

						//Наличие						
						if ($stocks = $this->model_catalog_product->getProductStocks($product_id, true, true)){
							$question = sprintf($data['text_faq_product_question_stocks'], $product_info['name']);
							$answer = $this->makeStockAnswer($data['text_faq_product_answer_stocks'], $stocks);
							$data['faq'][] = array(
								'question' 	=> $question,
								'answer'	=> $answer
							);							
						}
					
						
						//Доставка												
						$question = sprintf($data['text_faq_product_question_delivery'], $product_info['name']);
						if ($product_info['no_shipping'] || $product_info['is_receipt']){
							$answer = sprintf($data['text_faq_product_answer_delivery_no'], $product_info['name']);
							} else {
							$answer = sprintf($data['text_faq_product_answer_delivery_yes'], $product_info['name']);
						}
						
						$data['faq'][] = array(
						'question' 	=> $question,
						'answer'	=> $answer
						);	
						
						
						//Без рецепта												
						$question = sprintf($data['text_faq_product_question_receipt'], $product_info['name']);
						if ($product_info['is_receipt']){
							$answer = sprintf($data['text_faq_product_answer_receipt_no'], $product_info['name']);
							} else {
							$answer = sprintf($data['text_faq_product_answer_receipt_yes'], $product_info['name']);
						}
						
						$data['faq'][] = array(
						'question' 	=> $question,
						'answer'	=> $answer
						);	
						
						//Собственно FAQ
						if ($product_info['faq_name']){
							$data['faq_header'] = $product_info['faq_name'];						
							} else {
							$data['faq_header'] = sprintf($data['text_faq_product_header'], $product_info['name']);
						}
						
						//Ручной FAQ
						if ($handmade_faq = $this->model_hobotix_hobofaq->getProductFaq($product_id)){
							foreach ($handmade_faq as $handmade_qa){
								
								if (mb_strlen(strip_tags($handmade_qa['answer'])) > 10){
									
									if (!empty($handmade_qa['icon'])){
										$question = $handmade_qa['icon'] . ' ' . $handmade_qa['question'];
										} else {
										$question = $handmade_qa['question'];
									}
									
									$data['faq'][] = array(
									'question' 	=> $question,
									'answer'	=> $handmade_qa['answer']
									);	
								}
							}								
						}		
					}
					}  elseif ($this->request->get['route'] == 'information/information'){
					$information_id = $this->request->get['information_id'];
					if ($information_info = $this->model_catalog_information->getInformation($information_id)){
						
						//Собственно FAQ
						if ($information_info['faq_name']){
							$data['faq_header'] = $information_info['faq_name'];						
							} else {
							$data['faq_header'] = sprintf($data['text_faq_information_header'], $information_info['title'], $this->config->get('config_name'));
						}
						
						//Ручной FAQ
						if ($handmade_faq = $this->model_hobotix_hobofaq->getInformationFaq($information_id)){
							foreach ($handmade_faq as $handmade_qa){
								
								if (!empty($handmade_qa['icon'])){
									$question = $handmade_qa['icon'] . ' ' . $handmade_qa['question'];
									} else {
									$question = $handmade_qa['question'];
								}
								
								$data['faq'][] = array(
								'question' 	=> $question,
								'answer'	=> $handmade_qa['answer']
								);								
							}								
						}
					}
				}		
				
				return $this->load->view('hobotix/hobofaq', $data);
				
				} else {
				
				return '';
				
			}
		}
	}
	
