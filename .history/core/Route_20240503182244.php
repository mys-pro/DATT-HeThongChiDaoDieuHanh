<?php
echo getWebRoot();
die;

$route['default_controller'] = 'user';

$route['dang-nhap'] = 'user/login';
$route['ac/thong-ke'] = 'task/statistical';
$route['ac/bao-cao'] = 'task/report';
$route['ac/cong-viec'] = 'task/task';

$route['kb/quan-tri-he-thong'] = 'admin/departments';
$route['kb/phong-ban'] = 'admin/departments';
