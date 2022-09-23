<?php
class ModelModuleAlsoViewed extends Model {

  	public function getSetting($code, $store_id) {
	    $this->load->model('setting/setting');
		return $this->model_setting_setting->getSetting($code,$store_id);
  	}


}
?>