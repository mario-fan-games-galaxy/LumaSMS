<?php
namespace LumaSMS;

// Load up the global functions and settings
require_once(dirname(__DIR__).DIRECTORY_SEPARATOR.'functions.php');
require_once(dirname(__DIR__).DIRECTORY_SEPARATOR.'password.php');

use \InvalidArgumentException;
use \Exception;
use \PDO;

/*
 * The filename of the `settings.php` file, or at least where it should be when
 * all is said and done.
 *
 * PHP 5.4 won't let me delcare a constant with expressions so it'll go here.
 *
 */
if (!defined('SETTINGS_FILE')) {
    define('SETTINGS_FILE', dirname(__DIR__).DIRECTORY_SEPARATOR.'settings.php');
}

/**
 * This class organizes all the functionality
 * designed for the installer.
 */
class Installer
{

    /*
     * An array of settings so we don't have
     * to go back and retrieve them if they're
     * called multiple times
     */
    protected static $_settings = array();


    /*
     * Import MySQL files using PHP
     * Adapted from https://stackoverflow.com/a/19752106
     *
     * @param  string  $filename  The filename you wish to import. Include the full path.
     *
     * @throws  InvalidArgument Exception  If the file can not be read.
     * @throws  Exception  If there's an issue connecting to the database.
     * @throws  Exception  If a query in the file has a problem executing.
     *
     * @return  boolean  `true` on success, `false` on failure.
     */
    protected static function import_mysql_file($filename)
    {
        if (!is_readable($filename)) {
            throw new InvalidArgumentException('File cannot be read: '.$filename);
            return false;
        }
        try {
            $db = new PDO(
                'mysql:'.
                'host='.static::get_setting('db_host').';'.
                'dbname='.static::get_setting('db_name').';',
                    static::get_setting('db_user'),
                    static::get_setting('db_pass')
                );
        } catch (Exception $e) {
            // Couldn't connect!
            throw new Exception('There was an issue connecting to the MySQL database');
            return false;
        }

        $temp_line = '';

        $file_pointer = fopen($filename, 'r');
        if ($file_pointer) {
            while (!feof($file_pointer)) {
                $line = trim(fgets($file_pointer));
                if ('' === $line) {
                    continue;
                }
                // Skip it if it's a comment
                if ('--' === substr($line, 0, 2)) {
                    continue;
                }

                $temp_line .= ' '.$line;
                if (substr($line, -1, 1) == ';') {
                    $temp_line = str_replace('`tsms_', '`'.static::get_setting('db_prefix'), $temp_line);
                    if (!$db->query($temp_line)) {
                        throw new Exception('Could not execute query: '.$temp_line);
                        return false;
                    }
                    $temp_line = '';
                }
            }
            fclose($file_pointer);
        }

        // close connection
        $db = null;

        return true;
    }

    /*
     * Get a complete list of tables that should exist in the database
     * if the application is installed. Includes `db_prefix`
     *
     * @return  string[]  An array of the name of each table in the database
     */
    public static function get_tables()
    {
        $no_prefix_tables = array(
            'admin_msg',
            'comments',
            'filter_group',
            'filter_list',
            'filter_multi',
            'filter_use',
            'forums',
            'groups',
            'login_attempts',
            'mail_log',
            'messages',
            'modules',
            'news',
            'panels',
            'posts',
            'resources',
            'res_games',
            'res_gfx',
            'res_howtos',
            'res_misc',
            'res_reviews',
            'res_sounds',
            'sec_images',
            'sessions',
            'skins',
            'staffchat',
            'topics',
            'users',
            'version',
        );

        // Add the database prefix
        $tables = array();
        foreach ($no_prefix_tables as $table) {
            $tables[] = static::get_setting('db_prefix').$table;
        }

        return $tables;
    }

