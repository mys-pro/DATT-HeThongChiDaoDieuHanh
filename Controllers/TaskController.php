<?php
class TaskController extends BaseController
{
    private $taskModel;
    private $userModel;
    public function __construct()
    {
        if (!isset($_SESSION["UserInfo"])) {
            header("Location:" . getWebRoot());
        }

        $this->loadModel('TaskModel');
        $this->loadModel('UserModel');
        $this->taskModel = new TaskModel();
        $this->userModel = new UserModel();
    }

    public function notifyView()
    {
        if (isset($_POST["watchedID"])) {
            if ($this->taskModel->updateNotify($_POST["watchedID"])) {
                echo 'success';
            } else {
                echo 'fail';
            }
            exit();
        } else if (isset($_SESSION["UserInfo"])) {
            $notify = $this->taskModel->getNotifyByID($_SESSION["UserInfo"][0]["UserID"]);
            $notifyHTML = '';
            foreach ($notify as $value) {
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $currentDate = new DateTime();
                $targetDate = new DateTime($value["DateCreated"]);
                $interval = $currentDate->diff($targetDate);

                if ($interval->y != 0) {
                    $intervalText = $interval->y . ' năm trước';
                } else if ($interval->m != 0) {
                    $intervalText = $interval->m . ' tháng trước';
                } else if ($interval->d != 0) {
                    $intervalText = $interval->d . ' ngày trước';
                } else if ($interval->h != 0) {
                    $intervalText = $interval->h . ' giờ trước';
                } else if ($interval->i != 0) {
                    $intervalText = $interval->i . ' phút trước';
                } else {
                    $intervalText = '';
                }

                $notifyHTML .= '
                    <li data-id="' . $value["NotifyId"] . '"class="d-flex rounded-3 p-2 dropdown">
                        <a class="notify-link dropdown-item d-flex p-0 pe-5 ' . ($value["Watched"] != 0 ? "watched" : "") . '" href="' . getWebRoot() . $value["Link"] . '">
                            <img src="data:image/jpeg;base64,' . base64_encode($value["Avatar"]) . '" alt="" class="rounded-circle me-2" style="max-width: 36px; min-width: 36px;" height="36px">
                            <div class="notify-container text-break text-wrap">
                                <div class="notify-content">
                                    <span class="fw-semibold text-break text-wrap">' . $value["FullName"] . '</span>
                                    <span class="text-break text-wrap">' . $value["Content"] . '</span>
                                </div>
                                <p class="notify-date text-secondary m-0 p-0">' . $intervalText . '</p>
                            </div>
                        </a>

                        <div class="dropdown dropstart">
                            <button class="btn border-0 dropdown-toggle p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu px-1">
                                <li class="rounded-3"><a class="read-notify-btn dropdown-item text-success" role="button">
                                    <i class="bi bi-check2-square me-2"></i>Đã xem
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li class="rounded-3"><a class="delete-notify-btn dropdown-item text-danger" role="button">
                                    <i class="bi bi-trash3 me-2"></i>Xóa
                                </a></li>
                            </ul>
                        </div>
                    </li>';
            }

            echo $notifyHTML;
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function statistical()
    {
        if (!checkRole($_SESSION["Role"], 4) && !checkRole($_SESSION["Role"], 6)) {
            header('Location: ' . getWebRoot() . '/ac/cong-viec');
            exit();
        }

        if (isset($_POST['priority']) && isset($_POST['date'])) {
            echo json_encode($this->taskModel->statistical($_POST['priority'], $_POST['date'], $_POST['dateStart'], $_POST['dateEnd']));
            exit();
        } else {
            $statistical = $this->taskModel->statistical();
        }

        $notify = $this->taskModel->getNotifyByID($_SESSION["UserInfo"][0]["UserID"]);
        $quantityNotify = 0;
        foreach ($notify as $value) {
            if ($value["Watched"] == 0) {
                $quantityNotify++;
            }
        }

        $this->view('tasks.index', [
            'active' => __FUNCTION__,
            'page' => 'tasks.pages.statistical',
            'quantityNotify' => $quantityNotify,
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

        $notify = $this->taskModel->getNotifyByID($_SESSION["UserInfo"][0]["UserID"]);
        $quantityNotify = 0;
        foreach ($notify as $value) {
            if ($value["Watched"] == 0) {
                $quantityNotify++;
            }
        }

        if (checkRole($_SESSION["Role"], 4) || checkRole($_SESSION["Role"], 6) || checkRole($_SESSION["Role"], 7)) {
            $this->view('tasks.index', [
                'active' => __FUNCTION__,
                'page' => 'tasks.pages.report',
                'quantityNotify' => $quantityNotify,
                'data' => [
                    'pageTitle' => 'Báo cáo',
                    'departmentFilter' =>  $departmentFilter,
                    'report' => $report,
                ],
            ]);
        } else {
            header('Location: ' . getWebRoot() . '/ac/cong-viec');
        }
    }

    public function task()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $userInfo = $_SESSION["UserInfo"][0];
        $tasks = $this->taskModel->getTask();
        $subTasks = $this->taskModel->getSubTask();
        $data = array();
        $taskList = array();
        $subTaskList = array();

        if (isset($_POST["search"])) {
            $tasks = $this->taskModel->getTaskByName($_POST["search"]);
        }

        $notify = $this->taskModel->getNotifyByID($_SESSION["UserInfo"][0]["UserID"]);
        $quantityNotify = 0;
        foreach ($notify as $value) {
            if ($value["Watched"] == 0) {
                $quantityNotify++;
            }
        }

        foreach ($tasks as $value) {
            $Users = $this->taskModel->getUserByID($value["AssignedBy"]);
            $taskPerformers = $this->taskModel->getTaskPerformers($value["TaskID"], $userInfo["UserID"]);

            if ($value["AssignedBy"] == $userInfo["UserID"] && $value['ParentTaskID'] == NULL && empty($taskPerformers)) {
                $DateStart = new DateTime($value["DateStart"]);
                $deadline = $DateStart->add(new DateInterval("P" . ($value["Deadline"] - 1) . "D"));

                array_push($data, [
                    "TaskID" => $value["TaskID"],
                    "TaskName" => $value["TaskName"],
                    "Status" => $value["StatusTask"],
                    "Avatar" => base64_encode($Users[0]["Avatar"]),
                    "FullName" => $Users[0]["FullName"],
                    "Deadline" => $deadline->format("d-m-Y"),
                    "Progress" => $value["Progress"],
                    "AssignedBy" => $value["AssignedBy"]
                ]);
            } else if (!empty($taskPerformers)) {
                if ($taskPerformers[0]["DateStart"] != null) {
                    $DateStart = new DateTime($taskPerformers[0]["DateStart"]);
                    $deadline = $DateStart->add(new DateInterval("P" . ($taskPerformers[0]["Deadline"] - 1) . "D"));
                    $deadline = $deadline->format("d-m-Y");
                } else {
                    $deadline = null;
                }

                array_push($data, [
                    "TaskID" => $value["TaskID"],
                    "TaskName" => $value["TaskName"],
                    "Status" => $taskPerformers[0]["StatusPerformer"],
                    "Avatar" => base64_encode($Users[0]["Avatar"]),
                    "FullName" => $Users[0]["FullName"],
                    "Deadline" => $deadline,
                    "Progress" => $taskPerformers[0]["Progress"],
                    "AssignedBy" => $value["AssignedBy"]
                ]);
            }
        }

        foreach ($subTasks as $value) {
            $Users = $this->taskModel->getUserByID($value["AssignedBy"]);
            $DateStart = new DateTime($value["DateStart"]);
            $deadline = $DateStart->add(new DateInterval("P" . ($value["Deadline"] - 1) . "D"));

            if ($value["AssignedBy"] == $userInfo["UserID"]) {
                array_push($subTaskList, [
                    "TaskID" => $value["TaskID"],
                    "TaskName" => $value["TaskName"],
                    "Status" => $value["StatusTask"],
                    "Avatar" => base64_encode($Users[0]["Avatar"]),
                    "FullName" => $Users[0]["FullName"],
                    "Deadline" => $deadline->format("d-m-Y"),
                    "Progress" => $value["Progress"],
                    "AssignedBy" => $value["AssignedBy"],
                    "ParentTaskID" => $value["ParentTaskID"]
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
                            if (strstr($value["Status"], "Hoàn thành") == false && $value["Status"] !== "Dự thảo") {
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

        function compareTaskIDDesc($a, $b)
        {
            return $b['TaskID'] <=> $a['TaskID'];
        }

        usort($taskList, 'compareTaskIDDesc');
        $this->view('tasks.index', [
            'active' => __FUNCTION__,
            'page' => 'tasks.pages.task',
            'quantityNotify' => $quantityNotify,
            'data' => [
                'pageTitle' => 'Công việc',
                'taskList' => $taskList,
                'subTask' => $subTaskList,
                'departmentList' => $this->taskModel->getAll('departments'),
                'userList' => $this->userModel->userAll(),
                'role' => $this->userModel->getAll("Permissions"),
            ],
        ]);
    }

    public function signature()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $signature = $this->taskModel->getAll("Tasks");

        $signatureList = array();
        foreach ($signature as $value) {
            $DateStart = new DateTime($value["DateStart"]);
            $deadline = $DateStart->add(new DateInterval("P" . ($value["Deadline"] - 1) . "D"));

            $taskPerformer = $this->taskModel->getTaskPerformersByTaskId($value["TaskID"]);
            if ($value["AssignedBy"] == $_SESSION["UserInfo"][0]["UserID"]) {
                if ((count($taskPerformer) == 2 && $taskPerformer[1]["Status"] == 'Chờ duyệt') ||
                    (count($taskPerformer) == 1 && $taskPerformer[0]["Status"] == 'Chờ duyệt')
                ) {
                    $Users = $this->taskModel->getUserByID($value["AssignedBy"]);
                    array_push($signatureList, [
                        "TaskID" => $value["TaskID"],
                        "TaskName" => $value["TaskName"],
                        "Status" => $value["Status"],
                        "Avatar" => base64_encode($Users[0]["Avatar"]),
                        "FullName" => $Users[0]["FullName"],
                        "Deadline" => $deadline->format("d-m-Y"),
                        "Progress" => $value["Progress"],
                        "AssignedBy" => $value["AssignedBy"]
                    ]);
                }
            }
        }

        $notify = $this->taskModel->getNotifyByID($_SESSION["UserInfo"][0]["UserID"]);
        $quantityNotify = 0;
        foreach ($notify as $value) {
            if ($value["Watched"] == 0) {
                $quantityNotify++;
            }
        }

        $this->view('tasks.index', [
            'active' => __FUNCTION__,
            'page' => 'tasks.pages.signature',
            'quantityNotify' => $quantityNotify,
            'data' => [
                'pageTitle' => 'Xét duyệt',
                'signatureList' => $signatureList
            ],
        ]);
    }

    public function deleteNotify()
    {
        if (isset($_POST["notifyID"])) {
            if ($this->taskModel->deleteNotify($_POST["notifyID"])) {
                $notify = $this->taskModel->getNotifyByID($_SESSION["UserInfo"][0]["UserID"]);
                $quantityNotify = 0;
                foreach ($notify as $value) {
                    if ($value["Watched"] == 0) {
                        $quantityNotify++;
                    }
                }
                echo json_encode(["type" => "success", "quality" => $quantityNotify]);
            } else {
                echo json_encode(["type" => "fail"]);
            }
            exit;
        } else {
            $this->view('errors.404');
        }
    }

    public function readNotify()
    {
        if (isset($_POST["notifyID"])) {
            if ($this->taskModel->readNotify($_POST["notifyID"])) {
                $notify = $this->taskModel->getNotifyByID($_SESSION["UserInfo"][0]["UserID"]);
                $quantityNotify = 0;
                foreach ($notify as $value) {
                    if ($value["Watched"] == 0) {
                        $quantityNotify++;
                    }
                }
                echo json_encode(["type" => "success", "quality" => $quantityNotify]);
            } else {
                echo json_encode(["type" => "fail"]);
            }
            exit;
        } else {
            $this->view('errors.404');
        }
    }

    public function addTask()
    {
        if (isset($_POST["taskName"])) {
            $taskName = $_POST["taskName"];
            $insert = $this->taskModel->insertData("Tasks", ['NULL', "'{$taskName}'", "''", "'1'", "'0'", "'Dự thảo'", 'NULL', "'2'", 'NULL', 'NULL', "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);
            if ($insert) {
                sendPusherEvent('direct_operator', 'update', array(
                    'taskID' => $insert,
                    'type' => 'update-task'
                ));

                echo json_encode(["type" => "success", "id" => $insert]);
            } else {
                echo json_encode(["type" => "fail"]);
            }
            exit;
        } else {
            $this->view('errors.404');
        }
    }

    public function forwardTask()
    {
        if (isset($_POST["taskID"])) {
            $insert = $this->taskModel->insertData("Tasks", ['NULL', "'{$_POST["taskName"]}'", "''", "'1'", "'0'", "'Dự thảo'", 'NULL', "'2'", 'NULL', "'{$_POST["taskID"]}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'"]);
            if ($insert) {
                sendPusherEvent('direct_operator', 'update', array(
                    'taskID' => $insert,
                    'type' => 'update-task'
                ));

                echo json_encode(["type" => "success", "id" => $insert]);
            } else {
                echo json_encode(["type" => "fail"]);
            }
            exit;
        } else {
            $this->view('errors.404');
        }
    }

    public function viewTask()
    {
        if (isset($_POST["idTask"])) {
            $view = 'task';
            $idTask = $_POST["idTask"];
            $userID = $_SESSION["UserInfo"][0]["UserID"];
            $page = 'tasks.pages.viewTask';
            if (isset($_POST["view"])) {
                $view = $_POST["view"];
            }

            $task = $this->taskModel->getTaskByIdTask($idTask);
            $taskPerformer = $this->taskModel->getTaskPerformersByTaskId($idTask);
            $status = $task[0]["StatusTask"];
            $progress = $task[0]["Progress"];
            $dateStart = $task[0]["DateStart"];

            if ($task[0]["ParentTaskID"] != NULL) {
                $page = 'tasks.pages.viewChildTask';
            }

            foreach ($taskPerformer as $value) {
                if ($value["UserID"] == $userID) {
                    $status = $value["StatusPerformer"];
                    $progress = $value["Progress"];
                    $dateStart = $value["DateStart"];
                    break;
                }
            }

            $performerID = null;
            $deadlinePerformer = 1;
            $reviewerID = null;
            $deadlineReviewer = 1;

            foreach ($taskPerformer as $value) {
                if ($value["Reviewer"] == 0) {
                    $performerID = $value["UserID"];
                    $deadlinePerformer = $value["Deadline"];
                } else {
                    $reviewerID = $value["UserID"];
                    $deadlineReviewer = $value["Deadline"];
                }
            }


            echo $this->view(
                $page,
                [
                    'status' => $status,
                    'assignedBy' => $task[0]["AssignedBy"],
                    'taskName' => $task[0]["TaskName"],
                    'dateStart' => $dateStart,
                    'priority' => $task[0]["Priority"],
                    'deadlineTask' => $task[0]["Deadline"],
                    'assignedInfo' => $this->userModel->userInfo($task[0]["AssignedBy"]),
                    'description' => $task[0]["Description"],
                    'departmentList' => $this->taskModel->getAll('Departments'),
                    'userList' => $this->userModel->userAll(),
                    'roleList' => $this->taskModel->getAll('Permissions'),
                    'performerID' => $performerID,
                    'deadlinePerformer' => $deadlinePerformer,
                    'reviewerID' => $reviewerID,
                    'deadlineReviewer' => $deadlineReviewer,
                    'documentList' => $this->taskModel->getDocumentByTaskID($idTask),
                    'commentList' => $this->taskModel->getCommentByTaskID($idTask),
                    'progress' => $progress,
                    'view' => $view,
                ]
            );
            exit;
        } else {
            $this->view('errors.404');
        }
    }

    public function deleteTask()
    {
        if (isset($_POST["taskID"])) {
            $documents = $this->taskModel->getDocumentByTaskID($_POST["taskID"]);

            if ($this->taskModel->deleteTask($_POST["taskID"], $_POST["taskPerformers"], $_POST["taskReview"])) {
                foreach ($documents as $value) {
                    if (file_exists($value["FilePath"]))
                        unlink($value["FilePath"]);
                }

                $childTasks = $this->taskModel->getTaskByParentTask($_POST["taskID"]);
                if (empty($childTasks)) {
                    sendPusherEvent('direct_operator', 'update', array(
                        'taskID' => $_POST["taskID"],
                        'userID' => $_SESSION["UserInfo"][0]["UserID"],
                        'type' => 'delete-task',
                    ));
                } else {
                    foreach ($childTasks as $value) {
                        sendPusherEvent('direct_operator', 'update', array(
                            'taskID' => $value["taskID"],
                            'userID' => $_SESSION["UserInfo"][0]["UserID"],
                            'type' => 'delete-task',
                        ));
                        sleep(3);
                    }
                }
                echo "success";
            } else {
                echo "fail";
            }
            exit;
        } else {
            $this->view('errors.404');
        }
    }

    public function updateTask()
    {
        if (isset($_POST['taskID'])) {
            $data = [
                'taskID' => $_POST['taskID'],
                'name' => $_POST['name'],
                'priority' => $_POST['priority'],
                'description' => $_POST['description'],
                'deadlineTask' => $_POST['deadlineTask'],
                'deadlinePerformer' => $_POST['deadlinePerformer'],
                'deadlineReview' => $_POST['deadlineReview'],
                'progress' => $_POST['progress']
            ];

            if ($this->taskModel->updateTask($data)) {
                sendPusherEvent('direct_operator', 'update', array(
                    'taskID' => $_POST['taskID'],
                    'type' => 'update-task'
                ));
                echo "success";
            } else {
                echo "fail";
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function updateChildTask()
    {
        if (isset($_POST['taskID'])) {
            $data = [
                'taskID' => $_POST['taskID'],
                'name' => $_POST['name'],
                'priority' => $_POST['priority'],
                'description' => $_POST['description'],
                'deadlineTask' => $_POST['deadlineTask'],
                'deadlinePerformer' => $_POST['deadlinePerformer'],
                'progress' => $_POST['progress']
            ];

            if ($this->taskModel->updateChildTask($data)) {
                sendPusherEvent('direct_operator', 'update', array(
                    'taskID' => $_POST['taskID'],
                    'type' => 'update-task'
                ));
                echo "success";
            } else {
                echo "fail";
            }
            exit();
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
                $htmlContent = str_replace('{{title}}', "Thông báo giao công việc", $htmlContent);
                $htmlContent = str_replace('{{container}}', "Chúng tôi xin thông báo rằng một công việc mới đã được tạo trên hệ thống của chúng tôi", $htmlContent);
                $htmlContent = str_replace('{{TaskName}}', $_POST['name'], $htmlContent);
                $htmlContent = str_replace('{{Description}}', $_POST['description'], $htmlContent);
                $htmlContent = str_replace('{{DateStart}}', $currentDate, $htmlContent);
                $htmlContent = str_replace('{{Deadline}}', date('d-m-Y', strtotime($currentDate . ' + ' . ($_POST['deadlineTaskPerformers'] - 1) . ' days')), $htmlContent);

                if (sendMail($user[0]["Gmail"], "Công việc ngày " . $currentDate, $htmlContent)) {
                    sendPusherEvent('direct_operator', 'update', array(
                        'taskID' => $_POST['taskID'],
                        'type' => 'update-task'
                    ));
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                echo "fail";
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function sendTaskChild()
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
            ];

            $user = $this->taskModel->getUserByID($_POST['taskPerformers']);
            if (
                $_POST['taskPerformers'] == $_SESSION["UserInfo"][0]["UserID"] ||
                $user[0]["PositionID"] == $_SESSION["UserInfo"][0]["PositionID"] ||
                ($user[0]["PositionID"] != 5 && $_SESSION["UserInfo"][0]["PositionID"] == 4)
            ) {
                echo "absurd";
                exit();
            } else if ($this->taskModel->sendChildTask($data)) {
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $currentDate = date('d-m-Y');
                $htmlContent = file_get_contents(getWebRoot() . '/Views/emailTemplate/sendTask.html');
                $htmlContent = str_replace('{{title}}', "Thông báo giao công việc", $htmlContent);
                $htmlContent = str_replace('{{container}}', "Chúng tôi xin thông báo rằng một công việc mới đã được tạo trên hệ thống của chúng tôi", $htmlContent);
                $htmlContent = str_replace('{{TaskName}}', $_POST['name'], $htmlContent);
                $htmlContent = str_replace('{{Description}}', $_POST['description'], $htmlContent);
                $htmlContent = str_replace('{{DateStart}}', $currentDate, $htmlContent);
                $htmlContent = str_replace('{{Deadline}}', date('d-m-Y', strtotime($currentDate . ' + ' . ($_POST['deadlineTaskPerformers'] - 1) . ' days')), $htmlContent);

                if (sendMail($user[0]["Gmail"], "Công việc ngày " . $currentDate, $htmlContent)) {
                    sendPusherEvent('direct_operator', 'update', array(
                        'taskID' => $_POST['taskID'],
                        'type' => 'update-task'
                    ));
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                echo "fail";
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function viewFeedback()
    {
        if (isset($_POST["taskID"])) {
            $data = $this->taskModel->getTaskPerformers($_POST["taskID"], $_SESSION["UserInfo"][0]["UserID"]);
            if(count($this->taskModel->getTaskPerformersByTaskId($_POST["taskID"])) == 2) {
                $status = $this->taskModel->getTaskPerformersByReviewer($_POST["taskID"], 1)[0]["Status"];
            } else {
                $status = $this->taskModel->getTaskPerformersByReviewer($_POST["taskID"], 0)[0]["Status"];
            }
            
            $show = $status == "Từ chối phê duyệt";
            $view = $_POST["view"];
            $feedbackView = '';

            $feedbackView .= '<div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="feedback-task-label">' . (!empty($data) && $data[0]["StatusPerformer"] == "Từ chối phê duyệt" && $view == "content" ? "Lý do" : "Nhận xét") . '</h1>';

            $feedbackView .= '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating">
                        <textarea class="form-control" id="feedback-area" style="height: 100px" ' . ($view == "content" ? "Disabled" : "") . ' >' . (!empty($data) && $view == "content" ? $data[0]["Comment"] : "") . '</textarea>
                        <label for="feedback-area" id="feedback-area-label">Nội dung</label>';

            $feedbackView .= ' </div>
                        </div>
                        <div class="modal-footer">';

            if ($view == "content") {
                $feedbackView .= '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quay lại</button>';
            } else {
                $feedbackView .= '<button id="submit-comment-task" type="button" class="btn btn-primary">Xác nhận</button>';
            }

            $feedbackView .= '</div></div></div>';

            echo json_encode([
                "show" => $show,
                "content" => $feedbackView
            ]);
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function viewFile()
    {
        if (isset($_POST["taskID"])) {
        } else {
            $this->view('errors.404');
        }
    }

    public function uploadFile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['files']) && isset($_POST["taskID"])) {
            $type = null;
            $files = $_FILES['files'];
            $uploadDirectory = 'uploads/';

            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            for ($i = 0; $i < count($files['name']); $i++) {
                $originalFileName = pathinfo($files['name'][$i], PATHINFO_FILENAME);
                $extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $filePath = $uploadDirectory . $fileName;

                if (move_uploaded_file($files['tmp_name'][$i], $filePath)) {
                    $fileSize = formatSizeUnits(filesize($filePath));
                    $insert = $this->taskModel->insertData('Documents', ["NULL", "'{$_POST["taskID"]}'", "'{$files['name'][$i]}'", "'{$fileSize}'", "'{$filePath}'", "current_timestamp()"]);
                    if ($insert) {
                        $type = true;
                    } else {
                        unlink($filePath);
                        $type = false;
                    }
                } else {
                    $type = false;
                }
            }

            if ($type == true) {
                $document = $this->taskModel->getDocumentByTaskID($_POST["taskID"]);

                $documentList = "";
                foreach ($document as $value) {
                    $documentList .= '<li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between mb-2 rounded-3">
                            <span class="file-name fw-medium">
                                <span data-value="' . sha1($value["DocumentID"]) . '" class="link-file text-primary text-decoration-underline me-2">' . $value["FileName"] . '</span>
                                <span class="text-secondary fw-normal">(' . $value["FileSize"] . ')</span>
                            </span>
                            <button class="remove-file-btn btn btn-white border-0"><i class="bi bi-x-lg"></i></button>
                        </li>';
                }
                sendPusherEvent(
                    'direct_operator',
                    'update',
                    array(
                        'taskID' => $_POST['taskID'],
                        'type' => 'update-file',
                        'content' => $documentList,
                    )
                );
                echo "success";
            } else {
                echo "fail";
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function downloadFile()
    {
        if (isset($_POST["documentID"])) {
            $documentID = $_POST["documentID"];
            $document = $this->taskModel->getAll("Documents");
            $filePath = "";
            $fileName = "";
            foreach ($document as $doc) {
                if (sha1($doc["DocumentID"]) == $documentID) {
                    $filePath = $doc["FilePath"];
                    $fileName = $doc["FileName"];
                    break;
                }
            }

            if (file_exists($filePath)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filePath));
                echo $fileName . ", " . getWebRoot() . "/" . $filePath;
            } else {
                echo 'notFound';
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function removeFile()
    {
        if (isset($_POST["documentID"])) {
            $documentID = $_POST["documentID"];
            $document = $this->taskModel->getAll("Documents");
            $filePath = "";
            $id = "";
            foreach ($document as $doc) {
                if (sha1($doc["DocumentID"]) == $documentID) {
                    $filePath = $doc["FilePath"];
                    $id = $doc["DocumentID"];
                    break;
                }
            }
            if (file_exists($filePath) && $id != "") {
                unlink($filePath);
                if ($this->taskModel->removeDocument($id)) {
                    $documentList = $this->taskModel->getDocumentByTaskID($_POST["taskID"]);

                    $documentHtml = "";
                    foreach ($documentList as $value) {
                        $documentHtml .= '<li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between mb-2 rounded-3">
                                <span class="file-name fw-medium">
                                    <span data-value="' . sha1($value["DocumentID"]) . '" class="link-file text-primary text-decoration-underline me-2">' . $value["FileName"] . '</span>
                                    <span class="text-secondary fw-normal">(' . $value["FileSize"] . ')</span>
                                </span>
                                <button class="remove-file-btn btn btn-white border-0"><i class="bi bi-x-lg"></i></button>
                            </li>';
                    }
                    sendPusherEvent('direct_operator', 'update', array(
                        'taskID' => $_POST['taskID'],
                        'type' => 'update-file',
                        'content' => $documentHtml,
                    ));
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                echo "notFound";
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function viewComment()
    {
        if (isset($_POST["taskID"])) {
            $comment = $this->taskModel->getCommentByTaskID($_POST["taskID"]);

            $commentList = "";
            foreach ($comment as $value) {
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $currentDate = new DateTime();
                $targetDate = new DateTime($value["DateCreated"]);
                $interval = $currentDate->diff($targetDate);

                if ($interval->y != 0) {
                    $intervalText = $interval->y . ' năm trước';
                } else if ($interval->m != 0) {
                    $intervalText = $interval->m . ' tháng trước';
                } else if ($interval->d != 0) {
                    $intervalText = $interval->d . ' ngày trước';
                } else if ($interval->h != 0) {
                    $intervalText = $interval->h . ' giờ trước';
                } else if ($interval->i != 0) {
                    $intervalText = $interval->i . ' phút trước';
                } else {
                    $intervalText = '';
                }

                $commentList .= '
                <li class="list-group-item d-flex">
                    <img src="data:image/jpeg;base64,' . base64_encode($value["Avatar"]) . '" alt="" class="rounded-circle me-2" style="max-width: 36px; min-width: 36px;" height="36px">
                    <div class="comment-content">';

                if ($value["UserID"] == $_SESSION["UserInfo"][0]["UserID"]) {
                    $commentList .= '
                        <div class="dropdown position-static">
                        <button class="btn border-0 dropdown-toggle position-absolute top-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots text-secondary"></i>
                        </button>
                        <ul class="dropdown-menu p-2">
                            <li class="dropdown-item rounded-3 p-0">
                                <button type="button" class="delete-comment-btn btn border-0 text-start w-100 text-danger" data-value=" ' . sha1($value["CommentID"]) . ' "><i class="bi bi-trash3 me-2"></i>Xóa</button>
                            </li>
                        </ul>
                    </div>';
                }

                $commentList .= '
                <div class="comment-info mb-1">
                            <span class="comment-info-name fw-semibold me-2">' . $value["FullName"] . '</span>
                            <span class="comment-info-date text-secondary">' . $intervalText . '</span>
                        </div>
                        ' . $value["Content"] . '
                    </div>
                </li>';
            }

            echo $commentList;
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function addComment()
    {
        if (isset($_POST["taskID"])) {
            $insert = $this->taskModel->insertData("Comments", ['NULL', "'{$_POST["taskID"]}'", "'{$_SESSION["UserInfo"][0]["UserID"]}'", "'{$_POST["comment"]}'", 'current_timestamp()']);

            if ($insert) {
                sendPusherEvent('direct_operator', 'update', array(
                    'taskID' => $_POST['taskID'],
                    'type' => 'update-comment',
                ));
                echo "success";
            } else {
                echo "fail";
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function deleteComment()
    {
        if (isset($_POST["commentID"])) {
            $id = "";
            $commentAll = $this->taskModel->getAll("Comments");
            foreach ($commentAll as $value) {
                if (sha1($value["CommentID"]) == trim($_POST["commentID"])) {
                    $id = $value["CommentID"];
                    break;
                }
            }

            if ($id != "" && $this->taskModel->removeComment($id)) {
                sendPusherEvent('direct_operator', 'update', array(
                    'taskID' => $_POST['taskID'],
                    'type' => 'update-comment',
                ));
                echo "success";
            } else {
                echo "fail";
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function sendAppraisal()
    {
        if (isset($_POST["taskID"])) {
            if ($this->taskModel->sendAppraisal($_POST["taskID"], $_POST["progress"], $_POST["taskReview"])) {
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $currentDate = date('d-m-Y');
                $user = $this->taskModel->getUserByID($_POST['taskReview']);
                $htmlContent = file_get_contents(getWebRoot() . '/Views/emailTemplate/sendTask.html');
                $htmlContent = str_replace('{{title}}', "Thẩm định công việc", $htmlContent);
                $htmlContent = str_replace('{{container}}', "Chúng tôi xin thông báo rằng có công việc cần bạn thẩm định", $htmlContent);
                $htmlContent = str_replace('{{TaskName}}', $_POST['name'], $htmlContent);
                $htmlContent = str_replace('{{Description}}', $_POST['description'], $htmlContent);
                $htmlContent = str_replace('{{DateStart}}', $currentDate, $htmlContent);
                $htmlContent = str_replace('{{Deadline}}', date('d-m-Y', strtotime($currentDate . ' + ' . ($_POST['deadlineReview'] - 1) . ' days')), $htmlContent);

                if (sendMail($user[0]["Gmail"], "Công việc ngày " . $currentDate, $htmlContent)) {
                    sendPusherEvent('direct_operator', 'update', array(
                        'taskID' => $_POST['taskID'],
                        'type' => 'update-task'
                    ));
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                echo "fail";
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function recallTask()
    {
        if (isset($_POST["taskID"])) {
            $statusReviewer = $this->taskModel->getTaskPerformers($_POST["taskID"], $_POST["taskReview"])[0]["Status"];
            if ($_SESSION["UserInfo"][0]["UserID"] != $_POST["taskReview"] && $statusReviewer == "Chờ duyệt") {
                echo "signing";
            } else if ($this->taskModel->recallTask($_POST["taskID"], $_POST["taskReview"])) {
                if ($_POST["taskReview"] != $_SESSION["UserInfo"][0]["UserID"]) {
                    $user = $this->taskModel->getUserByID($_POST['taskReview']);
                } else {
                    $task = $this->taskModel->viewTask($_POST["taskID"]);
                    $user = $this->taskModel->getUserByID($task[0]["AssignedBy"]);
                }
                $htmlContent = file_get_contents(getWebRoot() . '/Views/emailTemplate/recallTask.html');
                $htmlContent = str_replace('{{nameTask}}', $_POST["name"], $htmlContent);

                if (sendMail($user[0]["Gmail"], "Thu hồi công việc", $htmlContent)) {
                    sendPusherEvent('direct_operator', 'update', array(
                        'taskID' => $_POST["taskID"],
                        'userID' => $user[0]["UserID"],
                        'type' => 'recall-task',
                    ));
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                echo "fail";
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function recallChildTask()
    {
        if (isset($_POST["taskID"])) {
            if ($this->taskModel->recallChildTask($_POST["taskID"])) {
                $task = $this->taskModel->viewTask($_POST["taskID"]);
                $user = $this->taskModel->getUserByID($task[0]["AssignedBy"]);
                
                $htmlContent = file_get_contents(getWebRoot() . '/Views/emailTemplate/recallTask.html');
                $htmlContent = str_replace('{{nameTask}}', $_POST["name"], $htmlContent);

                if (sendMail($user[0]["Gmail"], "Thu hồi công việc", $htmlContent)) {
                    sendPusherEvent('direct_operator', 'update', array(
                        'taskID' => $_POST["taskID"],
                        'userID' => $user[0]["UserID"],
                        'type' => 'recall-task',
                    ));
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                echo "fail";
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function refuseTask()
    {
        if (isset($_POST["taskID"])) {
            if ($this->taskModel->refuseTask($_POST["taskID"], $_POST["taskPerformers"], $_POST["taskReviewer"], $_POST["content"])) {
                $task = $this->taskModel->getTaskByIdTask($_POST["taskID"]);
                if ($task[0]["AssignedBy"] != $_SESSION["UserInfo"][0]["UserID"]) {
                    $userID = $_POST['taskPerformers'];
                    $title = "Từ chối thẩm định";
                } else {
                    $userID = $_POST["taskReviewer"];
                    $title = "Từ chối phê duyệt";
                }

                $user = $this->taskModel->getUserByID($userID);

                $htmlContent = file_get_contents(getWebRoot() . '/Views/emailTemplate/refuseTask.html');
                $htmlContent = str_replace('{{title}}', $title, $htmlContent);
                $htmlContent = str_replace('{{nameTask}}', $_POST["name"], $htmlContent);
                $htmlContent = str_replace('{{comment}}', nl2br($_POST["content"]) . "\n\n", $htmlContent);

                if (sendMail($user[0]["Gmail"], $title, $htmlContent)) {
                    sendPusherEvent('direct_operator', 'update', array(
                        'taskID' => $_POST["taskID"],
                        'userID' => $userID,
                        'type' => 'refuse-task',
                    ));
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                echo "fail";
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function refuseChildTask()
    {
        if (isset($_POST["taskID"])) {
            if ($this->taskModel->refuseChildTask($_POST["taskID"], $_POST["taskPerformers"], $_POST["content"])) {
                $userID = $_POST["taskPerformers"];
                $title = "Từ chối phê duyệt";

                $user = $this->taskModel->getUserByID($userID);

                $htmlContent = file_get_contents(getWebRoot() . '/Views/emailTemplate/refuseTask.html');
                $htmlContent = str_replace('{{title}}', $title, $htmlContent);
                $htmlContent = str_replace('{{nameTask}}', $_POST["name"], $htmlContent);
                $htmlContent = str_replace('{{comment}}', nl2br($_POST["content"]) . "\n\n", $htmlContent);

                if (sendMail($user[0]["Gmail"], $title, $htmlContent)) {
                    sendPusherEvent('direct_operator', 'update', array(
                        'taskID' => $_POST["taskID"],
                        'userID' => $userID,
                        'type' => 'refuse-task',
                    ));
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                echo "fail";
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function sendSignatureTask()
    {
        if (isset($_POST["taskID"])) {
            if ($this->taskModel->sendSignatureTask($_POST["taskID"], $_POST["progress"], $_POST["taskPerformers"])) {
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $currentDate = date('d-m-Y');
                $task = $this->taskModel->getTaskByIdTask($_POST["taskID"]);
                $gmail1 = $this->taskModel->getUserByID($task[0]["AssignedBy"])[0]["Gmail"];
                $gmail2 = $this->taskModel->getUserByID($_POST["taskPerformers"])[0]["Gmail"];

                $htmlContent = file_get_contents(getWebRoot() . '/Views/emailTemplate/approveTask.html');
                $htmlContent = str_replace('{{title}}', 'Phê duyệt công việc', $htmlContent);
                $htmlContent = str_replace('{{content}}', 'Bạn có một công việc cần phê duyệt:', $htmlContent);
                $htmlContent = str_replace('{{nameTask}}', $_POST['name'], $htmlContent);
                $htmlContent = str_replace('{{nameSend}}', $_SESSION["UserInfo"][0]["FullName"], $htmlContent);
                $htmlContent = str_replace('{{dateSend}}', $currentDate, $htmlContent);
                $sendGmail1 = sendMail($gmail1, "Phê duyệt công việc ngày " . $currentDate, $htmlContent);

                $htmlContent = file_get_contents(getWebRoot() . '/Views/emailTemplate/approveTask.html');
                $htmlContent = str_replace('{{title}}', 'Trình ký công việc', $htmlContent);
                $htmlContent = str_replace('{{content}}', 'Công việc đã được trình ký:', $htmlContent);
                $htmlContent = str_replace('{{nameTask}}', $_POST['name'], $htmlContent);
                $htmlContent = str_replace('{{nameSend}}', $_SESSION["UserInfo"][0]["FullName"], $htmlContent);
                $htmlContent = str_replace('{{dateSend}}', $currentDate, $htmlContent);
                $sendGmail2 = sendMail($gmail2, "Trình ký công việc ngày " . $currentDate, $htmlContent);

                if ($sendGmail1 && $sendGmail2) {
                    echo "success";
                    sendPusherEvent('direct_operator', 'update', array(
                        'taskID' => $_POST["taskID"],
                        'type' => 'update-task'
                    ));
                } else {
                    echo "fail";
                }
            }
        } else {
            $this->view('errors.404');
        }
    }

    public function sendSignatureChildTask()
    {
        if (isset($_POST["taskID"])) {
            if ($this->taskModel->sendSignatureChildTask($_POST["taskID"], $_POST["progress"])) {
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $currentDate = date('d-m-Y');
                $task = $this->taskModel->getTaskByIdTask($_POST["taskID"]);
                $gmail1 = $this->taskModel->getUserByID($task[0]["AssignedBy"])[0]["Gmail"];

                $htmlContent = file_get_contents(getWebRoot() . '/Views/emailTemplate/approveTask.html');
                $htmlContent = str_replace('{{title}}', 'Phê duyệt công việc', $htmlContent);
                $htmlContent = str_replace('{{content}}', 'Bạn có một công việc cần phê duyệt:', $htmlContent);
                $htmlContent = str_replace('{{nameTask}}', $_POST['name'], $htmlContent);
                $htmlContent = str_replace('{{nameSend}}', $_SESSION["UserInfo"][0]["FullName"], $htmlContent);
                $htmlContent = str_replace('{{dateSend}}', $currentDate, $htmlContent);
                $sendGmail1 = sendMail($gmail1, "Phê duyệt công việc ngày " . $currentDate, $htmlContent);

                if ($sendGmail1) {
                    echo "success";
                    sendPusherEvent('direct_operator', 'update', array(
                        'taskID' => $_POST["taskID"],
                        'type' => 'update-task'
                    ));
                } else {
                    echo "fail";
                }
            }
        } else {
            $this->view('errors.404');
        }
    }

    public function signatureTask()
    {
        if (isset($_POST["taskID"])) {
            if ($this->taskModel->signatureTask($_POST["taskID"], $_POST["taskPerformers"], $_POST["taskReviewer"], $_POST["content"])) {
                $gmail1 = $this->taskModel->getUserByID($_POST["taskPerformers"])[0]["Gmail"];
                $gmail2 = $this->taskModel->getUserByID($_POST["taskReviewer"])[0]["Gmail"];

                $htmlContent = file_get_contents(getWebRoot() . '/Views/emailTemplate/signature.html');
                $htmlContent = str_replace('{{title}}', "Phê duyệt công việc", $htmlContent);
                $htmlContent = str_replace('{{nameTask}}', $_POST["name"], $htmlContent);
                $htmlContent = str_replace('{{comment}}', nl2br($_POST["content"]) . "\n\n", $htmlContent);

                if (sendMail($gmail1, "Phê duyệt công việc", $htmlContent) && sendMail($gmail2, "Phê duyệt công việc", $htmlContent)) {
                    sendPusherEvent('direct_operator', 'update', array(
                        'taskID' => $_POST["taskID"],
                        'type' => 'signature-task',
                        'userID' => $_SESSION["UserInfo"][0]["UserID"]
                    ));
                    echo "success";
                } else {
                    echo "fail";
                }
            }
        } else {
            $this->view('errors.404');
        }
    }

    public function signatureChildTask()
    {
        if (isset($_POST["taskID"])) {
            if ($this->taskModel->signatureChildTask($_POST["taskID"], $_POST["taskPerformers"], $_POST["content"])) {
                $gmail1 = $this->taskModel->getUserByID($_POST["taskPerformers"])[0]["Gmail"];

                $htmlContent = file_get_contents(getWebRoot() . '/Views/emailTemplate/signature.html');
                $htmlContent = str_replace('{{title}}', "Phê duyệt công việc", $htmlContent);
                $htmlContent = str_replace('{{nameTask}}', $_POST["name"], $htmlContent);
                $htmlContent = str_replace('{{comment}}', nl2br($_POST["content"]) . "\n\n", $htmlContent);

                if (sendMail($gmail1, "Phê duyệt công việc", $htmlContent)) {
                    sendPusherEvent('direct_operator', 'update', array(
                        'taskID' => $_POST["taskID"],
                        'type' => 'signature-task',
                        'userID' => $_SESSION["UserInfo"][0]["UserID"]
                    ));
                    echo "success";
                } else {
                    echo "fail";
                }
            }
        } else {
            $this->view('errors.404');
        }
    }
}
