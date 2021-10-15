<?php
require_once('../App/lib/Path.php');
require_once('../App/lib/Config.php');
require_once('../App/lib/RenderEngine.php');


require_once(Path::get_path("c", "APIController"));
require_once(Path::get_path("c", "VisualController"));


$action = $_GET['action'] ?? false;

if ($action === false) VisualController::index();
else if (strpos($action, "api-") == 0) APIController::$action();
else VisualController::$action();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
</head>
<body>
<div style="display: flex">
    <article class="Logo" style=" width: 200px; height: 200px;">
        <h2>Takuzu</h2>
        <img src="assets/img/logo.jpg" style="border-radius: 10px 100px / 120px; width: 150px; height: 150px;">
    </article>
    <section class="accueil" style="align-items: center">
        <div class="bouton"><a href="partie.php">Lancer une partie</a></div>
        <div class="bouton"><a href="option.php">Option</a></div>
    </section>
</div>

</body>
</html>
