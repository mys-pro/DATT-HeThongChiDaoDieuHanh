<?php
class App {
    private $__controller, $__action, $__params;
    public function __construct() {
        $this->__controller = 'Task';
        $this->__action = 'index';
        $this->__params = [];

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
            $this->__controller = ucfirst($urlArr[0]);
            if(file_exists('app/controllers/'.($this->__controller).'.php')) {
                require_once 'controllers/'.($this->__controller).'.php';
                $this->__controller = new $this->__controller();
            } else {
                
            }
        }
    }
}