<h1 id="page-title">
    Games
</h1>





<div>
    <strong><?=$total?></strong> results / <strong><?=$pages?></strong> pages
</div>





<?=template('pagination', [
    'pages' => $pages,
    'page' => $page,
    'baseUrl' => 'games/archive'
])?>





<ul class="list-games"><?php foreach ($objects as $object) : ?>
    <li>
        <?=template('games/small', $object->data)?>
    </li>
                       <?php endforeach; ?></ul>





<?=template('pagination', [
    'pages' => $pages,
    'page' => $page,
    'baseUrl' => 'games/archive'
])?>
