<?php
// Version
define('VERSION', '2.3.0.2');

// Configuration
if (is_file(dirname(__FILE__) . '/../admin/config.php')) {
	require_once(dirname(__FILE__) . '/../admin/config.php');
}

error_reporting (E_ALL);	
	ini_set('display_errors', 1);

// Startup
require_once(DIR_SYSTEM . 'startup.php');

start('api_getProductImage');