<?php
/**
 * LumaSMS Autoloader
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/mit>
 * @author  World's Tallest Ladder <wtl420@users.noreply.github.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS;

// Load composer autoloader
require_once __DIR__ . DIRECTORY_SEPARATOR .
    'vendor' . DIRECTORY_SEPARATOR .
    'autoload.php';

// Load our autoloader
require_once __DIR__ . DIRECTORY_SEPARATOR .
    'install' . DIRECTORY_SEPARATOR .
    'Autoloader.php';

use LumaSMS\install\Autoloader;

$autoloader = new Autoloader();
$autoloader->register();
