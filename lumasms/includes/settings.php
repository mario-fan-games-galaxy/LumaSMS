<?php

// For easy getting
function S(){
    return $GLOBALS['_SETTINGS'];
}

$_SETTINGS = Spyc::YAMLLoad('settings.yaml');

?>