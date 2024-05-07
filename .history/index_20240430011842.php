<?php
require_once 'Helper/functions.php';

$controllerName = ucfirst((strtolower($_REQUEST['controller']) ?? 'Task') . 'Controller' );
echo $controllerName;
die();
$actionName = $_REQUEST['action'] ?? 'index';

require "./Controllers/${controllerName}.php";
$controllerObject = new $controllerName;
$controllerObject->$actionName();
