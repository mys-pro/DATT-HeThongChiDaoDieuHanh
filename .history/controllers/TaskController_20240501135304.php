<?php
class TaskController extends BaseController{
    private $taskModel;
    public function __construct() {
        $this->loadModel('TaskModel');
        $this->taskModel = new TaskModel();
    }
    public function statistical($id = 0) {
        $statistical = $this->taskModel->statisticalByYear($id);

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