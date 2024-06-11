<?php
class AdminController extends BaseController
{
    private $adminModel;
    private $taskModel;
    private $userModel;
    public function __construct()
    {
        if (!isset($_SESSION["UserInfo"]) || !checkRole($_SESSION["Role"], 6)) {
            header("Location:" . getWebRoot());
        }
        $this->loadModel('AdminModel');
        $this->loadModel('TaskModel');
        $this->loadModel('UserModel');
        $this->adminModel = new AdminModel();
        $this->taskModel = new TaskModel();
        $this->userModel = new UserModel();
    }

    public function department()
    {
        $department = $this->adminModel->getAll("Departments");

        if (isset($_POST["search"])) {
            $department = $this->adminModel->getDepartmentByName($_POST["search"]);
        }

        $notify = $this->taskModel->getNotifyByID($_SESSION["UserInfo"][0]["UserID"]);
        $quantityNotify = 0;
        foreach ($notify as $value) {
            if ($value["Watched"] == 0) {
                $quantityNotify++;
            }
        }

        $this->view('admins.index', [
            'active' => __FUNCTION__,
            'page' => 'admins.pages.department',
            'quantityNotify' => $quantityNotify,
            'data' => [
                'pageTitle' => 'Cơ cấu tổ chức',
                'department' => $department,
            ],
        ]);
    }

    public function viewDepartment()
    {
        if (isset($_POST["departmentID"])) {
            $department = $this->adminModel->getDepartmentById($_POST["departmentID"]);
            $data = '
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="view-department-modal__label">Phòng ban</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label for="view-department-name" class="mb-1">Tên phòng ban <span class="text-danger">*</span></label>
                            <input class="form-control mb-2" id="view-department-name" placeholder="Nhập tên phòng ban" rows="1" value="' . $department[0]["DepartmentName"] . '"></input>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="view-department-delete">Xóa</button>
                            <button type="button" class="btn btn-primary" id="view-department-save">Lưu</button>
                        </div>
                    </div>
                </div>
            ';

            echo $data;
        } else {
            $this->view('errors.404');
        }
    }

    public function addDepartment()
    {
        if (isset($_POST["departmentName"])) {
            if ($this->adminModel->insertData('Departments', ["NULL", "'{$_POST["departmentName"]}'", "current_timestamp()"])) {
                echo "success";
                sendPusherEvent(
                    'direct_operator',
                    'admin-update',
                    array(
                        'type' => 'department',
                    )
                );
            } else {
                echo 'fail';
            }
        } else {
            $this->view('errors.404');
        }
    }

