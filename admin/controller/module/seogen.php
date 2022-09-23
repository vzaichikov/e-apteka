<?php
class ControllerModuleSeogen extends Controller {
	private $error = array();

	public function index() {
		$data =array();
		$data += $this->load->language('module/seogen');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		$this->load->model('setting/setting');
		
		$data['token'] = $this->session->data['token'];

		if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			if (!isset($this->request->post['seogen']['seogen_overwrite'])){
				$this->request->post['seogen']['seogen_overwrite'] = 0;
			}
			$this->model_setting_setting->editSetting('seogen', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

            if (version_compare(VERSION, "2.3", ">=")) {
                $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
            } else {
                $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
            }

		}

		if(isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}


		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

        if (version_compare(VERSION, "2.3", ">=")) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_extension'),
                'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
            );

        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_module'),
                'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
            );
        }

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/seogen', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('module/seogen', 'token=' . $this->session->data['token'], 'SSL');
		$data['action_profile_add'] = str_replace("&amp;", "&", $this->url->link('module/seogen/profile', 'action=add&token=' . $this->session->data['token'], 'SSL'));
		$data['action_profile_get'] = str_replace("&amp;", "&", $this->url->link('module/seogen/profile', 'action=get&token=' . $this->session->data['token'], 'SSL'));
		$data['action_profile_del'] = str_replace("&amp;", "&", $this->url->link('module/seogen/profile', 'action=del&token=' . $this->session->data['token'], 'SSL'));
		$data['generate'] = $this->url->link('module/seogen/generate', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');


		$this->load->model('catalog/category');
		// function from 1.5.4.1
		$categories = $this->model_catalog_category_getAllCategories();
		$data['categories'] = $this->getAllCategories($categories);

		$this->load->model('catalog/manufacturer');
		$data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers(array('start' => 0, 'limit' => 1000));

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		if(isset($this->request->post['seogen'])) {
			$data['seogen'] = $this->request->post['seogen'];
		} elseif($this->config->get('seogen')) {
			$data['seogen'] = $this->config->get('seogen');
		}

		if (!isset($data['seogen']['only_categories'])){
			$data['seogen']['only_categories'] = array();
		}

		if (!isset($data['seogen']['only_manufacturers'])){
			$data['seogen']['only_manufacturers'] = array();
		}

		if (!isset($data['seogen']['language_id'])){
			$data['seogen']['language_id'] = $this->config->get('config_language_id');
		}
		if (!isset($data['seogen']['seogen_tab'])){
			$data['seogen']['seogen_tab'] = '#tab-categories';
		}

		$default_tags = $this->getDefaultTags();
		foreach($default_tags['seogen'] as $k => $v) {
			if(!isset($data['seogen'][$k])) {
				$data['seogen'][$k] = $v;
			}
		}

		$data['seogen_status'] = $this->config->get('seogen_status');
		if(isset($this->request->post['seogen_status'])) {
			$data['seogen_status'] = $this->request->post['seogen_status'];
		}

		$this->load->model('module/seogen');
		$data['profiles'] = $this->model_module_seogen->getProfiles();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/seogen.tpl', $data));

	}

	private function getDefaultTags() {
		$seogen = array('seogen_status' => 1,
				'seogen' => array(
						'seogen_overwrite' => 1,
						'categories_template' => $this->language->get('text_categories_tags'),
						'categories_description_template' => $this->language->get('text_categories_description_tags'),
						'categories_meta_description_limit' => 160,
						'products_template' => $this->language->get('text_products_tags'),
						'products_model_template' => $this->language->get('text_products_model_tags'),
						'products_description_template' => $this->language->get('text_products_description_tags'),
						'products_meta_description_limit' => 160,
						'products_img_alt_template' => $this->language->get('text_products_img_alt'),
						'products_img_title_template' => $this->language->get('text_products_img_title'),
						'manufacturers_template' => $this->language->get('text_manufacturers_tags'),
						'manufacturers_description_template' => $this->language->get('text_manufacturers_description_tags'),
						'informations_template' => $this->language->get('text_informations_tags'),
				));
		foreach($this->getTables() as $table => $val) {
			foreach($this->getFields() as $field_name => $tmpl) {
				$seogen['seogen'][$val . '_' . $tmpl . '_template'] = $this->language->get('text_' . $val . '_' . $tmpl . '_tags');
			}
		}
		$seogen['seogen']['products_tag_template'] = $this->language->get('text_products_tag_tags');
		return $seogen;
	}

	public function install() {
		$this->load->language('module/seogen');
		$this->load->model('setting/setting');

		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "manufacturer_description'");
		if(!$query->num_rows){
			$this->db->query("CREATE TABLE `" . DB_PREFIX . "manufacturer_description` (
			 `manufacturer_id` int(11) NOT NULL DEFAULT '0',
			 `language_id` int(11) NOT NULL DEFAULT '0',
			 `description` text NOT NULL,
			 `meta_description` varchar(255) NOT NULL,
			 `meta_keyword` varchar(255) NOT NULL,
			 `meta_title` varchar(255) NOT NULL,
			 `meta_h1` varchar(255) NOT NULL,
			 PRIMARY KEY (`manufacturer_id`,`language_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		}

		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "seogen_profile'");
		if(!$query->num_rows) {
			$this->db->query("CREATE TABLE `" . DB_PREFIX . "seogen_profile` (" .
				" `profile_id` int(11) NOT NULL AUTO_INCREMENT," .
				" `name` varchar(255) NOT NULL," .
				" `data` text NOT NULL," .
				" PRIMARY KEY (`profile_id`)" .
				" ) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		}

		foreach($this->getTables() as $table => $val) {
			$query = $this->db->query("DESC `" . DB_PREFIX . $table . "`");
			$fields = array();
			foreach($query->rows as $row) {
				$fields[] = $row['Field'];
			}
			foreach($this->getFields() as $field_name => $tmpl) {
				if(!in_array($field_name, $fields)) {
					$this->db->query("ALTER TABLE `" . DB_PREFIX . $table . "` ADD `" . $field_name . "` varchar(255) NOT NULL");
				}
			}
		}

		$query = $this->db->query("DESC `" . DB_PREFIX . "product_to_category`");
		$fields = array();
		foreach($query->rows as $row) {
			$fields[] = $row['Field'];
		}
		if(!in_array("main_category", $fields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_to_category` ADD `main_category` tinyint(1) NOT NULL DEFAULT '0'");
		}

		$seogen = $this->getDefaultTags();
		$this->model_setting_setting->editSetting('seogen', $seogen);

		// register the event triggers
		if (version_compare(VERSION, '2.0.1', '>=')) {
			$this->load->model('extension/event');
			$this->model_extension_event->addEvent('seogen', 'post.admin.product.edit', 'module/seogen/eventGenProduct');
			$this->model_extension_event->addEvent('seogen', 'post.admin.product.add', 'module/seogen/eventGenProduct');

			$this->model_extension_event->addEvent('seogen', 'post.admin.category.edit', 'module/seogen/eventGenCategory');
			$this->model_extension_event->addEvent('seogen', 'post.admin.category.add', 'module/seogen/eventGenCategory');

			$this->model_extension_event->addEvent('seogen', 'post.admin.manufacturer.edit', 'module/seogen/eventGenManufacturer');
			$this->model_extension_event->addEvent('seogen', 'post.admin.manufacturer.add', 'module/seogen/eventGenManufacturer');

			$this->model_extension_event->addEvent('seogen', 'post.admin.information.edit', 'module/seogen/eventGenInformation');
			$this->model_extension_event->addEvent('seogen', 'post.admin.information.add', 'module/seogen/eventGenInformation');
		} else {
			$this->load->model('tool/event');
			$this->model_tool_event->addEvent('seogen', 'post.product.edit', 'module/seogen/eventGenProduct');
			$this->model_tool_event->addEvent('seogen', 'post.product.add', 'module/seogen/eventGenProduct');

			$this->model_tool_event->addEvent('seogen', 'post.category.edit', 'module/seogen/eventGenCategory');
			$this->model_tool_event->addEvent('seogen', 'post.category.add', 'module/seogen/eventGenCategory');

			$this->model_tool_event->addEvent('seogen', 'post.manufacturer.edit', 'module/seogen/eventGenManufacturer');
			$this->model_tool_event->addEvent('seogen', 'post.manufacturer.add', 'module/seogen/eventGenManufacturer');

			$this->model_tool_event->addEvent('seogen', 'post.information.edit', 'module/seogen/eventGenInformation');
			$this->model_tool_event->addEvent('seogen', 'post.information.add', 'module/seogen/eventGenInformation');
		}

	}
	public function uninstall() {
		// delete the event triggers
		if (version_compare(VERSION, '2.0.1', '>=')) {
			$this->load->model('extension/event');

			$this->model_extension_event->deleteEvent('seogen');
		} else {
			$this->load->model('tool/event');

			$this->model_tool_event->deleteEvent('seogen');
		}
	}

	public function eventGenProductAdd_23($route, $arr, $product_id) {
        $this->eventGenProduct($product_id);
    }
    public function eventGenCategoryAdd_23($route, $arr, $category_id) {
        $this->eventGenCategory($category_id);
    }
    public function eventGenManufacturerAdd_23($route, $arr, $manufacturer_id) {
        $this->eventGenManufacturer($manufacturer_id);
    }
    public function eventGenInformationAdd_23($route, $arr, $information_id) {
        $this->eventGenInformation($information_id);
    }

    public function eventGenProductEdit_23($route, $arr) {
        $this->eventGenProduct($arr[0]);
    }
    public function eventGenCategoryEdit_23($route, $arr) {
        $this->eventGenCategory($arr[0]);
    }
    public function eventGenManufacturerEdit_23($route, $arr) {
        $this->eventGenManufacturer($arr[0]);
    }
    public function eventGenInformationEdit_23($route, $arr) {
        $this->eventGenInformation($arr[0]);
    }

    public function eventSetPermissions_23($route, $arr){
        if($this->validate()) {
            $this->load->model('user/user_group');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/module/seogen');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/module/seogen');
        }

    }

	public function eventGenProduct($product_id) {
		if ($this->config->get('seogen_status')) {
			$this->load->model('module/seogen');
			$this->model_module_seogen->urlifyProduct($product_id);
		}
	}

	public function eventGenCategory($category_id) {
		if ($this->config->get('seogen_status')) {
			$this->load->model('module/seogen');
			$this->model_module_seogen->urlifyCategory($category_id);
		}
	}

	public function eventGenManufacturer($manufacturer_id) {
		if ($this->config->get('seogen_status')) {
			$this->load->model('module/seogen');
			$this->model_module_seogen->urlifyManufacturer($manufacturer_id);
		}
	}

	public function eventGenInformation($information_id) {
		if ($this->config->get('seogen_status')) {
			$this->load->model('module/seogen');
			$this->model_module_seogen->urlifyInformation($information_id);
		}
	}

	public function generate() {
		if($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->post['name']) && $this->validate()) {
			$time_start = microtime(true);
			$base_memory_usage = memory_get_usage();

			$this->load->language('module/seogen');
			$this->load->model('module/seogen');
			$name = $this->request->post['name'];
		    if($name == 'categories') {
				$this->model_module_seogen->generateCategories($this->request->post['seogen']);
			} elseif($name == 'products') {
				$this->model_module_seogen->generateProducts($this->request->post['seogen']);
			} elseif($name == 'manufacturers') {
				$this->model_module_seogen->generateManufacturers($this->request->post['seogen']);
			} elseif($name == 'informations') {
				$this->model_module_seogen->generateInformations($this->request->post['seogen']);
			}

			$this->response->setOutput($this->language->get('text_success_generation') . "</br><b>Total Execution Time:</b> ".(microtime(true) - $time_start).
			"<br/>" . "<b>Memory usage:</b> ". number_format((memory_get_usage() - $base_memory_usage) /1024/1024, 2, '.', '') . "Mb");
			$this->saveSettings($this->request->post['seogen']);
			$this->cache->delete("seo_pro");
		}
	}

	private function getAllCategories($categories, $parent_id = 0, $parent_name = '') {
		$output = array();

		if (array_key_exists($parent_id, $categories)) {
			if ($parent_name != '') {
				$parent_name .= $this->language->get('text_separator');
			}

			foreach ($categories[$parent_id] as $category) {
				$output[$category['category_id']] = array(
					'category_id' => $category['category_id'],
					'name'        => $parent_name . $category['name']
				);

				$output += $this->getAllCategories($categories, $category['category_id'], $parent_name . $category['name']);
			}
		}

		return $output;
	}

	public function model_catalog_category_getAllCategories() {
		$category_data = $this->cache->get('category.all.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'));

		if (!$category_data || !is_array($category_data)) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  ORDER BY c.parent_id, c.sort_order, cd.name");

			$category_data = array();
			foreach ($query->rows as $row) {
				$category_data[$row['parent_id']][$row['category_id']] = $row;
			}

			$this->cache->set('category.all.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'), $category_data);
		}

		return $category_data;
	}

	private function saveSettings($data) {
		$seogen_status = $this->config->get('seogen_status');
		$seogen = $this->config->get('seogen');
		foreach($data as $key => $val) {
			if(in_array($key, array_keys($seogen))) {
				$seogen[$key] = $val;
			}
		}
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('seogen', array('seogen' => $seogen, 'seogen_status' => $seogen_status));
	}

	public function profile(){
		if($this->validate() && $this->request->server['REQUEST_METHOD'] == 'POST' && (isset($this->request->post['data']) || isset($this->request->post['profile_id']))) {
			$this->load->model('module/seogen');

			$action = $this->request->get['action'];
			if($action == 'add') {
				$data = $this->model_module_seogen->parse_str(base64_decode($this->request->post['data']));
				$seogen_profile_name = $data['seogen_profile_name'];
				$profile_id = $this->model_module_seogen->addProfile($seogen_profile_name, serialize($data['seogen']));

				$json = array('result' => 'success', 'profile_id' => $profile_id);
				$this->response->setOutput(json_encode($json));
			} elseif($action == 'get' && isset($this->request->post['profile_id'])) {
				$profile_id = $this->request->post['profile_id'];
				$profile = $this->model_module_seogen->getProfile($profile_id);

				$json = array('result' => 'success', 'profile' => $profile);
				$this->response->setOutput(json_encode($json));
			} elseif($action == 'del' && isset($this->request->post['profile_id'])) {
				$profile_id = $this->request->post['profile_id'];
				$this->model_module_seogen->deleteProfile($profile_id);

				$json = array('result' => 'success');
				$this->response->setOutput(json_encode($json));
			}
		}
	}

	private function validate() {
		if(!$this->user->hasPermission('modify', 'module/seogen')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	private function getTables() {
		return array(
			"category_description" => "categories",
			"product_description" => "products",
			"manufacturer_description" => "manufacturers",
			"information_description" => "informations",
		);
	}

	private function getFields() {
		return array(
			"meta_title" => "meta_title",
			"meta_h1" => "meta_h1",
			"meta_description" => "meta_description",
			"meta_keyword" => "meta_keyword");
	}
}

?>