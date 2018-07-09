<?php

function Fatality($e){
	$errorlog='logs/fatality_log';
	
	file_put_contents(
		$errorlog,
		file_get_contents($errorlog) . '[ ' . date('m/d/Y g:i:sa',time()) . ' ]' . "\n" . $e . "\n\n"
	);
	
	return '<h1>FATAL ERROR</h1>';
}





foreach([
	'core',
	'dbdrivers',
	'controllers',
	'models'
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





$database=S()['database']['driver'];
$database=new $database();





$route=$_GET['uri'];
if(empty($route)){
	$route='updates/archive';
}
$route=explode('/',$route);

$controllerUse=false;
$finalRoute='';
$params=[];

do {
	$_route=implode('/',$route);
	
	if(!empty($routes[$_route])){
		$controllerUse=$routes[$_route];
		$finalRoute=$_route;
	}else{
		$params[]=array_pop($route);
	}
}
while(count($route) && empty($controllerUse));
$params=array_reverse($params);





$controller=explode('@',$controllerUse);
$method=array_pop($controller);
$controller=array_shift($controller);
$yield='';

if(
	!class_exists($controller)
	||
	!($controller = new $controller())
	||
	!method_exists($controller, $method)
){
	$controller='InformationController';
	$method='error404';
}

ob_start();

$controller->$method();

$yield=ob_get_clean();





require_once 'template.php';

?>