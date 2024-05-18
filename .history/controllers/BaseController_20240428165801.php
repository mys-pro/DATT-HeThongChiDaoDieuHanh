<?php

class BaseController {
    protected function view($path) {
        require ($path);
    }
}