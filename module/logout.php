<?php
if ($_COOKIE != NULL) {
    $u = $_COOKIE['user'] ? $_COOKIE['user'] : NULL;
    $token = $_COOKIE['token'] ? $_COOKIE['token'] : NULL;
}
if ($_SESSION != NULL && $u === $_SESSION['user'] && $token === $_SESSION['token']) {
    include_once('./functions.php');
    logout();
} else {
    echo json_encode(['success' => 0, 'msg' => 'logout failed']);
}