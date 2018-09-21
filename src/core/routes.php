<?php

/**
 * Function for easily adding a CRUD controller to the routes
 *
 * @param string $type CRUD Controller to add to routes
 * @return void
 */
function CRUDRoute($type)
{
    foreach ([
        false,
        'archive',
        'single'
    ] as $method) {
        if ($method == false) {
            $_method = 'archive';
        } else {
            $_method = $method;
        }
        
        $GLOBALS['routes'][$type . ($method ? '/' . $method : '')] = $type . 'Controller@' . $_method;
    }
}

/**
 * An associative array that corresponds to URI requests
 *
 * The value should be the desired controller @ the desired method within that controller
 */
$routes = [
    'users/staff' => 'UsersController@staff'
];

foreach ([
    'updates',
    'sprites',
    'games',
    'sounds',
    'howtos',
    'misc'
] as $crud) {
    CRUDRoute($crud);
}
