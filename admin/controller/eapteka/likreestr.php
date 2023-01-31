<?php
ini_set('memory_limit', '-1');
class ControllerEaptekaLikReestr extends Controller {
	private $path = 'http://www.drlz.com.ua/ibp/zvity.nsf/all/zvit/$file/reestr.csv';

	private $csvMappings = [
		"ID" => "",
		"Торгівельне найменування" => "",
		"Міжнародне непатентоване найменування" => "",
		"Форма випуску" => "",
		"Умови відпуску" => "",
		"Склад (діючі)" => "",
		"Фармакотерапевтична група" => "",
		"Код АТС 1" => "",
		"Код АТС 2" => "",
		"Код АТС 3" => "",
		"Заявник: назва українською" => "",
		"Заявник: країна" => "",
		"Заявник: адреса" => "",
		"Кількість виробників" => "",
		"Виробник 1: назва українською" => "",
		"Виробник 1: країна " => "",
		"Виробник 1: адреса" => "",
		"Виробник 2: назва українською" => "",
		"Виробник 2: країна " => "",
		"Виробник 2: адреса" => "",
		"Виробник 3: назва українською" => "",
		"Виробник 3: країна " => "",
		"Виробник 3: адреса" => "",
		"Виробник 4: назва українською" => "",
		"Виробник 4: країна " => "",
		"Виробник 4: адреса" => "",
		"Виробник 5: назва українською" => "",
		"Виробник 5: країна " => "",
		"Виробник 5: адреса" => "",
		"Номер Реєстраційного посвідчення" => "",
		"Дата початку дії" => "",
		"Дата закінчення" => "",
		"Тип ЛЗ" => "",
		"ЛЗ біологічного походження" => "",
		"ЛЗ рослинного походження" => "",
		"ЛЗ-сирота" => "",
		"Гомеопатичний ЛЗ" => "",
		"Тип МНН" => "",
		"Дострокове припинення" => "",
		"Дострокове припинення: останній день дії" => "",
		"Дострокове припинення: причина" => "",
		"URL інструкції" => "",
		"Термін придатності" => "",
		"Термін придатності: значення" => "",
		"Термін придатності: одиниця вимірювання"
	];

	private $excludeFromCompare = [
		"ID", "URL інструкції"
	];

	private function parseCSV(){
		echoLine('[Likreestr::full] Getting data...', 'i');

		$csv = array_map('str_getcsvLR', file($this->path));
		array_walk($csv, function(&$a) use ($csv) {
			$a = array_combine($csv[0], $a);
		});
		array_shift($csv);

		echoLine('[Likreestr::full] Parsed data', 'i');

		return $csv;			
	}


	public function index(){
		$this->load->model('catalog/product');					
		$data = $this->parseCSV();			
		foreach ($data as $line){				
			$registryNumber = $line['Номер Реєстраційного посвідчення'];				
			if ($registryNumber && $product = $this->model_catalog_product->getProductByRegistryNumber($registryNumber)){				
				echoLine('Нашли товар c регистрационным номером ' . $registryNumber . ': ' . $product['name']);
				$this->model_catalog_product->updateProductByRegistryNumber($product['product_id'], $line);					
			} else {				
				echoLine('Не нашли товар c регистрационным номером ' . $registryNumber);				
			}
		}			
	}

	public function full(){
		$this->load->model('catalog/product');
		// $data = $this->parseCSV();

		// foreach ($data as $line){	
		// 	$registryNumber = trim($line['Номер Реєстраційного посвідчення']);

		// 	$product_id = null;
		// 	if ($registryNumber && $product = $this->model_catalog_product->getProductByRegistryNumber($registryNumber)){	
		// 		$product_id	= $product['product_id'];
		// 		echoLine('[Likreestr::full] Found product with ' . $registryNumber . ': ' . $product['name'], 's');
		// 	} else {				
		// 		echoLine('[Likreestr::full] Not found ' . $registryNumber . ': ' . $line['Торгівельне найменування'] , 'e');				
		// 	}

		// 	$this->model_catalog_product->insertDataToLikReestr($registryNumber, $line, $product_id);
		// }

		echoLine('[Likreestr::full] Getting all data from database..', 'i');

		$likreestr = $this->model_catalog_product->getAllDataFromLikReestr();
		$changes   = [];

		foreach ($likreestr as $drug){			
			$current_data 	= json_decode($drug['json'], true);
			$previous_data 	= json_decode($drug['json_old'], true);

			foreach ($current_data as $key => $value){
				$previous_value = $previous_data[$key];

				if ($value != $previous_value && $drug['product_id'] && !in_array($key, $this->excludeFromCompare)){
					if (empty($changes[$drug['drug_id']])){
						$changes[$drug['drug_id']] = [];
					}

					$changes[$drug['drug_id']][] = [
						'key' 				=> $key,
						'previous_value' 	=> $previous_value,
						'current_value' 	=> $value 	
					];
				}
			}
		}

		if ($changes){
			foreach ($changes as $key => $drug_change_list){						
				$product = $this->model_catalog_product->getProduct($key);
				echoLine('[Likreestr::full] Found change for drug ' . $product['name'] . ': ' . $key, 's');

				foreach ($drug_change_list as $drug_change){
					echoLine('[Likreestr::full] Key: ' . $drug_change['key'], 'w');
					echoLine('[Likreestr::full] Old value: ' . $drug_change['previous_value'], 'i');
					echoLine('[Likreestr::full] New value: ' . $drug_change['current_value'], 'e');
				}						
			}
		}
	}
}			