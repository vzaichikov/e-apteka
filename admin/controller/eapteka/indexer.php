<?php
	class ControllerEaptekaIndexer extends Controller {
	
		public function eventRouteEdit_addToIndexerQueue($route, $arr) {
			$this->db->query("INSERT IGNORE INTO `" . DB_PREFIX . "indexer_queue` SET 
				indexer_entity_route = '" . $this->db->escape($route) . "', 
				indexer_entity_id = '" . (int)$arr[0] . "'");			
		}

	}