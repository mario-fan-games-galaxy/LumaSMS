<textarea
	name="<?=$name?>"
	class="form-control <?=$error ? 'form-control-danger' : ''?>"
	placeholder="<?=$title?>"
	<?php if($minlength) echo 'minlength="' . $minlength . '"'; ?>
	<?php if($maxlength) echo 'maxlength="' . $maxlength . '"'; ?>
	<?php if($tabindex) echo 'tabindex="' . $tabindex . '"'; ?>
	<?=$required ? 'required' : ''?>
><?=$_POST[$name]?></textarea>