<?php
require_once 'Helper/functions.php';

$controllerName = ucfirst((strtolower($_REQUEST['controller']) ?? 'Task') . 'Controller' );
$actionName = $_REQUEST['action'] ?? 'index';

require "./Controllers/${controllerName}.php";
