<?php
require_once('../App/lib/Path.php');
require_once('../App/lib/Config.php');
require_once('../App/lib/RenderEngine.php');

require_once(Path::get_path("c", "VisualController"));

$action = $_GET['action'] ?? false;

if ($action === false)
{
    VisualController::index();
}