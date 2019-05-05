<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>MFGG</title>
<base href="<?=$base?>">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="themes/style.css">
<link rel="stylesheet" type="text/css" href="themes/<?=$skin->f('slug')?>/style.css">
</head>

<body>

<input type="checkbox" accesskey="m" id="nav-checkbox">

<header id="header">
    <div class="container">
        <a href="./">
            <img src="themes/<?=$skin->f('slug')?>/header.png" alt="Mario Fan Games Galaxy">
        </a>
    </div>
</header>

<nav id="nav">
    <div class="container">
        <ul class="list-inline">
            <li><a href="./">Updates</a></li>
            <li><a href="./content/sprites">Sprite Sheets</a></li>
        </ul>
    </div>
</nav>

<main id="main">
    <div class="container">
        <?=$content?>
    </div>
</main>

<footer id="footer">
    <div class="container">
        Footer
    </div>
</footer>

</body>

</html>