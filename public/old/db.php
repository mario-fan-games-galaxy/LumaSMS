<?php

/**
 * Database helpers
 * @package lumasms
 */

/**
 * Database shortcut function
 *
 * @return \PDO A PDO instance
 */
function DB()
{
    global $_DB;

    if (empty($_DB)) {
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
    }

    return $_DB;
}
