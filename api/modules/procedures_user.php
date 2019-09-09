<?php
include_once("functions.php");

function login()
{
    if (!$_POST) {
        return ['code' => 0];
    }
    $coll = connect('dbReader', 'default', 'users');
    $cursor = $coll->findOne($_POST);
    if ($cursor === NULL)
        return ['code' => 0];
    else {
        $token = genToken();
        $_SESSION['user'] = $_POST['user'];
        $_SESSION['token'] = $token;
        $_SESSION['role'] = json_decode(json_encode($cursor['role']));
        return ['code' => 20000, 'role' => $cursor['role'], 'token' => $token, 'sid' => session_id()];
    }
}
function logout()
{
    session_destroy();
    setcookie('token', '');
    return ['code' => 20000];
}
function getinfo()
{
    if ($_SESSION != null && $_POST['token'] === $_SESSION['token'])
        return ['code' => 20000, 'info' => ['role' => $_SESSION['role'], 'name' => $_SESSION['user'], 'avatar' => 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif']];
    else return ['code' => 0];
}