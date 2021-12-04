<?php

interface IVerifier
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

    static function get_message(array $grid, bool $force_full = false, string $direction = null, int $i = null, array $candidates = null);

    static function is_valid(array $grid, bool $force_full = false, string $direction = null, int $i = null, array $candidates = null);

}