    /*
     * Create settings file
     *
     * @throws  Exception  If the setting file already exists and is unreadable or unwritable
     * @throws  Exception  If there is an issue copying the file over
     *
     * @return  boolean  `true` if file was copied over successfully.
     */
    public static function create_settings_file()
    {
        // Check if file already exists
        if (is_readable(SETTINGS_FILE) && is_writable(SETTINGS_FILE)) {
            // No need to do anything
            return true;
        }
        if (file_exists(SETTINGS_FILE)) {
            throw new Exception('Settings file already exists and is inacessible.');
            return false;
        }
        // Copy file over
        $default_settings_file = __DIR__.DIRECTORY_SEPARATOR.'settings.default.php';
        $result = copy($default_settings_file, SETTINGS_FILE);
        if (!$result) {
            throw new Exception('There was an issue copying the file over!');
            return false;
        }
        // should always return true at this point
        return file_exists(SETTINGS_FILE);
    }

    /*
     * Read a setting by parsing the `SETTINGS_FILE` file- necessary for
     * loading a setting that has changed after the file has been included
     *
     * @param  string  $setting  The setting you want to read
     * @param  boolean  $ignore_saved  If you want to ingore settings that are saved in the Installer file and load from the `SETTINGS_FILE` file set this to true
     *
     * @throw  Exception  if `SETTINGS_FILE` can not be read.
     *
     * @return  mixed  The value of the setting you've read
     */
    public static function get_setting($setting, $ignore_saved = false)
    {
        if (isset(static::$_settings[$setting]) && !$ignore_saved) {
            // we can ignore all this and use what's already there
            return static::$_settings[$setting];
        }

        $settings_string = '';
        if (!is_readable(SETTINGS_FILE)) {
            throw new Exception('Could not read `'.SETTINGS_FILE.'` file!');
            return false;
        }

        $file_pointer = fopen(SETTINGS_FILE, 'r');
        if ($file_pointer) {
            while (!feof($file_pointer)) {
                $line = fgets($file_pointer);
                if (false === $line) {
                    $settings_string = '';
                    break;
                }

                if (0 === strlen($settings_string)) {
                    $matches = array();
                    if (preg_match(
                        '/\$_SETTINGS\s*=\s*(?P<settings_array_opening>(?:\[|[Aa][Rr][Rr][Aa][Yy]\().*(?:(?:\]|\))\s*;|$))/',
                        $line,
                        $matches)
                    ) {
                        $settings_string = trim($matches['settings_array_opening']).PHP_EOL;
                    }
                    if (preg_match(
                        '/$_SETTINGS\s*=\s*(?:\[|[Aa][Rr][Rr][Aa][Yy]\().*(?:\]|\))\s*;/',
                        $line)
                    ) {
                        // looks like we got the full string already
                        break;
                    }
                    continue;
                } else {
                    $matches = array();
                    if (preg_match(
                        "/(?'settings_array_close'(?:\]|\))\s*;)/",
                        $line,
                        $matches)
                    ) {
                        // This should be the end of the settings array
                        $settings_string .= ' '.trim($matches['settings_array_close']).PHP_EOL;
                        break;
                    } else {
                        $settings_string .= ' '.trim($line).PHP_EOL;
                    }
                }
            }
            fclose($file_pointer);
        }

        if (0 < strlen($settings_string)) {
            // eval isn't smart to use, but it's the only way to deal with a
            // `SETTINGS_FILE` file other than writing a parser
            $settings = false;
            eval('$settings = '.$settings_string.';');
            if (is_array($settings) && isset($settings[$setting])) {
                static::$_settings[$setting] = $settings[$setting];
                return $settings[$setting];
            }
        }

        throw new Exception('Could not read settings!');
        return null;
    }

    /*
     * Check if the application is installed already or not
     *
     * @throw  Exception  If there is an issue checking if a table is there
     *
     * @return  boolean  True if the application is installed, false otherwise
     */
    public static function is_installed()
    {
        // attempt connection with existing settings
        try {
            $db = new PDO(
                'mysql:'.
                    'host='.static::get_setting('db_host').';'.
                    'dbname='.static::get_setting('db_name').';',
                static::get_setting('db_user'),
                static::get_setting('db_pass')
            );
        } catch (Exception $e) {
            // If we can't connect, assume it isn't installed
            return false;
        }

        // If connected, check for tables
        foreach (static::get_tables() as $table) {
            // This can throw an exception
            try {
                $result = $db->query('SELECT 1 FROM `'.$table.'` LIMIT 1');
            } catch (Exception $e) {
                throw $e;
                return false;
            }
            // Result should be `false` if table does not exist
            if (!$result) {
                return false;
            }
        }

        // Close connection
        $db = null;

        return true;
    }

