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

    /**
     * The number of remaining gaps to fill
     * @var int $gaps_number
     */
    private $gaps_number;

    private function __construct(array $grid)
    {
        $this->grid = $grid;
        $this->backtrace = [];
        $this->gap = Adapter::GAP_PHP;
        $this->gaps_number = self::countgaps();
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


    // MAIN FUNCTION

    private function solve()
    {
        while (!$this->filled())
        {
            foreach (['l', 'c'] as $d)
            {
                for ($i = 0; $i < count($this->grid); $i++)
                {
                    for ($j = 0; $j < count($this->grid); $j++)
                    {

                        if ($this->get($d, $i, $j) != $this->gap) continue;

                        if (($v = $this->check_mult($d, $i, $j)) !== null) $this->fill($d, $i, $j, 1-$v);

                    }
                }
            }
        }
    }


    // UTILS

    private function get(string $direction, int $i, int $j): int
    {
        return $direction == 'l' ? $this->grid[$i][$j] : $this->grid[$j][$i];
    }

    private function fill(string $direction, int $i, int $j, int $value)
    {
        if ($direction == 'c')
        {
            $temp = $i;
            $i = $j;
            $j = $temp;
        }

        $this->grid[$i][$j] = $value;
        $this->gaps_number--;
    }

    private function filled(): bool
    {
        return $this->gaps_number == 0;
    }

    private function countgaps(): int
    {
        $n = 0;

        foreach ($this->grid as $line)
        {
            foreach ($line as $item)
            {
                if ($item == $this->gap) $n++;
            }
        }

        return $n;
    }


    // CHECKS

    /**
     * Checks whether the current gap fits one of the patterns below:
     *
     * using X in {0,1} and _ the gap:
     *  - XX_
     *  - X_X
     *  - _XX
     *
     *
     * @param string $direction the direction the program is looking at the grid with
     * @param int $i the line
     * @param int $j the column
     * @return int|null the repeating char if the grid fits one of the patterns above, else null
     */
    private function check_mult(string $direction, int $i, int $j): ?int
    {
        $size = count($this->grid);
        $c = null;

        $cond = (
            // XX_ pattern
            ($j >= 2 && (($c = self::get($direction, $i, $j-1)) == self::get($direction, $i, $j-2))) ||
            // X_X pattern
            ($j >= 1 && $j < $size-1 && (($c =self::get($direction, $i, $j-1)) == self::get($direction, $i, $j+1))) ||
            // _XX pattern
            ($j < $size-2 && (($c = self::get($direction, $i, $j+1)) == self::get($direction, $i, $j+2)))
        );

        return $cond ? $c : null;
    }
}