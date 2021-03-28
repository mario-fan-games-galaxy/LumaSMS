<?php

/**
 * The How-Tos archive template.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

?><h1 id="page-title">
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





<ul class="list-games">
<?php foreach ($objects as $object) : ?>
    <li>
        <?=template('howtos/small', $object->data)?>
    </li>
<?php endforeach; ?>
</ul>





<?=template('pagination', [
    'pages' => $pages,
    'page' => $page,
    'baseUrl' => 'sprites/archive'
])?>
