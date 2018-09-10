<h1 id="comments"><?=lang('comments-title')?></h1>

<?php
if (count($comments = Comments::Read($data = ['type' => $type,'rid' => $id,'page' => $page]))) :
    foreach ($comments as $comment) {
        echo view('comments/single', $comment);
    }
else : ?>
<div class="card">
    <div class="card-block">
        <?=lang('comments-empty')?>
    </div>
</div>

<?php endif; ?>

<?=view('pagination', [
    'page' => $page,
    'pageCount' => Comments::NumberOfPages($data),
    'url' => $url . '/' . $GLOBALS['params'][0]
])?>