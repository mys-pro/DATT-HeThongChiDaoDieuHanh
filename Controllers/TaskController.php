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

        if (checkRole($_SESSION["Role"], 4) || checkRole($_SESSION["Role"], 6)) {
            $this->view('tasks.index', [
                'active' => __FUNCTION__,
                'page' => 'tasks.pages.statistical',
                'data' => [
                    'pageTitle' => 'Thống kê',
                    'statistical' => $statistical,
                ],
            ]);
        } else {
            header('Location: ' . getWebRoot() . '/ac/cong-viec');
        }
    }

    public function report()
    {
        if (isset($_POST['department']) && isset($_POST['date'])) {
            $report = $this->taskModel->report($_POST['department'], $_POST['date'], $_POST['dateStart'], $_POST['dateEnd']);
        } else {
            $report = $this->taskModel->report();
        }

        $departmentFilter = $this->taskModel->getAll('Departments', ['DepartmentID', 'DepartmentName']);

        if (checkRole($_SESSION["Role"], 4) || checkRole($_SESSION["Role"], 6) || checkRole($_SESSION["Role"], 7)) {
            $this->view('tasks.index', [
                'active' => __FUNCTION__,
                'page' => 'tasks.pages.report',
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
        $userInfo = $_SESSION["UserInfo"][0];
        $tasks = $this->taskModel->getTask();
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
                $deadline = $dateCreated->add(new DateInterval("P" . ($value["Deadline"] - 1) . "D"));

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
                    $dateCreated = new DateTime($taskPerformers[0]["DateStart"]);
                    $deadline = $dateCreated->add(new DateInterval("P" . ($taskPerformers[0]["Deadline"] - 1) . "D"));

                    array_push($data, [
                        "TaskID" => $value["TaskID"],
                        "TaskName" => $value["TaskName"],
                        "Status" => $taskPerformers[0]["StatusPerformer"],
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

        function compareTaskIDDesc($a, $b)
        {
            return $b['TaskID'] <=> $a['TaskID'];
        }

        usort($taskList, 'compareTaskIDDesc');

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
            $status = $task[0]["StatusTask"];
            $progress = $task[0]["ProgressTask"];
            foreach ($task as $value) {
                $reviewer = $value["Reviewer"];

                if ($reviewer != null) {
                    if ($reviewer == 0) {
                        $userPerformer = $value["UserID"];
                        $deadlinePerformer = $value["DeadlineTaskPerformers"];
                    }

                    if ($reviewer == 1) {
                        $userReviewer = $value["UserID"];
                        $deadlineReviewer = $value["DeadlineTaskPerformers"];
                    }

                    if ($value["UserID"] == $_SESSION["UserInfo"][0]["UserID"]) {
                        $status = $value["StatusTaskPerformers"];
                        $progress = $value["ProgressTaskPerformers"];
                    }
                } else {
                    $userPerformer = 'null';
                    $userReviewer = 'null';
                    $deadlinePerformer = 1;
                    $deadlineReviewer = 1;
                }
            }

            $document = $this->taskModel->getDocumentByTaskID($task[0]["TaskID"]);
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

            $comment = $this->taskModel->getCommentByTaskID($task[0]["TaskID"]);
            $commentList = "";
            foreach ($comment as $value) {
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
                        <li class="dropdown-item rounded-3">
                            <button type="button" class="delete-comment-btn btn border-0 text-start w-100 text-danger p-0" data-value=" ' . sha1($value["CommentID"]) . ' "><i class="bi bi-trash3 me-2"></i>Xóa</button>
                        </li>
                    </ul>
                </div>';
                }

                $commentList .= '
                <div class="comment-info mb-1">
                            <p class="comment-info-name fw-semibold m-0">' . $value["FullName"] . '</p>
                            <p class="comment-info-date text-secondary m-0">' . date("d-m-Y", strtotime($value["DateCreated"])) . '</p>
                        </div>
                        ' . $value["Content"] . '
                    </div>
                </li>';
            }

            $data = ([
                "taskID" => $task[0]["TaskID"],
                "statusTask" => $status,
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
                "document" => $documentList,
                "progress" => $progress,
                'commentList' => $commentList
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
            $documents = $this->taskModel->getDocumentByTaskID($_POST["taskID"]);

            if ($this->taskModel->deleteTask($_POST["taskID"])) {
                foreach ($documents as $value) {
                    if (file_exists($value["FilePath"]))
                        unlink($value["FilePath"]);
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
                $htmlContent = str_replace('{{TaskName}}', $_POST['name'], $htmlContent);
                $htmlContent = str_replace('{{Description}}', $_POST['description'], $htmlContent);
                $htmlContent = str_replace('{{DateStart}}', $currentDate, $htmlContent);
                $htmlContent = str_replace('{{Deadline}}', date('d-m-Y', strtotime($currentDate . ' + ' . ($_POST['deadlineTaskPerformers'] - 1) . ' days')), $htmlContent);

                if (sendMail($user[0]["Gmail"], "Công việc ngày " . $currentDate, $htmlContent)) {
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
                echo json_encode(array("type" => "success", "documentList" => $documentList));
            } else {
                echo json_encode(array("type" => "fail"));
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
                    echo json_encode(array("type" => "success", "documentHtml" => $documentHtml));
                } else {
                    echo json_encode(array("type" => "fail"));
                }
            } else {
                echo json_encode(array("type" => "notFound"));
            }
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
                $comment = $this->taskModel->getCommentByTaskID($_POST["taskID"]);
                $commentList = "";
                foreach ($comment as $value) {
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
                            <li class="dropdown-item rounded-3">
                                <button type="button" class="delete-comment-btn btn border-0 text-start w-100 text-danger p-0" data-value=" ' . sha1($value["CommentID"]) . ' "><i class="bi bi-trash3 me-2"></i>Xóa</button>
                            </li>
                        </ul>
                    </div>';
                    }

                    $commentList .= '
                <div class="comment-info mb-1">
                            <p class="comment-info-name fw-semibold m-0">' . $value["FullName"] . '</p>
                            <p class="comment-info-date text-secondary m-0">' . date("d-m-Y", strtotime($value["DateCreated"])) . '</p>
                        </div>
                        ' . $value["Content"] . '
                    </div>
                </li>';
                }

                echo $commentList;
            } else {
                echo 'fail';
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
                $comment = $this->taskModel->getCommentByTaskID($_POST["taskID"]);
                $commentList = "";
                foreach ($comment as $value) {
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
                            <li class="dropdown-item rounded-3">
                                <button type="button" class="delete-comment-btn btn border-0 text-start w-100 text-danger p-0" data-value=" ' . sha1($value["CommentID"]) . ' "><i class="bi bi-trash3 me-2"></i>Xóa</button>
                            </li>
                        </ul>
                    </div>';
                    }

                    $commentList .= '
                <div class="comment-info mb-1">
                            <p class="comment-info-name fw-semibold m-0">' . $value["FullName"] . '</p>
                            <p class="comment-info-date text-secondary m-0">' . date("d-m-Y", strtotime($value["DateCreated"])) . '</p>
                        </div>
                        ' . $value["Content"] . '
                    </div>
                </li>';
                }

                echo $commentList;
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
                $htmlContent = str_replace('{{TaskName}}', $_POST['name'], $htmlContent);
                $htmlContent = str_replace('{{Description}}', $_POST['description'], $htmlContent);
                $htmlContent = str_replace('{{DateStart}}', $currentDate, $htmlContent);
                $htmlContent = str_replace('{{Deadline}}', date('d-m-Y', strtotime($currentDate . ' + ' . ($_POST['deadlineReview'] - 1) . ' days')), $htmlContent);

                if (sendMail($user[0]["Gmail"], "Công việc ngày " . $currentDate, $htmlContent)) {
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
            if ($this->taskModel->recallTask($_POST["taskID"], $_POST["taskReview"])) {
                $user = $this->taskModel->getUserByID($_POST['taskReview']);
                $htmlContent = file_get_contents(getWebRoot() . '/Views/emailTemplate/recallTask.html');
                $htmlContent = str_replace('{{nameTask}}', $_POST["name"], $htmlContent);

                if (sendMail($user[0]["Gmail"], "Thu hồi công việc", $htmlContent)) {
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

    public function approval()
    {
        echo __METHOD__;
    }
}
