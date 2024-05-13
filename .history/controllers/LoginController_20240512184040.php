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
        $this->view('logins.index', ['page' => 'logins.pages.login']);
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
                        echo sha1($login[0]['UserID']);
                    } else {
                        echo 'fail';
                    }
                } else {
                    echo 'fail';
                }
            }
            exit();
        }
        $this->view('logins.index', ['page' => 'logins.pages.forgot']);
    }

    public function verify($id = null)
    {
        if ($id == null) {
            $this->view('errors.404');
            exit;
        }

        if (isset($_POST['sendVerify'])) {
            $verify = $this->generateCode();
            $UserID = $this->userModel->getIDbySha1($id);
            if ($this->userModel->updateForgotToken($UserID, $verify) == 1) {
                $userInfo = $this->userModel->userInfo($UserID);
                $username = $userInfo[0]['Gmail'];
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
            exit;
        }

        $UserID = $this->userModel->getIDbySha1($id);
        if ($UserID == null) {
            $this->view('errors.404');
            exit;
        }

        $forgotToken = $this->userModel->userInfo($UserID)[0]["ForgotToken"];
        $time = $this->userModel->userInfo($UserID)[0]["DateUpdate"];
        if ($forgotToken == null || $forgotToken == "") {
            header("Location:" . getWebRoot());
            exit;
        }

        if(isset($_POST["verify"])) {
            if($forgotToken == $_POST["verify"]) {
                $countSecond = $this->countSecond($time);
                if($countSecond >= 300) {
                    echo 'overTime';
                } else {
                    echo $id;
                }
            } else {
                echo 'wrong';
            }
            exit;
        }

        $this->view('verifies.show');
    }

    public function changePassword($id = null)
    {
        if ($id == null) {
            $this->view('errors.404');
            exit;
        }

        $UserID = $this->userModel->getIDbySha1($id);
        if ($UserID == null) {
            $this->view('errors.404');
            exit;
        }

        $forgotToken = $this->userModel->userInfo($UserID)[0]["ForgotToken"];
        $time = $this->userModel->userInfo($UserID)[0]["DateUpdate"];
        if ($forgotToken == null || $forgotToken == "" || $this->countSecond($time) >= 500) {
            $this->view('errors.404');
            exit;
        }

        if(isset($_POST['updatePassword'])) {
            if($this->userModel->updatePassword($UserID, $_POST['updatePassword']) == 1) {
                echo "success";
            } else {
                echo "fail";
            }
            exit;
        }
        $this->view('changePasswords.show');
    }
}
