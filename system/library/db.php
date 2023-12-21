<?php
	class DB {
		private $adaptor;
		
		private $uncacheableTables = [];
		
		public function __construct($adaptor, $hostname, $username, $password, $database, $port = NULL, $registry = false) {
			$class = 'DB\\' . $adaptor;

			if (function_exists('loadJsonConfig')){
				$jsonConfig = loadJsonConfig('dbcache');
				$this->uncacheableTables = $jsonConfig['uncacheableTables'];
			}
			
			if (class_exists($class)) {
				
				$class_reflection = new ReflectionClass($class);
				$constructor = $class_reflection->getConstructor();
				
				if ($constructor->getNumberOfParameters() == 6){				
					$this->adaptor = new $class($hostname, $username, $password, $database, $port, $registry);				
					} else {
					$this->adaptor = new $class($hostname, $username, $password, $database, $port);			
				}			

				if (defined('DEBUGSQL') && DEBUGSQL) {			
					$GLOBALS['sql'] = [];
				}

				} else {
				throw new \Exception('Error: Could not load database adaptor ' . $adaptor . '!');
			}
		}
		
		public function query_old($sql, $params = array()) {
			return $this->adaptor->query($sql, $params);
		}

		public function ecquery($sql, $params = array()){
			if (defined('DEBUGSQL') && DEBUGSQL) {
				$startTime = microtime(true);
			}

			$result = $this->adaptor->query($sql, $params);


			if (defined('DEBUGSQL') && DEBUGSQL) {
				$finishTime = microtime(true) - $startTime;	
				$GLOBALS['sql'][] = [
					'query' 		=> (new Doctrine\SqlFormatter\SqlFormatter())->highlight($sql),
					'query2'		=> $sql,
					'debug'			=> debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS),
					'time'  		=> $finishTime,
					'fromCache' 	=> $result->fromCache
				];
			}
			
			return $result;
		}
		
		public function query($sql, $params = array(), $cache = false) {
			if (defined('DEBUGSQL') && DEBUGSQL) {
				$startTime = microtime(true);
			}

			if (!$cache){
				foreach ($this->uncacheableTables as $table){
					if (strpos($sql, $table)){		
						$result = $this->ncquery($sql, $params);
						break;
					}
				}		
			}
				

			if (empty($result)){
				$result = $this->adaptor->query($sql, $params);
			}

			if (defined('DEBUGSQL') && DEBUGSQL) {
				$finishTime = microtime(true) - $startTime;	
				$GLOBALS['sql'][] = [
					'query' 		=> (new Doctrine\SqlFormatter\SqlFormatter())->highlight($sql),
					'query2'		=> $sql,
					'debug'			=> debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS),
					'time'  		=> $finishTime,
					'fromCache' 	=> !empty($result->fromCache)?$result->fromCache:'unknown'
				];
			}
			
			return $result;
		}
		
		public function ncquery($sql, $params = array()) {
			if (defined('DEBUGSQL') && DEBUGSQL) {
				$startTime = microtime(true);
			}

			if (method_exists($this->adaptor, 'ncquery')){
				
				$result = $this->adaptor->ncquery($sql, $params);				

				if (defined('DEBUGSQL') && DEBUGSQL) {
				$finishTime = microtime(true) - $startTime;	
				$GLOBALS['sql'][] = [
					'query' 		=> (new Doctrine\SqlFormatter\SqlFormatter())->highlight($sql),
					'query2'		=> $sql,
					'debug'			=> debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS),
					'time'  		=> $finishTime,
					'fromCache' 	=> !empty($result->fromCache)?$result->fromCache:'unknown'
					];
				}

				return $result;

				} else {
				return $this->adaptor->query($sql, $params);
			}
		}
		
		public function escape($value) {
			return $this->adaptor->escape($value);
		}
		
		public function countAffected() {
			return $this->adaptor->countAffected();
		}
		
		public function getLastId() {
			return $this->adaptor->getLastId();
		}
		
		public function connected() {
			return $this->adaptor->connected();
		}
	}			