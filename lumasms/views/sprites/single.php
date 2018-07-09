<section>
	<?=view('sprites/small',$object)?>
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
		'baseUrl'=>$GLOBALS['finalRoute'] . '/' . $object['rid'] . '/' . titleToSlug($object['title'])
	])?>
<?php else: ?>
	<?=view('information',[
		'message'=>'No comments'
	])?>
<?php endif; ?>