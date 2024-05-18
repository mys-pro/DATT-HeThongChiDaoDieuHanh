<?php
$controllerName = ucfirst(($_REQUEST['controller'] ?? 'task') . 'Controller');

require "./Controllers/${controllerName}.php";