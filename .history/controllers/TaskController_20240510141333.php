<?php
class TaskController extends BaseController
{
    private $taskModel;
    public function __construct()
    {
        $this->loadModel('TaskModel');
        $this->taskModel = new TaskModel();
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
        $userInfo = $_SESSION["UserInfo"][0];
        $tasks = $this->taskModel->getTask();
        $taskList = [];
        foreach ($tasks as $value) {
            $Users = $this->taskModel->getUserByID($value["AssignedBy"]);

            if ($value["AssignedBy"] === $userInfo["UserID"] && $value["UserID"] !== $userInfo["UserID"]) {
                $dateCreated = new DateTime($value["DateCreated"]);
                $deadline = $dateCreated->add(new DateInterval("P" . $value["Deadline"] . "D"));

                array_push($taskList, [
                    "TaskName" => $value["TaskName"],
                    "Status" => $value["Status"],
                    "Avatar" => $Users[0]["Avatar"],
                    "FullName" => $Users[0]["FullName"],
                    "Deadline" => $deadline->format("d-m-Y"),
                    "Progress" => $value["Progress"]
                ]);
            } else if($value["AssignedBy"] != $userInfo["UserID"] && $value["UserID"] == $userInfo["UserID"]) {
                $dateCreated = new DateTime($value["DateStart"]);
                $deadline = $dateCreated->add(new DateInterval("P" . $value["TP_Deadline"] . "D"));

                array_push($taskList, [
                    "TaskName" => $value["TaskName"],
                    "Status" => $value["TP_Status"],
                    "Avatar" => $Users[0]["Avatar"],
                    "FullName" => $Users[0]["FullName"],
                    "Deadline" => $deadline->format("d-m-Y"),
                    "Progress" => $value["TP_Progress"]
                ]);
            }
        }

        if (isset($_REQUEST["v"])) {
            switch ($_REQUEST["v"]) {
                case "tat-ca": {
                        break;
                    }

                case "chua-hoan-thanh": {
                        break;
                    }

                case "hoan-tat": {
                        break;
                    }

                case "cho-phe-duyet": {
                        break;
                    }

                case "tu-choi-phe-duyet": {
                        break;
                    }

                case "du-thao": {
                        break;
                    }

                default: {
                        $this->view('errors.404');
                        exit;
                    }
            }
        }

        $this->view('tasks.show', [
            'pageTitle' => 'Công việc',
            'taskList' => $taskList,
            'active' => __FUNCTION__,
        ]);
    }

    public function approval()
    {
        echo __METHOD__;
    }
}