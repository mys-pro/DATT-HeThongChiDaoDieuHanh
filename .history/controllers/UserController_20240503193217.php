<?php
class UserController extends BaseController {
    
    public function login() {
        if(isset($_POST['login'])) {
            
            
        }
        $this->view('users.login');
    }
}