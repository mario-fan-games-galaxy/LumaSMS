<?php
/**
 * The information template.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

?><div class="card">
    <?php if (!empty($title)) : ?>
        <h2 class="card-header">
            <?=$title?>
        </h2>
    <?php endif; ?>

    <div class="card-body">
        <?=$message?>
    </div>
</div>
