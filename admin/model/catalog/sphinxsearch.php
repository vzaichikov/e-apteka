<?php

require_once DIR_APPLICATION .'../catalog/model/catalog/sphinx.php';

class ModelCatalogSphinxsearch extends ModelCatalogSphinx {
	
	protected $_fields = array(
			'main' 			=> array(
								'columns' 	=> array(
													//Column - type
													 'id'					=> 'int',
													 'product_id' 			=> 'int',
													 'name' 				=> 'string', 
													 'description'			=> 'string',
													 'model' 				=> 'string',
													 'sku' 					=> 'string',
													 'ean' 					=> 'string',
													 'jan' 					=> 'string',
													 'isbn' 				=> 'string',
													 'mpn' 					=> 'string',
													 'price' 				=> 'float',
												 	 'quantity' 			=> 'int',
													 'stock_status_id' 		=> 'int',
													 'status'				=> 'int',
													 'rating' 				=> 'float',
													 'language_id' 			=> 'int',
													 'date_available' 		=> 'timestamp',
													 'categories_filter'	=> 'int',
													 'store_filter' 		=> 'int',
													 'product_attribute'	=> 'int'
												)
								),
			
			'categoryinfo' 	=> array(
								'columns' 	=> array(
													'id'					=> 'int',
													'category_id'			=> 'int',
													'language_id'			=> 'int',
													'name' 					=> 'string',
													'status'				=> 'int',
													'store_filter'			=> 'int'
												)
								),
			
			'suggestions' 	=> array(
								'columns' 	=> array(
													'id'					=> 'int',
													'keyword'				=> 'string',
													'len'					=> 'int',
													'trigrams'				=> 'string',
													'freq'					=> 'int'
												)
								)
	);

	
	public function install() {
	
		$this->db->query("
        CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "sphinx_suggestions` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `keyword` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
          `trigrams` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
          `freq` int(11) NOT NULL ,
          PRIMARY KEY (`id`),
		  UNIQUE KEY `keyword` (`keyword`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
	
	}
	
	/**
	 * @return Mysqli sphinx connection
	 */
	public function sphinxConnection() {
	
		if (null === $this->_sphinxConnection) {
			$sphinxConnection = new mysqli($this->config->get('sphinx_search_server'), DB_USERNAME, DB_PASSWORD, DB_DATABASE, 9306, '');
			$this->_sphinxConnection = $sphinxConnection;
		}
	
		return $this->_sphinxConnection;
	}

	public function insertOrReplace($index, $data) {

		$keys = array();
		$values = array();
	
		$action = 'insert';
		
		$dbc = $this->sphinxConnection();
		
		$index = $this->getSphinxIndex($index);
		
		foreach ($data as $key => $val) {
			
			if(array_key_exists($key, $this->_fields[$index]['columns'])) {
			
				$keys[$key] = '`'.$key.'`';
				
				if($this->_fields[$index]['columns'][$key] == 'string') {
					$values[$key] = "'".$this->db->escape($val)."'";
				} else { 
					$values[$key] = $val;
				}
			}
		}
		
		// Check if item with the provided id exists already
		$results = $dbc->query("SELECT * FROM ".$index." WHERE id = ".$values['id']);
			
		if($results->num_rows) {
			$action = 'replace';
		}

		if (is_array($index) || is_array($action)){
		die();	
		}
		
		$sql = strtoupper($action)." INTO ".$index." (".implode(',', $keys).") VALUES (".implode(", ", $values).")";
		
		$dbc->query($sql);
			
		if($dbc->error) {
			$this->log->write('Sphinx '.$index.' '.$action.' error: ' . $dbc->error);
		}
	
	}
	
	/**
	 * Delete record from index
	 * @param string $index - index name
	 * @param int $id - id to delete
	 */
	public function delete($index, $id) {
		//Get all languages
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();

		$dbc = $this->sphinxConnection();
		$index = $this->getSphinxIndex($index);
		
		foreach($languages as $lang) {
			$sql = "DELETE FROM ".$index." WHERE id = ".$this->properSphinxId($id, $lang['language_id']);
		
			$dbc->query($sql);
		
			if($dbc->error) {
				$this->log->write('Sphinx '.$index.' delete error: ' . $dbc->error);
			}
		}
	}
	
	/**
	 * Add keywords to suggestions table/index
	 * @param array $data - product description
	 * @return boolean
	 */
	public function addToSphinxSuggestions($data) {
	
		if(empty($data)) {
			return array('error' => 'No product\'s data found!');
		}
		
		$sphinxClient = $this->getSphinxClient();
		
		if(!empty($sphinxClient->_error) && $sphinxClient->_error != '') {
			return array('error' => $sphinxClient->_error);
		}
		
		$sphinxClient->SetMatchMode(SPH_MATCH_ALL);
	
		$this->db->query("START TRANSACTION;");
		$index = $this->getSphinxIndex('suggestions');
		$productsIndex = $this->getSphinxIndex('products');
		
		foreach ($data as $lang_id => $arr) {
			$keywords = $sphinxClient->buildKeywords($arr['name'], $productsIndex, true);
			
			if(empty($keywords) || !$keywords) {
				return array('error' => 'No words found. Please make sure you have generated the product and the category indexes, before generating suggestions!');
			}
			
			foreach ($keywords as $key => $arr) {
				if(!strlen($arr['tokenized']) > $this->MIN_KEYWORD_LEN) {
					continue;
				}
					
				$trigrams = $this->getKeywordTrigrams($arr['tokenized']);
				$freq = ($arr['hits']) ? $arr['hits'] : 1;	
				
				if(!$this->config->get('sphinx_config_index_type')) {
					$sql = "INSERT IGNORE INTO `" . DB_PREFIX . "sphinx_suggestions` (`keyword`, `trigrams`, `freq`)
																VALUES ('".$arr['tokenized']."', '".$trigrams."', ".$freq.");";
					$this->db->query($sql);
				} else {
					//Insert to rt index
					$dbc = $this->sphinxConnection();

					// Check if suggestion with the provided id exists already
					$results = $dbc->query("SELECT * FROM ".$index." WHERE MATCH('".$arr['tokenized']."');");
					if($results->num_rows) {
						continue;
					}
					
					$indexData = array(
							'id'		=> sprintf("%u", crc32($arr['tokenized'])),
							'keyword' 	=> $arr['tokenized'],
							'len'		=> strlen($arr['tokenized']),
							'trigrams' 	=> $trigrams,
							'freq' 		=> ($arr['hits']) ? $arr['hits'] : 1
					);
						
					$this->insertOrReplace($index, $indexData);
				}
			}
		}
		
		$this->db->query("COMMIT;");
		
		return true;
	
	}
	
	public function sphinxProduct($product_id, $data) {
		//Insert suggestions
		$this->addToSphinxSuggestions($data['product_description']);
		 
		if(!$this->config->get('sphinx_config_index_type')) {
			return;
		}

		//Prepare data
		$productInfo = $data['product_description'];
		unset($data['product_description']);
		
		$data['date_available'] = strtotime($data['date_available']);
		$data['price'] = ($data['price'] != '') ? $data['price'] : 0;
		$categoriesFilter = (implode(',', $this->model_catalog_product->getProductCategories($product_id)) != 0) ? '('.implode(',', $this->model_catalog_product->getProductCategories($product_id)).')' : '(0)';
		$data['categories_filter'] = $categoriesFilter;
		$storeFilter = (implode(',', $this->model_catalog_product->getProductStores($product_id)) != 0) ? '('.implode(',', $this->model_catalog_product->getProductStores($product_id)).')' : '(0)';
		$data['store_filter'] = $storeFilter;
		
		$productAttributes = $this->model_catalog_product->getProductAttributes($product_id);
		$prAttributes = array();
		if(is_array($productAttributes) && !empty($productAttributes)) {
			foreach ($productAttributes as $attribute) {
				$prAttributes[] = $attribute['attribute_id'];
			}
				
			$data['product_attribute'] = '('. implode(',', $prAttributes) .')';
		}
		
		foreach($productInfo as $lang_id => $info) {
			$info['id'] = $this->properSphinxId($product_id, $lang_id);
			$info['product_id'] = $this->properSphinxId($product_id, $lang_id);
			$info['language_id'] = $lang_id;
			
			$product = array_merge($info,$data);
			
			$this->insertOrReplace('products', $product);
		}
	}
	
	public function sphinxCategory($category_id, $data) {
		if(!$this->config->get('sphinx_config_index_type')) {
			return;
		}
		 
		//Prepare data
		$categoryInfo = $data['category_description'];
		unset($data['category_description']);
	
		foreach($categoryInfo as $lang_id => $info) {
			$info['id'] = $this->properSphinxId($category_id, $lang_id);
			$info['category_id'] = $this->properSphinxId($category_id, $lang_id);
			$info['language_id'] = $lang_id;
			$store_filter = (implode(',', $this->model_catalog_category->getCategoryStores($category_id)) != 0) ? '('.implode(',', $this->model_catalog_category->getCategoryStores($category_id)).')' : '(0)';
			$info['store_filter'] = $store_filter;
			$category = array_merge($info,$data);
			$this->insertOrReplace('categories', $category);
		}
	}
	
	public function getCategories($offset = 0, $limit = 100) {
	
		$sql = "SELECT * FROM " . DB_PREFIX . "category c 
					LEFT JOIN " . DB_PREFIX . "category_description cd ON c.category_id = cd.category_id
					LIMIT ". (int)$offset . "," . (int)$limit;
	
		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	
	public function getRatingByProductId($product_id) {
		
		$query = $this->db->query("SELECT AVG(r.rating) as rating
									FROM " . DB_PREFIX . "review r 
									LEFT JOIN " . DB_PREFIX . "product p ON (r.product_id = p.product_id) 
									LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
									WHERE p.product_id = '" . (int)$product_id . "' 
										AND p.date_available <= NOW() 
										AND p.status = '1' 
										AND r.status = '1' 
										AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
									GROUP BY p.product_id 
									");

		$rating = ($query->rows) ? $query->row['rating'] : 0;
		
		return $rating;
		
	}
	
	public function getTotalRows($table) {
		$query = $this->db->query("SELECT COUNT(*) AS count FROM " . DB_PREFIX . $table);
		$count = (int)$query->row['count'];
	
		return $count;
	}
	
	public function properSphinxId($id, $langId) {
		
		$theLang = $langId << 22;
		
		return ($id | $theLang);
		
	}
	
	public function sphinxMatchModes() {
	
		return array(
				'0' => 'SPH_MATCH_ALL',
				'1' => 'SPH_MATCH_ANY',
				'2' => 'SPH_MATCH_PHRASE',
				'3' => 'SPH_MATCH_BOOLEAN',
				'4' => 'SPH_MATCH_EXTENDED',
				'5' => 'SPH_MATCH_FULLSCAN',
				'6' => 'SPH_MATCH_EXTENDED2',
		);
	
	}
	
	public function sphinxSortModes() {
	
		return array(
				'0' => array( 'mode' => 'SPH_SORT_RELEVANCE'),
				'1' => array( 'mode' => 'SPH_SORT_ATTR_DESC', 'attrs' => $this->sphinxSortAttrs()),
				'2' => array( 'mode' => 'SPH_SORT_ATTR_ASC', 'attrs' => $this->sphinxSortAttrs()),
				'3' => array( 'mode' => 'SPH_SORT_TIME_SEGMENTS'),
				'4' => array( 'mode' => 'SPH_SORT_EXTENDED'),
				'5' => array( 'mode' => 'SPH_SORT_EXPR')
		);
	
	}
	
	public function sphinxRankingModes() {
	
		return array(
				'0' => 'SPH_RANK_PROXIMITY_BM25',
				'1' => 'SPH_RANK_BM25',
				'2' => 'SPH_RANK_NONE',
				'3' => 'SPH_RANK_WORDCOUNT',
				'4' => 'SPH_RANK_PROXIMITY',
				'5' => 'SPH_RANK_MATCHANY',
				'6' => 'SPH_RANK_FIELDMASK',
				'7' => 'SPH_RANK_SPH04',
				'8' => 'SPH_RANK_EXPR',
				'9' => 'SPH_RANK_TOTAL',
		);
	
	}
	
	public function sphinxSortAttrs() {
	
		return array(
				'name' => 'name',
				'description' => 'description',
				'model' => 'model',
				'sku' => 'sku',
				'ean' => 'ean',
				'jan' => 'jan',
				'isbn' => 'isbn',
				'mpn' => 'mpn',
				'price' => 'price'
		);
	
	}
	
	
}