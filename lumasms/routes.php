<?php

function getRoute($route){
    foreach($GLOBALS['routes'] as $key => $value){
        preg_match(
            $key,
            $route,
            $matches
        );
        
        if(empty($matches)){
            continue;
        }
        
        array_shift($matches);
        
        return call_user_func_array($value, $matches);
    }
    
    http_response_code(404);
    return '404';
}

$routes = [
    // News
    '/^$/' => function(){
        return getRoute('news/page/1');
    },
    
    '/^news\/page\/([0-9]+)$/' => function($page){
        $news = News::paginate(['order'=>'nid desc'], [], 20, $page);
        
        return view('news/archive', [
            'news' => $news,
        ]);
    },
    
    '/^news\/view\/([0-9]+)(\/page\/([0-9]+)){0,1}$/' => function($id, $hasCommentsPage = false, $commentsPage = 1){
        $post = News::id($id);
        
        return view('news/single', [
            'post' => $post,
            'commentsPage' => $commentsPage,
        ]);
    },
    
    // Sprites
    '/^content\/sprites$/' => function(){
        return getRoute('content/sprites/page/1');
    },
    
    '/^content\/sprites\/page\/([0-9]+)$/' => function($page){
        $sprites = SpriteMeta::paginate(['order' => 'eid desc'], [], 20, $page);
        
        return view('content/sprites/archive', [
            'contents' => $sprites,
        ]);
    },
    
    '/^content\/sprites\/view\/([0-9]+)(\/page\/([0-9]+)){0,1}$/' => function($id, $hasCommentsPage = false, $commentsPage = 1){
        $sprite = SpriteMeta::id($id);
        
        $sprite->set('views', intval($sprite->f('views')) + 1)->save();
        
        return view('content/single', [
            'content' => $sprite,
            'typeName' => 'sprites',
            'commentsPage' => $commentsPage,
        ]);
    },
    
    '/^content\/sprites\/download\/([0-9]+)(.*)$/' => function($id){
        $sprite = SpriteMeta::id($id);
        
        $file = $sprite->file();
        
        if(!file_exists($file)){
            return '404';
        }
        
        $sprite->set('downloads', intval($sprite->f('downloads')) + 1)->save();
        
        header('Content-type: ' . mime_content_type($file));
        
        echo file_get_contents($file);
        
        die();
    },
    
    // Games
    '/^content\/games$/' => function(){
        return getRoute('content/games/page/1');
    },
    
    '/^content\/games\/page\/([0-9]+)$/' => function($page){
        $games = GameMeta::paginate(['order' => 'eid desc'], [], 20, $page);
        
        return view('content/games/archive', [
            'contents' => $games,
        ]);
    },
    
    '/^content\/games\/view\/([0-9]+)(\/page\/([0-9]+)){0,1}$/' => function($id, $hasCommentsPage = false, $commentsPage = 1){
        $game = GameMeta::id($id);
        
        return view('content/single', [
            'content' => $game,
            'typeName' => 'games',
            'commentsPage' => $commentsPage,
        ]);
    },
];

?>