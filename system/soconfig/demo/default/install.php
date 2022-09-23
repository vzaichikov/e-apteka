<?php
	$number_store = count($stores);
	if($number_store > 1){
		$sql = "delete from ".DB_PREFIX."layout_module WHERE `layout_id` = ".$home_layout; $this->db->query($sql);
		$sql = "delete from ".DB_PREFIX."soconfig"; $this->db->query($sql);
		
		//Inset Data Table - soconfig, layout_module
		$quickstart_sql = DIR_SYSTEM.'soconfig/demo/'.$install_layout.'/quickstart.sql';
		if( file_exists($quickstart_sql)){
			$query_quickstart = loo_parse_queries($quickstart_sql,DB_PREFIX,$home_layout);
			foreach ($query_quickstart as $query) {
				$this->db->query($query);
			}
		} 
		
	}else{
		//var_dump(DB_PREFIX);exit;
		//Delete & Create Data Table
		$sql = "delete from ".DB_PREFIX."setting WHERE `code` IN ('theme_default','so_sociallogin','so_onepagecheckout')" ; $this->db->query($sql);
		$sql = "delete from ".DB_PREFIX."soconfig"; $this->db->query($sql);
		$sql = "DELETE FROM ".DB_PREFIX."layout_module"; $this->db->query($sql);
		$sql = "delete from ".DB_PREFIX."module where `code` REGEXP 'so|bestseller'" ; $this->db->query($sql);
		$sql = "delete from ".DB_PREFIX."modification"; $this->db->query($sql);
		$sql = "delete from ".DB_PREFIX."extension where `code` REGEXP 'so|simple_blog'"; $this->db->query($sql);
		
		$sql ="DROP TABLE IF EXISTS `".DB_PREFIX."mega_menu`"; $this->db->query($sql);
		$sql ="DROP TABLE IF EXISTS `".DB_PREFIX."so_homeslider`"; $this->db->query($sql);
		$sql ="DROP TABLE IF EXISTS `".DB_PREFIX."so_homeslider_description`"; $this->db->query($sql);
		$sql ="DROP TABLE IF EXISTS `".DB_PREFIX."simple_blog_category`"; $this->db->query($sql);
		$sql ="DROP TABLE IF EXISTS `".DB_PREFIX."simple_blog_category_description`"; $this->db->query($sql);
	

		$sql="CREATE TABLE `".DB_PREFIX."mega_menu` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `parent_id` int(11) NOT NULL, `rang` int(11) NOT NULL, `icon` varchar(255) NOT NULL DEFAULT '', `name` text, `type_link` int(11) DEFAULT NULL, `module_id` int(11) DEFAULT NULL, `link` text, `description` text, `new_window` int(11) NOT NULL DEFAULT '0', `status` int(11) NOT NULL DEFAULT '0', `position` int(11) NOT NULL DEFAULT '0', `submenu_width` text, `submenu_type` int(11) NOT NULL DEFAULT '0', `content_width` int(11) NOT NULL DEFAULT '12', `content_type` int(11) NOT NULL DEFAULT '0', `content` text, `label_item` varchar(255) NOT NULL DEFAULT '', `icon_font` varchar(255) NOT NULL DEFAULT '', `class_menu` varchar(255) DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=247 DEFAULT CHARSET=utf8"; $this->db->query($sql);
		$sql="CREATE TABLE `".DB_PREFIX."so_homeslider` (`id` int(11) NOT NULL AUTO_INCREMENT, `module_id` int(11) NOT NULL, `url` varchar(255) NOT NULL, `position` int(11) NOT NULL, `image` varchar(255) NOT NULL, `status` tinyint(1) NOT NULL, PRIMARY KEY (`id`), KEY `id` (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8"; $this->db->query($sql);
		$sql="CREATE TABLE `".DB_PREFIX."so_homeslider_description` (`homeslider_id` int(11) NOT NULL AUTO_INCREMENT,`language_id` int(11) NOT NULL,`title` varchar(255) NOT NULL,`caption` varchar(255) NOT NULL,`description` text NOT NULL,PRIMARY KEY (`homeslider_id`,`language_id`),KEY `title` (`title`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"; $this->db->query($sql);		
    	$sql="CREATE TABLE IF NOT EXISTS ". DB_PREFIX . "simple_blog_category( `simple_blog_category_id` int(16) NOT NULL AUTO_INCREMENT, `image` text NOT NULL, `parent_id` int(16) NOT NULL, `top` tinyint(1) NOT NULL, `blog_category_column` int(16) NOT NULL, `external_link` text NOT NULL, `column` int(8) NOT NULL, `sort_order` int(8) NOT NULL, `status` tinyint(1) NOT NULL, `date_added` datetime NOT NULL, `date_modified` datetime NOT NULL, PRIMARY KEY (`simple_blog_category_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1"; $this->db->query($sql);
    	$sql="CREATE TABLE IF NOT EXISTS ". DB_PREFIX . "simple_blog_category_description( `simple_blog_category_description_id` int(16) NOT NULL AUTO_INCREMENT, `simple_blog_category_id` int(16) NOT NULL, `language_id` int(16) NOT NULL, `name` varchar(256) NOT NULL, `description` text NOT NULL, `meta_description` varchar(256) NOT NULL, `meta_keyword` varchar(256) NOT NULL, PRIMARY KEY (`simple_blog_category_description_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci"; $this->db->query($sql);
    	
    	



		//Inset Data Table - themes, soconfig, module, layout_module
		$settings_sql = DIR_SYSTEM.'soconfig/demo/'.$install_layout.'/themes.sql';
		if( file_exists($settings_sql) ){
			$query_setting = loo_parse_queries($settings_sql,DB_PREFIX,$home_layout);
			foreach ($query_setting as $query) {
				$this->db->query($query);
			}
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
	function loo_parse_queries($sql_file,$prefix,$home_layout=null) {
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