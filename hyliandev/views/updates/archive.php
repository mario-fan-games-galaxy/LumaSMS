<?php
$updates=Updates::Read([
	'page'=>$page
]);

if(count($updates)):
	foreach($updates as $update){
		echo view('updates/small',$update);
	}
else: ?>

<div class="card">
	<div class="card-block">
		<?=lang('updates-empty')?>
	</div>
</div>

<?php endif; ?>

<?=view('pagination',[
	'page'=>$page,
	'pageCount'=>Updates::NumberOfPages(),
	'url'=>'updates/archive'
])?>