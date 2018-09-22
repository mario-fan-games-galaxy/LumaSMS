<?php
/**
 * Database related functions and classes.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\core;

/**
 * Base database driver class
 */
class DatabaseDriver
{
    /**
     * @var PDO The PDO object for the database.
     */
    protected $database;
}
