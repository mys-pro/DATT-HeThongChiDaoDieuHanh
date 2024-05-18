<?php

class BaseController {
    protected function view($viewPath) {
        str_replace('.', '/', $viewPath);
        require ($viewPath);
    }
}