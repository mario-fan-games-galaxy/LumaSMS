<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../vendor/autoload.php';
require_once 'includes/class.db.php';
require_once 'includes/fatality.php';
require_once 'includes/functions.php';
require_once 'includes/settings.php';
require_once 'models/model.php';
require_once 'models/news.php';

//echo 'Hello, World!';

echo debug(News::get());

?>