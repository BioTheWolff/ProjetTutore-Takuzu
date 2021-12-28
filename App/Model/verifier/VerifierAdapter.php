<?php

require_once 'IVerifier.php';
require_once 'GridVerifier.php';

class VerifierAdapter implements IVerifier
{

    private static function handle_insertions(string $direction = null, int $i = null, array $candidates = null): ?array
    {
        if (!is_null($direction) && !is_null($i) && !is_null($candidates))
        {
            $insertions = [];

            foreach ($candidates as $item)
            {
                [$j, $v] = $item;
                $insertions[$direction == 'l' ? "$i:$j" : "$j:$i"] = $v;
            }

            return $insertions;
        }
        else return null;
    }

    private static function _verify(int $format, array $grid, array $insertions = null)
    {
        $res = GridVerifier::verify($grid, $insertions);

        $ensure_full = $format & IVerifier::FORMAT_ENSURE_FULL;
        $return_format = $format & 0b1111;

        if ($ensure_full && !$res[0]) throw new RuntimeException("Grid is not full");

        switch ($return_format)
        {
            case IVerifier::FORMAT_CODE:
                return $res[1];

            case IVerifier::FORMAT_ARRAY:
                return $res;

            case IVerifier::FORMAT_MESSAGE:
                return GridVerifier::format_message(array_slice($res, 1));

            case IVerifier::FORMAT_CHECK_NOERR:
                return IVerifier::CODE_NOERR == $res[1];

            default:
                throw new RuntimeException("Unrecognised verifier format.");
        }
    }

    public static function get_message(array $grid, bool $force_full = false, string $direction = null, int $i = null, array $candidates = null)
    {
        $format = self::FORMAT_MESSAGE | ($force_full * self::FORMAT_ENSURE_FULL);
        return self::_verify($format, $grid, self::handle_insertions($direction, $i, $candidates));
    }

    public static function is_valid(array $grid, bool $force_full = false, string $direction = null, int $i = null, array $candidates = null)
    {
        $format = self::FORMAT_CHECK_NOERR | ($force_full * self::FORMAT_ENSURE_FULL);
        return self::_verify($format, $grid, self::handle_insertions($direction, $i, $candidates));
    }

    public static function get_code(array $grid, bool $force_full = false, string $direction = null, int $i = null, array $candidates = null)
    {
        $format = self::FORMAT_CODE | ($force_full * self::FORMAT_ENSURE_FULL);
        return self::_verify($format, $grid, self::handle_insertions($direction, $i, $candidates));
    }
}