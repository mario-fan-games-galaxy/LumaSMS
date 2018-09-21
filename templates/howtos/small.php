<div class="card">
	<h2 class="card-header">
		<a href="<?=url()?>/howtos/view/<?=$rid?>/<?=titleToSlug($title)?>/">
			<?=$title?>
		</a>
	</h2>
	
	<div class="card-body">
		<?=format($description)?>
	</div>
	
	<div class="card-footer">
		(<?=$comments?>) Comments
	</div>
</div>