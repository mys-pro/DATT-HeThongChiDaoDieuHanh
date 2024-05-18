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
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $max)];
        }
        return $randomString;
    }

    protected function countSecond($dateTime)
    {
        $now = date("Y-m-d H:i:s");

        $timestamp_now = strtotime($now);
        $timestamp_dateTime = strtotime($dateTime);

        // Tính số giây chênh lệch
        $interval = $timestamp_now - $timestamp_dateTime;

        return $interval; // Trả về số giây chênh lệch
    }
}