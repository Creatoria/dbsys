<?php
$option = $_GET['sub_opt'];
$target = $_GET['target'];
$db = $_GET['db'];
$collection = $_GET['collection'];
$role = $_SESSION['role'];
switch ($role) { //TODO: db_user judgement
    case '':
        break;
}
switch ($option) { //TODO:query case
    case 'query':
        # code...
        break;
    case 'delete':
        # code...
        break;
    case 'update':

        break;
    default:
        # code...
        break;
}