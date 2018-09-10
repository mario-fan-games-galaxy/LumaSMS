<?php

function setting($key,$value=null){
	global $_SETTINGS;
	
	if(empty($key) || empty($_SETTINGS[$key])){
		return false;
	}
	
	if($value == null){
		return $_SETTINGS[$key];
	}
	
	$_SETTINGS[$key]=$value;
}

$_SETTINGS=[
	// Content settings
	
	'thumbnail_directory'=>'../tcsms/thumbnail',
	'file_directory'=>'../tcsms/file',
	
	'session_hotlink_protection'=>true,
	
	
	
	// Database settings
	
	'db_host'=>'localhost',
	'db_name'=>'mfgg',
	'db_user'=>'root',
	'db_pass'=>'',
	'db_prefix'=>'tsms_',
	
	
	
	// Date settings
	
	'date_format'=>'m/d/Y g:ia',
	'date_setting'=>'since',
	
	
	
	// Login settings
	
	'login_attempts_max'=>10,
	'login_attempts_wait'=>60 * 5,
	
	
	
	// Registration Form Settings
	
	'username_min_length'=>3,
	'username_max_length'=>32,
	
	'password_min_length'=>3,
	'password_max_length'=>72,
	
	
	
	// Resource settings
	
	'limit_per_page'=>20,
	
	
	
	// Site settings
	
	'site_name'=>'Mario Fan Games Galaxy',
	'site_abbr'=>'MFGG',
];

?>