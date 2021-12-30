<?php

require_once 'App/Lib/Path.php';
require_once Path::get_path('m', ['messages', 'MessageAdapter']);

use PHPUnit\Framework\TestCase;

class GridGeneratorTest extends TestCase
{

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
        for ($i=0; $i < 100; $i++)
        {
            $grid = GridGenerator::generate(6, .25);
            self::assertTrue(VerifierAdapter::is_valid($grid), "Invalid grid on round $i");
        }
    }
}
