<?php

namespace hobotix;

class phoneValidator
{  

	private $country_id 		= null;
	private $regular_expression = null;
	private $format 			= null;
	
	/*
		Mapping country codes to regular expressions
	*/
	private $validationMapping = [
		'220' => "/^380(39|50|63|66|67|68|91|92|93|94|95|96|97|98|99|44|73)[0-9]{7}$/",
		'109' => "/^7((7[0-9]{9})|(6(7|9)[0-9]{8}))$/",
		/* for future */
		'176' => "/^7(9[0-9]{9})$/"
	];

	private $formatMapping = [
		'220' => "+XX(XXX)XXX-XX-XX",
		'109' => "+X(XXX)XXX-XX-XX",
		'176' => "+X(XXX)XXX-XX-XX"
	];

	public function __construct($registry){
		$this->country_id = $registry->get('config')->get('config_country_id');	

		if (!empty($this->validationMapping[$this->country_id])){
			$this->regular_expression = $this->validationMapping[$this->country_id];
		}	

		if (!empty($this->formatMapping[$this->country_id])){
			$this->format = $this->formatMapping[$this->country_id];
		}
	}

	public function validate($phone_number){
		if (!$this->regular_expression){
			return $phone_number;
		}

		$phone_number = preg_replace("/[^0-9]/", "", $phone_number);

		if (preg_match($this->regular_expression, $phone_number)) {
			return $this->format($phone_number);
		} else {
			return false;
		}
	}

	function format($phone_number) {
		if (!$this->format){
			return $phone_number;
		}

		$phone_number = preg_replace("/[^0-9]/", "", $phone_number);

		$formatted_phone_number = "";
		$i = 0;
		for ($j = 0; $j < strlen($this->format); $j++) {
			if ($this->format[$j] === "X") {
				$formatted_phone_number .= $phone_number[$i];
				$i++;
			} else {
				$formatted_phone_number .= $this->format[$j];
			}
		}
		return $formatted_phone_number;
	}
}
