<?php

class News extends Model {
    public static
        $primaryKey = 'nid',
        $table = 'tsms_news'
    ;
    
    protected $_author = false;
    
    public function author(){
        if(empty($this->_author)){
            $this->_author = User::id($this->f('uid'));
        }
        
        return $this->_author;
    }
    
    public function comments($commentsPage = 1){
        $comments = Comment::paginate(
            [
                'where' => 'type = 2 AND rid = :rid',
            ],
            [
                'rid' => $this->f('nid'),
            ],
            20,
            $commentsPage
        );
        
        return $comments;
    }
    
    public function commentsCount(){
        $comments = Comment::count(
            [
                'where' => 'type = 2 AND rid = :rid',
            ],
            [
                'rid' => $this->f('nid'),
            ],
            20
        );
        
        return $comments;
    }
}

?>