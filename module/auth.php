<?php
$user = $_GET['user'];
$pwd = $_GET['pwd'];
include_once("./functions.php");
$mess = login_auth($user, $pwd);
// setcookie("");
echo $mess;