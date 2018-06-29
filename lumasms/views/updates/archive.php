<h1 id="page-title">
	Updates
</h1>





<div>
	<strong><?=$total?></strong> results / <strong><?=$pages?></strong> pages
</div>





<?=view('pagination',[
	'pages'=>$pages,
	'page'=>$page,
	'baseUrl'=>$GLOBALS['finalRoute']
])?>





<ul class="list-updates"><?php foreach($updates as $update): ?>
	<li>
		<?=view('updates/small',$update->data)?>
	</li>
<?php endforeach; ?></ul>





<?=view('pagination',[
	'pages'=>$pages,
	'page'=>$page,
	'baseUrl'=>$GLOBALS['finalRoute']
])?>