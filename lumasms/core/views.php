<?php

function view($_____file,$vars = []){
	$_____file='views/' . $_____file . '.php';
	
	if(!file_exists($_____file)){
		return false;
	}
	
	extract($vars);
	
	ob_start();
	
	include $_____file;
	
	return ob_get_clean();
}

?>