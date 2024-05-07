<?php
class Controller {
    public function model($model) {
        require_once _DIR_ROOT.'/app/models/'.$model.'.php';
        $model = new $model();
        return $model;
    }
}