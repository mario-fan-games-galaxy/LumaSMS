<section>
	<?=view('games/small',$game)?>
</section>





<h2>
	Comments
</h2>





<?php if(count($comments)): ?>
	<ul class="list-comments"><?php foreach($comments as $comment): ?>
		<li>
			<?=view('comments/small',$comment->data)?>
		</li>
	<?php endforeach; ?></ul>
	
	<?=view('pagination',[
		'pages'=>$commentsPages,
		'page'=>$commentsPage,
		'baseUrl'=>$GLOBALS['finalRoute'] . '/' . $update['nid'] . '/' . titleToSlug($update['title'])
	])?>
<?php else: ?>
	<?=view('information',[
		'message'=>'No comments'
	])?>
<?php endif; ?>