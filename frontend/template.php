<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="<?=url()?>/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?=url()?>/assets/css/frontend.min.css">
<link rel="shortcut icon" href="<?=url()?>/assets/favicon.ico">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<title>MFGG</title>
</head>

<body>

<header id="header">
	<div class="container">
		<div>
			<img src="<?=url()?>/assets/images/header.png" alt="Mario Fan Games Galaxy" id="logo">
		</div>
	</div>
</header>

<nav id="nav">
	<div class="container">
		<ul>
			<li>
				<a href="<?=url()?>/index">
					Updates
				</a>
			</li>
			
			<li>
				<a href="<?=url()?>/content">
					Content
				</a>
			</li>
			
			<li>
				<a href="<?=url()?>/forums">
					Forums
				</a>
			</li>
			
			<li>
				<a href="<?=url()?>/account">
					Account
				</a>
			</li>
		</ul>
	</div>
</nav>

<?=$yield?>

</body>

</html>