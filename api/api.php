<?php
// error_reporting(0);
$debug = true;
$opt = isset($_GET['opt']) ? $_GET['opt'] : NULL;
$subopt = isset($_GET['subopt']) ? $_GET['subopt'] : NULL;
$modules = array(
    'user' => array(
        'login',
        'logout',
        'getinfo'
    ), 'admin' => array(
        'getconfig',
        'setconfig',
        'getallgrade',
        'getallcourse',
        'getallstudent',
        'getallteacher',
        'insert',
        'edit',
        'delete'
    ), 'stu' => array(
        'getgrade'
    )
);
if (1) {
    try {
        if (!in_array($subopt, $modules[$opt])) {
            throw new Exception('no');
        }
        session_start();
        include_once("./vendor/autoload.php");
        include_once("./config/config.php");
        include_once("./modules/procedures_$opt.php");
        echo eval($subopt());
    } catch (Exception $e) {
        echo json_encode(['success' => 0, 'mess' => $e]);
    }
} else {
    echo json_encode(['success' => 0]);
}
