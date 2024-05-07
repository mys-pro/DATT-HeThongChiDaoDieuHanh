<?php
class TaskController extends BaseController{
    public function statistical() {
        $this->view('statistical.show', [
            'pageTitle' => 'Thống kê',
        ]);
    }

    public function report() {
        $this->view('reports.show');
    }

    public function task() {
        echo __METHOD__;
    }

    public function approval() {
        echo __METHOD__;
    }
}