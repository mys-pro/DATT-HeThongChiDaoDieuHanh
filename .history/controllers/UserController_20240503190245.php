<?php
class UserController extends BaseController {
    public function login() {
        if(isset($_POST['login'])) {
            echo (getWebRoot()."/ac/thong-ke");
            exit();
        }

        $this->view('users.login');
    }
}