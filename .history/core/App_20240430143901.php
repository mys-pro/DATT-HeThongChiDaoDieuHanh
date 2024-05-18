<?php
class App {
    private $controller, $action, $params, $route;
    public function __construct() {
        global $route;
        $this->route = $route;
        if(!empty($route['default_controller'])) {
            $this->controller = $route['default_controller'];
        }
        $this->action = 'task';
        $this->params = [];
        
        $this->handleUrl();
    }

    public function getUrl() {
        echo '<pre>';
        print_r($route);
        echo '</pre>';
        die;
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
            $this->controller = ucfirst($urlArr[0]).'Controller';
        } else {
            $this->controller = ucfirst($this->controller).'Controller';
        }

        $fileControllers = 'Controllers/'.($this->controller).'.php';
        if(file_exists($fileControllers)) {
            require_once $fileControllers;

            if(class_exists($this->controller)) {
                $this->controller = new $this->controller();
                unset($urlArr[0]);
            } else {
                $this->loadError();
            }
        } else {
            $this->loadError();
        }

        if(!empty($urlArr[1])) {
            $this->action = $urlArr[1];
            unset($urlArr[1]);
        }

        $this->params = array_values($urlArr);

        if(method_exists($this->controller, $this->action)) {
            call_user_func_array([$this->controller, $this->action], $this->params);
        } else {
            $this->loadError();
        }
    }

    public function loadError($name='404') {
        view('errors.'.$name);
    }
}