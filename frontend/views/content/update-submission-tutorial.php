<section class="content-update-submission content-update-submission-tutorial">
	<div class="flex flex-center">
		<span class="content-update-submission-big-icon fas fa-code"></span>
		
		<div>
			<h4>
				<a href="<?=url()?>/content/tutorial">
					Paper Mario-style Turn Based Engine
				</a>
			</h4>
			
			<?=view('user/profile-link')?>
			
			<ul class="list-tags"><?php foreach([
				'Game Maker 8',
				'Drag n Drop',
				'HTML5',
				'Mario',
				'Zelda',
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