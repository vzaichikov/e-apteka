<?php
class Cache {
	private $adaptor;

	public function __construct($adaptor, $expire = 7200) {
		$class = 'Cache\\' . $adaptor;

		if (class_exists($class)) {
			$this->adaptor = new $class($expire);
		} else {
			throw new \Exception('Error: Could not load cache adaptor ' . $adaptor . ' cache!');
		}
	}
	
	public function get($key) {				
		return $this->adaptor->get($key);
	}
	
	public function flush() {	
		if (method_exists($this->adaptor, 'flush')){
			return $this->adaptor->flush();
		} else {
			return false;
		}
	}

	public function set($key, $value) {
		return $this->adaptor->set($key, $value);
	}

	public function delete($key) {
		return $this->adaptor->delete($key);
	}
}
