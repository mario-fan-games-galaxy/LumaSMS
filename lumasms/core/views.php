<?php

function view($file,$vars = []){
	$file='views/' . $file . '.php';
	
	if(!file_exists($file)){
		return false;
	}
	
	extract($vars);
	
	ob_start();
	
	include $file;
	
	return ob_get_clean();
}

?>