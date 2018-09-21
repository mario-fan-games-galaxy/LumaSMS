<div class="card">
	<div class="card-block">
		Your topic was created successfully. View it <a href="<?=$url = url() . '/forums/topic/' . $GLOBALS['topic_id']?>">here</a>.
		
		<?=view('redirect', ['url' => $url])?>
	</div>
</div>