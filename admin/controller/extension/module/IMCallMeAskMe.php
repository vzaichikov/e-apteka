<?php
class ControllerExtensionModuleIMCallMeAskMe extends Controller {
	private $error = array(); 

	/////////////////////////////////////////
	// Основные экшены
	/////////////////////////////////////////
	
	// Стартовая страница контроллера
	public function index() {   
		$this->load->language('extension/module/IMCallMeAskMe');

		$this->document->setTitle($this->language->get('curr_heading_title'));
		
		$this->document->addStyle('view/javascript/summernote/summernote.css');
		$this->document->addScript('view/javascript/summernote/summernote.min.js');
		$this->document->addScript('view/javascript/summernote/opencart.js');
		
		$this->load->model('setting/setting');
		$this->load->model('extension/module/IMCallMeAskMe');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('IMCallMeAskMe', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));			
		}
		
		// Данные
		$data = array();
		
		// Получаем стандартные настройки для вьюх
		$this->getDefaultFormSettings($data);

		////////////////////////////////////
		// Строим хлебные крошки
		////////////////////////////////////
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/IMCallMeAskMe', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		////////////////////////////////////
		// Формируем ссылки
		////////////////////////////////////

		$data['replace'] = $this->url->link('extension/module/IMCallMeAskMe/replace', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);
		$data['getStat'] = $this->url->link('extension/module/IMCallMeAskMe/getStat', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['module_links'] = array(
			'setStatus' => $this->url->link('extension/module/IMCallMeAskMe/setStatus', 'token=' . $this->session->data['token'], 'SSL'),
			'saveStat' => $this->url->link('extension/module/IMCallMeAskMe/saveStat', 'token=' . $this->session->data['token'], 'SSL'),
			'deleteStat' => $this->url->link('extension/module/IMCallMeAskMe/deleteStat', 'token=' . $this->session->data['token'], 'SSL')
		); 
		
		$data['modules'] = array();

		// 2.2 :(
		$data['is_version_2_2'] = true;//(version_compare('2.2', VERSION) <= 0);

		////////////////////////////////////
		// Стандартная подгрузка данных и вывод на шаблон
		////////////////////////////////////
		if (isset($this->request->post['IMCallMeAskMe_module'])) {
			$data['modules'] = $this->request->post['IMCallMeAskMe_module'];
		} elseif ($this->config->get('IMCallMeAskMe_module')) { 
			$data['modules'] = $this->config->get('IMCallMeAskMe_module');
		}	
		
		$this->load->model('design/layout');
		
		$data['layouts'] = $this->model_design_layout->getLayouts();

		$template = 'extension/module/IMCallMeAskMe.tpl';
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		// Подгружаем вьюху со статистикой
		$data['IMCallMeAskMe_statView'] = $this->load->controller('extension/module/IMCallMeAskMe/statView');
		// Подгружаем вьюху с настройками
		$data['IMCallMeAskMe_settingsView'] = $this->load->controller('extension/module/IMCallMeAskMe/settingsView');

		setcookie('token', $this->session->data['token']);
		
		$this->getForm($data);

		$this->response->setOutput($this->load->view($template, $data));
	}

	// Вьюха со статистикой
	public function statView($settings_data = array()) {
		$this->load->language('extension/module/IMCallMeAskMe');

		$this->document->setTitle($this->language->get('curr_heading_title'));
		
		$this->load->model('setting/setting');
		$this->load->model('extension/module/IMCallMeAskMe');

		
		// Данные
		$data = array();
		
		// Получаем стандартные настройки для вьюх
		$this->getDefaultFormSettings($data);
		
		////////////////////////////////////
		// Формируем ссылки
		////////////////////////////////////

		$data['replace'] = $this->url->link('extension/module/IMCallMeAskMe/replace', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);
		$data['getStat'] = $this->url->link('extension/module/IMCallMeAskMe/getStat', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['module_links'] = array(
			'setStatus' => $this->url->link('extension/module/IMCallMeAskMe/setStatus', 'token=' . $this->session->data['token'], 'SSL'),
			'saveStat' => $this->url->link('extension/module/IMCallMeAskMe/saveStat', 'token=' . $this->session->data['token'], 'SSL'),
			'deleteStat' => $this->url->link('extension/module/IMCallMeAskMe/deleteStat', 'token=' . $this->session->data['token'], 'SSL')
		); 
		
		$data['modules'] = array();

		// 2.2 :(
		$data['is_version_2_2'] = true;//(version_compare('2.2', VERSION) <= 0);

		////////////////////////////////////
		// Стандартная подгрузка данных и вывод на шаблон
		////////////////////////////////////
		if (isset($this->request->post['IMCallMeAskMe_module'])) {
			$data['modules'] = $this->request->post['IMCallMeAskMe_module'];
		} elseif ($this->config->get('IMCallMeAskMe_module')) { 
			$data['modules'] = $this->config->get('IMCallMeAskMe_module');
		}	
		
		$template = 'extension/module/IMCallMeAskMe_stat.tpl';
		
		$this->getForm($data);
		//$this->response->setOutput($this->load->view($template, $data));
		
		////////////////////////////////////
		// Вывол в зависимости от параметров
		////////////////////////////////////

		// Тип отображения фильтра
		if (($this->request->server['REQUEST_METHOD'] == 'POST'))
			$stat_filter_type = $this->getPostValue('stat_filter_type', 'normal');
		else
			$stat_filter_type = 'normal';
		$data['stat_filter_type'] = $stat_filter_type;

		$curr_vals = $this->model_setting_setting->getSetting('IMCallMeAskMeData');
		
		if ($data['stat_filter_type'] == 'min')
		{
			if (isset($curr_vals['IMCallMeAskMeData_main_panel']))	
			{
				if (''.$curr_vals['IMCallMeAskMeData_main_panel'] == '1')
				{
					$this->response->setOutput($this->load->view($template, $data));	
				}
				else
				{
					$this->response->setOutput('');
				}
			}
			else
			{
				$this->response->setOutput('');
			}
		}
		else
		{
			return $this->load->view($template, $data);	
		}		
	}

	// Вьюха с настройками
	public function settingsView($settings_data = array()) {
		$this->load->language('extension/module/IMCallMeAskMe');

		$this->document->setTitle($this->language->get('curr_heading_title'));
		
		$this->load->model('setting/setting');
		$this->load->model('extension/module/IMCallMeAskMe');
		
		// Данные
		$data = array();
		
		// Получаем стандартные настройки для вьюх
		$this->getDefaultFormSettings($data);
		
		////////////////////////////////////
		// Формируем ссылки
		////////////////////////////////////
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);
		$data['setModuleSettings'] = $this->url->link('extension/module/IMCallMeAskMe/setModuleSettings', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['modules'] = array();

		// 2.2 :(
		$data['is_version_2_2'] = true;//(version_compare('2.2', VERSION) <= 0);

		////////////////////////////////////
		// Данные модуля
		////////////////////////////////////
		$curr_vals = array();

		$curr_vals = $this->model_setting_setting->getSetting('IMCallMeAskMeData');

		$data['curr_vals'] = $curr_vals;

		////////////////////////////////////
		// Стандартная подгрузка данных и вывод на шаблон
		////////////////////////////////////
		if (isset($this->request->post['IMCallMeAskMe_module'])) {
			$data['modules'] = $this->request->post['IMCallMeAskMe_module'];
		} elseif ($this->config->get('IMCallMeAskMe_module')) { 
			$data['modules'] = $this->config->get('IMCallMeAskMe_module');
		}	
		
		$template = 'extension/module/IMCallMeAskMe_settings.tpl';
		$this->getForm($data);
		//$this->response->setOutput($this->load->view($template, $data));
		return $this->load->view($template, $data);
	}

	// Стандартные настройки
	private function getDefaultFormSettings(&$data) {
		$this->load->model('localisation/language');
		////////////////////////////////////
		// Стандартные данные
		////////////////////////////////////
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['h1_text'] = $this->language->get('heading_title_h1');
		$data['h2_text'] = $this->language->get('heading_title_h2');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');
		
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		////////////////////////////////////
		// Добавленные данные
		////////////////////////////////////
		// Перевод
		$data['module_labels'] = $this->language->get('module_labels');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
	}

	// Функция подгрузки списка языков
	private function getForm(&$data) {
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$data['lang_settings'] = $this->model_extension_module_IMCallMeAskMe->getSettings();

		////////////////////////////////////
		// Формируем списки
		////////////////////////////////////
		$data['module_lists'] = array(
			'sort' => $this->model_extension_module_IMCallMeAskMe->getSortList(),
			'status' => $this->model_extension_module_IMCallMeAskMe->getStatusList()
		);
		
		if (true) {
			foreach ($data['languages'] as $key => $language) {
				$data['languages'][$key]['imgsrc'] = 'language/' . $language['code'] . '/' . $language['code'] . '.png';
			}
		}else{
			foreach ($data['languages'] as $key => $language) {
				$data['languages'][$key]['imgsrc'] = 'view/image/flags/' . $language['image'];
			}
		}
		
		$data['token'] = $this->session->data['token'];
	}

	// Установка настроек модуля
	public function setModuleSettings() {
		if($this->validate()) {
			$this->load->model('setting/setting');
			$json = array();
			$curr_vals = $this->model_setting_setting->getSetting('IMCallMeAskMeData');
			$settings = array_merge($curr_vals, $this->request->post['IMCallMeAskMe']);
			$this->model_setting_setting->editSetting('IMCallMeAskMeData', $settings);
			$json['success'] = 1;
			$this->response->setOutput(json_encode($json));
		}
		else {
			$this->load->language('module/IMCallMeAskMe');
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			
			$this->response->setOutput(json_encode($json));
		}
	}

	// Получить настройки окошек
	public function getSettings(){
		$this->load->model('extension/module/IMCallMeAskMe');
		$json = array();
		
		$json['settings'] = $this->model_extension_module_IMCallMeAskMe->getSettings();
		$json['success'] = 1;
		
		$this->response->setOutput(json_encode($json));
	}

	// Сохранение шаблона замены окошек
	public function saveSettings() {
		if($this->validate()) {
			$this->load->model('extension/module/IMCallMeAskMe');
			$json = array();
			$this->model_extension_module_IMCallMeAskMe->saveSettings($this->request->post['IMCallMeAskMe']);
			$json['success'] = 1;
			
			$this->response->setOutput(json_encode($json));
		}
		else {
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			
			$this->response->setOutput(json_encode($json));
		}
	}

	// Получить данные по статистике
	public function getStat()
	{
		$this->load->model('extension/module/IMCallMeAskMe');
		$json = array();
		$json['data'] = $this->model_extension_module_IMCallMeAskMe->getStat($this->request->post['IMCallMeAskMe']);
		
		if (true) {
			$json['path_lang_image'] = 'language/';
		}else{
			$json['path_lang_image'] = 'view/image/flags/';
		}
		
		$json['success'] = 1;
		
		$this->response->setOutput(json_encode($json));
	}

	// Установка состояния
	public function setStatus()
	{
		if($this->validate()) 
		{
			$this->load->model('extension/module/IMCallMeAskMe');
			$this->model_extension_module_IMCallMeAskMe->setStatus($this->request->post['IMCallMeAskMe']);
			$json['success'] = 1;
			$this->response->setOutput(json_encode($json));
		}
		else
		{
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			$this->response->setOutput(json_encode($json));
		}
	}

	// Сохранение статистики
	public function saveStat()
	{
		if($this->validate()) 
		{
			$this->load->model('extension/module/IMCallMeAskMe');
			$this->model_extension_module_IMCallMeAskMe->saveStat($this->request->post['IMCallMeAskMe']);
			$json['success'] = 1;
			$this->response->setOutput(json_encode($json));
		}
		else
		{
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			$this->response->setOutput(json_encode($json));
		}
	}

	// Удаление статистики
	public function deleteStat()
	{
		if($this->validate()) 
		{
			$this->load->model('extension/module/IMCallMeAskMe');
			$this->model_extension_module_IMCallMeAskMe->deleteStat($this->request->post['IMCallMeAskMe']);
			$json['success'] = 1;
			$this->response->setOutput(json_encode($json));
		}
		else
		{
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			$this->response->setOutput(json_encode($json));
		}
	}

	/////////////////////////////////////////
	// Вспомогательные функции
	/////////////////////////////////////////

	private function getPostValue($name, $default = '') {
		$data = $this->request->post['IMCallMeAskMe'];
		
		if (isset($data) && is_array($data))
		{
			if (isset($data[$name]))
				return $data[$name];
		}
		return $default;
	}

	// Добавление кода
	protected function addPHPCode($path, $sign, $searchcode, $addCode)
	{
		$content = file_get_contents($path);
		$content = str_replace(
			$searchcode, 
			$searchcode
			. '/* ' . $sign . ' Start */'
				.$addCode
			. '/* ' . $sign . ' End */', 
			$content
		);

		$fp = fopen($path, 'w+');
		fwrite($fp, $content);
		fclose($fp);
	}
	
	// Удаление кода
	protected function removePHPCode($path, $sign)
	{
		$content = file_get_contents($path);

		preg_match_all('!(\/\*)\s?' . $sign . ' Start.+?' . $sign . ' End\s+?(\*\/)!is', $content, $matches);
		foreach ($matches[0] as $match) {
			$content = str_replace($match, '', $content);
		}

		$fp = fopen($path, 'w+');
		fwrite($fp, $content);
		fclose($fp);
	}

	/////////////////////////////////////////
	// Установка / Деинсталляция
	/////////////////////////////////////////

	// Установка модуля
	public function install() {
        $this->load->model('extension/module/IMCallMeAskMe');
		$this->model_extension_module_IMCallMeAskMe->install();
		
		// Указываем, что модуль установлен
		$this->load->model('setting/setting');
		$curr_vals = $this->model_setting_setting->getSetting('IMCallMeAskMe');
		$settings = array_merge($curr_vals, array('IMCallMeAskMe_status'=>1));
		$this->model_setting_setting->editSetting('IMCallMeAskMe', $settings);

		// Добавляем на дашбоард главной страницы
		// DIR_APPLICATION
		$this->addPHPCode(
			DIR_APPLICATION . 'controller/common/dashboard.php',
			'IMCallMeAskMe',
			'$this->document->setTitle($this->language->get(\'heading_title\'));',
			' $this->document->addScript(\'view/javascript/IMCallMeAskMe/jquery.admin.imcallme.js\'); '
		);

		// Добавляем вызов скрипта
		$this->addPHPCode(
			DIR_CATALOG . 'controller/common/header.php',
			'IMCallMeAskMe',
			'$data[\'title\'] = $this->document->getTitle();',
			' $this->document->addScript(\'catalog/view/javascript/IMCallMeAskMe/jquery.imcallask.js\'); '
			. ' $this->document->addStyle(\'catalog/view/javascript/IMCallMeAskMe/jquery.imcallback.css\'); '
		);

        
	}
	
	// Деинсталляция модуля
    public function uninstall() {
        $this->load->model('extension/module/IMCallMeAskMe');
		$this->model_extension_module_IMCallMeAskMe->uninstall();
		
		// Указываем, что модуль удален
	 	$this->load->model('setting/setting');
		$curr_vals = $this->model_setting_setting->getSetting('IMCallMeAskMe');
		$settings = array_merge($curr_vals, array('IMCallMeAskMe_status'=>0));
		$this->model_setting_setting->editSetting('IMCallMeAskMe', $settings);

		// Удаляем подключение на серверной стороне
		$this->removePHPCode(
			DIR_APPLICATION . 'controller/common/dashboard.php',
			'IMCallMeAskMe'
		);

		// Удаляем подключение на клиентской стороне
		$this->removePHPCode(
			DIR_CATALOG . 'controller/common/header.php',
			'IMCallMeAskMe'
		);
        
    }

	/////////////////////////////////////////
	// Валидация
	/////////////////////////////////////////
	
	// Проверка, что у пользователя есть необходимые права
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/IMCallMeAskMe')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
