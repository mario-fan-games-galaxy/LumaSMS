<?php

/**
 * The pagination template.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

?><div class="pagination-box">
    <div class="previous-link">
        <?php if ($page > 1) : ?>
            <a href="<?=url()?>/<?=$baseUrl?>/<?=$page - 1?>/" class="btn btn-primary">
                Previous
            </a>
        <?php endif; ?>
    </div>

    <div class="pages-links">
        <ul class="list-pages">
<?php for ($i = 0; $i < $pages; $i++) : ?>
            <li>
                <?php if ($page == $i + 1) : ?>
                    <button type="button" class="btn btn-primary disabled" disabled>
                        <?=$i + 1?>
                    </button>
                <?php else : ?>
                    <a href="<?=url()?>/<?=$baseUrl?>/<?=$i + 1?>/" class="btn btn-primary">
                        <?=$i + 1?>
                    </a>
                <?php endif; ?>
            </li>
<?php endfor; ?>
        </ul>
    </div>

    <div class="next-link">
        <?php if ($page < $pages) : ?>
            <a href="<?=url()?>/<?=$baseUrl?>/<?=$page + 1?>/" class="btn btn-primary">
                Next
            </a>
        <?php endif; ?>
    </div>
</div>
