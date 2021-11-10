<?php

class GridSolver
{

    /**
     * @var array $grid
     */
    private $grid;

    /**
     * @var array $backtrace
     */
    private $backtrace;


    private function __construct(array $grid)
    {
        $this->grid = $grid;
        $this->backtrace = [];
    }


    /**
     * Solves a given grid
     *
     * @param array $grid the grid to solve
     * @return array the solved grid
     */
    public static function solveGrid(array $grid): string
    {
        $ins = new GridSolver($grid);
        $ins->solve();
        return Adapter::grid_to_message($ins->grid);
    }


    private function solve()
    {
        // FIXME dummy function that fills the grid with 0s ; THIS IS A PLACEHOLDER

        for ($i = 0; $i < count($this->grid); $i++) {
            for ($j = 0; $j < count($this->grid); $j++) {
                $this->grid[$i][$j] = 0;
            }
        }
    }
}

