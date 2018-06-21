<?php
namespace LumaSMS;

// I'm not making an autoloader for one class
require_once __DIR__.'/Installer.php';
// Load settings file for `settings` function
//require_once SETTINGS_FILE;

use LumaSMS\Installer;
use \PDO;
use \PHPUnit_Framework_TestCase;

/**
 * This is all the tests for the Installer class.
 * Uses PHPUnit 4.8 (old, but the latest still compatible with PHP 5.4)
 * Run with `phpunit Installer_Tests.php` in this directory
 * DO NOT run these tests on a live environment, for development purposes only
 * You WILL LOSE YOUR DATABASE if you run these!
 *
 * Tests assume your database connection settings in `settings.php` are valid
 * (other settings will be overwritten)
 */
class Installer_Tests extends PHPUnit_Framework_TestCase
{
    /*
     * Store the database connection information so we don't lose it
     */
    protected static $_db_host = '';
    protected static $_db_name = '';
    protected static $_db_user = '';
    protected static $_db_pass = '';


    /*
     * Save the database information
     */
    public function __construct()
    {
        static::$_db_host = Installer::get_setting('db_host');
        static::$_db_name = Installer::get_setting('db_name');
        static::$_db_user = Installer::get_setting('db_user');
        static::$_db_pass = Installer::get_setting('db_pass');
    }

