<?php
class TaskController extends BaseController
{
    private $taskModel;
    private $userModel;
    public function __construct()
    {
        $this->loadModel('TaskModel');
        $this->loadModel('UserModel');
        $this->taskModel = new TaskModel();
        $this->userModel = new UserModel();
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

        if (isset($_POST["search"])) {
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
                    "Progress" => $value["Progress"],
                    "AssignedBy" => $value["AssignedBy"]
                ]);
            } else if (!empty($taskPerformers)) {
                if ($taskPerformers[0]["DateStart"] != null) {
                    $dateCreated = new DateTime($taskPerformers[0]["DateStart"]);
                    $deadline = $dateCreated->add(new DateInterval("P" . $taskPerformers[0]["Deadline"] . "D"));

                    array_push($data, [
                        "TaskID" => $value["TaskID"],
                        "TaskName" => $value["TaskName"],
                        "Status" => $taskPerformers[0]["Status"],
                        "Avatar" => base64_encode($Users[0]["Avatar"]),
                        "FullName" => $Users[0]["FullName"],
                        "Deadline" => $deadline->format("d-m-Y"),
                        "Progress" => $taskPerformers[0]["Progress"],
                        "AssignedBy" => $value["AssignedBy"]
                    ]);
                }
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
                            if (
                                strstr($value["Status"], "Hoàn thành") == false
                                && $value["Status"] !== "Dự thảo"
                            ) {
                                array_push($taskList, [
                                    "TaskID" => $value["TaskID"],
                                    "TaskName" => $value["TaskName"],
                                    "Status" => $value["Status"],
                                    "Avatar" => $value["Avatar"],
                                    "FullName" => $value["FullName"],
                                    "Deadline" => $value["Deadline"],
                                    "Progress" => $value["Progress"],
                                    "AssignedBy" => $value["AssignedBy"]
                                ]);
                            }
                        }
                        break;
                    }

                case "hoan-tat": {
                        foreach ($data as $value) {
                            if (strstr($value["Status"], "Hoàn thành") != false) {
                                array_push($taskList, [
                                    "TaskID" => $value["TaskID"],
                                    "TaskName" => $value["TaskName"],
                                    "Status" => $value["Status"],
                                    "Avatar" => $value["Avatar"],
                                    "FullName" => $value["FullName"],
                                    "Deadline" => $value["Deadline"],
                                    "Progress" => $value["Progress"],
                                    "AssignedBy" => $value["AssignedBy"]
                                ]);
                            }
                        }
                        break;
                    }

                case "cho-phe-duyet": {
                        foreach ($data as $value) {
                            if ($value["Status"] === "Chờ duyệt") {
                                array_push($taskList, [
                                    "TaskID" => $value["TaskID"],
                                    "TaskName" => $value["TaskName"],
                                    "Status" => $value["Status"],
                                    "Avatar" => $value["Avatar"],
                                    "FullName" => $value["FullName"],
                                    "Deadline" => $value["Deadline"],
                                    "Progress" => $value["Progress"],
                                    "AssignedBy" => $value["AssignedBy"]
                                ]);
                            }
                        }
                        break;
                    }

                case "tu-choi-phe-duyet": {
                        foreach ($data as $value) {
                            if ($value["Status"] === "Từ chối phê duyệt") {
                                array_push($taskList, [
                                    "TaskID" => $value["TaskID"],
                                    "TaskName" => $value["TaskName"],
                                    "Status" => $value["Status"],
                                    "Avatar" => $value["Avatar"],
                                    "FullName" => $value["FullName"],
                                    "Deadline" => $value["Deadline"],
                                    "Progress" => $value["Progress"],
                                    "AssignedBy" => $value["AssignedBy"]
                                ]);
                            }
                        }
                        break;
                    }

                case "du-thao": {
                        foreach ($data as $value) {
                            if ($value["Status"] === "Dự thảo") {
                                array_push($taskList, [
                                    "TaskID" => $value["TaskID"],
                                    "TaskName" => $value["TaskName"],
                                    "Status" => $value["Status"],
                                    "Avatar" => $value["Avatar"],
                                    "FullName" => $value["FullName"],
                                    "Deadline" => $value["Deadline"],
                                    "Progress" => $value["Progress"],
                                    "AssignedBy" => $value["AssignedBy"]
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
                'departmentList' => $this->taskModel->getAll('departments'),
                'userList' => $this->userModel->userAll(),
                'role' => $this->userModel->getAll("Permissions"),
            ],
        ]);
    }

    public function addTask()
    {
        if (isset($_POST["taskName"])) {
            $taskName = $_POST["taskName"];
            $insert = $this->taskModel->insertData("Tasks", ['NULL', "'${taskName}'", "''", "'1'", "'0'", "'Dự thảo'", 'current_timestamp()', "'2'", 'NULL', 'NULL', "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);
            if ($insert) {
                echo "success";
            } else {
                echo "fail";
            }
            exit;
        } else {
            $this->view('errors.404');
        }
    }

    public function viewTask()
    {
        if (isset($_POST["idTask"])) {
            $task = $this->taskModel->viewTask($_POST["idTask"]);
            foreach ($task as $value) {
                $reviewer = $value["Reviewer"];

                if ($reviewer != null) {
                    if ($reviewer == 0) {
                        $userPerformer = $value["UserID"];
                        $deadlinePerformer = $value["DeadlineTaskPerformers"];
                    } else if ($reviewer == 1) {
                        $userReviewer = $value["UserID"];
                        $deadlineReviewer = $value["DeadlineTaskPerformers"];
                    }
                } else {
                    $userPerformer = 'null';
                    $userReviewer = 'null';
                    $deadlinePerformer = 1;
                    $deadlineReviewer = 1;
                }
            }

            $data = ([
                "taskID" => $task[0]["TaskID"],
                "statusTask" => $task[0]["StatusTask"],
                "name" =>  $task[0]["TaskName"],
                "priority" => $task[0]["Priority"],
                "deadlineTask" => $task[0]["DeadlineTask"],
                "description" => $task[0]["Description"],
                "avatar" => base64_encode($task[0]["Avatar"]),
                "assignedBy" => $task[0]["FullName"],
                "position" => $task[0]["PositionName"],
                "department" => $task[0]["DepartmentName"],
                "userPerformer" => $userPerformer,
                "deadlinePerformer" => $deadlinePerformer,
                "userReviewer" => $userReviewer,
                "deadlineReviewer" => $deadlineReviewer,
            ]);

            echo json_encode($data);
            exit;
        } else {
            $this->view('errors.404');
        }
    }

    public function deleteTask()
    {
        if (isset($_POST["taskID"])) {
            if ($this->taskModel->deleteTask($_POST["taskID"])) {
                echo "success";
            } else {
                echo "fail";
            }
            exit;
        } else {
            $this->view('errors.404');
        }
    }

    public function sendTask()
    {
        if (isset($_POST["taskID"])) {
            $data = [
                'taskID' => $_POST['taskID'],
                'name' => $_POST['name'],
                'priority' => $_POST['priority'],
                'deadlineTask' => $_POST['deadlineTask'],
                'description' => $_POST['description'],
                'taskPerformers' => $_POST['taskPerformers'],
                'deadlineTaskPerformers' => $_POST['deadlineTaskPerformers'],
                'taskReview' => $_POST['taskReview'],
                'deadlineReview' => $_POST['deadlineReview']
            ];
            if ($this->taskModel->sendTask($data)) {
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $currentDate = date('d-m-Y');
                $user = $this->taskModel->getUserByID($_POST['taskPerformers']);
                $htmlContent = file_get_contents(getWebRoot() . '/Views/emailTemplate/sendTask.html');
                $htmlContent = str_replace('{{Receiver}}', $user[0]['FullName'], $htmlContent);
                $htmlContent = str_replace('{{TaskName}} ', $_POST['name'], $htmlContent);
                $htmlContent = str_replace('{{AssignedBy}}', $_SESSION["UserInfo"][0]["FullName"], $htmlContent);
                $htmlContent = str_replace('{{Description}} ', $_POST['description'], $htmlContent);
                $htmlContent = str_replace('{{DateStart}} ', $currentDate, $htmlContent);
                $htmlContent = str_replace('{{Deadline}} ', date('d-m-Y', strtotime($currentDate . ' + ' . $_POST['deadlineTaskPerformers'] . ' days')), $htmlContent);
                $htmlContent = str_replace('{{Email}}. ', $_SESSION["UserInfo"][0]["Gmail"], $htmlContent);
                
                if (sendMail($username, "Quên mật khẩu", $htmlContent)) {
                    echo sha1($login[0]['UserID']);
                } else {
                    
                }
            } else {
                echo "fail";
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function approval()
    {
        echo __METHOD__;
    }
}
