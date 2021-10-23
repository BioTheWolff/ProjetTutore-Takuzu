<?php

require_once(Path::get_path("l", "Adapter"));
require_once(Path::get_path("m", "GridVerifier"));


/**
 * Classe s'occupant de l'API du jeu, utilisée par le Javascript avec des XHR
 */
class APIController
{

    /**
     * Route permettant de vérifier que la grille est correcte
     *
     * @see GridVerifier::partial_verify
     */
    public static function check()
    {
        echo(GridVerifier::partial_verify(Adapter::message_to_grid($_GET['message'])));
    }

    /**
     * Route utilisée par le Javascript lors du chargement de la page de jeu
     * Elle prend la taille de la grille en paramètre (16 au maximum) et renvoie une grille en message
     */
    public static function generate()
    {
        // TODO: Prendre en compte la taille de la grille donnée par _$GET['size']
        // TODO: Majorer la taille par 16

        $g = Adapter::GAP_PHP;
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

        echo(Adapter::grid_to_message($grid));
    }

}