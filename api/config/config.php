<?php
const userLevel=array(
    'root'=>0,
    'student'=>2
);
$dbConfig = array(
    'dbAddress' => 'localhost',
    'authDB' => 'test',
    "dbReader" => array(
        "user" => "dbReader",
        "password" => "reader"
    ),
    "dbWriter" => array(
        'user' => 'dbWriter',
        "password" => "writer"
    )
);