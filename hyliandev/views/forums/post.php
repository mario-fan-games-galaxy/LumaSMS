<div class="card-footer flex-row">
	<a href="<?=url()?>/forums/topic/<?=$GLOBALS['params'][1]?>/<?=$pid?>" class="flex-column">
		ID #<?=$pid?>
	</a>
	
	<div class="flex-column">
		Posted <?=displayDate($date)?>
	</div>
	
	<div class="flex-column">
		Edit
	</div>
</div>

<div class="card-block">
	<div class="row">
		<div class="col-12 col-lg-3 text-center">
			<?=view('user/profile-small',$user)?>
		</div>
		
		<div class="col-12col-lg-9">
			<?=format($message)?>
		</div>
	</div>
</div>