<?php
require_once 'functions.php';

$passing = [[1, 0, 1, 0], [1, 1, 0, 0], [0, 1, 0, 1], [0, 0, 1, 1]];
$shape = [[1, 0, 1, 0], [1, 0, 1, 0], [0, 1, 0, 1], [0, 1, 0, 1]];
$count = [[1, 0, 1, 0], [1, 1, 0, 0], [0, 1, 0, 1], [1, 0, 1, 1]];
$mult = [[1, 0, 1, 0], [1, 1, 0, 0], [0, 1, 0, 1], [0, 1, 1, 1]];

var_dump(partial_verify($passing));
var_dump(partial_verify($shape));
var_dump(partial_verify($count));
var_dump(partial_verify($mult));

$start = microtime(true);
partial_verify($passing);
partial_verify($shape);
partial_verify($count);
partial_verify($mult);
$end = microtime(true);

echo $end - $start;