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

    private $mult_col = [
        [1, 0, 1, 0],
        [0, 0, 1, 1],
        [1, 0, 0, 1],
        [0, 1, 0, 1]
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

    private $partial = [
        [5, 0, 1, 0],
        [1, 1, 0, 0],
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
        self::assertTrue(self::check(IVerifier::CODE_MULT, $this->mult_col));
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
        self::assertEquals("MULT:c:2:1", VerifierAdapter::get_message($this->mult_col));
        self::assertEquals("UNSTABLE:l:1:3", VerifierAdapter::get_message($this->equality));
        self::assertEquals("SHAPE:l:1:-1", VerifierAdapter::get_message($this->shape));
    }

    /**
     * @covers VerifierAdapter
     * @covers GridVerifier
     */
    public function testEnforceFullGrid()
    {
        $this->expectException("RuntimeException");
        VerifierAdapter::is_valid($this->partial, true);
    }

    /**
     * @covers VerifierAdapter
     * @covers GridVerifier
     */
    public function testFunctioningArray()
    {
        self::assertEquals([true, IVerifier::CODE_NOERR], VerifierAdapter::raw_output($this->valid));
    }

    /**
     * @covers GridVerifier::get_message_from_code
     */
    public function testEdgeCase1()
    {
        self::assertEquals("OK", GridVerifier::get_message_from_code(IVerifier::CODE_NOERR));
    }

    /**
     * @covers GridVerifier::get_message_from_code
     */
    public function testEdgeCase2()
    {
        $this->expectException("RuntimeException");
        GridVerifier::get_message_from_code(-150);
    }

    /**
     * @covers GridVerifier::format_message
     */
    public function testEdgeCase3()
    {
        $this->expectException("RuntimeException");
        GridVerifier::format_message([-150, 0]);
    }

    /**
     * @covers VerifierAdapter::_verify
     * @covers GridVerifier::verify
     */
    public function testEdgeCase4()
    {
        $reflection = new ReflectionMethod(VerifierAdapter::class, "_verify");
        $reflection->setAccessible(true);

        self::assertNull($reflection->invokeArgs(null, [-150, $this->valid]));
    }
}
