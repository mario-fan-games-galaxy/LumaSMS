<?php

class ContentMeta extends Model {
    public static $primaryKey = 'eid';
    
    public $content = false;
    
    public function load(){
        $content = @Content::first(
            [ 'where' => 'eid = :eid AND type = ' . $this->type, ],
            [ 'eid' => $this->f('eid'), ]
        );
        
        if(!$content->f('rid')){
            return;
        }
        
        $this->content = $content;
    }
}

?>