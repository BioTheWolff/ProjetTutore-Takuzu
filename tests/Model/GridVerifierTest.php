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

    /**
     * @covers VerifierAdapter
     * @covers GridVerifier::verify
     */
    public function testValid()
    {
        self::assertTrue(VerifierAdapter::is_valid($this->valid));
    }

    /**
     * @covers VerifierAdapter
     * @covers GridVerifier::verify
     */
    public function testErrorMult()
    {
        self::assertTrue(self::check(IVerifier::CODE_MULT, $this->mult));
    }

    /**
     * @covers VerifierAdapter
     * @covers GridVerifier::verify
     */
    public function testErrorEquality()
    {
        self::assertTrue(self::check(IVerifier::CODE_STABILITY, $this->equality));
    }

    /**
     * @covers VerifierAdapter
     * @covers GridVerifier::verify
     */
    public function testErrorShape()
    {
        self::assertTrue(self::check(IVerifier::CODE_SHAPE, $this->shape));
    }

    /**
     * @covers VerifierAdapter
     * @covers GridVerifier
     */
    public function testFunctioningMessage()
    {
        self::assertEquals("OK", VerifierAdapter::get_message($this->valid));
        self::assertEquals("MULT:l:0:2", VerifierAdapter::get_message($this->mult));
    }
}
