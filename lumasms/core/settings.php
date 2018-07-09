<?php

/**
 * Use this function to access the settings easily
 *
 * @return array The settings array
 */
function S(){
	return $GLOBALS['_SETTINGS'];
}

$_SETTINGS=[
	/**
	 * Any database settings we need
	 */
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