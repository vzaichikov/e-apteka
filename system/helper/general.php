<?php
	function token($length = 32) {
		$string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		
		$max = strlen($string) - 1;
		
		$token = '';
		
		for ($i = 0; $i < $length; $i++) {
			$token .= $string[mt_rand(0, $max)];
		}	
		
		return $token;
	}
	
	function pin($length = 4) {
		$string = '0123456789';
		
		$max = strlen($string) - 1;
		
		$token = '';
		
		for ($i = 0; $i < $length; $i++) {
			$token .= $string[mt_rand(0, $max)];
		}	
		
		return $token;
		
	}

	function size_convert($size)
	{
		$unit = array('b','kb','mb','gb','tb','pb');
		return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	}
	
	function checkIfStringIsEmail($string){
		
		return strpos($string, '@') && filter_var($string, FILTER_VALIDATE_EMAIL);
		
	}	
	
	function normalizePhone($phone, $plus = true){
		$phone = trim($phone);
		
		if (!trim($phone)){
			return '';
		}
		
		if ($phone[0] == '+'){
			$phone = substr($phone, 1);			
		}
		
		$phone = str_replace(" ", "", $phone);
		$phone = preg_replace("/\D+/", "", $phone);
		
		if (substr($phone, 0, 4) == '3838'){
			$phone = substr($phone, 2);
		}
		
		if ($phone[0] == '3'){
			$phone = '+' . $phone;			
		}
		
		if ($phone[0] == '8'){
			$phone = '+3' . $phone;			
		}
		
		if ($phone[0] == '0'){
			$phone = '+38' . $phone;			
		}
		
		if (in_array($phone[0], array(9,5,6))){
			$phone = '+380' . $phone;			
		}
		
		if (substr($phone, 0, 2) == '+30'){				
			$phone = str_replace('+30', '+380', $phone);
		}
		
		if (substr($phone, 0, 3) == '+38' && substr($phone, 0, 4) != '+380'){				
			$phone = str_replace('+38', '+380', $phone);
		}
		
		if (substr($phone, 0, 7) == '+380380' && mb_strlen($phone) != 13){				
			$phone = str_replace('+380380', '+380', $phone);
		}
		
		if (mb_strlen($phone) != 13){
			return '';
		}
		
		if ($phone[0] == '+'){
			$phone = substr($phone, 1);			
		}
		
		$phone = '+' . preg_replace("/\D+/", "", $phone);
		
		if (!$plus){
			if ($phone[0] == '+'){
				$phone = substr($phone, 1);			
			}
			
			return $phone;
		}
		
		return $phone;
	}
	
	function prepareEcommString($string){
		$string = str_replace('&amp;', '&', $string);
		$string = str_replace('&quot;', '', $string);
		$string = str_replace("'", "`", $string);
		$string = str_replace('"', '\"', $string);
		
		return $string;
	}
	
	function getCountryNameFromManufacturerName($string){
		$country = mb_strrchr($string, '(');
		$country = trim($country);
		$country = trim($country, '\)');
		$country = trim($country, '\(');
		$country = trim($country);
		
		if (mb_strpos($country, ',') > 0){
			$exploded = explode(',', $country);			
			$country = trim($exploded[0]);
		}		
		
		
		return $country;
	}
	
	function dateDiff($date){
		
		$date1 = new DateTime(); 
		$date2 = new DateTime($date);
		$diff = $date2->diff($date1)->format("%a");				
		$days = intval($diff) + 1;
		return $days;
		
	}	
	
	function explodeByEOL($data){
		$result = array();
		
		$exploded = explode(PHP_EOL, $data);
		
		foreach($exploded as $line){
			$tmp = str_replace(PHP_EOL, '', $line);
			$tmp = trim($tmp);
			$result[] = $tmp;
		}
		
		return $result;
		
	}
	
	function preparePhone($phone){
		$phone = preg_replace('/[^0-9]/', '', $phone);
		
		if (mb_strlen($phone) == 10 && $phone[0] == '0'){
			$phone = '38' . $phone;
		}
		
		if (mb_strlen($phone) == 11 && $phone[0] == '8'){
			$phone = '3' . $phone;
		}
		
		return $phone;
	}
	
	function getPhoneReplaceSQL($fieldname, $value){
		
		$sql = "(TRIM(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(`" . mysqli::real_escape_string($fieldname) . "`,' ',''), '+', ''), '-', ''), '(', ''), ')', '')) LIKE '". mysqli::real_escape_string($value) ."' )";
		
	}
	
	function phoneToNineDigits($phone){
		
		$phone = preg_replace('/[^0-9]/', '', $phone);
		
		if (mb_strlen($phone) >= 9){
			$phone = substr($phone, -9);
			} else {
			return false;
		}
		
		return $phone;		
	}
	
	
	function rseo_nofollow($content) {
		$content = preg_replace_callback('~<(a\s[^>]+)>~isU', "cb2", $content);
		return $content;
	}
	
	function array_key_unique($arr){
		
		$temp = array();
		
		foreach ($arr as $key => $value){
			$temp[$key] = $value;
		}
		
		return $temp;
	}
	
	function super_normalize($str){
		return mb_strtolower(trim(str_replace('  ', '', $str)));
	}
	
	function checkIfIsSeparatedString($string, $separator = ','){
		$exploded = explode($separator, $string);
		
		if (count($exploded) > 1){
			return array_map('trim', $exploded); 
		}
		
		return false;
	}
	
	
	function removequotes($string){
		
		$string = str_replace('"', '', $string);
		$string = str_replace("'", '', $string);
		$string = str_replace('"', '', $string);
		$string = str_replace('\\', '', $string);
		$string = trim($string);
		
		return $string;
		
	}

	if(!function_exists('hash_equals')) {
		function hash_equals($known_string, $user_string) {
			$known_string = (string)$known_string;
			$user_string = (string)$user_string;
			
			if(strlen($known_string) != strlen($user_string)) {
				return false;
				} else {
				$res = $known_string ^ $user_string;
				$ret = 0;
				
				for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
				
				return !$ret;
			}
		}
	}				