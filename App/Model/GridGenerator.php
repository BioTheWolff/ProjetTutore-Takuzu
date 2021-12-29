<?php

require_once 'messages/MessageAdapter.php';
require_once 'verifier/VerifierAdapter.php';

class GridGenerator
{
    /**
     * @param int $size the size of the grid
     * @param float $fillPercentage le pourcentage de remplissage
     * @return int[][] Une grille de takuzu remplie à $fillPercentage pourcents
     */
    public static function generate(int $size, float $fillPercentage)
    {
        $str = "$size:" . str_repeat("_", $size**2);
        $grid = MessageAdapter::message_to_grid(MessageAdapter::solve($str));

        // swap lines until grid is valid again
        $nb = 0;
        do
        {
            $lineFrom = rand(0, $size-1);
            $lineTo = rand(0, $size-1);

            $temp = $grid[$lineTo];
            $grid[$lineTo] = $grid[$lineFrom];
            $grid[$lineFrom] = $temp;
        }
        while (++$nb < $size && !VerifierAdapter::is_valid($grid));

        // then remove values to get only $fillPercentage values left
        while (self::count_gap_percentage($grid) < (1.0 - $fillPercentage))
        {
            do
            {
                $line = rand(0, $size-1);
                $column = rand(0, $size-1);
            }
            while ($grid[$line][$column] == IMessages::GAP_PHP);

            $grid[$line][$column] = IMessages::GAP_PHP;
        }

        return $grid;
    }

    public static function count_gap_percentage(array $grid): float
    {
        [$size, $message] = explode(":", MessageAdapter::grid_to_message($grid));

        return substr_count($message, "_") / ((float)$size**2);
    }
}