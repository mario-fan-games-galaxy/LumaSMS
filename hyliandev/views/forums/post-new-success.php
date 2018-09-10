<div class="card">
	<div class="card-block">
		Your post was created successfully. View it <a href="<?=$url = url() . '/forums/topic/' . $GLOBALS['params'][2]?>">here</a>.
		
		<?=view('redirect', ['url' => $url])?>
	</div>
</div>