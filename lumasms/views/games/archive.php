<h1 id="page-title">
    Games
</h1>





<div>
    <strong><?=$total?></strong> results / <strong><?=$pages?></strong> pages
</div>





<?=view('pagination', [
    'pages' => $pages,
    'page' => $page,
    'baseUrl' => 'games/archive'
])?>





<ul class="list-games"><?php foreach ($objects as $object) : ?>
    <li>
        <?=view('games/small', $object->data)?>
    </li>
                       <?php endforeach; ?></ul>





<?=view('pagination', [
    'pages' => $pages,
    'page' => $page,
    'baseUrl' => 'games/archive'
])?>