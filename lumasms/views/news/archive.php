<?php if(count($news)): ?>
    <ul class="list-inline"><?php foreach($news as $post): ?>
        <li>
            <h2>
                <a href="news/view/<?=$post->f('nid')?>">
                    <?=$post->f('title')?>
                </a>
            </h2>
        </li>
    <?php endforeach; ?></ul>
    
    <?=view('pagination', [
        'route' => 'news/page',
        'pages' => News::$pageCount,
        'results' => News::$count,
        'page' => News::$page,
    ])?>
<?php else: ?>
    <p>Nothing was found.</p>
<?php endif; ?>