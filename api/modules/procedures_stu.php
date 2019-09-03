<?php
include_once('./functions.php');
function getgrade()
{
    if (check_auth('student')) {
        $res = queryAll('dbReader', 'default', 'grades', $_POST);
        return json_encode(['code' => 20000, 'data' => $res]);
    } else return json_encode(['code' => 0]);
}
