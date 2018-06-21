<div class="card">
	<div class="card-header">
		<?=$title?>
	</div>
	
	<div class="card-block">
		<div class="resource-layout">
			<img src="<?=url()?>/../tcsms/thumbnail/1/<?=$thumbnail?>" class="resource-thumbnail">
			
			<div class="resource-description">
				<?=$description?>
			</div>
		</div>
		
		<div class="resource-action-bar">
			<a href="<?=url()?>/view/file/<?=$rid?>" target="_blank">
				<span class="fa fa-download"></span>
				<?=lang('content-download')?>
			</a>
		</div>
		
		<div>
			<?=lang('content-views')?>: <?=$views?>
			<br>
			<?=lang('content-downloads')?>: <?=$downloads?>
		</div>
	</div>
</div>