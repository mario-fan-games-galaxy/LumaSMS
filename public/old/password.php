<?php

/**
 * Load the password compatibility library from composer
 * @package lumasms
 */

/**
 * Load library
 */

require_once dirname(dirname(__DIR__)) .
    DIRECTORY_SEPARATOR .
    'vendor' .
    DIRECTORY_SEPARATOR .
    'ircmaxell' .
    DIRECTORY_SEPARATOR .
    'password-compat' .
    DIRECTORY_SEPARATOR .
    'lib' .
    DIRECTORY_SEPARATOR .
    'password.php';
