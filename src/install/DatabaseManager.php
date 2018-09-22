<?php
/**
 * Database class for handling installer database functions.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  World's Tallest Ladder <wtl420@users.noreply.github.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\install;

use \InvalidArgumentException;
use \Exception;
use \PDO;

/**
 * This handles the database functionality for the installer.
 */
class DatabaseManager
{

    /**
     * @var PDO The PDO database object.
     */
    protected $database = null;

    /**
     * @var string The database prefix string, such as `mfgg_`
     */
    protected $prefix = '';

    /**
     * Constructor for the DatabaseManager
     *
     * @param string $host     The database host, such as `127.0.0.1`.
     * @param string $database The database name, such as `mfgg`.
     * @param string $username The username of the database user, such as `admin`.
     * @param string $password The password of the database user, such as `hunter2`.
     * @param string $prefix   The table prefix for database tables, such as `mfgg_`.
     *                         This is optional.
     *
     * @throws Exception If there was an error connecting to the database.
     *
     */
    public function __construct($host, $database, $username, $password, $prefix = '')
    {
        try {
            $this->database = new PDO(
                'mysql:' .
                'host=' . $host . ';' .
                'dbname=' . $database . ';',
                $username,
                $password
            );
        } catch (Exception $e) {
            // Couldn't connect!
            throw $e;
        }

        if (is_string($prefix) && 0 < mb_strlen($prefix)) {
            $this->prefix = $prefix;
        }
    }

    /**
     * Applies the database prefix to the given string
     *
     * @param string $name The string to apply the prefix to.
     *
     * @return string The string with the database prefix applied.
     */
    protected function applyPrefix($name)
    {
        return $this->prefix . $name;
    }

    /**
     * Get a complete list of tables that should exist in the database
     * if the application is installed. Includes the database prefix.
     *
     * @return string[] An array of the name of each table in the database
     */
    protected function getTables()
    {
        $noPrefixTables = array(
            'admin_msg',
            'comments',
            'filter_group',
            'filter_list',
            'filter_multi',
            'filter_use',
            'forums',
            'groups',
            'login_attempts',
            'mail_log',
            'messages',
            'modules',
            'news',
            'panels',
            'posts',
            'resources',
            'res_games',
            'res_gfx',
            'res_howtos',
            'res_misc',
            'res_reviews',
            'res_sounds',
            'sec_images',
            'sessions',
            'skins',
            'staffchat',
            'topics',
            'users',
            'version',
        );

        // Add the database prefix
        $tables = array();
        foreach ($noPrefixTables as $table) {
            $tables[] = $this->applyPrefix($table);
        }

        return $tables;
    }

    /**
     * Import MySQL files using PHP
     * Adapted from https://stackoverflow.com/a/19752106
     *
     * @param string $filename The filename you wish to import. Include the full path.
     *
     * @throws InvalidArgumentException If the file can not be read.
     * @throws Exception If there's an issue connecting to the database.
     * @throws Exception If a query in the file has a problem executing.
     *
     * @return boolean `true` on success, `false` on failure.
     */
    protected function importMySQLFile($filename)
    {
        $fileManager = new FileManager();

        if (!$fileManager->fileAccessible($filename)) {
            throw new InvalidArgumentException('File cannot be read: `' . $filename . '`');
            return false;
        }

        $tempLine = '';

        $filePointer = fopen($filename, 'r');
        if ($filePointer) {
            while (!feof($filePointer)) {
                $line = trim(fgets($filePointer));
                if ('' === $line) {
                    continue;
                }
                // Skip it if it's a comment
                if ('--' === mb_substr($line, 0, 2)) {
                    continue;
                }

                $tempLine .= ' ' . $line;
                if (mb_substr($line, -1, 1) == ';') {
                    $tempLine = str_replace('`tsms_', '`' . $this->prefix, $tempLine);
                    if (!$this->database->query($tempLine)) {
                        throw new Exception('Could not execute query: ' . $tempLine);
                        return false;
                    }
                    $tempLine = '';
                }
            }
            fclose($filePointer);
        }

        return true;
    }

