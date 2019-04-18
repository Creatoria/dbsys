<?php
session_save_path("./sess");
session_start();
$_SESSION['user'] = 1;
$_SESSION['pwd'] = 2;
var_dump($_SESSION);
session_destroy();