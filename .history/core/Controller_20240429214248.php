<?php
class Controller {
    public function model($model) {
        if(file_exists(_DIR_ROOT.'/app/models/'.$model.'.php')) {
            require_once _DIR_ROOT.'/app/models/'.$model.'.php';
            if(class_exists($model)) {
                $model = new $model();
                return $model;
            }
        }
        return false;
    }

    public function render($view) {
        if(file_exists(_DIR_ROOT.'/app/models/'.$view.'.php')) {
        }
    }
}