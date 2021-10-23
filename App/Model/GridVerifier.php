<?php

/**
 * Cette classe permet de vérifier une grille
 *
 * @author Fabien Zoccola
 */
class GridVerifier
{

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
                        ? ($i == $insert_pos[0] && $j == $insert_pos[1] ? $insertion : $grid[$i][$j])
                        : ($i == $insert_pos[1] && $j == $insert_pos[0] ? $insertion : $grid[$j][$i])
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
                        return "MULT:" . $d . "," . ($d == 'l' ? $i : $j) . "," . ($d == 'l' ? $j : $i);

                    // règle d'apparence
                    if ($n == 1) $c_one++;
                }

                if (!$is_full) continue;

                // erreur égalité d'apparence
                if ($c_one != count($grid)/2) return "UNSTABLE:" . $d . "," . $i . "," . $c_one;

                // erreur motif
                $line = implode("", $line);
                if (in_array($line, $shape_array)) return "SHAPE:" . $d . "," . $i;
                else $shape_array[] = $line;
            }
        }

        return "OK";
    }
}