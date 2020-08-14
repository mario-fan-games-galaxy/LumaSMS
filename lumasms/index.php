<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../vendor/autoload.php';
require_once 'includes/class.db.php';
require_once 'includes/fatality.php';
require_once 'includes/functions.php';
require_once 'includes/class.login.php';
require_once 'includes/settings.php';
require_once 'includes/views.php';
require_once 'models/model.php';
require_once 'models/comment.php';
require_once 'models/content.php';
require_once 'models/contentmeta.php';
require_once 'models/contenttype.php';
require_once 'models/gamemeta.php';
require_once 'models/news.php';
require_once 'models/siteskin.php';
require_once 'models/spritemeta.php';
require_once 'models/user.php';
require_once 'routes.php';

Login::init();

$route = false;

if(!empty($_GET['route'])){
    $route = $_GET['route'];
}

$content = getRoute($route);

echo view('template', [
    'base' => baseHref(),
    'content' => $content,
    'skin' => Login::skin(),
]);

?>