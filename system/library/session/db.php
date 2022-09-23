<?php

namespace Session;
class DB extends \SessionHandler {
	private $db = null;

	public $data = array();
	public $is_bot = array();
	public $expire = 5184000;

	private $cliSession = [
		'language' => 'uk-ua',
		'currency' => 'UAH'
	];
	
	public function __construct($registry) {
		$this->db = $registry->get('db');

		$this->is_bot = $registry->get('crawlerDetect')->isCrawler();

		register_shutdown_function('session_write_close');
	}

	private function is_cli(){
		return (php_sapi_name() === 'cli');
	}
	
	private function is_curl(){

		if (empty($_SERVER['HTTP_USER_AGENT'])){
			return false;
		}

		return (strpos($_SERVER['HTTP_USER_AGENT'], 'curl') === 0);
	}

	private function is_bot(){		
		return $this->is_bot;
	}

	private function check(){		
		return $this->is_cli() || $this->is_curl() || $this->is_bot();
	}
	
	public function open($save_path, $session_id): bool {
		if ($this->db){
			return true;
		} else {
			return false;
		}
	}
	
	public function close() {
		return true;
	}
	
	public function read($session_id): string {

		if ($this->check()){
			return serialize($this->cliSession);
		}

		$query = $this->db->ncquery("SELECT `data` FROM `" . DB_PREFIX . "session` WHERE session_id = '" . $this->db->escape($session_id) . "'");

		if ($query->num_rows) {
			return $query->row['data'];
		} else {
			return false;
		}
	}
	
	public function write($session_id, $data): bool {

		if ($this->check()){			
			return true;
		}

		$expire = date('Y-m-d H:i:s', time() + $this->expire);
		$data = $this->db->escape($data);
		
		/*
		$ip = $_SERVER['REMOTE_ADDR'];
		$ua = $_SERVER['HTTP_USER_AGENT'];
		$qs = $_SERVER['QUERY_STRING'];
		*/

	//	$sql = "REPLACE INTO `" . DB_PREFIX . "session` (`session_id`, `data`, `expire`, `ip`, `ua`, `qs`) VALUES('$session_id', '$data', '$expire', '$ip', '$ua', '$qs')";
		$sql = "REPLACE INTO `" . DB_PREFIX . "session` (`session_id`, `data`, `expire`) VALUES('$session_id', '$data', '$expire')";

		$this->db->ncquery($sql);
		
		return true;
	}
	
	public function destroy($session_id) {
		$this->db->ncquery("DELETE FROM `" . DB_PREFIX . "session` WHERE session_id = '" . $this->db->escape($session_id) . "'");
		
		return true;
	}
	
	public function gc($expire) {
		$this->db->ncquery("DELETE FROM `" . DB_PREFIX . "session` WHERE DATE(expire) < DATE_SUB(NOW(), INTERVAL 30 DAY)");
		
		return true;
	}
}
