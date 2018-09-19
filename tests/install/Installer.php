<?php
/**
 * This is being phased out, please ignore this file for now.
 *
 * It's unlikely it even works at this point... just working on moving
 * out the bits I need
 */
namespace LumaSMS;

use LumaSMS\Installer;
use \PDO;
use \PHPUnit_Framework_TestCase;

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
        static::$_db_host = Installer::getSetting('db_host');
        static::$_db_name = Installer::getSetting('db_name');
        static::$_db_user = Installer::getSetting('db_user');
        static::$_db_pass = Installer::getSetting('db_pass');
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
        $this->assertContains(Installer::getSetting('db_prefix') . 'users', $tables);
    }

    /*
     * Test the `createSettingsFile` method of the `Installer` class
     */
    public function testCreateSettingsFile()
    {
        // Test with existing `SETTINGS_FILE`
        $this->assertEquals(true, Installer::createSettingsFile());

        // delete settings file
        unlink(SETTINGS_FILE);

        // create a new one!
        $this->assertEquals(true, Installer::createSettingsFile());

        // re-add database settings
        Installer::updateSetting('db_host', static::$_db_host);
        Installer::updateSetting('db_name', static::$_db_name);
        Installer::updateSetting('db_user', static::$_db_user);
        Installer::updateSetting('db_pass', static::$_db_pass);
    }

    /*
     * Test the `getSetting()` method of the `Installer` class
     *
     * @depends test_create_installer_file
     */
    public function testGetSetting()
    {
        // First grab the setting via the `setting` function.
        $original_thumbnail_directory = setting('thumbnail_directory');

        $test_thumbnail_directory = Installer::getSetting('thumbnail_directory');
        $this->assertEquals($original_thumbnail_directory, $test_thumbnail_directory);
    }

    /*
     * Test the `isInstalled()` method of the `Installer` class
     *
     * @depends testGetSetting
     */
    public function testIsInstalled()
    {
        $this->assertInternalType('boolean', Installer::isInstalled());
    }

    /*
     * Test the `updateSetting()` method of the `Installer` class
     *
     * @depends testGetSetting
     */
    public function testUpdateSetting()
    {
        // Try updating a real setting
        $original_thumbnail_directory = Installer::getSetting('thumbnail_directory');

        $update_setting_result = Installer::updateSetting('thumbnail_directory', 'TEST');
        $this->assertEquals(true, $update_setting_result);
        $this->assertEquals('TEST', Installer::getSetting('thumbnail_directory'));

        // Revert the change and make sure it saved
        $update_setting_result = Installer::updateSetting('thumbnail_directory', $original_thumbnail_directory);
        $this->assertEquals(true, $update_setting_result);
        $this->assertEquals($original_thumbnail_directory, Installer::getSetting('thumbnail_directory'));
    }

    /*
     * Test the `updateSetting` method of the `Installer` class with a
     * fake setting.
     */
    public function testFakeUpdateSetting()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'Setting not found.'
        );
        $fake_setting_result = Installer::updateSetting('fake_setting', 'fake_value');
        $this->assertEquals(false, $fake_setting_result);
    }

    /*
     * Tests the `uninstallDatabase` method of the `Installer` class
     *
     * @depends testGetSetting
     * @depends testIsInstalled
     */
    public function testUninstallDatabase()
    {
        $this->assertEquals(true, Installer::uninstallDatabase());

        $this->assertEquals(false, Installer::isInstalled());
    }

    /*
     * Tests the `installDatabase` method of the `Installer` class
     *
     * @depends testGetSetting
     * @depends testIsInstalled
     * @depends testUninstallDatabase
     */
    public function testInstallDatabase()
    {
        if (Installer::isInstalled()) {
            // If it's already installed, empty the database...
            Installer::uninstallDatabase();
        }

        $this->assertEquals(true, Installer::installDatabase());

        $this->assertEquals(true, Installer::isInstalled());
    }

    /*
     * Test the `createDirectories` method of the `Installer` class
     *
     * @depends  testGetSetting
     */
    public function testCreateDirectories()
    {
        $directories = array(
            Installer::getSetting('thumbnail_directory'),
            Installer::getSetting('file_directory'),
        );
        foreach ($directories as $key => $dir) {
            if (substr($dir, 0, 1) === '.') {
                $directories[$key] = dirname(__DIR__) . DIRECTORY_SEPARATOR . $dir;
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
        $this->assertEquals(true, Installer::createDirectories());

        // make sure they all exist
        foreach ($directories as $dir) {
            $this->assertEquals(true, Installer::createDirectories());
            $this->assertEquals(true, is_dir($dir));
            $this->assertEquals(true, is_readable($dir));
            $this->assertEquals(true, is_writable($dir));
        }
        for ($i = 1; $i <= 6; ++$i) {
            foreach ($directories as $dir) {
                $dir = $dir . DIRECTORY_SEPARATOR . $i;
                $this->assertEquals(true, is_dir($dir));
                $this->assertEquals(true, is_readable($dir));
                $this->assertEquals(true, is_writable($dir));
            }
        }
    }

    /*
     * Test the `emptyInstall` method of the `Installer` class
     *
     * @depends  testIsInstalled
     * @depends  testInstallDatabase
     */
    public function testEmptyInstall()
    {
        $keep_tables = array(
            'filter_group',
            'filter_multi',
            'filter_use',
            'groups',
        );
        foreach ($keep_tables as $key => $table) {
            $keep_tables[$key] = Installer::getSetting('db_prefix') . $table;
        }

        try {
            $db = new PDO(
                'mysql:' .
                'host=' . Installer::getSetting('db_host') . ';' .
                'dbname=' . Installer::getSetting('db_name') . ';',
                Installer::getSetting('db_user'),
                Installer::getSetting('db_pass')
            );
        } catch (Exception $e) {
            echo $e . PHP_EOL;
            // Not sure if this is the best way
            // to tell PHPUnit to quit, but it works!
            $this->assertEquals(true, false);
        }

        $this->assertEquals(true, Installer::emptyInstall());
        foreach (Installer::get_tables() as $table) {
            if (in_array($table, $keep_tables, true)) {
                continue;
            }
            $result = $db->query('SELECT COUNT(*) FROM `' . $table . '`;');
            $this->assertEquals(0, (int) $result->fetchColumn());
        }

        // Close database connection
        $db = null;
    }

    /*
     * Test the `create_admin_user` method of the `Installer` class
     * with a username that is too long
     *
     * @depends  testIsInstalled
     * @depends  testInstallDatabase
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
     * @depends  testIsInstalled
     * @depends  testInstallDatabase
     */
    public function test_create_admin_user_invalid_email()
    {
        $this->setExpectedExceptionRegExp('Exception', '/^Invalid email address: /');
        $this->assertEquals(false, Installer::create_admin_user('test_create_admin_user', 'test_create_admin_user', 'test_create_admin_user'));
    }


    /*
     * Test the `create_admin_user` method of the `Installer` class
     *
     * @depends  testIsInstalled
     * @depends  testInstallDatabase
     */
    public function test_create_admin_user()
    {
        $this->assertEquals(true, Installer::create_admin_user('test_create_admin_user', 'test@example.com', 'test_create_admin_user'));

        // Make sure it exists
        try {
            $db = new PDO(
                'mysql:' .
                'host=' . Installer::getSetting('db_host') . ';' .
                'dbname=' . Installer::getSetting('db_name') . ';',
                Installer::getSetting('db_user'),
                Installer::getSetting('db_pass')
            );
        } catch (Exception $e) {
            echo $e . PHP_EOL;
            // Not sure if this is the best way
            // to tell PHPUnit to quit, but it works!
            $this->assertEquals(true, false);
            return;
        }

        $result = $db->query('SELECT COUNT(*) FROM `' . Installer::getSetting('db_prefix') . 'users` WHERE `username` = \'test_create_admin_user\' AND `email` = \'test@example.com\';');

        $result = (int) $result->fetchColumn();
        $this->assertEquals(1, $result);

        // Clear result
        $result = $db->query('DELETE FROM `' . Installer::getSetting('db_prefix') . 'users` WHERE `username` = \'test_create_admin_user\' AND `email` = \'test@example.com\';');

        // Close connection
        $db = null;
    }
}