    public function updateDepartment()
    {
        if (isset($_POST["departmentId"])) {
            if ($this->adminModel->updateDepartment($_POST["departmentId"], $_POST["departmentName"])) {
                echo 'success';
                sendPusherEvent(
                    'direct_operator',
                    'admin-update',
                    array(
                        'type' => 'department',
                    )
                );
            } else {
                echo 'fail';
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function deleteDepartment()
    {
        if (isset($_POST["departmentId"])) {
            if ($this->adminModel->deleteDepartment($_POST["departmentId"])) {
                echo 'success';
                sendPusherEvent(
                    'direct_operator',
                    'admin-update',
                    array(
                        'type' => 'department',
                    )
                );
            } else {
                echo 'fail';
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function position()
    {
        $position = $this->adminModel->getAll("Positions");

        if (isset($_POST["search"])) {
            $position = $this->adminModel->getPositionByName($_POST["search"]);
        }

        $notify = $this->taskModel->getNotifyByID($_SESSION["UserInfo"][0]["UserID"]);
        $quantityNotify = 0;
        foreach ($notify as $value) {
            if ($value["Watched"] == 0) {
                $quantityNotify++;
            }
        }

        $this->view('admins.index', [
            'active' => __FUNCTION__,
            'page' => 'admins.pages.position',
            'quantityNotify' => $quantityNotify,
            'data' => [
                'pageTitle' => 'Cơ cấu tổ chức',
                'position' => $position,
            ],
        ]);
    }

    public function addPosition()
    {
        if (isset($_POST["positionName"])) {
            if ($this->adminModel->insertData('Positions', ["NULL", "'{$_POST["positionName"]}'", "'{$_POST["description"]}'", "current_timestamp()"])) {
                echo 'success';
                sendPusherEvent(
                    'direct_operator',
                    'admin-update',
                    array(
                        'type' => 'position',
                    )
                );
            } else {
                echo 'fail';
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function viewPosition()
    {
        if (isset($_POST["positionID"])) {
            $position = $this->adminModel->getPositionById($_POST["positionID"]);
            $data = '
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="view-position-modal__label">Chức vụ</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label for="view-position-name" class="mb-1">Tên phòng ban <span class="text-danger">*</span></label>
                            <input class="form-control mb-2" id="view-position-name" placeholder="Nhập tên chức vụ" rows="1" value="' . $position[0]["PositionName"] . '"></input>

                            <label for="view-position-description" class="mb-1">Mô tả</label>
                            <textarea class="form-control mb-2" id="view-position-description">' . $position[0]["Description"] . '</textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="view-position-delete">Xóa</button>
                            <button type="button" class="btn btn-primary" id="view-position-save">Lưu</button>
                        </div>
                    </div>
                </div>
            ';

            echo $data;
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function updatePosition()
    {
        if (isset($_POST["positionID"])) {
            if ($this->adminModel->updatePosition($_POST["positionID"], $_POST["positionName"], $_POST["description"])) {
                echo 'success';
                sendPusherEvent(
                    'direct_operator',
                    'admin-update',
                    array(
                        'type' => 'position',
                    )
                );
            } else {
                echo 'fail';
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function deletePosition()
    {
        if (isset($_POST["positionId"])) {
            if ($this->adminModel->deletePosition($_POST["positionId"])) {
                echo 'success';
                sendPusherEvent(
                    'direct_operator',
                    'admin-update',
                    array(
                        'type' => 'position',
                    )
                );
            } else {
                echo 'fail';
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function user()
    {
        $user = $this->adminModel->getUser();
        if (isset($_POST["search"])) {
            $user = $this->adminModel->getUserByName($_POST["search"]);
        }

        $notify = $this->taskModel->getNotifyByID($_SESSION["UserInfo"][0]["UserID"]);
        $quantityNotify = 0;
        foreach ($notify as $value) {
            if ($value["Watched"] == 0) {
                $quantityNotify++;
            }
        }

        $this->view('admins.index', [
            'active' => __FUNCTION__,
            'page' => 'admins.pages.user',
            'quantityNotify' => $quantityNotify,
            'data' => [
                'pageTitle' => 'Người dùng',
                'user' => $user,
                'department' => $this->adminModel->getAll("Departments"),
                'position' => $this->adminModel->getAll("Positions")
            ],
        ]);
    }

    public function addUser()
    {
        if (isset($_POST["name"]) && isset($_POST["gmail"])) {
            if (!empty($this->adminModel->getUserByGmail($_POST["gmail"]))) {
                echo 'gmail-exist';
            } else {
                $insert = $this->adminModel->addUser($_POST["name"], $_POST["position"], $_POST["department"], $_POST["gmail"], $_POST["phone"], $_POST['roles']);
                if ($insert) {
                    $htmlContent = file_get_contents(getWebRoot() . '/Views/emailTemplate/activeAccount.html');
                    $htmlContent = str_replace('{{container}}', "Chúng tôi xin thông báo rằng một công việc mới đã được tạo trên hệ thống của chúng tôi", $htmlContent);
                    $htmlContent = str_replace('{{name}}', $_POST['name'], $htmlContent);
                    $htmlContent = str_replace('{{gmailName}}', $_POST['gmail'], $htmlContent);
                    $htmlContent = str_replace('{{gmail}}', $_POST['gmail'], $htmlContent);
                    $htmlContent = str_replace('{{activeLink}}', getWebRoot() . "/kich-hoat-tai-khoan?active=" . sha1($insert), $htmlContent);

                    if (sendMail($_POST['gmail'], "Kích hoạt tài khoản", $htmlContent)) {
                        echo "success";
                        sendPusherEvent(
                            'direct_operator',
                            'admin-update',
                            array(
                                'type' => 'user',
                            )
                        );
                    } else {
                        echo "fail";
                    }
                } else {
                    echo 'fail';
                }
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function viewUser()
    {
        if (isset($_POST["userID"])) {
            $user = $this->adminModel->getUserById($_POST["userID"]);
            $role = $this->adminModel->getRoleByUserID($_POST["userID"]);
            $department = $this->adminModel->getAll("Departments");
            $position = $this->adminModel->getAll("Positions");
            echo $this->view('admins.pages.viewUser', [
                'user' => $user,
                'role' => $role,
                'department' => $department,
                'position' => $position
            ]);
            exit();
        } else {
            $this->view('errors.404');
        }
    }

    public function deleteUser()
    {
        if (isset($_POST["userID"])) {
            if ($this->adminModel->deleteUser($_POST["userID"])) {
                echo 'success';
                sendPusherEvent(
                    'direct_operator',
                    'admin-update',
                    array(
                        'type' => 'delete-user',
                        'userID' => $_POST["userID"]
                    )
                );
            } else {
                echo 'fail';
            }
        } else {
            $this->view('errors.404');
        }
    }

    public function updateUser() {
        if (isset($_POST["userID"])) {
            if ($this->adminModel->updateUser($_POST["userID"], $_POST["name"], $_POST["position"], $_POST["department"], $_POST["phone"], $_POST["roles"])) {
                echo 'success';
                sendPusherEvent(
                    'direct_operator',
                    'admin-update',
                    array(
                        'type' => 'user',
                    )
                );
            } else {
                echo 'fail';
            }
        } else {
            $this->view('errors.404');
        }
    }
}
