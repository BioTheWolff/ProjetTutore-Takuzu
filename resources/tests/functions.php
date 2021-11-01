<?php

CONST GAP = 5;

function partial_verify(array $grid, array $insert_pos = null, int $insertion = null): ?array
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

                if ($n == GAP) $is_full = false;

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
                if ($seen != GAP && $mult >= 3) return ["MULT", [$d, $d == 'l' ? $i : $j, $d == 'l' ? $j : $i]];

                // règle d'apparence
                if ($n == 1) $c_one++;
            }

            if (!$is_full) continue;

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


function number_of_gaps(array $grid): int
{
    $n = 0;

    for ($i = 0; $i < count($grid); $i++)
    {
        for ($j = 0; $j < count($grid[0]); $j++)
        {
            if ($grid[$i][$j] == GAP) $n++;
        }
    }

    return $n;
}


function get(array $grid, string $direction, int $i, int $j)
{
    return $direction == 'l' ? $grid[$i][$j] : $grid[$j][$i];
}


function solve(array $grid): array
{
    $gaps = number_of_gaps($grid);
    $filled = ($gaps == 0);

    while (!$filled)
    {
        foreach (['l', 'c'] as $d)
        {
            for ($i = 0; $i < count($grid); $i++)
            {
                for ($j = 0; $j < count($grid[0]); $j++)
                {
                    // si la case est remplie, on continue
                    if (get($grid, $d, $i, $j) != GAP) continue;

                    $changed = false;


                    if ($j >= 2
                        && ($c = get($grid, $d, $i, $j-1)) == get($grid, $d, $i, $j-2)
                        && is_null(partial_verify($grid, [$d == 'l' ? $i : $j, $d == 'l' ? $j : $i], 1 - $c))
                    )
                    {
                        $grid[$d == 'l' ? $i : $j][$d == 'l' ? $j : $i] = 1 - $c;
                        $changed = true;
                    }

                    if ($j >= 1 && $j < count($grid[0])-1
                        && ($c = get($grid, $d, $i, $j-1)) == get($grid, $d, $i, $j+1)
                        && is_null(partial_verify($grid, [$d == 'l' ? $i : $j, $d == 'l' ? $j : $i], 1 - $c))
                    )
                    {
                        $grid[$d == 'l' ? $i : $j][$d == 'l' ? $j : $i] = 1 - $c;
                        $changed = true;
                    }

                    if ($j < count($grid[0])-2
                        && ($c = get($grid, $d, $i, $j+1)) == get($grid, $d, $i, $j+2)
                        && is_null(partial_verify($grid, [$d == 'l' ? $i : $j, $d == 'l' ? $j : $i], 1 - $c))
                    )
                    {
                        $grid[$d == 'l' ? $i : $j][$d == 'l' ? $j : $i] = 1 - $c;
                        $changed = true;
                    }


                    if ($changed == true) $filled = (--$gaps == 0);
                }
            }
        }
    }

    return $grid;
}