<?php

use PHPUnit\Framework\TestCase;

require_once 'App/Lib/Path.php';
require_once Path::get_path('l', 'Adapter');
require_once Path::get_path('m', 'GridVerifier');

class GridVerifierTest extends TestCase
{

    const G = Adapter::GAP_PHP;

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
        return $code == IVerifier::code(IVerifier::FORMAT_CODE, $grid);
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
