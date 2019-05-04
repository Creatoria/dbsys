<?php
$user = $_GET['user'];
$pwd = $_GET['pwd'];
include_once("./module_functions_auth.php");
$mess = login($user, $pwd);
// setcookie("");
echo $mess;