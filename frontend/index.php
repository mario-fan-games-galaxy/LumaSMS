<?php

function url(){
	$scriptRoot = explode('/index.php',$_SERVER['SCRIPT_NAME']);
	$scriptRoot = array_shift($scriptRoot);
	
	$url =
		'http' . (!empty($_SERVER['HTTPS']) ? 's' : '') . 
		'://' . $_SERVER['SERVER_NAME'] . $scriptRoot
	;
	
	return $url;
}

ob_start();
include 'pages/updates/archive.php';
$yield=ob_get_clean();

require_once 'template.php';

?>