<?php
require_once("./vendor/autoload.php");

function login($i, $j)
{
    session_start();
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $client->testt->testt;
    $cursor = $collection->findOne(["u" => $i, 'b' => $j]);
    if ($cursor === NULL)
        $arr = ['success' => 0, 'msg' => 'failed'];
    else {
        $token = "aehbibuiabs3893yh=="; //setToken needed
        $_SESSION['user'] = $i;
        $_SESSION['token'] = $token;
        $arr = ['success' => 1, 'msg' => 'success', 'token' => $token];
    }
    return json_encode($arr);
}
function logout($user)
{
    unset($_SESSION);
}