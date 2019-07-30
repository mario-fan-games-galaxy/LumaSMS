<?php

function baseHref(){
    $domain = 'http' . (empty($_SERVER['HTTPS']) ? '' : 's') . '://' . $_SERVER['SERVER_NAME'];
    
    $uri = explode('index.php', $_SERVER['SCRIPT_NAME']);
    $uri = array_shift($uri);
    
    return $domain . $uri;
}

function debug(){
    ob_start();
    
    echo '<pre>';
    
    foreach(func_get_args() as $arg){
        echo print_r($arg, true);
    }
    
    echo '</pre>';
    
    return ob_get_clean();
}

?>