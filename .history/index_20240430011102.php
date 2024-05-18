<?php
require_once 'Helper/functions.php';

$controllerName = ucfirst((strtolower($_REQUEST['controller'])?? 'Task') . 'Controller' );
