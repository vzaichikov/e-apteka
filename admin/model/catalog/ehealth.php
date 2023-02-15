<?php
class ModelCatalogEhealth extends Model {
	
	public function parseXLSX($file){
		if ( $xlsx = \Shuchkin\SimpleXLSX::parse($file['tmp_name'])) {
			$i = 0;

			foreach ($xlsx->rows() as $row){
				if ($i == 0){ $i++; continue; }

				$this->addEhealth(
					[
						'program_id' 				=> $row[0],
						'program_name' 				=> $row[1],
						'morion_code' 				=> $row[2],
						'trade_name' 				=> $row[3],
						'ehealth_id' 				=> $row[4],
						'participant_id' 			=> $row[5],
						'manufacturer' 				=> $row[6],
						'manufacturer_trade_name' 	=> $row[7],
						'pack' 						=> $row[8],
						'reg_number' 				=> $row[9],
						'package_min_qty' 			=> $row[10],
						'package_qty' 				=> $row[11],
					]
				);
			}


		} else {
			throw new \Exception( \Shuchkin\SimpleXLSX::parseError() );
		}

		unlink($file['tmp_name']);
	}

	public function addEhealth($data){
		$this->db->query("
			INSERT INTO oc_ehealth SET
			program_id 				= '" . $this->db->escape($data['program_id']) . "',
			program_name 			= '" . $this->db->escape($data['program_name']) . "',
			morion_code 			= '" . $this->db->escape(trim($data['morion_code'])) . "',
			trade_name 				= '" . $this->db->escape($data['trade_name']) . "',
			ehealth_id 				= '" . $this->db->escape($data['ehealth_id']) . "',
			participant_id 			= '" . $this->db->escape($data['participant_id']) . "',
			manufacturer 			= '" . $this->db->escape($data['manufacturer']) . "',
			manufacturer_trade_name = '" . $this->db->escape($data['manufacturer_trade_name']) . "',
			pack 					= '" . $this->db->escape($data['pack']) . "',
			reg_number 				= '" . $this->db->escape(trim($data['reg_number'])) . "',
			package_min_qty 		= '" . (int)($data['package_min_qty']) . "',
			package_qty 			= '" . (int)($data['package_qty']) . "',
			product_id				= '0'
			ON DUPLICATE KEY UPDATE			
			program_name 			= '" . $this->db->escape($data['program_name']) . "',
			morion_code 			= '" . $this->db->escape($data['morion_code']) . "',
			trade_name 				= '" . $this->db->escape($data['trade_name']) . "',
			ehealth_id 				= '" . $this->db->escape($data['ehealth_id']) . "',
			participant_id 			= '" . $this->db->escape($data['participant_id']) . "',
			manufacturer 			= '" . $this->db->escape($data['manufacturer']) . "',
			manufacturer_trade_name = '" . $this->db->escape($data['manufacturer_trade_name']) . "',
			pack 					= '" . $this->db->escape($data['pack']) . "',
			reg_number 				= '" . $this->db->escape(trim($data['reg_number'])) . "',
			package_min_qty 		= '" . (int)($data['package_min_qty']) . "',
			package_qty 			= '" . (int)($data['package_qty']) . "'
		");
	}

	public function getTotalEhealth($data){
		$sql = "SELECT COUNT(*) as total FROM oc_ehealth e WHERE 1 ";

		if (!empty($data['filter_bad'])){
			$sql .= " AND product_id = 0";
		}

		if (!empty($data['filter'])){
			if ($data['filter'] == 'morion_not_found'){
				$sql .= " AND e.morion_code <> '' AND e.morion_code NOT IN (SELECT upc FROM oc_product WHERE upc)";
			}

			if ($data['filter'] == 'regnumber_not_found'){
				$sql .= " AND e.reg_number <> '' AND e.reg_number NOT IN (SELECT reg_number FROM oc_product)";
			}

			if ($data['filter'] == 'many_products_found'){
				$sql .= " AND parse_info LIKE ('%REGNUMBER_FOUND_X%') OR parse_info LIKE ('%MORION_FOUND_X%')";
			}
		}

		return $this->db->query($sql)->row['total'];
	}


	public function getEhealth($data){
		$sql = "SELECT e.* FROM oc_ehealth e WHERE 1 ";

		if (!empty($data['filter_bad'])){
			$sql .= " AND e.product_id = 0";
		}

		if (!empty($data['filter'])){
			if ($data['filter'] == 'morion_not_found'){
				$sql .= " AND e.morion_code <> '' AND e.morion_code NOT IN (SELECT upc FROM oc_product WHERE upc)";
			}

			if ($data['filter'] == 'regnumber_not_found'){
				$sql .= " AND e.reg_number <> '' AND e.reg_number NOT IN (SELECT reg_number FROM oc_product)";
			}

			if ($data['filter'] == 'many_products_found'){
				$sql .= " AND parse_info LIKE ('%REGNUMBER_FOUND_X%') OR parse_info LIKE ('%MORION_FOUND_X%')";
			}
		}

		$sql .= " ORDER BY (e.product_id <> 0) DESC, trade_name ASC ";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}			

		return $this->db->query($sql)->rows;
	}

