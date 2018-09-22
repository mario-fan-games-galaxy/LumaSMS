<?php
/**
 * Utility functions.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

/**
 * Easy access to the global database object.
 *
 * @SuppressWarnings(PHPMD.Superglobals)
 *
 * @return DatabaseDriver|null The PDO object for the database, or null.
 */
function database()
{
    if (isset($GLOBALS['database'])) {
        return $GLOBALS['database'];
    }
    return null;
}

/**
 * Use this if you ever need to suddenly kill because of a fatal error
 *
 * @author  HylianDev <supergoombario@gmail.com>
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 *
 * @param Exception $exception The exception, or just a log string, This gets
 *                             added to the `fatality.log`. There is no other
 *                             information except for the date.
 * @return void
 */
function Fatality(Exception $exception)
{
    $errorlog = APP_LOGS . DIRECTORY_SEPARATOR .
        'fatality.log';

    if (!file_exists($errorlog)) {
        file_put_contents($errorlog, '');
    }

    file_put_contents(
        $errorlog,
        file_get_contents($errorlog) .
        '[ ' . date('m/d/Y g:i:sa', time()) . ' ]' . PHP_EOL . $exception . PHP_EOL . PHP_EOL
    );

    die('<h1>FATAL ERROR</h1>');
}

/**
 * Returns a print_r string warapped in a <pre> tag for all of the parameters
 *
 * @SuppressWarnings(PHPMD.DevelopmentCodeFragment)
 *
 * @return string
 */
function debug()
{
    ob_start();

    foreach (func_get_args() as $arg) {
        echo '<pre>' . print_r($arg, true) . '</pre>';
    }

    return ob_get_clean();
}

/**
 * Echo this any time you show a date
 *
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 *
 * @param integer $date           Unix timestamp.
 * @param string  $displaySetting Override for the date display setting.
 *
 * @return string
 */
function showDate($date, $displaySetting = null)
{
    if (empty($date) || !is_numeric($date)) {
        $date = 0;
    }

    if ($displaySetting == null) {
        $displaySetting = 'since';
    }

    switch ($displaySetting) {
        case 'date':
            $date = date(
                'm/d/Y g:i:sa',
                $date
            );
            break;

        case 'since':
            $date = time() - $date;

            $suffixes = [
                0 => 'second',
                60 => 'minute',
                (60 * 60) => 'hour',
                (60 * 60 * 24) => 'day',
                (60 * 60 * 24 * 7) => 'week',
                (60 * 60 * 24 * 365) => 'year'
            ];

            foreach ($suffixes as $key => $value) {
                if (abs($date) < $key) {
                    break;
                }

                $val = abs($date);
                if ($key != 0) {
                    $val = floor(abs($date) / $key);
                }

                $dateString = $val . ' ' . $value;

                if ($val != 1) {
                    $dateString .= 's';
                }

                if ($date > 0) {
                    $dateString .= ' ago';
                } elseif ($date < 0) {
                    $dateString .= ' from now';
                }

                $dateString = '<span class="countdown-container" data-timer="' .
                    - $date . '">' . $dateString . '</span>';
            }

            $date = $dateString;
            break;
    }

    return $date;
}

/**
 * Turn a formatted string into a URL-frindly string
 *
 * @param string $title The title to slugify.
 *
 * @return string The title, slugified.
 */
function titleToSlug($title)
{
    $title = preg_replace('/&(.)+;/U', '', $title);
    $title = preg_replace('/[^a-zA-Z0-9 ]/', '', $title);
    $title = str_replace(' ', '-', $title);
    $title = mb_strtolower($title);
    $title = mb_substr($title, 0, 50);

    return $title;
}

/**
 * Put this at the beginning of any on-site links. Returns the domain and directory
 *
 * @SuppressWarnings(PHPMD.Superglobals)
 *
 * @return string
 */
function url()
{
    $url = 'http';

    if (!empty($_SERVER['HTTPS'])) {
        $url .= 's';
    }

    $url .= '://';

    $url .= $_SERVER['SERVER_NAME'];

    $self = explode('/index.php', $_SERVER['SCRIPT_NAME']);

    $url .= array_shift($self);

    return $url;
}

/**
 * Write a string a specified number of times. Used for putting ?s in prepared queries
 *
 * @param string  $string  The string to repead.
 * @param integer $count   The number of times to repeat it.
 * @param string  $divider The divider. Default ", ".
 *
 * @return return string
 */
function writeNTimes($string, $count, $divider = ', ')
{
    $ret = [];

    for ($i = 0; $i < $count; $i++) {
        $ret[] = $string;
    }

    return implode($divider, $ret);
}
