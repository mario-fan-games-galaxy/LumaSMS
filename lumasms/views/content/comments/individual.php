<div class="card mb-3">
    <h2 class="card-header">
        <?=$comment->author()->f('username')?>
        <small><?=date('Y-m-d g:i:sa', $comment->f('date'))?></small>
    </h2>
    
    <div class="card-body">
        <?=$comment->f('message')?>
    </div>
</div>