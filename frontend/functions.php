<?php

function view($template, $vars = []){
	if(!file_exists($template = 'views/' . $template . '.php')){
		return false;
	}
	
	extract($vars);
	
	ob_start();
	
	include $template;
	
	return ob_get_clean();
}

function url(){
	$scriptRoot = explode('/index.php',$_SERVER['SCRIPT_NAME']);
	$scriptRoot = array_shift($scriptRoot);
	
	$url =
		'http' . (!empty($_SERVER['HTTPS']) ? 's' : '') . 
		'://' . $_SERVER['SERVER_NAME'] . $scriptRoot
	;
	
	return $url;
}

?>