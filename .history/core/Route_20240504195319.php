<?php
$route['default_controller'] = 'login';

$route['dang-nhap'] = 'login/login';
$route['quen-mat-khau'] = 'login/forgot';
$route['ma-xac-nha'] = 'login/verify';

$route['ac/thong-ke'] = 'task/statistical';
$route['ac/bao-cao'] = 'task/report';
$route['ac/cong-viec'] = 'task/task';

$route['kb/quan-tri-he-thong'] = 'admin/departments';
$route['kb/phong-ban'] = 'admin/departments';