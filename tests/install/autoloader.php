<?php
/**
 * Autoloader for the tests
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/mit>
 * @author  World's Tallest Ladder <wtl420@users.noreply.github.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\install\tests;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR .
    'install' . DIRECTORY_SEPARATOR .
    'Autoloader.php';

use LumaSMS\install\Autoloader;

$autoloader = new Autoloader();
$autoloader->register();
