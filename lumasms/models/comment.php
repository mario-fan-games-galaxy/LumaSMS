<?php

class Comment extends Model {
    public static
        $primaryKey = 'cid',
        $table = 'tsms_comments'
    ;
    
    protected $author = false;
    
    public function author(){
        if(empty($this->_author)){
            $this->_author = User::id($this->f('uid'));
        }
        
        return $this->_author;
    }
}

?>