<?php

/**
 * Autoloader - include this file to setup the constants and autoload
 *              functionality.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  World's Tallest Ladder <wtl420@users.noreply.github.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

// Load our constants
require_once __DIR__ . DIRECTORY_SEPARATOR . 'constants.php';

// Load composer autoloader
require_once APP_VENDOR . DIRECTORY_SEPARATOR .
    'autoload.php';

// Load our autoloader
require_once APP_CORE . DIRECTORY_SEPARATOR .
    'Autoloader.php';

use LumaSMS\core\Autoloader;

$autoloader = new Autoloader();
// Anything outside this directory or with a non-standard namespace
// should be added first.
$autoloader->appendNamespace('LumaSMS\tests', APP_TESTS);
$autoloader->appendNamespace('LumaSMS', APP_SRC);
$autoloader->register();
