<?php
function genToken()
{
    return sha1(md5(uniqid(md5(microtime(true)), true)));
}
function connect($user, $db, $collection)
{
    $conn = new MongoDB\Client("mongodb://" + $user + "@127.0.0.1:27017");
    $coll = $conn->selectDatabase($db)->selectCollection($collection);
    return $coll;
}
function check_auth()
{
    if ($_SESSION != null && $_COOKIE['token'] == $_SESSION['token'] && $_COOKIE['user'] == $_SESSION['user'])
        return true;
    else
        return false;
}

function login($i, $j)
{


    $coll = connect('db_reader', 'users', 'users');
    $cursor = $coll->findOne(['user' => $i, 'password' => $j]);
    if ($cursor === NULL)
        $arr = ['success' => 0, 'msg' => 'failed'];
    else {
        $token = genToken();
        $_SESSION['user'] = $i;
        $_SESSION['token'] = $token;
        $_SESSION['role'] = 0;
        setcookie("user", $i, time() + 24 * 60);
        setcookie("token", $token, time() + 24 * 60);
        $arr = ['success' => 1, 'msg' => 'success'];
    }
    return json_encode($arr);
}
function logout()
{
    session_destroy();
    setcookie('user', NULL);
    setcookie('token', null);
    echo json_encode(['success' => 1, 'msg' => 'logout success']);
}
function query($user, $db, $collection, $target)
{
    if (check_auth()) {
        $coll = connect($user, $db, $collection);
        $res = $coll->findOne($target);
    } else {
        return json_encode(['success' => 0]);
    }
}
function update_one($user, $db, $collection, $target, $ar)
{
    if (check_auth()) {
        $coll = connect($user, $db, $collection);
    } else {
        return json_encode(['success' => 0]);
    }
}
function delete_one($user, $db, $collection, $target)
{
    if (check_auth()) {
        $coll = connect($user, $db, $collection);
    } else {
        return json_encode(['success' => 0]);
    }
}