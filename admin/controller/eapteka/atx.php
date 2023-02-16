<?php
ini_set('memory_limit', '-1');
class ControllerEaptekaATX extends Controller {
	private $atx_main_category = 543;


	public function cattree(){
		$this->load->model('catalog/category');

		$query = $this->db->query("SELECT * FROM atx_tree");

		foreach ($query->rows as $row){			
			$query2 = $this->db->query("SELECT category_id FROM oc_category WHERE atx_code = '" . $row['code'] . "'");

			if (!$query2->num_rows){
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