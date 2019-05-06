<?php if(count($contents)): ?>
    <ul class="list-inline"><?php foreach($contents as $content): if(empty($content->content)): continue; endif; ?>
        <li>
            <?=view('content/games/individual', [ 'content' => $content ])?>
        </li>
    <?php endforeach; ?></ul>
    
    <?=view('pagination', [
        'route' => 'content/games/page',
        'pages' => GameMeta::$pageCount,
        'results' => GameMeta::$count,
        'page' => GameMeta::$page,
    ])?>
<?php else: ?>
    <p>Nothing was found.</p>
<?php endif; ?>