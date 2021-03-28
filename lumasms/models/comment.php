<?php

class Comment extends Model {
    public static
        $primaryKey = 'cid',
        $table = 'tsms_comments'
    ;
    
    protected $author = false;
    
    private static function abstractResource($func, $sql, $params){
        $sql = [
            'where' => 'type = :type AND rid = :rid',
        ];
        
        $params = [
            'type' => $type,
            'rid' => $rid,
        ];
        
        $comments = Comment::$func(
            $sql,
            $params,
            20,
            $commentsPage
        );
    }
    
    public static function resource($type, $rid, $commentsPage){
        
    }
    
    public function author(){
        if(empty($this->_author)){
            $this->_author = User::id($this->f('uid'));
        }
        
        return $this->_author;
    }
}

?>