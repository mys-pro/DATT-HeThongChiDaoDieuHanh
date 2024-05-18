<?php
class App {
    private $__controller, $__action, $__params;
    public function __construct() {
        $this->__controller = 'task';
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
    }
}