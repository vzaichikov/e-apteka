<?php
ini_set('memory_limit', '-1');
class ControllerEaptekaSubstances extends Controller {	
	private $substances_category_id = 6660;
	private $names_final = [
		'2' => 'Препараты с веществом',
		'3' => 'Препарати з речовиною',
	];
	private $names_parent = [
		'2' => 'Действующие вещества на',
		'3' => 'Діючі речовини на',
	];
	private $attribute_id = 40;


	private function prepareCategory($row, $type = 'final'){

		if ($type == 'final'){
			$name_ru 	= $this->names_final['2'];
			$name_ua 	= $this->names_final['3'];
			$parent_id 	= $this->substances_category_id;
		} elseif ($type == 'parent'){
			$name_ru 	= $this->names_parent['2'];
			$name_ua 	= $this->names_parent['3'];
			$parent_id 	= $row['parent_id'];
		}

		$data = array(
					'category_description' => array(
						"2" => array(
							'name' 				=> $row['name_ru'],
							'alternate_name'	=> '',
							'seo_name' 			=> $name_ru . ' ' . $row['name_ru'],
							'faq_name' 			=> '',
							'description'		=> '',
							'meta_title'        => $name_ru . ' ' . $row['name_ru'],
							'meta_description'  => '',
							'meta_keyword'      => '',
						),
						"3" => array(
							'name' 				=> $row['name_ua'],
							'alternate_name'	=> '',
							'seo_name' 			=> $name_ua . ' ' . $row['name_ua'],
							'faq_name' 			=> '',
							'description'		=> '',
							'meta_title'        => $name_ua . ' ' . $row['name_ua'],
							'meta_description'  => '',
							'meta_keyword'      => '',
						)
					),
					'category_store' => array(
						'0'
					),
					'image'     	 => '',
					'parent_id'      => $parent_id,
					'show_subcats'   => 0,
					'sort_order'	 => 0,
					'top' 			 =>	0,
					'is_searched' 	 => 0,
					'status' 		 => 1,
					'column'		 => 2,
					'atx_code'		 => '',
					'substance'		 => $row['name_ru'],
					'keyword'    	 => trim(URLify::transliterate(URLify::rms2('substance-' . $row['name_ua'])), ' -'),
					'uuid'   		 => md5($row['name_ru']),	
					'google_base_category_id' 	=> '',
					'no_fucken_path' 			=> true
				);

		return $data;
	}


	public function buildAndLink(){
		$this->load->model('catalog/category');

		$substances2p 		= [];
		$substances_tmp   	= [];

		$query = $this->db->query("UPDATE oc_product_attribute SET text = TRIM(text) WHERE attribute_id = 40");
		$query = $this->db->query("SELECT * FROM oc_product_attribute WHERE attribute_id = 40 AND text <> ''");

		foreach ($query->rows as $row){
			if (empty($substances2p[$row['product_id']])){
				$substances2p[$row['product_id']] = [];
			}

			if ($row['language_id'] == 2){
				$substances2p[$row['product_id']]['ru'] = mb_ucfirst($row['text']);
			} elseif ($row['language_id'] == 3){
				$substances2p[$row['product_id']]['ua'] = mb_ucfirst($row['text']);
			}			
		}

	
		foreach ($substances2p as $id => $substance){
			if (empty($substance['ua'])){
				$substance['ua'] = $substance['ru'];
			}

			if (empty($substances_tmp[$substance['ru']])){
				$substances_tmp[$substance['ru']] = $substance['ua'];
			}
		}

		foreach($substances_tmp as $name_ru => $name_ua){
			//searching for parent
			$prefix = mb_strtoupper(mb_substr($name_ua, 0, 1));

			$query = $this->db->query("SELECT category_id FROM oc_category WHERE substance = '" . $this->db->escape($name_ru) . "'");

			if (!$query->num_rows){
				$data = $this->prepareCategory(['name_ru' => $name_ru, 'name_ua' => $name_ua]);

				$this->model_catalog_category->addCategory($data);
				echoLine('Added category ' . $name_ru . ' (' . $name_ua . ')', 'i');
			} 
		}

		$sql = "DELETE FROM oc_product_to_category WHERE category_id IN (SELECT category_id FROM oc_category WHERE parent_id = '" . (int)$this->substances_category_id . "')";
		
		foreach($substances_tmp as $name_ru => $name_ua){
			$query = $this->db->query("SELECT category_id FROM oc_category WHERE substance = '" . $this->db->escape($name_ru) . "'");

			if ($query->row['category_id']){
				echoLine('Filling category ' . $query->row['category_id'] . ' (' . $name_ru . ')', 'i');
				$this->db->query("INSERT IGNORE INTO oc_product_to_category (product_id, category_id) SELECT product_id, " . (int)$query->row['category_id'] . " FROM oc_product_attribute WHERE LOWER(text) = '" . $this->db->escape(mb_strtolower($name_ru)) . "' AND language_id = 2");

				$this->db->query("UPDATE oc_category SET product_count = (SELECT COUNT(product_id) FROM oc_product_to_category WHERE category_id = '" . (int)$query->row['category_id'] . "') WHERE category_id = '" . (int)$query->row['category_id'] . "'");
			}


		}


		
	}

























}