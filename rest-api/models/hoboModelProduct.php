<?

namespace hobotix;

class hoboModelProduct extends hoboModel{	

	public function getProductIdsByUUID($uuids){
		$result = [];

		foreach ($uuids as $uuid){
			$result[$uuid] = false;
		}

		$uuids = array_map(array($this, 'escape'), $uuids);		

		$query = $this->db->query("SELECT uuid, product_id FROM oc_product WHERE uuid IN (" . implode(',', $uuids) . ")");		
		if ($query->num_rows){
			foreach ($query->rows as $row){
				$result[$row['uuid']] = $row['product_id'];
			}

			return $result;
		}

		return false;
	}

	public function getAllIdToUUIDTable(){
		$result = [];

		$query = $this->db->query("SELECT uuid, product_id, ms_code FROM oc_product WHERE 1");	

		foreach ($query->rows as $row){
			$result[] = [
				'productUUID' 	=> $row['uuid'],
				'productMSCode'	=> $row['ms_code'],
				'productID' 	=> $row['product_id']
			];
		}

		return $result;
	}

	public function getProductIdByUUID($uuid){
		$query = $this->db->query("SELECT product_id, uuid FROM oc_product WHERE uuid = '" . $this->db->escape($uuid) . "'");		

		if ($query->num_rows){
			return $query->row['product_id'];
		}

		return false;
	}

