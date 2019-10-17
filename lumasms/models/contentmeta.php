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
    
    public function file(){
        if(empty($file = $this->f('file'))){
            return '';
        }
        
        $path = 'file/' . $this->type . '/' . $file;
        
        return $path;
    }
    
    public function thumbnail(){
        if(empty($thumbnail = $this->f('thumbnail'))){
            return '';
        }
        
        $path = 'thumbnail/' . $this->type . '/' . $thumbnail;
        
        if(!file_exists($path)){
            $thumbnailImg = file_get_contents('https://mfgg.net/' . $path);
            
            file_put_contents($path, $thumbnailImg);
        }
        
        return $path;
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
    
    public function commentsCount(){
        return Comment::count(
            [
                'where' => 'type = 1 AND rid = :rid',
            ],
            [
                'rid' => $this->content->f('rid'),
            ]
        );
    }
}

?>