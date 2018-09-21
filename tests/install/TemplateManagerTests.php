<?php
/**
 * Tests for the TemplateManager class.
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

use LumaSMS\install\TemplateManager;
use \PHPUnit_Framework_TestCase;
use \Exception;

/**
 * TemplateManager Tests
 */
class TemplateManagerTests extends PHPUnit_Framework_TestCase
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
    }

    /**
     * Test the `template()` method of the `TemplateManager` class.
     *
     * @return void
     */
    public function testTemplate()
    {
        $templateManager = new TemplateManager();

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
                $templateManager->template(
                    $testTemplateFile,
                    [ 'test' => 'test' ]
                )
            )
        );

        unlink($testTemplateFile);
    }

    /**
     * Test the `template()` method of the `TemplateManager` class when it throws
     * exceptions of the type Exception.
     *
     * @expectedException Exception
     *
     * @return void
     */
    public function testTemplateException()
    {
        $templateManager = new TemplateManager();

        $testTemplateFile = TEST_DIRECTORY . 'testTemplate.html';

        if (file_exists($testTemplateFile)) {
            unlink($testTemplateFile);
        }

        $this->setExpectedExceptionRegExp(
            'Exception',
            '/^Could not open file: `.*`$/'
        );
        $this->assertEquals(
            '',
            trim(
                $templateManager->template(
                    $testTemplateFile,
                    [ 'test' => 'test' ]
                )
            )
        );
    }
}
