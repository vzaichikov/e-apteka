<?
	class ModelHobotixSearch extends Model {
		
		
		private static function date_added_sorter($a, $b) {
			return strtotime($a['date_added']) < strtotime($b['date_added']);
		}
		
		
		public function getPopularSearches(){
			
		//	$query = $this->db->ncquery("SELECT * FROM search_history WHERE results > 10  AND times > 5 ORDER BY times DESC LIMIT 10");

			$query = $this->db->ncquery("SELECT * FROM search_history WHERE results > 30 AND times > 5 ORDER BY RAND() DESC LIMIT 10");
			
			shuffle($query->rows);			
			
			return $query->rows;
			
			
		}
		
		public function getSearchHistory(){
			$data = array();
			
			if ($this->customer->isLogged()){
				
				$query = $this->db->ncquery("SELECT * FROM customer_search_history WHERE customer_id = '" . $this->customer->isLogged() . "' ORDER BY date_added DESC LIMIT 10");
				
				foreach ($query->rows as $history){
					$data[] = array(
					'href' => $this->url->link('product/search', 'search=' . $history['text']),
					'id'   => $history['customer_history_id'],
					'date_added' => date('d.m.Y H:i', strtotime($history['date_added'])),
					'text' => $history['text']
					);
				}
				
				} else {
				
				if (!empty($this->session->data['customer_search_history'])){
					
					usort($this->session->data['customer_search_history'], array('ModelHobotixSearch', 'date_added_sorter'));
					
					foreach ($this->session->data['customer_search_history'] as $history){
						$history['href'] = $this->url->link('product/search', 'search=' . $history['text']);
						$history['id'] = !empty($history['id'])?$history['id']:md5($history['text']);
						$history['date_added'] = date('d.m.Y H:i', strtotime($history['date_added']));
						$data[] = $history;
					}
					
				}
				
			}
			
			return $data;
		}
		
		public function clearSearchHistory($id = false){
			
			if ($this->customer->isLogged()){
			if ($id == 'all'){
				$this->db->ncquery("DELETE FROM customer_search_history WHERE customer_id = '" . (int)$this->customer->isLogged() . "'");
				} else {
				$this->db->ncquery("DELETE FROM customer_search_history WHERE customer_id = '" . (int)$this->customer->isLogged() . "' AND customer_history_id = '" . (int)$id . "'");
			}
			} else {

			if (empty($this->session->data['customer_search_history'])){
				$this->session->data['customer_search_history'] = array();
				}
				
				if ($id == 'all'){
					$this->session->data['customer_search_history'] = array();
				} else {
				$tmp = array();
				foreach ($this->session->data['customer_search_history'] as $history){
					if ($history['id'] != $id && md5($history['text']) != $id){
						$tmp[] = $history;
					}
				}
				$this->session->data['customer_search_history'] = $tmp;
			}
			
		}
		
		}
		
		public function writeSearchHistory($search_history, $results = 0){
			$search_history = trim($search_history);
			
			$this->db->ncquery("INSERT INTO search_history SET text = '" . $this->db->escape($search_history) . "', times = 1, results = '" . (int)$results . "' ON DUPLICATE KEY UPDATE times = times + 1, results = '" . (int)$results . "'");
			
			if ($this->customer->isLogged()){
				
				$this->db->ncquery("INSERT INTO customer_search_history SET customer_id = '" . (int)$this->customer->isLogged() . "', text = '" . $this->db->escape($search_history) . "', date_added = NOW() ON DUPLICATE KEY UPDATE date_added = NOW()");
				
				if (!empty($this->session->data['customer_search_history'])){										
					
					foreach ($this->session->data['customer_search_history'] as $history){
						$this->db->ncquery("INSERT IGNORE INTO customer_search_history SET customer_id = '" . $this->customer->isLogged() . "', text = '" . $this->db->escape($history['text']) . "', date_added = '" . date('Y-m-d H:i:s', strtotime($history['date_added'])) . "'");
					}
					
					unset($this->session->data['customer_search_history']);
				}
				
				} else {
				
				if (empty($this->session->data['customer_search_history'])){
					$this->session->data['customer_search_history'] = array();
				}
				
				$exists = false;
				foreach ($this->session->data['customer_search_history'] as &$history){
					if ($history['text'] == $search_history){
						$history['date_added'] = date('Y-m-d H:i:s');
						$exists = true;
					}					
				}				
				
				if (!$exists){
					$this->session->data['customer_search_history'][] = array(
					'date_added' => date('Y-m-d H:i:s'),
					'text'		 => $search_history,
					'id'		 => md5($search_history)
					);
				}
				
			}
		}
		
	}		 								