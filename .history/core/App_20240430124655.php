<?php
class App {
    private $controler, $action, $params;
    public function __construct() {
        $this->controler = 'task';
        $this->action = 'task';
        $this->params = [];
        $url = $this->getUrl();
        echo $url;
    }

    public function getUrl() {
        if(!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = '/';
        }
        return $url;
    }
}