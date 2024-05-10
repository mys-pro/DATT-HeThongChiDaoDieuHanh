<?php
require './Helper/functions.php';
require './Controllers/BaseController.php';

$controllerName = ucfirst((strtolower($_REQUEST['controller'] ?? 'Task')) . 'Controller' );
$actionName = $_REQUEST['action'] ?? 'task';

require "./Controllers/${controllerName}.php";
$controllerObject = new $controllerName;
$controllerObject->$actionName();