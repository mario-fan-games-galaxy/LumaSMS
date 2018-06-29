<?php

function debug(){
	ob_start();
	
	foreach(func_get_args() as $arg){
		echo '<pre>' . print_r($arg,true) . '</pre>';
	}
	
	return ob_get_clean();
}

function url(){
	$url='http';
	
	if(!empty($_SERVER['HTTPS'])){
		$url .= 's';
	}
	
	$url .= '://';
	
	$url .= $_SERVER['SERVER_NAME'];
	
	$self=explode('/index.php',$_SERVER['SCRIPT_NAME']);
	
	$url .= array_shift($self);
	
	return $url;
}

function writeNTimes($str, $n, $divider = ', '){
	$ret=[];
	
	for($i=0;$i<$n;$i++){
		$ret[]=$n;
	}
	
	return implode($divider,$ret);
}

?>