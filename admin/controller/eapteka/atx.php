<?php
ini_set('memory_limit', '-1');
class ControllerEaptekaATX extends Controller {
	private $atx_main_category 		= 543;
	private $substances_category_id = 6660;

	private function prepareCategory($row){
		$data = array(
					'category_description' => array(
						"2" => array(
							'name' 				=> $row['name_ru'] . ' (ATX-код ' . $row['code'] . ')',
							'alternate_name'	=> '',
							'seo_name' 			=> $row['name_ru'] . ' (ATX-код ' . $row['code'] . ')',
							'faq_name' 			=> '',
							'description'		=> '',
							'meta_title'        => $row['name_ru'] . ' (ATX-код ' . $row['code'] . ')',
							'meta_description'  => '',
							'meta_keyword'      => '',
						),
						"3" => array(
							'name' 				=> $row['name_ua'] . ' (ATX-код ' . $row['code'] . ')',
							'alternate_name'	=> '',
							'seo_name' 			=> $row['name_ua'] . ' (ATX-код ' . $row['code'] . ')',
							'faq_name' 			=> '',
							'description'		=> '',
							'meta_title'        => $row['name_ua'] . ' (ATX-код ' . $row['code'] . ')',
							'meta_description'  => '',
							'meta_keyword'      => '',
						),
						// "4" => array(
						// 	'name' 				=> $row['name_eng'] . ' (ATX-код ' . $row['code'] . ')',
						// 	'alternate_name'	=> '',
						// 	'seo_name' 			=> $row['name_eng'] . ' (ATX-код ' . $row['code'] . ')',
						// 	'faq_name' 			=> '',
						// 	'description'		=> '',
						// 	'meta_title'        => $row['name_eng'] . ' (ATX-код ' . $row['code'] . ')',
						// 	'meta_description'  => '',
						// 	'meta_keyword'      => '',
						// )
					),
					'category_store' => array(
						'0'
					),
					'image'     	 => '',
					'parent_id'      => $this->atx_main_category,
					'show_subcats'   => 0,
					'sort_order'	 => 0,
					'top' 			 =>	0,
					'is_searched' 	 => 0,
					'status' 		 => 1,
					'column'		 => 2,
					'atx_code'		 => $row['code'],
					'keyword'    	 => trim(URLify::transliterate(URLify::rms2(mb_strtolower($row['name_ua'] . ' (ATX-код ' . $row['code'] . ')'))), ' -'),
					'uuid'   		 => md5($row['code']),	
					'google_base_category_id' 	=> '',
					'no_fucken_path' 			=> true
				);

		return $data;
	}

	public function normalizenames(){
		$query = $this->db->query("SELECT c.atx_code, cd.name, cd.language_id, c.category_id FROM oc_category c LEFT JOIN oc_category_description cd ON c.category_id = cd.category_id WHERE c.atx_code <> ''");

		foreach ($query->rows as $row){
			$code_start = mb_substr($row['atx_code'], 0, 3);			

			if (mb_strpos($row['name'], $code_start) === 0){
				echoLine('HAVING PROBLEM, CODE ' . $row['atx_code'] . ' IN NAME: ' . $row['name'], 'w');
				
				$code_with_space = mb_substr($row['atx_code'], 0, 4) . ' ' . mb_substr($row['atx_code'], 4);
				$possible_name = str_replace($code_with_space, '', $row['name']);
				echoLine('Possible name: ' . $possible_name, 's');

				$this->db->query("UPDATE oc_category_description SET name = '" . trim($possible_name) . "' WHERE language_id = '" . $row['language_id'] . "' AND category_id = '" . $row['category_id'] . "'");
			}
		}
	}