    /*
     * Gather some information about the environment. Any information that
     * can not be retrieved is returned as `Unknown` and `compatible` is set to
     * `true`
     *
     * @return  array  Returns an array of environment details with each feature as a key and an array including version numbers and if the version is good to use or not, as well as additional details
     */
    public static function get_environment()
    {
        // This is what we'll be returning when this is all over
        $environment = array();

        // Figure out the PHP environment
        $php_compatible = version_compare('5.4.16', phpversion(), '<=');
        $php_extensions = get_loaded_extensions();
        // Not sure if this list is complete, but it's a start
        $required_extensions = array(
            'Core',
            'date',
            'session',
            'PDO',
            'pdo_mysql',
        );
        foreach ($required_extensions as $extension) {
            $php_compatible = $php_compatible &&
                in_array($extension, $php_extensions, true);
        }
        $environment['php'] = array(
            'version' => phpversion(),
            'extensions' => $php_extensions,
            'compatible' => $php_compatible,
        );


        // Figure out the MySQL environment, or at least as much as we can
        // before being able to connect
        $mysql_version = 'Unknown';
        if (is_callable('shell_exec') && false === stripos(ini_get('disable_functions'), 'shell_exec')) {
            $mysql_version_string = shell_exec('mysql -V');
            $mysql_version_match_results = array();
            preg_match('/[0-9]+\.[0-9]+\.[0-9]+/', $mysql_version_string, $mysql_version_match_results);
            $mysql_version = $mysql_version_match_results[0];
        };
        $environment['mysql'] = array(
            'version' => $mysql_version,
            'compatible' => $mysql_version === 'Unknown' or
                version_compare('5.5', $mysql_version, '<=')
        );

        // Figure out webserver information
        $webserver_software = 'Unknown';
        $webserver_version = 'Unknown';
        $webserver_operating_system = 'Unknown';
        if ('cli' !== php_sapi_name() && isset($_SERVER['SERVER_SOFTWARE'])) {
            $webserver_string_matches = array();
            if (preg_match(
                "/^(?'software'[\w ]+)\/(?'version'(?:\d+(?:\.\d+(?:\.\d+)?)?))\s+\((?'OS'[\w ]+)\)/",
                $_SERVER['SERVER_SOFTWARE'],
                $webserver_string_matches
            )) {
                $webserver_software = trim($webserver_string_matches['software']);
                $webserver_version = trim($webserver_string_matches['version']);
                $webserver_operating_system = trim($webserver_string_matches['OS']);
            }
        }
        $environment['webserver'] = array(
            'software' => $webserver_software,
            'version' => $webserver_version,
            'operating_system' => $webserver_operating_system,
            'compatible' => ($webserver_software === 'Unknown') or
                ('apache' === strtolower($webserver_software)) &&
                    version_compare('2.2', $webserver_version, '<='),
        );

        return $environment;
    }

