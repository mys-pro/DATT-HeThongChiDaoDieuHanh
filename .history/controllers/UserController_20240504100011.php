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
                    $_SESSION['Welcome'] = true;
                    $_SESSION['UserInfo'] = $this->userModel->userInfo($login[0]['UserID']);
                    echo 'success';
                } else {
                    echo 'fail';
                }
            }
            exit();
        }
        $this->view('users.login');
    }

    public function logout() {
        unset($_SESSION['UserInfo']);
        session_destroy();
        header("Location:".getWebRoot());
    }
}