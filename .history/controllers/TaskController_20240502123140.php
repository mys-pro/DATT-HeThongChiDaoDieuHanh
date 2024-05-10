<?php
class TaskController extends BaseController{
    private $taskModel;
    public function __construct() {
        $this->loadModel('TaskModel');
        $this->taskModel = new TaskModel();
    }
    public function statistical() {
        if(isset($_POST['priority']) && isset($_POST['date'])) {
            if($_POST['date'] == "DATE" && $_POST['dateStart'] != 0) {
                $statistical = ($this->taskModel->statisticalByDate($_POST['priority'], $_POST['dateStart'], $_POST['dateEnd']));
            } else if($_POST['date'] == 'MONTH') {
                $statistical = ($this->taskModel->statisticalByMonth($_POST['priority']));
            } else {
                $statistical = ($this->taskModel->statisticalByYear($_POST['priority']));
            }
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
        if(isset($_POST['reportVal']) && isset($_POST['date'])) {
            if($_POST['date'] == "DATE" && $_POST['dateStart'] != 0) {
                echo json_encode($this->taskModel->statisticalByDate($_POST['dateStart'], $_POST['dateEnd']));
            } else if($_POST['date'] == 'MONTH') {
                echo json_encode($this->taskModel->statisticalByMonth());
            } else {
                echo json_encode($this->taskModel->statisticalByYear());
            }
            exit();
        } else {
            $statistical = $this->taskModel->statisticalByYear();
        }

        $report = $this->taskModel->statisticalByYear();
        $this->view('reports.show', [
            'pageTitle' => 'Báo cáo',
            'active' =>  __FUNCTION__,
            'report' => $report,
        ]);
    }

    public function task() {
        echo __METHOD__;
    }

    public function approval() {
        echo __METHOD__;
    }
}