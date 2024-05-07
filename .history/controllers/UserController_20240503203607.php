<?php
class UserController extends BaseController {
    private $userModel;
    public function __construct() {
        $this->loadModel('UserModel');
        $this->userModel = new UserModel();
    }

    public function login() {
        if(isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $login = $this->userModel->login($username);
            print_r($login);
            exit();
        }
        $this->view('users.login');
    }
}