    /*
     * Update a setting in the site's configuration file.
     * Note: This will NOT create new settings,
     * only update existing ones. If it can't find the setting, it shouldn't
     * do anything.
     *
     * Settings in the settings file _must_ be 1 per line, in the format:
     * `'setting_name' => value,`
     *
     * @param  string  The setting you wish to update
     * @param  mixed  The value of the setting you wish to update.
     *
     * @throws  InvalidArgumentException  if the value to set is invalid.
     * @throws  InvalidArgumentException  if the setting to be updated isn't found.
     * @throws  Exception  if the `SETTINGS_FILE` cannot be read
     * @throws  Exception  if the `SETTINGS_FILE` cannot be written
     *
     * @return  boolean  If the setting was updated successfully
     */
    public static function update_setting($setting, $value)
    {
        $boolean_settings = array(
            'session_hotlink_protection',
        );

        // Check if value shouldn't be a string and give it the correct type
        if (in_array($setting, $boolean_settings, true) && (
            trim(strtolower($value)) === 'true' or
            trim(strtolower($value)) === 'false')
        ) {
            $value = trim(strtolower($value)) === 'true';
        } elseif (is_numeric($value)) {
            if ((string) (int) $value === $value) {
                $value = (int) $value;
            } elseif ((string) (float) $value === $value) {
                $value = (float) $value;
            } elseif ((string) (double) $value === $value) {
                $value = (double) $value;
            }
        } elseif (!is_string($value) && $value == '') {
            throw new InvalidArgumentException('Invalid value for setting.');
        }
        if (is_string($value)) {
            $value_string = '\''.$value.'\'';
        } elseif ($value === true) {
            // `true` normally becomes `'1'` when converted to a string
            $value_string = 'true';
        } elseif ($value === false) {
            // `false` normall becomes `''` when converted to a string
            $value_string = 'false';
        } else {
            $value_string = $value;
        }

        $settings_file = array();

        if (!is_readable(SETTINGS_FILE)) {
            throw new Exception('Could not read `'.SETTINGS_FILE.'` file!');
            return false;
        } elseif (!is_writable(SETTINGS_FILE)) {
            throw new Exception(SETTINGS_FILE);
            return false;
        }
        $file_pointer = fopen(SETTINGS_FILE, 'r');
        if ($file_pointer) {
            while (!feof($file_pointer)) {
                $line = fgets($file_pointer);
                if (false === $line) {
                    break;
                }
                $settings_file[] = $line;
            }
            fclose($file_pointer);
        }
        $regex_safe_setting = preg_quote($setting);

        $setting_updated = false;
        foreach ($settings_file as $key=>$line) {
            $matches = array();
            if (preg_match(
                '/^(?<starting_space>\s*)[\'"]'.$regex_safe_setting.'[\'"]\s*=\s*>\s*.*,(?<ending_space>\s*)(?:\n|$)/',
                $line,
                $matches
            )) {
                $settings_file[$key] = $matches['starting_space'].'\''.$setting.'\' => '.$value_string.','.$matches['ending_space'];
                $setting_updated = true;
                break;
            }
        }

        if (!$setting_updated) {
            throw new InvalidArgumentException('Setting not found.');
            return false;
        }

        $file_pointer = fopen(SETTINGS_FILE, 'w+');
        if ($file_pointer) {
            fwrite($file_pointer, implode('', $settings_file));
            fclose($file_pointer);
        }

        return static::get_setting($setting, true) === $value;
    }

    /*
     * Uninstalls the database.
     *
     * @return  boolean  True if it worked, false if it didn't.
     */
    public static function uninstall_database()
    {
        try {
            $db = new PDO(
                'mysql:'.
                'host='.static::get_setting('db_host').';'.
                'dbname='.static::get_setting('db_name').';',
                    static::get_setting('db_user'),
                    static::get_setting('db_pass')
                );
        } catch (Exception $e) {
            return false;
        }
        foreach (static::get_tables() as $table) {
            $db->query('DROP TABLE IF EXISTS `'.$table.'`;');
        }

        // Close connection
        $db = null;

        return !static::is_installed();
    }

    /*
     * Imports the database files.
     *
     * @throws  Exception  if there is an issue importing a mysql file, see `Installer::import_mysql_file` for more details
     *
     * @return  boolean  True if it worked, false if it didn't.
     */
    public static function install_database()
    {
        $mysql_files = array(
            __DIR__.DIRECTORY_SEPARATOR.'mfgg.sql',
            __DIR__.DIRECTORY_SEPARATOR.'mfgg_update.sql',
        );
        $sql_contents = scandir(__DIR__.DIRECTORY_SEPARATOR.'sql');
        foreach ($sql_contents as $item) {
            if ('.sql' === substr($item, -4, 4)) {
                $mysql_files[] = __DIR__.DIRECTORY_SEPARATOR.'sql'.DIRECTORY_SEPARATOR.$item;
            }
        }

        foreach ($mysql_files as $file) {
            try {
                if (!static::import_mysql_file($file)) {
                    return false;
                }
            } catch (Exception $e) {
                throw $e;
            }
        }

        return static::is_installed();
    }

