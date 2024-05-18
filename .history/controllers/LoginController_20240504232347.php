<?php
class LoginController extends BaseController {
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
        $this->view('logins.show');
    }

    public function logout() {
        unset($_SESSION['UserInfo']);
        session_destroy();
        header("Location:".getWebRoot());
    }

    public function forgot() {
        if(isset($_POST['email'])) {
            $username = $_POST['email'];
            $login = $this->userModel->login($username);
            if(empty($login)) {
                echo 'wrong';
            } else {
                $html = '
                <div class="form-login bg-white rounded-3">
                <div class="mb-4">
                    <h3 class="text-center">Quên mật khẩu</h3>
                </div>
                <div class="mb-4">
                    <span class="text-center w-100 d-inline-block">Vui lòng nhập email để lấy mã xác nhận</span>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" id="InputEmail" placeholder="Nhập email đăng nhập">
                </div>
                <div class="input-group mb-3 w-100">
                    <span class="wrong-account text-center text-danger w-100 d-inline-block"></span>
                </div>
                <button type="button" class="btn btn-primary btn-submit w-100 mb-3">Lấy lại mật khẩu</button>
                <a href="<?= getWebRoot() ?>/dang-nhap" class="w-100 text-center d-inline-block text-decoration-none">Quay lại đăng nhập</a>
            </div>
                ';

                if(sendMail($username, "test mail", 'hello')) {
                    echo 'success';
                } else {
                    echo 'fail';
                }
            }
            exit();
        }
        $this->view('forgotten.show');
    }

    public function verify() {
        $this->view('verifies.show');
    }

    public function changePassword() {
        $this->view('changePasswords.show');
    }
}