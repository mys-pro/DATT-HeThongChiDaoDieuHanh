<?php
$route['default_controller'] = 'task';

$route['thong-ke'] = 'task/statistical';
$route['thong-ke/(.+)'] = 'task/statistical/$1';
$route['bao-cao'] = 'task/report';
$route['bao-cao/(.+)'] = 'task/report/$1';

