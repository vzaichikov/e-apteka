<?php
	// Registry
	$registry = new Registry();
	
	// Config
	$config = new Config();
	$config->load('default');
	$config->load($application_config);
	$registry->set('config', $config);
	
	// Event
	$event = new Event($registry);
	$registry->set('event', $event);
	
	// Event Register
	if ($config->has('action_event')) {
		foreach ($config->get('action_event') as $key => $value) {
			$event->register($key, new Action($value));
		}
	}
	
	// Loader
	$loader = new Loader($registry);
	$registry->set('load', $loader);
	
	// Request
	$registry->set('request', new Request());
	
	// Response
	$response = new Response();
	$response->addHeader('Content-Type: text/html; charset=utf-8');
	$registry->set('response', $response);
	
	// Cache 
	$registry->set('cache', new Cache($config->get('cache_type'), $config->get('cache_expire')));
	
	if ($config->get('db_autostart_slave')) {
		$registry->set('db_slave', new DB($config->get('db_type_slave'), $config->get('db_hostname_slave'), $config->get('db_username_slave'), $config->get('db_password_slave'), $config->get('db_database_slave'), $config->get('db_port_slave'), $registry));
		} else {
		$registry->set('db_slave', false);
	}
	
	
	if ($config->get('db_autostart')) {
		$registry->set('db', new DB($config->get('db_type'), $config->get('db_hostname'), $config->get('db_username'), $config->get('db_password'), $config->get('db_database'), $config->get('db_port'), $registry));
	}
	
	if (defined('IS_ADMIN')){
		try{
			$registry->set('dbCalls', false);
			// if (fsockopen(AMI_DB_HOST, 3306, $fsock_errcode, $fsock_errmessage, 1)){
			// 	$registry->set('dbCalls', new DB('mysqli_remote', AMI_DB_HOST, AMI_DB_USER, AMI_DB_PASSWORD, AMI_DB_NAME, 3306));
			// }		
			} catch (\Exception $e){
			$registry->set('dbCalls', false);
		}		
	}

	$registry->set('crawlerDetect', new \Jaybizzle\CrawlerDetect\CrawlerDetect);
	$registry->set('mobileDetect', new \Detection\MobileDetect);
	
	// Session
	$session = new Session('native', $registry);
	
	if ($config->get('session_autostart')) {
		$session->start();
	}
	
	$registry->set('session', $session);
	
	// Url
	if ($config->get('url_autostart')) {
		$registry->set('url', new Url($config->get('site_base'), $config->get('site_ssl')));
	}
	
	// Language
	$language = new Language($config->get('language_default'));
	$language->load($config->get('language_default'));
	$registry->set('language', $language);

	//Branding
	$registry->set('branding', loadJsonConfig('brands'));

	//Languages
	$query = $registry->get('db')->query("SELECT * FROM `oc_language` WHERE status = '1'"); 
	foreach ($query->rows as $result) {		
		$languages[$result['code']] = $result;
		$languages_id_mapping[$result['language_id']] = $result;
		$languages_id_code_mapping[$result['language_id']] = $result['code'];
	}

	$registry->set('languages', 					$languages);
	$registry->set('languages_id_mapping', 			$languages_id_mapping);
	$registry->set('languages_id_code_mapping', 	$languages_id_code_mapping);

	$short_url_mapping = loadJsonConfig('shorturlmap');
	$short_uri_queries = $short_uri_keywords = [];

	if (is_array($short_url_mapping)){
		foreach ($short_url_mapping as $query => $keyword){
			$short_uri_queries[$query] = $keyword;
			$short_uri_keywords[$keyword] = $query;
		}
	}
       
	$registry->set('short_uri_queries', $short_uri_queries);
	$registry->set('short_uri_keywords', $short_uri_keywords);	
	
	// Document
	$registry->set('document', new Document());
		
	// Config Autoload
	if ($config->has('config_autoload')) {
		foreach ($config->get('config_autoload') as $value) {
			$loader->config($value);
		}
	}
	
	// Language Autoload
	if ($config->has('language_autoload')) {
		foreach ($config->get('language_autoload') as $value) {
			$loader->language($value);
		}
	}
	
	// Library Autoload
	if ($config->has('library_autoload')) {
		foreach ($config->get('library_autoload') as $value) {
			$loader->library($value);
		}
	}
	
	// Model Autoload
	if ($config->has('model_autoload')) {
		foreach ($config->get('model_autoload') as $value) {
			$loader->model($value);
		}
	}
	
	// Front Controller
	$controller = new Front($registry);
	
	// Pre Actions
	if ($config->has('action_pre_action')) {
		foreach ($config->get('action_pre_action') as $value) {
			$controller->addPreAction(new Action($value));
		}
	}
	
	// Dispatch
	$controller->dispatch(new Action($config->get('action_router')), new Action($config->get('action_error')));
	
	// Output
	$response->setCompression($config->get('config_compression'));
	$response->output();
