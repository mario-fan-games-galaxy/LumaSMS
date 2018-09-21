<h1><?=format($title)?></h1>

<div class="button-bar">
    <a href="<?=url()?>/forums/post/new/<?=$tid?>" class="btn btn-blue">
        Reply
    </a>
</div>

<div class="card"><?php foreach (Posts::Read($data = ['tid' => $tid,'page' => $page]) as $post) : ?>
    <?=view('forums/post', $post)?>
                  <?php endforeach; ?></div>

<?=view('pagination', [
    'url' => 'forums/topic/' . $GLOBALS['params'][1],
    'page' => $page,
    'pageCount' => Posts::NumberOfPages($data)
])?>