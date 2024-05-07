<?php
class BaseController {
    const VIEW_FOLDER_NAME = 'Views';

    protected function view($viewPath) {
        die($viewPath);
        require ($viewPath);
    }
}