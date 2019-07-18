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
    
    public function comments($commentsPage){
        $comments = Comment::paginate(
            [
                'where' => 'type = 1 AND rid = :rid',
            ],
            [
                'rid' => $this->content->f('rid'),
            ],
            20,
            $commentsPage
        );
        
        return $comments;
    }
}

?>