    /*
     * A utility method for recursively deleting a directory
     * uses rrmdir function from here: https://secure.php.net/manual/en/function.rmdir.php#117354
     *
     * @param  string  The directory you want to delete
     *
     */
    protected static function _rmdir($src)
    {
        $dir = opendir($src);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                $full = $src . '/' . $file;
                if (is_dir($full)) {
                    static::_rmdir($full);
                } else {
                    unlink($full);
                }
            }
        }
        closedir($dir);
        rmdir($src);
    }

    /*
     * Test the `get_tables()` method of the `Installer` class
     */
    public function test_get_tables()
    {
        $tables = Installer::get_tables();
        $this->assertInternalType('array', $tables);
        // Only going to test for this,
        // as full table list is supposed to be able
        // to change
        $this->assertContains(Installer::get_setting('db_prefix').'users', $tables);
    }

    /*
     * Test the `create_settings_file` method of the `Installer` class
     */
    public function test_create_settings_file()
    {
        // Test with existing `SETTINGS_FILE`
        $this->assertEquals(true, Installer::create_settings_file());

        // delete settings file
        unlink(SETTINGS_FILE);

        // create a new one!
        $this->assertEquals(true, Installer::create_settings_file());

        // re-add database settings
        Installer::update_setting('db_host', static::$_db_host);
        Installer::update_setting('db_name', static::$_db_name);
        Installer::update_setting('db_user', static::$_db_user);
        Installer::update_setting('db_pass', static::$_db_pass);
    }

    /*
     * Test the `get_setting()` method of the `Installer` class
     *
     * @depends test_create_installer_file
     */
    public function test_get_setting()
    {
        // First grab the setting via the `setting` function.
        $original_thumbnail_directory = setting('thumbnail_directory');

        $test_thumbnail_directory = Installer::get_setting('thumbnail_directory');
        $this->assertEquals($original_thumbnail_directory, $test_thumbnail_directory);
    }

    /*
     * Test the `is_installed()` method of the `Installer` class
     *
     * @depends test_get_setting
     */
    public function test_is_installed()
    {
        $this->assertInternalType('boolean', Installer::is_installed());
    }

    /*
     * Test the `get_environment()` method of the `Installer` class
     */
    public function test_get_environment()
    {
        $environment = Installer::get_environment();

        // Make sure the right amount of stuff is in the environment
        $this->assertInternalType('array', $environment);
        $this->assertCount(3, $environment);

        // Make sure PHP information is gathered
        $this->assertArrayHasKey('php', $environment);
        $this->assertCount(3, $environment['php']);
        $this->assertArrayHasKey('version', $environment['php']);
        $this->assertRegExp('/^\d+(?:\.\d+(?:\.\d+)?)?/', $environment['php']['version']);
        $this->assertInternalType('string', $environment['php']['version']);
        $this->assertArrayHasKey('compatible', $environment['php']);
        $this->assertInternalType('boolean', $environment['php']['compatible']);
        $this->assertArrayHasKey('extensions', $environment['php']);
        $this->assertInternalType('array', $environment['php']['extensions']);
        $this->assertContains('Core', $environment['php']['extensions']);

        // Make sure MySQL information is gathered
        $this->assertArrayHasKey('mysql', $environment);
        $this->assertCount(2, $environment['mysql']);
        $this->assertArrayHasKey('version', $environment['mysql']);
        $this->assertInternalType('string', $environment['mysql']['version']);
        $this->assertRegExp('/^(?:\d+(?:\.\d+(?:\.\d+)?)?|Unknown$)/', $environment['mysql']['version']);
        $this->assertArrayHasKey('compatible', $environment['mysql']);
        $this->assertInternalType('boolean', $environment['mysql']['compatible']);

        // Make sure Apache information is gathered
        $this->assertArrayHasKey('webserver', $environment);
        $this->assertCount(4, $environment['webserver']);
        $this->assertArrayHasKey('software', $environment['webserver']);
        $this->assertInternalType('string', $environment['webserver']['software']);
        $this->assertArrayHasKey('operating_system', $environment['webserver']);
        $this->assertInternalType('string', $environment['webserver']['operating_system']);
        $this->assertArrayHasKey('version', $environment['webserver']);
        $this->assertInternalType('string', $environment['webserver']['version']);
        $this->assertRegExp('/^(?:\d+(?:\.\d+(?:\.\d+)?)?|Unknown$)/', $environment['webserver']['version']);
        $this->assertArrayHasKey('compatible', $environment['webserver']);
        $this->assertInternalType('boolean', $environment['webserver']['compatible']);
    }

    /*
     * Test the `update_setting()` method of the `Installer` class
     *
     * @depends test_get_setting
     */
    public function test_update_setting()
    {
        // Try updating a real setting
        $original_thumbnail_directory = Installer::get_setting('thumbnail_directory');

        $update_setting_result = Installer::update_setting('thumbnail_directory', 'TEST');
        $this->assertEquals(true, $update_setting_result);
        $this->assertEquals('TEST', Installer::get_setting('thumbnail_directory'));

        // Revert the change and make sure it saved
        $update_setting_result = Installer::update_setting('thumbnail_directory', $original_thumbnail_directory);
        $this->assertEquals(true, $update_setting_result);
        $this->assertEquals($original_thumbnail_directory, Installer::get_setting('thumbnail_directory'));
    }

    /*
     * Test the `update_setting` method of the `Installer` class with a
     * fake setting.
     */
    public function test_fake_update_setting()
    {
        $this->setExpectedException(
              'InvalidArgumentException', 'Setting not found.'
          );
        $fake_setting_result = Installer::update_setting('fake_setting', 'fake_value');
        $this->assertEquals(false, $fake_setting_result);
    }

    /*
     * Tests the `uninstall_database` method of the `Installer` class
     *
     * @depends test_get_setting
     * @depends test_is_installed
     */
    public function test_uninstall_database()
    {
        $this->assertEquals(true, Installer::uninstall_database());

        $this->assertEquals(false, Installer::is_installed());
    }

    /*
     * Tests the `install_database` method of the `Installer` class
     *
     * @depends test_get_setting
     * @depends test_is_installed
     * @depends test_uninstall_database
     */
    public function test_install_database()
    {
        if (Installer::is_installed()) {
            // If it's already installed, empty the database...
            Installer::uninstall_database();
        }

        $this->assertEquals(true, Installer::install_database());

        $this->assertEquals(true, Installer::is_installed());
    }

    /*
     * Test the `create_directories` method of the `Installer` class
     *
     * @depends  test_get_setting
     */
    public function test_create_directories()
    {
        $directories = array(
            Installer::get_setting('thumbnail_directory'),
            Installer::get_setting('file_directory'),
        );
        foreach ($directories as $key=>$dir) {
            if (substr($dir, 0, 1) === '.') {
                $directories[$key] = dirname(__DIR__).DIRECTORY_SEPARATOR.$dir;
            }
        }

        // Delete directories first
        foreach ($directories as $dir) {
            if (file_exists($dir)) {
                if (is_dir($dir)) {
                    static::_rmdir($dir);
                } else {
                    unlink($dir);
                }
            }
        }

        // try it
        $this->assertEquals(true, Installer::create_directories());

        // make sure they all exist
        foreach ($directories as $dir) {
            $this->assertEquals(true, Installer::create_directories());
            $this->assertEquals(true, is_dir($dir));
            $this->assertEquals(true, is_readable($dir));
            $this->assertEquals(true, is_writable($dir));
        }
        for ($i = 1; $i <= 6; ++$i) {
            foreach ($directories as $dir) {
                $dir = $dir.DIRECTORY_SEPARATOR.$i;
                $this->assertEquals(true, is_dir($dir));
                $this->assertEquals(true, is_readable($dir));
                $this->assertEquals(true, is_writable($dir));
            }
        }
    }

    /*
     * Test the `empty_install` method of the `Installer` class
     *
     * @depends  test_is_installed
     * @depends  test_install_database
     */
    public function test_empty_install()
    {
        $keep_tables = array(
            'filter_group',
            'filter_multi',
            'filter_use',
            'groups',
        );
        foreach ($keep_tables as $key=>$table) {
            $keep_tables[$key] = Installer::get_setting('db_prefix').$table;
        }

        try {
            $db = new PDO(
                'mysql:'.
                'host='.Installer::get_setting('db_host').';'.
                'dbname='.Installer::get_setting('db_name').';',
                    Installer::get_setting('db_user'),
                    Installer::get_setting('db_pass')
                );
        } catch (Exception $e) {
            echo $e.PHP_EOL;
            // Not sure if this is the best way
            // to tell PHPUnit to quit, but it works!
            $this->assertEquals(true, false);
        }

        $this->assertEquals(true, Installer::empty_install());
        foreach (Installer::get_tables() as $table) {
            if (in_array($table, $keep_tables, true)) {
                continue;
            }
            $result = $db->query('SELECT COUNT(*) FROM `'.$table.'`;');
            $this->assertEquals(0, (int) $result->fetchColumn());
        }

        // Close database connection
        $db = null;
    }

    /*
     * Test the `create_admin_user` method of the `Installer` class
     * with a username that is too long
     *
     * @depends  test_is_installed
     * @depends  test_install_database
     */
    public function test_create_admin_user_lengthy_username()
    {
        $this->setExpectedException('Exception', 'Username is too long!');
        $this->assertEquals(false, Installer::create_admin_user('012345678901234567890123456789012345678901234567890', 'test@example.com', 'test_create_admin_user'));
    }

    /*
     * Test the `create_admin_user` method of the `Installer` class
     * with an invalid email address
     *
     * @depends  test_is_installed
     * @depends  test_install_database
     */
    public function test_create_admin_user_invalid_email()
    {
        $this->setExpectedExceptionRegExp('Exception', '/^Invalid email address: /');
        $this->assertEquals(false, Installer::create_admin_user('test_create_admin_user', 'test_create_admin_user', 'test_create_admin_user'));
    }


    /*
     * Test the `create_admin_user` method of the `Installer` class
     *
     * @depends  test_is_installed
     * @depends  test_install_database
     */
    public function test_create_admin_user()
    {
        $this->assertEquals(true, Installer::create_admin_user('test_create_admin_user', 'test@example.com', 'test_create_admin_user'));

        // Make sure it exists
        try {
            $db = new PDO(
                'mysql:'.
                'host='.Installer::get_setting('db_host').';'.
                'dbname='.Installer::get_setting('db_name').';',
                    Installer::get_setting('db_user'),
                    Installer::get_setting('db_pass')
                );
        } catch (Exception $e) {
            echo $e.PHP_EOL;
            // Not sure if this is the best way
            // to tell PHPUnit to quit, but it works!
            $this->assertEquals(true, false);
            return;
        }

        $result = $db->query('SELECT COUNT(*) FROM `'.Installer::get_setting('db_prefix').'users` WHERE `username` = \'test_create_admin_user\' AND `email` = \'test@example.com\';');

        $result = (int) $result->fetchColumn();
        $this->assertEquals(1, $result);

        // Clear result
        $result = $db->query('DELETE FROM `'.Installer::get_setting('db_prefix').'users` WHERE `username` = \'test_create_admin_user\' AND `email` = \'test@example.com\';');

        // Close connection
        $db = null;
    }
}
