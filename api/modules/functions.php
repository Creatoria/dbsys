<?php
function genToken()
{
    return sha1(md5(uniqid(md5(microtime(true)), true)));
}
function connect($user, $db, $collection)
{
    global $dbConfig;
    $conn = new MongoDB\Client(
        // "mongodb://" . $dbConfig[$user]['user'] . ":" . $dbConfig[$user]['password'] . "@" . $dbConfig['dbAddress'] . "/" . $dbConfig['authDB']
    );
    $coll = $conn->selectDatabase($db)->selectCollection($collection);
    return $coll;
}
function check_auth($role)
{
    global $debug;
    global $userLevel;
    if ($debug) return true;
    if ($_SESSION != null && $_POST['token'] == $_SESSION['token'] && $userLevel[$role] >= $userLevel[$_SESSION['role']])
        return true;
    else
        return false;
}


function query($user, $db, $collection, $target)
{
    $coll = connect($user, $db, $collection);
    $res = $coll->findOne($target);
    if ($res !== null)
        return  $res;
    else
        return 0;
}
function queryAll($user, $db, $collection, $target)
{
    $coll = connect($user, $db, $collection);
    $cur = $coll->find($target);
    $res = array();

    foreach ($cur as $line)
        array_push($res, $line);
    if ($res !== null) {

        return  $res;
    } else
        return 0;
}
function insert_one($user, $db, $collection, $ar)
{
    $coll = connect($user, $db, $collection);
    $res = $coll->insertOne($ar);
    if ($res->getInsertedCount())
        return $coll->findOne(['_id' => $res->getInsertedId()]);
    else
        return 0;
}
function update_one($user, $db, $collection, $target, $ar)
{
    $coll = connect($user, $db, $collection);
    $res = $coll->findOneAndUpdate($target, $ar);
    if ($res !== null)
        return 1;
    else
        return 0;
}
function delete_one($user, $db, $collection, $target)
{
    $coll = connect($user, $db, $collection);
    $res = $coll->findOneAndDelete($target);
    if ($res !== null)
        return $res;
    else
        return 0;
}