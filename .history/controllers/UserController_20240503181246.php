<?php
class UserController extends BaseController {
    public function login() {
        

        $this->view('users.login');
    }
}