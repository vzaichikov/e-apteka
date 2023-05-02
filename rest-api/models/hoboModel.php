<?

namespace hobotix;

class hoboModel{
	public $db = null;


	public function __construct($dbObject){
		$this->db = $dbObject;
	}


	public function escape($string) {
		return "'" . $this->db->escape($string) . "'";
	}

}