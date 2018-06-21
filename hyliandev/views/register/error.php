<div class="card">
	<div class="card-header">
		<?=lang('misc-error')?>
	</div>
	
	<div class="card-block">
		<?=debug(DB()->errorInfo())?>
	</div>
</div>