	public function getNumberFromName($name){
		preg_match('/№[0-9]+/', $name, $result);

		if (count($result) == 1){
			return $result[0];
		} else {
			return false;
		}
	}

	public function getMGFromName($name, $num = false){
		preg_match('/ [0-9]+[ ]?MG /', $name, $result);

		if (count($result) == 1){
			if ($num){
				return trim(str_replace('MG', '', $result[0]));		
			}

			return $result[0];
		} else {
			return false;
		}
	}

	public function getMLFromName($name, $num = false){
		preg_match('/ [0-9]+[ ]?мл /', $name, $result);

		if (count($result) == 1){
			if ($num){
				return trim(str_replace('мл', '', $result[0]));		
			}

			return $result[0];
		} else {
			return false;
		}
	}

	public function getMGFromNameAGP($name, $num = false){
		$return = false;

		preg_match_all('/[0-9]+,?[0-9]?[ ]?г/', mb_strtolower($name), $gramms);
		if (count($gramms[0]) >= 1){
			foreach ($gramms[0] as $gramm){				
				$tmp = $gramm;
				$gramm = (float)trim(str_replace([',', 'г'], ['.', ''], $gramm));
				$milligrams = ($gramm * 1000) . ' мг';

				$name = str_ireplace($tmp, $milligrams, $name);
			}
		}

		preg_match_all('/[0-9]+[ ]?мг/', mb_strtolower($name), $result);		

		if (count($result[0]) == 1){
			if ($num){
				$return = trim(str_replace('мг', '', $result[0][0]));		
			} else {
				$return = $result[0][0];
			}
		} elseif (count($result[0]) == 2 || count($result[0]) == 3) {
			if ($num){
				$return = (int)trim(str_replace('мг', '', $result[0][0])) + (int)trim(str_replace('мг', '', $result[0][1]));
			} else {
				$return = (int)trim(str_replace('мг', '', $result[0][0])) + (int)trim(str_replace('мг', '', $result[0][1])) . ' мг';
			}
		} else {
			return false;
		}

		return $return;
	}

	public function getMLFromNameAGP($name, $num = false){
		preg_match('/[0-9]+[ ]?мл/', mb_strtolower($name), $result);		

		if (count($result) == 1){
			if ($num){
				return trim(str_replace('мл', '', $result[0]));		
			}

			return $result[0];
		} else {
			return false;
		}
	}

	public function checkMorionCodeExists($morion_code, $count = true){
		if ($count){
			return $this->db->query("SELECT product_id FROM oc_product WHERE upc = '" . $this->db->escape($morion_code) . "'")->num_rows;			
		} else {
			return $this->db->query("SELECT product_id FROM oc_product WHERE upc = '" . $this->db->escape($morion_code) . "'")->rows;
		}
		
	}

	public function checkRegNumberExists($reg_number, $count = true){
		if ($count){
			return $this->db->query("SELECT product_id FROM oc_product WHERE reg_number = '" . $this->db->escape($reg_number) . "'")->num_rows;
		} else {
			return $this->db->query("SELECT product_id FROM oc_product WHERE reg_number = '" . $this->db->escape($reg_number) . "'")->rows;
		}
	}


	public function linkProduct($product_id, $ehealth_id){
		$this->db->query("UPDATE oc_ehealth SET product_id = '" . (int)$product_id . "' WHERE ehealth_id = '" . $this->db->escape($ehealth_id) . "'");
	}
}