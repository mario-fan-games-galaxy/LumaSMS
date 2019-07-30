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
</div>