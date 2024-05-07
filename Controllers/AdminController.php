<?php
if (!isset($_SESSION['UserID'])) {
    header('Location:'.getWebRoot() . '/dang-nhap');
    exit();
}
class AdminController {
    public function departments() {
        echo __METHOD__;
    }

    public function positions() {
        echo __METHOD__;
    }

    public function user() {
        echo __METHOD__;
    }
}