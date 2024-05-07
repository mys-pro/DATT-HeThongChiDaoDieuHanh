<?php
class Statistical extends Controller {
    public $model;
    public function __construct() {
        $this->$model = $this->model('StatisticalModel');
    }
    public function index() {
        $data = $this->model->getList();
        echo '<pre>';
        print_r($data);
        echo '</pre>';

        $detail = $this->model->getDetail(0);
        echo '<pre>';
        print_r($detail);
        echo '</pre>';
    }
}