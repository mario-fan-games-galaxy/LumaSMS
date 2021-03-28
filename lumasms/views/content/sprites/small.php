<div class="card mb-3">
    <h2 class="card-header">
        <a href="content/sprites/view/<?=$content->f('eid')?>">
            <?=$content->content->f('title')?>
        </a>
    </h2>
    
    <div class="card-body">
        <p>
            <img src="<?=$content->thumbnail()?>" alt="">
        </p>
        
        <?=$content->content->f('description')?>
    </div>
    
    <div class="card-footer">
        <?=$count = $content->commentsCount()?> comment<?=$count != 1 ? 's' : ''?>
        &bull;
        <a href="content/sprites/view/<?=$content->f('eid')?>">
            View (<?=$content->f('views')?> times total)
        </a>
        &bull;
        <a href="content/sprites/download/<?=$content->f('eid')?>/<?=$content->f('file')?>">
            Download (<?=$content->f('downloads')?> times total)
        </a>
    </div>
</div>