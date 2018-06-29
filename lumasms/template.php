<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>MFGG</title>
<?php foreach([
	'tools/bootstrap',
	'header',
	'lists',
	'pagination',
] as $css): ?>
<link rel="stylesheet" href="<?=url()?>/theme/base/css/<?=$css?>.min.css">
<?php endforeach; ?>
</head>

<body>

<?=view('header')?>

<div class="container">
<?=$yield?>
</div>

</body>

</html>