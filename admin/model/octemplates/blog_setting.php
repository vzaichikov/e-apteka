<?php
/**************************************************************/
/*	@copyright	OCTemplates 2018.							  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */
/**************************************************************/

class ModelOctemplatesBlogSetting extends Model {
	public function installTables() {

		$sql  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."oct_blog_category` (";
		$sql .= "  `oct_blog_category_id` int(11) NOT NULL AUTO_INCREMENT,";
		$sql .= "  `image` varchar(255) DEFAULT NULL,";
		$sql .= "  `oct_blog_category_parent_id` int(11) NOT NULL DEFAULT '0',";
		$sql .= "  `sort_order` int(3) NOT NULL DEFAULT '0',";
		$sql .= "  `status` tinyint(1) NOT NULL,";
		$sql .= "  `date_added` datetime NOT NULL,";
		$sql .= "  `date_modified` datetime NOT NULL,";
		$sql .= "  PRIMARY KEY (`oct_blog_category_id`)";
		$sql .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;";

		$this->db->query($sql);

		$sql1  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."oct_blog_category_description` (";
		$sql1 .= "  `oct_blog_category_id` int(11) NOT NULL,";
		$sql1 .= "  `language_id` int(11) NOT NULL,";
		$sql1 .= "  `name` varchar(255) NOT NULL,";
		$sql1 .= "  `description` text NOT NULL,";
		$sql1 .= "  `meta_title` varchar(255) NOT NULL,";
		$sql1 .= "  `meta_description` varchar(255) NOT NULL,";
		$sql1 .= "  `meta_keyword` varchar(255) NOT NULL,";
		$sql1 .= "  PRIMARY KEY (`oct_blog_category_id`,`language_id`),";
		$sql1 .= "  KEY `name` (`name`)";
		$sql1 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$this->db->query($sql1);

		$sql2  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."oct_blog_category_to_layout` (";
		$sql2 .= "  `oct_blog_category_id` int(11) NOT NULL,";
		$sql2 .= "  `store_id` int(11) NOT NULL,";
		$sql2 .= "  `layout_id` int(11) NOT NULL,";
		$sql2 .= "  PRIMARY KEY (`oct_blog_category_id`,`store_id`)";
		$sql2 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$this->db->query($sql2);

		$sql3  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."oct_blog_category_to_store` (";
		$sql3 .= "  `oct_blog_category_id` int(11) NOT NULL,";
		$sql3 .= "  `store_id` int(11) NOT NULL,";
		$sql3 .= "  PRIMARY KEY (`oct_blog_category_id`,`store_id`)";
		$sql3 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$this->db->query($sql3);

		$sql4  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."oct_blog_category_path` (";
		$sql4 .= "  `oct_blog_category_id` int(11) NOT NULL,";
		$sql4 .= "  `oct_blog_category_path_id` int(11) NOT NULL,";
		$sql4 .= "  `level` int(11) NOT NULL,";
		$sql4 .= "  PRIMARY KEY (`oct_blog_category_id`,`oct_blog_category_path_id`)";
		$sql4 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

		$this->db->query($sql4);

		$sql5  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."oct_blog_article` (";
		$sql5 .= "  `oct_blog_article_id` int(11) NOT NULL AUTO_INCREMENT,";
		$sql5 .= "  `image` varchar(255) DEFAULT NULL,";
		$sql5 .= "  `sort_order` int(11) NOT NULL DEFAULT '0',";
		$sql5 .= "  `status` tinyint(1) NOT NULL DEFAULT '0',";
		$sql5 .= "  `viewed` int(5) NOT NULL DEFAULT '0',";
		$sql5 .= "  `date_added` datetime NOT NULL,";
		$sql5 .= "  `date_modified` datetime NOT NULL,";
		$sql5 .= "  PRIMARY KEY (`oct_blog_article_id`)";
		$sql5 .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;";

		$this->db->query($sql5);

		$sql6  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."oct_blog_article_description` (";
		$sql6 .= "  `oct_blog_article_id` int(11) NOT NULL,";
		$sql6 .= "  `language_id` int(11) NOT NULL,";
		$sql6 .= "  `name` varchar(255) NOT NULL,";
		$sql6 .= "  `description` text NOT NULL,";
		$sql6 .= "  `tag` text NOT NULL,";
		$sql6 .= "  `meta_title` varchar(255) NOT NULL,";
		$sql6 .= "  `meta_description` varchar(255) NOT NULL,";
		$sql6 .= "  `meta_keyword` varchar(255) NOT NULL,";
		$sql6 .= "  PRIMARY KEY (`oct_blog_article_id`,`language_id`),";
		$sql6 .= "  KEY `name` (`name`)";
		$sql6 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$this->db->query($sql6);

		$sql7  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."oct_blog_article_image` (";
		$sql7 .= "  `oct_blog_article_image_id` int(11) NOT NULL AUTO_INCREMENT,";
		$sql7 .= "  `oct_blog_article_id` int(11) NOT NULL,";
		$sql7 .= "  `image` varchar(255) DEFAULT NULL,";
		$sql7 .= "  `sort_order` int(3) NOT NULL DEFAULT '0',";
		$sql7 .= "  PRIMARY KEY (`oct_blog_article_image_id`),";
		$sql7 .= "  KEY `oct_blog_article_id` (`oct_blog_article_id`)";
		$sql7 .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;";

		$this->db->query($sql7);

		$sql8  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."oct_blog_article_products_related` (";
		$sql8 .= "  `oct_blog_article_id` int(11) NOT NULL,";
		$sql8 .= "  `product_related_id` int(11) NOT NULL,";
		$sql8 .= "  PRIMARY KEY (`oct_blog_article_id`,`product_related_id`)";
		$sql8 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$this->db->query($sql8);

		$sql9  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."oct_blog_article_articles_related` (";
		$sql9 .= "  `oct_blog_article_id` int(11) NOT NULL,";
		$sql9 .= "  `article_related_id` int(11) NOT NULL,";
		$sql9 .= "  PRIMARY KEY (`oct_blog_article_id`,`article_related_id`)";
		$sql9 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$this->db->query($sql9);

		$sql10  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."oct_blog_article_to_category` (";
		$sql10 .= "  `oct_blog_article_id` int(11) NOT NULL,";
		$sql10 .= "  `oct_blog_category_id` int(11) NOT NULL,";
		$sql10 .= "  `main_oct_blog_category_id` tinyint(1) NOT NULL DEFAULT '0',";
		$sql10 .= "  PRIMARY KEY (`oct_blog_article_id`,`oct_blog_category_id`),";
		$sql10 .= "  KEY `oct_blog_category_id` (`oct_blog_category_id`)";
		$sql10 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$this->db->query($sql10);

		$sql11  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."oct_blog_article_to_layout` (";
		$sql11 .= "  `oct_blog_article_id` int(11) NOT NULL,";
		$sql11 .= "  `store_id` int(11) NOT NULL,";
		$sql11 .= "  `layout_id` int(11) NOT NULL,";
		$sql11 .= "  PRIMARY KEY (`oct_blog_article_id`,`store_id`)";
		$sql11 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$this->db->query($sql11);

		$sql12  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."oct_blog_article_to_store` (";
		$sql12 .= "  `oct_blog_article_id` int(11) NOT NULL,";
		$sql12 .= "  `store_id` int(11) NOT NULL DEFAULT '0',";
		$sql12 .= "  PRIMARY KEY (`oct_blog_article_id`,`store_id`)";
		$sql12 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$this->db->query($sql12);

		$sql13  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."oct_blog_comments` (";
		$sql13 .= "  `oct_blog_comment_id` int(11) NOT NULL AUTO_INCREMENT,";
		$sql13 .= "  `oct_blog_article_id` int(11) NOT NULL,";
		$sql13 .= "  `customer_id` int(11) NOT NULL,";
		$sql13 .= "  `author` varchar(64) NOT NULL,";
		$sql13 .= "  `text` text NOT NULL,";
		$sql13 .= "  `rating` int(1) NOT NULL,";
		$sql13 .= "  `status` tinyint(1) NOT NULL DEFAULT '0',";
		$sql13 .= "  `plus` INT(11) NOT NULL DEFAULT  '0',";
		$sql13 .= "  `minus` INT( 11 ) NOT NULL DEFAULT '0',";
		$sql13 .= "  `date_added` datetime NOT NULL,";
		$sql13 .= "  `date_modified` datetime NOT NULL,";
		$sql13 .= "  PRIMARY KEY (`oct_blog_comment_id`),";
		$sql13 .= "  KEY `oct_blog_article_id` (`oct_blog_article_id`)";
		$sql13 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;";

		$this->db->query($sql13);

		$sql14  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."oct_blog_comments_like` (";
		$sql14 .= "  `oct_blog_comment_id` int(11) NOT NULL,";
		$sql14 .= "  `oct_blog_article_id` int(11) NOT NULL,";
		$sql14 .= "  `customer_id` int(11) NOT NULL,";
		$sql14 .= "  `customer_ip` varchar(40) NOT NULL";
		$sql14 .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$this->db->query($sql14);
	}

	public function deleteTables() {
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."oct_blog_category`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."oct_blog_category_description`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."oct_blog_category_to_layout`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."oct_blog_category_to_store`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."oct_blog_category_path`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."oct_blog_article`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."oct_blog_article_description`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."oct_blog_article_image`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."oct_blog_article_products_related`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."oct_blog_article_articles_related`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."oct_blog_article_to_category`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."oct_blog_article_to_layout`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."oct_blog_article_to_store`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."oct_blog_comments`;");
		$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."oct_blog_comments_like`;");
	}
}