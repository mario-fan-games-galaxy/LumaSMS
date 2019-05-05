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
    '/^$/' => function(){
        return getRoute('news/page/1');
    },
    
    '/^news\/page\/([0-9]+)$/' => function($page){
        $news = News::get(['order'=>'nid desc'], [], 20, $page);
        
        return view('news/archive', [
            'news' => $news,
        ]);
    },
    
    '/^news\/view\/([0-9]+)[\/|\-]*(.*)$/' => function($id){
        $post = News::id($id);
        
        return view('news/single', [ 'post' => $post ]);
    },
    
    '/^content\/sprites$/' => function(){
        return getRoute('content/sprites/page/1');
    },
    
    '/^content\/sprites\/page\/([0-9]+)$/' => function($page){
        $sprites = SpriteMeta::get(['order' => 'eid desc'], [], 20, $page);
        
        return view('content/sprites/archive', [
            'contents' => $sprites,
        ]);
    },
    
    '/^content\/sprites\/view\/([0-9]+)$/' => function($id){
        $sprite = SpriteMeta::id($id);
        
        return view('content/single', [
            'content' => $sprite,
            'typeName' => 'sprites',
        ]);
    },
];

?>