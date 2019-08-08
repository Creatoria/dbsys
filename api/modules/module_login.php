<?php
$user = $_GET['user'];
$pwd = $_GET['pwd'];
$mess = login($user, $pwd);
echo $mess;