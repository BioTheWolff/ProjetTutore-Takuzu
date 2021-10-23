<?php


class Adapter
{

    const GAP_JS = '_';
    const GAP_PHP = 5;

    public static function grid_to_message(array $grid): string
    {
        $fs = count($grid) . ":";

        foreach ($grid as $row) {
            foreach ($row as $item) {
                if ($item == self::GAP_PHP) $fs .= self::GAP_JS;
                else $fs .= (string)$item;
            }
        }

        return $fs;
    }

    public static function message_to_grid(string $message): array
    {
        [$size, $chars] = explode(":", $message);
        $size = (int)$size;
        $chars = preg_split('//', $chars, -1, PREG_SPLIT_NO_EMPTY);;

        $grid = [];

        for ($i = 0; $i < $size; ++$i)
        {
            $line = [];

            for ($j = 0; $j < $size; ++$j)
            {
                $c = $chars[$i*$size+$j];

                if ($c == self::GAP_JS) $c = self::GAP_PHP;
                else $c = (int)$c;

                $line[] = $c;
            }

            $grid[] = $line;
        }

        return $grid;
    }

}