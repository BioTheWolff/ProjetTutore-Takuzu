<?php
require_once('../App/Lib/Path.php');
require_once('../App/Lib/Config.php');
require_once('../App/Lib/RenderEngine.php');


require_once(Path::get_path("c", "APIController"));
require_once(Path::get_path("c", "VisualController"));


$action = $_GET['action'] ?? false;
// on appelle la view STP FABIEN MAIS DES COM
if ($action === false) VisualController::index();
else if (strpos($action, "api-") === 0)
{
    $action = str_replace("api-", "", $action);
    APIController::$action();
}
else VisualController::$action();