	public function cattree(){
		$this->load->model('catalog/category');

		$query = $this->db->query("SELECT * FROM atx_tree");
		foreach ($query->rows as $row){			
			$query2 = $this->db->query("SELECT category_id FROM oc_category WHERE atx_code = '" . $row['code'] . "'");

			if (!$query2->num_rows){
				$data = $this->prepareCategory($row);

				$this->model_catalog_category->addCategory($data);
				echoLine('Added category ' . $row['code'] . ' ' . $row['name_ua'], 'i');
			}
		}

		//VALIDATE CODES
		$query = $this->db->query("SELECT * FROM atx_tree_eapteka WHERE 1");
		foreach ($query->rows as $row){
			$query2 = $this->db->query("SELECT category_id FROM oc_category WHERE atx_code = '" . $row['code'] . "'");

			if (!$query2->num_rows){
				echoLine('OH SHIT, NO CATEGORY WITH ATX: ' . $row['code'], 'e');
				$parent = '';

				if (mb_strlen($row['code']) >= 7){
					$parent = mb_substr($row['code'], 0, 5);
				}

				if (mb_strlen($row['code']) == 5){
					$parent = mb_substr($row['code'], 0, 4);
				}

				if (mb_strlen($row['code']) == 4){
					$parent = mb_substr($row['code'], 0, 3);
				}

				if ($parent){
					echoLine('I THINK PARENT IS: ' . $parent, 'w');

					$query3 = $this->db->query("SELECT * FROM atx_tree WHERE code = '" . $parent . "'");
					if ($query3->num_rows){
						echoLine('FOUND PARENT: ' . $query3->row['code'] . ': ' . $query3->row['name_ua'], 's');

						echoLine('ADDING ' . $row['code'] . ': ' . $row['name_ua'], 'i');

						$this->addATX([
							'code' 		=> $row['code'],
							'parent' 	=> $query3->row['code'],
							'name_ua'	=> $row['name_ua'],
							'name_ru'	=> $row['name_ru'],
							'name_eng'	=> '',
						]);
					}
				}								
			}
		}
		
		//SECOND ITERATION
		$query = $this->db->query("SELECT * FROM atx_tree");
		foreach ($query->rows as $row){			
			$query2 = $this->db->query("SELECT category_id FROM oc_category WHERE atx_code = '" . $row['code'] . "'");

			if (!$query2->num_rows){
				$data = $this->prepareCategory($row);

				$this->model_catalog_category->addCategory($data);
				echoLine('Added category ' . $row['code'] . ' ' . $row['name_ua'], 'i');
			}
		}


		$query = $this->db->query("SELECT * FROM oc_category WHERE atx_code <> ''");
		foreach ($query->rows as $row){
			$query2 = $this->db->query("SELECT parent, category_id FROM atx_tree LEFT JOIN oc_category ON (oc_category.atx_code = atx_tree.parent) WHERE code = '" . $row['atx_code'] . "'");			
			if ($query2->row && $query2->row['parent']){
				echoLine('Setting parent ' . $row['code'] . ' ' . $query2->row['parent'], 'i');

				$this->db->query("UPDATE oc_category SET parent_id = '" . $query2->row['category_id'] . "' WHERE category_id = '" . $row['category_id'] . "'");
			}
		}


		$this->db->query("DELETE FROM oc_product_to_category WHERE category_id IN (SELECT category_id FROM oc_category WHERE atx_code <> '')");
		$this->db->query("INSERT IGNORE INTO oc_product_to_category (product_id, category_id, main_category) SELECT product_id, (SELECT category_id FROM oc_category WHERE atx_code = oc_product.reg_atx_1) as category_id, 0 FROM oc_product WHERE reg_atx_1 <> ''");

	}

	private function addATX($atx){
		if (empty($atx['code'])){
			return;
		}

		$this->db->query("INSERT INTO atx_tree SET 
			code 		= '" . $this->db->escape($atx['code']) . "',
			parent 		= '" . $this->db->escape($atx['parent']) . "',
			name_ua 	= '" . $this->db->escape($atx['name_ua']) . "',
			name_ru 	= '" . $this->db->escape($atx['name_ru']) . "',
			name_eng 	= '" . $this->db->escape($atx['name_eng']) . "'
			ON DUPLICATE KEY UPDATE
			name_ua 	= '" . $this->db->escape($atx['name_ua']) . "',
			name_ru 	= '" . $this->db->escape($atx['name_ru']) . "',
			name_eng 	= '" . $this->db->escape($atx['name_eng']) . "'");
	}

	private function decodeLevelRecursive($level){
		$this->addATX([
			'code' 		=> $level['code'],
			'parent' 	=> !empty($level['parent'])?$level['parent']:'',
			'name_ua' 	=> $level['name_ua'],
			'name_ru' 	=> $level['name_ru'],
			'name_eng' 	=> $level['name_eng']
		]);

		echoLine('ADDING ' . $level['code'] . ': ' . $level['name_ua'], 'i');

		if (!empty($level['children'])){
			foreach ($level['children'] as $child){
				$child['parent'] = $level['code'];

				$this->decodeLevelRecursive($child);
			}
		}
	}

	public function getatx(){
		$first_levels = ['A', 'B', 'C', 'D', 'G', 'H', 'J', 'L', 'M', 'N', 'P', 'R', 'S', 'V'];

		foreach ($first_levels as $level){
			$json 		= file_get_contents(DIR_SYSTEM . '/storage/atx/' . $level . '.json');
			$json 		= json_decode($json, true);						
			$level_data = $json['data']['atcTree'][0];
			$this->decodeLevelRecursive($level_data);
		}
	}
}