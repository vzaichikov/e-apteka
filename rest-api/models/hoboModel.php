<?

namespace hobotix;

class hoboModel{
	public $db 		= null;
	public $cache 	= null;

	public function __construct($dbObject, $cacheObject = null){
		$this->db 		= $dbObject;
		$this->cache 	= $cacheObject;
	}

	public function escape($string) {
		return "'" . $this->db->escape($string) . "'";
	}

	public function getProductIdByUUID($uuid){
		if (is_numeric($uuid)){
			return $uuid;
		}

		$product_id = $this->cache->get('uuid-to-id-' . $uuid);
		if ($product_id){
			return $product_id;
		}

		$query = $this->db->query("SELECT product_id FROM oc_product WHERE uuid = '" . $this->db->escape($uuid) . "' LIMIT 1");

		if ($query->num_rows){
			$product_id = $query->row['product_id'];
		} else {
			$product_id = 0;
		}

		$this->cache->set('uuid-to-id-' . $uuid, $product_id);

		return $product_id;
	}

}