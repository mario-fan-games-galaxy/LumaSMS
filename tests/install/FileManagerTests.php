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
use \InvalidArgumentException;
use \Exception;

/**
 * FileManager Tests
 */
class FileManagerTests extends PHPUnit_Framework_TestCase
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
                'tmp' . DIRECTORY_SEPARATOR .
                'tests' . DIRECTORY_SEPARATOR
            );
        }
    }

    /**
     * Test the `fileAccessible()` method of the `FileManager` class.
     *
     * @return void
     */
    public function testFileAccessible()
    {
        $fileManager = new FileManager();

        $this->assertEquals(true, $fileManager->fileAccessible(__FILE__));
        $this->assertEquals(false, $fileManager->fileAccessible('FAKE_FILE'));
    }

    /**
     * Test the `canBeCreated()` method of the `FileManager` class.
     *
     * @return void
     */
    public function testCanBeCreated()
    {
        $fileManager = new FileManager();

        $this->assertEquals(true, $fileManager->canBeCreated(TEST_DIRECTORY));
        $this->assertEquals(false, $fileManager->canBeCreated('/'));
    }

    /**
     * Test the `copyFile()` method of the `FileManager` class.
     *
     * @return void
     */
    public function testCopyFile()
    {

        $fileManager = new FileManager();

        $testFile = TEST_DIRECTORY . basename(__FILE__);

        $this->assertEquals(true, $fileManager->copyFile(__FILE__, $testFile));

        unlink($testFile);
    }

    /**
     * Test the `copyFile()` method of the `FileManager` class when it throws
     * exceptions of the type InvalidArgumentException.
     *
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function testCopyFileInvalidArgumentException()
    {

        $fileManager = new FileManager();

        $this->assertEquals(false, $fileManager->copyFile('', TEST_DIRECTORY));
        $this->assertEquals(false, $fileManager->copyFile(__FILE__, ''));

        $testFile = TEST_DIRECTORY . basename(__FILE__);
        $fileManager->copyFile(__FILE__, $testFile);
        chmod($testFile, 0220);
        $this->assertEquals(false, $fileManager->copyFile($testFile, $testFile));
        $this->assertEquals(false, $fileManager->copyFile(__FILE__, __FILE__));
    }

    /**
     * Test the `copyFile()` method of the `FileManager` class when it throws
     * exceptions of the type Exception.
     *
     * @expectedException Exception
     *
     * @return void
     */
    public function testCopyFileException()
    {

        $fileManager = new FileManager();

        $this->assertEquals(
            false,
            $fileManager->copyFile(__FILE__, '/' . basename(__FILE__))
        );

        // Not sure how to test when there's an issue copying a file over.
        // But if I figure that out, that would go here.
    }
}
