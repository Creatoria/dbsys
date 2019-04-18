<?php
$mode = $_GET['mode'] ? $_GET['mode'] : NULL;
const modules = array("auth");
if ($mode != NULL) {
    try {
        if (!in_array($mode, $modules))
            throw new Exception();
        include_once("./$mode.php");
    } catch (Exception $e) {

        include_once("./404.html");
        header("HTTP/1.1 404 Not Found ");
        header("Status: 404 Not Found");
    }
}
//  else {
//     include_once();
// }