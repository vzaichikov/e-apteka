<?php
class ControllerExtensionModuleBrandManufacturer extends Controller {
	public function index($setting) {

		$data['heading_title'] = $setting['name'];

		$this->load->model('catalog/manufacturer');

		$this->load->model('tool/image');

		$data['status_brands'] = $setting['status'];

		$data['quantity'] = $setting['quantity'];

		$data['auto_play'] = $setting['auto_play'];

		$data['show_pagination'] = $setting['show_pagination'];

		$data['pause_on_hover'] = $setting['pause_on_hover'];

		$data['type'] = $setting['type'];

		$data['manufacturers'] = array();

		if ($setting['all'] == 1){
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturers($data);

			foreach ($manufacturer_info as $key => $value) {
				$image = $this->model_tool_image->resize($value['image'], $setting['thumb_width'], $setting['thumb_height']);
				if(!$image){
					$image = $this->model_tool_image->resize('placeholder.png', $setting['thumb_width'], $setting['thumb_height']);	
				} 

				$data['manufacturers'][] = array(
					'manufacturer_id'  => $value['manufacturer_id'],
					'thumb'            => $image,
					'name'             => $value['name'],
					'href'             => $this->url->link('product/manufacturer/info', '&manufacturer_id=' . $value['manufacturer_id'], true)
				);
			}
		} elseif ($setting['all'] == 2) {
			if(!empty($setting['manufacturers'])){
				foreach ($setting['manufacturers'] as $manufacturer_id) {
					$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);
					if ($manufacturer_info) {
						$image = $this->model_tool_image->resize($manufacturer_info['image'], $setting['thumb_width'], $setting['thumb_height']);
						if(!$image){
							$image = $this->model_tool_image->resize('placeholder.png', $setting['thumb_width'], $setting['thumb_height']);	
						}
						$data['manufacturers'][] = array(
							'manufacturer_id' => $manufacturer_info['manufacturer_id'],
							'thumb'            => $image,
							'name' => $manufacturer_info['name'],
							'href'             => $this->url->link('product/manufacturer/info', '&manufacturer_id=' . $manufacturer_info['manufacturer_id'], true)
						);
					}
				}
			}
		}

		return $this->load->view('extension/module/brand_manufacturer', $data);

	}
}