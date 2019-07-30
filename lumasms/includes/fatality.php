<?php

function Fatality($e){
?><!DOCTYPE html>
<html lang="en">

<head>

</head>

<body>
<h1>
    Fatal Error
</h1>

<p><?=$e?></p>

</body>
</html><?php
    die();
}

?>