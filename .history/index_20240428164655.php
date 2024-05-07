<?php
$controllerName = ucfirst((strtolower($_REQUEST['controller']) ?? 'task') . 'Controller');

require "./Controllers/${controllerName}.php";