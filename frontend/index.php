<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'functions.php';
require_once 'routes.php';

if(empty($_GET['uri'])){
	$uri='index';
}else{
	$uri = $_GET['uri'];
}

$file = false;

if(!empty($routes[$uri])){
	$file = 'pages/' . $routes[$uri] . '.php';
	
	if(!file_exists($file)){
		$file = false;
	}
}

if(!$file){
	$file='pages/404.php';
}

ob_start();
include $file;
$yield=ob_get_clean();

require_once 'template.php';

?>