<?php

use PHPUnit\Framework\TestCase;

require_once 'App/Lib/Path.php';
require_once Path::get_path('m', ['verifier', 'VerifierAdapter']);

class GridVerifierTest extends TestCase
{

    private $valid = [
        [1, 0, 1, 0],
        [1, 1, 0, 0],
        [0, 1, 0, 1],
        [0, 0, 1, 1]
    ];

    private $mult = [
        [1, 1, 1, 0],
        [1, 1, 0, 0],
        [0, 1, 0, 1],
        [0, 0, 1, 1]
    ];

    private $equality = [
        [1, 0, 1, 0],
        [1, 1, 0, 1],
        [0, 1, 0, 1],
        [0, 0, 1, 1]
    ];

    private $shape = [
        [1, 0, 1, 0],
        [1, 0, 1, 0],
        [0, 1, 0, 1],
        [0, 0, 1, 1]
    ];

    private static function check(int $code, array $grid): bool
    {
        return $code == VerifierAdapter::get_code($grid);
    }

    public function testValid()
    {
        self::assertTrue(self::check(IVerifier::CODE_NOERR, $this->valid));
    }

    public function testErrorMult()
    {
        self::assertTrue(self::check(IVerifier::CODE_MULT, $this->mult));
    }

    public function testErrorEquality()
    {
        self::assertTrue(self::check(IVerifier::CODE_STABILITY, $this->equality));
    }

    public function testErrorShape()
    {
        self::assertTrue(self::check(IVerifier::CODE_SHAPE, $this->shape));
    }
}
