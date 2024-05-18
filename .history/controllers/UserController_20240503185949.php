<?php
class UserController extends BaseController {
    public function login() {
        if(isset($_POST['login'])) {
            echo json_encode('success');
            exit();
        }

        $this->view('users.login');
    }
}