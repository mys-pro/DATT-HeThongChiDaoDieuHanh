<?php
class BaseController
{
    const VIEW_FOLDER_NAME = 'Views';
    const MODEL_FOLDER_NAME = 'Models';

    protected function view($viewPath, array $data = [])
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        require(self::VIEW_FOLDER_NAME . '/' . str_replace('.', '/', $viewPath) . '.php');
    }

    protected function loadModel($modelPath)
    {
        require(self::MODEL_FOLDER_NAME . '/' . $modelPath . '.php');
    }

    protected function generateCode($length = 6)
    {
        // Gọi phương thức từ Model để tạo mã xác nhận
        $verificationModel = new VerificationModel();
        $verificationCode = $verificationModel->generateRandomString();

        // Đưa mã xác nhận vào View để hiển thị cho người dùng
        include 'verification_view.php';
    }
}
