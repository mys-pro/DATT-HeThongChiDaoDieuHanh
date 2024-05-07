<?php
class UserController extends BaseController {
    public function login() {
        if(isset($_POST['login'])) {
            $task = new TaskController();
            
            exit();
        }

        $this->view('users.login');
    }
}