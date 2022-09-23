<?php
namespace Cache;
class Mem {
	private $expire;
	private $memcache;
	
	const CACHEDUMP_LIMIT = 9999;
	const CACHE_HOSTNAME = 'localhost';
	const CACHE_PORT = 11211;
	const CACHE_PREFIX = 'n9_';

	public function __construct($expire) {
		$this->expire = $expire;

		$this->memcache = new \Memcache();
		$this->memcache->pconnect(self::CACHE_HOSTNAME, self::CACHE_PORT);
	}

	public function get($key) {
		return $this->memcache->get(self::CACHE_PREFIX . $key);
	}

	public function set($key, $value) {
		return $this->memcache->set(self::CACHE_PREFIX . $key, $value, MEMCACHE_COMPRESSED, $this->expire);
	}
	
	public function flush() {
		return $this->memcache->flush();
	}

	public function delete($key) {
		$all_slabs = $this->memcache->getExtendedStats('slabs');
		foreach ($all_slabs as $server => $slabs) {
			foreach ($slabs as $slab_id => $slab_meta) {
				if (!is_int($slab_id)) {
					continue;
				}
				$cachedump = $this->memcache->getExtendedStats('cachedump', $slab_id, self::CACHEDUMP_LIMIT);
				foreach ($cachedump as $server => $entries) {
					if (!empty($entries) && is_array($entries)) {
						foreach (array_keys($entries) as $entry_key) {
							if (strpos($entry_key, self::CACHE_PREFIX . $key) === 0) {
								$this->memcache->delete($entry_key);
							}
						}
					}
				}
			}
		}
	}
}