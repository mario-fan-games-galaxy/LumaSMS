<?php

function Fatality(){
	return '<h1>FATAL ERROR</h1>';
}





foreach([
	'functions',
	'controller',
	'routes'
] as $script){
	(include_once 'core/' . $script . '.php') or die(Fatality());
}





foreach([
	'controllers'
] as $directory){
	$_directory=scandir($directory);
	
	foreach($_directory as $file){
		$file=$directory . '/' . $file;
		$fileExtension=explode('.',$file);
		$fileExtension=array_pop($fileExtension);
		
		if(is_dir($file) || $fileExtension != 'php'){
			continue;
		}
		
		require_once $file;
	}
}





$controllerUse=false;
$route=explode('/',$_GET['uri']);

do {
	$_route=implode('/',$route);
	
	if(!empty($routes[$_route])){
		$controllerUse=$routes[$_route];
	}
	
	array_pop($route);
}
while(count($route) && empty($controllerUse));





$controller=explode('@',$controllerUse);
$method=array_pop($controller);
$controller=array_shift($controller);
$yield='';

if(!class_exists($controller) || !method_exists($controller, $method)){
	echo debug($controller,$method);
	die('fuck');
}

ob_start();

$controller::$method();

$yield=ob_get_clean();





require_once 'template.php';

?>