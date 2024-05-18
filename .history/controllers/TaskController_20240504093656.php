<?php
class TaskController extends BaseController
{
    private $taskModel;
    private $userModel;

    private $userInfo;
    public function __construct()
    {
        $this->loadModel('TaskModel');
        $this->taskModel = new TaskModel();
        $this->loadModel('UserModel');
        $this->userModel = new UserModel();
        $this->userInfo = $this->userModel->userInfo($_SESSION['UserID']);
    }
    public function statistical()
    {
        if (isset($_POST['priority']) && isset($_POST['date'])) {
            if ($_POST['date'] == "DATE" && $_POST['dateStart'] != 0) {
                echo json_encode($this->taskModel->statisticalByDate($_POST['priority'], $_POST['dateStart'], $_POST['dateEnd']));
            } else if ($_POST['date'] == 'MONTH') {
                echo json_encode($this->taskModel->statisticalByMonth($_POST['priority']));
            } else {
                echo json_encode($this->taskModel->statisticalByYear($_POST['priority']));
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

    public function report()
    {
        if (isset($_POST['department']) && isset($_POST['date'])) {
            if ($_POST['date'] == "DATE" && $_POST['dateStart'] != 0) {
                echo json_encode($this->taskModel->reportByDate($_POST['department'], $_POST['dateStart'], $_POST['dateEnd']));
            } else if ($_POST['date'] == 'MONTH') {
                echo json_encode($this->taskModel->reportByMonth($_POST['department']));
            } else {
                echo json_encode($this->taskModel->reportByYear($_POST['department']));
            }
            exit();
        } else {
            $report = $this->taskModel->reportByYear();
        }

        $departmentFilter = $this->taskModel->getAll('Departments', ['DepartmentID', 'DepartmentName']);
        $this->view('reports.show', [
            'pageTitle' => 'Báo cáo',
            'active' =>  __FUNCTION__,
            'departmentFilter' =>  $departmentFilter,
            'report' => $report,
        ]);
    }

    public function task()
    {
        echo __METHOD__;
    }

    public function approval()
    {
        echo __METHOD__;
    }
}
