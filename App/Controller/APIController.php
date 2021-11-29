<?php

require_once(Path::get_path("m", ["verifier", "VerifierAdapter"]));
require_once(Path::get_path("m", "GridSolver"));
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
        // TODO: Prendre en compte la taille de la grille donnée par _$GET['size']
        // TODO: Majorer la taille par 16

        $g = IMessages::GAP_PHP;

        switch ($_GET['size'] ?? '') {
            case '12':
                $grid = [
                    [$g, 1, $g, $g, $g, $g, 0, $g, $g, $g, $g, $g],
                    [$g, $g, $g, $g, $g, $g, 0, $g, $g, 0, $g, $g],
                    [1, $g, $g, $g, $g, 0, $g, $g, $g, 1, $g, 1],
                    [$g, 0, $g, $g, $g, $g, 1, $g, $g, $g, $g, $g],
                    [$g, $g, 0, $g, $g, 0, $g, $g, 0, $g, $g, $g],
                    [$g, $g, $g, 1, $g, $g, $g, 0, $g, 0, $g, $g],
                    [$g, $g, $g, $g, $g, 0, $g, 0, $g, $g, $g, $g],
                    [$g, $g, $g, 1, $g, $g, 1, $g, $g, $g, $g, $g],
                    [$g, 1, $g, 1, $g, $g, $g, $g, $g, 0, $g, $g],
                    [$g, $g, $g, $g, $g, $g, 0, $g, $g, 0, $g, $g],
                    [$g, 1, $g, 1, $g, $g, $g, 1, $g, $g, $g, 1],
                    [$g, $g, 0, $g, 0, $g, $g, $g, 0, 0, $g, $g],
                ];
                break;
            case '4':
                $grid = [
                    [$g, 1, $g, $g],
                    [1, $g, 1, $g],
                    [1, $g, $g, $g],
                    [$g, $g, 1, $g],
                ];
                break;
            default:
                $grid = [
                    [$g, $g, $g, $g, $g, $g, $g, $g],
                    [1, $g, $g, $g, $g, $g, $g, $g],
                    [$g, $g, $g, 0, $g, 1, $g, $g],
                    [$g, $g, $g, 0, $g, $g, 0, 0],
                    [$g, $g, $g, $g, $g, $g, 0, $g],
                    [1, $g, $g, $g, $g, $g, $g, $g],
                    [1, 1, $g, $g, $g, $g, $g, $g],
                    [$g, $g, 0, $g, $g, $g, $g, $g]
                ];
        }

        echo MessageAdapter::grid_to_message($grid);
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
