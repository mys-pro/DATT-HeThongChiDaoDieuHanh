<?php

class StatisticalController extends BaseController{
    public function index() {
        return view("frontend.statistical.index");
    }

    public function show() {
        echo __METHOD__;
    }
}