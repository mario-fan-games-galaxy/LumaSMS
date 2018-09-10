<?php
if (empty($id = array_shift(explode('-', $GLOBALS['params'][0]))) || !is_numeric($id) || $id < 0 || empty($sprite = Sprites::Read(['rid' => $id]))) :
    ?>

<div class="card">
    <div class="card-block">
        <?=lang('misc-invalid-id')?>
    </div>
</div>

    <?php
else :
    $q = DB()->prepare("
	UPDATE " . setting('db_prefix') . "res_gfx
	SET views = views + 1
	WHERE
	eid= ?
");

    $q->execute([
    $sprite->eid
    ]);

    $sprite->views++;

    echo view('sprites/large', $sprite);

    echo view('comments/archive', [
    'id' => $id,
    'page' => $page,
    'type' => 1,
    'url' => 'sprites'
    ]);
endif;
?>