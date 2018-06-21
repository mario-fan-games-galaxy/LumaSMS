<h1><?=lang('sprites-title')?></h1>

<?php
$view=$params[0];
if(empty($view)) $view='archive';
$page=$params[1];
if(empty($page) || !is_numeric($page) || $page <= 0) $page=1;

switch($view){
	case 'archive':
		$view='sprites/archive';
	break;
	
	default:
		$view='sprites/single';
	break;
}

echo view(
	$view,
	[
		'page'=>$page
	]
);

?>
