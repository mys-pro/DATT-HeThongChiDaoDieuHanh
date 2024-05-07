<?php

class BaseController {
    protected function view($path) {
        str_replace('.', '/', $path);
        require ($path);
    }
}