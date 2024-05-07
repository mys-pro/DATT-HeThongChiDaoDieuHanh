<?php
class UserController extends BaseController {
    
    public function login() {
        if(isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            echo 'success';
            exit;
        }
        $this->view('users.login');
    }
}