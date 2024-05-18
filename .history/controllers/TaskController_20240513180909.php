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
            echo json_encode($this->taskModel->statistical($_POST['priority'], $_POST['date'], $_POST['dateStart'], $_POST['dateEnd']));
            exit();
        } else {
            $statistical = $this->taskModel->statistical();
        }

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
        $data = array();
        $taskList = array();

        if(isset($_POST["search"])) {
            $tasks = $this->taskModel->getTaskByName($_POST["search"]);
        } 

        foreach ($tasks as $value) {
            $Users = $this->taskModel->getUserByID($value["AssignedBy"]);
            $taskPerformers = $this->taskModel->getTaskPerformers($value["TaskID"], $userInfo["UserID"]);

            if ($value["AssignedBy"] == $userInfo["UserID"] && empty($taskPerformers)) {
                $dateCreated = new DateTime($value["DateCreated"]);
                $deadline = $dateCreated->add(new DateInterval("P" . $value["Deadline"] . "D"));

                array_push($data, [
                    "TaskID" => $value["TaskID"],
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

                array_push($data, [
                    "TaskID" => $value["TaskID"],
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
                        $taskList = array_merge(array(), $data);
                        break;
                    }

                case "chua-hoan-thanh": {
                        foreach ($data as $value) {
                            if (strstr($value["Status"], "Hoàn thành") == false
                            && $value["Status"] !== "Dự thảo") {
                                array_push($taskList, [
                                    "TaskID" => $value["TaskID"],
                                    "TaskName" => $value["TaskName"],
                                    "Status" => $value["Status"],
                                    "Avatar" => $value["Avatar"],
                                    "FullName" => $value["FullName"],
                                    "Deadline" => $value["Deadline"],
                                    "Progress" => $value["Progress"]
                                ]);
                            }
                        }
                        break;
                    }

                case "hoan-tat": {
                        foreach ($data as $value) {
                            if (strstr($value["Status"], "Hoàn thành") != false) {
                                array_push($taskList, [
                                    "TaskName" => $value["TaskName"],
                                    "Status" => $value["Status"],
                                    "Avatar" => $value["Avatar"],
                                    "FullName" => $value["FullName"],
                                    "Deadline" => $value["Deadline"],
                                    "Progress" => $value["Progress"]
                                ]);
                            }
                        }
                        break;
                    }

                case "cho-phe-duyet": {
                        foreach ($data as $value) {
                            if ($value["Status"] === "Chờ duyệt") {
                                array_push($taskList, [
                                    "TaskName" => $value["TaskName"],
                                    "Status" => $value["Status"],
                                    "Avatar" => $value["Avatar"],
                                    "FullName" => $value["FullName"],
                                    "Deadline" => $value["Deadline"],
                                    "Progress" => $value["Progress"]
                                ]);
                            }
                        }
                        break;
                    }

                case "tu-choi-phe-duyet": {
                        foreach ($data as $value) {
                            if ($value["Status"] === "Từ chối phê duyệt") {
                                array_push($taskList, [
                                    "TaskName" => $value["TaskName"],
                                    "Status" => $value["Status"],
                                    "Avatar" => $value["Avatar"],
                                    "FullName" => $value["FullName"],
                                    "Deadline" => $value["Deadline"],
                                    "Progress" => $value["Progress"]
                                ]);
                            }
                        }
                        break;
                    }

                case "du-thao": {
                        foreach ($data as $value) {
                            if ($value["Status"] === "Dự thảo") {
                                array_push($taskList, [
                                    "TaskName" => $value["TaskName"],
                                    "Status" => $value["Status"],
                                    "Avatar" => $value["Avatar"],
                                    "FullName" => $value["FullName"],
                                    "Deadline" => $value["Deadline"],
                                    "Progress" => $value["Progress"]
                                ]);
                            }
                        }
                        break;
                    }

                default: {
                        $this->view('errors.404');
                        exit;
                    }
            }
        } else {
            $taskList = array_merge(array(), $data);
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
