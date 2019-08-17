<?php
error_reporting(0);
$debug = true;
$opt = $_GET['opt'] ? $_GET['opt'] : NULL;
$modules = array("login", 'logout', 'query');
if ($opt != NULL) {
    try {
        if (!in_array($opt, $modules))
            throw new Exception();
        session_start();
        include_once("./vendor/autoload.php");
        include_once("./config/config.php");
        include_once("./modules/functions.php");
    } catch (Exception $e) {
        echo json_encode(['success' => 0]);
    }
} else {
    echo json_encode(['success' => 0]);
}
extract($_GET);
$role = $_SESSION['role'];
if (!check_auth())
    echo json_encode(['success' => 0]);
else {
    switch ($opt) {
        case 'query':
            echo query($role, $db, $collection, $target);
            break;
        case 'delete':
            echo delete_one($role, $db, $collection, $target);
            break;
        case 'update':
            echo update_one($role, $db, $collection, $target, $ar);
            break;
        case 'insert':
            echo insert_one($role, $db, $collection, $target);
            break;
        case 'login':
            echo login($user, $password);
            break;
        case 'logout':
            echo logout();
            break;
    }
}