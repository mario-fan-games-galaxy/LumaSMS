<?php
/**
 * Tests for the EnviornmentManager class.
 *
 * Uses phpunit 4.8 (old, but the latest still compatible with php 5.4)
 * Run with `phpunit installer_tests.php` in this directory.
 * Do not run these tests on a live environment, for development purposes only:
 * You will lose your database if you run these!
 *
 * Tests assume your database connection settings in `settings.php` are valid
 * (other settings will be overwritten).
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/mit>
 * @author  World's Tallest Ladder <wtl420@users.noreply.github.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\tests\install;

use LumaSMS\install\EnvironmentManager;
use \PHPUnit_Framework_TestCase;

/**
 * EnvironmentManager Tests
 */
class EnvironmentManagerTests extends PHPUnit_Framework_TestCase
{

    /**
     * Test the `getUrl()` method of the `EnvironmentManager` class
     *
     * @return void
     */
    public function testGetUrl()
    {
        $environmentManager = new EnvironmentManager();
        $url = $environmentManager->getUrl();

        $this->assertInternalType('string', $url);
        $this->assertSame('', $url);

        global $_SERVER;

        $_SERVER['REQUEST_SCHEME'] = 'https';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['SERVER_PORT'] = '443';
        $_SERVER['REQUEST_URI'] = '/';

        $url = $environmentManager->getUrl();
        $this->assertInternalType('string', $url);
        $this->assertSame('https://localhost/', $url);

        $environmentManager = new EnvironmentManager();

        $_SERVER['REQUEST_SCHEME'] = 'http';

        $url = $environmentManager->getUrl();
        $this->assertInternalType('string', $url);
        $this->assertSame('http://localhost:443/', $url);
    }

    /**
     * Test the `getPHPEnvironment()` method of the `EnvironmentManager` class
     *
     * @return void
     */
    public function testGetPHPEnvironment()
    {
        $environmentManager = new EnvironmentManager();
        $environment = $environmentManager->getPHPEnvironment();

        // Make sure PHP information is gathered.
        $this->assertInternalType('array', $environment);
        $this->assertCount(3, $environment);
        $this->assertArrayHasKey('version', $environment);
        $this->assertRegExp('/^\d+(?:\.\d+(?:\.\d+)?)?/', $environment['version']);
        $this->assertInternalType('string', $environment['version']);
        $this->assertArrayHasKey('compatible', $environment);
        $this->assertInternalType('boolean', $environment['compatible']);
        $this->assertArrayHasKey('extensions', $environment);
        $this->assertInternalType('array', $environment['extensions']);
        $this->assertContains('Core', $environment['extensions']);
    }

    /**
     * Test the `getMySQLEnvironment()` method of the `EnvironmentManager` class
     *
     * @return void
     */
    public function testGetMySQLEnvironment()
    {
        $environmentManager = new EnvironmentManager();
        $environment = $environmentManager->getMySQLEnvironment();

        // Make sure MySQL information is gathered.
        $this->assertInternalType('array', $environment);
        $this->assertCount(2, $environment);
        $this->assertArrayHasKey('version', $environment);
        $this->assertInternalType('string', $environment['version']);
        $this->assertRegExp('/^(?:\d+(?:\.\d+(?:\.\d+)?)?|Unknown$)/', $environment['version']);
        $this->assertArrayHasKey('compatible', $environment);
        $this->assertInternalType('boolean', $environment['compatible']);
    }

    /**
     * Test the `getWebserverEnvironment()` method of the `EnvironmentManager` class
     *
     * @return void
     */
    public function testGetWebserverEnvironment()
    {
        $environmentManager = new EnvironmentManager();
        $environment = $environmentManager->getWebserverEnvironment();

        // Make sure Webserver information is gathered.
        $this->assertInternalType('array', $environment);
        $this->assertCount(4, $environment);
        $this->assertArrayHasKey('software', $environment);
        $this->assertInternalType('string', $environment['software']);
        $this->assertArrayHasKey('operating_system', $environment);
        $this->assertInternalType('string', $environment['operating_system']);
        $this->assertArrayHasKey('version', $environment);
        $this->assertInternalType('string', $environment['version']);
        $this->assertRegExp('/^(?:\d+(?:\.\d+(?:\.\d+)?)?|Unknown$)/', $environment['version']);
        $this->assertArrayHasKey('compatible', $environment);
        $this->assertInternalType('boolean', $environment['compatible']);
    }


    /**
     * Test the `getEnvironment()` method of the `EnvironmentManager` class
     *
     * @return void
     */
    public function testGetEnvironment()
    {
        $environmentManager = new EnvironmentManager();
        $environment = $environmentManager->getEnvironment();

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

        // Make sure Webserver information is gathered
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
}
