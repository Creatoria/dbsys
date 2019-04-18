<?php
$user = $_GET['user'];
$pwd = $_GET['pwd'];
include_once("./functions.php");
$mess = login($user, $pwd);
// setcookie("");
echo $mess;