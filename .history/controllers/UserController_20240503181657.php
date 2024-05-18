<?php
class UserController extends BaseController {
    public function login() {
        if(isset($_GET['login'])) {
            die;
        }

        $this->view('users.login');
    }
}