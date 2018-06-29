<section>
	<div class="card">
		<h2 class="card-header">
			#<?=$update['nid']?>:
			<?=$update['title']?>
		</h2>
		
		<div class="card-body">
			<?=format($update['message'])?>
		</div>
		
		<div class="card-footer">
			(<?=$update['comments']?>) Comments
		</div>
	</div>
</section>





<h2>
	Comments
</h2>





<ul class="list-comments"><?php foreach($comments as $comment): ?>
	<li>
		<?=view('comments/small',$comment->data)?>
	</li>
<?php endforeach; ?></ul>