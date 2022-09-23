<?php
	//Delete & Create Data Table
	$sql = "delete from ".DB_PREFIX."layout_module WHERE `layout_id` = ".$home_layout; $this->db->query($sql);
	$sql = "delete from ".DB_PREFIX."soconfig"; $this->db->query($sql);
	
	//Inset Data Table - themes, soconfig, module, layout_module
	$settings_sql = DIR_SYSTEM.'soconfig/demo/'.$install_layout.'/themes.sql';
	if( file_exists($settings_sql) ){
		$query_setting = loo_parse_queries($settings_sql,$home_layout);
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
	 *     ($home_layout) 	- ID of Home Layout
	 */
	function loo_parse_queries($sql_file,$home_layout=null) {
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
					if($home_layout!=null) {
						$query =  str_replace('{home_layout_id}',$home_layout,$query);
					}
					$query = str_replace(array($matches[0], 'key = '), array($table_name, '`key` = '), $query);
				}
				$queries[] = $query;
			}
		}
		
		return $queries ;
		
	}
	
	
?>