	public function getProductByID($product_id){
		if (is_numeric($product_id)){
			$query = $this->db->query("SELECT * FROM oc_product p WHERE p.product_id = '" . (int)$product_id . "' LIMIT 1");
		} else {
			$query = $this->db->query("SELECT * FROM oc_product p WHERE uuid = '" . $this->db->escape($product_id) . "' LIMIT 1");
		}
		
		if ($query->num_rows){
			$description_query_RU = $this->db->query("SELECT * FROM oc_product_description WHERE product_id = '" . $query->row['product_id'] . "' AND language_id = '2'");
			$description_query_UA = $this->db->query("SELECT * FROM oc_product_description WHERE product_id = '" . $query->row['product_id'] . "' AND language_id = '3'");

			$manufacturer_description_query_RU = $this->db->query("SELECT md.name, m.uuid FROM oc_manufacturer_description md LEFT JOIN oc_manufacturer m ON (md.manufacturer_id = m.manufacturer_id) WHERE md.manufacturer_id = '" . $query->row['manufacturer_id'] . "' AND language_id = '2'");
			$manufacturer_description_query_UA = $this->db->query("SELECT md.name FROM oc_manufacturer_description md WHERE md.manufacturer_id = '" . $query->row['manufacturer_id'] . "' AND language_id = '3'");

			$pricegroup_query = $this->db->query("SELECT * FROM oc_price_group WHERE pricegroup_id = '" . $query->row['pricegroup_id'] . "'");
			
			$attributes_query_RU = $this->db->query("SELECT pad.name, pa.text FROM oc_product_attribute pa LEFT JOIN oc_attribute_description pad ON (pad.attribute_id = pa.attribute_id AND pad.language_id = '2') WHERE product_id = '" . $query->row['product_id'] . "' AND pa.language_id = '2'");
			$attributes_query_UA = $this->db->query("SELECT pad.name, pa.text FROM oc_product_attribute pa LEFT JOIN oc_attribute_description pad ON (pad.attribute_id = pa.attribute_id AND pad.language_id = '3') WHERE product_id = '" . $query->row['product_id'] . "' AND pa.language_id = '3'");

			$attributes_RU 		= [];
			$attributes_UA 		= [];
			$activeIngredients 	= [];

			foreach ($attributes_query_RU->rows as $row_RU){
				$attributes_RU[$row_RU['name']] = $row_RU['text'];
			}

			foreach ($attributes_query_UA->rows as $row_UA){
				$attributes_UA[$row_UA['name']] = $row_UA['text'];
			}

			for ($i=1; $i<=5; $i++){
				$found = [];
				if (!empty($attributes_RU['Действующее вещество ' . $i])){
					$found['ActiveIngredientName_RU'] = $attributes_RU['Действующее вещество ' . $i];
				}

				if (!empty($attributes_UA['Діюча речовина ' . $i])){
					$found['ActiveIngredientName_UA'] = $attributes_UA['Діюча речовина ' . $i];
				}

				if ($found){
					$activeIngredients[] = $found;
				}
			}

			return [
				'ProductUUID' 		=> $query->row['uuid'],
				'ProductDisabled' 	=> !$query->row['status'],
				'ProductName' 		=> $description_query_RU->row['name'],
				'ProductName_RU' 	=> $description_query_RU->row['name'],
				'ProductName_UA' 	=> $description_query_UA->row['name'],
				'PriceGroupID' 		=> $query->row['pricegroup_id'],
				'PriceGroupUUID' 	=> $pricegroup_query->row['uuid'],
				'PriceGroupNAME' 	=> $pricegroup_query->row['name'],		

				'ManufacturerUUID' 				=> $manufacturer_description_query_RU->row['uuid'],
				'ManufacturerName_RU' 			=> $manufacturer_description_query_RU->row['name'],
				'ManufacturerName_UA' 			=> $manufacturer_description_query_UA->row['name'],

				'MainActiveIngredientName_RU' 	=> !empty($attributes_RU['Основное действующее вещество'])?$attributes_RU['Основное действующее вещество']:'',
				'MainActiveIngredientName_UA' 	=> !empty($attributes_UA['Основна діюча речовина'])?$attributes_UA['Основна діюча речовина']:'',

				'IsReceipt' 					=> $query->row['is_receipt'],
				'IsNarcoticDrug' 				=> $query->row['is_drug'],
				'IsPoison' 						=> !empty($attributes_RU['Яд'])?$attributes_RU['Яд']:'0',
				'IsOQA' 						=> $query->row['is_pko'],
				'IsInsuline' 					=> !empty($attributes_RU['Инсулин'])?$attributes_RU['Инсулин']:'0',
				'IsThermolabel' 				=> $query->row['is_thermolabel'],

				'PharmacotherapeuticGroup_RU'	=> !empty($attributes_RU['Фармакотерапевтическая группа'])?$attributes_RU['Фармакотерапевтическая группа']:'',
				'PharmacotherapeuticGroup_UA'	=> !empty($attributes_UA['Фармакотерапевтична група'])?$attributes_UA['Фармакотерапевтична група']:'',

				'UnitOfMeasurement_RU' 			=> $query->row['name_of_part'],
				'UnitOfMeasurement_UA' 			=> $query->row['name_of_part'],

				'ActiveIngredients' 			=> $activeIngredients,
				
				'IsPreOrder' 					=> $query->row['is_preorder'],
				'NoPayment' 					=> $query->row['no_payment'],
				'NoShipping' 					=> $query->row['no_shipping'],
				'NoAdvertising' 				=> $query->row['no_advert'],

				'ProductCode' 					=> $query->row['model'],
				'ProductMorion' 				=> $query->row['upc'],
				'ProductSKU' 					=> $query->row['sku'],

				'ProductATXName_RU' 				=> !empty($attributes_RU['Классификатор АТХ'])?$attributes_RU['Классификатор АТХ']:'',
				'ProductATXName_UA' 				=> !empty($attributes_UA['Класифікатор АТХ'])?$attributes_UA['Класифікатор АТХ']:'',		
				'ProductATXCode' 					=> $query->row['reg_atx_1'],

				'InternationalNonPatendedName' 		=> $query->row['reg_unpatented_name'],				

				'ProductTradeName_RU' 				=> !empty($attributes_RU['Торговое Наименование'])?$attributes_RU['Торговое Наименование']:'',
				'ProductTradeName_UA' 				=> !empty($attributes_UA['Торгівельне Найменування'])?$attributes_UA['Торгівельне Найменування']:'',

				'ReleaseForm_RU' 					=> !empty($attributes_RU['Лекарственная форма'])?$attributes_RU['Лекарственная форма']:'',
				'ReleaseForm_UA' 					=> !empty($attributes_UA['Лікарська форма'])?$attributes_UA['Лікарська форма']:'',

				'NumberOfParts' 					=> $query->row['count_of_parts'],
				'UnitPartUUID' 						=> $query->row['uuid_of_part'],
				'UnitPartName_RU' 					=> $query->row['name_of_part'],
				'UnitPartName_UA' 					=> $query->row['name_of_part'],

				'EAN' 								=> $query->row['ean'],
				'UARegistryNumber' 					=> $query->row['reg_number'],

				'MainCategoryUUID' 					=> 'DELAYED_IMPLEMENTATION',
				'MainCategoryName' 					=> 'DELAYED_IMPLEMENTATION',
				'ProductCategory1' 					=> 'DELAYED_IMPLEMENTATION',
				'ProductCategory2' 					=> 'DELAYED_IMPLEMENTATION',
				'ProductCategory3' 					=> 'DELAYED_IMPLEMENTATION',
				'ProductPath' 						=> 'DELAYED_IMPLEMENTATION'
			];
		}

		return false;
	}

