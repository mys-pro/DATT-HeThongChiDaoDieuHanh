<?php
class BaseController {
    const VIEW_FOLDER_NAME = 'Views';

    protected function view($viewPath, array $data = []) {
        require self::VIEW_FOLDER_NAME . '/' . str_replace('.', '/', $viewPath) . '.php';
    }
}