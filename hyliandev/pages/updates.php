<h1><?=lang('updates-title')?></h1>

<?php
$view=$params[0];
if(empty($view)) $view='archive';
$page=$params[1];
if(empty($page) || !is_numeric($page) || $page <= 0) $page=1;

switch($view){
	case 'archive':
		$view='updates/archive';
	break;
	
	default:
		$view='updates/single';
	break;
}

echo view(
	$view,
	[
		'page'=>$page
	]
);

?>
