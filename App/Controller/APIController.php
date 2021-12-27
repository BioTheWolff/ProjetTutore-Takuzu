<?php

require_once(Path::get_path("m", ['messages', 'MessageAdapter']));
require_once(Path::get_path("l", "Douane"));


/**
 * Classe s'occupant de l'API du jeu, utilisée par le Javascript avec des XHR
 */
class APIController
{

    /**
     * Route permettant de vérifier que la grille est correcte
     *
     * @see IVerifier::code
     */
    public static function check()
    {
        if (!Douane::message($_GET['message'] ?? "")) {
            http_response_code(400);
            echo "NOK";
        }
        else echo MessageAdapter::verify($_GET['message']);
    }

    /**
     * Route utilisée par le Javascript lors du chargement de la page de jeu
     * Elle prend la taille de la grille en paramètre (16 au maximum) et renvoie une grille en message
     */
    public static function generate()
    {
        $size = (int)($_GET['size'] ?? 8);
        if ($size > 16) $size = 16;
        if ($size < 6) $size = 6;

        $fp = (float)($_GET['fillPercentage'] ?? 0.25);
        if ($fp > 0.7) $fp = 0.7;
        if ($fp < 0.25) $fp = 0.25;

        echo MessageAdapter::generate($size, $fp);
    }

    public static function solve()
    {
        if (!Douane::message($_GET['message'] ?? "")) {
            http_response_code(400);
            echo "NOK";
        }
        else echo MessageAdapter::solve($_GET['message']);
    }

}
