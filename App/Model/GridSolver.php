<?php

class GridSolver
{

    /**
     * The grid variable where in-place replacement happens
     * @var array $grid
     */
    private $grid;

    /**
     * The list of hypothesis made by the program
     * @var Grid[] $backtrace
     */
    private $backtrace;

    /**
     * The gap type.
     * Setting it as an instance variable solves the dependency import order problem
     * @var int $gap
     */
    private $gap;

    private function __construct(array $grid)
    {
        $this->grid = $grid;
        $this->backtrace = [];
        $this->gap = Adapter::GAP_PHP;
    }


    /**
     * Solves a given grid
     *
     * @param array $grid the grid to solve
     * @return array the solved grid
     */
    public static function solveGrid(array $grid): array {
        $ins = new GridSolver($grid);
        $ins->solve();
        return $ins->grid;
    }


    private function solve()
    {
        // FIXME dummy function that fills the grid with 0s ; THIS IS A PLACEHOLDER

        while (!$this->filled())
        {
            foreach (['l', 'c'] as $d)
            {
                for ($i = 0; $i < count($this->grid); $i++)
                {
                    for ($j = 0; $j < count($this->grid); $j++)
                    {

                        if ($this->get($d, $i, $j) != $this->gap) continue;

                    }
                }
            }
        }

    }

    private function get(string $direction, int $i, int $j): int
    {
        return $direction == 'l' ? $this->grid[$i][$j] : $this->grid[$j][$i];
    }

    private function filled(): bool
    {
        /**
         * @see https://stackoverflow.com/questions/4128323/in-array-and-multidimensional-array/4128377#4128377 original solution
         * @param mixed $needle what to look for
         * @param array $haystack where to look in
         * @return bool if the object was found
         */
        function in_array_r($needle, array $haystack): bool
        {
            foreach ($haystack as $item) {
                if ($item == $needle || (is_array($item) && in_array_r($needle, $item))) {
                    return true;
                }
            }

            return false;
        }

        return in_array_r($this->gap, $this->grid);

    }

}