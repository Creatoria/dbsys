<?php
function getgrade()
{
    if (check_auth('student')) {
        $res = queryAll('dbReader', 'default', 'grades', $_POST);
        if ($res != 0)
            return ['code' => 20000, 'data' => $res];
        else return ['code' => 0];
    } else return ['code' => 0];
}
function getstuinfo()
{
    var_dump($_POST);
    if (check_auth('student')) {
        $res = query('dbReader', 'default', 'students', $_POST);
        if ($res != 0)
            return ['code' => 20000, 'data' => $res];
        else return ['code' => 0];
    } else return ['code' => 0];
}