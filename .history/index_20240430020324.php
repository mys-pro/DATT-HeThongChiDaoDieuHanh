<?php
require './Controllers/BaseController.php';
require './Helper/functions.php';

$controllerName = ucfirst((strtolower($_REQUEST['controller'] ?? 'Task')) . 'Controller' );
$actionName = $_REQUEST['action'] ?? 'task';

require "./Controllers/${controllerName}.php";
$controllerObject = new $controllerName;
$controllerObject->$actionName();
