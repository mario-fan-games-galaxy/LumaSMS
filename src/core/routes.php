<?php

/**
 * Route related functions
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

/**
 * Function for easily adding a CRUD controller to the routes
 *
 * @SuppressWarnings(PHPMD.Superglobals)
 *
 * @param string $type CRUD Controller to add to routes.
 *
 * @return void
 */
function CRUDRoute($type)
{
    foreach ([false, 'archive', 'single'] as $method) {
        $controllerMethod = $method;
        if (!$method) {
            $controllerMethod = 'archive';
        }

        $GLOBALS['routes'][$type . ($method ? '/' . $method : '')] = $type . 'Controller@' . $controllerMethod;
    }
}
