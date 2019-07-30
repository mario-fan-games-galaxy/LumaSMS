<div class="card mb-4">
    <h2 class="card-header">
        <a href="news/view/<?=$post->f('nid')?>">
            <?=$post->f('title')?>
        </a>
    </h2>
    
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-lg-3 text-center">
                <?=$post->author()?>
            </div><!-- .col -->
            
            <div class="col-12 col-lg-9">
                <?=$post->f('message')?>
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .card-body -->
    
    <div class="card-footer">
        <a href="news/view/<?=$post->f('nid')?>">
            <?=$count = $post->commentsCount()?> comment<?=$count != 1 ? 's' : ''?>
        </a>
    </div><!-- .card-footer -->
</div><!-- .card -->