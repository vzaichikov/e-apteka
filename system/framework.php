<?php

	function loadJsonConfig($config){
		if (defined('DIR_SYSTEM')){
			$json = file_get_contents(DIR_SYSTEM . 'config/' . $config . '.json');
			} else {
			$json = file_get_contents(dirname(__FILE__) . '/config/' . $config . '.json');
		}
		
		return json_decode($json, true);
	}


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
	
	// Database
	
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
			$registry->set('dbCalls', new DB('mysqli_remote', AMI_DB_HOST, AMI_DB_USER, AMI_DB_PASSWORD, AMI_DB_NAME, 3306));
			} catch (\Exception $e){
			$registry->set('dbCalls', false);
		}
		
	}

	$registry->set('crawlerDetect', new \Jaybizzle\CrawlerDetect\CrawlerDetect);
	
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
