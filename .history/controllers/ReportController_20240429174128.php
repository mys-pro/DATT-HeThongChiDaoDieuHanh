<?php

class ReportController{
    public function index() {
        $this->view('frontend.reports.show');
    }

    public function show() {
        echo __METHOD__;
    }
}

?>