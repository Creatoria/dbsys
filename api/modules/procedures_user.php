<?php
include_once("functions.php");

function login()
{
    extract($_POST);
    $coll = connect('dbReader', 'default', 'users');
    $cursor = $coll->findOne(['user' => $user, 'password' => $password]);
    if ($cursor === NULL)
        $arr = ['code' => 0];
    else {
        $token = genToken();
        $_SESSION['user'] = $user;
        $_SESSION['token'] = $token;
        $_SESSION['role'] = $cursor['role'];
        setcookie("token", $token, time() + 24 * 60);
        $arr = ['code' => 20000];
    }
    return json_encode($arr);
}
function logout()
{
    session_destroy();
    setcookie('token', '');
    return json_encode(['code' => 20000]);
}
function getinfo()
{
    return json_decode(['code' => 20000, 'role' => $_SESSION['role']]);
}
