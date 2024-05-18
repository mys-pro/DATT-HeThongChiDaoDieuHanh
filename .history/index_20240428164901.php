<?php
$controllerName = ucfirst((strtolower($_REQUEST['controller']) ?? 'task') . 'Controller');
$actionName = $_REQUEST['action'] ?? 'index';

require "./Controllers/${controllerName}.php";