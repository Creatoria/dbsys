<?php
$mode = $_GET['mode'] ? $_GET['mode'] : NULL;
$modules = array("login", 'logout');
if ($mode != NULL) {
    try {
        if (!in_array($mode, $modules))
            throw new Exception();
        session_start();
        include_once("./$mode.php");
    } catch (Exception $e) {

        echo json_encode(['success' => 0, 'msg' => 'unknown option']);
        header("HTTP/1.1 404 Not Found ");
        header("Status: 404 Not Found");
    }
} else {
    echo json_encode(['success' => 0, 'msg' => 'no option specified']);
}