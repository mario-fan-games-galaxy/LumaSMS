<h1 id="page-title">
	Sprites
</h1>





<div>
	<strong><?=$total?></strong> results / <strong><?=$pages?></strong> pages
</div>





<?=view('pagination',[
	'pages'=>$pages,
	'page'=>$page,
	'baseUrl'=>'sprites/archive'
])?>





<ul class="list-games"><?php foreach($sprites as $sprite): ?>
	<li>
		<?=view('sprites/small',$sprite->data)?>
	</li>
<?php endforeach; ?></ul>





<?=view('pagination',[
	'pages'=>$pages,
	'page'=>$page,
	'baseUrl'=>'sprites/archive'
])?>