    /*
     * Create configured directories if they don't exist, if they already do,
     * great! No need for any further action.
     *
     * @throws  Exception  if the directory settings are invalid paths
     * @throws  Exception  if the directories can not be created
     *
     * @return  boolean  `true` if directories now exist, `false` if they don't
     */
    public static function create_directories()
    {
        $directories = array(
            static::get_setting('thumbnail_directory'),
            static::get_setting('file_directory'),
        );
        foreach ($directories as $key=>$dir) {
            if (substr($dir, 0, 1) === '.') {
                $directories[$key] = dirname(__DIR__).DIRECTORY_SEPARATOR.$dir;
                $dir = $directories[$key];
            }
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            if (!is_readable($dir) && !is_writable($dir)) {
                throw new Exception('Could not access directory: '.$dir);
                return false;
            }
        }
        for ($i = 1; $i <= 6; ++$i) {
            foreach ($directories as $dir) {
                $dir = $dir.DIRECTORY_SEPARATOR.$i;
                if (!file_exists($dir)) {
                    mkdir($dir, 0755, true);
                }
                if (!is_readable($dir) && !is_writable($dir)) {
                    throw new Exception('Could not access directory: '.$dir);
                    return false;
                }
            }
        }

        return true;
    }

    /*
     * Clear the database of sample data
     *
     * @throws  Exception  if there is an issue connecting to the database
     * @throws  Exception  if there is an issue clearing a table
     *
     * @return  boolean  `true` if data was removed successfully.
     */
    public static function empty_install()
    {
        $keep_tables = array(
            'filter_group',
            'filter_multi',
            'filter_use',
            'groups',
        );
        foreach ($keep_tables as $key=>$table) {
            $keep_tables[$key] = static::get_setting('db_prefix').$table;
        }
        $tables = static::get_tables();

        try {
            $db = new PDO(
                'mysql:'.
                'host='.static::get_setting('db_host').';'.
                'dbname='.static::get_setting('db_name').';',
                    static::get_setting('db_user'),
                    static::get_setting('db_pass')
                );
        } catch (Exception $e) {
            throw $e;
            return false;
        }

        foreach ($tables as $table) {
            if (in_array($table, $keep_tables, true)) {
                continue;
            }
            if (!$db->query('TRUNCATE TABLE `'.$table.'`;')) {
                throw new Exception('There was an issue truncating table `'.$table.'`');
            };
        }

        // Close database connection
        $db = null;

        return true;
    }

    /*
     * Create an admin user, typically the site owner
     *
     * @throws  Exception  because this function is not implemented yet.
     * @throws  InvalidArgumentException  if the username is invalid.
     * @throws  InvalidArgumentException  if the password is invalid.
     * @throws  InvalidArgumentException  if the email is invalid.
     * @throws  Exception  if there is an issue connecting to the database
     * @throws  Exception  if there is an issue adding the user to the database
     *
     * @return  boolean  `true` if user was created successfully.
     */
    public static function create_admin_user($username, $email, $password)
    {
        $ip = isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'127.0.0.1';

        if (strlen($username) > 32) {
            throw new Exception('Username is too long!');
            return false;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email address: '.$email);
            return false;
        }
        $user = array(
            'gid' => 1,
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'join_date' => time(),
            'last_activity' => time(),
            'last_visit' => time(),
            'registered_ip' => $ip,
            'last_ip' => $ip,
        );

        try {
            $db = new PDO(
                'mysql:'.
                'host='.static::get_setting('db_host').';'.
                'dbname='.static::get_setting('db_name').';',
                    static::get_setting('db_user'),
                    static::get_setting('db_pass')
                );
        } catch (Exception $e) {
            throw $e;
            return false;
        }

        $create = $db->prepare('INSERT INTO `'.static::get_setting('db_prefix').'users` (gid, username, email, password, join_date, last_activity, last_visit, registered_ip, last_ip) VALUES (:gid, :username, :email, :password, :join_date, :last_activity, :last_visit, :registered_ip, :last_ip);');
        foreach ($user as $setting=>$value) {
            $create->bindValue(':'.$setting, $value);
        }
        $create->execute();

        // Close connection
        $db = null;

        return true;
    }
}
