<?php
function genToken()
{
    return sha1(md5(uniqid(md5(microtime(true)), true)));
}
function connect($user, $db, $collection)
{
    global $db_users;
    $conn = new MongoDB\Client(
        "mongodb://" . $db_users[$user]['user'] . ":" . $db_users[$user]['password'] . "@localhost/" . $db_users['auth_server']
    );
    $coll = $conn->selectDatabase($db)->selectCollection($collection);
    return $coll;
}
function check_auth()
{
    global $debug;
    if ($debug) return true;
    if ($_SESSION != null && $_COOKIE['token'] == $_SESSION['token'] && $_COOKIE['user'] == $_SESSION['user'])
        return true;
    else
        return false;
}

function login($i, $j)
{


    $coll = connect('dbReader', 'users', 'users');
    $cursor = $coll->findOne(['user' => $i, 'password' => $j]);
    if ($cursor === NULL)
        $arr = ['success' => 0];
    else {
        $token = genToken();
        $_SESSION['user'] = $i;
        $_SESSION['token'] = $token;
        $_SESSION['role'] = $cursor['role'];
        setcookie("user", $i, time() + 24 * 60);
        setcookie("token", $token, time() + 24 * 60);
        $arr = ['success' => 1];
    }
    return json_encode($arr);
}
function logout()
{
    session_destroy();
    setcookie('user', NULL);
    setcookie('token', null);
    return json_encode(['success' => 1]);
}
function query($user, $db, $collection, $target)
{
    if (check_auth()) {
        $coll = connect($user, $db, $collection);
        $res = $coll->findOne($target);
        if ($res !== null)
            return json_encode(['results' => $res, 'success' => 1]);
        else
            return json_encode(['success' => 0]);
    } else {
        return json_encode(['success' => 0]);
    }
}
function insert_one($user, $db, $collection, $ar)
{
    if (check_auth()) {
        $coll = connect($user, $db, $collection);
        $res = $coll->insertOne($ar);
        if ($res !== null)
            return json_encode(['success' => 1]);
        else
            return json_encode(['success' => 0]);
    } else {
        return json_encode(['success' => 0]);
    }
}
function update_one($user, $db, $collection, $target, $ar)
{
    if (check_auth()) {
        $coll = connect($user, $db, $collection);
        $res = $coll->findOneAndUpdate($target, $ar, ['returnDocument' => MongoDB\Operation\FindOneAndUpdate::RETURN_DOCUMENT_AFTER]);
        if ($res !== null)
            return json_encode($res);
        else
            return json_encode(['success' => 0]);
    } else {
        return json_encode(['success' => 0]);
    }
}
function delete_one($user, $db, $collection, $target)
{
    if (check_auth()) {
        $coll = connect($user, $db, $collection);
        $res = $coll->findOneAndDelete($target);
        if ($res !== null)
            return json_encode(['success' => 1]);
        else
            return json_encode(['success' => 0]);
    } else {
        return json_encode(['success' => 0]);
    }
}