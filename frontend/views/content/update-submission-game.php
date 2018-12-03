<section class="content-update-submission content-update-submission-game content-game">
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
		<a href="<?=url()?>/content/game">
			Toadette Strikes (Toad Strikes Back 2)
		</a>
	</h4>
	
	<div class="content-game-score">
		Score:
		<span class="fas fa-star"></span>
		<span class="fas fa-star"></span>
		<span class="fas fa-star"></span>
		<span class="far fa-star"></span>
		<span class="far fa-star"></span>
	</div>
	
	<?=view('user/profile-link')?>
	
	<ul class="list-tags"><?php foreach([
		'<span class="fab fa-windows"></span>',
		'Demo',
		'Platformer',
		'Game Maker 8',
	] as $tag): ?>
		<li>
			<a href="<?=url()?>" class="tag">
				<?=$tag?>
			</a>
		</li>
	<?php endforeach; ?></ul>
</section>