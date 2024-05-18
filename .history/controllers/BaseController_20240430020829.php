<?php
class BaseController {
    const VIEW_FOLDER_NAME = 'Views';

    protected function view($viewPath, array $data = []) {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        echo '<pre>';
        print_r($pageTile);
        echo '</pre>';
        die;
        require (self::VIEW_FOLDER_NAME . '/' . str_replace('.', '/', $viewPath) . '.php');
    }
}