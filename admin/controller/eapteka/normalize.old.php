//Нормализация названий : товары
			$query = $this->db->query("UPDATE oc_product_description SET name = TRIM(name) WHERE 1");
			$query = $this->db->query("UPDATE oc_product_description SET original_name = TRIM(original_name) WHERE 1");
			$query = $this->db->query("SELECT product_id, language_id, name FROM oc_product_description WHERE 1");
			
			echo '[NORMALIZE] Нормализация товаров' . PHP_EOL;
			foreach ($query->rows as $row){
				
				echo $row['name'] . ' -> ' . firstWord($row['name']) . ' -> ' . transSoundex(firstWord($row['name'])) . ' -> ' . normalizeString($row['name']) . ' -> ' . normalizeKeyErrString($row['name']) . ' -> ' . transSoundex($row['name']) . PHP_EOL;
				
				$this->db->query("UPDATE oc_product_description SET normalized_firstword = '" . $this->db->escape(normalizeString(firstWord($row['name']))) . "', soundex_firstword = '" . $this->db->escape(transSoundex(firstWord($row['name']))) . "', normalized_name = '" . $this->db->escape(normalizeString($row['name'])) . "', soundex_name = '" . $this->db->escape(transSoundex($row['name'])) . "' WHERE product_id = '" . (int)$row['product_id'] . "' AND language_id = '" . (int)$row['language_id'] . "'");
			}
			
			//Нормализация названий : категории
			$query = $this->db->query("SELECT category_id, language_id, name FROM oc_category_description WHERE 1");
			
			echo '[NORMALIZE] Нормализация категорий' . PHP_EOL;
			foreach ($query->rows as $row){
				
				echo $row['name'] . ' -> ' . normalizeString($row['name']) . ' -> ' . normalizeKeyErrString($row['name']) . ' -> ' . transSoundex($row['name']) . PHP_EOL;
				
				$this->db->query("UPDATE oc_category_description SET normalized_name = '" . $this->db->escape(normalizeString($row['name'])) . "', soundex_name = '" . $this->db->escape(transSoundex($row['name'])) . "' WHERE category_id = '" . (int)$row['category_id'] . "' AND language_id = '" . (int)$row['language_id'] . "'");
			}
			
			//Нормализация названий : коллекции
			$query = $this->db->query("SELECT collection_id, language_id, name FROM oc_collection_description WHERE 1");
			
			echo '[NORMALIZE] Нормализация коллекций' . PHP_EOL;
			foreach ($query->rows as $row){
				
				echo $row['name'] . ' -> ' . normalizeString($row['name']) . ' -> ' . normalizeKeyErrString($row['name']) . ' -> ' . transSoundex($row['name']) . PHP_EOL;
				
				$this->db->query("UPDATE oc_collection_description SET normalized_name = '" . $this->db->escape(normalizeString($row['name'])) . "', soundex_name = '" . $this->db->escape(transSoundex($row['name'])) . "' WHERE collection_id = '" . (int)$row['collection_id'] . "' AND language_id = '" . (int)$row['language_id'] . "'");
			}