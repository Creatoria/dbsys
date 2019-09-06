<?php
include_once('./functions.php');
function getallgrade()
{
    if (check_auth('root')) {
        return query('dbReader', 'default', 'grades', []);
    } else return 0;
}
function getallstudent()
{
    if (check_auth('root')) {
        return query('dbReader', 'default', 'students', []);
    } else return 0;
}
function getallcourse()
{
    if (check_auth('root')) {
        return query('dbReader', 'default', 'courses', []);
    } else return 0;
}
function addcourse()
{
    if (check_auth('root')) {
        if (insert_one('dbWriter', 'default', 'courses', $_POST)) return ['code' => 20000];
        else return ['code' => 0];
    }
}
function delcourse()
{
    if (check_auth('root')) {
        if (delete_one('dbWriter', 'default', 'courses', $_POST['target'])) return ['code' => 20000];
        else return ['code' => 0];
    }
}
function editcourse()
{
    if (check_auth('root')) {
        if (update_one('dbWriter', 'default', 'courses', $_POST['target'], $_POST['repr'])) return ['code' => 20000];
        else return ['code' => 0];
    }
}
function addstudent()
{
    if (check_auth('root')) {
        if (insert_one('dbWriter', 'default', 'students', $_POST)) return ['code' => 20000];
        else return ['code' => 0];
    }
}
function delstudent()
{
    if (check_auth('root')) {
        if (delete_one('dbWriter', 'default', 'students', $_POST['target'])) return ['code' => 20000];
        else return ['code' => 0];
    }
}
function editstudent()
{
    if (check_auth('root')) {
        if (update_one('dbWriter', 'default', 'students', $_POST['target'], $_POST['repr'])) return ['code' => 20000];
        else return ['code' => 0];
    }
}
function addgrade()
{
    if (check_auth('root')) {
        $res = insert_one('dbWriter', 'default', 'grades', $_POST);
        if ($res && update_one('dbWriter', 'default', 'students', ['stuid' => $_POST['stuid']], ['$push' => ['grades' => $res]])) return ['code' => 20000];
        else return ['code' => 0];
    }
}
function delgrade()
{
    if (check_auth('root')) {
        $res = delete_one('dbWriter', 'default', 'grades', ['_id' => $_POST['target']]);
        if ($res && update_one('dbWriter', 'default', 'students', ['stuid' => $res['stuid']], ['$pull' => ['grades' => $res['_id']]])) return ['code' => 20000];
        else return ['code' => 0];
    }
}
function editgrade()
{
    if (check_auth('root')) {
        if (update_one('dbWriter', 'default', 'grades', $_POST['target'], $_POST['repr'])) return ['code' => 20000];
        else return ['code' => 0];
    }
}