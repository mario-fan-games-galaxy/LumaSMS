<?php

require_once '../vendor/autoload.php';
require_once 'includes/class.db.php';
require_once 'includes/fatality.php';
require_once 'includes/functions.php';
require_once 'includes/settings.php';
require_once 'models/model.php';
require_once 'models/comment.php';
require_once 'models/content.php';
require_once 'models/contenttype.php';
require_once 'models/news.php';

echo '<h1>The last 5 updates</h1>';

foreach(News::get(['order'=>'nid desc'], [], 5) as $news){
    echo '<p>' . $news->f('title') . '</p>';
}

echo '<h1>The last 5 submissions</h1>';

foreach(Content::get(['order'=>'rid desc'], [], 5) as $content){
    echo '<p>' . $content->f('title') . ' &dash; ' . (ContentType::id($content->f('type'))->f('module_name')) . '</p>';
}

echo '<h1>The last 5 comments</h1>';

foreach(Comment::get(['order'=>'cid desc'], [], 5) as $comment){
    echo '<p><pre>' . htmlentities($comment->f('message')) . '</pre></p>';
}

?>