	public function updateEhealth($data){
		$debug 		= [];
		$totals  	= ['updated' => 0, 'not_found' => 0];

		$this->db->query("UPDATE oc_product SET ehealth_id = '' WHERE 1");

		foreach ($data as $product){
			$query = $this->db->query("UPDATE oc_product SET ehealth_id = '" . $this->db->escape($product['ProductEhealthUUID']) . "' WHERE uuid = '" . $this->db->escape($product['ProductUUID']) . "'");
			if ($this->db->countAffected()){
				$mode = 'updated';
				$totals['updated']++;
			} else {
				$mode = 'not_found';
				$totals['not_found']++;
			}

			$debug[] = [
					'ProductParseResult' 	=> $mode,
					'ProductUUID' 			=> $product['ProductUUID']
				];
		}

		return [
			'totals' 	=> $totals,
			'debug' 	=> $debug,
		];
	}

	public function parseProducts($data){
		$debug 		= [];
		$totals  	= ['edited' => 0, 'added' => 0];

		foreach ($data as $product){
			$product_id = $this->getProductIdByUUID($product['ProductUUID']);

			if ($product_id){
				$mode = 'edited';
				$totals['edited']++;

				$this->editProduct($product_id, $product);				
			} else {
				$mode = 'added';
				$totals['added']++;

				$product_id = $this->addProduct($product);
			}

			$debug[] = [
				'ProductParseResult'	=> $mode,
				'ProductUUID' 			=> $product['ProductUUID'],
				'ProductID' 			=> $product_id,
			];
		}

		return [
			'totals' 	=> $totals,
			'debug' 	=> $debug,
		];
	}

	private function checkDataOrProduct(array $data, array $product, array $idx, string $type = 'string'){
		$result = false;

		$data_idx 		= $idx[0];
		$product_idx 	= $idx[1];

		if (isset($data[$data_idx])){
			switch($type){
				case 'string':
					$result = $this->db->escape($data[$data_idx]);
					break;

				case 'int':
					$result = (int)$data[$data_idx];
					break;

				case 'float':
					$result = (float)$data[$data_idx];
					break;

				default:
					$result = $this->db->escape($data[$data_idx]);
					break;
			}
		} elseif (isset($product[$product_idx])) {
			switch($type){
				case 'string':
					$result = $this->db->escape($product[$product_idx]);
					break;

				case 'int':
					$result = (int)$product[$product_idx];
					break;

				case 'float':
					$result = (float)$product[$product_idx];
					break;

				default:
					$result = $this->db->escape($product[$product_idx]);
					break;
			}			
		} else {
			switch($type){
				case 'string':
					$result = '';
					break;

				case 'int':
					$result = (int)0;
					break;

				case 'float':
					$result = (float)0;
					break;

				default:
					$result = '';
					break;
			}
		}

		return $result;
	}

	private function normalizeName($name){
		$name = trim($name);
		$name = trim($name, '*');

		return $this->db->escape($name);
	}

