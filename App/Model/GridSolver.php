<?php

require_once 'verifier/VerifierAdapter.php';
require_once 'Grid.php';

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

    /**
     * Is used to see if the solver stalls (meaning no constraints are matching).
     * We need to pick at random and diverge
     * @var bool $filled_this_sweep
     */
    private $filled_this_sweep;

    private function __construct(array $grid)
    {
        $this->grid = $grid;
        $this->backtrace = [];
        $this->gap = 5;

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
            $this->filled_this_sweep = false;
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
                        if (($v = $this->check_mult($d, $i, $j)) !== null)
                        {
                            // prevent from inserting if we cannot insert
                            if (!$this->verify_with_values($d, $i, [$j => 1-$v])) {
                                $this->revert_hypothesis_and_apply_opposite();
                                continue;
                            }
                            $this->fill($d, $i, $j, 1-$v);
                        }

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
                                    // possibilities are 0/1 and 1/0 (in order)

                                    // we grab the two possible candidates
                                    $c1 = $this->find_first_candidate($d, $i);
                                    $c2 = $this->find_second_candidate($d, $i);

                                    // we test both options
                                    $zero_one = $this->verify_with_values($d, $i, [$c1 => 0, $c2 => 1]);
                                    $one_zero = $this->verify_with_values($d, $i, [$c1 => 1, $c2 => 0]);

                                    if ($zero_one && $one_zero)
                                    {
                                        // both are plausible, we diverge by trying one of both
                                        $this->stack_hypothesis($d, $i, [$c1 => 0, $c2 => 1]);
                                    }
                                    else if ($zero_one && !$one_zero)
                                    {
                                        // we apply the change
                                        $this->fill($d, $i, $c1, 0);
                                        $this->fill($d, $i, $c2, 1);
                                    }
                                    else if ($one_zero && !$zero_one)
                                    {
                                        // we apply the change
                                        $this->fill($d, $i, $c1, 1);
                                        $this->fill($d, $i, $c2, 0);
                                    }
                                    else
                                    {
                                        // none are possible, it seems this is a dead end
                                        // we un-stack one hypothesis (we "go back in time")
                                        $this->revert_hypothesis_and_apply_opposite();
                                    }

                                    break;

                            }
                            break;
                    }
                    // -- END "after line/column"
                }
                // -- END lines
            }
            // -- END directions

            // if nothing was filled in this sweep, we pick at "random" and diverge
            if (!$this->filled_this_sweep && !$this->filled())
            {
                // find the first candidate in the entire grid
                $i = 0;
                do $c = $this->find_first_candidate('l', ++$i);
                while ($c == -1);

                // try to assign it a value, if it doesn't work then do the opposite
                if ($this->verify_with_values('l', $i, [$c => 1]))
                    $this->stack_hypothesis('l', $i, [$c => 1]);
                else
                    $this->stack_hypothesis('l', $i, [$c => 0]);
            }

            // if the grid is filled, try running a verification one last time
            // if it fails (surely because of shape), unstack one hypothesis
            while ($this->filled() && !VerifierAdapter::is_valid($this->grid))
                $this->revert_hypothesis_and_apply_opposite();
        }
        // -- END while
    }


    // UTILS | GETTERS

    private function get(string $direction, int $i, int $j): int
    {
        return $direction == 'l' ? $this->grid[$i][$j] : $this->grid[$j][$i];
    }

    private function find_first_candidate(string $direction, int $i): int
    {
        if ($this->get_gaps($direction, $i) == 0) return -1;
        for ($counter = 0; $counter < count($this->grid); $counter++)
        {
            if ($this->get($direction, $i, $counter) == $this->gap) return $counter;
        }
        return -1;
    }

    private function find_second_candidate(string $direction, int $i): int
    {
        if ($this->get_gaps($direction, $i) == 0) return -1;
        for ($counter = $this->find_first_candidate($direction, $i)+1; $counter < count($this->grid); $counter++)
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

        $this->filled_this_sweep = true;
    }

    private function fill_first_candidate(string $direction, int $i, int $value)
    {
        $this->fill($direction, $i, $this->find_first_candidate($direction, $i), $value);
    }

    private function verify_with_values(string $direction, int $i, array $candidates): bool
    {
        return VerifierAdapter::is_valid($this->grid, false, $direction, $i, $candidates);
    }

    private function filled(): bool
    {
        return $this->gaps_number <= 0;
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
            ($j >= 2 && (($c = self::get($direction, $i, $j-1)) == self::get($direction, $i, $j-2)) && $c != $this->gap) ||
            // X_X pattern
            ($j >= 1 && $j < $size-1 && (($c =self::get($direction, $i, $j-1)) == self::get($direction, $i, $j+1)) && $c != $this->gap) ||
            // _XX pattern
            ($j < $size-2 && (($c = self::get($direction, $i, $j+1)) == self::get($direction, $i, $j+2)) && $c != $this->gap)
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


    // BACKTRACKING

    private function revert_hypothesis_and_apply_opposite()
    {
        if (empty($this->backtrace))
            throw new RuntimeException("Cannot unstack from an empty backtrace.");

        /** @var Grid $grid */
        $grid = array_pop($this->backtrace);

        $this->grid = $grid->getGrid();
        $this->gaps_number = $grid->getGapsNumber();
        $this->gaps_table = $grid->getGapsTable();

        [$direction, $i, $candidates] = $grid->getHypothesis();

        // fill the values according to the OPPOSITE of the hypothesis we just unstacked
        foreach ($candidates as $j => $v) $this->fill($direction, $i, $j, 1-$v);
    }

    private function stack_hypothesis(string $direction, int $i, array $candidates)
    {
        $this->backtrace[] = new Grid($this->grid, $this->gaps_table, $this->gaps_number, [$direction, $i, $candidates]);

        // fill the value from the hypothesis
        foreach ($candidates as $j => $v) $this->fill($direction, $i, $j, $v);
    }

    private function pretty_print_self()
    {
        echo "grid: [\n";
        foreach ($this->grid as $line)
        {
            echo '  [' . implode(', ', $line) . "]\n";
        }
        echo "]\n";

        echo "number of gaps: $this->gaps_number\n";

        echo "gaps table: [\n";
        foreach ($this->gaps_table as $e => $t)
        {
            echo "  $e => [" . implode(', ', $t) . "]\n";
        }
        echo "]\n";
    }
}