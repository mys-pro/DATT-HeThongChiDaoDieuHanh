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
            if(empty($login)) {
                echo 'wrong';
            } else {
                if($login[0]['Password'] == $password) {
                    echo 'success';
                } else {
                    echo 'wrong';
                }
            }
            exit();
        }
        $this->view('users.login');
    }
}