<?php
include (getWebRoot().'/Controllers/TaskController');
class UserController extends BaseController {
    public function login() {
        if(isset($_POST['login'])) {
            $task = new TaskController();
            $task->statistical();
            exit();
        }

        $this->view('users.login');
    }
}