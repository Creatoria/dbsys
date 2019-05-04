<?php
$key = $_GET['key'];
include_once("./module_functions_manage.php");
$res = search($key);
echo $res;