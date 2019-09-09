<?php
// error_reporting(0);
header("Access-Control-Allow-Headers:*");
header("Access-Control-Allow-Methods:*");

Header("X-Content-Type-Options:nosniff");
header("Access-Control-Allow-Credentials:true");
$debug = false;
$opt = isset($_GET['opt']) ? $_GET['opt'] : NULL;
$subopt = isset($_GET['subopt']) ? $_GET['subopt'] : NULL;
if ($opt == 'act' && $subopt == 'acts') {
    echo json_encode(['code' => 20000]);
    return 0;
}
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
        'getallclass',
        'editcourse',
        'delcourse',
        'addcourse',
        'editstudent',
        'delstudent',
        'addstudent',
        'editgrade',
        'delgrade',
        'addgrade'
    ), 'stu' => array(
        'getgrade',
        'getstuinfo'
    )
);
if (1) {
    try {
        if (!in_array($subopt, $modules[$opt])) {
            throw new Exception('no');
        }
    } catch (Exception $e) {
        echo json_encode(['success' => 0, 'mess' => $e]);
    }
    if (isset($_POST['sid']))
        session_id($_POST['sid']);
    session_start();
    include_once("./vendor/autoload.php");
    include_once("./config/config.php");
    include_once('./modules/functions.php');

    include_once("./modules/procedures_$opt.php");
    echo json_encode(eval('return $subopt();'));
} else {
    echo json_encode(['success' => 0]);
}