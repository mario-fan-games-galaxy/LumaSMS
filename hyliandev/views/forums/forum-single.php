<h1><?=format($title)?></h1>

<div class="button-bar">
	<a href="<?=url()?>/forums/topic/new/<?=$fid?>" class="btn btn-primary">
		New Topic
	</a>
</div>

<div class="card">
	<div class="card-header">
		Topics
	</div>
	
	<?php if(count($topics)): ?>
		<?php foreach($topics as $topic): ?>
			<?=view('forums/topic',$topic)?>
		<?php endforeach; ?>
	<?php else: ?>
		<div class="card-block">
			No topics to show!
		</div>
	<?php endif; ?>
</div>

<?=view('pagination',[
	'url'=>'forums/forum/' . $GLOBALS['params'][1],
	'page'=>$page,
	'pageCount'=>Topics::NumberOfPages($data)
])?>