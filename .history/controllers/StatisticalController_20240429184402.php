<?php

class StatisticalController extends BaseController{
    public function index() {
        $this->view("frontend.statisticals.show");
    }

    public function show() {
        echo __METHOD__;
    }
}