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
                echo 'fail';
            } else {
                if($login[0]['Password'] == $password) {
                    // $_SESSION['UserID'] = $login[0]['UserID'];
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