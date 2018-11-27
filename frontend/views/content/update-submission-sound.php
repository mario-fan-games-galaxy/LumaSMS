<section class="content-update-submission content-update-submission-sound">
	<div class="flex flex-center">
		<span class="content-update-submission-big-icon fas fa-headphones-alt"></span>
		
		<div>
			<h4>
				<a href="<?=url()?>/content/sound">
					Super Mario World SFX Pack
				</a>
			</h4>
			
			<?=view('user/profile-link')?>
			
			<ul class="list-tags"><?php foreach([
				'Super Mario World',
				'Ripped',
				'SNES',
			] as $tag): ?>
				<li>
					<a href="<?=url()?>" class="tag">
						<?=$tag?>
					</a>
				</li>
			<?php endforeach; ?></ul>
		</div>
	</div>
</section>