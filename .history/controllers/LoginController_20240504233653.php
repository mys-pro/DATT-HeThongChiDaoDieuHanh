<?php
class LoginController extends BaseController
{
    private $userModel;
    public function __construct()
    {
        $this->loadModel('UserModel');
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $login = $this->userModel->login($username);
            if (empty($login)) {
                echo 'fail';
            } else {
                if ($login[0]['Password'] == $password) {
                    $_SESSION['Welcome'] = true;
                    $_SESSION['UserInfo'] = $this->userModel->userInfo($login[0]['UserID']);
                    echo 'success';
                } else {
                    echo 'fail';
                }
            }
            exit();
        }
        $this->view('logins.show');
    }

    public function logout()
    {
        unset($_SESSION['UserInfo']);
        session_destroy();
        header("Location:" . getWebRoot());
    }

    public function forgot()
    {
        if (isset($_POST['email'])) {
            $username = $_POST['email'];
            $login = $this->userModel->login($username);
            if (empty($login)) {
                echo 'wrong';
            } else {
                $html = file_get_contents('test.php');
                echo $html;
                // if (sendMail($username, "test mail", $html)) {
                //     echo 'success';
                // } else {
                //     echo 'fail';
                // }
            }
            exit();
        }
        $this->view('forgotten.show');
    }

    public function verify()
    {
        $this->view('verifies.show');
    }

    public function changePassword()
    {
        $this->view('changePasswords.show');
    }
}
