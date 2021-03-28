<?php

/**
 * MySQL database driver.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\dbdrivers;

use LumaSMS\core\DatabaseDriver;
use PDO;

/**
 * MySQL database driver.
 */
class MySQLDatabaseDriver extends DatabaseDriver
{

    /**
     * @var PDO Store the database object here.
     */
    protected $database = null;

    /**
     * Constructor
     *
     * Will do a `Fatality` if there is an exception.
     */
    public function __construct()
    {
        $settings = settings();
        try {
            $this->database = new PDO(
                'mysql:hostname=' . $settings['database']['hostname'] .
                ';dbname=' . $settings['database']['dbname'],
                $settings['database']['username'],
                $settings['database']['password']
            );
        } catch (Exception $e) {
            Fatality($e);
        }
    }

    /**
     * Grab the database object directly.
     *
     * @return PDO|null
     */
    public function object()
    {
        return $this->database;
    }
}
