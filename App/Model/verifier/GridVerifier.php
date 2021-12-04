<?php

/**
 * Cette classe permet de vérifier une grille
 *
 * @author Fabien Zoccola
 */
class GridVerifier
{

    private static $MESSAGE_NOERR = "OK";
    private static $MESSAGE_MULT = "MULT";
    private static $MESSAGE_STABILITY = "UNSTABLE";
    private static $MESSAGE_SHAPE = "SHAPE";

    /**
     * Vérifie que la grille ne viole aucune règle du jeu.
     *
     * La vérification partielle est possible.
     * On utilisera les paramètres insert_pos et insertion pour virtuellement "insérer" une valeur dans la grille
     * afin de vérifier que la grille est toujours valide (utilisé lors de la résolution).
     *
     * @param array $grid la grille d'entiers
     * @param array|null $insertions l'array de valeurs à insérer (format: `["line:column" => value]`)
     * @return array le retour (UNSTABLE, SHAPE, MULT ou OK)
     */
    public static function verify(array $grid, array $insertions = null): array
    {
        $mult = -1;
        $c_one = 0;
        $seen = -1;
        $grid_is_full = true;

        foreach (['l', 'c'] as $d)
        {
            $shape_array = [];

            for ($i = 0; $i < count($grid); $i++)
            {
                $line = [];
                $is_full = true;

                for ($j = 0; $j < count($grid[0]); $j++)
                {
                    $n = ($d == 'l'
                        ? (!is_null($insertions) && array_key_exists("$i:$j", $insertions) ? $insertions["$i:$j"] : $grid[$i][$j])
                        : (!is_null($insertions) && array_key_exists("$j:$i", $insertions) ? $insertions["$j:$i"] : $grid[$j][$i])
                    );
                    $line[] = $n;

                    // a gap
                    if ($n == 5) {
                        $grid_is_full = false;
                        $is_full = false;
                    }

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
                    if ($seen != 5 && $mult >= 3)
                        return [$grid_is_full, IVerifier::CODE_MULT, $d, $i, $j];

                    // règle d'apparence
                    if ($n == 1) $c_one++;
                }

                if (!$is_full) continue;

                // erreur égalité d'apparence
                if ($c_one != count($grid)/2) return [$grid_is_full, IVerifier::CODE_STABILITY, $d, $i, $c_one];

                // erreur motif
                $line = implode("", $line);
                if (in_array($line, $shape_array)) return [$grid_is_full, IVerifier::CODE_SHAPE, $d, $i];
                else $shape_array[] = $line;
            }
        }

        return [$grid_is_full, IVerifier::CODE_NOERR];
    }

    public static function format_message(array $result): string
    {
        $code = $result[0];

        switch ($code)
        {
            case IVerifier::CODE_NOERR:
                return self::$MESSAGE_NOERR;

            case IVerifier::CODE_SHAPE:
                return self::format_error($code, $result[1], $result[2]);

            case IVerifier::CODE_STABILITY:
            case IVerifier::CODE_MULT:
                return self::format_error($code, $result[1], $result[2], $result[3]);

            default:
                throw new RuntimeException("Unrecognised verifier code.");
        }
    }

    public static function get_message_from_code(int $code): string
    {
        switch ($code)
        {
            case IVerifier::CODE_NOERR:
                return self::$MESSAGE_NOERR;
            case IVerifier::CODE_MULT:
                return self::$MESSAGE_MULT;
            case IVerifier::CODE_STABILITY:
                return self::$MESSAGE_STABILITY;
            case IVerifier::CODE_SHAPE:
                return self::$MESSAGE_SHAPE;

            default:
                throw new RuntimeException("Unrecognised verifier code.");
        }
    }

    /**
     * @param string $code the error type
     * @param string $direction the direction the error was found in
     * @param int $line the line the error was found in
     * @param int $other another parameter. Column if MULT, number of ones in line/column if UNSTABLE. Defaults to -1
     * @return string the formatted error string
     */
    public static function format_error(string $code, string $direction, int $line, int $other = -1): string
    {
        // invert line and column if the multiplicity is found in columns,
        // so we follow the pattern "line:column"
        if ($code == IVerifier::CODE_MULT && $direction == "c")
        {
            $temp = $line;
            $line = $other;
            $other = $temp;
        }

        $message = self::get_message_from_code($code);
        return "$message:$direction:$line:$other";
    }
}