<?php
include_once('./functions.php');
function getallgrade()
{
    if (check_auth('root')) {
        return query('dbReader', 'default', 'grades', []);
    } else return json_encode(['code' => 0]);
}
function getallteacher()
{
    if (check_auth('root')) {
        return query('dbReader', 'default', 'teachers', []);
    } else return json_encode(['code' => 0]);
}
function getallstudent()
{
    if (check_auth('root')) {
        return query('dbReader', 'default', 'students', []);
    } else return json_encode(['code' => 0]);
}
function getallcourse()
{
    if (check_auth('root')) {
        return query('dbReader', 'default', 'courses', []);
    } else return json_encode(['code' => 0]);
}
function addcourse(){
    if (check_auth('root')){
        
    }
}