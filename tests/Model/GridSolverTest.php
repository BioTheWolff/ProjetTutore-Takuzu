<?php

use PHPUnit\Framework\TestCase;

require_once 'App/Lib/Path.php';
require_once Path::get_path('l', 'Adapter');
require_once Path::get_path('m', 'GridSolver');

class GridSolverTest extends TestCase
{

    const G = Adapter::GAP_PHP;

    private $expected = [
        [1, 0, 1, 0],
        [1, 1, 0, 0],
        [0, 1, 0, 1],
        [0, 0, 1, 1]
    ];

    private $multGrid = [
        [1, self::G, 1, 0],
        [1, 1, self::G, 0],
        [0, 1, self::G, 1],
        [0, 0, self::G, 1]
    ];

    private $appearance1Grid = [
        [1, self::G, 1, self::G],
        [1, 1, self::G, 0],
        [0, 1, self::G, 1],
        [self::G, 0, self::G, 1]
    ];

    public function testSolveFullGrid()
    {

        self::assertEquals($this->expected, GridSolver::solveGrid($this->multGrid));
    }

    public function testSolveGridMultOnly()
    {
        self::assertEquals($this->expected, GridSolver::solveGrid($this->multGrid));
    }

    public function testGapsTable()
    {
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

        $object = $constructorReflection->invokeArgs(null, [$this->multGrid]);

        self::assertEquals($table, $tableReflection->getValue($object));
        $solveReflection->invoke($object);
        self::assertEquals($emptyTable, $tableReflection->getValue($object));

    }

    public function testSolveGridDistance1()
    {
        self::assertEquals($this->expected, GridSolver::solveGrid($this->appearance1Grid));
    }
}
