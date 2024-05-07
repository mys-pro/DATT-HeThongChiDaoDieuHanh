<?php
session_start();

require './Core/App.php';
require './Helper/Common.php';
require './Controllers/BaseController.php';



// $controllerName = ucfirst((strtolower($_REQUEST['controller'] ?? 'Task')) . 'Controller' );
// $actionName = $_REQUEST['action'] ?? 'task';

// require "./Controllers/${controllerName}.php";
// $controllerObject = new $controllerName;
// $controllerObject->$actionName();