    /**
     * Uninstalls the database.
     *
     * @return boolean True if it worked, false if it didn't.
     */
    public function uninstallDatabase()
    {
        foreach ($this->getTables() as $table) {
            $this->database->query('DROP TABLE IF EXISTS `' . $table . '`;');
        }

        return !$this->isInstalled();
    }


    /**
     * Imports the database files.
     *
     * @throws Exception If there is an issue importing a mysql file, see
     *                   `Installer::importMySQLFile` for more details.
     *
     * @return boolean True if it worked, false if it didn't.
     */
    public function installDatabase()
    {
        $mysqlFiles = [];
        $sqlContents = scandir(__DIR__ . DIRECTORY_SEPARATOR . 'sql');
        foreach ($sqlContents as $item) {
            if ('.sql' === mb_substr($item, -4, 4)) {
                $mysqlFiles[] = __DIR__ . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . $item;
            }
        }

        sort($sqlContents);

        foreach ($mysqlFiles as $file) {
            try {
                if (!$this->importMySQLFile($file)) {
                    return false;
                }
            } catch (Exception $e) {
                throw $e;
            }
        }

        return $this->isInstalled();
    }


    /**
     * Clear the database of sample data
     *
     * @throws Exception If there is an issue connecting to the database.
     * @throws Exception If there is an issue clearing a table.
     *
     * @return boolean `true` if data was removed successfully.
     */
    public function emptyInstall()
    {
        $keepTables = array(
            'filter_group',
            'filter_multi',
            'filter_use',
            'groups',
        );
        foreach ($keepTables as $key => $table) {
            $keepTables[$key] = $this->applyPrefix($table);
        }
        $tables = $this->getTables();

        foreach ($tables as $table) {
            if (in_array($table, $keepTables, true)) {
                continue;
            }
            if (!$this->database->query('TRUNCATE TABLE `' . $table . '`;')) {
                throw new Exception('There was an issue truncating table `' . $table . '`');
            };
        }

        return true;
    }


    /**
     * Create an admin user, typically the site owner
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     *
     * @param string $username The username of the new user.
     * @param string $email    The email address of the new user.
     * @param string $password The password of the new user.
     *
     * @throws InvalidArgumentException If the username or email is invalid.
     * @throws Exception                If there is an issue adding the user to
     *                                  the database.
     *
     * @return void
     */
    public function createAdminUser($username, $email, $password)
    {
        $ipAddress = isset($_SERVER['REMOTE_ADDR']) ?
            $_SERVER['REMOTE_ADDR'] : '127.0.0.1';

        if (mb_strlen($username) > 32) {
            throw new InvalidArgumentException('Username is too long!');
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email address: ' . $email);
            return;
        }
        $user = array(
            'gid' => 1,
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'join_date' => time(),
            'last_activity' => time(),
            'last_visit' => time(),
            'registered_ip' => $ipAddress,
            'last_ip' => $ipAddress,
        );

        try {
            $create = $this->database->prepare('INSERT INTO `' .
                $this->applyPrefix('users') .
                <<<'EOT'
` (
    `gid`,
    `username`,
    `email`,
    `password`,
    `join_date`,
    `last_activity`,
    `last_visit`,
    `registered_ip`,
    `last_ip`
) VALUES (
    :gid,
    :username,
    :email,
    :password,
    :join_date,
    :last_activity,
    :last_visit,
    :registered_ip,
    :last_ip
);
EOT
            );
            foreach ($user as $setting => $value) {
                $create->bindValue(':' . $setting, $value);
            }
            $create->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Check if the databse is installed already or not
     *
     * @throws Exception If there is an issue checking if a table is there.
     *
     * @return boolean True if the application is installed, false otherwise.
     */
    public function isInstalled()
    {
        // If connected, check for tables
        foreach ($this->getTables() as $table) {
            // This can throw an exception
            try {
                $result = $this->database->query('SELECT 1 FROM `' . $table . '` LIMIT 1');
            } catch (Exception $e) {
                throw $e;
                return false;
            }
            // Result should be `false` if table does not exist
            if (!$result) {
                return false;
            }
        }

        return true;
    }
}
