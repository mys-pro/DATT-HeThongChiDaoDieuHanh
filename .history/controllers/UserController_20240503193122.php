<?php
class UserController extends BaseController {

    private $taskModel;
    public function __construct() {
        $this->loadModel('TaskModel');
        $this->taskModel = new TaskModel();
    }
    public function login() {
        if(isset($_POST['login'])) {
            $statistical = $this->taskModel->statisticalByYear();
            $this->view('statistical.show', [
                'pageTitle' => 'Thống kê',
                'active' => __FUNCTION__,
                'statistical' => $statistical,
            ]);
            exit();
        }
        $this->view('users.login');
    }
}