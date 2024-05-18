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
        $statistical = $this->taskModel->statistical($_REQUEST['priority'], $_REQUEST['date'], $_REQUEST['dateStart'], $_REQUEST['dateEnd']);
        
        $this->view('tasks.index', [
            'active' => __FUNCTION__,
            'page' => 'tasks.pages.statistical',
            'data' => [
                'pageTitle' => 'Thống kê',
                'statistical' => $statistical,
            ],
        ]);
    }

    public function report()
    {
        if (isset($_POST['department']) && isset($_POST['date'])) {
            $report = $this->taskModel->report($_POST['department'], $_POST['date'], $_POST['dateStart'], $_POST['dateEnd']);
        } else {
            $report = $this->taskModel->report();
        }

        $departmentFilter = $this->taskModel->getAll('Departments', ['DepartmentID', 'DepartmentName']);

        $this->view('tasks.index', [
            'active' => __FUNCTION__,
            'page' => 'tasks.pages.report',
            'data' => [
                'pageTitle' => 'Báo cáo',
                'departmentFilter' =>  $departmentFilter,
                'report' => $report,
            ],
        ]);
    }

    public function task()
    {
        $userInfo = $_SESSION["UserInfo"][0];
        $tasks = $this->taskModel->getAll("Tasks");
        $taskList = array();

        foreach ($tasks as $value) {
            $Users = $this->taskModel->getUserByID($value["AssignedBy"]);
            $taskPerformers = $this->taskModel->getTaskPerformers($value["TaskID"], $userInfo["UserID"]);

            if ($value["AssignedBy"] == $userInfo["UserID"] && empty($taskPerformers)) {
                $dateCreated = new DateTime($value["DateCreated"]);
                $deadline = $dateCreated->add(new DateInterval("P" . $value["Deadline"] . "D"));

                array_push($taskList, [
                    "TaskName" => $value["TaskName"],
                    "Status" => $value["Status"],
                    "Avatar" => base64_encode($Users[0]["Avatar"]),
                    "FullName" => $Users[0]["FullName"],
                    "Deadline" => $deadline->format("d-m-Y"),
                    "Progress" => $value["Progress"]
                ]);
            } else if (!empty($taskPerformers)) {
                $dateCreated = new DateTime($taskPerformers[0]["DateStart"]);
                $deadline = $dateCreated->add(new DateInterval("P" . $taskPerformers[0]["Deadline"] . "D"));

                array_push($taskList, [
                    "TaskName" => $value["TaskName"],
                    "Status" => $taskPerformers[0]["Status"],
                    "Avatar" => base64_encode($Users[0]["Avatar"]),
                    "FullName" => $Users[0]["FullName"],
                    "Deadline" => $deadline->format("d-m-Y"),
                    "Progress" => $taskPerformers[0]["Progress"]
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

        $this->view('tasks.index', [
            'active' => __FUNCTION__,
            'page' => 'tasks.pages.task',
            'data' => [
                'pageTitle' => 'Công việc',
                'taskList' => $taskList,
            ],
        ]);
    }

    public function approval()
    {
        echo __METHOD__;
    }
}
