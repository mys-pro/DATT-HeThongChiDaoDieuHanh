<?php
class UserController extends BaseController {
    public function login() {
        if(isset($_POST['login'])) {
            header('http://localhost/datt-hethongchidaodieuhanh/ac/thong-ke');
            exit;
        } else {
            $this->view('users.login');
        }
    }
}