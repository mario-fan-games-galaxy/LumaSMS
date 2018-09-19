<?php
/**
 * Gather information about the environment.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  World's Tallest Ladder <wtl420@users.noreply.github.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

namespace LumaSMS\install;

/**
 * The environment manager class.
 */
class EnvironmentManager
{

    /**
     * @var string The URL, store it here so we don't have to parse it more
     *             than once.
     */
    protected $url = '';

    /**
     * Get the current protocol of the script, such as `https` or `http`.
     *
     * @return string The current protocol the script is running from.
     *                Will return an empty string if it can't be found.
     */
    protected function getProtocol()
    {
        global $_SERVER;

        if (isset($_SERVER)
            && is_array($_SERVER)
            && isset($_SERVER['REQUEST_SCHEME'])
        ) {
            return $_SERVER['REQUEST_SCHEME'];
        }

        return '';
    }

    /**
     * Get the path of the script, seperate from the URL.
     *
     * @return string The path of the script.
     *                Will return an empty string if it can't be found.
     */
    protected function getPath()
    {
        if (isset($_SERVER)
            && isset($_SERVER['REQUEST_URI'])
        ) {
            return $_SERVER['REQUEST_URI'];
        }

        return '';
    }

    /**
     * Get the port of the script.
     *
     * @param string $protocol If the port is the standard for the protocol,
     *                         will return an empty string.
     *
     * @return string The port of the script.
     *                Will return an empty string if it can't be found.
     */
    protected function getPort($protocol)
    {
        global $_SERVER;

        $defaultPort = '';
        switch ($protocol) {
            case 'https':
                $defaultPort = '443';
                break;
            case 'http':
                $defaultPort = '80';
                break;
        }

        if (isset($_SERVER)
            && isset($_SERVER['SERVER_PORT'])
            && $defaultPort !== $_SERVER['SERVER_PORT']
        ) {
            return $_SERVER['SERVER_PORT'];
        }

        return '';
    }

    /**
     * Get the current host of the script.
     *
     * @return string The host of the script.
     *                Will return an empty string if it can't be found.
     */
    protected function getHost()
    {
        global $_SERVER;

        if (isset($_SERVER)
            && is_array($_SERVER)
            && isset($_SERVER['SERVER_NAME'])
        ) {
            return $_SERVER['SERVER_NAME'];
        }

        return '';
    }

    /**
     * Get the current URL of the script.
     *
     * @return string The current URL of the script.
     */
    public function getUrl()
    {
        // Figure out url.
        $host = $this->getHost();
        $protocol = $this->getProtocol();
        if (!$this->url && $host && $protocol) {
            // Build the url.
            $baseUrl = $protocol . '://';
            $baseUrl .= $host;
            $port = $this->getPort($protocol);
            if ($port) {
                $baseUrl .= ':' . $port;
            }

            $this->url = $baseUrl . $this->getPath();
        }

        return $this->url;
    }

    /**
     * Gather some information about the PHP environment. Any information that
     * can not be retrieved is returned as `Unknown` and `compatible` is set to
     * `true`.
     *
     * @return mixed[] Returns an array including version numbers and if the
     *                 version is good to use or not, as well as additional details
     */
    public function getPHPEnvironment()
    {
        // Figure out the PHP environment
        $phpCompatible = version_compare('5.4.16', phpversion(), '<=');
        $phpExtensions = get_loaded_extensions();
        // Not sure if this list is complete, but it's a start
        $requiredExtensions = [
            'Core',
            'date',
            'session',
            'PDO',
            'pdo_mysql',
        ];
        foreach ($requiredExtensions as $extension) {
            $phpCompatible = $phpCompatible &&
                in_array($extension, $phpExtensions, true);
        }

        return [
            'version' => phpversion(),
            'extensions' => $phpExtensions,
            'compatible' => $phpCompatible,
        ];
    }

    /**
     * Gather some information about the PHP environment. Any information that
     * can not be retrieved is returned as `Unknown` and `compatible` is set to
     * `true`.
     *
     * @return mixed[] Returns an array including version numbers and if the
     *                 version is good to use or not, as well as additional details
     */
    public function getMySQLEnvironment()
    {
        // Figure out the MySQL environment, or at least as much as we can
        // before being able to connect
        $mysqlVersion = 'Unknown';
        if (is_callable('shell_exec') && false === mb_stripos(ini_get('disable_functions'), 'shell_exec')) {
            $mysqlVersionString = shell_exec('mysql -V');
            $matches = [];
            preg_match('/[0-9]+\.[0-9]+\.[0-9]+/', $mysqlVersionString, $matches);
            $mysqlVersion = $matches[0];
        };

        return [
            'version' => $mysqlVersion,
            'compatible' => $mysqlVersion === 'Unknown' or
                version_compare('5.5.3', $mysqlVersion, '<=')
        ];
    }

    /**
     * Gather some information about the Webserver environment. Any information
     * that can not be retrieved is returned as `Unknown` and `compatible` is
     * set to `true`.
     *
     * @return mixed[] Returns an array including version numbers and if the
     *                 version is good to use or not, as well as additional details
     */
    public function getWebserverEnvironment()
    {
        global $_SERVER;

        // Figure out webserver information
        $webserverSoftware = 'Unknown';
        $webserverVersion = 'Unknown';
        $webserverOS = 'Unknown';
        if ('cli' !== php_sapi_name() && isset($_SERVER['SERVER_SOFTWARE'])) {
            $matches = [];
            $match = preg_match(
                <<<'EOT'
/^(?'software'[\w ]+)\/(?'version'(?:\d+(?:\.\d+(?:\.\d+)?)?))\s+\((?'OS'[\w ]+)\)/
EOT
                ,
                $_SERVER['SERVER_SOFTWARE'],
                $matches
            );
            if ($match) {
                $webserverSoftware = trim($matches['software']);
                $webserverVersion = trim($matches['version']);
                $webserverOS = trim($matches['OS']);
            }
        }
        return [
            'software' => $webserverSoftware,
            'version' => $webserverVersion,
            'operating_system' => $webserverOS,
            'compatible' => ($webserverSoftware === 'Unknown') or
                ('apache' === mb_strtolower($webserverSoftware)) &&
                    version_compare('2.2', $webserverVersion, '<='),
        ];
    }

    /**
     * Gather some information about the environment. Any information that
     * can not be retrieved is returned as `Unknown` and `compatible` is set to
     * `true`
     *
     * @return mixed[] Returns an array of environment details with each feature
     *                 as a key and an array including version numbers and if the
     *                 version is good to use or not, as well as additional details
     */
    public function getEnvironment()
    {
        return [
            'php' => $this->getPHPEnvironment(),
            'mysql' => $this->getMySQLEnvironment(),
            'webserver' => $this->getWebserverEnvironment(),
        ];
    }
}
