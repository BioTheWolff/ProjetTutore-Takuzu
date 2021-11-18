<?php

/**
 * Cette classe permet de vérifier une grille
 *
 * @author Fabien Zoccola
 */
class GridVerifier
{

    const FORMAT_CODE = 0b1;
    const FORMAT_ARRAY = 0b10;
    const FORMAT_MESSAGE = 0b100;
    const FORMAT_CHECK_NOERR = 0b1000;
    const FORMAT_ENSURE_FULL = 0b100000;

    const CODE_NOERR = 0;
    const CODE_MULT = 1;
    const CODE_STABILITY = 2;
    const CODE_SHAPE = 3;

    private static $MESSAGE_NOERR = "OK";
    private static $MESSAGE_MULT = "MULT";
    private static $MESSAGE_STABILITY = "UNSTABLE";
    private static $MESSAGE_SHAPE = "SHAPE";

    public static function verify(int $format, array $grid, array $insertions = null)
    {
        $res = self::partial_verify($grid, $insertions);

        $ensure_full = $format & self::FORMAT_ENSURE_FULL;
        $return_format = $format & 0b1111;

        if ($ensure_full && !$res[0]) throw new RuntimeException("Grid is not full");

        switch ($return_format)
        {
            case self::FORMAT_CODE:
                return $res[1];

            case self::FORMAT_ARRAY:
                return $res;

            case self::FORMAT_MESSAGE:
                return self::format_message(array_slice($res, 1, null));

            case self::FORMAT_CHECK_NOERR:
                return self::CODE_NOERR == $res[1];

            default:
                throw new RuntimeException("Unrecognised verifier format.");
        }
    }

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
    private static function partial_verify(array $grid, array $insertions = null): array
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

                    if ($n == Adapter::GAP_PHP) {
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
                    if ($seen != Adapter::GAP_PHP && $mult >= 3)
                        return [$grid_is_full, self::CODE_MULT, $d, $i, $j];

                    // règle d'apparence
                    if ($n == 1) $c_one++;
                }

                if (!$is_full) continue;

                // erreur égalité d'apparence
                if ($c_one != count($grid)/2) return [$grid_is_full, self::CODE_STABILITY, $d, $i, $c_one];

                // erreur motif
                $line = implode("", $line);
                if (in_array($line, $shape_array)) return [$grid_is_full, self::CODE_SHAPE, $d, $i];
                else $shape_array[] = $line;
            }
        }

        return [$grid_is_full, self::CODE_NOERR];
    }

    private static function format_message(array $result): string
    {
        $code = $result[0];

        switch ($code)
        {
            case self::CODE_NOERR:
                return self::$MESSAGE_NOERR;

            case self::CODE_SHAPE:
                return self::format_error($code, $result[1], $result[2]);

            case self::CODE_STABILITY:
            case self::CODE_MULT:
                return self::format_error($code, $result[1], $result[2], $result[3]);

            default:
                throw new RuntimeException("Unrecognised verifier code.");
        }
    }

    private static function get_message_from_code(int $code): string
    {
        switch ($code)
        {
            case self::CODE_NOERR:
                return self::$MESSAGE_NOERR;
            case self::CODE_MULT:
                return self::$MESSAGE_MULT;
            case self::CODE_STABILITY:
                return self::$MESSAGE_STABILITY;
            case self::CODE_SHAPE:
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
    private static function format_error(string $code, string $direction, int $line, int $other = -1): string
    {
        // invert line and column if the multiplicity is found in columns,
        // so we follow the pattern "line:column"
        if ($code == self::CODE_MULT && $direction == "c")
        {
            $temp = $line;
            $line = $other;
            $other = $temp;
        }

        $message = self::get_message_from_code($code);
        return "$message:$direction:$line:$other";
    }
}