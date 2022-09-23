<?php 
class ModelLoggerAdmin extends Model {
	public function check_return_url()
	{
		
		if(!strstr(@$_SERVER['HTTP_REFERER'], $_GET['route']))
		{			
			return true;			
		}
		else
		{
			return false;
		}
		
	}
	public function get_page_route($page)
	{
		$pageroute = explode("&",$_SERVER['QUERY_STRING']);			
		$page_route = $pageroute[0];
		if($page_route == $page)
		{
			return true;
		}
		else
		{
			return false;
		}
	}	
	
	public function logEvent($data,$item,$action) {
		@$this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "logger SET log_date = NOW(), log_item = '" . $item. "', log_action='".$action."', user_name='".$this->user->getUserName()."', user_fullname='".$this->db->escape($this->user->getFullName())."', ip_address='".$_SERVER['REMOTE_ADDR']."', url='".$this->db->escape($this->selfURL())."', data='".$this->db->escape(serialize($data))."'");				
	}
	
	public function selfURL() {
		$s = empty($_SERVER["HTTPS"]) ? ''
			: ($_SERVER["HTTPS"] == "on") ? "s"
			: "";
		$protocol = $this->strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
		$port = ($_SERVER["SERVER_PORT"] == "80") ? ""
			: (":".$_SERVER["SERVER_PORT"]);
		return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
	}
	public function strleft($s1, $s2) {
		return substr($s1, 0, strpos($s1, $s2));
	}
	
	public function getLog($log_id) {
		$log_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "logger`  WHERE log_id = '" . (int)$log_id . "'");

		if ($log_query->num_rows) {
			return array(
				'log_id'                => $log_query->row['log_id'],
				'log_date'              => $log_query->row['log_date'],
				'log_item'          => $log_query->row['log_item'],
				'log_action'                => $log_query->row['log_action'],
				'user_name'              => $log_query->row['user_name'],
				'ip_address'               => $log_query->row['ip_address'],
				'log_data'               => $log_query->row['data']
			);
		} else {
			return false;
		}
	}
	
	public function clearLogs() {
		$this->db->query("DELETE FROM " . DB_PREFIX . "logger ");
	}
	
	public function getLogItems() {
		$sql = "SELECT DISTINCT log_item FROM " . DB_PREFIX . "logger ORDER BY log_item";
		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getLogActions() {
		$sql = "SELECT DISTINCT log_action FROM " . DB_PREFIX . "logger ORDER BY log_action";
		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getLogUsers() {
		$sql = "SELECT DISTINCT user_name FROM " . DB_PREFIX . "logger ORDER BY user_name";
		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getTotalLogs($data = array()) {
      	$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "logger`";

		if (isset($data['filter_log_item']) && !is_null($data['filter_log_item'])) {
			$sql .= " WHERE log_item = '" . $data['filter_log_item'] . "'";
		} else {
			$sql .= " WHERE log_id > 0";
		}
		
		if (!empty($data['filter_log_date'])) {
			$sql .= " AND DATE(log_date) = DATE('" . $this->db->escape($data['filter_log_date']) . "')";
		}

		if (!empty($data['filter_log_action'])) {
			$sql .= " AND log_action = '" . $data['filter_log_action'] . "'";
		}

		if (!empty($data['filter_user_name'])) {
			$sql .= " AND user_name = '" . $data['filter_user_name'] . "'";
		}

		if (!empty($data['filter_ip_address'])) {
			$sql .= " AND ip_address LIKE '%" . $data['filter_ip_address'] . "%'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function getLogs($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "logger` ";

		if (isset($data['filter_log_item']) && !is_null($data['filter_log_item'])) {
			$sql .= " WHERE log_item = '" . $data['filter_log_item'] . "'";
		} else {
			$sql .= " WHERE log_id > 0";
		}
		
		if (!empty($data['filter_log_date'])) {
			$sql .= " AND DATE(log_date) = DATE('" . $this->db->escape($data['filter_log_date']) . "')";
		}

		if (!empty($data['filter_log_action'])) {
			$sql .= " AND log_action = '" . $data['filter_log_action'] . "'";
		}

		if (!empty($data['filter_user_name'])) {
			$sql .= " AND user_name = '" . $data['filter_user_name'] . "'";
		}

		if (!empty($data['filter_ip_address'])) {
			$sql .= " AND ip_address LIKE '%" . $data['filter_ip_address'] . "%'";
		}

		$sort_data = array(
			'filter_log_date',
			'filter_log_item',
			'filter_log_action',
			'filter_user_name',
			'filter_ip_address'
		);

		//if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
		if (isset($data['sort']) ) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY log_id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

	if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			
			if( isset($_REQUEST['page']) )
			{
								
				if($_REQUEST['page'] == 0){$_REQUEST['page'] = 1;}
				$offset = ($_REQUEST['page']-1)*$this->config->get('config_limit_admin');
			}
			else
			{
				$offset = 0;
			}			
						
			if ($data['limit'] < 1) {
				$data['limit'] = $this->config->get('config_limit_admin');
			}

			$sql .= " LIMIT " . (int)$offset . "," . (int)$data['limit'];
		}
		$query = $this->db->query($sql);

		return $query->rows;
	}
}
?>