<?php
/**
 * Constants.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  World's Tallest Ladder <wtl420@users.noreply.github.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

// Define directories.
// Root directory.
define('APP_ROOT', dirname(__DIR__));

// Main directories.
define('APP_CONFIG', APP_ROOT . DIRECTORY_SEPARATOR . 'config');
define('APP_PUBLIC', APP_ROOT . DIRECTORY_SEPARATOR . 'public');
define('APP_SRC', __DIR__);
define('APP_TEMPLATES', APP_ROOT . DIRECTORY_SEPARATOR . 'templates');
define('APP_TESTS', APP_ROOT . DIRECTORY_SEPARATOR . 'tests');
define('APP_VAR', APP_ROOT . DIRECTORY_SEPARATOR . 'var');
define('APP_VENDOR', APP_ROOT . DIRECTORY_SEPARATOR . 'vendor');

// Subdirectories.
define('APP_CORE', APP_SRC . DIRECTORY_SEPARATOR . 'core');
define('APP_CONTROLLERS', APP_SRC . DIRECTORY_SEPARATOR . 'controllers');
define('APP_DBDRIVERS', APP_SRC . DIRECTORY_SEPARATOR . 'dbdrivers');
define('APP_INSTALL', APP_SRC . DIRECTORY_SEPARATOR . 'install');
define('APP_MODELS', APP_SRC . DIRECTORY_SEPARATOR . 'models');
define('APP_LOGS', APP_VAR . DIRECTORY_SEPARATOR . 'logs');

// Define special files.
define('CONFIG_FILE', APP_CONFIG . DIRECTORY_SEPARATOR . 'config.yaml');
