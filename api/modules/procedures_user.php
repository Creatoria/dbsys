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
    return $arr;
}
function logout()
{
    session_destroy();
    setcookie('token', '');
    return ['code' => 20000];
}
function getinfo()
{
    if ($_SESSION != null && $_COOKIE['token'] === $_SESSION['token'])
        return ['code' => 20000, 'info' => ['role' => $_SESSION['role'], 'name' => $_SESSION['user'], 'avatar' => 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif']];
    else return ['code' => 0];
}