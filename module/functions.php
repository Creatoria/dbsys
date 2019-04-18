<?php
function login_auth($j, $k)
{
    $coon = new mongoclient();
    $coon->selectcollection("2017", "all_stu");
    $res = array(
        "user" => $j,
        "password" => $k
    );
    return json_encode($res);
}