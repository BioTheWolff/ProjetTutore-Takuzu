<?php

/**
 * Cette classe permet de vérifier une grille
 *
 * @author Fabien Zoccola
 */
class GridVerifier
{

    const MULT_ERR = "MULT";
    const SHAPE_ERR = "SHAPE";
    const STABILITY_ERR = "UNSTABLE";
    const NOERR = "OK";

    /**
     * Vérifie que la grille ne viole aucune règle du jeu.
     *
     * La vérification partielle est possible.
     * On utilisera les paramètres insert_pos et insertion pour virtuellement "insérer" une valeur dans la grille
     * afin de vérifier que la grille est toujours valide (utilisé lors de la résolution).
     *
     * @param array $grid la grille d'entiers
     * @param array|null $insert_pos la position sur laquelle insérer
     * @param int|null $insertion la valeur à insérer
     * @return string le retour (UNSTABLE, SHAPE, MULT ou OK)
     */
    public static function partial_verify(array $grid, array $insert_pos = null, int $insertion = null): string
    {
        $mult = -1;
        $c_one = 0;
        $seen = -1;
        $is_full = true;

        foreach (['l', 'c'] as $d)
        {
            $shape_array = [];

            for ($i = 0; $i < count($grid); $i++)
            {
                $line = [];

                for ($j = 0; $j < count($grid[0]); $j++)
                {
                    $n = ($d == 'l'
                        ? ($i === $insert_pos[0] && $j === $insert_pos[1] ? $insertion : $grid[$i][$j])
                        : ($i === $insert_pos[1] && $j === $insert_pos[0] ? $insertion : $grid[$j][$i])
                    );
                    $line[] = $n;

                    if ($n == Adapter::GAP_PHP) $is_full = false;

                    // test multiplicité
                    if ($j == 0)
                    {
                        $c_one = 0;
                        $seen = $n;
                        $mult = 1;
                    }
                    else if ($seen == $n) $mult++;
                    else
                    {
                        $mult = 1;
                        $seen = $n;
                    }

                    // erreur multiplicité
                    if ($seen != Adapter::GAP_PHP && $mult >= 3)
                        return self::format_error(self::MULT_ERR, $d, $i, $j);

                    // règle d'apparence
                    if ($n == 1) $c_one++;
                }

                if (!$is_full) continue;

                // erreur égalité d'apparence
                if ($c_one != count($grid)/2) return self::format_error(self::STABILITY_ERR, $d, $i, $c_one);

                // erreur motif
                $line = implode("", $line);
                if (in_array($line, $shape_array)) return self::format_error(self::SHAPE_ERR, $d, $i);
                else $shape_array[] = $line;
            }
        }

        return self::NOERR;
    }

    /**
     * @param string $error the error type
     * @param string $direction the direction the error was found in
     * @param int $line the line the error was found in
     * @param int $other another parameter. Column if MULT, number of ones in line/column if UNSTABLE. Defaults to -1
     * @return string the formatted error string
     */
    private static function format_error(string $error, string $direction, int $line, int $other = -1): string
    {
        // invert line and column if the multiplicity is found in columns,
        // so we follow the pattern "line:column"
        if ($error == self::MULT_ERR && $direction == "c")
        {
            $temp = $line;
            $line = $other;
            $other = $temp;
        }

        return "$error:$direction:$line:$other";
    }
}