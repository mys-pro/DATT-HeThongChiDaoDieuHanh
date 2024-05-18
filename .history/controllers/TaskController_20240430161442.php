<?php
class TaskController extends BaseController{
    public function statistical() {
        $this->view('statistical.show', [
            'pageTitle' => 'Thống kê',
            'active' => __FUNCTION__,
        ]);
    }

    public function report() {
        $this->view('reports.show', [
            'pageTitle' => 'Báo cáo',
            'active' =>  __FUNCTION__,
        ]);
    }

    public function task() {
        $this->loadModel('StatisticalModel');
        echo __METHOD__;
    }

    public function approval() {
        echo __METHOD__;
    }
}