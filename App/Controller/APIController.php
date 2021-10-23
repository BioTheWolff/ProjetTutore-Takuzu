<?php

require_once(Path::get_path("l", "Adapter"));
require_once(Path::get_path("m", "GridVerifier"));


/**
 *
 */
class APIController
{

    /**
     *
     */
    public static function check()
    {
        echo(GridVerifier::partial_verify(Adapter::message_to_grid($_GET['message'])));
    }

    /**
     *
     */
    public static function generate()
    {
        // TODO: Prendre en compte la taille de la grille donnée par _$GET['size']

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