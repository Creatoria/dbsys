<?php
require_once("./vendor/autoload.php");

function login($i, $j)
{

    $client = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $client->testt->testt;
    $cursor = $collection->findOne(["u" => $i, 'b' => $j]);
    if ($cursor === NULL)
        $arr = ['success' => 0, 'msg' => 'failed'];
    else {
        $token = "aehbibuiabs3893yh=="; //setToken needed
        $_SESSION['user'] = $i;
        $_SESSION['token'] = $token;
        setcookie("user", $i, time() + 24 * 60);
        setcookie("token", $token, time() + 24 * 60);
        $arr = ['success' => 1, 'msg' => 'success', 'token' => $token];
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