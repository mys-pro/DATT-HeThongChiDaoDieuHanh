<?php
class TaskController extends BaseController{
    public function statistical() {
        $this->view('statistical.show', [
            'pageTitle' => 'Thống kê',
            'active' => 'statistical',
        ]);
    }

    public function report() {
        $this->view('reports.show', [
            'pageTitle' => 'Báo cáo',
            'active' => 'report',
        ]);
    }

    public function task() {
        echo __METHOD__;
    }

    public function approval() {
        echo __METHOD__;
    }
}