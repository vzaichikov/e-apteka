<?php
	class ModelEaptekaIndexer extends Model {
		
		
		
		public function getIndexes($data = array()) {
			$sql = "SELECT * FROM " . DB_PREFIX . "indexer_history";
			
			$sql .= " ORDER BY date_added DESC";
			
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}
				
				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}
				
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
			
			$query = $this->db->query($sql);
			
			return $query->rows;
		}
		
		public function getTotalIndexes() {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "indexer_history");
			
			return $query->row['total'];
		}
		
		
		
		
		
	}		