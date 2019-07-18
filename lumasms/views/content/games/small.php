<div class="card mb-3">
    <h2 class="card-header">
        <a href="content/games/view/<?=$content->f('eid')?>">
            <?=$content->content->f('title')?>
        </a>
    </h2>
    
    <div class="card-body">
        <?=$content->content->f('description')?>
    </div>
</div>