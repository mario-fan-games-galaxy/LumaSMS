<h1 id="page-title">
	Miscellaneous
</h1>





<div>
	<strong><?=$total?></strong> results / <strong><?=$pages?></strong> pages
</div>





<?=view('pagination',[
	'pages'=>$pages,
	'page'=>$page,
	'baseUrl'=>'sprites/archive'
])?>





<ul class="list-games"><?php foreach($objects as $object): ?>
	<li>
		<?=view('misc/small',$object->data)?>
	</li>
<?php endforeach; ?></ul>





<?=view('pagination',[
	'pages'=>$pages,
	'page'=>$page,
	'baseUrl'=>'sprites/archive'
])?>