<?php if(count($contents)): ?>
    <ul class="list-inline"><?php foreach($contents as $content): if(empty($content->content)): continue; endif; ?>
        <li>
            <?=view('content/sprites/individual', [ 'content' => $content ])?>
        </li>
    <?php endforeach; ?></ul>
    
    <?=view('pagination', [
        'route' => 'content/sprites/page',
        'pages' => News::$pageCount,
        'results' => News::$count,
        'page' => News::$page,
    ])?>
<?php else: ?>
    <p>Nothing was found.</p>
<?php endif; ?>