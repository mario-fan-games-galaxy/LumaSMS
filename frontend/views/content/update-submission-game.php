<section class="content-update-submission content-update-submission-sprite">
	<a href="<?=url()?>/content/game">
		<div class="thumbnail thumbnail-blur" style="background-image: url('<?=url()?>/assets/content/games/game<?=rand(0, 2)?>screen0.png');">
			<?php if(rand(0, 1) == 1): ?>
				<span class="game-badge">
					Staff Pick!
				</span>
			<?php endif; ?>
		</div>
	</a>
	
	<h4>
		<a href="<?=url()?>/content/single">
			Toadette Strikes (Toad Strikes Back 2)
		</a>
	</h4>
	
	<div>
		Score:
		<span class="fas fa-star"></span>
		<span class="fas fa-star"></span>
		<span class="fas fa-star"></span>
		<span class="far fa-star"></span>
		<span class="far fa-star"></span>
	</div>
	
	<?=view('user/profile-link')?>
</section>