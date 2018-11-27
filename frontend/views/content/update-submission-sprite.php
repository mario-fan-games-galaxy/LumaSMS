<section class="content-update-submission content-update-submission-sprite">
	<a href="<?=url()?>/content/sprite">
		<div class="thumbnail thumbnail-blur" style="background-image: url('<?=url()?>/assets/content/sprites/thumb<?=rand(0, 2)?>.png');"></div>
	</a>
	
	<h4>
		<a href="<?=url()?>/content/sprite">
			SMB2 (All-Stars) Modern Peach
		</a>
	</h4>
	
	<?=view('user/profile-link')?>
	
	<ul class="list-tags"><?php foreach([
		'Super Mario Bros 2 (16-bit)',
		'Edited',
		'Sprite Sheet',
		'Princess Peach'
	] as $tag): ?>
		<li>
			<a href="<?=url()?>" class="tag">
				<?=$tag?>
			</a>
		</li>
	<?php endforeach; ?></ul>
</section>