<?php
class UserController extends BaseController {
    public function login() {
        if(isset($_POST['login'])) {
            echo header('http://localhost/datt-hethongchidaodieuhanh/ac/thong-ke');
            exit;
        }

        $this->view('users.login');
    }
}