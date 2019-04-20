<?php
$key = $_GET['key'];
include_once("./module_manage_functions.php");
$res = search($key);
echo $res;