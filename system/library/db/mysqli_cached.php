<?php
	namespace DB;
	final class MySQLi_Cached {
		private $connection;
		private $cache;
		private $config;
		private $registry;
		
		public function __construct($hostname, $username, $password, $database, $port = '3306', $registry) {
			
			if (stripos($hostname, 'sock')){
				$socket = $hostname;
				$hostname = NULL;
				} else {
				$socket = false;
			}
			
			
			$this->registry = $registry;		
			$this->cache = $this->registry->get('cache');						
			
			$this->connection = new \mysqli($hostname, $username, $password, $database, $port, $socket);
			
			if ($this->connection->connect_error) {
				throw new \Exception('Error: ' . $this->connection->error . '<br />Error No: ' . $this->connection->errno);
			}
			
			$this->connection->set_charset("utf8");
			$this->connection->query("SET names utf8mb4");
			$this->connection->query("SET SQL_MODE = ''");
		}
		
		public function query($sql) {		

			// if(defined('DEBUG') && DEBUG){
			// 	if ($sql == "SELECT * FROM oc_setting WHERE store_id = '0' AND `code` = 'config'"){
			// 		 print('<pre>');
			// 		 debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
			// 		 print('</pre>');
			// 	}
			// }			
								
			if (stripos($sql, 'select ') === 0){
				if ($result = $this->cache->get('sql.' . md5($sql))){
					if (isset($result->sql) AND $result->sql == $sql) {
						$result->fromCache = 'FromCache';
						return($result);					
					}				
				}
			}

			$query = $this->connection->query($sql);
			
			if (!$this->connection->errno) {
				if ($query instanceof \mysqli_result) {
					$data = array();
					
					while ($row = $query->fetch_assoc()) {
						$data[] = $row;
					}
					
					$result = new \stdClass();
					$result->num_rows = $query->num_rows;
					$result->row = isset($data[0]) ? $data[0] : array();
					$result->rows = $data;
					
					$result->sql = $sql;
					$result->fromCache = 'Cacheable';
					$this->cache->set('sql.' . md5($sql), $result);
					
					$query->close();
					
					return $result;
					} else {
					return true;
				}
				} else {
				throw new \Exception('Error: ' . $this->connection->error  . '<br />Error No: ' . $this->connection->errno . '<br />' . $sql);
			}
		}
		
		public function ncquery($sql) {				
		
			$query = $this->connection->query($sql);

			if (!$this->connection->errno) {
				if ($query instanceof \mysqli_result) {
					$data = array();

					while ($row = $query->fetch_assoc()) {
						$data[] = $row;
					}
					
					$result = new \stdClass();
					$result->num_rows = $query->num_rows;
					$result->row = isset($data[0]) ? $data[0] : array();
					$result->rows = $data;
					$result->fromCache = 'NonCached';
					
					$query->close();
					
					return $result;
					} else {
					return true;
				}
				} else {
				throw new \Exception('Error: ' . $this->connection->error  . '<br />Error No: ' . $this->connection->errno . '<br />' . $sql);
			}
		}
		
		public function escape($value) {
			return $this->connection->real_escape_string($value);
		}
		
		public function countAffected() {
			return $this->connection->affected_rows;
		}
		
		public function getLastId() {
			return $this->connection->insert_id;
		}
		
		public function connected() {
			return $this->connection->ping();
		}
		
		public function __destruct() {
			$this->connection->close();
		}
	}
