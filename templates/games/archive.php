<?php
/**
 * Games archive template.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

?><h1 id="page-title">
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





<ul class="list-games">
<?php foreach ($objects as $object) : ?>
    <li>
        <?=template('games/small', $object->data)?>
    </li>
<?php endforeach; ?>
</ul>





<?=template('pagination', [
    'pages' => $pages,
    'page' => $page,
    'baseUrl' => 'games/archive'
])?>
