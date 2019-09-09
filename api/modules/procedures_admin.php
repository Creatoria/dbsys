<?php
include_once('functions.php');
function getallgrade()
{
    if (check_auth('root')) {
        $rep = query('dbReader', 'default', 'students', ['stuid' => $_POST['target']]);
        $res = array();
        foreach ($rep['grades'] as $grade) {
            $re = query('dbReader', 'default', 'grades', ['_id' => new MongoDB\BSON\ObjectId($grade)]);
            array_push($res, $re);
        }
        return ['code' => 20000, 'items' => $res];
    } else return ['code' => 0];
}
function getallstudent()
{
    if (check_auth('root')) {
        $rep = query('dbReader', 'default', 'classes', ['classid' => $_POST['target']]);
        $res = array();
        foreach ($rep['students'] as $student) {
            $re = query('dbReader', 'default', 'students', ['stuid' => $student]);
            array_push($res, $re);
        }
        return ['code' => 20000, 'items' => $res];
    } else return ['code' => 0];
}
function getallclass()
{
    if (check_auth('root')) {
        return ['code' => 20000, 'items' => queryAll('dbReader', 'default', 'classes', [])];
    } else return ['code' => 0];
}

function getallcourse()
{
    if (check_auth('root')) {
        return ['code' => 20000, 'items' => queryAll('dbReader', 'default', 'courses', [])];
    } else return ['code' => 0];
}
function addcourse()
{
    if (check_auth('root')) {
        if (insert_one('dbWriter', 'default', 'courses', $_POST['target'])) return ['code' => 20000];
        else return ['code' => 0];
    } else return ['code' => 0];
}
function delcourse()
{
    if (check_auth('root')) {
        if (delete_one('dbWriter', 'default', 'courses', ['courseid' => $_POST['target']['courseid']]))
            return ['code' => 20000];
        else return ['code' => 0];
    } else return ['code' => 0];
}
function editcourse()
{
    $repr = $_POST['repr'];
    unset($repr['_id']);
    if (check_auth('root')) {
        if (update_one('dbWriter', 'default', 'courses', ['courseid' => $_POST['target']['courseid']], ['$set' => $repr])) return ['code' => 20000];
        else return ['code' => 0];
    } else return ['code' => 0];
}
function addstudent()
{
    if (check_auth('root')) {
        $res = insert_one('dbWriter', 'default', 'students', $_POST['target']);
        if ($res && update_one('dbWriter', 'default', 'classes', ['classid' => $_POST['classid']], ['$push' => ['students' => $res['stuid']]])) return ['code' => 20000];
        else return ['code' => 0];
    } else return ['code' => 0];
}
function delstudent()
{
    if (check_auth('root')) {
        if (
            delete_one(
                'dbWriter',
                'default',
                'students',
                ['stuid' => $_POST['target']['stuid']]
            ) &&
            update_one(
                'dbWriter',
                'default',
                'classes',
                ['classid' => $_POST['classid']],
                ['$pull' => ['students' => $_POST['target']['stuid']]]
            )
        ) return ['code' => 20000];
        else return ['code' => 0];
    } else return ['code' => 0];
}
function editstudent()
{
    $repr = $_POST['repr'];
    unset($repr['_id']);
    if (check_auth('root')) {
        if (update_one('dbWriter', 'default', 'students', ['stuid' => $_POST['target']['stuid']], ['$set' => $repr])) return ['code' => 20000];
        else return ['code' => 0];
    } else return ['code' => 0];
}
function addgrade()
{
    if (check_auth('root')) {
        $res = insert_one('dbWriter', 'default', 'grades', $_POST['target']);
        if ($res && update_one('dbWriter', 'default', 'students', ['stuid' => $_POST['stuid']], ['$push' => ['grades' => $res['_id']]])) return ['code' => 20000];
        else return ['code' => 0];
    } else return ['code' => 0];
}
function delgrade()
{
    if (check_auth('root')) {
        $res = delete_one('dbWriter', 'default', 'grades', ['_id' => new MongoDB\BSON\ObjectId($_POST['target']['_id']['$oid'])]);
        if ($res && update_one('dbWriter', 'default', 'students', ['stuid' => $_POST['stuid']], ['$pull' => ['grades' => $res['_id']]])) return ['code' => 20000];
        else return ['code' => 1];
    } else return ['code' => 0];
}
function editgrade()
{
    $repr = $_POST['repr'];
    unset($repr['_id']);
    unset($repr['stuid']);
    if (check_auth('root')) {
        if (update_one('dbWriter', 'default', 'grades', ['_id' => new MongoDB\BSON\ObjectId($_POST['target']['_id']['$oid'])], ['$set' => $repr])) return ['code' => 20000];
        else return ['code' => 0];
    } else return ['code' => 0];
}