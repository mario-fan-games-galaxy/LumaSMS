<?php

/**
 * Settings manager.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @author  World's Tallest Ladder <wtl420@users.noreply.github.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

use Symfony\Component\Yaml\Yaml;

/**
 * Use this function to access the settings easily
 *
 * @SuppressWarnings(PHPMD.Superglobals)
 * @SuppressWarnings(PHPMD.StaticAccess)
 *
 * @author HylianDev <supergoombario@gmail.com>
 *
 * @return array The settings array
 */
function settings()
{
    if (!isset($GLOBALS['_SETTINGS'])) {
        // Get settings if they're not found.
        try {
            $GLOBALS['_SETTINGS'] = Yaml::parse(file_get_contents(CONFIG_FILE));
        } catch (Exception $e) {
            Fatality($e);
        }
    }
    return $GLOBALS['_SETTINGS'];
}
