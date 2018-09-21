<?php
/**
 * Tests for the DatabaseManager class.
 *
 * Uses phpunit 4.8 (old, but the latest still compatible with php 5.4)
 * Run with `phpunit installer_tests.php` in this directory.
 * Do not run these tests on a live environment, for development purposes only:
 * You will lose your database if you run these!
 *
 * Tests assume your database connection settings in `old/settings.php` are
 * valid.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/mit>
 * @author  World's Tallest Ladder <wtl420@users.noreply.github.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\tests\install;

use LumaSMS\install\DatabaseManager;
use LumaSMS\install\SettingsManager;
use \PHPUnit_Framework_TestCase;
use \InvalidArgumentException;
use \Exception;
use \PDO;

/**
 * DatabaseManager Tests
 */
class DatabaseManagerTests extends PHPUnit_Framework_TestCase
{

    /**
     * @var DatabaseManager The database manager so we don't need to
     *                      recreate this for each test.
     */
    private $databaseManager = null;

    /**
     * @var string The database prefix string, such as `mfgg_`
     */
    private $prefix = '';

    /**
     * Do some setup for the tests.
     */
    public function __construct()
    {
        if (!defined('SETTINGS_FILE')) {
            define(
                'SETTINGS_FILE',
                dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR .
                'old' . DIRECTORY_SEPARATOR .
                'settings.php'
            );
        }
        $settingsManager = new SettingsManager(SETTINGS_FILE);
        $this->databaseManager = new DatabaseManager(
            $settingsManager->getSetting('db_host'),
            $settingsManager->getSetting('db_name'),
            $settingsManager->getSetting('db_user'),
            $settingsManager->getSetting('db_pass'),
            $settingsManager->getSetting('db_prefix')
        );
        $this->prefix = $settingsManager->getSetting('db_prefix');
    }

    /**
     * Applies the database prefix to the given string
     *
     * @param string $name The string to apply the prefix to.
     *
     * @return string The string with the database prefix applied.
     */
    private function applyPrefix($name)
    {
        return $this->prefix . $name;
    }

    /**
     * Test the `isInstalled()` method of the `DatabaseManager` class
     *
     * @return void
     */
    public function testIsInstalled()
    {
        $this->assertInternalType(
            'boolean',
            $this->databaseManager->isInstalled()
        );
    }

    /**
     * Test the `uninstallDatabase()` method of the `DatabaseManager` class.
     *
     * @depends testIsInstalled
     *
     * @return void
     */
    public function testInstallDatabase()
    {
        if ($this->databaseManager->isInstalled()) {
            // Need to uninstall database in order to install it.
            $this->databaseManager->uninstallDatabase();
        }

        $this->assertEquals(true, $this->databaseManager->installDatabase());

        $this->assertEquals(true, $this->databaseManager->isInstalled());
    }

    /**
     * Test the `uninstallDatabase()` method of the `DatabaseManager` class.
     *
     * @depends testInstallDatabase
     * @depends testIsInstalled
     *
     * @return void
     */
    public function testUninstallDatabase()
    {
        if (!$this->databaseManager->isInstalled()) {
            // Need to install database in order to uninstall it.
            $this->databaseManager->installDatabase();
        }

        $this->assertEquals(true, $this->databaseManager->uninstallDatabase());

        $this->assertEquals(false, $this->databaseManager->isInstalled());
    }


