<?php
session_start();

require './Helper/Common.php';
// require './Controllers/BaseController.php';
// require './Core/App.php';

// $app = new App();


$controllerName = ucfirst((strtolower($_REQUEST['controller'] ?? 'Task')) . 'Controller' );
$actionName = $_REQUEST['action'] ?? 'task';

require "./Controllers/${controllerName}.php";
$controllerObject = new $controllerName;
$controllerObject->$actionName();
