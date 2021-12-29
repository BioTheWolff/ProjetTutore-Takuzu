<?php

require_once 'App/Lib/Path.php';
require_once Path::get_path('m', 'Grid');

use PHPUnit\Framework\TestCase;

class GridTest extends TestCase
{

    /**
     * @var Grid $grid
     */
    private static $instance;

    private const grid = [
        [1, 0, 1, 0],
        [1, 1, 0, 0],
        [0, 1, 0, 1],
        [0, 0, 1, 1]
    ];

    private const gaps_table = [
        'lines' => [0, 0, 0, 0],
        'columns' => [0, 0, 0, 0]
    ];

    private const hypothesis = ['l', 2, [0, 1]];

    public static function setUpBeforeClass(): void
    {
        self::$instance = new Grid(self::grid, self::gaps_table, 0, self::hypothesis);
    }

    /**
     * @covers Grid::__construct
     * @covers Grid::getHypothesis
     */
    public function testGetHypothesis()
    {
        self::assertEquals(self::hypothesis, self::$instance->getHypothesis());
    }

    /**
     * @covers Grid::__construct
     * @covers Grid::getGapsNumber
     */
    public function testGetGapsNumber()
    {
        self::assertEquals(0, self::$instance->getGapsNumber());
    }

    /**
     * @covers Grid::__construct
     * @covers Grid::getGrid
     */
    public function testGetGrid()
    {
        self::assertEquals(self::grid, self::$instance->getGrid());
    }

    /**
     * @covers Grid::__construct
     * @covers Grid::getGapsTable
     */
    public function testGetGapsTable()
    {
        self::assertEquals(self::gaps_table, self::$instance->getGapsTable());
    }
}
