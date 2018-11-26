<?php

require_once 'functions.php';
require_once 'routes.php';

if(empty($uri = $_GET['uri'])){
	$uri='index';
}

if(
	@empty($file = $routes[$uri])
	||
	!file_exists($file = 'pages/' . $file . '.php')
){
	$file='pages/404.php';
}

ob_start();
include $file;
$yield=ob_get_clean();

require_once 'template.php';

?>