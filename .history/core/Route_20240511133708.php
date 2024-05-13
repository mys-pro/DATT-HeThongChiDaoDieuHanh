<?php
$route['default_controller'] = 'login';

$route['dang-nhap'] = 'login/login';
$route['quen-mat-khau'] = 'login/forgot';
$route['ma-xac-nhan'] = 'login/verify';
$route['doi-mat-khau'] = 'login/changePassword';

$route['thong-ke'] = 'task/statistical';
$route['bao-cao'] = 'task/report';
$route['cong-viec'] = 'task/task';

$route['quan-tri-he-thong'] = 'admin/departments';
$route['phong-ban'] = 'admin/departments';
