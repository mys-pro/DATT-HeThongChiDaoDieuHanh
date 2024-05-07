<?php

$controllerName = ucfirst((strtolower($_REQUEST['controller'] ?? 'Task')) . 'Controller');

require "./controllers/${controllerName}.php";
?>