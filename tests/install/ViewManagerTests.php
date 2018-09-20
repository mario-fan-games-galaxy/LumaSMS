<?php
/**
 * Tests for the ViewManager class.
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

use LumaSMS\install\ViewManager;
use \PHPUnit_Framework_TestCase;
use \Exception;

/**
 * ViewManager Tests
 */
class ViewManagerTests extends PHPUnit_Framework_TestCase
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
     * Test the `template()` method of the `ViewManager` class.
     *
     * @return void
     */
    public function testTemplate()
    {
        $viewManager = new ViewManager();

        $testTemplateFile = TEST_DIRECTORY . 'testTemplate.html';

        if (!file_exists($testTemplateFile)) {
            file_put_contents(
                $testTemplateFile,
                '{{ test }}'
            );
        }

        $this->assertEquals(
            'test',
            trim(
                $viewManager->template(
                    $testTemplateFile,
                    [ 'test' => 'test' ]
                )
            )
        );

        unlink($testTemplateFile);
    }

    /**
     * Test the `template()` method of the `ViewManager` class when it throws
     * exceptions of the type Exception.
     *
     * @expectedException Exception
     *
     * @return void
     */
    public function testTemplateException()
    {
        $viewManager = new ViewManager();

        $testTemplateFile = TEST_DIRECTORY . 'testTemplate.html';

        if (file_exists($testTemplateFile)) {
            unlink($testTemplateFile);
        }

        $this->assertEquals(
            '',
            trim(
                $viewManager->template(
                    $testTemplateFile,
                    [ 'test' => 'test' ]
                )
            )
        );
    }
}
