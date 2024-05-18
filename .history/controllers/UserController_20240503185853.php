<?php
class UserController extends BaseController {
    public function login() {
        if(isset($_POST['login'])) {
            echo "success";
        }

        $this->view('users.login');
    }
}