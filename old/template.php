<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=setting('site_abbr')?></title>
<link rel="stylesheet" type="text/css" href="<?=url()?>/theme/base/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?=url()?>/theme/base/font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?=url()?>/theme/base/highlight.min.css">
<link rel="stylesheet" type="text/css" href="<?=url()?>/theme/base/style.css">
<link rel="shortcut icon" type="image/ico" href="<?=url()?>/theme/base/favicon.ico">
</head>

<body class="no-js">

<header>
    <main>
        <div class="container">
            <a href="<?=url()?>">
                <img src="<?=url()?>/theme/base/logo.png">
            </a>
        </div>
    </main>
    
    <nav>
        <div class="container nav-container">
            <div id="show-menu">
                <div class="show-menu-button">
                    Menu <span class="fa fa-caret-down"></span>
                </div>
                
                <div class="user-info">
                    <?php if (User::GetUser()) : ?>
                        <?=User::GetUser()->username?>
                    <?php else : ?>
                        Not logged in
                    <?php endif; ?>
                </div>
            </div>
            
            <ul class="top-menu">
                <li>
                    <a href="<?=url()?>/">
                        Updates
                    </a>
                </li>
                
                <li>
                    <a href="<?=url()?>/content/">
                        Content
                        <span class="fa fa-caret-down"></span>
                    </a>
                    
                    <ul>
                        <li>
                            <a href="<?=url()?>/sprites/">
                                Sprites
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?=url()?>/games/">
                                Games
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?=url()?>/how-tos/">
                                How-Tos
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?=url()?>/sounds/">
                                Sounds
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?=url()?>/misc/">
                                Misc
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li>
                    <a href="<?=url()?>/forums/">
                        Forums
                    </a>
                </li>
                
                <?php if (User::GetUser()) : ?>
                    <li>
                        <a href="<?=url()?>/user/">
                            <div class="show-when-small">
                                User
                            </div>
                            
                            <div class="show-when-big">
                                <?=User::GetUser()->username?>
                                <span class="fa fa-caret-down"></span>
                            </div>
                        </a>
                        
                        <ul>
                            <li>
                                <a href="<?=url()?>/users/">
                                    Users
                                </a>
                            </li>
                            
                            <li>
                                <a href="<?=url()?>/logout/">
                                    <span class="fa fa-sign-out"></span>
                                    Log Out
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li>
                        <a href="<?=url()?>/login/">
                            <span class="fa fa-sign-in"></span>
                            Log In
                        </a>
                        
                        <ul>
                            <li>
                                <a href="<?=url()?>/register/">
                                    <span class="fa fa-user"></span>
                                    Register
                                </a>
                            </li>
                            
                            <li>
                                <a href="<?=url()?>/users/">
                                    Users
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>

<div class="container">

<?=$yield?>

</div>

<footer>
    <div class="container text-center">
    All Nintendo material is © Nintendo. MFGG does not own any user-submitted content,
    which is &copy; the submitter or a third party. All remaining material is &copy; MFGG.
    MFGG is a non-profit site. Please read the Disclaimer.
    </div>
</footer>

<script type="text/javascript" src="<?=url()?>/theme/base/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?=url()?>/theme/base/highlight.min.js"></script>
<script type="text/javascript" src="<?=url()?>/theme/base/script.js"></script>
<script type="text/javascript">
function API(){
    return '<?=url()?>/api';
}
</script>

</body>

</html>