<?php
	
	$sql = "delete from ".DB_PREFIX."layout where `layout_id` = '32'"; $this->db->query($sql);
		$sql = "delete from ".DB_PREFIX."layout_module where `layout_id` = '32'"; $this->db->query($sql);
		$sql = "delete from ".DB_PREFIX."layout_route where `layout_id` = '32'"; $this->db->query($sql);
		$sql = "delete from ".DB_PREFIX."setting WHERE `code` IN ('so_mobile')" ; $this->db->query($sql);
		
		$settings_sql = DIR_SYSTEM.'soconfig/demo/'.$install_layout.'/themes.sql';
		if( file_exists($settings_sql) ){
			$query_setting = loo_parse_queries($settings_sql,DB_PREFIX);
			foreach ($query_setting as $query) {
				$this->db->query($query);
			}
		} 
	
	/**
	 * Function loo_parse_queries
	 * Performs a query on the database
	 *
	 * Parameters:
	 *     ($db) 			- 
	 *     ($sql_file) 		- Source File SQL
	 *     ($prefix) 		- Prefix of DB
	 */
	function loo_parse_queries($sql_file,$prefix) {
		$contents = file_get_contents($sql_file);
		$contents 	= preg_replace('/(?<=t);(?=\n)/', "{{semicolon_in_text}}", $contents);
		$statements = preg_split('/;(?=\n)/', $contents);
		
		$queries = array();
		foreach ($statements as $query) {
			if (trim($query) != '') {
				$query = str_replace("{{semicolon_in_text}}", ";", $query);
				//apply db prefix parametr
				preg_match("/\{table_prefix}\w*/i", $query, $matches);
				$table_name = str_replace('{table_prefix}', DB_PREFIX, $matches[0]);
				if ( !empty($table_name) ) {
					
					$query = str_replace(array($matches[0], 'key = '), array($table_name, '`key` = '), $query);
				}
				$queries[] = $query;
			}
		}
		
		return $queries ;
		
	}
	
	
?>