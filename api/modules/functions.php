<?php
function genToken()
{
    return sha1(md5(uniqid(md5(microtime(true)), true)));
}
function connect($user, $db, $collection)
{
    global $dbConfig;
    $conn = new MongoDB\Client(
        "mongodb://" . $dbConfig[$user]['user'] . ":" . $dbConfig[$user]['password'] . "@" . $dbConfig['dbAddress'] . "/" . $dbConfig['auth_server']
    );
    $coll = $conn->selectDatabase($db)->selectCollection($collection);
    return $coll;
}
function check_auth($role)
{
    global $debug;
    global $userLevel;
    if ($debug) return true;
    if ($_SESSION != null && $_COOKIE['token'] == $_SESSION['token'] && $userLevel[$role]>=$userLevel[$_SESSION['role']])
        return true;
    else
        return false;
}


function query($user, $db, $collection, $target)
{
    $coll = connect($user, $db, $collection);
    $res = $coll->findOne($target);
    if ($res !== null)
        return json_encode(['results' => $res, 'code' => 20000]);
    else
        return json_encode(['code' => 0]);
}
function queryAll($user, $db, $collection, $target)
{
    $coll = connect($user, $db, $collection);
    $res = $coll->find($target);
    if ($res !== null)
        return json_encode(['results' => $res, 'code' => 20000]);
    else
        return json_encode(['code' => 0]);
}
function insert_one($user, $db, $collection, $ar)
{
    $coll = connect($user, $db, $collection);
    $res = $coll->insertOne($ar);
    if ($res !== null)
        return json_encode(['code' => 20000]);
    else
        return json_encode(['code' => 0]);
}
function update_one($user, $db, $collection, $target, $ar)
{
    $coll = connect($user, $db, $collection);
    $res = $coll->findOneAndUpdate($target, $ar, ['returnDocument' => MongoDB\Operation\FindOneAndUpdate::RETURN_DOCUMENT_AFTER]);
    if ($res !== null)
        return json_encode($res);
    else
        return json_encode(['code' => 0]);
}
function delete_one($user, $db, $collection, $target)
{
    $coll = connect($user, $db, $collection);
    $res = $coll->findOneAndDelete($target);
    if ($res !== null)
        return json_encode(['code' => 20000]);
    else
        return json_encode(['code' => 0]);
}
