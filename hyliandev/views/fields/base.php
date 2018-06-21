<?php
$type_view=$type;

if(!file_exists('./views/fields/' . $type . '.php')){
	$type_view='text';
}
?>
<div class="field <?=$error ? 'has-danger' : ''?>">
	<?php if($has_label=(!in_array($type,[ 'textarea-bbcode','checkbox','radio' ]) && !$multiple)): ?><label><?php endif; ?>
	<strong class="<?=$error ? 'text-danger' : ''?>"><?=$title?></strong>
	<small class="error-info"><?=$error?></small>
	<?=view('fields/' . $type_view,$vars)?>
	<?php if($has_label): ?></label><?php endif; ?>
</div>