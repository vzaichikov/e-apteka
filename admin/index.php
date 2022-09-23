<?php




// Version
define('VERSION', '2.3.0.2');
define('EAPTEKA_VERSION', '0.8b');
ini_set('display_errors', 'On');
error_reporting(E_ALL);

// Configuration
if (is_file('config.php')) {
	require_once('config.php');	
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');



start('admin');