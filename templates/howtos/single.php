<?php

/**
 * The how-tos single template.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

?><section>
    <?=template('sprites/small', $object)?>
</section>





<h2>
    Comments
</h2>





<?php if (count($comments)) : ?>
    <ul class="list-comments">
    <?php foreach ($comments as $comment) : ?>
        <li>
            <?=template('comments/small', $comment->data)?>
        </li>
    <?php endforeach; ?>
    </ul>

    <?=template('pagination', [
        'pages' => $commentsPages,
        'page' => $commentsPage,
        'baseUrl' => $GLOBALS['finalRoute'] . '/' . $object['rid'] . '/' . titleToSlug($object['title'])
    ])?>
<?php else : ?>
    <?=template('information', [
        'message' => 'No comments'
    ])?>
<?php endif; ?>
