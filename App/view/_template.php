<?php

$rvar_file_name = $rvar_file_name ?? 'error/not_found';

$rvar_site_title = Config::getInstance()->get("website.name", "Projet Takuzu");
if (isset($rvar_page_title)) $rvar_site_title .= " | $rvar_page_title";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/template.css">
    <link rel="stylesheet" href="assets/css/<?=$rvar_file_name?>.css">
    <title><?= $rvar_site_title ?></title>
</head>
<body>
    <header>
        <?php require_once('_header.php'); ?>
    </header>

    <div id="container">
        <!-- Affiche la view utilisé -->
        <?php require_once("content/$rvar_file_name.php"); ?>
        <script type="text/javascript" src="assets/js/<?=$rvar_file_name?>.js"></script>
    </div>

    <footer>
        <?php require_once('_footer.php'); ?>
    </footer>

</body>
</html>