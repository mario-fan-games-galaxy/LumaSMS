<?php
/**
 * Tests for the FileManager class.
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

use LumaSMS\install\FileManager;
use \PHPUnit_Framework_TestCase;

/**
 * FileManager Tests
 */
class FileManagerTests extends PHPUnit_Framework_TestCase
{

    /**
     * Test the `fileAccessible()` method of the `FileManager` class.
     *
     * @return void
     */
    public function testFileAccessible()
    {
    }

    /**
     * Test the `canBeCreated()` method of the `FileManager` class.
     *
     * @return void
     */
    public function testCanBeCreated()
    {
    }

    /**
     * Test the `copyFile()` method of the `FileManager` class.
     *
     * @return void
     */
    public function testCopyFile()
    {
    }
}
