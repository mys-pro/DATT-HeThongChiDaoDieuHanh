<?php
$controllerName = ucfirst(($_REQUEST['controller'] ?? 'Welcome') . 'Controller');

require "./Controllers/${controllerName}.php";