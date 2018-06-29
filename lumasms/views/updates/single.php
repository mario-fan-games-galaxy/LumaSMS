<section>
	<?=view('updates/small',$update)?>
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
<?php else: ?>
	<?=view('information',[
		'message'=>'No comments'
	])?>
<?php endif; ?>