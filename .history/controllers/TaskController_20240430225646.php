<?php
class TaskController extends BaseController{
    private $taskModel;
    public function __construct() {
        $this->loadModel('TaskModel');
        $this->taskModel = new TaskModel();
    }
    public function statistical() {
        $statistical = $this->taskModel->statisticalByYEAR();
        $totalTask = [];
        foreach ($statistical as $department) {
            array_push($totalTask, $this->taskModel->getTotalTasksByName($department['DepartmentName']));
        }

        foreach ($totalTask as $task) {
            echo $task['TotalTasks'] . '<br>';
        }
        die;
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