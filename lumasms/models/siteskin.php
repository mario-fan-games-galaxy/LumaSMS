<?php

class SiteSkin extends Model {
    public static
        $primaryKey = 'sid',
        $table = 'tsms_skins'
    ;
    
    public function __construct(){
        $this->set('slug', 'mfgg-default');
    }
}

?>