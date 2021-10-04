<?php

require_once('_header.php');

$filename = $filename ?? 'error/not_found';
require_once("$filename.php");

require_once('_footer.php');