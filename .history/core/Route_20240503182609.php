<?php
$route['default_controller'] = 'user';

$route['/dang-nhap'] = substr(getWebRoot(), strrpos(getWebRoot(), "/") + 1).'/user/login';
$route['ac/thong-ke'] = 'task/statistical';
$route['ac/bao-cao'] = 'task/report';
$route['ac/cong-viec'] = 'task/task';

$route['kb/quan-tri-he-thong'] = 'admin/departments';
$route['kb/phong-ban'] = 'admin/departments';
