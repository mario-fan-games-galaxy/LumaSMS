<?php

function view($___lumasms__view, $__lumasms__view__params = []){
    $___lumasms__view = 'views/' . $___lumasms__view . '.php';
    
    if(!file_exists($___lumasms__view)){
        return false;
    }
    
    extract($__lumasms__view__params);
    
    ob_start();
    
    include $___lumasms__view;
    
    return ob_get_clean();
}

?>