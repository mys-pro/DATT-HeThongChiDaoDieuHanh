<?php
class App {
    private $controler, $action, $params;
    public function __construct() {
        $this->controler = 'task';
        $this->action = 'task';
        $this->params = [];
        
        $this->handleUrl();
    }

    public function getUrl() {
        if(!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = '/';
        }
        return $url;
    }

    public function handleUrl() {
        $url = $this->getUrl();
        $urlArr = array_filter(explode('/', $url));
        $urlArr = array_values($urlArr);

        if(!empty($urlArr[0])) {
            $this->controler = $urlArr[0];
        }
    }
}