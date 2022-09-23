<?php
	namespace hobotix;
	use Elasticsearch\ClientBuilder;
	
	class ElasticSearch{
		private static $languages = array(2 => 'ru', 3 => 'ua');				
		
		
		public $elastic;
		private $db;
		private $log;
		private $cache;
		private $config;
		private $settings = array();
		private $transliteratorRu = null;
		private $transliteratorUk = null;
		
		private $ocfilter_pages = array();
		private $ocfilter_options = array();		
		private $manufacturerReplacements = array();
		
		const brandsListingOcFilterValueID = 5004;
		const arrayLengthLimit = 500;
		
		const CATEGORY_PRIORITY = 20;			
		const OCFILTER_PRIORITY_BRANDPAGE = 30;
		const OCFILTER_PRIORITY = 50;
		const COLLECTION_PRIORITY = 80;	
		
		const MANUFACTURER_PRIORITY = 80;
		const IN_STOCK_PRIORITY = 100;
		
		
		public function __construct($registry){			
			$this->elastic = ClientBuilder::create()->setHosts(['http://127.0.0.1:9200'])->build();
			
			$this->settings = loadJsonConfig('search');	
			
			$this->registry = $registry;
			$this->db 		= $registry->get('db');
			$this->cache 	= $registry->get('cache');
			$this->config 	= $registry->get('config');
			$this->log 		= $registry->get('log');
			$this->load 	= $registry->get('load');
			
			$this->load->model('catalog/ocfilter');
			$this->model_catalog_ocfilter = new \ModelCatalogOCFilter($this->registry);
			
			$this->load->model('catalog/product');
			$this->model_catalog_product = new \ModelCatalogProduct($this->registry);

			$this->transliteratorRu = new \Transliterator\Transliterator(\Transliterator\Settings::LANG_RU, \Transliterator\Settings::SYSTEM_British_Standard);
			$this->transliteratorUk = new \Transliterator\Transliterator(\Transliterator\Settings::LANG_UK, \Transliterator\Settings::SYSTEM_British);
		}

		/* Static service functions */
		private static function transformNumberSimple($number){
			$numberToWords 	   = new \NumberToWords\NumberToWords();
			$numberTransformer = $numberToWords->getNumberTransformer('ua');
			$result = array();
			
			$m1 = array($numberTransformer->toWords($number));
			$m2 = array(\morphos\Russian\CardinalNumeralGenerator::getCase($number, 'именительный', $gender = \morphos\Gender::MALE));
			
			return self::mergeArrays($m1, $m2);
		}
		
		private static function parseArrayToNumbers(&$params){
			$tmp = $params;
			
			foreach ($tmp['body']['names'] as $tmp_name){					
				if (preg_match_all("/([0-9]+)/", $tmp_name, $matches)){
					foreach ($matches[0] as $match){
						if ((int)$match){
							$numberTexts = self::transformNumberSimple((int)$match);
							
							foreach ($numberTexts as $numberText){
								$string = trim(str_ireplace((int)$match, ' ' . $numberText . ' ', $tmp_name));
								
							}
							
							$string = str_ireplace('  ', ' ', $string);
							$params['body']['names'][] = $string;
							//	echoLine($tmp_name . ' -> ' . $string);
						}
					}
				}	
			}		
			
			$params['body']['names'] = array_values(array_unique($params['body']['names']));			
		}

		public static function validateAggregationResult($results, $index){
			
			
			if (!empty($results['aggregations']) && !empty($results['aggregations'][$index]) && !empty($results['aggregations'][$index]['buckets']) ){
				return $results['aggregations'][$index]['buckets'];
			}
			
			return 0;
		}
		
		public static function getFirstSuggestion($result, $query){
			
			if (is_array($result['suggest']) && is_array($result['suggest']['phrase-suggestion']) && !empty($result['suggest']['phrase-suggestion'][0])){
				
				if (!empty($result['suggest']['phrase-suggestion'][0]['options']) && $result['suggest']['phrase-suggestion'][0]['options'][0]['text'] != $query){				
					return 	$result['suggest']['phrase-suggestion'][0]['options'][0]['text'];		
				}
			}
			
			if (is_array($result['suggest']) && is_array($result['suggest']['term-suggestion']) && !empty($result['suggest']['term-suggestion'][0])){
				
				$text = ' ';
				foreach ($result['suggest']['term-suggestion'] as $suggestion_word){
					
					if (!empty($suggestion_word['options'][0])){
						$text .= $suggestion_word['options'][0]['text'];
						} else {
						$text .= $suggestion_word['text'] . ' ';
					}
				}
				
				$text = trim($text);
				if ($text){
					return $text;
				}
				
				return 	$result['suggest']['term-suggestion'][0]['options'][0]['text'];							
			}
			
			return false;			
		}		

		private static function mergeArrays($array1, $array2){		
			return array_values(array_unique(array_merge($array1, $array2)));		
		}

		public static function prepareWords($query){
			
			$exploded = explode(' ',$query);
			$words = array();
			foreach ($exploded as $word){
				if (count($exploded) > 1){
					
					if (mb_strlen($word) > 2 && !self::is_stopword($word)){
						$words[] = trim($word);
					}
					
					} else {					
					$words[] = trim($word);
				}
			}
			
			return $words;
		}

		public static function createMappingToIDS($query, $indexOne, $indexTwo){
			
			$mapping = array();
			if ($query->num_rows){										
				foreach ($query->rows as $row){
					$mapping[$row[$indexOne]] = $row[$indexTwo];
				}
				unset($row);			
			}
			
			return $mapping;
		}	
		
		public static function createIndexArray($mapping, $index, &$params){			
			$params['body'][$index] = array();
			
			foreach ($mapping as $key => $value){
				$params['body'][$index][] = $key;
			}
		}
		
		public static function createMappingToNonEmpty($query, $indexOne){
			
			$mapping = array();
			if ($query->num_rows){										
				foreach ($query->rows as $row){
					$mapping[$row[$indexOne]] = true;
				}
				unset($row);			
			}
			
			return $mapping;
		}

		private static function collectionName($name){
			return preg_replace('/[^a-zA-Z0-9а-щА-ЩЬьЮюЯяЇїІіЄєҐґ()\-,&\'\.\/\* ]/mui', '', $name, -1);
		}
		
		public static function makeIdentifiersArray($sku){
			$results = array();
			
			$sku = trim($sku);
			
			$results[] = str_replace(' ', '', $sku);
			$results[] = str_replace('.', '', $sku);
			$results[] = str_replace('-', '', $sku);
			$results[] = str_replace('/', '', $sku);		
			$results[] = str_replace(array(' ', '.', '-', '/'), '', $sku);
			$results[] = str_replace(array(' ', '-'), '', $sku);
			$results[] = str_replace(array(' ', '.'), '', $sku);
			$results[] = str_replace(array('-', '.'), '', $sku);
			$results[] = str_replace(array('/', '.'), '', $sku);
			$results[] = str_replace(array('/', ' '), '', $sku);
			$results[] = str_replace(array('/', '-'), '', $sku);
			
			return array_filter(array_values(array_unique($results)));		
		}	
		/* Static service functions */


		/* fuzzy search functions */
		public function fuzzyProducts($index, $query, $field1, $field2, $data = array()){
			
			$fuzziness = 1;
			if (!empty($data['fuzziness'])){
				$fuzziness = (int)$data['fuzziness'];
			}		
			
			if (empty($data['limit'])){
				$data['limit'] = 10;
			}
			
			if (empty($data['start'])){
				$data['start'] = 0;
			}
			
			
			$params = [
			'index' => $index,
			'body'  	=> [
			'from' 		=> $data['start'],
			'size'		=> $data['limit'],
			'sort' => [	
			[ 'stock' => 'desc' ],
			[ '_score' => 'desc' ],
			],							
			'query' 	=> [
			'bool' 		=>  [
			'must' 		=>  [ 'multi_match' => [ 'fields' => [$field1.'^8', $field2.'^10'], 'query' => $query, 'type' => 'best_fields', 'fuzziness' => $fuzziness, 'prefix_length' => 2, 'max_expansions' => 10, 'operator' => 'AND' ]	],
			'should'	=> [
			//	[ 'multi_match' => [ 'fields' => [$field3], 'query' => $query, 'fuzziness' => $fuzziness, 'prefix_length' => 2, 'operator' => 'AND' ] ]
			],
			'filter' 	=> [ 
			[ 'term'  => [ 'status' 	=> '1' ] ], 		
			[ 'range' => [ 'price' 		=> [ 'gte' => 1 ] ] ],
			],
			'minimum_should_match' => 0	],
			],
			'highlight' => [ 
			'pre_tags' => [ '<b>' ], 'post_tags' => [ '</b>' ], 
			'fields' => [ 
			$field1 => [ 'require_field_match' => 'false', 'fragment_size' => 400,  'number_of_fragments' => 1 ],  
			$field2 => [ 'require_field_match' => 'false', 'fragment_size' => 400,  'number_of_fragments' => 1 ],
			] ],
			] ];	
			
			if (!empty($data['sort'])){
				if ($data['sort'] == 'p.price'){
					if ($data['order'] == 'DESC'){
						$params['body']['sort'] = [							
						[ 'stock' => 'desc' ],
						[ 'price' => 'desc' ],
						[ '_score' => 'desc' ],				
						];
					}
					
					if ($data['order'] == 'ASC'){
						$params['body']['sort'] = [							
						[ 'stock' => 'desc' ],
						[ 'price' => 'asc' ],		
						[ '_score' => 'desc' ],				
						];
					}
				}
			}
			
			if (!empty($data['filter_ocfilter'])){
				$params['body']['query']['bool']['filter'][] = [ 'term'  => [ 'filter_ocfilter' => $data['filter_ocfilter'] ] ];
			}
			
			if (!empty($data['filter_category_id'])){
				$params['body']['query']['bool']['filter'][] = [ 'term'  => [ 'categories' => $data['filter_category_id'] ] ];
			}
			
			if (!empty($data['getTotal'])){
				unset($params['body']['from']);
				unset($params['body']['size']);
				unset($params['body']['sort']);
				unset($params['body']['suggest']);
				unset($params['body']['highlight']);				

				return self::validateCountResult($this->elastic->count($params));
			}
			
			if (!empty($data['count'])){
				$params['body']['aggs'] = [
			//	'manufacturers' => [ 'terms' => [ 'field' => 'manufacturer_id' ]],
				'categories' 	=> [ 'terms' => [ 'field' => 'categories' ]]
				];
			//	$params['body']['_source'] = 'categories';
				$params['body']['from'] = 0;
				$params['body']['size'] = 5000;
				unset($params['body']['sort']);
				unset($params['body']['suggest']);
				unset($params['body']['highlight']);
				return $this->elastic->search($params);
			}
			
			return $this->elastic->search($params);			
		}
		
		public function fuzzyCategories($index, $query, $field, $highlight, $suggest, $data = array()){
			
			$fuzziness = 1;
			if (!empty($data['fuzziness'])){
				$fuzziness = (int)$data['fuzziness'];
			}
			
			$limit = 5;
			if (!empty($data['limit'])){
				$limit = $data['limit'];
			}
			
			$params = [
			'index' => $index,
			'body'  	=> [
			'from' 		=> '0',
			'size'		=> $limit,
			'sort' => [	
			[ '_score' => 'desc' ]
			],		
			'query' 	=> [
			'bool' 		=>  [
			'must' 		=>  [ 'match' => [ $field => [ 'query' => $query, 'fuzziness' => $fuzziness, 'prefix_length' => 1, 'max_expansions' => 8, 'operator' => 'AND' ] ] ],
			'should'	=> [ 
			[ 'range' => [ 'priority' => [ 'lte' => self::COLLECTION_PRIORITY+10, 'boost' => 8.0 ] ] ],
			[ 'range' => [ 'priority' => [ 'lte' => self::CATEGORY_PRIORITY+10, 'boost' => 6.0 ] ] ], 
			[ 'range' => [ 'priority' => [ 'lte' => self::OCFILTER_PRIORITY_BRANDPAGE+10, 'boost' => 5.0 ] ] ],
			[ 'range' => [ 'priority' => [ 'lte' => self::OCFILTER_PRIORITY+10, 'boost' => 4.0 ] ] ],
			],			
			'minimum_should_match' => 0
			] ],
			'suggest' 	=> [ 
			'completition-suggestion' => ['prefix' => $query, 
			'completion' => ['field' => $suggest, 'size' => 4, 'skip_duplicates' => true, 
			'contexts' => ['suggest-priority' => [ ['context' => 'collection', 'boost' => 8], ['context' => 'category', 'boost' => 5], ['context' => 'ocfilterpage', 'boost' => 4] ]			
			]]
			]],
			'highlight' => [ 'pre_tags' => [ '<b>' ], 'post_tags' => [ '</b>' ], 'fields' => [ $highlight => [ 'require_field_match' => 'false', 'fragment_size' => 400,  'number_of_fragments' => 1 ] ] ]
			] ];
			
			return $this->elastic->search($params);
		}
		/* fuzzy search functions */


		public function validateResult($results){
			
			if (is_array($results['hits']) && (int)$results['hits']['total']['value'] > 0){
				return (int)$results['hits']['total']['value'];
			}
			
			return false;
		}
		
		public function validateCountResult($results){
			
			if (!empty($results['count'])){
				return $results['count'];
			}
			
			return 0;
		}				
		
		public function buildField($field){
			
			$result = $field . '_ru';
			if (!empty(self::$languages[$this->config->get('config_language_id')])){
				$result = $field . '_' . self::$languages[$this->config->get('config_language_id')];
			}
			
			return trim($result);
		}		
				
		public function checkUAName($name){
			
			if ($this->config->get('config_language_id') == 3){
				if (is_array($name)){
					$name = $name[1];
				}
			}
			
			return mb_ucfirst($name);
		}		
		
		public function prepareQueryExceptions($query){
			foreach ($this->settings['exceptions'] as $key => $value){
				$query = mb_strtolower($query);
				$key = mb_strtolower($key);
				
				if (trim($query) == $key){
					$query = $value;
				}
				
				$query = str_ireplace(' ' . $key, ' ' . $value, $query);
				$query = str_ireplace($key . ' ', $value . ' ', $query);
				$query = str_ireplace(' ' . $key . ' ', ' ' . $value . ' ', $query);
			}
			
			return $query;
		}
		
		public function parseAlternateName($alternate_name){
			$results = array();
			
			if (trim($alternate_name) && mb_strlen(trim(str_ireplace(PHP_EOL, '', $alternate_name))) > 2){
				$exploded = explode(PHP_EOL, $alternate_name);
				
				foreach ($exploded as $line){
					if (trim($line) && mb_strlen(trim(str_ireplace(PHP_EOL, '', $line))) > 2){
						$line = trim(str_ireplace(PHP_EOL, '', $line));
						$this->parseGlobalWordReplacements($line, $results);
					}				
				}
			}
			return $results;
		}
		
		private function parseGlobalWordReplacements($string, &$array){
			$array = array_values(array_unique($array));
			shuffle($array);
			$array = array_slice($array, 0, self::arrayLengthLimit);
			
			if (is_array($string)){
				$array = array_merge($array, $string);
				} else {
				$array[] = $string;
			}
			
			foreach ($this->settings['wordreplacements'] as $key => $value){
				foreach ($value as $line){
					if (is_array($string)){
						foreach ($string as $one){
							$array[] = str_ireplace($key, $line, $one);
						}
						} else {
						$array[] = str_ireplace($key, $line, $string);
					}
				}
			}
			
			$array = array_values(array_unique($array));
			shuffle($array);
			$array = array_slice($array, 0, self::arrayLengthLimit);			
			
			$array = array_values(array_unique($array));
			shuffle($array);
			$array = array_slice($array, 0, self::arrayLengthLimit); 
		}
		
		private function superPostitionOfReplacements(&$arrayReplacements, $arrayStrings){		
			foreach ($arrayReplacements as $lineFromReplace){
				foreach ($arrayStrings as $keyToReplace => $linesToReplace){
					foreach ($linesToReplace as $lineToReplace){
						$arrayReplacements[] = str_ireplace($keyToReplace, $lineToReplace, $lineFromReplace);
					}
				}						
			}
			
			$arrayReplacements = array_values(array_unique($arrayReplacements));
			shuffle($arrayReplacements);
			$arrayReplacements = array_slice($arrayReplacements, 0, self::arrayLengthLimit); 
			
			$arrayReplacements = array_values(array_unique($arrayReplacements));
		}				

		public function parseArrayToTranslit(&$params){			
			$tmp = $params;
			
			foreach ($tmp['body']['names'] as $tmp_name){	

				$string = $this->transliteratorRu->cyr2Lat($tmp_name);
				$params['body']['names'][] = $string;

//				$string = $this->transliteratorUk->cyr2Lat($tmp_name);
//				$params['body']['names'][] = $string;

				$string = str_replace('-', '', $tmp_name);				
				$params['body']['names'][] = $string;

				$string = str_replace('-', ' ', $tmp_name);				
				$params['body']['names'][] = $string;
			}		
			
			$params['body']['names'] = array_values(array_unique($params['body']['names']));
		}		

		public function addCollectionNamesToTheBeginning($collection, &$params){
			$tmp_names = $params['body']['names'];

			if (!empty($collection['name'])){			
				foreach ($tmp_names as $name){
					if (mb_stripos($name, self::collectionName($collection['name'])) === false){
						$params['body']['names'][] = self::collectionName($collection['name']) . ' ' . $name;
					}
				}
			}

			if (!empty($collection['alternate_name'])){
				foreach ($this->parseAlternateName($collection['alternate_name']) as $alternate_name){
					foreach ($tmp_names as $name){
						if (mb_stripos($name, self::collectionName($alternate_name)) === false){
							$params['body']['names'][] = self::collectionName($alternate_name) . ' ' . $name;
						}
					}					
				}
			}

			foreach ($params['body']['names'] as &$name){
				$name = implode(' ', array_unique(explode(' ', $name)));
			}

			$params['body']['names'] = array_values(array_unique($params['body']['names']));
		}
		
		private function decodeOcfilterPageOptions($path, $category_id){
			$path = trim($path, '/');
			$path = trim($path);
			
			$results = array();
			
			$keywords = explode('/', $path);			
			
			$current = false;
			$ocfilters = array();
			foreach ($keywords as $keyword){
				if ($option_id = $this->model_catalog_ocfilter->decodeOption($keyword, $category_id)){
					$current = $option_id;
					$ocfilters[$current] = array();
				}
				
				if ($current && $value_id = $this->model_catalog_ocfilter->decodeValue($keyword, $current)){
					$ocfilters[$current][] = $value_id;
				}
			}
			
			return $ocfilters;
		}
		
		private function getOcFilterValuesByOptionID($ocfilter_option_id){
			$results = array();
			$query = $this->db->query("SELECT * FROM oc_ocfilter_option_value_description WHERE option_id = '" . (int)$ocfilter_option_id ."'");
			
			if ($query->num_rows){
				
				foreach ($query->rows as $row){
					
					if ($alternate_names = $this->parseAlternateName($row['alternate_name'])){
						if (empty($results[$row['name']])){
							$results[$row['name']] = $alternate_names;
							} else {
							$results[$row['name']] = self::mergeArrays($results[$row['name']], $alternate_names);						
						}
					}
				}
			}
			
			return $results;			
		}
		
		private function getOcFilterValuesForReplacements($ocfilter_option_value_id){	
			$results = array();
			
			$query = $this->db->query("SELECT * FROM oc_ocfilter_option_value_description WHERE value_id = '" . (int)$ocfilter_option_value_id ."'");
			
			if ($query->num_rows){
				
				$tmp = array();
				
				foreach ($query->rows as $row){
					$tmp[] = $row;
					
					if (count($exploded = explode('/', $row['name'])) > 1){
						foreach ($exploded as $line){
							if (trim($line)){
								$row1 = $row;
								$row1['name'] = trim($line);
								$tmp[] = $row1;
							}
						}
					}
				}
				
				unset($row);
				foreach ($tmp as $row){
					if ($alternate_names = $this->parseAlternateName($row['alternate_name'])){											
						if (empty($results[$row['name']])){
							$results[$row['name']] = $alternate_names;
							} else {
							$results[$row['name']] = self::mergeArrays($results[$row['name']], $alternate_names);
						}
					}
				}
			}
			
			return $results;
		}				
		
		private function prepareOcfilterPageIndex($namequery, $ocfilter_page_id, $filter_ocfilter, $category_id, &$params){
			$mapping 	= self::createMappingToIDS($namequery, 'language_id', 'title');
			
			$params['body']['category_id'] 		= $category_id;
			$params['body']['ocfilter_page_id'] = $ocfilter_page_id;
			$params['body']['ocfilter_filter'] 	= encodeParamsToString($filter_ocfilter, $this->config);
			
			
			$params['body']['names'] = array();
			
			//Основная запись
			foreach (self::$languages as $language_id => $language_code){
				if (!empty($mapping[$language_id])){
					$params['body']['name_' . $language_code] = $mapping[$language_id];
					$this->parseGlobalWordReplacements($mapping[$language_id], $params['body']['names']);
				}		
				
				if (!empty($altmapping[$language_id])){
					$params['body']['names'] = self::mergeArrays($params['body']['names'], $this->parseAlternateName($altmapping[$language_id]));
				}
				
				if (!empty($params['body']['name_' . $language_code])){
					$params['body']['suggest_' . $language_code] = $params['body']['name_' . $language_code];
				}
				
			}
			
			//Все фильтры оцфильтра с альтименами
			foreach ($filter_ocfilter as $option_id => $value_ids){
				
				if ($option_id == self::brandsListingOcFilterValueID){
					$params['body']['priority'] = self::OCFILTER_PRIORITY_BRANDPAGE;
					echoLine('[EaptekaElastic] Повышенный приоритет, страница бренда!');
				}
				
				foreach ($value_ids as $value_id){
					$ocfilterValues = $this->getOcFilterValuesForReplacements($value_id);					
					self::superPostitionOfReplacements($params['body']['names'], $this->getOcFilterValuesForReplacements($value_id));
				}
			}
			
			self::parseArrayToNumbers($params);		
		}
		
		public function prepareCategoryIndex($namequery, $category_id, $manufacturer_id, $ocfilter_page_id, $collection_id, $filter_ocfilter, &$params){
			$mapping 	= self::createMappingToIDS($namequery, 'language_id', 'name');
			$altmapping = self::createMappingToIDS($namequery, 'language_id', 'alternate_name');
			
			$params['body']['category_id'] 		= $category_id;
			$params['body']['manufacturer_id'] 	= $manufacturer_id;
			$params['body']['collection_id'] 	= $collection_id;
			$params['body']['ocfilter_page_id'] = $ocfilter_page_id;
			$params['body']['ocfilter_filter'] 	= $filter_ocfilter;
			$params['body']['names'] = array();
			
			
			//Основная запись
			foreach (self::$languages as $language_id => $language_code){
				if (!empty($mapping[$language_id])){
					$params['body']['name_' . $language_code] = $mapping[$language_id];
					$this->parseGlobalWordReplacements($mapping[$language_id], $params['body']['names']);
				}				
				
				if (!empty($altmapping[$language_id])){
					$params['body']['names'] = self::mergeArrays($params['body']['names'], $this->parseAlternateName($altmapping[$language_id]));
				}
				
				if (!empty($params['body']['name_' . $language_code])){
					$params['body']['suggest_' . $language_code] = $params['body']['name_' . $language_code];
				}
			}		

		//	self::parseArrayToTranslit($params);
		}
		
		public function prepareProductIndex($namequery, $product_id, &$params){
			$mapping = self::createMappingToIDS($namequery, 'language_id', 'name');
			
			foreach (self::$languages as $language_id => $language_code){
				if (!empty($mapping[$language_id])){
					$params['body']['name_' . $language_code] = $mapping[$language_id];

					if (!empty($params['body']['name_' . $language_code])){
					//	$params['body']['suggest_' . $language_code] = $params['body']['name_' . $language_code];
					}
					
					$nameWithOptions = $mapping[$language_id];
					$ocfilterProductValuesQuery = $this->db->query("SELECT name FROM oc_ocfilter_option_value_description WHERE value_id IN (SELECT value_id FROM oc_ocfilter_option_value_to_product WHERE product_id = '" . (int)$product_id . "') AND language_id = '" . (int)$language_id . "' AND option_id IN (10039, 10035, 10051, 10019)");
					
					foreach ($ocfilterProductValuesQuery->rows as $row){
						$row['name'] = trim(mb_strtolower($row['name']));
						
						if (mb_strlen($row['name']) && !is_numeric($row['name']) && mb_stripos($nameWithOptions, $row['name']) === false){
							$nameWithOptions .= ' ' . $row['name'];
						}
					}

					$this->parseGlobalWordReplacements($mapping[$language_id], $params['body']['names']);					
				//	$this->parseGlobalWordReplacements($nameWithOptions, $params['body']['names']);					
				}			
			}
			
			
			$ocfilterProductValuesQuery = $this->db->query("SELECT value_id FROM oc_ocfilter_option_value_to_product WHERE product_id = '" . (int)$product_id . "'");
			foreach ($ocfilterProductValuesQuery->rows as $row){
				$value_id = $row['value_id'];							
				$ocfilterValues = $this->getOcFilterValuesForReplacements($value_id);	
			//	self::superPostitionOfReplacements($params['body']['names'], $ocfilterValues);				
			}

			//Collection
			$collectionQuery = $this->db->query("SELECT name, alternate_name FROM oc_collection_description WHERE collection_id = (SELECT collection_id FROM oc_product_to_collection WHERE product_id = '" . (int)$product_id . "' AND main_collection = 1 LIMIT 1)");
					
			foreach ($collectionQuery->rows as $row){
				self::addCollectionNamesToTheBeginning($row, $params);
			}

			self::parseArrayToTranslit($params);
		}
				
		public function recreateIndices(){
			
			$deleteParams = [
			'index' => 'categories'
			];

			try{
				$response = $this->elastic->indices()->delete($deleteParams);
			} catch (\Exception $e){
				echoLine($e->getMessage());
			}
			
			$createParams = [
			'index' => 'categories',
			'body'  => [
			'settings' => [ 'analysis' => [ 
			'filter' => [
			'ru_stop' => [ 'type' => 'stop', 'stopwords' => '_russian_' ],
			'en_stop' => [ 'type' => 'stop', 'stopwords' => '_english_' ],
			'ua_stop' => [ 'type' => 'stop', 'stopwords' => '_ukrainian_' ],
			'ru_stemmer' => [ 'type' => 'stemmer', 'language' => 'russian' ],
			'en_stemmer' => [ 'type' => 'stemmer', 'language' => 'english' ],
			'ua_stemmer' => [ 'type' => 'stemmer', 'language' => 'russian' ],
			'phonemas'   => [ 'type' => 'phonetic', 'replace' => 'false', 'encoder' => 'refined_soundex'],
			],
			'char_filter' => [ 'ru_en_key' => [
			'type' => 'mapping', 
			'mappings' => [
				'a => ф','b => и','c => с','d => в','e => у','f => а','g => п','h => р','i => ш','j => о','k => л','l => д','m => ь','n => т','o => щ','p => з','r => к','s => ы','t => е','u => г','v => м','w => ц','x => ч','y => н','z => я','A => Ф','B => И','C => С','D => В','E => У','F => А','G => П','H => Р','I => Ш','J => О','K => Л','L => Д','M => Ь','N => Т','O => Щ','P => З','R => К','S => Ы','T => Е','U => Г','V => М','W => Ц','X => Ч','Y => Н','Z => Я','[' => 'х', '] => ъ','; => ж','< => б','> => ю'
			] ],
			'remove symbols' => [
				'type' 			=> 'pattern_replace',
				'pattern' 		=> '[^A-Za-zА-Яа-я0-9ЄЇєї ]',        		
       		 	'replacement' 	=> ''
			] ],
			'analyzer' => [
			'russian' 			=> [ 'char_filter' => [ 'html_strip', 'remove symbols', 'ru_en_key' ], 'tokenizer' => 'standard', 'filter' => ['lowercase', 'ru_stop', 'en_stop', 'ru_stemmer', 'en_stemmer', 'phonemas'] ],
			'ukrainian' 		=> [ 'char_filter' => [ 'html_strip', 'remove symbols', 'ru_en_key' ], 'tokenizer' => 'standard', 'filter' => ['lowercase', 'ua_stop', 'en_stop', 'ua_stemmer', 'en_stemmer', 'phonemas'] ],
			'russian_ukrainian' => [ 'char_filter' => [ 'html_strip', 'remove symbols', 'ru_en_key' ], 'tokenizer' => 'standard', 'filter' => ['lowercase', 'ru_stop', 'ua_stop', 'en_stop', 'ru_stemmer', 'ua_stemmer', 'en_stemmer', 'phonemas' ] ],
			'integer' 	=> [ 'char_filter' => [ 'html_strip' ], 'tokenizer' => 'standard']
			] ] ],			
			'mappings' 	=> [ 'properties' => [
			'category_id' 			=> [ 'type' => 'integer', 'index' => 'false' ],
			'manufacturer_id' 		=> [ 'type' => 'integer', 'index' => 'false' ],
			'collection_id' 		=> [ 'type' => 'integer', 'index' => 'false' ],
			'image' 				=> [ 'type' => 'text', 'index' => 'false' ],
			'total_products'		=> [ 'type' => 'integer', 'index' => 'false' ],
			'ocfilter_page_id' 		=> [ 'type' => 'integer', 'index' => 'true' ],			
			'ocfilter_page_keyword' => [ 'type' => 'text', 'index' => 'true' ],
			'ocfilter_page_params'  => [ 'type' => 'text', 'index' => 'true' ],
			'ocfilter_filter' 		=> [ 'type' => 'text', 'index' => 'true' ],
			'priority'				=> [ 'type' => 'integer', 'index' => 'true' ],
			'type'					=> [ 'type' => 'text', 'index' => 'true' ],
			'suggest_ru' 			=> [ 'type' => 'completion', 'preserve_separators' => 'false', 'preserve_position_increments' => 'false', 'analyzer' => 'russian', 'index' => 'true', 'contexts' => [[ 'name' => 'suggest-priority', 'type' => 'category', 'path' => 'type'  ]] ],
			'suggest_ua' 			=> [ 'type' => 'completion', 'preserve_separators' => 'false', 'preserve_position_increments' => 'false', 'analyzer' => 'ukrainian', 'index' => 'true', 'contexts' => [[ 'name' => 'suggest-priority', 'type' => 'category', 'path' => 'type'  ]] ],
			'name_ru' 				=> [ 'type' => 'text', 'analyzer' => 'russian', 'index' => 'true' ], 			
			'name_ua' 				=> [ 'type' => 'text', 'analyzer' => 'ukrainian', 'index' => 'true' ],  
			'names' 				=> [ 'type' => 'text', 'analyzer' => 'russian_ukrainian', 'index' => 'true' ]
			] ]
			] ];
			
			try{
			$response =  $this->elastic->indices()->create($createParams);	
			} catch (\Exception $e){
				echoLine($e->getMessage());
			}			
			
			$deleteParams = [
			'index' => 'products'
			];
			
			try{
			//	$response = $this->elastic->indices()->delete($deleteParams);
			} catch (\Exception $e){
				echoLine($e->getMessage());
			}
			
			$createParams = [
			'index' => 'products',
			'body'  => [
			'settings' => [ 'analysis' => [ 'filter' => [
			'ru_stop' => [ 'type' => 'stop', 'stopwords' => '_russian_' ],
			'en_stop' => [ 'type' => 'stop', 'stopwords' => '_english_' ],
			'ua_stop' => [ 'type' => 'stop', 'stopwords' => '_ukrainian_' ],
			'ru_stemmer' => [ 'type' => 'stemmer', 'language' => 'russian' ],
			'en_stemmer' => [ 'type' => 'stemmer', 'language' => 'english' ],
			'ua_stemmer' => [ 'type' => 'stemmer', 'language' => 'russian' ],
			'phonemas'   => [ 'type' => 'phonetic', 'replace' => 'false', 'encoder' => 'refined_soundex'],
			'edge_ngram' => ['type' => 'edge_ngram', 'min_gram' => 4, 'max_gram' => 10]		
			],
			'char_filter' => [ 'ru_en_key' => [
			'type' => 'mapping', 
			'mappings' => [
				'a => ф','b => и','c => с','d => в','e => у','f => а','g => п','h => р','i => ш','j => о','k => л','l => д','m => ь','n => т','o => щ','p => з','r => к','s => ы','t => е','u => г','v => м','w => ц','x => ч','y => н','z => я','A => Ф','B => И','C => С','D => В','E => У','F => А','G => П','H => Р','I => Ш','J => О','K => Л','L => Д','M => Ь','N => Т','O => Щ','P => З','R => К','S => Ы','T => Е','U => Г','V => М','W => Ц','X => Ч','Y => Н','Z => Я','[' => 'х', '] => ъ','; => ж','< => б','> => ю'
			] ],
			'remove symbols' => [
				'type' 			=> 'pattern_replace',
				'pattern' 		=> '[^A-Za-zА-Яа-я0-9ЄЇєї ]',        		
       		 	'replacement' 	=> ''
			] ],
			'analyzer' => [
			'russian' 		=> [ 'char_filter' => [ 'html_strip', 'remove symbols', 'ru_en_key' ], 'tokenizer' => 'standard', 'filter' => ['lowercase', 'ru_stop', 'en_stop', 'ru_stemmer', 'en_stemmer', 'edge_ngram', 'phonemas'] ],
			'ukrainian' 	=> [ 'char_filter' => [ 'html_strip', 'remove symbols', 'ru_en_key' ], 'tokenizer' => 'standard', 'filter' => ['lowercase', 'ua_stop', 'en_stop', 'ua_stemmer', 'en_stemmer', 'edge_ngram', 'phonemas'] ],
			'names' 		=> [ 'char_filter' => [ 'html_strip', 'remove symbols', 'ru_en_key' ], 'tokenizer' => 'standard', 'filter' => ['lowercase', 'ru_stop', 'en_stop', 'ru_stemmer', 'en_stemmer', 'phonemas'] ],
			'ukrainian' 	=> [ 'char_filter' => [ 'html_strip', 'ru_en_key' ], 'tokenizer' => 'standard', 'filter' => ['lowercase', 'ua_stop', 'en_stop', 'ua_stemmer', 'en_stemmer', 'edge_ngram', 'phonemas'] ],
			'integer' 		=> [ 'char_filter' => [ 'html_strip' ], 'tokenizer' => 'standard'],
			'identifier' 	=> [ 'char_filter' => [ 'html_strip' ], 'tokenizer' => 'standard', 'filter' => ['lowercase']]
			] ] ],			
			'mappings' 	=> [ 'properties' => [
			'category_id' 		=> [ 'type' => 'integer', 'index' => 'true' ],
			'manufacturer_id' 	=> [ 'type' => 'integer', 'index' => 'true' ],
			'collection_id' 	=> [ 'type' => 'integer', 'index' => 'true' ],
			'product_id' 		=> [ 'type' => 'integer', 'index' => 'true' ],
			'priority'			=> [ 'type' => 'integer', 'index' => 'true' ],
			'sort_order'		=> [ 'type' => 'integer', 'index' => 'true' ],
			'viewed'			=> [ 'type' => 'integer', 'index' => 'true' ],
			'price'				=> [ 'type' => 'float', 'index' => 'true' ],
			'special'			=> [ 'type' => 'float', 'index' => 'true' ],
			'status'			=> [ 'type' => 'integer', 'index' => 'true' ],			
			'is_receipt'		=> [ 'type' => 'integer', 'index' => 'true' ],
			'name_ru' 			=> [ 'type' => 'text', 'analyzer' => 'russian', 'index' => 'true' ], 
			'name_ua' 			=> [ 'type' => 'text', 'analyzer' => 'ukrainian', 'index' => 'true' ],  
			'names' 			=> [ 'type' => 'text', 'analyzer' => 'names', 'index' => 'true' ],
			'atxes'				=> [ 'type' => 'text', 'analyzer' => 'russian', 'index' => 'true' ],
			'farmgorups'		=> [ 'type' => 'text', 'analyzer' => 'russian', 'index' => 'true' ],		
			'ean'				=> [ 'type' => 'text', 'analyzer' => 'identifier', 'index' => 'true' ],
			'identifier'		=> [ 'type' => 'text', 'analyzer' => 'identifier', 'index' => 'true' ],
			'stock_status_id'	=> [ 'type' => 'integer', 'index' => 'true' ],
			'quantity'			=> [ 'type' => 'integer', 'index' => 'true' ],
			'stock'				=> [ 'type' => 'integer', 'index' => 'true' ],
			'categories'  		=> [ 'type' => 'integer', 'index' => 'true' ]
			] ]
			] ];
			
			try{
				$response = $this->elastic->indices()->create($createParams);		
			} catch (\Exception $e){
				echoLine($e->getMessage());
			}
			
			return $this;		
		}
		
		public function completition($index, $query, $suggest, $data = array()){
			
			$fuzziness = 1;
			if (!empty($data['fuzziness'])){
				$fuzziness = (int)$data['fuzziness'];
			}
			
			$limit = 10;
			if (!empty($data['limit'])){
				$limit = $data['limit'];
			}
			
			$params = [
			'index' 	=> $index,
			'body'  	=> [
			'from' 		=> '0',
			'size'		=> $limit,
			'suggest' 	=> [ 
			'completition-suggestion' => ['prefix' => $query, 
			'completion' 	=> ['field' => $suggest, 'size' => $limit, 'skip_duplicates' => true, 
			'contexts' 		=> ['suggest-priority' => [ ['context' => 'category', 'boost' => 5], ['context' => 'ocfilterpage', 'boost' => 4] ]]			
			]]
			],
			] ];
						
			return $this->elastic->search($params);
		}
		
		public function sku($query){
			
			$query = trim(str_ireplace(array('-', '.', '/', ' '), '', $query));
			
			$params = [
			'index' => 'products',
			'body'  	=> [
			'from' 		=> '0',
			'size'		=> '10',
			'sort' => [				
			'_score'
			],
			'query' 	=> [
			'match' => [ 'identifier' => $query ]
			],			
			] ];
			
			return $this->elastic->search($params);
		}		
		
		public function deleteUnexistentProduct($product_id){
		
			$params = [
			'index' => 'products',
			'id'    => $product_id
			];
			
			
			$response = $this->elastic->delete($params);
		}

		public function reindexproduct($product_id){			
			$this->indexproduct($product_id);
		}

		public function indexproduct($product_id){
				$product = $this->model_catalog_product->getProduct($product_id, true);

				if (!$product){
					echoLine('[EaptekaElastic] Товар не существует ' . $product_id);
					return;
				}
				
				echoLine('[EaptekaElastic] Товар ' . $product_id);
				$i++;
				
				$params = [];
				$params['index'] 	= 'products';
				$params['id'] 		= $product_id;				
				$params['body'] 	= array();
				$params['body']['priority'] = self::CATEGORY_PRIORITY;
				
				$params['body']['manufacturer_id'] 	= $product['manufacturer_id'];
				$params['body']['collection_id'] 	= $product['collection_id'];
				$params['body']['manufacturer'] 	= $product['manufacturer'];
				$params['body']['product_id'] 		= $product['product_id'];
				$params['body']['stock_status_id'] 	= $product['stock_status_id'];
				$params['body']['quantity'] 		= $product['quantity'];
				$params['body']['stock'] 			= (int)($product['quantity'] > 0);
				$params['body']['status'] 			= $product['status'];
				
				$params['body']['sort_order']  		= $product['sort_order'];
				$params['body']['viewed']  			= $product['viewed'];
				$params['body']['price']  			= $product['price'];
				$params['body']['special']  		= $product['special'];		
				$params['body']['ean'] 				= self::makeIdentifiersArray($product['ean']);
				
				$params['body']['identifier'] = array_values(array_unique(array_merge($params['body']['ean'])));
				
				if ($product['status']){
					//Индексация фармгруппы и ATX


					//Индексация названий
					$namequery = $this->db->query("SELECT TRIM(name) as name, language_id FROM oc_product_description WHERE product_id = '" . (int)$product_id . "'");		
					$this->prepareProductIndex($namequery, $product_id, $params);	
					
					//Привязка к категориям
					$catquery = $this->db->query("SELECT category_id FROM oc_product_to_category WHERE product_id = '" . (int)$product['product_id'] . "' AND main_category = 1 AND category_id NOT IN (SELECT category_id FROM oc_category WHERE parent_id = 1 OR status = 0)");
					$mapping = self::createMappingToNonEmpty($catquery, 'category_id');
					self::createIndexArray($mapping, 'categories', $params);			
				}				
				
				$response = $this->elastic->index($params);
		}
				
		public function productsindexer(){			
			$query = $this->db->query("SELECT DISTINCT(product_id) FROM oc_product WHERE 1 ORDER BY product_id ASC");		
			
			$i = 1;
			foreach ($query->rows as $row){
				echoLine('[productsindexer]' . $i . '/' . $query->num_rows);
				$i++;

				$this->indexproduct($row['product_id']);				
			}						
			
			return $this;
		}
		
		public function indexer(){
			$this->load->model('catalog/category');
			$this->load->model('catalog/product');

			$query = $this->db->query("SELECT collection_id, image FROM oc_collection WHERE status = 1");
			$i = 1;
			foreach ($query->rows as $collection){
				$collection_id = (int)$collection['collection_id'];

				$params = [];
				$params['index'] 					= 'categories';
				$params['id'] 						= $i;$i++;				
				$params['body'] 					= [];
				$params['body']['priority'] 		= self::COLLECTION_PRIORITY;
				$params['body']['type']				= 'collection';
				$params['body']['image']			= $collection['image'];
				$params['body']['total_products']	= 1;

				//Индексация названий
				$namequery = $this->db->query("SELECT TRIM(name) as name, alternate_name as alternate_name, language_id FROM oc_collection_description WHERE collection_id = '" . $collection_id . "'");										
				$tmpCategoryName = $namequery->row['name'];
				echoLine('[EaptekaElastic] Коллекция ' . $tmpCategoryName);				
				$this->prepareCategoryIndex($namequery, 0, 0, 0, $collection_id, '', $params);					
				$response = $this->elastic->index($params);
			}

			$params = [
			'index' => 'categories',
			'id'    => $i-1
			];
			
			
			$response = $this->elastic->get($params);
			print_r($response);


			$query = $this->db->query("SELECT category_id FROM oc_category WHERE status = 1 AND parent_id <> 1");
			foreach ($query->rows as $category){
				$category_id = (int)$category['category_id'];
				
				$params = [];
				$params['index'] 					= 'categories';
				$params['id'] 						= $i;$i++;				
				$params['body'] 					= [];
				$params['body']['priority'] 		= self::CATEGORY_PRIORITY;
				$params['body']['type']				= 'category';
				$params['body']['total_products']	= $this->model_catalog_product->getTotalProducts(['filter_category_id' 	=> $category_id, 'filter_sub_category' 	=> true,'filter_notnull_price'  => true]);				
				
				//Индексация названий
				$namequery = $this->db->query("SELECT TRIM(name) as name, alternate_name as alternate_name, language_id FROM oc_category_description WHERE category_id = '" . $category_id . "'");										
				$tmpCategoryName = $namequery->row['name'];
				echoLine('[EaptekaElastic] Категория ' . $tmpCategoryName);				
				$this->prepareCategoryIndex($namequery, $category_id, 0, 0, 0, '', $params);					
				$response = $this->elastic->index($params);

				$page_query = $this->db->query("SELECT ocfilter_page_id, params, keyword FROM oc_ocfilter_page WHERE category_id = '" . $category_id . "' AND status = 1");
				//Надо дешифровать значение опций
				foreach ($page_query->rows as $page){								
					$filter_ocfilter = $this->decodeOcfilterPageOptions($page['params'], $category_id);
					
					if ($filter_ocfilter){
						$namequery = $this->db->query("SELECT title as title, language_id FROM oc_ocfilter_page_description WHERE ocfilter_page_id = '" . $page['ocfilter_page_id'] . "'");
						
						echoLine('[EaptekaElastic] Категория ' . $tmpCategoryName . ', страница OCF: ' . $namequery->row['title']);
						
						$params = [];
						$params['index'] = 'categories';
						$params['id'] = $i;$i++;				
						$params['body'] = array();
						$params['body']['ocfilter_page_keyword'] 	= $page['keyword'];
						$params['body']['ocfilter_page_params'] 	= $page['params'];
						$params['body']['priority'] 			= self::OCFILTER_PRIORITY;	
						$params['body']['type']					= 'ocfilterpage';
						
						$this->prepareOcfilterPageIndex($namequery, $page['ocfilter_page_id'], $filter_ocfilter, $category_id, $params);	
						
						$response = $this->elastic->index($params);
					}
				}
			}	
			
			
			$params = [
			'index' => 'categories',
			'id'    => $i-1
			];
			
			
			$response = $this->elastic->get($params);
			print_r($response);
			
			return $this;			
		}
		
	}																																						