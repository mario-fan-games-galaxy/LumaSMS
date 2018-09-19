<?php
/**
 * Handler of files for the installer.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylainDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

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

$_SETTINGS = [
    // Content settings.
    'thumbnail_directory' => '../tcsms/thumbnail',
    'file_directory' => '../tcsms/file',
    'session_hotlink_protection' => true,

    // Database settings.
    'db_host' => 'localhost',
    'db_name' => 'mfgg',
    'db_user' => 'root',
    'db_pass' => '',
    'db_prefix' => 'tsms_',

    // Date settings.
    'date_format' => 'm/d/Y g:ia',
    'date_setting' => 'since',

    // Login settings.
    'login_attempts_max' => 10,
    'login_attempts_wait' => 60 * 5,

    // Registration Form Settings.
    'username_min_length' => 3,
    'username_max_length' => 32,
    'password_min_length' => 3,
    'password_max_length' => 72,

    // Resource settings.
    'limit_per_page' => 20,

    // Site settings.
    'site_name' => 'Mario Fan Games Galaxy',
    'site_abbr' => 'MFGG',
];
