<?php
	class ControllerProductSearch extends Controller {
		
		private $search = '';
		private $filter_category_id = 0;
		private $filter_manufacturer_id = 0;
		private $elasticSearch;
		
		public function __construct($registry){						
			parent::__construct($registry);
			
			$this->load->library('hobotix/ElasticSearch');
			$this->elasticSearch = new hobotix\ElasticSearch($registry);					
		}
		
		private function elasticSingleProductResult($results){
			$this->load->model('catalog/product');
			
			if (!empty($results['hits']['hits'][0]) && !empty($results['hits']['hits'][0]['_source']) && !empty($results['hits']['hits'][0]['_source']['product_id'])){
				
				if ($product = $this->model_catalog_product->getProduct($results['hits']['hits'][0]['_source']['product_id'])){					
					return $product;
				}
			}
			
			return false;
		}


		public function sku(){
			$query = trim($this->request->get['ean']);


			$result = [
				'status' 	=> false,
				'name' 		=> 'Не знайдено товар в базі'				
			];

			if (hobotix\ElasticSearch::validateResult($resultSKU = $this->elasticSearch->sku($query)) == 1){				
				if ($product = $this->elasticSingleProductResult($resultSKU)){

					$price = $product['special']?$product['special']:$product['price'];

					$result = [
						'status' 	=> true,
						'name' 		=> $product['name'],
						'quantity'  => $product['quantity'],
						'stocks'    => $this->model_catalog_product->getProductStocks($product['product_id']),
						'image' 	=> $this->model_tool_image->resize($product['image'], 150, 150),
						'price' 	=> $this->currency->format($this->tax->calculate($price, $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']),
						'href' 		=> $this->url->link('product/product', 'product_id=' . $product['product_id']) 							
					];
				}
			}

			$this->response->setOutput(json_encode($result));
		}

		
		private function elasticResults($results, $field){
			$this->load->model('catalog/product');
			
			$product_data = array();
			$manufacturer_data = array();	
			
			foreach ($results['hits']['hits'] as $hit){
				
				$name = $hit['_source'][$field];
				
				if (!empty($hit['highlight'][$field]) && $hit['highlight'][$field]){
					$name = $hit['highlight'][$field][0];
				}				
				
				if ($product = $this->model_catalog_product->getProduct($hit['_source']['product_id'])){
					$product_data[$hit['_source']['product_id']] = $product;
					$product_data[$hit['_source']['product_id']]['name'] = $name;
					} else {					
					$this->elasticSearch->deleteUnexistentProduct($hit['_source']['product_id']);
				}
			}
			
			return ['product_data' => $product_data, 'manufacturer_data' => $manufacturer_data];
		}
		
		private function elasticResultsCMA($results, $field, $exact){
			$this->load->model('catalog/manufacturer');
			$this->load->model('catalog/category');
			$this->load->model('catalog/product');
			$this->load->model('tool/image');
			
			$data = array();
			
			foreach ($results['hits']['hits'] as $hit){
				$href 		= '';
				$id 		= '';
				$idtype 	= '';
				$type 		= '';				

				$name = $hit['_source'][$field];
				
				if ($exact && !empty($hit['highlight'][$field])){
					$name = $hit['highlight'][$field][0];
				}
				
				$name = $this->elasticSearch->checkUAName($name);
				
				if (!empty($hit['_source']['product_id'])){
					
					$href 	= $this->url->link('product/product', 'product_id=' . $hit['_source']['product_id']);					
					$id 	= $hit['_source']['product_id'];
					$idtype = 'p' . $hit['_source']['product_id'];
					$type 	= 'p';
					
					
					} elseif ($hit['_source']['category_id'] && $hit['_source']['ocfilter_filter'] && $hit['_source']['ocfilter_page_id']) {
					
					$href = $this->url->link('product/category', 'path=' . $hit['_source']['category_id']);
					$href = rtrim($href, '/');
					$hit['_source']['ocfilter_page_keyword'] = trim($hit['_source']['ocfilter_page_keyword']);
					$hit['_source']['ocfilter_filter_params'] = trim($hit['_source']['ocfilter_filter_params']);
					
					if ($hit['_source']['ocfilter_page_keyword']) {
						$href .= '/' . $hit['_source']['ocfilter_page_keyword'];
						} else {
						$href .= '/' . $hit['_source']['ocfilter_filter_params'];
					}
					
					$href 	= $href;
					$id 	= $hit['_source']['ocfilter_page_id'];
					$idtype = 'ocfp' . $hit['_source']['ocfilter_page_id'];
					$type 	= 'ocfp';
					
					} elseif ($hit['_source']['category_id']) {
					
					$href 	= $this->url->link('product/category', 'path=' . $hit['_source']['category_id']);
					$id 	= $hit['_source']['category_id'];
					$idtype = 'c' . $hit['_source']['category_id'];
					$type 	= 'c';

					} elseif ($hit['_source']['collection_id']) {
					
					$href 	= $this->url->link('catalog/collection', 'collection_id=' . $hit['_source']['collection_id']);
					$id 	= $hit['_source']['collection_id'];
					$idtype = 'co' . $hit['_source']['collection_id'];
					$type 	= 'co';
					
				}
				
				$data[$idtype] = array(
				'name' 		=> $name,
				'href' 		=> $href,
				'id'   		=> $id,
				'idtype'   	=> $idtype,	
				'type' 		=> $type
				);	
			}
			
			return $data;
		}
		
		private function prepareCategories($results){
			$this->load->model('catalog/category');
			$data = array();
			
			foreach ($results as $result){
				
				$category = $this->model_catalog_category->getCategory($result['key']);	
				
				if ($category){
					
					$href = $this->url->link('product/search', 'search=' . $this->search . '&filter_category_id=' . $category['category_id']);
					
					$data[] = array(
					'name' 		=> $this->elasticSearch->checkUAName($category['name']),
					'active' 	=> ($category['category_id'] == $this->filter_category_id),
					'href' 		=> $href,
					'count' 	=> $result['doc_count']
					);
					
				}
			}			
			
			return $data;
		}		
		
		private function prepareManufacturers($results){
			$this->load->model('catalog/manufacturer');
			
			
			foreach ($results as $result){
				$manufacturer = $this->model_catalog_manufacturer->getManufacturer($result['key']);	
				
				if ($manufacturer){
					
					$data[] = array(
					'name' 	=> $this->elasticSearch->checkUAName($manufacturer['name']),
					'active' 	=> ($manufacturer['manufacturer_id'] == $this->filter_manufacturer_id),
					'href' 	=> $this->url->link('product/search', 'search=' . $this->search . '&filter_manufacturer_id=' . $manufacturer['manufacturer_id']),
					'count' => $result['doc_count']
					);
					
				}
			}
			
			return $data;
		}
		
		public function index() {
			$this->load->language('product/category');
			$this->load->language('product/search');				
			$this->load->model('catalog/category');
			$this->load->model('catalog/product');
			$this->load->model('account/search');

				
			$this->load->model('tool/image');
			
			if (isset($this->request->get['search'])) {
				$search = $this->request->get['search'];
				} else {
				$search = '';
			}
			
			if (isset($this->request->get['tag'])) {
				$tag = $this->request->get['tag'];
				} elseif (isset($this->request->get['search'])) {
				$tag = $this->request->get['search'];
				} else {
				$tag = '';
			}
			
			if (isset($this->request->get['description'])) {
				$description = $this->request->get['description'];
				} else {
				$description = '';
			}
			
			if (isset($this->request->get['category_id'])) {
				$category_id = $this->request->get['category_id'];
				} else {
				$category_id = 0;
			}
			
			if (isset($this->request->get['filter_category_id'])) {
				$filter_category_id = $this->request->get['filter_category_id'];
				} else {
				$filter_category_id = 0;
			} 
			
			if (isset($this->request->get['filter_manufacturer_id'])) {
				$filter_manufacturer_id = $this->request->get['filter_manufacturer_id'];
				} else {
				$filter_manufacturer_id = 0;
			} 
			
			if (isset($this->request->get['sub_category'])) {
				$sub_category = $this->request->get['sub_category'];
				} else {
				$sub_category = '';
			}
			
			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
				} else {
				// $sort = 'p.sort_order';
				$sort = 'rating';
			}
			
			if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
				} else {
				// $order = 'ASC';
				$order = 'DESC';
			}
			
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
				} else {
				$page = 1;
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = (int)$this->request->get['limit'];
				} else {
				$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
			}
			
			if (isset($this->request->get['search'])) {
				$this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->request->get['search']);
				} elseif (isset($this->request->get['tag'])) {
				$this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->language->get('heading_tag') . $this->request->get['tag']);
				} else {
				$this->document->setTitle($this->language->get('heading_title'));
			}
			
			if (!empty($this->request->get['page']) && (int)$this->request->get['page'] > 1){
				$data['seo_page'] = sprintf($this->language->get('text_page'), (int)$this->request->get['page']);			
			}
			
			$data['breadcrumbs'] = array();
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
			);
			
			
			$url = '';
			
			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}
			
			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}
			
			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}
			
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
			}
			
			if (isset($this->request->get['filter_manufacturer_id'])) {
				$url .= '&filter_manufacturer_id=' . $this->request->get['filter_manufacturer_id'];
			}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			
			$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('product/search', $url)
			);
			
			if (isset($this->request->get['search'])) {
				$data['heading_title'] = $this->language->get('heading_title') .  ' `<i>' . $this->request->get['search'] . '</i>`';
				} else {
				$data['heading_title'] = $this->language->get('heading_title');
			}		
			
			if ($category_id && $search) {
				$this->load->model('catalog/category');
				$category = $this->model_catalog_category->getCategory($this->request->get['category_id']);	
				
				if ($category){
					$data['heading_title'] .= ' в ' . $category['name'] . '';
				}
			}

			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			$data['clear_url'] = $this->url->link('product/search', $url);
			
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_search'] = $this->language->get('text_search');
			$data['text_keyword'] = $this->language->get('text_keyword');
			$data['text_category'] = $this->language->get('text_category');
			$data['text_sub_category'] = $this->language->get('text_sub_category');
			$data['text_quantity'] = $this->language->get('text_quantity');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_price'] = $this->language->get('text_price');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_limit'] = $this->language->get('text_limit');
			$data['text_go2cat'] = $this->language->get('text_go2cat');
			$data['text_drop_intersection'] = $this->language->get('text_drop_intersection');
			$data['mf_text_request'] = $this->language->get('mf_text_request');
			$data['mf_text_request_no'] = $this->language->get('mf_text_request_no');
			$data['text_dl_receipt'] = $this->language->get('text_dl_receipt');
			$data['mf_search'] = $this->request->get['search'];
			
			$data['entry_search'] = $this->language->get('entry_search');
			$data['entry_description'] = $this->language->get('entry_description');
			
			$data['text_not_in_stock'] = $this->language->get('text_not_in_stock');
			$data['text_has_analogs'] 	= $this->language->get('text_has_analogs');

			$data['button_search'] = $this->language->get('button_search');
			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_list'] = $this->language->get('button_list');
			$data['button_grid'] = $this->language->get('button_grid');
			$data['text_gift'] = $this->language->get('text_gift');
			
			$data['compare'] = $this->url->link('product/compare');
			
			$data['products'] = array();
			
			if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
				
				if (!empty($this->request->get['search']) && mb_strlen($this->request->get['search']) > 1){
					try {
						
						$query = $this->request->get['search'];
						$query = $this->elasticSearch->prepareQueryExceptions($query);
						$query = trim(mb_strtolower($query));	
						$this->search = $query;
						$this->filter_category_id = $filter_category_id;
						$this->filter_manufacturer_id = $filter_manufacturer_id;						
												
						
						$field1 = $this->elasticSearch->buildField('name');
						$field2 = 'names';
						$suggest = $this->elasticSearch->buildField('suggest');
										
						if (hobotix\ElasticSearch::validateResult($resultSKU = $this->elasticSearch->sku($query)) == 1){				
							if ($productFoundBySKU = $this->elasticSingleProductResult($resultSKU)){
								$this->response->redirect($this->url->link('product/product', 'product_id=' . $productFoundBySKU['product_id'] . '&search=' .  urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'))));
							}
						}
												
						$product_total = $this->elasticSearch->fuzzyProducts('products', $query, $field1, $field2, ['getTotal' => true, 'filter_manufacturer_id' => $filter_manufacturer_id, 'filter_category_id' => $filter_category_id]);												
						if ($page == 1){
							$resultsP0 = $this->elasticSearch->fuzzyProductsSimple('products', $query, $field1, $field2);
						} else {
							$resultsP0 = [];
						}

						$resultsE = $this->elasticSearch->fuzzyProducts('products', $query, $field1, $field2, ['start' => (($page - 1) * $limit), 'limit' => $limit, 'filter_manufacturer_id' => $filter_manufacturer_id, 'filter_category_id' => $filter_category_id, 'sort' => $sort, 'order' => $order, 'stock' => true]);
						
						if ($resultsP0){
							$resultsP = $this->elasticResults($resultsP0, $field1);
						}

						$results = $this->elasticResults($resultsE, $field1);

						$resultsP['product_data'] = array_reverse($resultsP['product_data']);
						foreach ($resultsP['product_data'] as $key => $resultP){							
							if (!empty($results['product_data'][$key])){
								unset($results[$key]);
							}
							array_unshift($results['product_data'], $resultP);
						}
						
						$resultAggregations = $this->elasticSearch->fuzzyProducts('products', $query, $field1, $field2, ['count' => true]);						
						$data['intersections'] = $this->prepareCategories($this->elasticSearch->validateAggregationResult($resultAggregations, 'categories'));
												
						$exact = true;
						$resultsCMA = $this->elasticSearch->fuzzyCategories('categories', $query, $field2, $field1, $suggest, ['limit' => 10]);								
						$data['top_found_cmas'] = $this->elasticResultsCMA($resultsCMA, $field1, $exact);
						
						} catch ( Exception $e ) {
						$data['elastic_failed_error'] = 'Наш дуже розумний пошук зламався, ми зараз його ремонтуємо';
						$data['elastic_failed_error_message'] = $e->getMessage();
					};
					
					} else {
					$results = array('product_data' => []);
				}
				
				$data['products'] = $this->model_catalog_product->prepareProductArray($results['product_data']);
								
				if (($total_results = ($product_total + count($this->data['intersections2']) + count($this->data['top_found_cmas']))) == 0){					
					$this->data['nothing_found'] = true;					
					} else {
					$this->load->model('hobotix/search');
					$this->model_hobotix_search->writeSearchHistory($query, $total_results);					
				}
				
				$url = '';
				
				if (isset($this->request->get['search'])) {
					$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
				}
				
				if (isset($this->request->get['tag'])) {
					$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
				}
				
				if (isset($this->request->get['description'])) {
					$url .= '&description=' . $this->request->get['description'];
				}
				
				if (isset($this->request->get['category_id'])) {
					$url .= '&category_id=' . $this->request->get['category_id'];
				}
				
				if (isset($this->request->get['filter_category_id'])) {
					$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
				}
				
				if (isset($this->request->get['filter_manufacturer_id'])) {
					$url .= '&filter_manufacturer_id=' . $this->request->get['filter_manufacturer_id'];
				}
				
				if (isset($this->request->get['sub_category'])) {
					$url .= '&sub_category=' . $this->request->get['sub_category'];
				}
				
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
				
				$data['sorts'] = array();
				
				
				
				$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/search', 'sort=p.price&order=ASC' . $url)
				);
				
				$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/search', 'sort=p.price&order=DESC' . $url)
				);
				
				if ($this->config->get('config_review_status')) {
					$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/search', 'sort=rating&order=DESC' . $url)
					);
					
				}
				
				$url = '';
				
				if (isset($this->request->get['search'])) {
					$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
				}
				
				if (isset($this->request->get['tag'])) {
					$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
				}
				
				if (isset($this->request->get['description'])) {
					$url .= '&description=' . $this->request->get['description'];
				}
				
				if (isset($this->request->get['category_id'])) {
					$url .= '&category_id=' . $this->request->get['category_id'];
				}
				
				if (isset($this->request->get['sub_category'])) {
					$url .= '&sub_category=' . $this->request->get['sub_category'];
				}
				
				if (isset($this->request->get['filter_category_id'])) {
					$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
				}
				
				if (isset($this->request->get['filter_manufacturer_id'])) {
					$url .= '&filter_manufacturer_id=' . $this->request->get['filter_manufacturer_id'];
				}
				
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}
				
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
				
				$data['limits'] = array();
				
				$limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 50, 100));
				
				sort($limits);
				
				foreach($limits as $value) {
					$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/search', $url . '&limit=' . $value)
					);
				}
				
				$url = '';
				
				if (isset($this->request->get['search'])) {
					$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
				}
				
				if (isset($this->request->get['tag'])) {
					$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
				}
				
				if (isset($this->request->get['description'])) {
					$url .= '&description=' . $this->request->get['description'];
				}
				
				if (isset($this->request->get['category_id'])) {
					$url .= '&category_id=' . $this->request->get['category_id'];
				}
				
				if (isset($this->request->get['sub_category'])) {
					$url .= '&sub_category=' . $this->request->get['sub_category'];
				}
				
				if (isset($this->request->get['filter_category_id'])) {
					$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
				}
				
				if (isset($this->request->get['filter_manufacturer_id'])) {
					$url .= '&filter_manufacturer_id=' . $this->request->get['filter_manufacturer_id'];
				}
				
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}
				
				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}
				
				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
				
				$pagination = new Pagination();
				$pagination->total = $product_total;
				$pagination->page = $page;
				$pagination->limit = $limit;
				$pagination->url = $this->url->link('product/search', $url . '&page={page}');
				
				$data['pagination'] = $pagination->render();
				
				$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));
				
				// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
				if ($page == 1) {
					$this->document->addLink($this->url->link('product/search', '', true), 'canonical');
					} elseif ($page == 2) {
					$this->document->addLink($this->url->link('product/search', '', true), 'prev');
					} else {
					$this->document->addLink($this->url->link('product/search', $url . '&page='. ($page - 1), true), 'prev');
				}
				
				if ($limit && ceil($product_total / $limit) > $page) {
					$this->document->addLink($this->url->link('product/search', $url . '&page='. ($page + 1), true), 'next');
				}
				
				if (isset($this->request->get['search']) && $this->config->get('config_customer_search')) {
					$this->load->model('account/search');                                       
                    
                    $json = array(
                        'p' => array(),
                    );
                    foreach (array_slice($results , 0, 10, true) as $result){
                        $json['p'][] = $result['product_id'];
                    }
                    
                    $search_data = array(
                    'keyword'       => $search,
                    'results'       => json_encode($json)
                    );
                    
                    $this->model_account_search->addSearch($search_data);
				}
			}
			
			$data['search'] = $search;
			$data['description'] = $description;
			$data['category_id'] = $category_id;
			$data['sub_category'] = $sub_category;
			
			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			
			$this->response->setOutput($this->load->view('product/search', $data));
		}
		
		
	}
