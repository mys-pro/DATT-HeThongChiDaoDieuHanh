<?php

class BaseController {
    const VIEW_FOLDER_NAME = "views";
    protected function view($viewPath) {
        $viewPath = self::VIEW_FOLDER_NAME . '/' . str_replace('.', '/', $viewPath) . '.php';
        die ($viewPath);
        return require ($viewPath);
    }
}