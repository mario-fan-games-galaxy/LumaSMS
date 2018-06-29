<?php

function S(){
	return $GLOBALS['_SETTINGS'];
}

$_SETTINGS=[
	'database'=>[
		'hostname'=>'localhost',
		'username'=>'root',
		'dbname'=>'mfgg',
		'password'=>'',
		'prefix'=>'tsms_',
		'driver'=>'MySQLDatabaseDriver'
	]
];

?>