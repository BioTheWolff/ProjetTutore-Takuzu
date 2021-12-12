<?php

interface IMessages
{
    const GAP_JS = '_';
    const GAP_PHP = 5;

    static function verify(string $message);

    static function solve(string $message);

}