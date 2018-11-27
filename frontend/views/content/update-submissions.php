<section class="content-update-submissions">
	<h3>
		Games
	</h3>
	
	<ul class="list-update-submissions row"><?php for($i=0; $i<2; $i++): ?>
		<li class="col-12 col-xl-6">
			<?=view('content/update-submission-game')?>
		</li>
	<?php endfor; ?></ul>
	
	<h3>
		Reviews
	</h3>
	
	<ul class="list-update-submissions row"><?php for($i=0; $i<4; $i++): ?>
		<li class="col-12 col-lg-6">
			<?=view('content/update-submission-review')?>
		</li>
	<?php endfor; ?></ul>
	
	<h3>
		Sprites
	</h3>
	
	<ul class="list-update-submissions row"><?php for($i=0; $i<6; $i++): ?>
		<li class="col-12 col-md-6 col-xl-4">
			<?=view('content/update-submission-sprite')?>
		</li>
	<?php endfor; ?></ul>
	
	<h3>
		Tutorials
	</h3>
	
	<ul class="list-update-submissions row"><?php for($i=0; $i<4; $i++): ?>
		<li class="col-12 col-lg-6">
			<?=view('content/update-submission-tutorial')?>
		</li>
	<?php endfor; ?></ul>
	
	<h3>
		Sounds
	</h3>
	
	<ul class="list-update-submissions row"><?php for($i=0; $i<4; $i++): ?>
		<li class="col-12 col-lg-6">
			<?=view('content/update-submission-sound')?>
		</li>
	<?php endfor; ?></ul>
	
	<h3>
		Miscellaneous
	</h3>
	
	<ul class="list-update-submissions row"><?php for($i=0; $i<4; $i++): ?>
		<li class="col-12 col-lg-6">
			<?=view('content/update-submission-misc')?>
		</li>
	<?php endfor; ?></ul>
</section>