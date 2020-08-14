<?php
if(empty($url)) $url=url();
?>

<br><br>

<?=lang('redirect-before')?> <a href="<?=$url?>" class="redirect-url"><?=lang('redirect-link')?></a> <?=lang('redirect-after')?>