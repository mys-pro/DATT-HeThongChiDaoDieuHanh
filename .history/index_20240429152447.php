<?php

$controllerName = ucfirst((strtolower($_REQUEST['controller'] ?? 'Task')) . 'Controller');
$actionName = $_REQUEST['action'] ?? 'index';

require "./controllers/${controllerName}.php";
