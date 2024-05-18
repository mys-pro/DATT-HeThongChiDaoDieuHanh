<?php
class BaseController {
    protected function view($viewPath) {
        die($viewPath);
        require ($viewPath);
    }
}