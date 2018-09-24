<?php
/**
 * The base template.
 *
 * @package LumaSMS
 * @license MIT <https://opensource.org/licenses/MIT>
 * @author  HylianDev <supergoombario@gmail.com>
 * @copyright Mario Fan Games Galaxy 2018 <https://www.mfgg.net>
 */

?><!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>MFGG</title>
<link rel="stylesheet" href="<?=url()?>/assets/main.css">
</head>

<body>

<?=template('header')?>

<div class="container">
<?=$yield?>
</div>

</body>

</html>
