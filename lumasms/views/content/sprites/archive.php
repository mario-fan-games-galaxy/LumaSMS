<?php if(count($contents)): ?>
    <ul class="list-inline"><?php foreach($contents as $content): if(empty($content->content)): continue; endif; ?>
        <li>
            <?=view('content/sprites/small', [ 'content' => $content ])?>
        </li>
    <?php endforeach; ?></ul>
    
    <?=view('pagination', [
        'route' => 'content/sprites/page',
        'pages' => SpriteMeta::$pageCount,
        'results' => SpriteMeta::$count,
        'page' => SpriteMeta::$page,
    ])?>
<?php else: ?>
    <p>Nothing was found.</p>
<?php endif; ?>