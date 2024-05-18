<?php
class Statistical {
    public $model;
    public function __construct() {
        require_once _DIR_ROOT.'/app/models/StatisticalModel.php';
        $this->model = new StatisticalModel();
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