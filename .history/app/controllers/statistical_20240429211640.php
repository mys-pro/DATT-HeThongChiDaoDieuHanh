<?php
class Statistical {
    public $model;
    public function __construct() {
        require_once _DIR_ROOT.'/app/models/StatisticalModel.php';
        $this->model = new Statistical();
    }
    public function index() {
        
    }
}