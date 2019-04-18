<?php
$coon = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$bulk = new MongoDB\Driver\BulkWrite;
var_dump($coon);
$doc = array('u' => 'a', 'n' => 10, 'b' => 'p');
$pp = $bulk->insert($doc);
var_dump($pp);
$res = $coon->executeBulkWrite("testt.testt", $bulk);