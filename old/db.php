<?php

// Database shortcut function

function DB()
{
    global $_DB;
    
    return $_DB;
}










// Connect to the database

try {
    $_DB = new PDO(
        'mysql:host=' . setting('db_host') . ';dbname=' . setting('db_name') . ';',
        setting('db_user'),
        setting('db_pass')
    );
} catch (Exception $e) {
    die('<h1>FATAL DB ERROR</h1><pre>' . $e . '</pre>');
}
