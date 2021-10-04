<?php

/**
 * @param int[][] $grid
 */
function verify(array $grid): ?array
{
    $mult = -1;
    $c_one = 0;
    $seen = -1;

    foreach (['l', 'c'] as $d)
    {
        $shape_array = [];

        for ($i = 0; $i < count($grid); $i++)
        {
            $line = [];

            for ($j = 0; $j < count($grid[0]); $j++)
            {
                $n = $d == 'l' ? $grid[$i][$j] : $grid[$j][$i];
                $line[] = $n;

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
                if ($mult >= 3) return ["MULT", [$d, $d == 'l' ? $i : $j, $d == 'l' ? $j : $i]];

                // règle d'apparence
                if ($n == 1) $c_one++;
            }

            // erreur égalité d'apparence
            if ($c_one != count($grid)/2) return ["UNSTABLE", [$d, $i, $c_one]];

            // erreur motif
            $line = implode("", $line);
            if (in_array($line, $shape_array)) return ["SHAPE", [$d, $i]];
            else $shape_array[] = $line;
        }
    }

    return null;
}

$passing = [[1, 0, 1, 0], [1, 1, 0, 0], [0, 1, 0, 1], [0, 0, 1, 1]];
$shape = [[1, 0, 1, 0], [1, 0, 1, 0], [0, 1, 0, 1], [0, 1, 0, 1]];
$count = [[1, 0, 1, 0], [1, 1, 0, 0], [0, 1, 0, 1], [1, 0, 1, 1]];
$mult = [[1, 0, 1, 0], [1, 1, 0, 0], [0, 1, 0, 1], [0, 1, 1, 1]];

var_dump(verify($passing));
echo '<br>';
var_dump(verify($shape));
echo '<br>';
var_dump(verify($count));
echo '<br>';
var_dump(verify($mult));
echo '<br>';

$start = microtime(true);
verify($passing);
verify($shape);
verify($count);
verify($mult);
$end = microtime(true);

echo $end - $start;