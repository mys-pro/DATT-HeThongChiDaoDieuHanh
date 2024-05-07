<?php
class App {
    private $controller, $action, $params;
    public function __construct() {
        $this->controller = 'task';
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
            $this->controller = ucfirst($urlArr[0]);
            $fileControllers = 'Controllers/'.($this->controller).'Controller.php';
            if(file_exists($fileControllers)) {
                require_once $fileControllers;
            } else {
                echo 'lỗi';
            }
        }

        if(!empty($urlArr[1])) {
            $this->action = $urlArr[1];
        }
    }
}