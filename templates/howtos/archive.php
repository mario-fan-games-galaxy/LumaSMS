<h1 id="page-title">
    Howtos
</h1>





<div>
    <strong><?=$total?></strong> results / <strong><?=$pages?></strong> pages
</div>





<?=template('pagination', [
    'pages' => $pages,
    'page' => $page,
    'baseUrl' => 'sprites/archive'
])?>





<ul class="list-games"><?php foreach ($objects as $object) : ?>
    <li>
        <?=template('howtos/small', $object->data)?>
    </li>
                       <?php endforeach; ?></ul>





<?=template('pagination', [
    'pages' => $pages,
    'page' => $page,
    'baseUrl' => 'sprites/archive'
])?>
