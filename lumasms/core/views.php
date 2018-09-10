<?php

/**
 * Returns the output of the view
 *
 * @param string $_____file The path to the view inside of ./views/ (the variable is called that so $vars doesn't conflict)
 * @param array  $vars      An associative array of variables that you want to be local to the template
 * @return string The output of the view
 */
function view($_____file, $vars = [])
{
    $_____file = 'views/' . $_____file . '.php';
    
    if (!file_exists($_____file)) {
        return false;
    }
    
    extract($vars);
    
    ob_start();
    
    include $_____file;
    
    return ob_get_clean();
}
