<?php
require_once 'functions.php';

$expected = [[1, 0, 1, 0], [1, 1, 0, 0], [0, 1, 0, 1], [0, 0, 1, 1]];
$grid = [[1, GAP, 1, 0], [1, 1, GAP, 0], [0, 1, GAP, 1], [0, 0, GAP, 1]];

var_dump(solve($grid));

var_dump($expected == solve($grid));