    /**
     * Test the `emptyInstall` method of the `Installer` class
     *
     * @depends  testIsInstalled
     * @depends  testInstallDatabase
     *
     * @return void
     */
    public function testEmptyInstall()
    {
        if (!$this->databaseManager->isInstalled()) {
            // Need to install database in order to uninstall it.
            $this->databaseManager->installDatabase();
        }

        $keep_tables = array(
            'filter_group',
            'filter_multi',
            'filter_use',
            'groups',
        );
        foreach ($keep_tables as $key => $table) {
            $keep_tables[$key] = $this->applyPrefix($table);
        }

        $this->assertEquals(true, $this->databaseManager->emptyInstall());

        // To check this we're going to connect to the database on our own.
        $settingsManager = new SettingsManager(SETTINGS_FILE);
        try {
            $database = new PDO(
                'mysql:' .
                'host=' . $settingsManager->getSetting('db_host') . ';' .
                'dbname=' . $settingsManager->getSetting('db_name') . ';',
                $settingsManager->getSetting('db_user'),
                $settingsManager->getSetting('db_pass')
            );
        } catch (Exception $e) {
            echo $e . PHP_EOL;
            // Not sure if this is the best way
            // to tell PHPUnit to quit, but it works!
            $this->assertEquals(true, false);
        }

        $tables = [];
        $result = $database->query(
            'SHOW TABLES LIKE \'' .
            $this->applyPrefix('%') .
            '\';'
        );
        while ($table = $result->fetchColumn()) {
            $tables[] = $table;
        }
        foreach ($tables as $table) {
            if (in_array($table, $keep_tables, true)) {
                continue;
            }
            $result = $database->query("SELECT COUNT(*) FROM `$table`;");
            $this->assertEquals(0, (int) $result->fetchColumn());
        }

        // Close database connection
        $database = null;
    }


    /**
     * Test the `createAdminUser` method of the `DatabaseManager` class
     * with a username that is too long
     *
     * @depends  testIsInstalled
     * @depends  testInstallDatabase
     *
     * @expectedException Exception
     *
     * @return void
     */
    public function testCreateAdminUserLengthyUsername()
    {
        $this->setExpectedException(
            'Exception',
            'Username is too long!'
        );
        $this->assertEquals(
            null,
            $this->databaseManager->createAdminUser(
                '012345678901234567890123456789012345678901234567890',
                'test@example.com',
                'test_create_admin_user'
            )
        );
    }


    /**
     * Test the `createAdminUser` method of the `DatabaseManager` class
     * with an invalid email address
     *
     * @depends  testIsInstalled
     * @depends  testInstallDatabase
     *
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function testCreateAdminUserInvalidEmail()
    {
        $this->setExpectedExceptionRegExp(
            'InvalidArgumentException',
            '/^Invalid email address: /'
        );
        $this->assertEquals(
            null,
            $this->databaseManager->createAdminUser(
                'test_create_admin_user',
                'test_create_admin_user',
                'test_create_admin_user'
            )
        );
    }

    /**
     * Test the `createAdminUser` method of the `DatabaseManager` class
     *
     * @depends  testIsInstalled
     * @depends  testInstallDatabase
     *
     * @return void
     */
    public function testCreateAdminUser()
    {
        $this->assertEquals(
            null,
            $this->databaseManager->createAdminUser(
                'test_create_admin_user',
                'test@example.com',
                'test_create_admin_user'
            )
        );

        // Make sure it exists
        $settingsManager = new SettingsManager(SETTINGS_FILE);
        try {
            $database = new PDO(
                'mysql:' .
                'host=' . $settingsManager->getSetting('db_host') . ';' .
                'dbname=' . $settingsManager->getSetting('db_name') . ';',
                $settingsManager->getSetting('db_user'),
                $settingsManager->getSetting('db_pass')
            );
        } catch (Exception $e) {
            echo $e . PHP_EOL;
            // Not sure if this is the best way
            // to tell PHPUnit to quit, but it works!
            $this->assertEquals(true, false);
        }

        $table = $this->applyPrefix('users');
        $result = $database->query(
            <<<EOT
SELECT COUNT(*) FROM `$table`
WHERE `username` = 'test_create_admin_user'
    AND `email` = 'test@example.com';
EOT
        );

        $this->assertEquals(1, (int) $result->fetchColumn());

        // Clear result
        $result = $database->query(
            <<<EOT
DELETE FROM `$table`
    WHERE `username` = 'test_create_admin_user'
    AND `email` = 'test@example.com';
EOT
        );

        // Close connection
        $database = null;
    }
}
