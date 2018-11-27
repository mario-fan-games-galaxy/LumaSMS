<?php

$icon = ['font', 'cogs', 'question-circle'];

$icon = $icon[rand(0, count($icon) - 1)];

?>
<section class="content-update-submission content-update-submission-misc">
	<div class="flex flex-center">
		<span class="content-update-submission-big-icon fas fa-<?=$icon?>"></span>
		
		<div>
			<h4>
				<a href="<?=url()?>/content/misc">
					Miscellaneous Submission
				</a>
			</h4>
			
			<?=view('user/profile-link')?>
			
			<ul class="list-tags"><?php foreach([
				'Font',
				'DLL',
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