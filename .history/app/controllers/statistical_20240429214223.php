<?php
class Statistical extends Controller {
    public $model;
    public function __construct() {
        $this->model = $this->model('StatisticalModel');
    }
    public function index() {
        $data = $this->model->getList();

        //Render
        $this->render('Statistical/list');
    }
}