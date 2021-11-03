<?php

class Grid
{

    /**
     * @see GridSolver::$grid
     * @var array $grid
     */
    private $grid;

    /**
     * @see GridSolver::$gaps_table
     * @var array $gaps_table
     */
    private $gaps_table;

    /**
     * The hypothesis made when creating this grid.
     * Will be used to invert the values when unstacking the grid from the backtrace
     * @see GridSolver::$backtrace for information about the backtrace
     * @var array $hypothesis
     */
    private $hypothesis;

    public function __construct(array $grid, array $gaps_table, array $hypothesis)
    {
        $this->grid = $grid;
        $this->gaps_table = $gaps_table;
        $this->hypothesis = $hypothesis;
    }

    /**
     * @return array
     */
    public function getGrid(): array
    {
        return $this->grid;
    }

    /**
     * @return array
     */
    public function getGapsTable(): array
    {
        return $this->gaps_table;
    }

    /**
     * @return array
     */
    public function getHypothesis(): array
    {
        return $this->hypothesis;
    }

}