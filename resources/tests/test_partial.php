<?php
require_once 'functions.php';

$passing = [[1, 0, 5, 0], [1, 5, 0, 0], [0, 5, 0, 1], [0, 1, 5, 1]];
$mult = [[1, 0, 5, 1], [1, 5, 0, 0], [0, 5, 0, 1], [5, 1, 1, 1]];

var_dump(partial_verify($passing));
var_dump(partial_verify($mult));