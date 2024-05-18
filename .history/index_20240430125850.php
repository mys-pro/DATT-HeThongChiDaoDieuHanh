<?php
session_start();

require './Core/App.php';
require './Helper/Common.php';
require './Controllers/BaseController.php';

$app = new App();

// $controllerName = ucfirst((strtolower($app->getController())) . 'Controller' );
// // $actionName = $_REQUEST['action'] ?? 'task';

// require "./Controllers/${controllerName}.php";
// // $controllerObject = new $controllerName;
// // $controllerObject->$actionName();
