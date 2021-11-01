<?php

use PHPUnit\Framework\TestCase;

require_once 'App/Lib/Path.php';
require_once Path::get_path('l', 'Adapter');
require_once Path::get_path('m', 'GridSolver');

class GridSolverTest extends TestCase
{

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
}