	private function editProductNames($product_id, $data){		
		$query = $this->db->query("SELECT name, language_id FROM oc_product_description WHERE product_id = '" . (int)$product_id . "'");

		$result  = [];
		$current = [];
		foreach ($query->rows as $row){
			$current[$row['language_id']] = $row['name'];
		}

		if (empty($data['ProductName_RU']) && !empty($current[2])){
			$result[2] = $current[2];
		} elseif (empty($data['ProductName_RU']) && !empty($data['ProductName_UA'])){
			$result[2] = $data['ProductName_UA'];
		} elseif (!empty($data['ProductName_RU'])){
			$result[2] = $data['ProductName_RU'];
		}

		if (empty($data['ProductName_UA']) && !empty($current[3])){
			$result[3] = $current[3];
		} elseif (empty($data['ProductName_UA']) && !empty($data['ProductName_RU'])){
			$result[2] = $data['ProductName_RU'];
		} elseif (!empty($data['ProductName_UA'])){
			$result[3] = $data['ProductName_UA'];
		}

		foreach ([2, 3] as $language_id){
			$this->db->query("UPDATE oc_product_description SET 
			original_name 	= '" . $this->normalizeName($result[$language_id]) . "'
			WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");

			$this->db->query("UPDATE oc_product_description SET 
			name 				= '" . $this->normalizeName($result[$language_id]) . "'
			WHERE product_id 	= '" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "' AND (name = '' OR ISNULL(name))");
		}

		return $this;
	}

	private function editProductManufacturer($product_id, $data){
		$manufacturer_id = $this->db->query("SELECT manufacturer_id FROM oc_product WHERE product_id = '" . (int)$product_id . "' LIMIT 1")->row['manufacturer_id'];

		if (!$manufacturer_id){
			$query = $this->db->query("SELECT manufacturer_id FROM oc_manufacturer WHERE uuid = '" . $this->db->escape($data['ManufacturerUUID']) . "'");
			if ($query->num_rows){
				$manufacturer_id = $query->row['manufacturer_id'];
			}
		}

		if (!$manufacturer_id){
			$this->db->query("INSERT INTO oc_manufacturer SET uuid = '" . $this->db->escape($data['ManufacturerUUID']) . "'");
			$manufacturer_id = $this->db->getLastId();

			foreach ([2, 3] as $language_id){
				$this->db->query("INSERT INTO oc_manufacturer_description SET manufacturer_id = '" . (int)$manufacturer_id . "', language_id = '" . (int)$language_id . "'");
			}

			if (empty($data['ManufacturerName_UA']) && !empty($data['ManufacturerName_RU'])){
				$data['ManufacturerName_UA'] = $data['ManufacturerName_RU'];
			} elseif (!empty($data['ManufacturerName_UA']) && empty($data['ManufacturerName_RU'])){
				$data['ManufacturerName_RU'] = $data['ManufacturerName_UA'];
			} elseif (empty($data['ManufacturerName_UA']) && empty($data['ManufacturerName_RU'])){
				$data['ManufacturerName_UA'] = 'Невизначений виробник - ' . $manufacturer_id;
				$data['ManufacturerName_RU'] = 'Неопределенный производитель - ' . $manufacturer_id;
			}

			$result    = [];
			$result[2] = $data['ManufacturerName_RU'];
			$result[3] = $data['ManufacturerName_UA'];

			$this->db->query("UPDATE oc_manufacturer SET name = '" . $this->db->escape($data['ManufacturerName_UA']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

			foreach ([2, 3] as $language_id){
				$this->db->query("UPDATE oc_manufacturer_description SET name = '" . $this->db->escape($data['ManufacturerName_UA']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
			}
		}

		$this->db->query("UPDATE oc_product SET manufacturer_id = '" . (int)$manufacturer_id . "' WHERE product_id = '". (int)$product_id ."'");

		return $this;
	}	

	// 30 	Бренд 	Характеристики 	0 	
	// 14 	Действующее вещество 1 	Действующие вещества 	0 	
	// 15 	Действующее вещество 2 	Действующие вещества 	0 	
	// 16 	Действующее вещество 3 	Действующие вещества 	0 	
	// 23 	Действующее вещество 4 	Действующие вещества 	0 	
	// 24 	Действующее вещество 5 	Действующие вещества 	0 	
	// 13 	Действующие вещества 	Характеристики 	0 	
	// 33 	Инсулин 	Характеристики 	0 	
	// 35 	Классификатор АТХ 	Характеристики 	0 	
	// 38 	Количество доз в упаковке 	Характеристики 	0 	
	// 39 	Лекарственная форма 	Характеристики 	0 	
	// 31 	Наркотическое средство 	Характеристики 	0 	
	// 12 	Нужен рецепт 	Характеристики 	0 	
	// 21 	Объем, мл. 	Характеристики 	0 	
	// 40 	Основное действующее вещество 	Характеристики 	0 	
	// 32 	Подконтрольный препарат 	Характеристики 	0 	
	// 52 	Сроки хранения 	Характеристики 	0 	
	// 51 	Страна-производитель 	Характеристики 	0 	
	// 17 	Термолабильный 	Характеристики 	0 	
	// 37 	Торговое Наименование 	Характеристики 	0 	
	// 19 	Фармакотерапевтическая группа 	Характеристики 	0 	
	// 34 	Яд 	Характеристики

	private function editProductOptions($product_id, $data){
		if (!empty($data['NumberOfParts'])){
			$data['product_option'] = [[
				'product_option_value' => [
					[
						'option_value_id' => 2					
					],							
				],
				'option_id' => 2,
				'type' 		=> 'radio'
			]];	

			$this->db->query("DELETE FROM oc_product_option WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_option_value WHERE product_id = '" . (int)$product_id . "'");

			$this->db->query("INSERT INTO oc_product_option SET 
				product_id 			= '" . (int)$product_id . "', 
				option_id 			= '" . (int)$data['product_option'][0]['option_id'] . "'");

			$product_option_id = $this->db->getLastId();
			$this->db->query("INSERT INTO oc_product_option_value SET 
				product_option_id 		= '" . (int)$product_option_id . "', 
				product_id 				= '" . (int)$product_id . "', 
				option_id 				= '" . (int)$data['product_option'][0]['option_id'] . "', 
				option_value_id 		= '" . (int)$data['product_option'][0]['product_option_value'][0]['option_value_id'] . "'");

			$this->db->query("UPDATE oc_product_option_value oopv LEFT JOIN oc_product p ON (p.product_id = oopv.product_id AND option_id = 2 AND option_value_id = 2) SET oopv.quantity = (p.quantity * p.count_of_parts), oopv.price = ROUND(p.price / p.count_of_parts, 2) WHERE oopv.product_id = '" . (int)$product_id . "' AND option_id = 2 AND option_value_id = 2");

			$this->db->query("UPDATE oc_product p SET p.price_of_part = ROUND(p.price / p.count_of_parts, 2) WHERE p.product_id = '" . (int)$product_id . "' AND p.count_of_parts > 0");
		}
	}

	private function editProductData($product_id, $data){
		$product = $this->db->query("SELECT * FROM oc_product WHERE product_id = '" . (int)$product_id . "' LIMIT 1")->row;

		if (!empty($data['IsOQA']) || !empty($data['IsNarcoticDrug']) || !empty($data['IsPoison'])){
			$data['NoPayment'] 		= true;
			$data['NoShipping'] 	= true;
			$data['NoAdvertising'] 	= true;
		}

		if (!empty($data['IsOQA'])){
			$data['NumberOfParts'] = 0;
		}

		$sql = "UPDATE oc_product SET 
			model 			= '" . $this->db->escape($data['ProductCode']) . "', 
			sku 			= '" . $this->db->escape($data['ProductCode']) . "',
			ms_code			= '" . $this->db->escape($data['ProductCode']) . "', 
			ms_json			= '" . $this->db->escape(json_encode($data)) . "',			
			ean 			= '" . $this->checkDataOrProduct($data, $product, ['EAN', 'ean'], 'string') . "', 
			status 			= '" . (int)(!$data['ProductDisabled']) . "', 
			no_payment 		= '" . $this->checkDataOrProduct($data, $product, ['NoPayment', 'no_payment'], 'int') . "', 
			no_shipping 	= '" . $this->checkDataOrProduct($data, $product, ['NoShipping', 'no_shipping'], 'int') . "', 
			no_advert 		= '" . $this->checkDataOrProduct($data, $product, ['NoAdvertising', 'no_advert'], 'int') . "', 
			is_receipt 		= '" . $this->checkDataOrProduct($data, $product, ['IsReceipt', 'is_receipt'], 'int') . "', 
			is_thermolabel 	= '" . $this->checkDataOrProduct($data, $product, ['IsThermolabel', 'is_thermolabel'], 'int') . "', 
			is_pko 			= '" . $this->checkDataOrProduct($data, $product, ['IsOQA', 'is_pko'], 'int') . "', 
			is_drug 		= '" . $this->checkDataOrProduct($data, $product, ['IsNarcoticDrug', 'is_drug'], 'int') . "', 
			is_poison 		= '" . $this->checkDataOrProduct($data, $product, ['IsPoison', 'is_poison'], 'int') . "', 					
			reg_number 		= '" . $this->checkDataOrProduct($data, $product, ['UARegistryNumber', 'reg_number'], 'string') . "', 			
			name_of_part 	= '" . $this->checkDataOrProduct($data, $product, ['UnitPartName_RU', 'name_of_part'], 'string') . "', 
			count_of_parts 	= '" . $this->checkDataOrProduct($data, $product, ['NumberOfParts', 'count_of_parts'], 'int') . "', 
			date_modified 	= NOW() 
			WHERE product_id = '" . (int)$product_id . "'";

		$this->db->query($sql);

		return $this;
	}

	public function editProduct($product_id, $data){
		$this->editProductNames($product_id, $data)
			->editProductData($product_id, $data)
			->editProductManufacturer($product_id, $data)
			->editProductOptions($product_id, $data);

		return $product_id;
	}

	public function addProduct($data){
		$this->db->query("INSERT INTO oc_product SET 
			model 				= '" . $this->db->escape($data['ProductCode']) . "', 
			sku 				= '" . $this->db->escape($data['ProductCode']) . "',
			ms_code 			= '" . $this->db->escape($data['ProductCode']) . "',
			uuid 				= '" . $this->db->escape($data['ProductUUID']) . "',
			date_added = NOW()");

		$product_id = $this->db->getLastId();

		foreach ([2, 3] as $language_id){
			$this->db->query("INSERT INTO oc_product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "'");
		}

		$this->db->query("INSERT INTO oc_product_to_store SET product_id = '" . (int)$product_id . "', store_id = '0'");
		
		$this->editProduct($product_id, $data);

		return $product_id;
	}

}