<?php
class TaskController extends BaseController{
    private $taskModel;
    public function __construct() {
        $this->loadModel('TaskModel');
        $this->taskModel = new TaskModel();
    }
    public function statistical() {
        if(isset($_POST['priority']) && isset($_POST['date'])) {
            echo json_encode($this->taskModel->statisticalByYear($_POST['priority']));
            exit();
        } else {
            $statistical = $this->taskModel->statisticalByYear();
        }

        $this->view('statistical.show', [
            'pageTitle' => 'Thống kê',
            'active' => __FUNCTION__,
            'statistical' => $statistical,
        ]);
    }

    public function report() {
        $this->view('reports.show', [
            'pageTitle' => 'Báo cáo',
            'active' =>  __FUNCTION__,
        ]);
    }

    public function task() {
        echo __METHOD__;
    }

    public function approval() {
        echo __METHOD__;
    }
}