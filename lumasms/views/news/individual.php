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
</div><!-- .card -->

<?=view('content/comments/list', [
    'comments' => $post->comments($commentsPage),
    'route' => 'news/view/' . $post->f('nid') . '/page',
    'commentsPage' => $commentsPage,
])?>