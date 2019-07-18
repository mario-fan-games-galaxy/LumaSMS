<h2>Comments</h2>

<ul class="list-inline"><?php foreach($comments as $comment): ?>
    <li>
        <?=view('content/comments/individual', [ 'comment' => $comment ])?>
    </li>
<?php endforeach; ?></ul>

<?=view('pagination', [
    'route' => $route,
    'pages' => Comment::$pageCount,
    'results' => Comment::$count,
    'page' => Comment::$page,
])?>