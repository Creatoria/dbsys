<?php
error_reporting(0);
$opt = $_GET['opt'] ? $_GET['opt'] : NULL;
$modules = array("login", 'logout', 'query');
if ($opt != NULL) {
    try {
        if (!in_array($opt, $modules))
            throw new Exception();
        session_start();
        include_once("./vendor/autoload.php");
        include_once("./modules/module_functions.php");
        include_once("./modules/module_$opt.php");
    } catch (Exception $e) {
        echo json_encode(['success' => 0, 'msg' => 'unknown option']);
    }
} else {
    echo json_encode(['success' => 0, 'msg' => 'no option specified']);
}