<?php
class LoginController extends BaseController {
    public function login() {
        $this->view('users.login');
    }
}