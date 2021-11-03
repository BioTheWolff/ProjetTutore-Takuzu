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

    /**
     * The table that contains the number of gaps per line/column.
     * Follows the structure `['lines' => [...], 'columns' => [...]]`
     * @var array $gaps_table
     */
    private $gaps_table;

    private function __construct(array $grid)
    {
        $this->grid = $grid;
        $this->backtrace = [];
        $this->gap = Adapter::GAP_PHP;

        $this->gaps_table = [
            'lines' => [],
            'columns' => []
        ];
        self::countgaps();
    }

    /**
     * Solves a given grid
     *
     * @param array $grid the grid to solve
     * @return array the solved grid
     */
    public static function solveGrid(array $grid): array
    {
        $ins = new GridSolver($grid);
        $ins->solve();
        return $ins->grid;
    }

    /**
     * Used only for testing
     *
     * @param array $grid the grid
     * @return GridSolver
     */
    private static function prepareGrid(array $grid): GridSolver
    {
        return new GridSolver($grid);
    }


    // MAIN FUNCTION

    private function solve()
    {
        while (!$this->filled())
        {
            // directions
            foreach (['l', 'c'] as $d)
            {
                // lines
                for ($i = 0; $i < count($this->grid); $i++)
                {
                    // columns
                    for ($j = 0; $j < count($this->grid); $j++)
                    {

                        // skip the "non-gaps" cells
                        if ($this->get($d, $i, $j) != $this->gap) continue;

                        // try to solve using the multiplicity constraint
                        if (($v = $this->check_mult($d, $i, $j)) !== null) $this->fill($d, $i, $j, 1-$v);

                    }

                    // at the end of the line/column
                    // try to solve using the equal appearance constraint
                    switch ($this->get_gaps($d, $i))
                    {
                        case 0:
                            // skip if we have no gaps in this line/column
                            break;

                        case 1:
                            // we just need to count the distance to fill it
                            $this->fill($d, $i,
                                $this->find_first_candidate($d, $i),
                                $this->count_ones_distance($d, $i)
                            );
                            break;

                        case 2:
                            switch ($this->count_ones_distance($d, $i))
                            {
                                case 2:
                                    // missing two "1" from the line
                                    $this->fill_first_candidate($d, $i, 1);
                                    $this->fill_first_candidate($d, $i, 1);
                                    break;

                                case 0:
                                    // missing two "0" from the line
                                    $this->fill_first_candidate($d, $i, 0);
                                    $this->fill_first_candidate($d, $i, 0);
                                    break;

                                case 1:
                                    // this is where the paths diverge
                                    // possibilities are 1/0 and 0/1 (in order)

                                    // we test both options
                                    // TODO: FILL THAT EMPTY SPACE
                                    break;

                            }
                            break;

                        default:
                            break;
                    }
                }
            }
        }
    }


    // UTILS | GETTERS

    private function get(string $direction, int $i, int $j): int
    {
        return $direction == 'l' ? $this->grid[$i][$j] : $this->grid[$j][$i];
    }

    private function find_first_candidate(string $direction, int $i): int
    {
        for ($counter = 0; $counter < count($this->grid); $counter++)
        {
            if ($this->get($direction, $i, $counter) == $this->gap) return $counter;
        }
        return -1;
    }

    // UTILS | FILLERS

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

        $this->gaps_table['lines'][$i]--;
        $this->gaps_table['columns'][$j]--;
    }

    private function fill_first_candidate(string $direction, int $i, int $value)
    {
        $this->fill($direction, $i, $this->find_first_candidate($direction, $i), $value);
    }

    private function filled(): bool
    {
        return $this->gaps_number == 0;
    }

    // UTILS | COUNTERS

    private function countgaps()
    {
        $n = 0;

        // Count the number of gaps per line
        // Also counts the total number of gaps
        foreach ($this->grid as $line)
        {
            $lc = 0;

            foreach ($line as $item)
            {
                if ($item == $this->gap) $lc++;
            }

            $n += $lc;
            $this->gaps_table['lines'][] = $lc;
        }

        $this->gaps_number = $n;

        // Count the number of gaps per column
        for ($i = 0; $i < count($this->grid); $i++)
        {
            $cc = 0;

            for ($j = 0; $j < count($this->grid); $j++)
            {
                if ($this->get('c', $i, $j) == $this->gap) $cc++;
            }

            $this->gaps_table['columns'][] = $cc;
        }
    }

    private function get_gaps(string $direction, int $i)
    {
        return $this->gaps_table[$direction == 'c' ? 'columns' : 'lines'][$i];
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

    /**
     * Counts the number of ones in the line/column then returns the distance between the current value and the expected one.
     * The expected value is `$grid_size/2` (following the equal appearance constraint)
     *
     * @param string $direction the direction we are going through the grid with
     * @param int $i the line/column
     * @return int the distance from the expected number of ones in the line/column
     */
    private function count_ones_distance(string $direction, int $i): int
    {
        $n = 0;
        for ($counter = 0; $counter < count($this->grid); $counter++)
        {
            if ($this->get($direction, $i, $counter) == 1) $n++;
        }
        return abs($n - count($this->grid)/2);
    }
}