<?php

class SpriteMeta extends Model {
    public static
        $primaryKey = 'eid',
        $table = 'tsms_res_gfx'
    ;
    
    public $content = false;
    
    public function load(){
        $content = @Content::first(
            [ 'where' => 'eid = :eid AND type = 1', ],
            [ 'eid' => $this->f('eid'), ]
        );
        
        if(!$content->f('rid')){
            return;
        }
        
        $this->content = $content;
    }
}

?>