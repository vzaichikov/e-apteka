<?php
	class ControllerEaptekaSmartSearch extends Controller
	{

		public function __construct($registry){					
			parent::__construct($registry);
						
			$this->load->library('hobotix/ElasticSearch');
			$this->elasticSearch = new hobotix\ElasticSearch($registry);						
		}
	

		public function clear(){
			if (!empty($this->request->get['id'])){
				$this->load->model('hobotix/search');
				$this->model_hobotix_search->clearSearchHistory($this->request->get['id']);
			}
		}	
		
		private function createData($hit, $field, $exact, $suggestLogic, $query, &$data){
			$href 		= '';
			$href_analog = '';
			$id 		= '';
			$idtype 	= '';
			$type 		= '';
			$price 		= '';
			$special 	= '';
			$atx 		= '';
			$stock	    = '';
			$image		= '';
			
			$name = $hit['_source'][$field];
			
			if ($exact && !empty($hit['highlight'][$field])){
				$name = $hit['highlight'][$field][0];
			}
			
			if (!empty($hit['_source']['product_id'])){								
				$href 			= $this->url->link('product/product', 'product_id=' . $hit['_source']['product_id']);	
				$href_analog 	= $this->url->link('product/product', 'product_id=' . $hit['_source']['product_id'] . '&product-display=analog');				
				$id 			= $hit['_source']['product_id'];
				$idtype 		= 'p' . $hit['_source']['product_id'];
				$type 			= 'p';	
				$price 			= $hit['_source']['price'];
				$stock 			= $hit['_source']['stock'];
				$atx 			= $hit['_source']['atx'];
				$special 		= $hit['_source']['special'];
				
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
				
				} elseif ($hit['_source']['category_id'] && !$hit['_source']['ocfilter_filter'] && !$hit['_source']['ocfilter_page_id']) {
				$href 	= $this->url->link('product/category', 'path=' . $hit['_source']['category_id']);
				$id 	= $hit['_source']['category_id'];
				$idtype = 'c' . $hit['_source']['category_id'];
				$type 	= 'c';

				} elseif ($hit['_source']['collection_id']) {
				$href 	= $this->url->link('catalog/collection', 'collection_id=' . $hit['_source']['collection_id']);
				$id 	= $hit['_source']['collection_id'];
				$idtype = 'co' . $hit['_source']['collection_id'];
				$type 	= 'co';
				$image  = $hit['_source']['image'];				
			}		
			
			if ($suggestLogic){
				$name 	= mb_strtolower($hit['_source'][$field]);
				
				if ($query){
					$name = str_ireplace($query, '<b>' . $query . '</b>', $name);
				}
				
				$type 	= 's';
				$id 	= 's' . $hit['_id'];
				$idtype = 's' . $hit['_id'];
			}
			
			$data[] = array(
			'name' 		=> $name,
			'href' 		=> $href,
			'href_analog' => $href_analog,
			'id'   		=> $id,
			'idtype'   	=> $idtype,	
			'type' 		=> $type,
			'price'		=> $price,
			'special'	=> $special,
			'stock'		=> $stock,
			'atx'		=> $atx,
			'image'		=> $image
			);		
		}
		
		private function prepareResults($results, $field, $exact, $query = false){
			$this->load->model('catalog/manufacturer');
			$this->load->model('catalog/category');
			$this->load->model('catalog/product');
			$this->load->model('tool/image');
			
			$data = array();
			
			if (!empty($results['suggest']['completition-suggestion']) && count($results['suggest']['completition-suggestion'][0]['options'])){				
				foreach ($results['suggest']['completition-suggestion'][0]['options'] as $option){					
					$this->createData($option, $field, $exact, true, $query, $data);	
				}		
			}
			
			foreach ($results['hits']['hits'] as $hit){				
				$this->createData($hit, $field, $exact, false, $query, $data);	
			}	
			
			$parsedData = ['p' => [], 'c' => [], 'ocfp' => [], 's' => [] ];
						
			foreach ($data as $result){		
				if ($result['type'] == 'p'){
					$analogues = [];
					if (!$result['stock'] && $result['atx']){
						if ($same_results = $this->model_catalog_product->getProductSame($result['id'], ['product_id' => $result['id'], 'reg_atx_1' => $result['atx']], 2)){
							foreach ($same_results as $same){
							$analogues[$same['product_id']] = [
								'id' 			=> $same['product_id'],
								'href' 			=> $this->url->link('product/product', 'product_id=' . $same['product_id']),
								'name' 			=> $same['name'],
								'stock'			=> ($same['quantity'] > 0),
								'price' 		=> $this->currency->format($same['price'], $this->session->data['currency']),
								'special' 		=> $same['special']?$this->currency->format($same['special'], $this->session->data['currency']):false	
								];
							}							
						}


						if (!$same_results && $analog_results = $this->model_catalog_product->getProductAnalog($result['id'], ['product_id' => $result['id'], 'reg_atx_1' => $result['atx']], array_keys($same_results['same']), 2)){
							foreach ($analog_results as $analog){
							$analogues[$analog['product_id']] = [
								'id' 			=> $analog['product_id'],
								'href' 			=> $this->url->link('product/product', 'product_id=' . $analog['product_id']),
								'name' 			=> $analog['name'],
								'stock'			=> ($analog['quantity'] > 0),
								'price' 		=> $this->currency->format($analog['price'], $this->session->data['currency']),
								'special' 		=> $analog['special']?$this->currency->format($analog['special'], $this->session->data['currency']):false	
								];
							}
						}

						if ($analogues){
							$result['href'] = $result['href_analog'];
						}
					}					

					$parsedData['p'][$result['id']] = [
						'id' 			=> $result['id'],
						'href' 			=> $result['href'],
						'name' 			=> $result['name'],
						'stock'			=> $result['stock'],					
						'atx'			=> $result['atx'],
						'analog'		=> $analogues,
						'price' 		=> $this->currency->format($result['price'], $this->session->data['currency']),						
						'special' 		=> $result['special']?$this->currency->format($result['special'], $this->session->data['currency']):false,
					];
				}
				
				if ($result['type'] == 'c'){
					$parsedData['c'][$result['id']] = array(
						'id' 		=> $result['id'],
						'href' 		=> $result['href'],
						'name' 		=> $result['name']								
					);					
				}

				if ($result['type'] == 'co'){
					
					$parsedData['co'][$result['id']] = array(
						'id' 		=> $result['id'],
						'href' 		=> $result['href'],
						'name' 		=> $result['name'],
						'image'		=> $this->model_tool_image->resize($result['image'], 50, 50)
					);					
				}
				
				if ($result['type'] == 'ocfp'){
					$parsedData['ocfp'][$result['id']] = array(
						'id' 		=> $result['id'],
						'href' 		=> $result['href'],
						'name' 		=> $result['name']
					);					
				}
				
				if ($result['type'] == 's'){
					
					$parsedData['s'][$result['id']] = array(
						'id' 		=> $result['id'],
						'href' 		=> $result['href'],
						'name' 		=> $result['name']
					);					
				}				
			}
			
			return $parsedData;
		}				
		
		public function index(){
			
			$query = $this->request->get['query'];
			$query = $this->elasticSearch->prepareQueryExceptions($query);
			$query = trim(mb_strtolower($query));	
			$length = mb_strlen($query);			

			ini_set('display_errors', 'On');

			$data['results'] = [];
			
			if (!mb_strlen($query)){				
				$this->load->model('hobotix/search');
				$data['results']['histories'] = array();
				
				$histories = $this->model_hobotix_search->getSearchHistory();
				if ($histories){
					foreach ($histories as $history){
						$data['results']['histories'][] = $history;
					}
				}
				
				$data['results']['populars'] = array();
				$populars = $this->model_hobotix_search->getPopularSearches();
				
				
				foreach ($populars as $popular){
					if (trim($popular['text'])){
						$r_text = morphos\Russian\NounPluralization::pluralize($popular['results'], $this->language->get('text_result_total_search'));
						if ($this->session->data['language'] == 'uk-ua'){
							$r_text = str_replace('результатов', 'результатів', $r_text);
						}

						$data['results']['populars'][] = array(
						'href' 		=> $this->url->link('product/search', 'search=' . trim($popular['text'])),
						'results'	=> $popular['results']?($popular['results'] . ' ' . $r_text):false,
						'text' 		=> trim($popular['text'])
						);				
					}
				}

				$data['results']['emptyquery'] = true;

				$this->response->setOutput(json_encode($data['results']));
				return;
			}			
			
			try {
				if ($length <= 3){
					
					$field = $this->elasticSearch->buildField('names'); 
					$suggest = $this->elasticSearch->buildField('suggest');					
					$results = $this->elasticSearch->completition('categories', $query, $suggest);

					$field_to_get = $this->elasticSearch->buildField('name');	
					$r1 = $this->prepareResults($results, $this->elasticSearch->buildField('name'), true, $query);
					
					} else {
		
					$field = 'names';				
					$highlight = $this->elasticSearch->buildField('name');
					$suggest = $this->elasticSearch->buildField('suggest');					
					$results = $this->elasticSearch->fuzzyCategories('categories', $query, $field, $highlight, $suggest, ['limit' => 10]);

				//	$this->log->debug($results);

					$r1 = $this->prepareResults($results, $highlight, true, $query);

					if (count($r1) < 8){
						if (\hobotix\Elasticsearch::validateResult($resultsP = $this->elasticSearch->sku($query)) == 1){
						} else {	
							$field1 = $this->elasticSearch->buildField('name');
							$highlight = $this->elasticSearch->buildField('name');
							$field2 = 'names';
							
							$resultsP0 = $this->elasticSearch->fuzzyProductsSimple('products', $query, $field1, $field2);
							$resultsP = $this->elasticSearch->fuzzyProducts('products', $query, $field1, $field2, ['stock' => true]);								
						}						

						$r20 	= $this->prepareResults($resultsP0, $highlight, true, $query);
						$r2 	= $this->prepareResults($resultsP, $highlight, true, $query);
					}					
				}
				
				if (empty($r1['results'])){
					$r1['results'] = [];
				}

				if (empty($r20['results'])){
					$r20['results'] = [];
				}
				
				if (empty($r2['results'])){
					$r2['results'] = [];
				}				
				} catch ( Exception $e ) {

				print_r($e->getMessage());				
			}			
			
			$data['results'] = [];
			$data['results']['p'] = $data['results']['c'] = $data['results']['co'] = $data['results']['ocfp'] = $data['results']['s'] = [];
			
			foreach (['p', 'c', 'co', 'ocfp', 's'] as $idx){
				foreach ($r1[$idx] as $itr){
					$data['results'][$idx][] = $itr;
				}

				unset($itr);
				foreach ($r20[$idx] as $itr){
					$data['results'][$idx][] = $itr;
				}
				
				unset($itr);
				foreach ($r2[$idx] as $itr){
					$data['results'][$idx][] = $itr;
				}
				
				unset($itr);
			}

			//ОЧЕНЬ ВРЕМЕННО ДО
			if (count($data['results']['c']) + count($data['results']['co']) + count($data['results']['ocpf']) > 0){
				$data['results']['s'] = [];
			}

			$tmp = [];
			foreach ($data['results']['p'] as $result){
				$tmp[$result['id']] = $result;
			}

			$data['results']['p'] = $tmp;

			foreach ($data['results']['p'] as $index => &$product) {
    			$product['original_index'] = $index;
			}

			usort($data['results']['p'], function ($a, $b) {    
				$stockComparison = $b['stock'] - $a['stock'];    
				if ($stockComparison !== 0) {
					return $stockComparison;
				} else {
					return $a['original_index'] - $b['original_index'];
				}
			});
			
			$data['results']['total'] = count($data['results']['p']) + count($data['results']['c']) + count($data['results']['co']) + count($data['results']['ocpf'])  + count($data['results']['s']);

			$data['results']['full_search_uri'] = $this->url->link('product/search', 'search=' . $query);
			
			$this->response->addHeader('Content-Type: application/json; charset=utf-8');

			$this->response->setOutput(json_encode($data['results']));
		}

		public function reindex(){
			$response = $this->elasticSearch->indexproduct($this->request->get['id']);
			
			$params = [
			'index' => 'products',
			'id'    => $this->request->get['id']
			];			
			
			$response = $this->elasticSearch->elastic->get($params);
			$this->log->debug($response);
			$this->response->setOutput('');	
		}
		
		public function test(){
			
			$params = [
			'index' => $this->request->get['index'],
			'id'    => $this->request->get['id']
			];			
			
			$response = $this->elasticSearch->elastic->get($params);
			$this->log->debug($response);
			$this->response->setOutput('');			
		}

		public function indexer(){			
			ini_set('memory_limit', '2G');			

			//$this->elasticSearch->productsindexer();
			
			$this->elasticSearch->recreateIndices()->indexer()->productsindexer();															
			
		}
	}