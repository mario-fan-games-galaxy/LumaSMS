<h1 id="page-title">
	Updates
</h1>

<strong><?=$total?></strong> results / <strong><?=$pages?></strong> pages

<ul class="list-updates"><?php foreach($updates as $update): ?>
	<li>
		<?=view('updates/single',$update->data)?>
	</li>
<?php endforeach; ?></ul>