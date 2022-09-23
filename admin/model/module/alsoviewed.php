<?php 
class ModelModuleAlsoviewed extends Model {
	public function __construct($register) {
		if (!defined('IMODULE_ROOT')) define('IMODULE_ROOT', substr(DIR_APPLICATION, 0, strrpos(DIR_APPLICATION, '/', -2)) . '/');
		if (!defined('IMODULE_SERVER_NAME')) define('IMODULE_SERVER_NAME', substr((defined('HTTP_CATALOG') ? HTTP_CATALOG : HTTP_SERVER), 7, strlen((defined('HTTP_CATALOG') ? HTTP_CATALOG : HTTP_SERVER)) - 8));
		parent::__construct($register);
	}
	public function install(){
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "alsoviewed`
	 (`id` INT(11) NOT NULL AUTO_INCREMENT, 
	 `low` INT(11) NULL DEFAULT '0',
	 `high` INT(11) NULL DEFAULT '0',
	 `number` INT(11) NULL DEFAULT '0',
	 `date_added` DATETIME  NOT NULL DEFAULT '0000-00-00 00:00:00', 
	  PRIMARY KEY (`id`));");	
	  
	  	$this->db->query("UPDATE `" . DB_PREFIX . "modification` SET status=1 WHERE `name` LIKE'%AlsoViewed by iSenseLabs%'");
		$modifications = $this->load->controller('extension/modification/refresh');
	}
	public function uninstall()	{
		  $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "alsoviewed`");
		 $this->db->query("UPDATE `" . DB_PREFIX . "modification` SET status=0 WHERE `name` LIKE'%AlsoViewed by iSenseLabs%'");
		$modifications = $this->load->controller('extension/modification/refresh');
	}
	
	public function getSetting($code, $store_id = 0) {
	    $this->load->model('setting/setting');
		return $this->model_setting_setting->getSetting($code,$store_id);
	}
  
  	public function editSetting($code, $data, $store_id = 0) {
	    $this->load->model('setting/setting');
		$this->model_setting_setting->editSetting($code,$data,$store_id);
	}

}
?>