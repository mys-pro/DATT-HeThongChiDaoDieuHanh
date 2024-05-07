<?php
class UserController extends BaseController {
    public function login() {
        if(isset($_POST['login'])) {
            
            exit;
        }
        $this->view('users.login');
    }
}