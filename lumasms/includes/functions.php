<?php

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