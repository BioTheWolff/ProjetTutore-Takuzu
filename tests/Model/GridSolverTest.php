<?php

use PHPUnit\Framework\TestCase;

require_once 'App/Lib/Path.php';
require_once Path::get_path('l', 'Adapter');
require_once Path::get_path('m', 'GridSolver');

class GridSolverTest extends TestCase
{

    const G = Adapter::GAP_PHP;

    public function testSolveFullGrid()
    {
        $grid = [
            [1, 0, 1, 0],
            [1, 1, 0, 0],
            [0, 1, 0, 1],
            [0, 0, 1, 1]
        ];

        self::assertEquals($grid, GridSolver::solveGrid($grid));
    }

    public function testSolveGridMultOnly()
    {
        $expected = [
            [1, 0, 1, 0],
            [1, 1, 0, 0],
            [0, 1, 0, 1],
            [0, 0, 1, 1]
        ];
        $grid = [
            [1, self::G, 1, 0],
            [1, 1, self::G, 0],
            [0, 1, self::G, 1],
            [0, 0, self::G, 1]
        ];

        self::assertEquals($expected, GridSolver::solveGrid($grid));
    }
}
