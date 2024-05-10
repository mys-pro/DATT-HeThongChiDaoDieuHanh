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
        $tasks = $this->taskModel->getAll("Tasks");
        $taskList = [
            "TaskName" => NULL,
            "Status" => NULL,
            "Avatar" => NULL,
            "FullName" => NULL,
            "Deadline" => NULL,
            "Progress" => NULL
        ];

        foreach ($tasks as $value) {
            $Users = $this->taskModel->getUserByID($value["AssignedBy"]);
            $taskPerformers = $this->taskModel->getTaskPerformers($value["TaskID"], $userInfo["UserID"]);

            $dateCreated = new DateTime($value["DateCreated"]);
            $value["DateCreated"] = $dateCreated->format("d-m-Y");

            $deadline = $dateCreated->add(new DateInterval("P" . $value["Deadline"] . "D"));
            $value["Deadline"] = $deadline->format("d-m-Y");

            if ($value["AssignedBy"] == $userInfo["UserID"] && empty($taskPerformers)) {
                $value["Avatar"] = $Users[0]["Avatar"];
                $value["FullName"] = $Users[0]["FullName"];

                array_push($taskList, $value);
            } else {
                foreach ($taskPerformers as $value) {
                    $dateCreated = new DateTime($value["DateStart"]);
                    $value["DateStart"] = $dateCreated->format("d-m-Y");

                    $deadline = $dateCreated->add(new DateInterval("P" . $value["Deadline"] . "D"));
                    $value["Deadline"] = $deadline->format("d-m-Y");

                    $value["Avatar"] = $Users[0]["Avatar"];
                    $value["FullName"] = $Users[0]["FullName"];

                    array_push($taskList, $value);
                }
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
