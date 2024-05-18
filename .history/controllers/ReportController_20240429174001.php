<?php

class ReportController extends BaseController{
    public function index() {
        $this->view('frontend.reports.show');
    }

    public function show() {
        echo __METHOD__;
    }
}

?>