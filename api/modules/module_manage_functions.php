<?php
require_once("../vendor/autoload.php");

function search($k)
{
    if (!($_COOKIE != null && $_COOKIE['token'] === $_SESSION['token'] && $_COOKIE['u'] === $_SESSION['u']))
        return json_encode(['success' => 0, 'msg' => 'unauthorized']);
    $conn = new MongoDB\Client();
    $cursor = $conn->testt->testt->find(['u' => $k]);
    return json_encode(['success' => 1, 'msg' => 'success', 'result' => $cursor]);
}