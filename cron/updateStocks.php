<?php
// Version
define('VERSION', '2.3.0.2');

ini_set('memory_limit', '2G');

// Configuration
if (is_file(dirname(__FILE__) . '/../admin/config.php')) {
	require_once(dirname(__FILE__) . '/../admin/config.php');
}


// Startup
require_once(DIR_SYSTEM . 'startup.php');

start('cron_updateStocks');