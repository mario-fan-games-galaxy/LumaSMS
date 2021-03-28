<?php

/**
 * Tests for the SettingsManager class.
 *
 * Uses phpunit 4.8 (old, but the latest still compatible with php 5.4)
 * Run with `phpunit installer_tests.php` in this directory.
 * Do not run these tests on a live environment, for development purposes only:
 * You will lose your database if you run these!
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/mit>
 * @author  World's Tallest Ladder <wtl420@users.noreply.github.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\tests\install;

use LumaSMS\install\SettingsManager;
use Exception;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

/**
 * SettingsManager Tests
 */
class SettingsManagerTests extends PHPUnit_Framework_TestCase
{

    /**
     * Do some setup for the tests.
     */
    public function __construct()
    {
        if (!defined('TEST_DIRECTORY')) {
            define(
                'TEST_DIRECTORY',
                dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR .
                'var' . DIRECTORY_SEPARATOR .
                'tests' . DIRECTORY_SEPARATOR
            );
        }
        if (!defined('TEST_SETTINGS_FILE')) {
            define(
                'TEST_SETTINGS_FILE',
                TEST_DIRECTORY . 'config.yaml'
            );
        }
    }

    /**
     * Test the `createSettingsFile()` method of the `SettingsManager` class.
     *
     * @return void
     */
    public function testCreateSettingsFile()
    {
        $settingsManager = new SettingsManager(TEST_SETTINGS_FILE);

        $this->assertEquals(
            true,
            $settingsManager->createSettingsFile()
        );

        $this->assertEquals(
            true,
            file_exists(TEST_SETTINGS_FILE)
        );
    }

    /**
     * Test the `getSetting()` method of the `SettingsManager` class.
     *
     * @return void
     */
    public function testGetSetting()
    {
        $settingsManager = new SettingsManager(TEST_SETTINGS_FILE);

        // This one's always true.
        $this->assertEquals(
            true,
            $settingsManager->getSetting('session_hotlink_protection')
        );
    }

    /**
     * Test the `getSetting()` method of the `SettingsManager` class when it throws
     * exceptions of the type Exception.
     *
     * @expectedException Exception
     *
     * @return void
     */
    public function testGetSettingException()
    {
        $settingsManager = new SettingsManager(TEST_SETTINGS_FILE);

        $this->setExpectedException(
            'Exception',
            'Could not read settings!'
        );
        $this->assertEquals(
            null,
            $settingsManager->getSetting('test_fake_setting_1998')
        );
    }

    /**
     * Test the `updateSetting()` method of the `SettingsManager` class.
     *
     * @return void
     */
    public function testUpdateSetting()
    {
        $settingsManager = new SettingsManager(TEST_SETTINGS_FILE);

        // Try updating a real setting
        $originalValue = $settingsManager->getSetting(
            'thumbnail_directory'
        );

        $result = $settingsManager->updateSetting(
            'thumbnail_directory',
            'TEST'
        );
        $this->assertEquals(true, $result);
        $this->assertEquals(
            'TEST',
            $settingsManager->getSetting('thumbnail_directory')
        );

        // Revert the change and make sure it saved
        $result = $settingsManager->updateSetting(
            'thumbnail_directory',
            $originalValue
        );
        $this->assertEquals(true, $result);
        $this->assertEquals(
            $originalValue,
            $settingsManager->getSetting('thumbnail_directory')
        );
    }

    /**
     * Test the `updateSetting()` method of the `SettingsManager` class when it throws
     * exceptions of the type InvalidArgumentException.
     *
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function testUpdateSettingInvalidArgumentException()
    {
        $settingsManager = new SettingsManager(TEST_SETTINGS_FILE);

        $this->setExpectedException(
            'InvalidArgumentException',
            'Setting not found.'
        );
        $this->assertEquals(
            false,
            $settingsManager->updateSetting('test_fake_setting_1998', false)
        );

        $this->setExpectedExceptionRegExp(
            'InvalidArgumentException',
            '/^Invalid value for setting: `.*`$/'
        );
        $this->assertEquals(
            false,
            $settingsManager->updateSetting(
                'session_hotlink_protection',
                (new \stdClass())
            )
        );
    }

    /**
     * Test the `updateSetting()` method of the `SettingsManager` class when it throws
     * exceptions of the type Exception.
     *
     * @return void
     */
    public function testUpdateSettingException()
    {
        // If I come up with a way to test if `TEST_SETTINGS_FILE` cannot be
        // read or written to, do it here.
    }

    /**
     * Do some cleanup after the tests.
     */
    public function __destruct()
    {
        if (file_exists(TEST_SETTINGS_FILE)) {
            unlink(TEST_SETTINGS_FILE);
        }
    }
}
