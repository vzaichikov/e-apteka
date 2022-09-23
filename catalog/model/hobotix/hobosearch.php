<?php
	
	class ModelHobotixHoboSearch extends Model {
		
		
		private function prepareMatch($field, $search){
			
			return " MATCH (" . $field . ") AGAINST ('" . $this->db->escape($search) . "' IN NATURAL LANGUAGE MODE) ";
			
		}
		
		private function prepareOrFilter($string){
			$result = array($string);
			
			if ($string != orfFilter($string)){
				$result[] = orfFilter($string);
			}
			
			if ($string != orfFilter($string, 1)){
				$result[] = orfFilter($string, 1);
			}
			
			return $result;
		}
		
		private function makeExcludeArray($field, $array){
			$result = array();
			
			foreach ($array as $item){
				if (!empty($item[$field])){
					$result[] = $item[$field];
				}
			}
			
			return array_unique($result);
		}
		
		private function prepareProductSQL($position, $sqlInsertion, $orderBy, $limit, $excludeArray = array()){
			
			$sql = "SELECT DISTINCT pd.product_id, '" . $position . "' as 'source'
			FROM ". DB_PREFIX . "product_description pd
			LEFT JOIN " . DB_PREFIX . "product p ON (pd.product_id = p.product_id) 
			LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) ";
			$sql .= " WHERE ";
			
			$sql .= $sqlInsertion;
			
			if ($excludeArray){
				$sql .= " AND pd.product_id NOT IN ('" . implode(',', array_map('intval', $excludeArray)) . "') ";
			}
			
			$sql .= " AND p2s.store_id = '" . $this->config->get('config_store_id') . "' AND
			p.status = 1 AND
			p.price > 0 AND
			p.quantity > 0		
			GROUP BY p.product_id
			ORDER BY " . $orderBy . "
			LIMIT " . $limit . "";
			
			return $sql;
		}
		
		
		private function prepareCategorySQL($position, $sqlInsertion, $orderBy, $limit, $excludeArray = array()){
			
			$sql = "SELECT DISTINCT c.category_id, cd.name, cd.seo_name, c.image, '" . $position . "' as 'source'
			FROM ". DB_PREFIX . "category_description cd
			LEFT JOIN ". DB_PREFIX . "category c ON (c.category_id = cd.category_id)
			LEFT JOIN ". DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) 
			WHERE ";
			
			$sql .= $sqlInsertion;
			
			if ($excludeArray){
				$sql .= " AND cd.category_id NOT IN ('" . implode(',', array_map('intval', $excludeArray)) . "')";
			}
			
			$sql .= " AND
			c2s.store_id = '" . $this->config->get('config_store_id') . "' AND
			c.status = 1			
			GROUP BY cd.category_id 			
			ORDER BY " . $orderBy . "
			LIMIT " . $limit . "";	
			
			return $sql;
		}
		
		private function prepareCollectionSQL($position, $sqlInsertion, $orderBy, $limit, $excludeArray = array()){
			
			$sql = "SELECT DISTINCT c.collection_id, cd.name, c.image, '" . $position . "' as 'source'
			FROM ". DB_PREFIX . "collection_description cd
			LEFT JOIN ". DB_PREFIX . "collection c ON (c.collection_id = cd.collection_id)
			LEFT JOIN ". DB_PREFIX . "collection_to_store c2s ON (c.collection_id = c2s.collection_id) 
			WHERE ";
			
			$sql .= $sqlInsertion;
			
			if ($excludeArray){
				$sql .= " AND cd.collection_id NOT IN ('" . implode(',', array_map('intval', $excludeArray)) . "')";
			}
			
			$sql .= " AND
			c2s.store_id = '" . $this->config->get('config_store_id') . "' AND
			c.status = 1			
			GROUP BY cd.collection_id 			
			ORDER BY " . $orderBy . "
			LIMIT " . $limit . "";	
			
			return $sql;
		}
		
		
		public function getProducts($data){
			
			$count = 0;
			$excludeArray = array();
			$result = array();
			
			if (!empty($data['limit'])){
				$limit = (int)$data['limit'];
				} else {
				$limit = 5;
			}
			
			//Исправляем возможные опечатки
			$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['search'])));			
			$data['search'] = normalizeKeyErrString($data['search']);							
			
			//В НАЧАЛЕ СТРОКИ
			$search = $this->db->escape($data['search']);
			
			$sqlInsertion = " (  normalized_name LIKE ('" . $search . "%') ) ";				
			$sql = $this->prepareProductSQL('exactbegin', $sqlInsertion, ' pd.name DESC ', $limit, $excludeArray);
			$query = $this->db->query($sql);
			
			if ($query->num_rows >= $limit){
				return array_merge($result, $query->rows);			
				} else {				
				$result = $result + $query->rows;
				$excludeArray = array_merge($excludeArray, $this->makeExcludeArray('product_id', $query->rows));
			}				
			
			//В СЕРЕДИНЕ СТРОКИ
			$search = $this->db->escape($data['search']);			
			$sqlInsertion = " (  normalized_name LIKE ('%" . $search . "%') ";			
			if (count($words) > 1){
				$implode = array();
				
				foreach ($words as $word) {
					if (mb_strlen(trim($word)) >= 2){
						$implode[] = "LOWER(pd.name) LIKE '%" . $this->db->escape(normalizeKeyErrString($word)) . "%'";
					}
				}
				
				if ($implode) {
					$sqlInsertion .= " OR ( " . implode(" AND ", $implode) . " ) ";
				}								
			}
			
			if (count($words) > 1){
				$implode = array();
				
				foreach ($words as $word) {
					if (mb_strlen(trim($word)) >= 2){
						$implode[] = "LOWER(pd.name) LIKE '%" . $this->db->escape($word) . "%'";
					}
				}
				
				if ($implode) {
					$sqlInsertion .= " OR ( " . implode(" AND ", $implode) . " ) ";
				}								
			}	
			$sqlInsertion .= " ) ";			

			$sql = $this->prepareProductSQL('exactmiddle', $sqlInsertion, ' pd.name DESC ', ($limit - count($result)), $excludeArray);
			$query = $this->db->query($sql);
		
			if ($query->num_rows >= ($limit - count($result))){
				return array_merge($result, $query->rows);		
				} else {				
				$result = $result + $query->rows;
				$excludeArray = array_merge($excludeArray, $this->makeExcludeArray('product_id', $query->rows));
			}
			
			//По первому слову SOUNDEX Лекарственные средства
			$search = $this->db->escape(transSoundex($data['search']));
			
			$sqlInsertion = " (is_searched = 1 AND soundex_firstword LIKE ('" . $search . "%') ) ";
			$sql = $this->prepareProductSQL('soundex_firstword', $sqlInsertion, $this->prepareMatch('normalized_firstword', $search) . ' DESC ', ($limit - count($result)), $excludeArray);
			$query = $this->db->query($sql);
			
			if ($query->num_rows >= ($limit - count($result))){
				return $result + $query->rows;			
				} else {				
				$result = $result + $query->rows;
				$excludeArray = array_merge($excludeArray, $this->makeExcludeArray('product_id', $query->rows));
			}		
			
			//Нечеткий поиск по первому слову, лекарственные средства
			$search = $this->db->escape(normalizeString($data['search']));
			
			$sqlInsertion = " ( " . $this->prepareMatch('normalized_firstword, normalized_name', $search) . " ) ";
			$sql = $this->prepareProductSQL('ngram_full', $sqlInsertion, ' is_searched = 1 DESC, ' .$this->prepareMatch('normalized_firstword', $search) . ' DESC ', ($limit - count($result)), $excludeArray);
			$query = $this->db->query($sql);
			
			if ($query->num_rows >= ($limit - count($result))){
				return array_merge($result, $query->rows);		
				} else {				
				$result = $result + $query->rows;
				$excludeArray = array_merge($excludeArray, $this->makeExcludeArray('product_id', $query->rows));
			}
			
			
			//Нечеткий поиск по всем словам
			$search = $this->db->escape(normalizeString($data['search']));
			
			$sqlInsertion = " ( " . $this->prepareMatch('normalized_name', $search) . " ) ";
			$sql = $this->prepareProductSQL('ngram', $sqlInsertion, $this->prepareMatch('normalized_name', $search) . ' DESC ', ($limit - count($result)), $excludeArray);
			$query = $this->db->query($sql);
			
			
			if ($query->num_rows >= ($limit - count($result))){
				return array_merge($result, $query->rows);			
				} else {				
				$result = $result + $query->rows;
				$excludeArray = array_merge($excludeArray, $this->makeExcludeArray('product_id', $query->rows));
			}
			
			return $result;
		}
		
		public function getCategories($data){
			$count = 0;
			$result = array();
			$excludeArray = array();
			
			if (!empty($data['limit'])){
				$limit = (int)$data['limit'];
				} else {
				$limit = 5;
			}
			
			$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['search'])));
			$data['search'] = normalizeKeyErrString($data['search']);
			
			if (mb_strlen($data['search']) < 4){
				return array();
			}
			
			//Прямое вхождение слова в начале
			
			$search = $this->db->escape($data['search']);			
			$sqlInsertion = " ( normalized_name LIKE ('" . $search . "%') ) ";
			$sql = $this->prepareCategorySQL('exactbegin', $sqlInsertion, ' cd.name DESC ', $limit, $excludeArray);
			$query = $this->db->query($sql);
			
			if ($query->num_rows >= $limit){
				return $query->rows;
				} else {
				$result = $result + $query->rows;
				$excludeArray = $this->makeExcludeArray('category_id', $query->rows);
			}
			
			//Прямое вхождение слова в середине
			$search = $this->db->escape($data['search']);			
			$sqlInsertion = " (  normalized_name LIKE ('%" . $search . "%') ";			
			if (count($words) > 1){
				$implode = array();
				
				foreach ($words as $word) {
					if (mb_strlen(trim($word)) >= 2){
						$implode[] = " LOWER(cd.name) LIKE '%" . $this->db->escape(normalizeKeyErrString($word)) . "%'";
					//	$implode[] = " LOWER(cd.name) LIKE '%" . $this->db->escape(getWordRoot(normalizeKeyErrString($word))) . "%'";
					}
				}
				
				if ($implode) {
					$sqlInsertion .= " OR ( " . implode(" AND ", $implode) . " ) ";
				}								
			}			
			$sqlInsertion .= " ) ";
			$sql = $this->prepareCategorySQL('exactmiddle', $sqlInsertion, ' cd.name DESC ', ($limit - count($result)), $excludeArray);
			$query = $this->db->query($sql);											
			
			if ($query->num_rows >= ($limit - count($result))){
				return array_merge($result, $query->rows);			
				} else {	
				$result = $result + $query->rows;
				$excludeArray = array_merge($excludeArray, $this->makeExcludeArray('category_id', $query->rows));
			}	
			
			//SOUNDEX
			$search = $this->db->escape(transSoundex($data['search']));		
			
			$sqlInsertion = " ( soundex_name LIKE ('%" . $search . "%') ) ";
			$sql = $this->prepareCategorySQL('soundex', $sqlInsertion, $this->prepareMatch('normalized_name', $search) .' DESC', ($limit - count($result)), $excludeArray);
			$query = $this->db->query($sql);
			
			if ($query->num_rows >= ($limit - count($result))){
				return array_merge($result, $query->rows);			
				} else {				
				$result = $result + $query->rows;
				$excludeArray = array_merge($excludeArray, $this->makeExcludeArray('category_id', $query->rows));
			}	
			
			/*
				//NGRAM
				$search = $this->db->escape(normalizeString($data['search']));
				
				$sqlInsertion = $this->prepareMatch('normalized_name', $search);
				$sql = $this->prepareCategorySQL('ngram', $sqlInsertion, $this->prepareMatch('normalized_name', $search) .' DESC', ($limit - count($result)), $excludeArray);
				$query = $this->db->query($sql);
				
				if ($query->num_rows >= ($limit - count($result))){
				return array_merge($result, $query->rows);			
				} else {				
				$result = $result + $query->rows;
				$excludeArray = array_merge($excludeArray, $this->makeExcludeArray('category_id', $query->rows));
				}	
			*/	
			//var_dump($query);
			
			return $result;
			
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	}
