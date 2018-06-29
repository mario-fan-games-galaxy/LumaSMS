<div class="card">
	<h2 class="card-header">
		<a href="<?=url()?>/updates/view/<?=$nid?>">
			<?=$title?>
		</a>
	</h2>
	
	<div class="card-body">
		<?=format($message)?>
	</div>
	
	<div class="card-footer">
		(<?=$comments?>) Comments
	</div>
</div>