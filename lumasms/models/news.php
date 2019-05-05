<?php

class News extends Model {
    public static
        $primaryKey = 'nid',
        $table = 'tsms_news'
    ;
    
    private $_author = false;
    
    public function author(){
        if(empty($this->_author)){
            $this->_author = User::id($this->f('uid'));
        }
        
        return $this->_author;
    }
}

?>