<?php

use PHPUnit\Framework\TestCase;

require_once 'App/Lib/Path.php';
require_once Path::get_path('l', 'Douane');

class DouaneTest extends TestCase
{

    public function testMessage()
    {
        self::assertFalse(Douane::message("truc"));

        self::assertFalse(Douane::message(":0100011100"));

        self::assertFalse(Douane::message("8:10101010"));

        self::assertTrue(Douane::message("4:1010101010101010"));
    }
}
