<?php

class StatisticalController extends BaseController{
    public function index() {
        return this->view("frontend.statistical.index");
    }

    public function show() {
        echo __METHOD__;
    }
}