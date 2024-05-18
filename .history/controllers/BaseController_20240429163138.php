<?php

class BaseController {
    const VIEW_FOLDER_NAME = "Views";
    protected function view($viewPath) {
        $viewPath = self::VIEW_FOLDER_NAME . '/' . str_replace('.', '/', $viewPath) . '.php';
        require ( $viewPath );
    }
}