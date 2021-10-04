<?php

$view = $view ?? 'error/not_found';

$title = Config::getInstance()->get("website.name");
if (isset($page_title)) $title .= " | $page_title";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>
</head>
<body>
    <header>
        <?php require_once('_header.php'); ?>
    </header>

    <div id="container">
        <?php require_once("$view.php"); ?>
    </div>

    <footer>
        <?php require_once('_footer.php'); ?>
    </footer>

</body>
</html>