<?php
	namespace DB;
	final class MySQLi_LBC2 {
		private $connection;
		private $cache;
		private $slave;
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
			$this->slave = $this->registry->get('db_slave');
			
			$this->connection = new \mysqli($hostname, $username, $password, $database, $port, $socket);
			
			if ($this->connection->connect_error) {
				throw new \Exception('Error: ' . $this->connection->error . '<br />Error No: ' . $this->connection->errno);
			}
			
			$this->connection->set_charset("utf8");
			$this->connection->query("SET names utf8mb4");
			$this->connection->query("SET SQL_MODE = ''");
		}
		
		public function query($sql) {					
								
			if (stripos($sql, 'select ') === 0){
				if ($result = $this->cache->get('sql.' . md5($sql))){					
					if (isset($result->sql) AND $result->sql == $sql) {
						return($result);					
					}				
				}
			}
			
			if (stripos($sql, 'select ') === 0){
				if ($this->slave){					
					if (mt_rand(0,1) == 1){
						return $this->slave->query($sql);
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
		
			if (stripos($sql, 'select ') === 0){
				if ($this->slave){		
					if (mt_rand(0,1) == 1){
						return $this->slave->query($sql);
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
