<?php
if (check_auth()) {
    logout();
} else {
    echo json_encode(['success' => 0, 'msg' => 'logout failed']);
}