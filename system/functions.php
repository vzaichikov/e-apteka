<?php

function loadJsonConfig($config){
	if (defined('DIR_SYSTEM') && @file_exists(DIR_SYSTEM . 'config/' . $config . '.json')){

		$json = file_get_contents(DIR_SYSTEM . 'config/' . $config . '.json');
		
	} elseif (@file_exists(dirname(__FILE__) . '/config/' . $config . '.json')) {

		$json = file_get_contents(dirname(__FILE__) . '/config/' . $config . '.json'); 

	} elseif (@file_exists(dirname(__FILE__) . '/system/config/' . $config . '.json')){

		$json = file_get_contents(dirname(__FILE__) . '/system/config/' . $config . '.json'); 

	}
	
	if ($json){
		return json_decode($json, true);
	} else {
		return [];
	}
}


if (!function_exists('is_cli')){
	function is_cli(){
		return (php_sapi_name() == 'cli');		
	}
}

if (!function_exists('echoLine')){
	function echoLine($line, $type = 'l'){
		if (php_sapi_name() === 'cli'){
			switch ($type) {
				case 'e':
				echo "\033[31m$line \033[0m" . PHP_EOL;
				break;
				case 's':
				echo "\033[32m$line \033[0m" . PHP_EOL;
				break;
				case 'w':
				echo "\033[33m$line \033[0m" . PHP_EOL;
				break;  
				case 'i':
				echo "\033[36m$line \033[0m" . PHP_EOL;
				break;    
				case 'l':
				echo $line . PHP_EOL;
				break;  
				default:
				echo $line . PHP_EOL;
				break;
			}
		} else {
			ob_end_flush();
			switch ($type) {
				case 'e':
				echo "<span class='text-error'>$line</span><br />";
				break;
				case 's':
				echo "<span class='text-success'>$line</span><br />";
				break;
				case 'w':
				echo "<span class='text-warning'>$line</span><br />";
				break;  
				case 'i':
				echo "<span class='text-info'>$line</span><br />";
				break;    
				case 'l':
				echo $line . '<br />';
				break;  
				default:
				echo $line . '<br />';
				break;
			}
			flush();
		}
	}
}

function thisIsAjax($request = false){
	if (!$request){
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			return true;
		}	
	}

	if (isset($request->server['HTTP_X_REQUESTED_WITH']) && strtolower($request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		return true;
	}

	return false;
}


function isFriendlyURL($url){
	if (stripos($url, 'index.php?route=') !== false){
		return false;
	}

	return true;
}

function thisIsUnroutedURI($request = false){	
	if (!$request){
		if (isset($_SERVER['REQUEST_URI'])){
			if (stripos($_SERVER['REQUEST_URI'], 'index.php?route=') !== false){
				return true;
			}
		}	
	}

	if (isset($request->server['REQUEST_URI'])){
		if (stripos($request->server['REQUEST_URI'], 'index.php?route=') !== false){
			return true;
		}
	}

	return false;
}