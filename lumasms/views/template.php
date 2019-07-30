<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>MFGG</title>
<base href="<?=$base?>">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
<link rel="stylesheet" type="text/css" href="themes/style.css">
<link rel="stylesheet" type="text/css" href="themes/<?=$skin->f('slug')?>/style.css">
<script type="text/javascript" src="themes/nav.js"></script>
</head>

<body>

<input type="checkbox" accesskey="m" id="nav-checkbox">

<header id="header">
    <div class="container">
        <div class="d-flex align-items-center">
            <a href="./" class="flex-grow-1">
                <img src="themes/<?=$skin->f('slug')?>/header.png" alt="Mario Fan Games Galaxy">
            </a>
            
            <label for="nav-checkbox" class="px-5">
                <span class="fas fa-bars fa-lg"></span>
            </label>
        </div>
    </div>
</header>

<nav id="nav">
    <dl>
        <dt class="d-flex align-items-center">
            <span class="flex-grow-1">Menu</span>
            
            <label for="nav-checkbox" class="p-2">
                <span class="fas fa-times fa-lg"></span>
            </label>
        </dt>
        <dd><a href="./">Updates</a></dd>
        <dd><a href="./content/sprites">Sprite Sheets</a></dd>
        <dd><a href="./content/games">Games</a></dd>
    </dl>
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