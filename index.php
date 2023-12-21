<?php

define('VERSION', '2.3.0.2');
header('X-ENGINE-ENTRANCE: INDEX');

ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

require_once(dirname(__FILE__) . '/system/library/hobotix/FPCTimer.php');
$timer = $GLOBALS['timer'] = new \hobotix\FPCTimer();

if ((isset($_GET['hello']) && $_GET['hello'] == 'world')){
	define('IS_DEBUG', true);
	define('DEV_ENVIRONMENT', true);
	define('DEBUGSQL', true);

} else {
	define('DEV_ENVIRONMENT', false);
	define('IS_DEBUG', false);

	if (isset($_GET['hello']) && $_GET['hello'] == 'sql'){
		define('DEBUGSQL', true);
	} else {
		define('DEBUGSQL', false);
	}
}

if(defined('IS_DEBUG') && IS_DEBUG) {
	$start_time = $GLOBALS['start'] = microtime();
	$start_mem = memory_get_usage();
}

if (is_file('config.php')) {
	require_once('config.php');
}

if (in_array($_SERVER['REMOTE_ADDR'], INNER_IP_POOL)){
	define ('INNER_IP', true);
} else {
	define ('INNER_IP', false);
}

require_once(DIR_SYSTEM . 'startup.php');

start('catalog');