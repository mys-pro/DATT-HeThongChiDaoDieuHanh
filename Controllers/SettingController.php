<?php

class SettingController extends BaseController {
    private $taskModel;
    private $userModel;
    private $settingModel;
    public function __construct()
    {
        if (!isset($_SESSION["UserInfo"])) {
            header("Location:" . getWebRoot());
        }
        $this->loadModel('TaskModel');
        $this->loadModel('UserModel');
        $this->loadModel('SettingModel');
        $this->taskModel = new TaskModel();
        $this->userModel = new UserModel();
        $this->settingModel = new SettingModel();
    }

    public function userInfo() {
        $notify = $this->taskModel->getNotifyByID($_SESSION["UserInfo"][0]["UserID"]);
        $quantityNotify = 0;
        foreach ($notify as $value) {
            if ($value["Watched"] == 0) {
                $quantityNotify++;
            }
        }

        $this->view('settings.index', [
            'active' => __FUNCTION__,
            'page' => 'settings.pages.userInfo',
            'quantityNotify' => $quantityNotify,
            'data' => [
                'pageTitle' => 'Thông tin cá nhân',
            ],
        ]);
    }

    public function updateAvatar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
            $avatar = $_FILES['avatar']['tmp_name'];
            $imageData = file_get_contents($avatar);
            $imageData = addslashes($imageData);
            if($this->settingModel->updateAvatar($imageData)) {
                echo 'success';
                $userInfo = $this->settingModel->userInfo($_SESSION["UserInfo"][0]["UserID"]);
                $_SESSION["UserInfo"] = $userInfo;
                sendPusherEvent(
                    'direct_operator',
                    'setting-update',
                    array(
                        'type' => 'userInfo',
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

    public function changePassword() {
        if(isset($_POST["oldPass"]) && isset($_POST["newPass"])) {
            $oldPass = $_POST["oldPass"];
            $newPass = $_POST["newPass"];
            if($oldPass != $_SESSION["UserInfo"][0]["Password"]) {
                echo 'oldPassError';
            } else {
                if($this->settingModel->changePassword($newPass)) {
                    echo 'success';
                } else {
                    echo 'fail';
                }
            }
            exit();
        } else {
            $this->view('errors.404');
        }
    }
}