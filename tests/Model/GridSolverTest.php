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

    public function testGapsTable()
    {
        $grid = [
            [1, self::G, 1, 0],
            [1, 1, self::G, 0],
            [0, 1, self::G, 1],
            [0, 0, self::G, 1]
        ];

        $table = [
            'lines' => [1, 1, 1, 1],
            'columns' => [0, 1, 3, 0],
        ];
        $emptyTable = [
            'lines' => [0, 0, 0, 0],
            'columns' => [0, 0, 0, 0],
        ];


        $constructorReflection = new ReflectionMethod(GridSolver::class, "prepareGrid");
        $constructorReflection->setAccessible(true);

        $solveReflection = new ReflectionMethod(GridSolver::class, 'solve');
        $solveReflection->setAccessible(true);

        $tableReflection = new ReflectionProperty(GridSolver::class, 'gaps_table');
        $tableReflection->setAccessible(true);

        $object = $constructorReflection->invokeArgs(null, [$grid]);

        self::assertEquals($table, $tableReflection->getValue($object));
        $solveReflection->invoke($object);
        self::assertEquals($emptyTable, $tableReflection->getValue($object));

    }
}
