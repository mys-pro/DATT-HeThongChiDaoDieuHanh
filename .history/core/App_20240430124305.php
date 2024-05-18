<?php
class App {
    public function __construct() {
        echo '13131';
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