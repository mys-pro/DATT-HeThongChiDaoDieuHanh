<?php
class BaseController {
    protected function view($viewPath) {
        require ($viewPath);
    }
}