<?php

require_once 'App/Lib/Path.php';
require_once Path::get_path('m', ['messages', 'MessageAdapter']);

use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase
{
    private const G = IMessages::GAP_PHP;

    private const fullExpected = "8:0101100101010110101001010110100110010110010010111011010010101010";

    private const fullGrid = "8:_____0__0______0__1__________0___00____0___0_____0____00_0_0_0_0";

    /**
     * @covers MessageAdapter
     * @covers GridSolver
     * @covers VerifierAdapter
     * @covers GridVerifier
     * @covers Grid
     */
    public function testSolve()
    {
        self::assertEquals(self::fullExpected, MessageAdapter::solve(self::fullGrid));
    }

    /**
     * @covers MessageAdapter
     * @covers VerifierAdapter
     * @covers GridVerifier
     */
    public function testVerify()
    {
        self::assertEquals("OK", MessageAdapter::verify(self::fullExpected));
    }

    /**
     * @covers MessageAdapter
     * @covers GridGenerator
     * @covers GridSolver
     * @covers VerifierAdapter
     * @covers GridVerifier
     * @covers Grid
     */
    public function testGenerate()
    {
        $generated = MessageAdapter::generate(8, .25);
        [$size,] = explode(":", $generated);
        $size = (int)$size;

        self::assertEquals(8, $size);
        $this->assertLessThanOrEqual(.25, GridGenerator::count_fill_percentage(MessageAdapter::message_to_grid($generated)));
    }
}
