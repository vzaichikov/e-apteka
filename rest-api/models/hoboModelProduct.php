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

		$query = $this->db->query("SELECT uuid, product_id FROM oc_product WHERE 1");	

		foreach ($query->rows as $row){
			$result[] = [
				'productUUID' 	=> $row['uuid'],
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
		$query = $this->db->query("SELECT * FROM oc_product p WHERE (p.product_id = '" . (int)$product_id . "' OR uuid = '" . $this->db->escape($product_id) . "') LIMIT 1");

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
				'IsPoison' 						=> !empty($attributes_RU['Инсулин'])?$attributes_RU['Инсулин']:'0',
				'IsOQA' 						=> $query->row['is_pko'],
				'IsInsuline' 					=> !empty($attributes_RU['Яд'])?$attributes_RU['Яд']:'0',
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



}