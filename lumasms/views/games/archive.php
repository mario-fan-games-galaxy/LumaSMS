<h1 id="page-title">
	Games
</h1>





<div>
	<strong><?=$total?></strong> results / <strong><?=$pages?></strong> pages
</div>





<?=view('pagination',[
	'pages'=>$pages,
	'page'=>$page,
	'baseUrl'=>'games/archive'
])?>





<ul class="list-games"><?php foreach($games as $game): ?>
	<li>
		<?=view('games/small',$game->data)?>
	</li>
<?php endforeach; ?></ul>





<?=view('pagination',[
	'pages'=>$pages,
	'page'=>$page,
	'baseUrl'=>'games/archive'
])?>