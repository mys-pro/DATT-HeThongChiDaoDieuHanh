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
                    $userInfo = $this->userModel->userInfo($login[0]['UserID']);
                    if ($userInfo[0]['Status'] == 0) {
                        echo 'notActive';
                        exit();
                    } else {
                        $_SESSION['Welcome'] = true;
                        $_SESSION['UserInfo'] = $userInfo;
                        echo 'success';
                    }
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
            $userInfo = $this->userModel->userInfo($login[0]['UserID']);
            if (empty($login)) {
                echo 'wrong';
            } else {
                $verify = $this->generateCode();
                if ($this->userModel->updateForgotToken($login[0]['UserID'], $verify) == 1) {
                    $htmlContent = file_get_contents(getWebRoot() . '/Views/emailTemplate/verification.html');
                    $htmlContent = str_replace('{{name}}', $userInfo[0]['FullName'], $htmlContent);
                    $htmlContent = str_replace('{{verify code}}', $verify, $htmlContent);
                    if (sendMail($username, "Quên mật khẩu", $htmlContent)) {
                        echo 'success';
                    } else {
                        echo 'fail';
                    }
                } else {
                    echo 'fail';
                }
            }
            exit();
        }

        if(isset($_POST['verify'])) {
            $verify = $_POST['verify'];
            $login = $this->userModel->login($verify);
        }

        $this->view('forgotten.show');
    }

    public function changePassword()
    {
        $this->view('changePasswords.show');
    }
}
