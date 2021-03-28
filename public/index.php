<?php

/**
 * Main router.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @author  World's Tallest Ladder <wtl420@users.noreply.github.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

// Load the autoloader first.
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .
    'src' . DIRECTORY_SEPARATOR .
    'autoload.php';

use LumaSMS\controllers\InformationController;

/*
 * Pull in all the important system files
 *
 * It searches every file in these directories for PHP files, then requires them if they aren't already included
 *
 * It does NOT search directories recursively
 */
foreach (
    [
    'core',
    'dbdrivers',
    'controllers',
    'models'
    ] as $directory
) {
    $directory = APP_SRC . DIRECTORY_SEPARATOR . $directory;
    $directoryContents = scandir($directory);

    foreach ($directoryContents as $file) {
        $file = $directory . DIRECTORY_SEPARATOR . $file;
        $fileExtension = mb_strtolower(pathinfo($file, PATHINFO_EXTENSION));

        if (is_dir($file) || $fileExtension !== 'php') {
            continue;
        }

        require_once $file;
    }
}

/*
 * Initialize the database connection
 *
 * It creates an instance of whatever database driver is defined in Settings
 */
$database = settings()['database']['driver'];
$database = 'LumaSMS\dbdrivers\\' . $database;
$database = new $database();

/*
 * An associative array that corresponds to URI requests
 *
 * The value should be the desired controller @ the desired method
 * within that controller
 */
$GLOBALS['routes'] = [
    'users/staff' => 'UsersController@staff'
];

foreach (
    [
    'updates',
    'sprites',
    'games',
    'sounds',
    'howtos',
    'misc'
    ] as $crud
) {
    CRUDRoute($crud);
}
/*
 * Get the route
 *
 * The parameter is placed there by the htaccess and includes everything after the root diretory in the URL
 *
 * Then, we look through the $routes associative array for a key that matches the uri
 *
 * We start with all of the parameters, then slowly peel them away until we make a match
 *
 * For example, if you visit /updates/view/1/ then we see if there's a view for:
 * updates/view/1, then updates/view, then just updates
 *
 * This is so that a generic /updates/ route that leads to the archive wouldn't take precedence over /updates/view/
 */
$route = '';
if (isset($_SERVER['REQUEST_URI'])) {
    $route = ltrim($_SERVER['REQUEST_URI'], '/');
}
if (!$route) {
    $route = 'updates/archive';
}
$route = explode('/', $route);

$controllerUse = false;
$finalRoute = '';
$params = [];

do {
    $_route = implode('/', $route);

    if (!empty($routes[$_route])) {
        $controllerUse = $routes[$_route];
        $finalRoute = $_route;
    } else {
        $params[] = array_pop($route);
    }
} while (count($route) && empty($controllerUse));
$params = array_reverse($params);

/*
 * Now that we have a controller + method combo (or have tried our best to
 * find one), Initialize the controller (or, if it doesn't exist or doesn't
 * have that method, use an error page controller + method)
 *
 * Then, we use ob_start() and ob_get_clean() to turn the output of that
 * method into a string we can echo in our template later
 *
 * We do it this way because that means the page is completely done and
 * finalized before we ever output anything to the user
 *
 * If we decide to do a Fatality(), it won't show half of the page
 */
$controller = explode('@', $controllerUse);
$method = array_pop($controller);
$controller = 'LumaSMS\controllers\\' . ucfirst(array_shift($controller));
$yield = '';

if (
    !class_exists($controller)
    ||
    !($controller = new $controller())
    ||
    !method_exists($controller, $method)
) {
    $controller = new InformationController();
    $method = 'error404';
}

ob_start();

$controller->$method();

$yield = ob_get_clean();

/**
 * Finally, require the template and show the page
 */
require_once APP_TEMPLATES . DIRECTORY_SEPARATOR . 'template.php';
