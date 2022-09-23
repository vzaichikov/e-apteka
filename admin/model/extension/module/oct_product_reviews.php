<?php
/**************************************************************/
/*	@copyright	OCTemplates 2018.							  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */
/**************************************************************/

class ModelExtensionModuleOctProductReviews extends Model {
	public function makeDB() {
		$sql1  = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "oct_product_reviews` ( ";
		$sql1 .= "`review_id` int(11) NOT NULL, ";
		$sql1 .= "`where_bought` int(11) NOT NULL DEFAULT '0', ";
		$sql1 .= "`admin_answer` text NOT NULL, ";
		$sql1 .= "`positive_text` text NOT NULL, ";
		$sql1 .= "`negative_text` text NOT NULL";
		$sql1 .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$this->db->query($sql1);

		$sql2  = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "oct_product_reviews_reputation` ( ";
		$sql2 .= "`review_id` int(11) NOT NULL, ";
		$sql2 .= "`ip` varchar(40) COLLATE utf8_general_ci NOT NULL, ";
		$sql2 .= "`plus_reputation` int(11) NOT NULL DEFAULT '0', ";
		$sql2 .= "`minus_reputation` int(11) NOT NULL DEFAULT '0'";
		$sql2 .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$this->db->query($sql2);
	}

	public function removeDB() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "oct_product_reviews`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "oct_product_reviews_reputation`;");
	}
}