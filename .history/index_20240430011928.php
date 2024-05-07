<?php
require_once 'Helper/functions.php';

$controllerName = ucfirst((strtolower($_REQUEST['controller']) ?? 'Task') . 'Controller' );
echo $_REQUEST['controller'] ?? 'Task';
die();
$actionName = $_REQUEST['action'] ?? 'index';

require "./Controllers/${controllerName}.php";
$controllerObject = new $controllerName;
$controllerObject->$actionName();
