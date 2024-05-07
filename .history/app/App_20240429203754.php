<?php
class App {
    public function __construct() {
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