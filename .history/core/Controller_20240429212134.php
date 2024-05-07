<?php
class Controller {
    public function model($model) {
        require_once _DIR_ROOT.'/app/models/StatisticalModel.php';
        $model = new StatisticalModel();
    }
}