<?php
class TaskController extends BaseController{
    public function statistical() {
        $this->view('statistical.show');
    }

    public function report() {
        echo __METHOD__;
    }

    public function task() {
        echo __METHOD__;
    }

    public function approval() {
        echo __METHOD__;
    }
}