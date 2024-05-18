<?php
class UserController extends BaseController {

    private $taskModel;
    public function __construct() {
        $this->loadModel('TaskModel');
        $this->taskModel = new TaskModel();
    }
    public function login() {
        if(isset($_POST['login'])) {
            
            
        }
        $this->view('users.login');
    }
}