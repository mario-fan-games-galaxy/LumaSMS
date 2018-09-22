<?php
/**
 * Handler of files for the installer.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylainDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

// Load the autoloader.
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR .
    'src' . DIRECTORY_SEPARATOR .
    'autoload.php';

use Symfony\Component\Yaml\Yaml;

// phpcs:disable PSR1.Files.SideEffects
if (!function_exists('setting')) {
/**
 * Set or get setting
 *
 * @param string $key   The setting to get or set.
 * @param mixed  $value If set, this is the new value for a setting.
 *
 * @return mixed Returns the setting if getting a setting, otherwise returns null.
 */
    function setting($key, $value = null)
    {
        global $_SETTINGS;

        if (empty($key) || empty($_SETTINGS[$key])) {
            return false;
        }

        if ($value == null) {
            return $_SETTINGS[$key];
        }

        $_SETTINGS[$key] = $value;
    }
}

$_SETTINGS = Yaml::parse(file_get_contents(CONFIG_FILE));
$_SETTINGS['db_host'] = $_SETTINGS['database']['hostname'];
$_SETTINGS['db_name'] = $_SETTINGS['database']['dbname'];
$_SETTINGS['db_user'] = $_SETTINGS['database']['username'];
$_SETTINGS['db_pass'] = $_SETTINGS['database']['password'];
$_SETTINGS['db_prefix'] = $_SETTINGS['database']['prefix'];
