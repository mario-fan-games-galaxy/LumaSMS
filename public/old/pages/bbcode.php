<div class="card">
	<div class="card-header">
		Testing BBCode
	</div>
	
	<div class="card-block" id="bbcode-preview">
		<?=format(preFormat($_POST['message']))?>
	</div>
	
	<div class="card-header">
		Type
	</div>
	
	<div class="card-block">
		<form method="post">
			<?=field([
				'title' => 'Message',
				'name' => 'message',
				'type' => 'textarea-bbcode'
			])?>
			
			<div>
				<button class="btn btn-success" type="button" data-bbcode-preview><?=lang('misc-preview')?></button>
				<button class="btn btn-primary" type="submit"><?=lang('misc-submit')?></button>
			</div>
		</form>
	</div>
</div>